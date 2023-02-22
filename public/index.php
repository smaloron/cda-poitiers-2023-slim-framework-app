<?php

use DI\Container;
use RedBeanPHP\R;
use Dotenv\Dotenv;
use Slim\Psr7\Response;
use DI\ContainerBuilder;
use DI\Bridge\Slim\Bridge;
use Slim\Factory\AppFactory;
use Seb\App\Model\DAO\SaleDAO;
use Seb\App\Model\DAO\UserDAO;
use Seb\App\Model\Entity\Sale;
use Seb\App\Model\DAO\PersonDAO;
use Psr\Container\ContainerInterface;
use Seb\App\Controller\JwtController;
use Seb\App\Controller\HomeController;
use Psr\Http\Message\ResponseInterface;
use Seb\App\Middleware\PersonMiddleware;
use Seb\App\Controller\RedBeanController;
use Tuupola\Middleware\JwtAuthentication;
use Seb\App\Controller\SecurityController;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Seb\App\Controller\SecureController;
use Seb\App\Middleware\UserCheckMiddleware;
use Slim\Handlers\Strategies\RequestHandler;
use Slim\Interfaces\RouteCollectorProxyInterface;

require "../vendor/autoload.php";

// Chargement des variables d'environement dotenv

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();



R::setup(
    $_ENV["DSN"],
    $_ENV["DB_USER"],
    $_ENV["DB_PASS"]
);

$container = new Container; //(new ContainerBuilder())->build();


$container->set("pdo", function (ContainerInterface $c) {
    return new PDO(
        $_ENV["DSN"],
        $_ENV["DB_USER"],
        $_ENV["DB_PASS"],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
});

$container->set("dao.sale", function (ContainerInterface $c) {
    return new SaleDAO($c->get('pdo'));
});

$container->set("dao.person", function (ContainerInterface $c) {
    return new PersonDAO($c->get("pdo"));
});

$container->set("dao.user", function (ContainerInterface $c) {
    return new UserDAO($c->get("pdo"));
});

$app = Bridge::create($container);

// Ajout d'un attribut
$app->add(
    function (ServerRequestInterface $request, RequestHandlerInterface $handler) {
        $request = $request->withAttribute("copyright", "Moi & Moi");
        return $handler->handle($request);
    }
);

$app->add(
    function (ServerRequestInterface $request, RequestHandlerInterface $handler) {
        $response = $handler->handle($request);
        return $response
            ->withHeader("Access-Control-Allow-Origin", "*")
            ->withHeader("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE, OPTIONS")
            ->withHeader("Access-Control-Allow-Headers", "Content-Type, Accept,  Origin, Authorization");
    }
);

// Middleware pour sécuriser l'API avec une clef

function protectWithKey(ServerRequestInterface $request, RequestHandlerInterface $handler)
{
    // Récupération des données du QueryString 
    // sous la forme d'un  tableau association
    $queryData = $request->getQueryParams();
    // Test de la clef
    if (isset($queryData["key"]) && $queryData["key"] === "123") {
        // Réponse constituée par la résolution des appels aux autre middlewares et à la route
        return $handler->handle($request);
    }

    // Si pas de clef ou clef incorrecte
    // On génère notre propre objet Response 
    $response = new Response(403);
    //$response->withHeader("Content-Type", "application/json");

    $response->getBody()->write(json_encode(["message" => "Accès non autorisé"]));
    return $response->withHeader("Content-Type", "application/json");
}

$app->get("/home", [HomeController::class, "home"]);
$app->get("/person", [HomeController::class, "person"]);
$app->get("/hello/{name}[/[{age:\d+}]]", [HomeController::class, "hello"]);

$app->group("/vente", function (RouteCollectorProxyInterface $group) {
    $group->get("", [HomeController::class, "testDAO"]);

    $group->get("/{id:\d+}", [HomeController::class, "saleById"]);
    $group->post("", [HomeController::class, "newSale"]);
    $group->delete("/{id:\d+}", [HomeController::class, "deleteSaleById"]);
    $group->post("/{id:\d+}", [HomeController::class, "updateSale"]);
})->add("protectWithKey");



$app->get("/book", [RedBeanController::class, "index"])
    ->add(new PersonMiddleware($container));

$app->get("/jwt/get-token", [JwtController::class, "getToken"]);
$app->get("/jwt/secure", [JwtController::class, "secureSpace"])
    ->add(new JwtAuthentication([
        "secret" => $_ENV["JWT_SECRET"]
    ]));


$app->post("/register", [SecurityController::class, "register"]);
$app->post("/login", [SecurityController::class, "login"]);

$app->get("/secure", [SecureController::class, "index"])
    ->add(new UserCheckMiddleware($container))
    ->add(new JwtAuthentication(["secret" => $_ENV["JWT_SECRET"]]));


$app->run();