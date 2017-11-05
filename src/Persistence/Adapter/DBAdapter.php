<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Persistence\Adapter;

use \PDO;

/**
 * Class DBAdapter
 * @package Darrigo\MovieCatalog\Persistence\Adapter
 */
class DBAdapter implements StorageAdapter
{
    /**
     * @var PDO
     */
    private $connection;

    /**
     * MySqlStorage constructor.
     * @param PDO $connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
        $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    /**
     * @param string $statement
     * @param array $parameters
     * @return mixed
     */
    public function fetch(string $statement, array $parameters = []): ?array
    {
        $statement = $this->prepare($statement, $parameters);
        return $statement->fetch() ?: null;
    }

    /**
     * @param string $statement
     * @param array $parameters
     * @return array
     */
    public function fetchAll(string $statement, array $parameters = []): array
    {
        $statement = $this->prepare($statement, $parameters);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param string $statement
     * @param array $parameters
     * @return \PDOStatement
     */
    private function prepare(string $statement, array $parameters = []): \PDOStatement
    {
        $statement = $this->connection->prepare($statement);
        $statement->execute($parameters);
        return $statement;
    }
}
