<?php

namespace App\Entity;

use App\Repository\ValueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ValueRepository::class)]
class Value
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Car $car = null;

    #[ORM\Column]
    private ?float $monthly_payment = null;

    #[ORM\Column]
    private ?float $total_price = null;

    #[ORM\Column]
    private ?float $extra_value = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): static
    {
        $this->car = $car;

        return $this;
    }

    public function getMonthlyPayment(): ?float
    {
        return $this->monthly_payment;
    }

    public function setMonthlyPayment(float $monthly_payment): static
    {
        $this->monthly_payment = $monthly_payment;

        return $this;
    }

    public function getTotalPrice(): ?float
    {
        return $this->total_price;
    }

    public function setTotalPrice(float $total_price): static
    {
        $this->total_price = $total_price;

        return $this;
    }

    public function getExtraValue(): ?float
    {
        return $this->extra_value;
    }

    public function setExtraValue(float $extra_value): static
    {
        $this->extra_value = $extra_value;

        return $this;
    }
}
