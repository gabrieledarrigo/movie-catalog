<?php
declare(strict_types=1);

namespace Tests\Darrigo\MovieCatalog\Application\Controller;

use Darrigo\MovieCatalog\Application\Controller\GenreController;
use Darrigo\MovieCatalog\Application\Service\MovieCatalogInterface;
use Darrigo\MovieCatalog\Domain\Model\Genre;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use PhpOption\None;
use PhpOption\Some;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GenreControllerTest
 * @package Tests\Darrigo\MovieCatalog\Application\Controller
 */
final class GenreControllerTest extends TestCase
{
    /**
     * @var ArrayCollection $genres
     */
    private $genres;

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
        $this->genres = new ArrayCollection([
            new Genre(80, 'Crime'),
            new Genre(12, 'Adventure')
        ]);
    }

    public function testItShouldReturnAResponseContainingAJsonEncodedGenre(): void
    {
        $request = Request::create('/genres');
        $request->attributes->add(['id' => 80]);
        $serialized = (new SerializerBuilder())->build()->serialize($this->genres->first(), 'json');

        $this->movieCatalog->expects($this->once())
            ->method('getGenre')
            ->willReturn(new Some($this->genres->first()));

        $this->serializer->expects($this->once())
            ->method('serialize')
            ->with($this->genres->first(), 'json')
            ->willReturn($serialized);

        $controller = new GenreController($this->movieCatalog, $this->serializer);
        $response = $controller->get($request);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($serialized, $response->getContent());
    }

    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @expectedExceptionMessage Genre with id 2000 cannot be found
     */
    public function testItShouldThrowANotFoundExceptionIfAGenreCannotBeFound(): void
    {
        $request = Request::create('/genres');
        $request->attributes->add(['id' => 2000]);

        $this->movieCatalog->expects($this->once())
            ->method('getGenre')
            ->willReturn(None::create());

        $controller = new GenreController($this->movieCatalog, $this->serializer);
        $controller->get($request);
    }

    public function testItShouldReturnAResponseContainingAJsonEncodedListOfGenres(): void
    {
        $request = Request::create('/genres');
        $serialized = (new SerializerBuilder())->build()->serialize($this->genres, 'json');

        $this->movieCatalog->expects($this->once())
            ->method('getGenres')
            ->willReturn(new Some($this->genres));

        $this->serializer->expects($this->once())
            ->method('serialize')
            ->with($this->genres, 'json')
            ->willReturn($serialized);

        $controller = new GenreController($this->movieCatalog, $this->serializer);
        $response = $controller->getAll($request);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($serialized, $response->getContent());
    }
}
