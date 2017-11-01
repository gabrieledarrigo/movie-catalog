<?php
declare(strict_types=1);

namespace Tests\Darrigo\MovieCatalog\Domain\Repository;

use Darrigo\MovieCatalog\Domain\Model\Genre;
use Darrigo\MovieCatalog\Domain\Model\Movie;
use Darrigo\MovieCatalog\Domain\Repository\Movies;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Darrigo\MovieCatalog\Persistence\Mapper\MovieMapper;

/**
 * Class MoviesTest
 * @package Tests\Darrigo\MovieCatalog\Persistence\Mapper
 */
final class MoviesTest extends TestCase
{
    /**
     * @var MovieMapper|\PHPUnit_Framework_MockObject_MockObject
     */
    private $movieMapper;

    /**
     * @var Movie[]|ArrayCollection
     */
    private $movies;

    public function setUp(): void
    {
        parent::setUp();

        $this->movies = new ArrayCollection([
            new Movie(15,
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

        $this->movieMapper = $this->getMockBuilder(MovieMapper::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->movieMapper->expects($this->any())
            ->method('fetchAll')
            ->willReturn($this->movies);
    }

    public function testItShouldRetrieveAMovie()
    {
        $id = 15;
        $this->movieMapper->expects($this->once())
            ->method('fetch')
            ->with($id)
            ->willReturn($this->movies->first());

        $repository = new Movies($this->movieMapper);

        /** @var Movie $result */
        $result = $repository->get($id);
        $this->assertInstanceOf(Movie::class, $result);
        $this->assertEquals($this->movies[0], $result);
    }

    public function testItShouldRetrieveAnACollectionOfMovies()
    {
        $repository = new Movies($this->movieMapper);

        /** @var ArrayCollection $result */
        $result = $repository->getAll();
        $this->assertEquals($this->movies->count(), $result->count());
        $this->assertEquals($this->movies, $result);
    }

    public function testItShouldRetrieveAnACollectionOfMoviesInASpecificRange()
    {
        $offset = 0;
        $perPage = 10;
        $repository = new Movies($this->movieMapper);

        $this->movieMapper->expects($this->once())
            ->method('fetchWithOffset')
            ->with($offset, $perPage)
            ->willReturn($this->movies);

        /** @var ArrayCollection $result */
        $result = $repository->getInRange($offset, $perPage);
        $this->assertEquals($this->movies->count(), $result->count());
        $this->assertEquals($this->movies, $result);
    }

    public function testItShouldKnowIfItHasASpecificMovies()
    {
        $id = 10;
        $repository = new Movies($this->movieMapper);

        $this->assertTrue($repository->has($id));
        $this->assertFalse($repository->has(75));
    }
}