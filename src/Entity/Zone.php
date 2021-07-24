<?php

namespace App\Entity;

use App\Repository\ZoneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ZoneRepository::class)
 */
class Zone
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $region;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $commune;

    /**
     * @ORM\Column(type="time")
     */
    private $horraire_debut;

    /**
     * @ORM\Column(type="time")
     */
    private $horraire_fin;

    /**
     * @ORM\ManyToOne(targetEntity=Livreur::class, inversedBy="zones")
     */
    private $livreur;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getCommune(): ?string
    {
        return $this->commune;
    }

    public function setCommune(string $commune): self
    {
        $this->commune = $commune;

        return $this;
    }

    public function getHorraireDebut(): ?\DateTimeInterface
    {
        return $this->horraire_debut;
    }

    public function setHorraireDebut(\DateTimeInterface $horraire_debut): self
    {
        $this->horraire_debut = $horraire_debut;

        return $this;
    }

    public function getHorraireFin(): ?\DateTimeInterface
    {
        return $this->horraire_fin;
    }

    public function setHorraireFin(\DateTimeInterface $horraire_fin): self
    {
        $this->horraire_fin = $horraire_fin;

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