<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Application\Service;

/**
 * Class Pagination
 * I fucking hate pagination...
 * @package Darrigo\MovieCatalog\Application\Service
 */
class Pagination implements PaginationInterface
{
    /**
     * @param int $page
     * @return int
     */
    public function offset(int $page): int
    {
        return $page < 1
            ? self::DEFAULT_PAGE
            : ($page - 1) * self::PER_PAGE;
    }
}