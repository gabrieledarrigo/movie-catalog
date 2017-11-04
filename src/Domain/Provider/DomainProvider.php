<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Domain\Provider;

use Darrigo\MovieCatalog\Container\ContainerInterface;
use Darrigo\MovieCatalog\Domain\Repository\Genres;
use Darrigo\MovieCatalog\Domain\Repository\Movies;
use Darrigo\MovieCatalog\Shared\ProviderInterface;

/**
 * Class DomainProvider
 * @package Darrigo\MovieCatalog\Domain\Provider
 */
class DomainProvider implements ProviderInterface
{
    /**
     * @param ContainerInterface $container
     */
    public function register(ContainerInterface $container): void
    {
        $container->set('domain.repository.movies', new Movies($container->get('persistence.mapper.movie')));
        $container->set('domain.repository.genres', new Genres($container->get('persistence.mapper.genre')));
    }
}
