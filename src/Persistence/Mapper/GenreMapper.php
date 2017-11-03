<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Persistence\Mapper;

use Darrigo\MovieCatalog\Domain\Model\Genre;
use Darrigo\MovieCatalog\Persistence\Adapter\StorageAdapter;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class MovieMapper
 * @package Darrigo\MovieCatalog\Persistence\Mapper
 */
class GenreMapper extends AbstractMapper
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
        $data = $this->adapter->fetch('SELECT * FROM genres WHERE id = :id', [':id' => $id]);
        return $this->map($data);
    }

    /**
     * @return ArrayCollection
     */
    public function fetchAll(): ArrayCollection
    {
        $data = $this->adapter->fetchAll('SELECT * FROM genres');
        return $this->mapArray($data);
    }

    /**
     * @param array $ids
     * @return ArrayCollection
     */
    public function fetchAllWithIds(array $ids): ArrayCollection
    {
        $placeholders = str_repeat('?,', count($ids) - 1) . '?';
        $data = $this->adapter->fetchAll("SELECT * FROM genres WHERE id IN($placeholders)", $ids);
        return $this->mapArray($data);
    }

    /**
     * @param array $data
     * @return Genre
     */
    public function map(array $data): Genre
    {
        return new Genre((int) $data['id'], $data['name']);
    }
}
