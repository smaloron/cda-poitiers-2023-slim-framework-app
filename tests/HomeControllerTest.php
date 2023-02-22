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

    public function testOfTestDAO()
    {
        $dao = $this->createStub(SaleDAO::class);
        $container = $this->createStub(ContainerInterface::class);
        $dao->method("findAll")->willReturn($dao);
        $dao->method("getAllAsArray")->willReturn([
            ["id" => 1, "montant" => 300],
            ["id" => 3, "montant" => 300],
            ["id" => 5, "montant" => 300],
        ]);
        $container->method("get")->with("dao.sale")->willReturn($dao);

        $controller = new HomeController($container);

        $response = $controller->testDAO(new Response());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('"id":1', $response->getBody());
        $this->assertCount(3, json_decode($response->getBody()));
    }
}