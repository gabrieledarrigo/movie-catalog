<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Domain\Repository;

use Darrigo\MovieCatalog\Domain\Model\Movie;
use Darrigo\MovieCatalog\Persistence\Mapper\MovieMapper;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Movies
 * @package Darrigo\MovieCatalog\MoviesTest
 */
class Movies implements MovieRepository
{
    /**
     * @var MovieMapper $movieMapper
     */
    private $movieMapper;

    /**
     * Movies constructor.
     * @param MovieMapper $movieMapper
     */
    public function __construct(MovieMapper $movieMapper)
    {
        $this->movieMapper = $movieMapper;
    }

    /**
     * @param int $id
     * @return Movie
     */
    public function get(int $id): Movie
    {
        return $this->movieMapper->fetch($id);
    }

    /**
     * @return ArrayCollection
     */
    public function getAll(): ArrayCollection
    {
        return $this->movieMapper->fetchAll();
    }

    /**
     * @param int $offset
     * @param int $perPage
     * @return ArrayCollection
     */
    public function getInRange(int $offset, int $perPage): ArrayCollection
    {
        return $this->movieMapper->fetchWithOffset($offset, $perPage);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function has(int $id): bool
    {
        /*
         * I know, this is a madness from each point of view,
         * But it's just to give the idea that a Repository is a collection of objects : P
         */
        $movies = $this->movieMapper->fetchAll();

        return $movies->exists(function ($i, Movie $movie) use ($id) {
            return $movie->getId() === $id;
        });
    }
}