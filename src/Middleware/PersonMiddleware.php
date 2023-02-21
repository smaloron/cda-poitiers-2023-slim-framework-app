<?php

namespace Seb\App\Middleware;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PersonMiddleware implements MiddlewareInterface
{

    public function __construct(private ContainerInterface $container)
    {
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $dao = $this->container->get("dao.person");
        $person = $dao->findOneById(1)->getOneAsArray();
        $request = $request->withAttribute("person", $person);

        return $handler->handle($request);
    }
}
