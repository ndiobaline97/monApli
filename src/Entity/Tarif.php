<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TarifRepository")
 */
class Tarif
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="bigint")
     */
    private $borneInf;

    /**
     * @ORM\Column(type="bigint")
     */
    private $borneSup;

    /**
     * @ORM\Column(type="bigint")
     */
    private $valeur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBorneInf(): ?int
    {
        return $this->borneInf;
    }

    public function setBorneInf(int $borneInf): self
    {
        $this->borneInf = $borneInf;

        return $this;
    }

    public function getBorneSup(): ?int
    {
        return $this->borneSup;
    }

    public function setBorneSup(int $borneSup): self
    {
        $this->borneSup = $borneSup;

        return $this;
    }

    public function getValeur(): ?int
    {
        return $this->valeur;
    }

    public function setValeur(int $valeur): self
    {
        $this->valeur = $valeur;

        return $this;
    }
}
