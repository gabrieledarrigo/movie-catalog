<?php
declare(strict_types=1);
require 'vendor/autoload.php';


use Darrigo\MovieCatalog\Application\Provider\ApplicationProvider;
use Darrigo\MovieCatalog\Container\Container;
use Darrigo\MovieCatalog\Application\Application;
use Darrigo\MovieCatalog\Domain\Model\Movie;
use Darrigo\MovieCatalog\Domain\Provider\DomainProvider;
use Darrigo\MovieCatalog\Persistence\Mapper\GenreMapper;
use Darrigo\MovieCatalog\Persistence\Mapper\MovieMapper;
use Darrigo\MovieCatalog\Persistence\Provider\StorageProvider;
use Darrigo\MovieCatalog\Application\Service\MovieCatalog;

$container = new Container();
$persistence = new StorageProvider();
$persistence->register($container);

$domain = new DomainProvider();
$domain->register($container);

$app = new ApplicationProvider();
$app->register($container);

/** @var MovieCatalog $service */
$service = $container->get('application.service.movie.catalog');
$result = $service->get(5345234234);



//$storage = $container->get('persistence.storage.mysql');
//$adapter = $container->get('persistence.adapter.db');
//
///** @var MovieMapper $movieMapper */
//$movieMapper = $container->get('persistence.mapper.movie');
//
///** @var GenreMapper $genreMapper */
//$genreMapper = $container->get('persistence.mapper.genre');
//
//var_dump($movieMapper->fetch(1239127389127318273));
//var_dump($genreMapper->fetchAll());


//$container = new Container();
//$application = new Application($container);
//return $application->bootstrap()->send();