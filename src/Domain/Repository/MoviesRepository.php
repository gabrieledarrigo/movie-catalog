<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Domain\Repository;

use Darrigo\MovieCatalog\Domain\Model\Movie;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface MovieRepository
 * @package Darrigo\MovieCatalog\Domain\Repository
 */
interface MoviesRepository
{
    /**
     * @param int $id
     * @return Movie
     */
    public function get(int $id): Movie;

    /**
     * @return ArrayCollection
     */
    public function getAll(): ArrayCollection;

    /**
     * @param int $offset
     * @param int $perPage
     * @return ArrayCollection
     */
    public function getInRange(int $offset, int $perPage): ArrayCollection;

    /**
     * @param int $id
     * @return bool
     */
    public function has(int $id): bool;
}
