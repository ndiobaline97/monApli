<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommissionRepository")
 */
class Commission
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $borneinf;

    /**
     * @ORM\Column(type="bigint")
     */
    private $bornesup;

    /**
     * @ORM\Column(type="bigint")
     */
    private $montantCommision;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBorneinf(): ?int
    {
        return $this->borneinf;
    }

    public function setBorneinf(int $borneinf): self
    {
        $this->borneinf = $borneinf;

        return $this;
    }

    public function getBornesup(): ?int
    {
        return $this->bornesup;
    }

    public function setBornesup(int $bornesup): self
    {
        $this->bornesup = $bornesup;

        return $this;
    }

    public function getMontantCommision(): ?int
    {
        return $this->montantCommision;
    }

    public function setMontantCommision(int $montantCommision): self
    {
        $this->montantCommision = $montantCommision;

        return $this;
    }
}
