<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Persistence\Exception;

/**
 * Class NoResultException
 * @package Darrigo\MovieCatalog\Persistence\Exception
 */
class NoResultException extends \Exception
{
    /**
     * NoResultException constructor.
     * @param string $message
     */
    public function __construct(string $message = '')
    {
        parent::__construct($message);
    }
}