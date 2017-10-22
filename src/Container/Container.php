<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Container;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class Container implements ContainerInterface
{
    private $entries = [];

    public function get($id)
    {
        // TODO: Implement get() method.
    }

    public function has($id)
    {
        // TODO: Implement has() method.
    }


    public function set(string $id, $entry)
    {
        // TODO: Implement set() method.
    }


}