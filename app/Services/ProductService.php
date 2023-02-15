<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;

class ProductService
{
    private ProductRepository $productRepository;

    public function __construct()
    {
        $this->productRepository = new ProductRepository();
    }

    public function getAll(): array
    {
        return $this->productRepository->getAll();
    }

    public function store(Product $product): array
    {
        return $this->productRepository->store($product);
    }

    public function delete(int $productId): void
    {
        $this->productRepository->delete($productId);
    }

    public function update(Product $product,int $productId): array
    {
        return $this->productRepository->update($product, $productId);
    }

    public function getOne(int $productId): array
    {
        return $this->productRepository->getOne($productId);
    }
}
