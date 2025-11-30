<?php

namespace App\Entity;

use App\Repository\ClientPasswordRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientPasswordRepository::class)]
class ClientPassword
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'password', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $clientid = null;

    #[ORM\Column(length: 100)]
    private ?string $password = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientid(): ?Client
    {
        return $this->clientid;
    }

    public function setClientid(Client $clientid): static
    {
        $this->clientid = $clientid;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }
}
