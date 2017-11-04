<?php
declare(strict_types=1);

namespace Tests\Darrigo\MovieCatalog\Domain\Repository;

use Darrigo\MovieCatalog\Domain\Model\Genre;
use Darrigo\MovieCatalog\Domain\Model\Movie;
use Darrigo\MovieCatalog\Domain\Repository\Genres;
use Darrigo\MovieCatalog\Persistence\Mapper\GenreMapper;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

/**
 * Class GenresTest
 * @package Tests\Darrigo\MovieCatalog\Domain\Repository
 */
final class GenresTest extends TestCase
{
    /**
     * @var GenreMapper|\PHPUnit_Framework_MockObject_MockObject
     */
    private $genreMapper;

    /**
     * @var Movie[]|ArrayCollection
     */
    private $genres;

    public function setUp(): void
    {
        parent::setUp();

        $this->genres = new ArrayCollection([
            new Genre(12, 'Adventure'),
            new Genre(18, 'Drama'),
            new Genre(27, 'Horror'),
            new Genre(35, 'Comedy'),
            new Genre(37, 'Western'),
        ]);

        $this->genreMapper = $this->getMockBuilder(GenreMapper::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->genreMapper->expects($this->any())
            ->method('fetchAll')
            ->willReturn($this->genres);
    }

    public function testItShouldRetrieveAGenre()
    {
        $id = 12;
        $this->genreMapper->expects($this->once())
            ->method('fetch')
            ->with($id)
            ->willReturn($this->genres->first());

        $repository = new Genres($this->genreMapper);

        /** @var Genre $result */
        $result = $repository->get($id);
        $this->assertInstanceOf(Genre::class, $result);
        $this->assertEquals($this->genres[0], $result);
    }

    public function testItShouldRetrieveACollectionOfGenres()
    {
        $repository = new Genres($this->genreMapper);

        /** @var ArrayCollection $result */
        $result = $repository->getAll();
        $this->assertEquals($this->genres->count(), $result->count());
        $this->assertEquals($this->genres, $result);
    }

    public function testItShouldRetrieveACollectionOfGenresWithSpecificIds()
    {
        $ids = [18, 35, 37];
        $expected = new ArrayCollection([
           $this->genres[1],
           $this->genres[3],
           $this->genres[4],
        ]);
        $repository = new Genres($this->genreMapper);

        $this->genreMapper->expects($this->once())
            ->method('fetchAllWithIds')
            ->with($ids)
            ->willReturn($expected);

        /** @var ArrayCollection $result */
        $result = $repository->getWithIds($ids);
        $this->assertEquals($expected->count(), $result->count());
        $this->assertEquals($expected, $result);
    }
}