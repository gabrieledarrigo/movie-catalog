<?php
declare(strict_types=1);

namespace Tests\Darrigo\MovieCatalog\Persistence\Storage;

use \PDO;
use \PDOStatement;
use PHPUnit\Framework\TestCase;
use Darrigo\MovieCatalog\Persistence\Adapter\DBAdapter;

/**
 * Class DBAdapterTest
 * @package Tests\Darrigo\MovieCatalog\Persistence\Adapter
 */
final class DBAdapterTest extends TestCase
{
    /**
     * @var PDO|\PHPUnit_Framework_MockObject_MockObject
     */
    private $connection;

    /**
     * @var PDOStatement|\PHPUnit_Framework_MockObject_MockObject
     */
    private $statement;

    public function setUp(): void
    {
        parent::setUp();

        $this->connection = $this->getMockBuilder(PDO::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->statement = $this->getMockBuilder(PDOStatement::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testItShouldExecuteAPreparedStatementAgainstTheDatabaseFetchingASingleObject()
    {
        $statement = 'SELECT * FROM movies WHERE id = :id';
        $parameters = [':id' => 15];

        $adapter = new DBAdapter($this->connection);

        $this->connection->expects($this->once())
            ->method('prepare')
            ->with($statement)
            ->willReturn($this->statement);

        $this->statement->expects($this->once())
            ->method('execute')
            ->with($parameters);

        $this->statement->expects($this->once())
            ->method('fetch')
            ->willReturn([]);

        $adapter->fetch($statement, $parameters);
    }

    public function testItShouldExecuteAPreparedStatementAgainstTheDatabaseFetchingAnArrayOfObject()
    {
        $statement = 'SELECT * FROM movies';
        $adapter = new DBAdapter($this->connection);

        $this->connection->expects($this->once())
            ->method('prepare')
            ->with($statement)
            ->willReturn($this->statement);

        $this->statement->expects($this->once())
            ->method('execute')
            ->with([]);

        $this->statement->expects($this->once())
            ->method('fetchAll')
            ->willReturn([]);

        $adapter->fetchAll($statement);
    }
}