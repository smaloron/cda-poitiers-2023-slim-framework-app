<?php

namespace Seb\App\Controller;

use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Response;
use Seb\App\Model\Entity\User;

class SecurityController extends AbstractController
{

    public function register(ServerRequestInterface $request, ResponseInterface $response): Response
    {
        // Récupération des données postées
        $postedData = $request->getParsedBody();
        // Obtention du DAO depuis le conteneur de dépendences 
        $dao = $this->container->get("dao.user");
        // hydratation de l'entité avec les données postées  
        $user = $dao->hydrate($postedData, new User);

        // Hashage du mot de passe en clair
        $user->setUserPass(password_hash($postedData["password"], PASSWORD_DEFAULT));
        // Enregistrement dans la BD
        $dao->save($user);
        // Génération du token
        $token = JWT::encode(
            [
                "iat" => time(),
                "exp" => time() * 60 * 5,
                "user" => [
                    "userName" => $user->getUserName(),
                    "email" => $user->getEmail(),
                    "role" => $user->getRole(),
                    "id" => $user->getId()
                ]
            ],
            $_ENV["JWT_SECRET"]
        );


        return $this->jsonResponse(
            [
                "message" => "OK",
                "token" => $token
            ],
            $response
        );
    }
}