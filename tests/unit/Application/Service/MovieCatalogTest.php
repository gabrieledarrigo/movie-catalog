<?php
declare(strict_types=1);

namespace Tests\Darrigo\MovieCatalog\Application;

use Darrigo\MovieCatalog\Application\Service\MovieCatalog;
use Darrigo\MovieCatalog\Application\Service\Pagination;
use Darrigo\MovieCatalog\Domain\Exception\NoDomainModelException;
use Darrigo\MovieCatalog\Domain\Model\Genre;
use Darrigo\MovieCatalog\Domain\Model\Movie;
use Darrigo\MovieCatalog\Domain\Repository\GenresRepository;
use Darrigo\MovieCatalog\Domain\Repository\MoviesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use PhpOption\None;
use PHPUnit\Framework\TestCase;

/**
 * Class MovieCatalogTest
 * @package Tests\Darrigo\MovieCatalog\Application
 */
final class MovieCatalogTest extends TestCase
{
    /**
     * @var ArrayCollection $movies
     */
    private $movies;

    /**
     * @var ArrayCollection $genres
     */
    private $genres;

    /**
     * @var MoviesRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    private $moviesRepository;

    /**
     * @var Pagination|\PHPUnit_Framework_MockObject_MockObject
     */
    private $pagination;

    /**
     * @var GenresRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    private $genresRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->moviesRepository = $this->getMockForAbstractClass(MoviesRepository::class);
        $this->genresRepository = $this->getMockForAbstractClass(GenresRepository::class);
        $this->pagination = $this->getMockBuilder(Pagination::class)->getMock();
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
        $this->genres = new ArrayCollection([
            new Genre(12, 'Adventure'),
            new Genre(18, 'Drama'),
            new Genre(27, 'Horror'),
            new Genre(35, 'Comedy'),
            new Genre(37, 'Western'),
        ]);
    }

    public function testItShouldReturnAnOptionFilledWithASpecificMovie(): void
    {
        $id = 15;
        $this->moviesRepository->expects($this->once())
            ->method('get')
            ->with($id)
            ->willReturn($this->movies->first());

        $movieCatalog = new MovieCatalog($this->moviesRepository, $this->genresRepository, $this->pagination);
        $result = $movieCatalog->getMovie($id);

        $this->assertFalse($result->isEmpty());
        $this->assertEquals($this->movies->first(), $result->get());
    }

    public function testItShouldReturnAnEmptyOptionIfNoMovieCanBeRetrievedFromTheRepositoryLayer(): void
    {
        $id = 172;
        $this->moviesRepository->expects($this->once())
            ->method('get')
            ->with($id)
            ->willThrowException(new NoDomainModelException());

        $movieCatalog = new MovieCatalog($this->moviesRepository, $this->genresRepository, $this->pagination);
        $result = $movieCatalog->getMovie($id);

        $this->assertTrue($result->isEmpty());
        $this->assertSame(None::create(), $result);
    }

    public function testItShouldReturnAnOptionWithACollectionOfPaginatedMovies(): void
    {
        $page = 1;
        $offset = 10;

        $this->pagination->expects($this->once())
            ->method('offset')
            ->with($page)
            ->willReturn($offset);

        $this->moviesRepository->expects($this->once())
            ->method('getInRange')
            ->with($offset, Pagination::PER_PAGE)
            ->willReturn($this->movies);

        $movieCatalog = new MovieCatalog($this->moviesRepository, $this->genresRepository, $this->pagination);
        $result = $movieCatalog->getMovies($page);

        $this->assertFalse($result->isEmpty());
        $this->assertEquals($this->movies, $result->get());
    }

    public function testItShouldReturnAnOptionFilledWithASpecificGenre(): void
    {
        $id = 18;
        $this->genresRepository->expects($this->once())
            ->method('get')
            ->with($id)
            ->willReturn($this->genres->first());

        $movieCatalog = new MovieCatalog($this->moviesRepository, $this->genresRepository, $this->pagination);
        $result = $movieCatalog->getGenre($id);

        $this->assertFalse($result->isEmpty());
        $this->assertEquals($this->genres->first(), $result->get());
    }

    public function testItShouldReturnAnEmptyOptionIfNoGenreCanBeRetrievedFromTheRepositoryLayer(): void
    {
        $id = 1200;
        $this->genresRepository->expects($this->once())
            ->method('get')
            ->with($id)
            ->willThrowException(new NoDomainModelException());

        $movieCatalog = new MovieCatalog($this->moviesRepository, $this->genresRepository, $this->pagination);
        $result = $movieCatalog->getGenre($id);

        $this->assertTrue($result->isEmpty());
        $this->assertSame(None::create(), $result);
    }

    public function testItShouldReturnAnOptionWithACollectionOfGenres(): void
    {
        $this->genresRepository->expects($this->once())
            ->method('getAll')
            ->willReturn($this->genres);

        $movieCatalog = new MovieCatalog($this->moviesRepository, $this->genresRepository, $this->pagination);
        $result = $movieCatalog->getGenres();

        $this->assertFalse($result->isEmpty());
        $this->assertEquals($this->genres, $result->get());
    }
}