<?php

namespace Seb\App\Controller;

use DateTime;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Factory\Psr17\ServerRequestCreator;

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

    public function newSale(
        ResponseInterface $response,
        ServerRequestInterface $request
    ) {

        $dao = $this->container->get("dao.sale");
        $postedData = $request->getParsedBody();
        $sale = $dao->hydrate($postedData);
        $dao->save($sale);

        $response->getBody()->write(json_encode(
            [
                "success" => true,
                "data" => serialize($sale)
            ]
        ));
        return $response->withHeader("Content-Type", "application/json");
    }


    public function deleteSaleById(int $id, ResponseInterface $response)
    {
        $dao = $this->container->get("dao.sale");
        $dao->deleteOneById($id);
        $response->getBody()->write(json_encode(
            [
                "success" => true
            ]
        ));
        return $response->withHeader("Content-Type", "application/json");
    }

    public function updateSale(
        int $id,
        ResponseInterface $response,
        ServerRequestInterface $request
    ) {
        $dao = $this->container->get("dao.sale");

        $postedData = $request->getParsedBody();
        $sale = $dao->findOneById($id)->getOneAsObject();
        $sale = $dao->hydrate($postedData, $sale);

        $dao->save($sale);

        $response->getBody()->write(json_encode(
            [
                "success" => true,
                "data" => serialize($sale)
            ]
        ));
        return $response->withHeader("Content-Type", "application/json");
    }
}
