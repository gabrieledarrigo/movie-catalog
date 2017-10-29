<?php

namespace Darrigo\MovieCatalog\Persistence\Mapper;

use Darrigo\MovieCatalog\Persistence\Adapter\StorageAdapter;

/**
 * Class MovieMapper
 * @package Darrigo\MovieCatalog\Persistence\Mapper
 */
final class MovieMapper
{
    /**
     * @var StorageAdapter
     */
    private $adapter;

    /**
     * MovieMapper constructor.
     * @param $adapter
     */
    public function __construct(StorageAdapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function fetch(int $id)
    {
        return $this->adapter->fetch('SELECT * FROM movies WHERE id = :id', [':id' => $id]);
    }

    /**
     * @return array
     */
    public function fetchAll(): array
    {
        return $statement = $this->adapter->fetchAll('SELECT * FROM movies');
    }

    /**
     * @param int $offset
     * @param int $perPage
     * @return array
     */
    public function fetchWithOffset(int $offset, int $perPage): array
    {
        return $this->adapter->fetchAll(
            'SELECT * FROM movies LIMIT :offset, :per_page', [
            ':offset' => $offset,
            ':per_page' => $perPage
        ]);
    }
}