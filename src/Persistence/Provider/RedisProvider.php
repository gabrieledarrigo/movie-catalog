<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Persistence\Provider;

use Darrigo\MovieCatalog\Container\ContainerInterface;
use Predis\Client;

class RedisProvider implements ProviderInterface
{
    public function register(ContainerInterface $container): void
    {
        $container->set('persistence.redis.client', new Client([
            'prefix' => 'movie.catalog',
            'scheme' => 'tcp',
            'host'   => 'redis',
            'port'   => 6379,
        ]));
    }
}