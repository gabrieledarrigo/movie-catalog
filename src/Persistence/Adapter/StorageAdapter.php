<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Persistence\Adapter;

/**
 * Interface StorageAdapter
 * @package Darrigo\MovieCatalog\Persistence\Adapter
 */
interface StorageAdapter
{
    /**
     * @param string $statement
     * @param array $parameters
     * @return mixed
     */
    public function fetch(string $statement, array $parameters = []): array;

    /**
     * @param string $statement
     * @param array $parameters
     * @return array
     */
    public function fetchAll(string $statement, array $parameters = []): array;
}
