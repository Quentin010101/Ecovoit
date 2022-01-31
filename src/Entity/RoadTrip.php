<?php

namespace App\Entity;

use App\Repository\RoadTripRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoadTripRepository::class)]
class RoadTrip
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $startingPlace;

    #[ORM\Column(type: 'string', length: 255)]
    private $endingPlace;

    #[ORM\Column(type: 'integer')]
    private $tripDistance;

    #[ORM\Column(type: 'integer')]
    private $tripDuration;

    #[ORM\Column(type: 'datetime')]
    private $startingTime;

    #[ORM\Column(type: 'datetime')]
    private $endingTime;

    #[ORM\Column(type: 'datetime')]
    private $tripDate;

    #[ORM\Column(type: 'datetime')]
    private $postDate;

    #[ORM\Column(type: 'integer')]
    private $numberSeat;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'roadTrips')]
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartingPlace(): ?string
    {
        return $this->startingPlace;
    }

    public function setStartingPlace(string $startingPlace): self
    {
        $this->startingPlace = $startingPlace;

        return $this;
    }

    public function getEndingPlace(): ?string
    {
        return $this->endingPlace;
    }

    public function setEndingPlace(string $endingPlace): self
    {
        $this->endingPlace = $endingPlace;

        return $this;
    }

    public function getTripDistance(): ?int
    {
        return $this->tripDistance;
    }

    public function setTripDistance(int $tripDistance): self
    {
        $this->tripDistance = $tripDistance;

        return $this;
    }

    public function getTripDuration(): ?int
    {
        return $this->tripDuration;
    }

    public function setTripDuration(int $tripDuration): self
    {
        $this->tripDuration = $tripDuration;

        return $this;
    }

    public function getStartingTime(): ?\DateTimeInterface
    {
        return $this->startingTime;
    }

    public function setStartingTime(\DateTimeInterface $startingTime): self
    {
        $this->startingTime = $startingTime;

        return $this;
    }

    public function getEndingTime(): ?\DateTimeInterface
    {
        return $this->endingTime;
    }

    public function setEndingTime(\DateTimeInterface $endingTime): self
    {
        $this->endingTime = $endingTime;

        return $this;
    }

    public function getTripDate(): ?\DateTimeInterface
    {
        return $this->tripDate;
    }

    public function setTripDate(\DateTimeInterface $tripDate): self
    {
        $this->tripDate = $tripDate;

        return $this;
    }

    public function getPostDate(): ?\DateTimeInterface
    {
        return $this->postDate;
    }

    public function setPostDate(\DateTimeInterface $postDate): self
    {
        $this->postDate = $postDate;

        return $this;
    }

    public function getNumberSeat(): ?int
    {
        return $this->numberSeat;
    }

    public function setNumberSeat(int $numberSeat): self
    {
        $this->numberSeat = $numberSeat;

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
