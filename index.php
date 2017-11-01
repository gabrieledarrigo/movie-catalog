<?php
declare(strict_types=1);

use Darrigo\MovieCatalog\Container\Container;
use Darrigo\MovieCatalog\Domain\Model\Movie;
use Darrigo\MovieCatalog\Persistence\Mapper\GenreMapper;
use Darrigo\MovieCatalog\Persistence\Mapper\MovieMapper;
use Darrigo\MovieCatalog\Persistence\Provider\StorageProvider;

require 'vendor/autoload.php';


$container = new Container();
$provider = new StorageProvider();
$provider->register($container);

$storage = $container->get('persistence.storage.mysql');
$adapter = $container->get('persistence.adapter.db');

/** @var MovieMapper $movieMapper */
$movieMapper = $container->get('persistence.mapper.movie');

/** @var GenreMapper $genreMapper */
$genreMapper = $container->get('persistence.mapper.genre');

var_dump($movieMapper->fetchWithOffset(0, 2));
var_dump($genreMapper->fetchAll());