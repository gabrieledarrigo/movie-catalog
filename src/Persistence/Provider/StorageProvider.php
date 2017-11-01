<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Persistence\Provider;

use Darrigo\MovieCatalog\Container\ContainerInterface;
use Darrigo\MovieCatalog\Persistence\Adapter\DBAdapter;
use Darrigo\MovieCatalog\Persistence\Mapper\GenreMapper;
use Darrigo\MovieCatalog\Persistence\Mapper\MovieMapper;
use \PDO;

/**
 * Class StorageProvider
 * @package Darrigo\MovieCatalog\Persistence\Provider
 */
class StorageProvider implements ProviderInterface
{
    /**
     * @param ContainerInterface $container
     */
    public function register(ContainerInterface $container): void
    {
        $container->set(
            'persistence.storage.mysql',
            new PDO(
                'mysql:dbname=movie_catalog;host=127.0.0.1',
                'movie_user',
                'password'
            )
        );

        $container->set(
            'persistence.adapter.db',
            new DBAdapter($container->get('persistence.storage.mysql'))
        );

        $container->set(
            'persistence.mapper.genre',
            new GenreMapper($container->get('persistence.adapter.db'))
        );

        $container->set(
            'persistence.mapper.movie',
            new MovieMapper($container->get('persistence.adapter.db'), $container->get('persistence.mapper.genre'))
        );
    }
}