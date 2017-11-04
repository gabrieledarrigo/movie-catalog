<?php
declare(strict_types=1);

namespace Tests\Darrigo\MovieCatalog\Domain\Model;

use Darrigo\MovieCatalog\Domain\Model\Genre;
use Darrigo\MovieCatalog\Domain\Model\Movie;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

/**
 * Class MovieTest
 * @package Tests\Darrigo\MovieCatalog\Domain\Model
 */
final class MovieTest extends TestCase
{
    /**
     * @var Genre[]|ArrayCollection
     */
    private $genres;

    /**
     * @var \DateTimeImmutable
     */
    private $dateTime;

    protected function setUp(): void
    {
        $this->genres = new ArrayCollection([
            new Genre(1, 'Action'),
            new Genre(2, 'Fantasy')
        ]);

        $this->dateTime = new \DateTimeImmutable('2009-12-10');
    }

    public function testItIsADomainModelRepresentingAMovie(): void
    {
        $movie = new Movie(
            19995,
            237000000,
            $this->genres,
            'http://www.avatarmovie.com/',
            'en',
            'Avatar',
            'In the 22nd century...',
            150.437577,
            $this->dateTime,
            2787965087,
            162,
            'Released',
            'Enter the World of Pandora.',
            'Avatar',
            7.2,
            11800
        );

        $this->assertEquals(19995, $movie->getId());
        $this->assertEquals(237000000, $movie->getBudget());
        $this->assertSame($this->genres, $movie->getGenres());
        $this->assertEquals('http://www.avatarmovie.com/', $movie->getHomepage());
        $this->assertEquals('en', $movie->getOriginalLanguage());
        $this->assertEquals('Avatar', $movie->getOriginalTitle());
        $this->assertEquals('In the 22nd century...', $movie->getOverview());
        $this->assertEquals(150.437577, $movie->getPopularity());
        $this->assertSame($this->dateTime, $movie->getReleaseDate());
        $this->assertEquals(2787965087, $movie->getRevenue());
        $this->assertEquals(162, $movie->getRuntime());
        $this->assertEquals('Released', $movie->getStatus());
        $this->assertEquals('Enter the World of Pandora.', $movie->getTagline());
        $this->assertEquals('Avatar', $movie->getTitle());
        $this->assertEquals(7.2, $movie->getVoteAverage());
        $this->assertEquals(11800, $movie->getVoteCount());
    }

    public function testItShouldKnowIfItHasASpecificGenre(): void
    {
        $movie = new Movie(
            19995,
            237000000,
            $this->genres,
            'http://www.avatarmovie.com/',
            'en',
            'Avatar',
            'In the 22nd century...',
            150.437577,
            $this->dateTime,
            2787965087,
            162,
            'Released',
            'Enter the World of Pandora.',
            'Avatar',
            7.2,
            11800
        );

        $this->assertTrue($movie->hasGenre(1));
        $this->assertTrue($movie->hasGenre(2));
        $this->assertFalse($movie->hasGenre(3));
    }
}
