<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Persistence\Exception;

/**
 * Class NoResultException
 * @package Darrigo\MovieCatalog\Persistence\Exception
 */
class NoResultException extends \Exception
{
    private const DEFAULT_MESSAGE = 'No result can be found';

    /**
     * NoResultException constructor.
     * @param string $message
     */
    public function __construct(string $message = self::DEFAULT_MESSAGE)
    {
        parent::__construct($message);
    }
}