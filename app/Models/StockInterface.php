<?php

namespace App\Models;

interface StockInterface
{
    public function addProduct(ProductInterface $product): self;

    public function removeProduct(ProductInterface $product): self;

    public function getProducts(): array;
}
