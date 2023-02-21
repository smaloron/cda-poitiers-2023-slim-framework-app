<?php

namespace Seb\App\Middleware;

use Slim\Psr7\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class UserCheckMiddleware implements MiddlewareInterface
{

    public function __construct(private ContainerInterface $container)
    {
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {

        $token = $request->getAttribute("token", []);

        if (isset($token["user"]) && !empty($token["user"]->id)) {
            $response = $handler->handle($request);
        } else {
            $response = new Response(403);
            $response->getBody()->write(json_encode([
                "message" => "Pas le droit d'accèder à cette ressource",
                "token" => $token
            ]));
        }

        return $response;
    }
}