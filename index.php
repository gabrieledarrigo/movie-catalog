<?php

use Predis\Client;

require 'vendor/autoload.php';

$client = new Client([
    'prefix' => 'movie.catalog',
    'scheme' => 'tcp',
    'host'   => '127.0.0.1',
    'port'   => 6379,
]);


$client->set('movie.data', 'ok');