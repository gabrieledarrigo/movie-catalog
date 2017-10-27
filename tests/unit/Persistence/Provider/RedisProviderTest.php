<?php
declare(strict_types=1);

namespace Tests\Darrigo\MovieCatalog\Persistence\Provider;

use Darrigo\MovieCatalog\Container\Container;
use Darrigo\MovieCatalog\Container\ContainerInterface;
use Darrigo\MovieCatalog\Persistence\Provider\RedisProvider;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use Predis\Client;

/**
 * Class RedisProviderTest
 * @package Tests\Darrigo\MovieCatalog\Persistence\Provider
 */
final class RedisProviderTest extends TestCase
{
    /**
     * @var Container|PHPUnit_Framework_MockObject_MockObject
     */
    protected $container;

    /**
     * @var Client|PHPUnit_Framework_MockObject_MockObject
     */
    protected $client;

    public function setUp()
    {
        parent::setUp();
        $this->container = $this->getMockForAbstractClass(ContainerInterface::class);
        $this->client = $this->getMockBuilder(Client::class)->getMock();
    }

    public function testItShouldRegisterVariousRedisRelatedDependencies(): void
    {
        $provider = new RedisProvider();

        $this->container->expects($this->once())
            ->method('set')
            ->with('persistence.redis.client');

        $provider->register($this->container);
    }
}