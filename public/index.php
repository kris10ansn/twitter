<?php

use app\controllers\AuthController;
use app\controllers\HomeController;
use app\controllers\InteractionController;
use app\src\Route;
use app\src\Router;
use app\src\Session;

$root = dirname(__DIR__);
require_once($root . "/vendor/autoload.php");

define("APP_ROOT", $root);
define("APP_URL_ROOT", str_replace("/srv/http", "", $root));

Session::start();
$router = new Router();

$router->addRoute(new Route("/", HomeController::class, "home"));
$router->addRoute(new Route("/login", AuthController::class, "login"));
$router->addRoute(new Route("/register", AuthController::class, "register"));
$router->addRoute(new Route("/logout", AuthController::class, "logout"));
$router->addRoute(new Route("/\/interact\/.+/", InteractionController::class, "interact"));

$router->resolve();

