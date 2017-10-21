<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Domain\Model;

/**
 * Class Genre
 * @package Darrigo\MovieCatalog\Domain\Model
 * @author darrigo.g@gmail.com
 */
final class Genre
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * Genre constructor.
     * @param int $id
     * @param string $name
     */
    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}