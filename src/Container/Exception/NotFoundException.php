<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Container\Exception;

use Psr\Container\NotFoundExceptionInterface;
use \Exception;

/**
 * Class NotFoundException
 * @package Darrigo\MovieCatalog\Container\Exception
 */
class NotFoundException extends \Exception implements NotFoundExceptionInterface
{
    /**
     * NotFoundException constructor.
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
