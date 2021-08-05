<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 *
 *
 * @UniqueEntity(
 *     fields={"username"},
 *     message="l'identifiant existe deja"
 * )
 * @UniqueEntity(
 *     fields={"telephone"},
 *     message="Le numero existe deja"
 * )
 * @UniqueEntity(
 *     fields={"email"},
 *     message="L'email existe deja"
 * )
 * @UniqueEntity(
 *     fields={"numero_cni"},
 *     message="Le numero de CNI existe deja"
 * )
 *
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("info:user")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups("info:user")
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     * @Groups("info:user")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups("info:user")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("info:user")
     *
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("info:user")
     *
     */
    private $prenom;


    /**
     * @ORM\Column(type="date")
     * @Groups("info:user")
     */
    private $date_naissance;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Length(
     *     max= "9",
     *     maxMessage="erreur chiffre depasse",
     *     min= "9",
     *     minMessage="erreur chiffre manquant"
     * )
     * @Groups("info:user")
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("info:user")
     */
    private $email;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Length(
     *
     *     min="17",
     *     max="17"
     * )
     * @Groups("info:user")
     */
    private $numero_cni;

    /**
     * @ORM\Column(type="string", length=255)
     *
     */
    private $adresse;

    /**
     * @ORM\OneToOne(targetEntity=Client::class, cascade={"persist", "remove"})
     */
    private $client;

    /**
     * @ORM\OneToOne(targetEntity=Prestataire::class, cascade={"persist", "remove"})
     * @Groups("info:user")
     */
    private $prestataire;

    /**
     * @ORM\OneToOne(targetEntity=Livreur::class, cascade={"persist", "remove"})
     */
    private $livreur;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

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
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(\DateTimeInterface $date_naissance): self
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
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

    public function getNumeroCni(): ?string
    {
        return $this->numero_cni;
    }

    public function setNumeroCni(string $numero_cni): self
    {
        $this->numero_cni = $numero_cni;

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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getPrestataire(): ?Prestataire
    {
        return $this->prestataire;
    }

    public function setPrestataire(?Prestataire $prestataire): self
    {
        $this->prestataire = $prestataire;

        return $this;
    }

    public function getLivreur(): ?Livreur
    {
        return $this->livreur;
    }

    public function setLivreur(?Livreur $livreur): self
    {
        $this->livreur = $livreur;

        return $this;
    }

}