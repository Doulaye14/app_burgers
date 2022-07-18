<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LigneTailleRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LigneTailleRepository::class)]
#[ApiResource]
class LigneTaille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: LigneDeCommande::class, inversedBy: 'ligneTailles')]
    #[ORM\JoinColumn(nullable: false)]
    private $ligneDeCommande;

    #[ORM\ManyToOne(targetEntity: TailleBoisson::class, inversedBy: 'ligneTailles')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["c:r:all","c:r:simple","c:write"])]
    private $tailleBoisson;

    #[ORM\Column(type: 'integer')]
    #[Groups(["c:r:all","c:r:simple","c:write"])]
    private $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLigneDeCommande(): ?LigneDeCommande
    {
        return $this->ligneDeCommande;
    }

    public function setLigneDeCommande(?LigneDeCommande $ligneDeCommande): self
    {
        $this->ligneDeCommande = $ligneDeCommande;

        return $this;
    }

    public function getTailleBoisson(): ?TailleBoisson
    {
        return $this->tailleBoisson;
    }

    public function setTailleBoisson(?TailleBoisson $tailleBoisson): self
    {
        $this->tailleBoisson = $tailleBoisson;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
