<?php

namespace App\Models;

use App\Interfaces\CartInterface;
use App\Interfaces\MoneyInterface;
use App\Interfaces\ProductInterface;

class Cart implements CartInterface
{
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
        $totalVatAmount = new Money();
        $totalVatAmount->setCents(0);
        foreach($this->products as $product) {
           $totalVatAmount->setCents($totalVatAmount->getCents() + $product->getPrice()->getCents() * $product->getVatRate());
        }
        return $totalVatAmount;
    }

    public function getTotal(): MoneyInterface
    {
        $subtotal = $this->getSubtotal();
        $vatAmount = $this->getVatAmount();
        $total = new Money();
        $total->setCents($subtotal->getCents() + $vatAmount->getCents());

        return $total;
    }
}
