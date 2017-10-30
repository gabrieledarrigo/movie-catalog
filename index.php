<?php
declare(strict_types=1);

use Darrigo\MovieCatalog\Container\Container;
use Darrigo\MovieCatalog\Domain\Model\Movie;
use Darrigo\MovieCatalog\Persistence\Provider\StorageProvider;

require 'vendor/autoload.php';


$container = new Container();
$provider = new StorageProvider();
$provider->register($container);

$storage = $container->get('persistence.storage.mysql');
$adapter = $container->get('persistence.adapter.db');
$mapper = $container->get('persistence.mapper.movie');

/** @var  Movie $movie */
$movie = $mapper->fetch(5);

var_dump($movie->getId());
var_dump($movie->getGenres());