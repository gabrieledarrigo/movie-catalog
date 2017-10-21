<?php
declare(strict_types=1);

namespace Tests\Darrigo\WeeklyOffers\Model;

use Darrigo\MovieCatalog\Domain\Model\Genre;
use Darrigo\MovieCatalog\Domain\Model\Movie;
use PHPUnit\Framework\TestCase;

/**
 * Class MovieTest
 * @package Tests\Darrigo\WeeklyOffers\Model
 * @author darrigo.g@gmail.com
 */
final class MovieTest extends TestCase
{
    public function testItIsADomainModelRepresentingAMovie() :void
    {
        $genres = [
            new Genre(1, 'Action'),
            new Genre(2, 'Fantasy')
        ];
        $date = new \DateTimeImmutable('2009-12-10');

        $movie = new Movie(
            237000000,
            $genres,
            'http://www.avatarmovie.com/',
            19995,
            'en',
            'Avatar',
            'In the 22nd century...',
            150.437577,
            $date,
            2787965087,
            162,
            'Released',
            'Enter the World of Pandora.',
            'Avatar',
            7.2,
            11800
        );

        $this->assertEquals(237000000, $movie->getBudget());
        $this->assertSame($genres, $movie->getGenres());
        $this->assertEquals('http://www.avatarmovie.com/', $movie->getHomepage());
        $this->assertEquals(19995, $movie->getId());
        $this->assertEquals('en', $movie->getOriginalLanguage());
        $this->assertEquals('Avatar', $movie->getOriginalTitle());
        $this->assertEquals('In the 22nd century...', $movie->getOverview());
        $this->assertEquals(150.437577, $movie->getPopularity());
        $this->assertSame($date, $movie->getReleaseDate());
        $this->assertEquals(2787965087, $movie->getRevenue());
        $this->assertEquals(162, $movie->getRuntime());
        $this->assertEquals('Released', $movie->getStatus());
        $this->assertEquals('Enter the World of Pandora.', $movie->getTagline());
        $this->assertEquals('Avatar', $movie->getTitle());
        $this->assertEquals(7.2, $movie->getVoteAverage());
        $this->assertEquals(11800, $movie->getVoteCount());
    }
}