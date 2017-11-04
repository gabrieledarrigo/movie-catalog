<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Application\Service;

/**
 * Interface PaginationInterface
 * @package Darrigo\MovieCatalog\Application\Service
 */
interface PaginationInterface
{
    const DEFAULT_PAGE = 0;
    const PER_PAGE = 10;

    /**
     * @param int $page
     * @return int
     */
    public function offset(int $page): int;
}