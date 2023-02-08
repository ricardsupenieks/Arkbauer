<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product implements ProductInterface // extends Model
{
    use HasFactory;

//    protected $fillable = [
//      'name',
//      'available',
//      'price',
//      'vat'
//    ];

    private string $name;
    private int $available;
    private MoneyInterface $price;
    private float $vatRate;

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


//    public function cart(): BelongsTo
//    {
//        return $this->belongsTo(Cart::class);
//    }
//
//    public function stock(): BelongsTo
//    {
//        return $this->belongsTo(Stock::class);
//    }
}
