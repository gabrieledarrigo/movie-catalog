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

    public function testItShouldExecuteAPreparedStatementAgainstTheDatabaseFetchingASingleRow(): void
    {
        $result = ['id' => 15, 'title' => 'Star Wars'];
        $statement = 'SELECT * FROM movies WHERE id = :id';
        $parameters = [':id' => 15];
        $this->setupPDOExpectation($statement, $parameters);

        $adapter = new DBAdapter($this->connection);

        $this->statement->expects($this->once())
            ->method('fetch')
            ->willReturn($result);

        $this->assertEquals($result, $adapter->fetch($statement, $parameters));
    }

    public function testItShouldReturnNullIfNoRowCanBeFetchedFromTheDatabase(): void
    {
        $statement = 'SELECT * FROM movies WHERE id = :id';
        $parameters = [':id' => 15];
        $this->setupPDOExpectation($statement, $parameters);

        $adapter = new DBAdapter($this->connection);

        $this->statement->expects($this->once())
            ->method('fetch')
            ->willReturn(false);

        $this->assertEquals(null, $adapter->fetch($statement, $parameters));
    }

    public function testItShouldExecuteAPreparedStatementAgainstTheDatabaseFetchingMultipleRows(): void
    {
        $statement = 'SELECT * FROM movies';
        $this->setupPDOExpectation($statement, []);

        $adapter = new DBAdapter($this->connection);

        $this->statement->expects($this->once())
            ->method('fetchAll')
            ->willReturn([]);

        $adapter->fetchAll($statement);
    }

    /**
     * @param string $statement
     * @param array $parameters
     */
    private function setupPDOExpectation(string $statement, array $parameters): void
    {
        $this->connection->expects($this->once())
            ->method('prepare')
            ->with($statement)
            ->willReturn($this->statement);

        $this->statement->expects($this->once())
            ->method('execute')
            ->with($parameters);
    }
}