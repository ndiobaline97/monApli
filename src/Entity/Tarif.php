<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="frais")
     */
    private $transactions;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
    }

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

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setFrais($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->contains($transaction)) {
            $this->transactions->removeElement($transaction);
            // set the owning side to null (unless already changed)
            if ($transaction->getFrais() === $this) {
                $transaction->setFrais(null);
            }
        }

        return $this;
    }
}
