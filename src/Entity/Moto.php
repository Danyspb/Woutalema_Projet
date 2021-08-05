<?php

namespace App\Entity;

use App\Repository\MotoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MotoRepository::class)
 */
class Moto
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("info:moto")
     * @Assert\NotBlank()
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("info:moto")
     * @Assert\NotBlank()
     */
    private $marque;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("info:moto")
     * @Assert\NotBlank()
     */
    private $model;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("info:moto")
     * @Assert\NotBlank()
     */
    private $matricule;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("info:moto")
     * @Assert\NotBlank()
     */
    private $assurance;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("info:moto")
     * @Assert\NotBlank()
     */
    private $num_carte_grise;

    /**
     * @ORM\ManyToOne(targetEntity=Livreur::class, inversedBy="motos",cascade={"persist"})
     * @Groups("info:moto")
     * @Assert\NotBlank()
     */
    private $livreur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getAssurance(): ?string
    {
        return $this->assurance;
    }

    public function setAssurance(string $assurance): self
    {
        $this->assurance = $assurance;

        return $this;
    }

    public function getNumCarteGrise(): ?string
    {
        return $this->num_carte_grise;
    }

    public function setNumCarteGrise(string $num_carte_grise): self
    {
        $this->num_carte_grise = $num_carte_grise;

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