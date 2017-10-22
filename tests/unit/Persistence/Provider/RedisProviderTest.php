<?php
declare(strict_types=1);

namespace Tests\Darrigo\MovieCatalog\Persistence\Provider;

use Darrigo\MovieCatalog\Container\Container;
use Darrigo\MovieCatalog\Container\ContainerInterface;
use Darrigo\MovieCatalog\Persistence\Provider\RedisProvider;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;

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

    public function setUp()
    {
        parent::setUp();
        $this->container = $this->getMockForAbstractClass(ContainerInterface::class);
    }

    public function testItShouldRegisterVariourRedisRelatedDependencies(): void
    {
        $provider = new RedisProvider();
        $provider->register($this->container);

        $this->container->method('set')
            ->with('redis.client');

    }
}