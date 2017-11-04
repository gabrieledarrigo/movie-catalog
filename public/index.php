<?php
declare(strict_types=1);

require dirname(dirname(__FILE__)) . '/vendor/autoload.php';

use Darrigo\MovieCatalog\Container\Container;
use Darrigo\MovieCatalog\Application\Application;

$container = new Container();
$application = new Application($container);
return $application->bootstrap()->send();