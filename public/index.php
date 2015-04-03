<?php

use League\Container\Container;
use League\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;

require '../vendor/autoload.php';

$container = new Container();

include '../app/boot.php';

/** @var RouteCollection $routes */
$routes = $container->get(RouteCollection::class);
/** @var Request $request */
$request = $container->get(Request::class);

$response = $routes->getDispatcher()->dispatch($request->getMethod(), $request->getPathInfo());

$response->send();