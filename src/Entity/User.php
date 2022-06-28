<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: UserRepository::class)]

#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name:"role",type:"string")]
#[ORM\DiscriminatorMap(["gestionnaire"=>"Gestionnaire","client"=>"Client","livreur"=>"Livreur"])]
#[ApiResource(
    collectionOperations:["get","post"],
    itemOperations:["get","put"]
)]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["burger:read:all","write","G:read:all","L:read:all","C:read:all"])]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Groups([
            "burger:read:all","write",
            "G:read:simple","G:write","G:read:all",
            "L:read:simple","L:write","L:read:all",
            "C:read:simple","C:write","C:read:all"
        ])]
    protected $email;

    #[ORM\Column(type: 'json')]
    #[Groups([
        "G:read:all",
        "L:read:all",
        "C:read:all"
    ])]
    protected $roles = [];

    #[ORM\Column(type: 'string')]
    protected $password;

    #[SerializedName("password")]
    #[Groups(["G:write","L:write","C:write"])]
    protected $plainPassword;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        "G:read:simple","G:write","G:read:all",
        "L:read:simple","L:write","L:read:all",
        "C:read:simple","C:write","C:read:all"
    ])]
    protected $prenom;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        "G:read:simple","G:write","G:read:all",
        "L:read:simple","L:write","L:read:all",
        "C:read:simple","C:write","C:read:all"
    ])]
    protected $nom;

    public function __construct()
    {
        $tab = explode("\\", get_called_class());
        $tab = strtoupper($tab[2]);
        $this->roles [] = "ROLE_".$tab;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles []= "ROLE_VISITEUR";

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of plainPassword
     */ 
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set the value of plainPassword
     *
     * @return  self
     */ 
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }
}
