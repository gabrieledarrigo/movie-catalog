<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Domain\Repository;

use Darrigo\MovieCatalog\Domain\Model\Genre;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface GenresRepository
 * @package Darrigo\MovieCatalog\Domain\Repository
 */
interface GenresRepository
{
    /**
     * @param int $id
     * @return Genre
     */
    public function get(int $id): Genre;

    /**
     * @return ArrayCollection
     */
    public function getAll(): ArrayCollection;

    /**
     * @param int[]|array $ids
     * @return ArrayCollection
     */
    public function getWithIds(array $ids = []): ArrayCollection;
}
