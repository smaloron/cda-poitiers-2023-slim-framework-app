<?php

namespace Seb\App\Model\DAO;

use Seb\App\Core\AbstractDAO;
use Seb\App\Model\Entity\Sale;
use PDO;

class SaleDAO extends AbstractDAO
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo, "vue_vente", Sale::class);
    }
}