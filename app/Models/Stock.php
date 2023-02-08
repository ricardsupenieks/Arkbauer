<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\Relations\HasMany;

class Stock implements StockInterface // extends Model
{
    use HasFactory;

    private array $products = [];

//    protected $fillable = [
//        'product_id'
//    ];

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


//    public function products(): HasMany
//    {
//        return $this->hasMany(Product::class);
//    }
}
