<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model implements StockInterface
{
    use HasFactory;

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
}
