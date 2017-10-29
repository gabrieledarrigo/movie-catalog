<?php

use Darrigo\MovieCatalog\Container\Container;
use Darrigo\MovieCatalog\Persistence\Provider\StorageProvider;

require 'vendor/autoload.php';


$container = new Container();
$provider = new StorageProvider();
$provider->register($container);

$storage = $container->get('persistence.storage.mysql');
$adapter = $container->get('persistence.adapter.db');
$mapper = $container->get('persistence.mapper.movie');


var_dump($mapper->fetchWithOffset(1, 2));