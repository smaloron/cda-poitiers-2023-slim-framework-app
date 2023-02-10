<?php

namespace Seb\App\Controller;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class HomeController
{


    public function home(
        ResponseInterface $response,
    ) {
        $response->getBody()->write("<h1>Hello</h1>");
        return $response;
    }

    public function person(
        ResponseInterface $response,
    ) {
        $response->getBody()->write(json_encode([
            "name" => "Bohr", "firstName" => "Niels", "profession" => "Physicien"
        ]));
        return $response->withHeader("Content-Type", "application/json")
            ->withStatus(200);
    }

    public function hello(
        ResponseInterface $response,
        array $args
    ) {
        $age = $args["age"] ?? 7;
        $text = "Bonjour {$args['name']} vous avez $age ans";
        $response->getBody()->write($text);
        return $response->withStatus(200);
    }
}