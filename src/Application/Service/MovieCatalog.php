<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Application\Service;

use Darrigo\MovieCatalog\Domain\Model\Genre;
use Darrigo\MovieCatalog\Domain\Model\Movie;
use Darrigo\MovieCatalog\Domain\Repository\GenresRepository;
use Darrigo\MovieCatalog\Domain\Repository\MoviesRepository;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class MovieCatalog
 * @package Darrigo\MovieCatalog\Application\Service
 */
class MovieCatalog implements MovieCatalogInterface
{
    /**
     * @var MoviesRepository $movieRepository
     */
    private $movieRepository;

    /**
     * @var GenresRepository $genresRepository
     */
    private $genresRepository;

    /**
     * MovieCatalog constructor.
     * @param MoviesRepository $moviesRepository
     * @param GenresRepository $genreRepository
     */
    public function __construct(MoviesRepository $moviesRepository, GenresRepository $genreRepository)
    {
        $this->movieRepository = $moviesRepository;
        $this->genresRepository = $genreRepository;
    }

    public function getMovie(int $id): Movie
    {
        return $this->movieRepository->get($id);
    }

    public function getMovies(): ArrayCollection
    {
        return $this->movieRepository->getAll();
    }

    public function getGenre(int $id): Genre
    {
        // TODO: Implement getGenre() method.
    }

    public function getGenres(): ArrayCollection
    {
        // TODO: Implement getGenres() method.
    }
}