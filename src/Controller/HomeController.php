<?php

namespace Seb\App\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class HomeController
{

    public function __construct(private ContainerInterface $container)
    {
    }


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
        $name,
        $age = 8
    ) {
        //$age = $args["age"] ?? 7;
        $text = "Bonjour $name vous avez $age ans";
        $response->getBody()->write($text);
        return $response->withStatus(200);
    }

    public function testDAO(
        ResponseInterface $response
    ) {
        $data = $this->container->get('dao.sale')->findAll([], ["limit" => 10])->getAllAsArray();
        $response->getBody()->write(json_encode($data));
        return $response->withHeader("Content-Type", "application/json");
    }

    public function saleById(ResponseInterface $response, int $id)
    {
        $sale = $this->container
            ->get('dao.sale')
            ->findOneById($id)->getOneAsArray();

        $response->getBody()->write(json_encode($sale));
        return $response->withHeader("Content-Type", "application/json");
    }
}