<?php

namespace Seb\App\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractController
{

    public function __construct(protected ContainerInterface $container)
    {
    }

    protected function jsonResponse(
        array $data,
        ResponseInterface $response,
        int $status = 200
    ) {
        $response->getBody()->write(json_encode($data));
        return $response->withHeader("Content-Type", "application/json")
            ->withStatus($status);
    }
}