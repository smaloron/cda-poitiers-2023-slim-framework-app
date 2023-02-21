<?php

namespace Seb\App\Model\DAO;

use Seb\App\Core\AbstractDAO;
use PDO;

class UserDAO extends AbstractDAO
{

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo, "users", User::class);
    }
}
