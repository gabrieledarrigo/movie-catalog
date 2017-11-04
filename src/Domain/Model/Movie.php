<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Domain\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Movie
 * @package Darrigo\MovieCatalog\Domain\Model
 * @author darrigo.g@gmail.com
 */
final class Movie
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $budget;

    /**
     * @var Genre[]|ArrayCollection
     */
    private $genres;

    /**
     * @var string
     */
    private $homepage;

    /**
     * @var string
     */
    private $originalLanguage;

    /**
     * @var string
     */
    private $originalTitle;

    /**
     * @var string
     */
    private $overview;

    /**
     * @var float
     */
    private $popularity;

    /**
     * @var \DateTimeImmutable
     */
    private $releaseDate;

    /**
     * @var int
     */
    private $revenue;

    /**
     * @var int
     */
    private $runtime;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $tagline;

    /**
     * @var string
     */
    private $title;

    /**
     * @var float
     */
    private $voteAverage;

    /**
     * @var int
     */
    private $voteCount;

    /**
     * Movie constructor.
     * @param int $id
     * @param int $budget
     * @param Genre[]|ArrayCollection $genres
     * @param string $homepage
     * @param string $originalLanguage
     * @param string $originalTitle
     * @param string $overview
     * @param float $popularity
     * @param \DateTimeImmutable $releaseDate
     * @param int $revenue
     * @param int $runtime
     * @param string $status
     * @param string $tagline
     * @param string $title
     * @param float $voteAverage
     * @param int $voteCount
     */
    public function __construct(
        int $id,
        int $budget,
        ArrayCollection $genres = null,
        string $homepage,
        string $originalLanguage,
        string $originalTitle,
        string $overview,
        float $popularity,
        \DateTimeImmutable $releaseDate,
        int $revenue,
        int $runtime,
        string $status,
        string $tagline,
        string $title,
        float $voteAverage,
        int $voteCount
    ) {
        $this->id = $id;
        $this->budget = $budget;
        $this->genres = $genres;
        $this->homepage = $homepage;
        $this->originalLanguage = $originalLanguage;
        $this->originalTitle = $originalTitle;
        $this->overview = $overview;
        $this->popularity = $popularity;
        $this->releaseDate = $releaseDate;
        $this->revenue = $revenue;
        $this->runtime = $runtime;
        $this->status = $status;
        $this->tagline = $tagline;
        $this->title = $title;
        $this->voteAverage = $voteAverage;
        $this->voteCount = $voteCount;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getBudget(): int
    {
        return $this->budget;
    }

    /**
     * @return Genre[]|ArrayCollection
     */
    public function getGenres(): ArrayCollection
    {
        return $this->genres;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function hasGenre(int $id): bool
    {
        $result = $this->genres->filter(function (Genre $genre) use ($id) {
            return $genre->getId() === $id;
        });

        return $result->count() > 0;
    }

    /**
     * @return string
     */
    public function getHomepage(): string
    {
        return $this->homepage;
    }

    /**
     * @return string
     */
    public function getOriginalLanguage(): string
    {
        return $this->originalLanguage;
    }

    /**
     * @return string
     */
    public function getOriginalTitle(): string
    {
        return $this->originalTitle;
    }

    /**
     * @return string
     */
    public function getOverview(): string
    {
        return $this->overview;
    }

    /**
     * @return float
     */
    public function getPopularity(): float
    {
        return $this->popularity;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getReleaseDate(): \DateTimeImmutable
    {
        return $this->releaseDate;
    }

    /**
     * @return int
     */
    public function getRevenue(): int
    {
        return $this->revenue;
    }

    /**
     * @return int
     */
    public function getRuntime(): int
    {
        return $this->runtime;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getTagline(): string
    {
        return $this->tagline;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return float
     */
    public function getVoteAverage(): float
    {
        return $this->voteAverage;
    }

    /**
     * @return int
     */
    public function getVoteCount(): int
    {
        return $this->voteCount;
    }
}
