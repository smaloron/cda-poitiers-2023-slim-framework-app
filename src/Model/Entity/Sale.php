<?php

namespace Seb\App\Model\Entity;

use DateTime;
use Seb\App\Core\EntityInterface;

class Sale implements EntityInterface
{

    private int $id;
    private int $vendeurId;
    private int $departementId;
    private float $montant;
    private DateTime $dateVente;



    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of vendeurId
     */
    public function getVendeurId()
    {
        return $this->vendeurId;
    }

    /**
     * Set the value of vendeurId
     *
     * @return  self
     */
    public function setVendeurId($vendeurId)
    {
        $this->vendeurId = $vendeurId;

        return $this;
    }

    /**
     * Get the value of departementId
     */
    public function getDepartementId()
    {
        return $this->departementId;
    }

    /**
     * Set the value of departementId
     *
     * @return  self
     */
    public function setDepartementId($departementId)
    {
        $this->departementId = $departementId;

        return $this;
    }

    /**
     * Get the value of montant
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set the value of montant
     *
     * @return  self
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get the value of dateVente
     */
    public function getDateVente()
    {
        return $this->dateVente;
    }

    /**
     * Set the value of dateVente
     *
     * @return  self
     */
    public function setDateVente($dateVente)
    {
        $this->dateVente = $dateVente;

        return $this;
    }
}