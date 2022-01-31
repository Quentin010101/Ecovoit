<?php

namespace App\Entity;

use App\Repository\PreferenceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PreferenceRepository::class)]
class Preference
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, options:['dafault_avatar.png'])]
    private $avatar;

    #[ORM\Column(type: 'boolean', options:[0])]
    private $petAllowed;

    #[ORM\Column(type: 'boolean', options:[0])]
    private $smokingAllowed;

    #[ORM\Column(type: 'string', length: 255, options:['Un peu de musique'])]
    private $music;

    #[ORM\Column(type: 'string', length: 255, options:['On peu discuter'])]
    private $talking;

    #[ORM\Column(type: 'string', length: 255, options:['light'])]
    private $theme;

    #[ORM\OneToOne(inversedBy: 'preference', targetEntity: User::class, cascade: ['persist', 'remove'])]
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getPetAllowed(): ?bool
    {
        return $this->petAllowed;
    }

    public function setPetAllowed(bool $petAllowed): self
    {
        $this->petAllowed = $petAllowed;

        return $this;
    }

    public function getSmokingAllowed(): ?bool
    {
        return $this->smokingAllowed;
    }

    public function setSmokingAllowed(bool $smokingAllowed): self
    {
        $this->smokingAllowed = $smokingAllowed;

        return $this;
    }

    public function getMusic(): ?string
    {
        return $this->music;
    }

    public function setMusic(string $music): self
    {
        $this->music = $music;

        return $this;
    }

    public function getTalking(): ?string
    {
        return $this->talking;
    }

    public function setTalking(string $talking): self
    {
        $this->talking = $talking;

        return $this;
    }

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(string $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
