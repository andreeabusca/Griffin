<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 18, scale: 4)]
    private ?string $amount = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 4)]
    private ?string $feeAmount = null;

    #[ORM\Column(length: 20)]
    private ?string $status = null;

    #[ORM\Column(length: 50)]
    private ?string $referenceNumber = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $transactionDate = null;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Account $senderAccount = null;

    #[ORM\ManyToOne(inversedBy: 'incoming_transactions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Account $receiverAccount = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getFeeAmount(): ?string
    {
        return $this->feeAmount;
    }

    public function setFeeAmount(string $feeAmount): static
    {
        $this->feeAmount = $feeAmount;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getReferenceNumber(): ?string
    {
        return $this->referenceNumber;
    }

    public function setReferenceNumber(string $referenceNumber): static
    {
        $this->referenceNumber = $referenceNumber;

        return $this;
    }

    public function getTransactionDate(): ?\DateTimeImmutable
    {
        return $this->transactionDate;
    }

    public function setTransactionDate(\DateTimeImmutable $transactionDate): static
    {
        $this->transactionDate = $transactionDate;

        return $this;
    }

    public function getSenderAccount(): ?Account
    {
        return $this->senderAccount;
    }

    public function setSenderAccount(?Account $senderAccount): static
    {
        $this->senderAccount = $senderAccount;

        return $this;
    }

    public function getReceiverAccount(): ?Account
    {
        return $this->receiverAccount;
    }

    public function setReceiverAccount(?Account $receiverAccount): static
    {
        $this->receiverAccount = $receiverAccount;

        return $this;
    }
}
