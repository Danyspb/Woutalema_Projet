<?php

namespace App\Entity;

use App\Repository\PrestataireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=PrestataireRepository::class)
 * @Vich\Uploadable()
 */
class Prestataire implements \Serializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("info:user")
     */
    private $id;
    /**
     * @var File|null
     * @Vich\UploadableField(mapping="diplomes", fileNameProperty="diplome")
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $niveau_etude;

    /**
     * @ORM\Column(type="string", length=255, nullable="true")
     * @var string|null
     */
    private $diplome;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lieu_atelier;

    /**
     * @ORM\OneToMany(targetEntity=Service::class, mappedBy="prestataire")
     */
    private $services;

    public function __construct()
    {
        $this->services = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNiveauEtude(): ?string
    {
        return $this->niveau_etude;
    }

    public function setNiveauEtude(string $niveau_etude): self
    {
        $this->niveau_etude = $niveau_etude;

        return $this;
    }

    public function getDiplome(): ?string
    {
        return $this->diplome;
    }

    public function setDiplome(string $diplome): self
    {
        $this->diplome = $diplome;

        return $this;
    }

    public function getLieuAtelier(): ?string
    {
        return $this->lieu_atelier;
    }

    public function setLieuAtelier(string $lieu_atelier): self
    {
        $this->lieu_atelier = $lieu_atelier;

        return $this;
    }

    /**
     * @return Collection|Service[]
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): self
    {
        if (!$this->services->contains($service)) {
            $this->services[] = $service;
            $service->setPrestataire($this);
        }

        return $this;
    }

    public function removeService(Service $service): self
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getPrestataire() === $this) {
                $service->setPrestataire(null);
            }
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param File|null $imageFile
     * @return Prestataire
     */
    public function setImageFile(?File $imageFile): Prestataire
    {
        $this->imageFile = $imageFile;
        return $this;
    }


    /**
     * @inheritDoc
     */
    public function serialize()
    {
        // TODO: Implement serialize() method.
    }

    /**
     * @inheritDoc
     */
    public function unserialize($serialized)
    {
        // TODO: Implement unserialize() method.
    }
}