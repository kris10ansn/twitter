<?php

use app\controllers\AuthController;
use app\controllers\HomeController;
use app\src\Route;
use app\src\Router;

$root = dirname(__DIR__);
require_once($root . "/vendor/autoload.php");

define("APP_ROOT", $root);

$router = new Router();

$router->register(new Route("/", HomeController::class, "home"));
$router->register(new Route("/login", AuthController::class, "login"));
$router->register(new Route("/register", AuthController::class, "register"));

$router->resolve();

