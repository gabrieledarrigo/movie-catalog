<?php
declare(strict_types=1);

namespace Tests\Darrigo\MovieCatalog\Persistence\Storage;

use Darrigo\MovieCatalog\Domain\Model\Genre;
use Darrigo\MovieCatalog\Domain\Model\Movie;
use Darrigo\MovieCatalog\Persistence\Mapper\GenreMapper;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Darrigo\MovieCatalog\Persistence\Mapper\MovieMapper;
use Darrigo\MovieCatalog\Persistence\Adapter\DBAdapter;

/**
 * Class MovieMapper
 * @package Tests\Darrigo\MovieCatalog\Persistence\Mapper
 */
final class MovieMapperTest extends TestCase
{
    /**
     * @var DBAdapter|\PHPUnit_Framework_MockObject_MockObject
     */
    private $adapter;

    /**
     * @var GenreMapper|\PHPUnit_Framework_MockObject_MockObject
     */
    private $genreMapper;

    /**
     * @var array
     */
    private $movie = [
        'id' => 15,
        'budget' => 4000000,
        'genres' => '[80, 35]',
        'homepage' => '',
        'original_language' => 'en',
        'original_title' => 'Four Rooms',
        'overview' => 'Its Ted the Bellhops first night on the job...',
        'popularity' => 22.87623,
        'release_date' => '1995-12-09',
        'revenue' => 4300000,
        'runtime' => 98,
        'status' => 'Released',
        'tagline' => 'Twelve outrageous guests. Four scandalous...',
        'title' => 'Four Rooms',
        'vote_average' => 6.5,
        'vote_count' => 530,
    ];

    /**
     * @var array
     */
    private $genres = [
        [
            'id' => 80,
            'name' => 'Crime'
        ],
        [
            'id' => 35,
            'name' => 'Comedy'
        ]
    ];

    /**
     * @var Genre[]|ArrayCollection
     */
    private $expectedGenres;

    public function setUp(): void
    {
        parent::setUp();

        $this->expectedGenres = new ArrayCollection([
            new Genre($this->genres[0]['id'], $this->genres[0]['name']),
            new Genre($this->genres[1]['id'], $this->genres[1]['name']),
        ]);

        $this->adapter = $this->getMockBuilder(DBAdapter::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->genreMapper = $this->getMockBuilder(GenreMapper::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->genreMapper->expects($this->once())
            ->method('fetchAllWithIds')
            ->with([80, 35])
            ->willReturn($this->expectedGenres);
    }

    public function testItShouldRetrieveAMovieFromTheDatabase()
    {
        $id = 15;
        $movieMapper = new MovieMapper($this->adapter, $this->genreMapper);

        $this->adapter->expects($this->once())
            ->method('fetch')
            ->with('SELECT * FROM movies WHERE id = :id', [':id' => $id])
            ->willReturn($this->movie);

        /** @var Movie $result */
        $result = $movieMapper->fetch($id);
        $this->assertInstanceOf(Movie::class, $result);
        $this->assertEquals($this->movie['id'], $result->getId());
    }

    public function testItShouldRetrieveAnArrayOfMoviesFromTheDatabase()
    {
        $movieMapper = new MovieMapper($this->adapter, $this->genreMapper);

        $this->adapter->expects($this->once())
            ->method('fetchAll')
            ->with('SELECT * FROM movies', [])
            ->willReturn([$this->movie]);

        /** @var ArrayCollection $result */
        $result = $movieMapper->fetchAll();
        $this->assertInstanceOf(ArrayCollection::class, $result);
        $this->assertEquals(1, $result->count());
        $this->assertEquals($this->movie['id'], $result->get(0)->getId());
        $this->assertEquals($this->movie['id'], $result->get(0)->getId());
    }

    public function testItShouldRetrieveAnArrayOfMoviesFromTheDatabaseGivenAnOffsetAndItemsPerPage()
    {
        $offset = 0;
        $perPage = 10;
        $movieMapper = new MovieMapper($this->adapter, $this->genreMapper);

        $this->adapter->expects($this->once())
            ->method('fetchAll')
            ->with('SELECT * FROM movies LIMIT :offset, :per_page', [':offset' => $offset, ':per_page' => $perPage])
            ->willReturn([$this->movie]);

        /** @var ArrayCollection $result */
        $result = $movieMapper->fetchWithOffset($offset, $perPage);
        $this->assertInstanceOf(ArrayCollection::class, $result);
        $this->assertEquals(1, $result->count());
        $this->assertEquals($this->movie['id'], $result->get(0)->getId());
    }
}