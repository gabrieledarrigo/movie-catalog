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
    /**
     * @param int $id
     * @return Option
     */
    public function getMovie(int $id): Option;

    /**
     * @param int $page
     * @return Option
     */
    public function getMovies(int $page): Option;

    /**
     * @param int $id
     * @return Option
     */
    public function getGenre(int $id): Option;

    /**
     * @return Option
     */
    public function getGenres(): Option;
}
