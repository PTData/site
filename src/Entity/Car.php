<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $brand = null;

    #[ORM\Column(length: 255)]
    private ?string $model = null;

    #[ORM\Column(length: 255)]
    private ?string $fuel = null;

    #[ORM\Column]
    private ?int $cc = null;

    #[ORM\Column]
    private ?int $co2 = null;

    #[ORM\Column]
    private ?float $consume = null;

    #[ORM\Column(length: 255)]
    private ?string $shifts = null;

    #[ORM\Column]
    private ?int $power = null;

    #[ORM\Column(length: 255)]
    private ?string $engine_model = null;

    #[ORM\Column(length: 255)]
    private ?string $sub_model = null;

    /**
     * @var Collection<int, Image>
     */
    #[ORM\OneToMany(targetEntity: Image::class, mappedBy: 'car')]
    private Collection $description;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $url = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $notes = null;

    public function __construct()
    {
        $this->description = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getFuel(): ?string
    {
        return $this->fuel;
    }

    public function setFuel(string $fuel): static
    {
        $this->fuel = $fuel;

        return $this;
    }

    public function getCc(): ?int
    {
        return $this->cc;
    }

    public function setCc(int $cc): static
    {
        $this->cc = $cc;

        return $this;
    }

    public function getCo2(): ?int
    {
        return $this->co2;
    }

    public function setCo2(int $co2): static
    {
        $this->co2 = $co2;

        return $this;
    }

    public function getConsume(): ?float
    {
        return $this->consume;
    }

    public function setConsume(float $consume): static
    {
        $this->consume = $consume;

        return $this;
    }

    public function getShifts(): ?string
    {
        return $this->shifts;
    }

    public function setShifts(string $shifts): static
    {
        $this->shifts = $shifts;

        return $this;
    }

    public function getPower(): ?int
    {
        return $this->power;
    }

    public function setPower(int $power): static
    {
        $this->power = $power;

        return $this;
    }

    public function getEngineModel(): ?string
    {
        return $this->engine_model;
    }

    public function setEngineModel(string $engine_model): static
    {
        $this->engine_model = $engine_model;

        return $this;
    }

    public function getSubModel(): ?string
    {
        return $this->sub_model;
    }

    public function setSubModel(string $sub_model): static
    {
        $this->sub_model = $sub_model;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getDescription(): Collection
    {
        return $this->description;
    }

    public function addDescription(Image $description): static
    {
        if (!$this->description->contains($description)) {
            $this->description->add($description);
            $description->setCar($this);
        }

        return $this;
    }

    public function removeDescription(Image $description): static
    {
        if ($this->description->removeElement($description)) {
            // set the owning side to null (unless already changed)
            if ($description->getCar() === $this) {
                $description->setCar(null);
            }
        }

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(string $notes): static
    {
        $this->notes = $notes;

        return $this;
    }
}
