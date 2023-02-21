<?php

namespace Seb\App\Controller;

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

        $dao->save($user);

        return $this->jsonResponse(
            [
                "message" => "OK",
                "parsedBody" => $postedData,
                "user" => [
                    "userName" => $user->getUserName(),
                    "email" => $user->getEmail(),
                    "role" => $user->getRole(),
                    "userPass" => $user->getUserPass(),
                    "id" => $user->getId()
                ]
            ],
            $response
        );
    }
}