<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ServiceRepository::class)
 * @Vich\Uploadable()
 */
class Service
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
    private $nom;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $tarifs;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string|null
     */
    private $realisation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lieu;


    /**
     * @ORM\ManyToOne(targetEntity=Domaine::class, inversedBy="services")
     */
    private $domaine;

    /**
     * @ORM\ManyToOne(targetEntity=Prestataire::class, inversedBy="services")
     */
    private $prestataire;



    /**
     * @ORM\Column(type="integer")
     */
    private $contact;

    /**
     * @Vich\UploadableField(mapping="services",fileNameProperty="realisation")
     * @var File | null
     *
     */
    private $imageFile;

    /**
     * @ORM\OneToMany(targetEntity=Publication::class, mappedBy="service")
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTarifs(): ?float
    {
        return $this->tarifs;
    }

    public function setTarifs(float $tarifs): self
    {
        $this->tarifs = $tarifs;

        return $this;
    }

    public function getRealisation(): ?string
    {
        return $this->realisation;
    }

    public function setRealisation(string $realisation): self
    {
        $this->realisation = $realisation;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }


    public function getDomaine(): ?Domaine
    {
        return $this->domaine;
    }

    public function setDomaine(?Domaine $domaine): self
    {
        $this->domaine = $domaine;

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
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param File|null $imageFile
     * @return Service
     */
    public function setImageFile(?File $imageFile): Service
    {
        $this->imageFile = $imageFile;
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
            $publication->setService($this);
        }

        return $this;
    }

    public function removePublication(Publication $publication): self
    {
        if ($this->publications->removeElement($publication)) {
            // set the owning side to null (unless already changed)
            if ($publication->getService() === $this) {
                $publication->setService(null);
            }
        }

        return $this;
    }




}