<?php

use DI\Container;
use DI\ContainerBuilder;
use DI\Bridge\Slim\Bridge;
use Slim\Factory\AppFactory;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Seb\App\Controller\HomeController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
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
    return new SaleDAO($c->get('pdo'));
});

$app = Bridge::create($container);

$app->add(
    function (RequestInterface $request, RequestHandlerInterface $handler) {
        $response = $handler->handle($request);
        return $response
            ->withHeader("Access-Control-Allow-Origin", "*")
            ->withHeader("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE, OPTIONS")
            ->withHeader("Access-Control-Allow-Headers", "Content-Type, Accept,  Origin, Authorization");
    }
);

$app->get("/home", [HomeController::class, "home"]);
$app->get("/person", [HomeController::class, "person"]);
$app->get("/hello/{name}[/[{age:\d+}]]", [HomeController::class, "hello"]);


$app->get("/vente", [HomeController::class, "testDAO"]);
$app->get("/vente/{id:\d+}", [HomeController::class, "saleById"]);
$app->post("/vente", [HomeController::class, "newSale"]);
$app->delete("/vente/{id:\d+}", [HomeController::class, "deleteSaleById"]);
$app->post("/vente/{id:\d+}", [HomeController::class, "updateSale"]);


$app->run();