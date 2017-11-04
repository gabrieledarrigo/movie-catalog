<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Domain\Repository;

use Darrigo\MovieCatalog\Domain\Exception\NoDomainModelException;
use Darrigo\MovieCatalog\Domain\Model\Movie;
use Darrigo\MovieCatalog\Persistence\Exception\NoResultException;
use Darrigo\MovieCatalog\Persistence\Mapper\MovieMapper;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Movies
 * @package Darrigo\MovieCatalog\MoviesTest
 */
class Movies implements MoviesRepository
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
     * @throws NoDomainModelException
     */
    public function get(int $id): Movie
    {
        try {
            return $this->movieMapper->fetch($id);
        } catch(NoResultException $e) {
            throw new NoDomainModelException("No Movie with id $id can be found");
        }
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
