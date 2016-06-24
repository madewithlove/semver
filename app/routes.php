<?php

use League\Route\RouteCollection;
use Semver\Http\Controllers\HomeController;
use Semver\Http\Controllers\PackageController;

/* @var RouteCollection $router */
$router->get('/', HomeController::class.'::index');
$router->get('/packages/{vendor}/{package}', PackageController::class.'::versions');
$router->get('/packages/{vendor}/{package}/match', PackageController::class.'::matchVersions');
