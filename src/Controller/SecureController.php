<?php

namespace Seb\App\Controller;

use Slim\Psr7\Response;

class SecureController extends AbstractController
{

    public function index(Response $response)
    {
        return $this->jsonResponse(
            [
                "message" => "Accès sécurisé"
            ],
            $response
        );
    }
}