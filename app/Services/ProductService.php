<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\JsonResponse;

class ProductService
{
    private ProductRepository $productRepository;

    public function __construct()
    {
        $this->productRepository = new ProductRepository();
    }

    public function getAll(): JsonResponse
    {
        return $this->productRepository->getAll();
    }

    public function store(Product $product): JsonResponse
    {
        return $this->productRepository->store($product);
    }

    public function delete(int $productId): JsonResponse
    {
        return $this->productRepository->delete($productId);
    }

    public function update(Product $product,int $productId): JsonResponse
    {
        return $this->productRepository->update($product, $productId);
    }

    public function getOne(int $productId): JsonResponse
    {
        return $this->productRepository->getOne($productId);
    }
}
