<?php

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Factory\AppFactory;
use Seb\App\Controller\HomeController;

require "../vendor/autoload.php";

$app = AppFactory::create();

$app->get("/home", [HomeController::class, "home"]);
$app->get("/person", [HomeController::class, "person"]);
$app->get("/hello/{name}[/[{age:\d+}]]", [HomeController::class, "hello"]);

$app->run();