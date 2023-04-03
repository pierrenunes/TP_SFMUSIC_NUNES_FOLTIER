<?php

namespace App\Entity;

use App\Repository\MusiqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MusiqueRepository::class)]
class Musique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titreMusique = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $Date = null;

    #[ORM\ManyToMany(targetEntity: Genre::class, inversedBy: 'musiques')]
    private Collection $Genre;

    #[ORM\ManyToOne(inversedBy: 'musiques')]
    private ?Artiste $Artiste = null;

    #[ORM\ManyToOne(inversedBy: 'musiques')]
    private ?Album $Album = null;

    #[ORM\ManyToMany(targetEntity: Playlist::class, inversedBy: 'musiques')]
    private Collection $Playlist;

    public function __construct()
    {
        $this->Genre = new ArrayCollection();
        $this->Playlist = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreMusique(): ?string
    {
        return $this->titreMusique;
    }

    public function setTitreMusique(string $titreMusique): self
    {
        $this->titreMusique = $titreMusique;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

    /**
     * @return Collection<int, Genre>
     */
    public function getGenre(): Collection
    {
        return $this->Genre;
    }

    public function addGenre(Genre $genre): self
    {
        if (!$this->Genre->contains($genre)) {
            $this->Genre->add($genre);
        }

        return $this;
    }

    public function removeGenre(Genre $genre): self
    {
        $this->Genre->removeElement($genre);

        return $this;
    }

    public function getArtiste(): ?Artiste
    {
        return $this->Artiste;
    }

    public function setArtiste(?Artiste $Artiste): self
    {
        $this->Artiste = $Artiste;

        return $this;
    }

    public function getAlbum(): ?Album
    {
        return $this->Album;
    }

    public function setAlbum(?Album $Album): self
    {
        $this->Album = $Album;

        return $this;
    }

    /**
     * @return Collection<int, Playlist>
     */
    public function getPlaylist(): Collection
    {
        return $this->Playlist;
    }

    public function addPlaylist(Playlist $playlist): self
    {
        if (!$this->Playlist->contains($playlist)) {
            $this->Playlist->add($playlist);
        }

        return $this;
    }

    public function removePlaylist(Playlist $playlist): self
    {
        $this->Playlist->removeElement($playlist);

        return $this;
    }
}
