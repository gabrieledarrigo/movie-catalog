<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Persistence\Mapper;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class AbstractMapper
 * @package Darrigo\MovieCatalog\Persistence\Mapper
 */
abstract class AbstractMapper implements MapperInterface
{
    /**
     * @param array $data
     * @return ArrayCollection
     */
    public function mapArray(array $data): ArrayCollection
    {
        return new ArrayCollection(array_map(function ($d) {
            return $this->map($d);
        }, $data));
    }

}