<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Repositories\StockRepository;
use Illuminate\Http\JsonResponse;

class StockService
{
    private StockRepository $stockRepository;
    private ProductRepository $productRepository;

    public function __construct()
    {
        $this->stockRepository = new StockRepository();
    }

    public function getStock(): JsonResponse
    {
        $stockIds = $this->stockRepository->getStock();
        var_dump($stockIds);die;
        $products = $this->productRepository->getAll();
    }

    public function addProduct(int $productId): JsonResponse
    {
        return $this->stockRepository->addProduct($productId);
    }

    public function removeProduct(int $productId): JsonResponse
    {
        return $this->stockRepository->removeProduct($productId);
    }
}
