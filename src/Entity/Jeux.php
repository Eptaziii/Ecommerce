<?php

namespace App\Entity;

use App\Repository\JeuxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JeuxRepository::class)]
class Jeux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column(length: 100)]
    private ?float $prix = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\OneToMany(targetEntity: Image::class, mappedBy: 'jeux', orphanRemoval: true)]
    private Collection $images;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'aimer')]
    private Collection $favoris;

    #[ORM\ManyToOne(inversedBy: 'jeuxes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categorie = null;

    #[ORM\OneToMany(targetEntity: Vouloir::class, mappedBy: 'jeu')]
    private Collection $vouloirs;

    #[ORM\OneToMany(targetEntity: Video::class, mappedBy: 'jeux')]
    private Collection $videos;

    #[ORM\OneToMany(targetEntity: Ajouter::class, mappedBy: 'jeux', orphanRemoval: true)]
    private Collection $ajouters;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->favoris = new ArrayCollection();
        $this->vouloirs = new ArrayCollection();
        $this->videos = new ArrayCollection();
        $this->ajouters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setJeux($this);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getJeux() === $this) {
                $image->setJeux(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getFavoris(): Collection
    {
        return $this->favoris;
    }

    public function addFavori(User $favori): static
    {
        if (!$this->favoris->contains($favori)) {
            $this->favoris->add($favori);
            $favori->addAimer($this);
        }

        return $this;
    }

    public function removeFavori(User $favori): static
    {
        if ($this->favoris->removeElement($favori)) {
            $favori->removeAimer($this);
        }

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection<int, Vouloir>
     */
    public function getVouloirs(): Collection
    {
        return $this->vouloirs;
    }

    public function addVouloir(Vouloir $vouloir): static
    {
        if (!$this->vouloirs->contains($vouloir)) {
            $this->vouloirs->add($vouloir);
            $vouloir->setJeu($this);
        }

        return $this;
    }

    public function removeVouloir(Vouloir $vouloir): static
    {
        if ($this->vouloirs->removeElement($vouloir)) {
            // set the owning side to null (unless already changed)
            if ($vouloir->getJeu() === $this) {
                $vouloir->setJeu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Video>
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(Video $video): static
    {
        if (!$this->videos->contains($video)) {
            $this->videos->add($video);
            $video->setJeux($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): static
    {
        if ($this->videos->removeElement($video)) {
            // set the owning side to null (unless already changed)
            if ($video->getJeux() === $this) {
                $video->setJeux(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ajouter>
     */
    public function getAjouters(): Collection
    {
        return $this->ajouters;
    }

    public function addAjouter(Ajouter $ajouter): static
    {
        if (!$this->ajouters->contains($ajouter)) {
            $this->ajouters->add($ajouter);
            $ajouter->setJeux($this);
        }

        return $this;
    }

    public function removeAjouter(Ajouter $ajouter): static
    {
        if ($this->ajouters->removeElement($ajouter)) {
            // set the owning side to null (unless already changed)
            if ($ajouter->getJeux() === $this) {
                $ajouter->setJeux(null);
            }
        }

        return $this;
    }

    
}
