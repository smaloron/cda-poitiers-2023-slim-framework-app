<?php
require "vendor/autoload.php";

use Slim\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Seb\App\Controller\HomeController;
use Seb\App\Model\DAO\SaleDAO;

class HomeControllerTest extends TestCase
{

    public function testHomeAction()
    {
        $dao = $this->createStub(SaleDAO::class);
        $container = $this->createStub(ContainerInterface::class);
        $container->method("get")->with("dao.sale")->willReturn($dao);

        $controller = new HomeController($container);
        $response = $controller->home(new Response);

        $this->assertStringContainsString(
            "Hello",
            $response->getBody()
        );
    }
}