<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 */
class Transaction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomE;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenomE;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="integer")
     */
    private $telephoneE;

    /**
     * @ORM\Column(type="datetime" )
     */
    private $dateEnvoie;

    /**
     * @ORM\Column(type="integer")
     */
    private $numTransaction;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typePiece;

     /**
     * @ORM\Column(type="bigint")
     */
    private $numPiece;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateDelivrance;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateExpiration;

    /**
     * @ORM\Column(type="float")
     */
    private $montant;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomB;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenomB;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresseB;

    /**
     * @ORM\Column(type="integer")
     */
    private $telephoneB;

    /**
     * @ORM\Column(type="string")
     */
    private $codeEnvoie;

    /**
     * @ORM\Column(type="integer")
     */
    private $commissionUser;

    /**
     * @ORM\Column(type="integer")
     */
    private $commissionSysteme;

    /**
     * @ORM\Column(type="integer")
     */
    private $commissionEtat;

    /**
     * @ORM\Column(type="integer")
     */
    private $fraisEnvoie;

    /**
     * @ORM\Column(type="bigint")
     */
    private $total;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $user;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateRetrait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="transaction")
     */
    private $useretrait;

   

    /**
     * @ORM\Column(type="integer")
     */
    private $commissionRetrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etatCode;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $typePieceB;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numPieceB;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomE(): ?string
    {
        return $this->nomE;
    }

    public function setNomE(string $nomE): self
    {
        $this->nomE = $nomE;

        return $this;
    }

    public function getPrenomE(): ?string
    {
        return $this->prenomE;
    }

    public function setPrenomE(string $prenomE): self
    {
        $this->prenomE = $prenomE;

        return $this;
    }

    public function getnumPiece(): ?int
    {
        return $this->numPiece;
    }

    public function setnumPiece(int $numPiece): self
    {
        $this->numPiece = $numPiece;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephoneE(): ?int
    {
        return $this->telephoneE;
    }
    
    public function setTelephoneE(int $telephoneE): self
    {
        $this->telephoneE = $telephoneE;

        return $this;
    }

    public function getDateEnvoie(): ?\DateTimeInterface
    {
        return $this->dateEnvoie;
    }

    public function setDateEnvoie(\DateTimeInterface $dateEnvoie): self
    {
        $this->dateEnvoie = $dateEnvoie;

        return $this;
    }

    public function getNumTransaction(): ?int
    {
        return $this->numTransaction;
    }

    public function setNumTransaction(int $numTransaction): self
    {
        $this->numTransaction = $numTransaction;

        return $this;
    }

    public function getTypePiece(): ?string
    {
        return $this->typePiece;
    }

    public function setTypePiece(string $typePiece): self
    {
        $this->typePiece = $typePiece;

        return $this;
    }

    public function getDateDelivrance(): ?\DateTimeInterface
    {
        return $this->dateDelivrance;
    }

    public function setDateDelivrance(\DateTimeInterface $dateDelivrance): self
    {
        $this->dateDelivrance = $dateDelivrance;

        return $this;
    }

    public function getDateExpiration(): ?\DateTimeInterface
    {
        return $this->dateExpiration;
    }

    public function setDateExpiration(\DateTimeInterface $dateExpiration): self
    {
        $this->dateExpiration = $dateExpiration;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getNomB(): ?string
    {
        return $this->nomB;
    }

    public function setNomB(string $nomB): self
    {
        $this->nomB = $nomB;

        return $this;
    }

    public function getPrenomB(): ?string
    {
        return $this->prenomB;
    }

    public function setPrenomB(string $prenomB): self
    {
        $this->prenomB = $prenomB;

        return $this;
    }

    public function getAdresseB(): ?string
    {
        return $this->adresseB;
    }

    public function setAdresseB(string $adresseB): self
    {
        $this->adresseB = $adresseB;

        return $this;
    }

    public function getTelephoneB(): ?int
    {
        return $this->telephoneB;
    }

    public function setTelephoneB(int $telephoneB): self
    {
        $this->telephoneB = $telephoneB;

        return $this;
    }

    public function getCodeEnvoie(): ?string
    {
        return $this->codeEnvoie;
    }

    public function setCodeEnvoie(string $codeEnvoie): self
    {
        $this->codeEnvoie = $codeEnvoie;

        return $this;
    }

    public function getCommissionUser(): ?int
    {
        return $this->commissionUser;
    }

    public function setCommissionUser(int $commissionUser): self
    {
        $this->commissionUser = $commissionUser;

        return $this;
    }

    public function getCommissionSysteme(): ?int
    {
        return $this->commissionSysteme;
    }

    public function setCommissionSysteme(int $commissionSysteme): self
    {
        $this->commissionSysteme = $commissionSysteme;

        return $this;
    }

    public function getCommissionEtat(): ?int
    {
        return $this->commissionEtat;
    }

    public function setCommissionEtat(int $commissionEtat): self
    {
        $this->commissionEtat = $commissionEtat;

        return $this;
    }

    public function getFraisEnvoie(): ?int
    {
        return $this->fraisEnvoie;
    }

    public function setFraisEnvoie(int $fraisEnvoie): self
    {
        $this->fraisEnvoie = $fraisEnvoie;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDateRetrait(): ?\DateTimeInterface
    {
        return $this->dateRetrait;
    }

    public function setDateRetrait(\DateTimeInterface $dateRetrait): self
    {
        $this->dateRetrait = $dateRetrait;

        return $this;
    }

    public function getUseretrait(): ?User
    {
        return $this->useretrait;
    }

    public function setUseretrait(?User $useretrait): self
    {
        $this->useretrait = $useretrait;

        return $this;
    }


    public function getCommissionRetrait(): ?int
    {
        return $this->commissionRetrait;
    }

    public function setCommissionRetrait(int $commissionRetrait): self
    {
        $this->commissionRetrait = $commissionRetrait;

        return $this;
    }

    public function getetatCode(): ?string
    {
        return $this->etatCode;
    }

    public function setetatCode(string $etatCode): self
    {
        $this->etatCode = $etatCode;

        return $this;
    }

    public function getTypePieceB(): ?string
    {
        return $this->typePieceB;
    }

    public function setTypePieceB(string $typePieceB): self
    {
        $this->typePieceB = $typePieceB;

        return $this;
    }

    public function getNumPieceB(): ?string
    {
        return $this->numPieceB;
    }

    public function setNumPieceB(string $numPieceB): self
    {
        $this->numPieceB = $numPieceB;

        return $this;
    }
}
