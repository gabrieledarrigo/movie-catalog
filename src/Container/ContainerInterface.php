<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Container;

/**
 * Interface ContainerInterface
 * @package Darrigo\MovieCatalog\Container
 */
interface ContainerInterface extends \Psr\Container\ContainerInterface
{
    /**
     * @param string $id
     * @param $entry
     * @return mixed
     */
    public function set(string $id, $entry): void;
}