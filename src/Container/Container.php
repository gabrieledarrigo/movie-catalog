<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Container;

use Darrigo\MovieCatalog\Container\Exception\NotFoundException;
use Doctrine\Common\Collections\ArrayCollection;

class Container implements ContainerInterface
{
    /**
     * @var ArrayCollection $entries
     */
    private $entries;

    public function __construct()
    {
        $this->entries = new ArrayCollection();
    }

    public function get($id)
    {
        if (!$this->entries->containsKey($id)) {
            throw new NotFoundException("No entry with id '$id' found");
        }

        return $this->entries->get($id);
    }

    public function has($id)
    {
        // TODO: Implement has() method.
    }


    public function set(string $id, $entry)
    {
        return $this->entries->set($id, $entry);
    }
}