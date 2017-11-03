<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Persistence\Mapper;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface MapperInterface
 * @package Darrigo\MovieCatalog\Persistence\Mapper
 */
interface MapperInterface
{
    /**
     * @param array $data
     * @return mixed
     */
    public function map(array $data);

    /**
     * @param array $data
     * @return ArrayCollection
     */
    public function mapArray(array $data): ArrayCollection;
}
