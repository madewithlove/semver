<?php
use League\Route\RouteCollection;

/** @var RouteCollection $router */
$ns = 'Semver\Http\Controllers\\';

$router->get('/', $ns.'HomeController::index');
$router->get('/packages/{vendor}/{name}', $ns.'PackageController::versions');
