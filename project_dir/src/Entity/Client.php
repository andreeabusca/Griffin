<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $clientid = null;

    #[ORM\Column(length: 100)]
    private ?string $firstname = null;

    #[ORM\Column(length: 100)]
    private ?string $lastname = null;

    #[ORM\Column(length: 11)]
    private ?string $phone = null;

    #[ORM\Column(length: 100)]
    private ?string $email = null;

    #[ORM\Column(length: 200)]
    private ?string $address = null;

    #[ORM\OneToOne(mappedBy: 'clientid', cascade: ['persist', 'remove'])]
    private ?ClientPassword $password = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientid(): ?int
    {
        return $this->clientid;
    }

    public function setClientid(int $clientid): static
    {
        $this->clientid = $clientid;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getPassword(): ?ClientPassword
    {
        return $this->password;
    }

    public function setPassword(ClientPassword $password): static
    {
        // set the owning side of the relation if necessary
        if ($password->getClientid() !== $this) {
            $password->setClientid($this);
        }

        $this->password = $password;

        return $this;
    }
}
