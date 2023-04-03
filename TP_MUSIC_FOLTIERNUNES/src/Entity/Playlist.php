<?php

namespace App\Entity;

use App\Repository\PlaylistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaylistRepository::class)]
class Playlist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titrePlaylist = null;

    #[ORM\ManyToMany(targetEntity: Musique::class, mappedBy: 'Playlist')]
    private Collection $musiques;

    #[ORM\ManyToMany(targetEntity: Utilisateur::class, inversedBy: 'playlists')]
    private Collection $Utilisateur;

    public function __construct()
    {
        $this->musiques = new ArrayCollection();
        $this->Utilisateur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitrePlaylist(): ?string
    {
        return $this->titrePlaylist;
    }

    public function setTitrePlaylist(string $titrePlaylist): self
    {
        $this->titrePlaylist = $titrePlaylist;

        return $this;
    }

    /**
     * @return Collection<int, Musique>
     */
    public function getMusiques(): Collection
    {
        return $this->musiques;
    }

    public function addMusique(Musique $musique): self
    {
        if (!$this->musiques->contains($musique)) {
            $this->musiques->add($musique);
            $musique->addPlaylist($this);
        }

        return $this;
    }

    public function removeMusique(Musique $musique): self
    {
        if ($this->musiques->removeElement($musique)) {
            $musique->removePlaylist($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getUtilisateur(): Collection
    {
        return $this->Utilisateur;
    }

    public function addUtilisateur(Utilisateur $utilisateur): self
    {
        if (!$this->Utilisateur->contains($utilisateur)) {
            $this->Utilisateur->add($utilisateur);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): self
    {
        $this->Utilisateur->removeElement($utilisateur);

        return $this;
    }
}
