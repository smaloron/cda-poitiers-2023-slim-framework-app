<?php

namespace Seb\App\Controller;

use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class JwtController extends AbstractController
{


    public function getToken(ResponseInterface $response)
    {
        $data = [
            "iat" => time(),
            "exp" => time() + 60,
            "user" => ["userName" => "toto", "role" => "admin"]
        ];

        $token = JWT::encode($data, $_ENV["JWT_SECRET"]);

        return $this->jsonResponse(["token" => $token], $response);
    }

    public function secureSpace(ResponseInterface $response, ServerRequestInterface $request)
    {
        $tokenData = $request->getAttribute("token", []);

        return $this->jsonResponse(
            [
                "message" => "Vous êtes dans un espace sécurisé",
                "token" => $tokenData
            ],
            $response
        );
    }
}