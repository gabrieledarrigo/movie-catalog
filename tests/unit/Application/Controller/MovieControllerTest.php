<?php
declare(strict_types=1);

namespace Tests\Darrigo\MovieCatalog\Application\Controller;

use Darrigo\MovieCatalog\Application\Controller\MovieController;
use Darrigo\MovieCatalog\Application\Service\MovieCatalogInterface;
use Darrigo\MovieCatalog\Domain\Model\Genre;
use Darrigo\MovieCatalog\Domain\Model\Movie;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use PhpOption\None;
use PhpOption\Some;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MovieControllerTest
 * @package Tests\Darrigo\MovieCatalog\Application\Controller
 */
final class MovieControllerTest extends TestCase
{
    /**
     * @var ArrayCollection $movies
     */
    private $movies;

    /**
     * @var MovieCatalogInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $movieCatalog;

    /**
     * @var SerializerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $serializer;

    public function setUp()
    {
        parent::setUp();
        $this->movieCatalog = $this->getMockForAbstractClass(MovieCatalogInterface::class);
        $this->serializer = $this->getMockForAbstractClass(SerializerInterface::class);
        $this->movies = new ArrayCollection([
            new Movie(
                15,
                4000000,
                new ArrayCollection([new Genre(80, 'Crime')]),
                '',
                'en',
                'Four Rooms',
                'Its Ted the Bellhops first night on the job...',
                22.87623,
                new \DateTimeImmutable('1995-12-09'),
                4300000,
                98,
                'Released',
                'Twelve outrageous guests. Four scandalous...',
                'Four Rooms',
                6.5,
                530
            ),
            new Movie(
                10,
                3000000,
                new ArrayCollection([new Genre(12, 'Adventure')]),
                '',
                'en',
                'Star Wars',
                'In a galaxy far far away...',
                59.87623,
                new \DateTimeImmutable('1995-12-09'),
                12600000,
                98,
                'Released',
                'In a galaxy far far away...',
                'Star Wars',
                9.5,
                956
            )
        ]);
    }

    public function testItShouldReturnAResponseContainingAJsonEncodedMovie(): void
    {
        $request = Request::create('/movies');
        $request->attributes->add(['id' => 15]);
        $serialized = (new SerializerBuilder())->build()->serialize($this->movies->first(), 'json');

        $this->movieCatalog->expects($this->once())
            ->method('getMovie')
            ->willReturn(new Some($this->movies->first()));

        $this->serializer->expects($this->once())
            ->method('serialize')
            ->with($this->movies->first(), 'json')
            ->willReturn($serialized);

        $controller = new MovieController($this->movieCatalog, $this->serializer);
        $response = $controller->get($request);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($serialized, $response->getContent());
    }

    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @expectedExceptionMessage Movie with id 175 cannot be found
     */
    public function testItShouldThrowANotFoundExceptionIfAMovieCannotBeFound(): void
    {
        $request = Request::create('/movies');
        $request->attributes->add(['id' => 175]);

        $this->movieCatalog->expects($this->once())
            ->method('getMovie')
            ->willReturn(None::create());

        $controller = new MovieController($this->movieCatalog, $this->serializer);
        $controller->get($request);
    }

    public function testItShouldReturnAResponseContainingAJsonEncodedListOfMovies(): void
    {
        $request = Request::create('/movies');
        $serialized = (new SerializerBuilder())->build()->serialize($this->movies, 'json');

        $this->movieCatalog->expects($this->once())
            ->method('getMovies')
            ->willReturn(new Some($this->movies));

        $this->serializer->expects($this->once())
            ->method('serialize')
            ->with($this->movies, 'json')
            ->willReturn($serialized);

        $controller = new MovieController($this->movieCatalog, $this->serializer);
        $response = $controller->getAll($request);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($serialized, $response->getContent());
    }
}
