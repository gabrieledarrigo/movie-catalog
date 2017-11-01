<?php
declare(strict_types=1);

namespace Tests\Darrigo\MovieCatalog\Persistence\Storage;

use Darrigo\MovieCatalog\Domain\Model\Genre;
use Darrigo\MovieCatalog\Persistence\Mapper\GenreMapper;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Darrigo\MovieCatalog\Persistence\Adapter\DBAdapter;

/**
 * Class MovieMapper
 * @package Tests\Darrigo\MovieCatalog\Persistence\Mapper
 */
final class GenreMapperTest extends TestCase
{
    /**
     * @var DBAdapter|\PHPUnit_Framework_MockObject_MockObject
     */
    private $adapter;

    /**
     * @var array
     */
    private $genres = [
        [
            'id' => '12',
            'name' => 'Adventure'
        ],
        [
            'id' => '14',
            'name' => 'Fantasy'
        ],
        [
            'id' => '16',
            'name' => 'Animation'
        ],
        [
            'id' => '18',
            'name' => 'Drama'
        ],
        [
            'id' => '27',
            'name' => 'Horror'
        ],
        [
            'id' => '28',
            'name' => 'Action'
        ],
    ];

    /**
     * @var array
     */
    private $expectedGenresNames = ['Adventure', 'Animation', 'Action', 'Horror', 'Drama', 'Fantasy'];

    /**
     * @var array
     */
    private $expectedGenresId = [12, 14, 16, 18, 27, 28];

    public function setUp(): void
    {
        parent::setUp();

        $this->adapter = $this->getMockBuilder(DBAdapter::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testItShouldRetrieveASpecificGenreFromTheDatabase()
    {
        $id = 12;
        $movieMapper = new GenreMapper($this->adapter);

        $this->adapter->expects($this->once())
            ->method('fetch')
            ->with('SELECT * FROM genres WHERE id = :id', [':id' => $id])
            ->willReturn($this->genres[0]);

        /** @var Genre $result */
        $result = $movieMapper->fetch($id);
        $this->assertInstanceOf(Genre::class, $result);
        $this->assertEquals($this->genres[0]['id'], $result->getId());
        $this->assertEquals($this->genres[0]['name'], $result->getName());
    }

    public function testItShouldRetrieveAnArrayOfGenresFromTheDatabase()
    {
        $mapper = new GenreMapper($this->adapter);

        $this->adapter->expects($this->once())
            ->method('fetchAll')
            ->with('SELECT * FROM genres', [])
            ->willReturn($this->genres);

        /** @var ArrayCollection $result */
        $result = $mapper->fetchAll();
        $this->assertGenresCollection($result);
    }

    public function testItShouldRetrieveAnArrayOfGenresWithSpecificIds()
    {
        $mapper = new GenreMapper($this->adapter);

        $this->adapter->expects($this->once())
            ->method('fetchAll')
            ->with('SELECT * FROM genres WHERE id IN(?,?,?,?,?,?)', $this->expectedGenresId)
            ->willReturn($this->genres);

        /** @var ArrayCollection $result */
        $result = $mapper->fetchAllWithIds($this->expectedGenresId);
        $this->assertGenresCollection($result);
    }

    /**
     * @param ArrayCollection $actual
     */
    private function assertGenresCollection(ArrayCollection $actual): void
    {
        $this->assertInstanceOf(ArrayCollection::class, $actual);
        $this->assertEquals(count($this->genres), $actual->count());
        $this->assertContainsOnlyInstancesOf(Genre::class, $actual);

        /** @var Genre $genre */
        foreach ($actual as $genre) {
            $this->assertContains($genre->getId(), $this->expectedGenresId);
            $this->assertContains($genre->getName(), $this->expectedGenresNames);
        }
    }
}