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

    /**
     * @ORM\Column(type="integer")
     */
    private $contact;

    /**
     * @ORM\OneToMany(targetEntity=Publication::class, mappedBy="zone")
     */
    private $publications;

    public function __construct()
    {
        $this->publications = new ArrayCollection();
    }


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

    public function getContact(): ?int
    {
        return $this->contact;
    }

    public function setContact(int $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * @return Collection|Publication[]
     */
    public function getPublications(): Collection
    {
        return $this->publications;
    }

    public function addPublication(Publication $publication): self
    {
        if (!$this->publications->contains($publication)) {
            $this->publications[] = $publication;
            $publication->setZone($this);
        }

        return $this;
    }

    public function removePublication(Publication $publication): self
    {
        if ($this->publications->removeElement($publication)) {
            // set the owning side to null (unless already changed)
            if ($publication->getZone() === $this) {
                $publication->setZone(null);
            }
        }

        return $this;
    }

}