<?php

namespace App\Models;

use App\Interfaces\MoneyInterface;
use App\Interfaces\ProductInterface;
use JsonSerializable;

class Product implements ProductInterface
{
    private int $id;
    private string $name;
    private int $available;
    private MoneyInterface $price;
    private float $vatRate;
    private string $image;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setAvailable(int $available): self
    {
        $this->available = $available;
        return $this;
    }

    public function getAvailable(): int
    {
        return $this->available;
    }

    public function setPrice(MoneyInterface $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getPrice(): MoneyInterface
    {
        return $this->price;
    }

    public function setVatRate(float $vat): self
    {
        $this->vatRate = $vat;
        return $this;
    }

    public function getVatRate(): float
    {
        return $this->vatRate;
    }

    public function setImage(string $imageUrl): self
    {
        $this->image = $imageUrl;
        return $this;
    }

    public function getImage(): string
    {
        return $this->image;
    }
}
