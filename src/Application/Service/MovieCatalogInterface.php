<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Application\Service;

use Darrigo\MovieCatalog\Domain\Model\Genre;
use Darrigo\MovieCatalog\Domain\Model\Movie;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface MovieCatalogInterface
 * @package Darrigo\MovieCatalog\Application\Service
 */
interface MovieCatalogInterface
{
    public function getMovie(int $id): Movie;

    public function getMovies(): ArrayCollection;

    public function getGenre(int $id): Genre;

    public function getGenres(): ArrayCollection;
}