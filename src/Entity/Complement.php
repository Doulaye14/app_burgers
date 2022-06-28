<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ComplementRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ComplementRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name:"type",type:"string")]
#[ORM\DiscriminatorMap(["boisson"=>"Boisson","frites"=>"Frites"])]
#[ApiResource]
class Complement extends Produit
{
    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["F:write"])]
    private $categorie;

    public function __construct()
    {
        $cat = explode("\\",get_called_class());
        $this->categorie = $cat[2];
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
}
