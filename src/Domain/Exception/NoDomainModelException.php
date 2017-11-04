<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Domain\Exception;

/**
 * Class NoDomainModelException
 * @package Darrigo\MovieCatalog\Domain\Exception
 */
class NoDomainModelException extends \Exception
{
    private const DEFAULT_MESSAGE = 'No Domain model can be found';

    /**
     * NoDomainModelException constructor.
     * @param string $message
     */
    public function __construct(string $message = self::DEFAULT_MESSAGE)
    {
        parent::__construct($message);
    }
}