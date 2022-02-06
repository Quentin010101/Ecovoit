<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'boolean')]
    private $messageReport;

    #[ORM\Column(type: 'boolean')]
    private $messageSenderDelete;

    #[ORM\Column(type: 'boolean')]
    private $messageRecieverDelete;

    #[ORM\Column(type: 'date')]
    private $messageDate;

    #[ORM\Column(type: 'string', length: 255)]
    private $messageContent;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'messages')]
    private $userSender;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'messages')]
    private $userReciever;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessageReport(): ?bool
    {
        return $this->messageReport;
    }

    public function setMessageReport(bool $messageReport): self
    {
        $this->messageReport = $messageReport;

        return $this;
    }

    public function getMessageSenderDelete(): ?bool
    {
        return $this->messageSenderDelete;
    }

    public function setMessageSenderDelete(bool $messageSenderDelete): self
    {
        $this->messageSenderDelete = $messageSenderDelete;

        return $this;
    }

    public function getMessageRecieverDelete(): ?bool
    {
        return $this->messageRecieverDelete;
    }

    public function setMessageRecieverDelete(bool $messageRecieverDelete): self
    {
        $this->messageRecieverDelete = $messageRecieverDelete;

        return $this;
    }

    public function getMessageDate(): ?\DateTimeInterface
    {
        return $this->messageDate;
    }

    public function setMessageDate(\DateTimeInterface $messageDate): self
    {
        $this->messageDate = $messageDate;

        return $this;
    }

    public function getMessageContent(): ?string
    {
        return $this->messageContent;
    }

    public function setMessageContent(string $messageContent): self
    {
        $this->messageContent = $messageContent;

        return $this;
    }

    public function getUserSender(): ?User
    {
        return $this->userSender;
    }

    public function setUserSender(?User $userSender): self
    {
        $this->userSender = $userSender;

        return $this;
    }

    public function getUserReciever(): ?User
    {
        return $this->userReciever;
    }

    public function setUserReciever(?User $userReciever): self
    {
        $this->userReciever = $userReciever;

        return $this;
    }
}
