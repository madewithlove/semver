<?php

use League\Container\Container;
use Semver\Application;

require __DIR__.'/../vendor/autoload.php';

$container = new Container();
$app       = new Application($container);

return $app->run();
