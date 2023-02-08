<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart implements CartInterface // extends Model
{
    use HasFactory;

//    protected $fillable = [
//        'product_id'
//    ];

    private array $products = [];

    public function addProduct(ProductInterface $product): self
    {
        $this->products[] = $product;
        return $this;
    }

    public function removeProduct(ProductInterface $product): self
    {
        $key = array_search($product, $this->products);
        if ($key) {
            unset($this->products[$key]);
        }
        return $this;
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    public function getSubtotal(): MoneyInterface
    {
        $subtotal = new Money();
        $subtotal->setCents(0);

        foreach ($this->products as $product) {
            $price = $product->getPrice();
            $subtotal->setCents($subtotal->getCents() + $price->getCents());
        }

        return $subtotal;
    }

    public function getVatAmount(): MoneyInterface
    {
        $subtotal = $this->getSubtotal();
        $vatAmount = new Money();
        $vatAmount->setCents($subtotal->getCents() * $this->getAverageVatRate());

        return $vatAmount;
    }

    public function getTotal(): MoneyInterface
    {
        $subtotal = $this->getSubtotal();
        $vatAmount = $this->getVatAmount();
        $total = new Money();
        $total->setCents($subtotal->getCents() + $vatAmount->getCents());

        return $total;
    }

    private function getAverageVatRate(): float
    {
        $totalVatRate = 0;
        $numberOfProducts = count($this->products);

        foreach ($this->products as $product) {
            $totalVatRate += $product->getVatRate();
        }

        return $totalVatRate / $numberOfProducts;
    }


//    public function products(): HasMany
//    {
//        return $this->hasMany(Product::class);
//    }
}
