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
     * @var Pagination $pagination
     */
    private $pagination;

    /**
     * MovieCatalog constructor.
     * @param MoviesRepository $moviesRepository
     * @param GenresRepository $genreRepository
     * @param PaginationInterface $pagination
     */
    public function __construct(MoviesRepository $moviesRepository, GenresRepository $genreRepository, PaginationInterface $pagination)
    {
        $this->movieRepository = $moviesRepository;
        $this->genresRepository = $genreRepository;
        $this->pagination = $pagination;
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
     * @param int $page
     * @return Option
     */
    public function getMovies(int $page = Pagination::DEFAULT_PAGE): Option
    {
        return new Some($this->movieRepository->getInRange(
            $this->pagination->offset($page),
            Pagination::PER_PAGE
        ));
    }

    /**
     * @param int $id
     * @return Option
     */
    public function getGenre(int $id): Option
    {
        try {
            return new Some($this->genresRepository->get($id));
        } catch (NoDomainModelException $e) {
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