<?php
declare(strict_types=1);

namespace Tests\Darrigo\MovieCatalog\Persistence\Storage;

use PHPUnit\Framework\TestCase;
use Darrigo\MovieCatalog\Persistence\Mapper\MovieMapper;
use Darrigo\MovieCatalog\Persistence\Adapter\DBAdapter;

/**
 * Class MovieMapper
 * @package Tests\Darrigo\MovieCatalog\Persistence\Adapter
 */
final class MovieMapperTest extends TestCase
{
    /**
     * @var DBAdapter|\PHPUnit_Framework_MockObject_MockObject
     */
    private $adapter;

    public function setUp(): void
    {
        parent::setUp();

        $this->adapter = $this->getMockBuilder(DBAdapter::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testItShouldRetrieveAMovieFromTheDatabase()
    {
        $id = 15;
        $movie = ['id' => 15, 'title' => 'Star Wars'];
        $movieMapper = new MovieMapper($this->adapter);

        $this->adapter->expects($this->once())
            ->method('fetch')
            ->with('SELECT * FROM movies WHERE id = :id', [':id' => $id])
            ->willReturn($movie);

        $this->assertEquals($movie, $movieMapper->fetch($id));
    }

    public function testItShouldRetrieveAnArrayOfMoviesFromTheDatabase()
    {
        $movies = [['id' => 15, 'title' => 'Star Wars'], ['id' => 16, 'title' => 'The Empire Strikes Back']];
        $movieMapper = new MovieMapper($this->adapter);

        $this->adapter->expects($this->once())
            ->method('fetchAll')
            ->with('SELECT * FROM movies', [])
            ->willReturn($movies);

        $movieMapper->fetchAll();
    }

    public function testItShouldRetrieveAnArrayOfMoviesFromTheDatabaseGivenAnOffsetAndItemsPerPage()
    {
        $offset = 0;
        $perPage = 10;
        $movies = [['id' => 15, 'title' => 'Star Wars'], ['id' => 16, 'title' => 'The Empire Strikes Back']];
        $movieMapper = new MovieMapper($this->adapter);

        $this->adapter->expects($this->once())
            ->method('fetchAll')
            ->with('SELECT * FROM movies LIMIT :offset, :per_page', [':offset' => $offset, ':per_page' => $perPage])
            ->willReturn($movies);

        $movieMapper->fetchWithOffset($offset, $perPage);
    }
}