<?php
declare(strict_types = 1);

namespace Tests\Darrigo\MovieCatalog\Container;

use Darrigo\MovieCatalog\Container\Container;
use Darrigo\MovieCatalog\Container\ContainerInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class GenreTest
 * @package Tests\Darrigo\WeeklyOffers\Model
 * @author darrigo.g@gmail.com
 */
final class ContainerTest extends TestCase
{
    /**
     * @var ContainerInterface $container
     */
    private $container;

    protected function setUp(): void
    {
        parent::setUp();
        $this->container = new Container();
    }

    public function testItCanSetAndGetAnEntry(): void
    {
        $entry = new \ArrayObject();
        $this->container->set('a.service', $entry);

        $this->assertSame($this->container->get('a.service'), $entry);
    }

    /**
     * @expectedException \Darrigo\MovieCatalog\Container\Exception\NotFoundException
     * @expectedExceptionMessage No entry with id 'a.service' found
     */
    public function testItThrowANotFoundExceptionOnNotExistentEntry(): void
    {
        $this->container->get('a.service');
    }

    public function testItShouldKnowIfItHasAnEntry(): void
    {
        $entry = new \ArrayObject();
        $this->container->set('a.service', $entry);

        $this->assertTrue($this->container->has('a.service'));
        $this->assertFalse($this->container->has('a.service.not.present'));
    }
}