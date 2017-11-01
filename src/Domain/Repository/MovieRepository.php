<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Repository;

use Darrigo\MovieCatalog\Domain\Model\Movie;

/**
 * Interface MovieRepository
 * @package Darrigo\MovieCatalog\Repository
 */
interface MovieRepository
{
    public function find(int $id);
    public function findAll();
    public function save(Movie $Movie);
}