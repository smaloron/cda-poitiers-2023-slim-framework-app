<?php

namespace Seb\App\Model\DAO;

use Seb\App\Core\AbstractDAO;
use PDO;
use Seb\App\Model\Entity\Person;

class PersonDAO extends AbstractDAO
{

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo, "vue_personne", Person::class);
    }
}