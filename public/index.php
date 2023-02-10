<?php

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Factory\AppFactory;

require "../vendor/autoload.php";

$app = AppFactory::create();

$app->get(
    "/home",
    function (
        RequestInterface $request,
        ResponseInterface $response,
        array $args = []
    ) {
        $response->getBody()->write("<h1>Hello</h1>");
        return $response;
    }
);

$app->get("/person", function (
    RequestInterface $request,
    ResponseInterface $response,
    array $args = []
) {

    $response->getBody()->write(json_encode([
        "name" => "Bohr", "firstName" => "Niels", "profession" => "Physicien"
    ]));
    return $response->withHeader("Content-Type", "application/json")
        ->withStatus(200);
});

$app->get("/hello/{name}[/[{age:\d+}]]", function (
    RequestInterface $request,
    ResponseInterface $response,
    array $args = []
) {
    $age = $args["age"] ?? 7;
    $text = "Bonjour {$args['name']} vous avez $age ans";
    $response->getBody()->write($text);
    return $response->withStatus(200);
});

$app->run();