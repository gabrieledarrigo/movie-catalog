<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Persistence\Provider;

use Darrigo\MovieCatalog\Container\ContainerInterface;

/**
 * Interface ProviderInterface
 * @package Darrigo\Persistence\Provider
 */
interface ProviderInterface
{
    /**
     * @param ContainerInterface $container
     */
    public function register(ContainerInterface $container): void;
}