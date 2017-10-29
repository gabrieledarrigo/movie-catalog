<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Container;

use Darrigo\MovieCatalog\Container\Exception\NotFoundException;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Container
 * @package Darrigo\MovieCatalog\Container
 */
final class Container implements ContainerInterface
{
    /**
     * @var ArrayCollection $entries
     */
    private $entries;

    /**
     * Container constructor.
     */
    public function __construct()
    {
        $this->entries = new ArrayCollection();
    }

    /**
     * @param string $id
     * @return mixed|null
     * @throws NotFoundException
     */
    public function get($id)
    {
        if (!$this->has($id)) {
            throw new NotFoundException("No entry with id '$id' found");
        }

        return $this->entries->get($id);
    }

    /**
     * @param string $id
     * @return bool
     */
    public function has($id): bool
    {
        return $this->entries->containsKey($id);
    }

    /**
     * @param string $id
     * @param $entry
     * @return void
     */
    public function set(string $id, $entry): void
    {
        $this->entries->set($id, $entry);
    }
}