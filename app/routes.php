<?php

use League\Route\RouteCollection;
use Semver\Http\Controllers\HomeController;
use Semver\Http\Controllers\PackageController;

/* @var RouteCollection $router */
$router->get('/', HomeController::class.'::index');
$router->get('/packages/{vendor}/{name}', PackageController::class.'::versions');
$router->post('/packages/{vendor}/{name}/match', PackageController::class.'::matchVersions');
