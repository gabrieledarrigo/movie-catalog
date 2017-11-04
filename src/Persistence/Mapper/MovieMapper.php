<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Persistence\Mapper;

use Darrigo\MovieCatalog\Domain\Model\Movie;
use Darrigo\MovieCatalog\Persistence\Adapter\StorageAdapter;
use Darrigo\MovieCatalog\Persistence\Exception\NoResultException;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class MovieMapper
 * @package Darrigo\MovieCatalog\Persistence\Mapper
 */
class MovieMapper extends AbstractMapper
{
    /**
     * @var StorageAdapter
     */
    private $adapter;

    /**
     * @var GenreMapper
     */
    private $genreMapper;

    /**
     * MovieMapper constructor.
     * @param StorageAdapter $adapter
     * @param GenreMapper $genreMapper
     */
    public function __construct(StorageAdapter $adapter, GenreMapper $genreMapper)
    {
        $this->adapter = $adapter;
        $this->genreMapper = $genreMapper;
    }

    /**
     * @param int $id
     * @return Movie
     * @throws NoResultException
     */
    public function fetch(int $id)
    {
        $data = $this->adapter->fetch('SELECT * FROM movies WHERE id = :id', [':id' => $id]);

        if ($data === null) {
            throw new NoResultException("No result with id $id can be found");
        }

        return $this->map($data);
    }

    /**
     * @return ArrayCollection
     */
    public function fetchAll(): ArrayCollection
    {
        $data = $this->adapter->fetchAll('SELECT * FROM movies');
        return $this->mapArray($data);
    }

    /**
     * @param int $offset
     * @param int $perPage
     * @return ArrayCollection
     */
    public function fetchWithOffset(int $offset, int $perPage): ArrayCollection
    {
        $data = $this->adapter->fetchAll(
            'SELECT * FROM movies LIMIT :offset, :per_page',
            [
                ':offset' => $offset,
                ':per_page' => $perPage
            ]
        );

        return $this->mapArray($data);
    }

    /**
     * @param array $data
     * @return Movie
     */
    public function map(array $data): Movie
    {
        return new Movie(
            (int)$data['id'],
            (int)$data['budget'],
            $this->genreMapper->fetchAllWithIds(json_decode($data['genres'], true)),
            $data['homepage'],
            $data['original_language'],
            $data['original_title'],
            $data['overview'],
            (float)$data['popularity'],
            new \DateTimeImmutable($data['release_date']),
            $data['revenue'],
            (int)$data['runtime'],
            $data['status'],
            $data['tagline'],
            $data['title'],
            (float)$data['vote_average'],
            (int)$data['vote_count']
        );
    }
}
