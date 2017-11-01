<?php
declare(strict_types=1);

namespace Tests\Darrigo\MovieCatalog\Domain\Model;

use Darrigo\MovieCatalog\Domain\Model\Genre;
use PHPUnit\Framework\TestCase;

/**
 * Class GenreTest
 * @package Tests\Darrigo\WeeklyOffers\Model
 * @author darrigo.g@gmail.com
 */
final class GenreTest extends TestCase
{
    public function testItIsADomainModelWithAUniqueIdAndAname() :void
    {
        $genre = new Genre(1, 'Action');
        $this->assertEquals(1, $genre->getId());
        $this->assertEquals('Action', $genre->getName());
    }
}