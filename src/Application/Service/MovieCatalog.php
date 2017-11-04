<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Application\Service;

use Darrigo\MovieCatalog\Domain\Exception\NoDomainModelException;
use Darrigo\MovieCatalog\Domain\Repository\GenresRepository;
use Darrigo\MovieCatalog\Domain\Repository\MoviesRepository;
use PhpOption\None;
use PhpOption\Option;
use PhpOption\Some;

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

    /**
     * @param int $id
     * @return Option
     */
    public function getMovie(int $id): Option
    {
        try {
            return new Some($this->movieRepository->get($id));
        } catch (NoDomainModelException $e) {
            return None::create();
        }
    }

    /**
     * @return Option
     */
    public function getMovies(): Option
    {
        return new Some($this->movieRepository->getAll());
    }

    /**
     * @param int $id
     * @return Option
     */
    public function getGenre(int $id): Option
    {
        try {
            return new Some($this->genresRepository->get($id));
        } catch(NoDomainModelException $e) {
            return None::create();
        }
    }

    /**
     * @return Option
     */
    public function getGenres(): Option
    {
        return new Some($this->genresRepository->getAll());
    }
}