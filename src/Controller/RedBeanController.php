<?php

namespace Seb\App\Controller;

use RedBeanPHP\R;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Seb\App\Model\Entity\Person;

class RedBeanController extends AbstractController
{

    public function index(ResponseInterface $response, ServerRequestInterface $request)
    {
        $book = R::dispense("book");
        $book->title = "Les Misérables";
        $book->author = "Victor Hugo";
        $book->price = 8;

        R::store($book);

        $newBook = R::find("book", "id=" . $book->id);

        $person = $request->getAttribute("person", []);

        return $this->jsonResponse([
            "success" => true,
            "data" => $newBook,
            "person" => $person
        ], $response);
    }
}