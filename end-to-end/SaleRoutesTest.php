<?php

use PHPUnit\Framework\TestCase;

require "vendor/autoload.php";

class SaleRoutesTest extends TestCase
{

    private function sendRequest(string $url)
    {
        $request = curl_init();
        curl_setopt($request, CURLOPT_URL, "http://localhost:8000/$url");
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($request);
        $info = curl_getinfo($request);
        curl_close($request);

        return [
            "info" => $info,
            "output" => $output
        ];
    }

    public function testRequestWithoutKeyReturns403Response()
    {
        $result = $this->sendRequest("vente/1");
        extract($result);

        //var_dump($info);
        $this->assertEquals(403, $info["http_code"]);
        $this->assertEquals("application/json", $info["content_type"]);
        $this->assertStringContainsString('non autoris\u00e9', $output);
    }

    public function testGetOneSaleById()
    {
        $result = $this->sendRequest("vente/1?key=123");
        extract($result);
        $this->assertEquals(200, $info["http_code"]);
        $response = json_decode($output, true);
        $this->assertIsArray($response);
        $sale = $response["sale"];
        $this->assertTrue(array_key_exists("id", $sale));
        $this->assertEquals(1, $sale["id"]);
    }
}