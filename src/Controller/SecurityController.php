<?php

namespace Seb\App\Controller;

use Firebase\JWT\JWT;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Seb\App\Core\NotFoundException;
use Slim\Psr7\Response;
use Seb\App\Model\Entity\User;

class SecurityController extends AbstractController
{

    public function register(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): Response {
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

    public function login(
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        // Récupération des données postées
        $postedData = $request->getParsedBody();

        // Validation des infos d'authentification
        if (!isset($postedData["login"]) || !isset($postedData["pass"])) {
            throw new InvalidArgumentException("Infos d'authentification incomplètes");
        }


        // Recherche de l'utilisateur dans la BD
        try {
            $dao = $this->container->get("dao.user");
            $user = $dao->find(["email" => $postedData["login"]])->getOneAsArray();
        } catch (NotFoundException $ex) {
            return $this->jsonResponse(["message" => "Accès impossible"], $response, 401);
        }

        // on a trouvé un utilisateur on doit désormais
        // tester son mot de passe
        if (password_verify($postedData["pass"], $user["user_pass"])) {
            // Elimination de la clef user_pass pour éviter de l'inclure dans le token
            unset($user["user_pass"]);
            // génération du token
            $token = JWT::encode([
                "iat" => time(),
                "exp" => time() * 60 * 5,
                "user" => $user
            ], $_ENV["JWT_SECRET"]);

            $response = $this->jsonResponse(
                ["message" => "OK", "token" => $token],
                $response
            );
        } else {
            $response = $this->jsonResponse(["message" => "Accès non autorisé"], $response, 403);
        }

        return $response;
    }
}