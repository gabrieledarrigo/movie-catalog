<?php
declare(strict_types=1);

namespace Tests\Darrigo\MovieCatalog\Application;

use Darrigo\MovieCatalog\Application\Service\Pagination;
use PHPUnit\Framework\TestCase;

/**
 * Class PaginationTest
 * @package Tests\Darrigo\MovieCatalog\Application
 */
final class PaginationTest extends TestCase
{
    /**
     * @param int $page
     * @param int $expected
     * @dataProvider providePageAndOffset
     */
    public function testItShouldReturnTheOffsetForTheCurrentPage(int $page, int $expected): void
    {
        $pagination = new Pagination();
        $this->assertEquals($expected, $pagination->offset($page));
    }

    /**
     * @param int $page
     * @dataProvider provideNegativePage
     *
     */
    public function testItShouldReturnTheDefaultPageIfTheCurrentPageIsZeroOrNegative(int $page): void
    {
        $pagination = new Pagination();
        $this->assertEquals(Pagination::DEFAULT_PAGE, $pagination->offset($page));
    }

    /**
     * @return array
     */
    public function providePageAndOffset(): array
    {
        return [
            [1, 0],
            [2, 10],
            [3, 20],
            [7, 60],
        ];
    }

    /**
     * @return array
     */
    public function provideNegativePage(): array
    {
        return [
            [0],
            [-1],
            [-3],
            [-293489843],
        ];
    }
}