<?php

namespace App\Entity;

use App\Repository\AccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccountRepository::class)]
class Account
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $accountType = null;

    #[ORM\Column(length: 7)]
    private ?string $currency = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 18, scale: 4)]
    private ?string $balance = null;

    #[ORM\Column(length: 20)]
    private ?string $accountStatus = null;

    #[ORM\ManyToOne(inversedBy: 'accounts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    /**
     * @var Collection<int, Transaction>
     */
    #[ORM\OneToMany(targetEntity: Transaction::class, mappedBy: 'senderAccount', orphanRemoval: true)]
    private Collection $transactions;

    /**
     * @var Collection<int, Transaction>
     */
    #[ORM\OneToMany(targetEntity: Transaction::class, mappedBy: 'receiverAccount', orphanRemoval: true)]
    private Collection $incoming_transactions;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
        $this->incoming_transactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccountType(): ?string
    {
        return $this->accountType;
    }

    public function setAccountType(?string $accountType): static
    {
        $this->accountType = $accountType;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function getBalance(): ?string
    {
        return $this->balance;
    }

    public function setBalance(string $balance): static
    {
        $this->balance = $balance;

        return $this;
    }

    public function getAccountStatus(): ?string
    {
        return $this->accountStatus;
    }

    public function setAccountStatus(string $accountStatus): static
    {
        $this->accountStatus = $accountStatus;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection<int, Transaction>
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): static
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions->add($transaction);
            $transaction->setSenderAccount($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): static
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getSenderAccount() === $this) {
                $transaction->setSenderAccount(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Transaction>
     */
    public function getIncomingTransactions(): Collection
    {
        return $this->incoming_transactions;
    }

    public function addIncomingTransaction(Transaction $incomingTransaction): static
    {
        if (!$this->incoming_transactions->contains($incomingTransaction)) {
            $this->incoming_transactions->add($incomingTransaction);
            $incomingTransaction->setReceiverAccount($this);
        }

        return $this;
    }

    public function removeIncomingTransaction(Transaction $incomingTransaction): static
    {
        if ($this->incoming_transactions->removeElement($incomingTransaction)) {
            // set the owning side to null (unless already changed)
            if ($incomingTransaction->getReceiverAccount() === $this) {
                $incomingTransaction->setReceiverAccount(null);
            }
        }

        return $this;
    }
}
