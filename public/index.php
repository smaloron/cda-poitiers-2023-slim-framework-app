<?php

use DI\Container;
use DI\ContainerBuilder;
use DI\Bridge\Slim\Bridge;
use Slim\Factory\AppFactory;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Seb\App\Controller\HomeController;
use Psr\Http\Message\ResponseInterface;
use Seb\App\Model\DAO\SaleDAO;
use Seb\App\Model\Entity\Sale;

require "../vendor/autoload.php";

$container = new Container; //(new ContainerBuilder())->build();


$container->set("pdo", function (ContainerInterface $c) {
    return new PDO(
        "mysql:host=localhost;dbname=formation_sql;charset=utf8",
        "root",
        "",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
});

$container->set("dao.sale", function (ContainerInterface $c) {
    return new SaleDAO($c->get('pdo'), "ventes", Sale::class);
});

$app = Bridge::create($container);





$app->get("/home", [HomeController::class, "home"]);
$app->get("/person", [HomeController::class, "person"]);
$app->get("/hello/{name}[/[{age:\d+}]]", [HomeController::class, "hello"]);

$app->run();