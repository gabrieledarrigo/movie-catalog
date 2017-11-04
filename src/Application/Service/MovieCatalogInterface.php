<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Application\Service;

use PhpOption\Option;

/**
 * Interface MovieCatalogInterface
 * @package Darrigo\MovieCatalog\Application\Service
 */
interface MovieCatalogInterface
{
    public function getMovie(int $id): Option;

    public function getMovies(): Option;

    public function getGenre(int $id): Option;

    public function getGenres(): Option;
}