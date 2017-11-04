<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Domain\Repository;

use Darrigo\MovieCatalog\Domain\Model\Genre;
use Darrigo\MovieCatalog\Persistence\Mapper\GenreMapper;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Genres
 * @package Darrigo\MovieCatalog\Domain\Repository
 */
class Genres implements GenresRepository
{
    /**
     * @var GenreMapper $genreMapper
     */
    private $genreMapper;

    /**
     * Genres constructor.
     * @param GenreMapper $genreMapper
     */
    public function __construct(GenreMapper $genreMapper)
    {
        $this->genreMapper = $genreMapper;
    }

    /**
     * @param int $id
     * @return Genre
     */
    public function get(int $id): Genre
    {
        return $this->genreMapper->fetch($id);
    }

    /**
     * @return ArrayCollection
     */
    public function getAll(): ArrayCollection
    {
        return $this->genreMapper->fetchAll();
    }

    /**
     * @param array $ids
     * @return ArrayCollection
     */
    public function getWithIds(array $ids = []): ArrayCollection
    {
        return $this->genreMapper->fetchAllWithIds($ids);
    }
}