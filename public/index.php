<?php

use app\controllers\AuthController;
use app\controllers\HashtagController;
use app\controllers\HomeController;
use app\controllers\PostController;
use app\controllers\UserController;
use app\src\Path;
use app\src\Route;
use app\src\Router;
use app\src\Session;


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


date_default_timezone_set("Europe/Oslo");

$root = str_replace("\\", "/", dirname(__DIR__));
require_once($root . "/vendor/autoload.php");

define("APP_ROOT", $root);
define("APP_URL_ROOT", preg_replace("/(\/srv\/http)|(C:\/wamp64\/www)/", "", $root));

Session::start();
$router = new Router();

$router->addRoute(new Route("/", HomeController::class, "home"));
$router->addRoute(new Route("/explore", HomeController::class, "explore"));

$router->addRoute(new Route("/login", AuthController::class, "login"));
$router->addRoute(new Route("/register", AuthController::class, "register"));
$router->addRoute(new Route("/logout", AuthController::class, "logout"));

$router->addRoute(new Route("/interact/:id", PostController::class, "interact"));
$router->addRoute(new Route("/post/:id", PostController::class, "post"));

$router->addRoute(new Route("/hashtag/:hashtag", HashtagController::class, "hashtag"));

$router->addRoute(new Route("/user/:id", UserController::class, "user"));
$router->addRoute(new Route("/user/:id/follow", UserController::class, "follow"));
$router->addRoute(new Route("/user/:id/followers", UserController::class, "followers"));
$router->addRoute(new Route("/user/:id/following", UserController::class, "following"));

$router->addRoute(new Route("/users", UserController::class, "users"));
$router->addRoute(new Route("/profile", UserController::class, "profile"));
$router->addRoute(new Route("/profile/edit", UserController::class, "editProfile"));

$router->resolve();

