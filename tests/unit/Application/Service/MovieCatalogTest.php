<?php
declare(strict_types=1);

namespace Tests\Darrigo\MovieCatalog\Application;

use Darrigo\MovieCatalog\Application\Service\MovieCatalog;
use Darrigo\MovieCatalog\Domain\Model\Genre;
use Darrigo\MovieCatalog\Domain\Model\Movie;
use Darrigo\MovieCatalog\Domain\Repository\GenresRepository;
use Darrigo\MovieCatalog\Domain\Repository\MoviesRepository;
use Doctrine\Common\Collections\ArrayCollection;
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

    private $genres;

    /**
     * @var MoviesRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    private $moviesRepository;

    /**
     * @var GenresRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    private $genresRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->moviesRepository = $this->getMockForAbstractClass(MoviesRepository::class);
        $this->genresRepository = $this->getMockForAbstractClass(GenresRepository::class);
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

    public function testItShouldReturnAllMovies(): void
    {
        $this->moviesRepository->expects($this->once())
            ->method('getAll')
            ->willReturn($this->movies);

        $movieCatalog = new MovieCatalog($this->moviesRepository, $this->genresRepository);
        $result = $movieCatalog->getMovies();

        $this->assertEquals($this->movies, $result);
    }

    public function testItShouldReturnASpecificMovie(): void
    {
        $id = 15;
        $this->moviesRepository->expects($this->once())
            ->method('get')
            ->with($id)
            ->willReturn($this->movies->first());

        $movieCatalog = new MovieCatalog($this->moviesRepository, $this->genresRepository);
        $result = $movieCatalog->getMovie($id);

        $this->assertEquals($this->movies->first(), $result);
    }
}