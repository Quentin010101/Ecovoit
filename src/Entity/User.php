<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Assert\NotBlank(message:"* L'email doit être obligatoirement renseigner")]
    #[Assert\Email(message:"* L'email renseigné n'est pas valid")]
    #[Assert\Length(max:50, maxMessage:"* L'email ne peux contenir que 50 caractères au maximum")]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank(message:"* Le mot de passe doit être obligatoirement renseigner")]
    #[Assert\Regex("/\w/", message:"* Le mot de passe doit contenir au moins un numérique")]
    #[Assert\Length(min:6 , minMessage:"* Votre mot de passe doit contenir au moins 6 caractères")]
    private $password;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message:"* Le prénom doit être obligatoirement renseigner")]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message:"* Le nom doit être obligatoirement renseigner")]
    private $surname;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $phoneNumber;

    #[ORM\Column(type: 'date')]
    private $date;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: Preference::class, cascade: ['persist', 'remove'])]
    private $preference;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: RoadTrip::class)]
    private $roadTrips;

    public function __construct()
    {
        $this->roadTrips = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?int $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPreference(): ?Preference
    {
        return $this->preference;
    }

    public function setPreference(?Preference $preference): self
    {
        // unset the owning side of the relation if necessary
        if ($preference === null && $this->preference !== null) {
            $this->preference->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($preference !== null && $preference->getUser() !== $this) {
            $preference->setUser($this);
        }

        $this->preference = $preference;

        return $this;
    }

    /**
     * @return Collection|RoadTrip[]
     */
    public function getRoadTrips(): Collection
    {
        return $this->roadTrips;
    }

    public function addRoadTrip(RoadTrip $roadTrip): self
    {
        if (!$this->roadTrips->contains($roadTrip)) {
            $this->roadTrips[] = $roadTrip;
            $roadTrip->setUser($this);
        }

        return $this;
    }

    public function removeRoadTrip(RoadTrip $roadTrip): self
    {
        if ($this->roadTrips->removeElement($roadTrip)) {
            // set the owning side to null (unless already changed)
            if ($roadTrip->getUser() === $this) {
                $roadTrip->setUser(null);
            }
        }

        return $this;
    }
}
