<?php

namespace Seb\App\Controller;

use RedBeanPHP\R;
use Psr\Http\Message\ResponseInterface;


class RedBeanController extends AbstractController
{

    public function index(ResponseInterface $response)
    {
        $book = R::dispense("book");
        $book->title = "Les Misérables";
        $book->author = "Victor Hugo";
        $book->price = 8;

        R::store($book);

        return $this->jsonResponse([
            "success" => true,
            "data" => serialize($book)
        ], $response);
    }
}