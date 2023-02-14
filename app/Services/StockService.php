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
        $this->productRepository = new ProductRepository();
    }

    public function getStock(): array
    {
        $stock = $this->stockRepository->getStock();

        $productIds = [];
        $products = [];

        foreach ($stock as $product) {
            $productIds []= $product->product_id;
        }

        foreach ($productIds as $singleProductId) {
            $products []= $this->productRepository->getOne($singleProductId)[0];
        }

        return $products;
    }

    public function addProduct(int $productId): array
    {
        return $this->stockRepository->addProduct($productId);
    }

    public function removeProduct(int $productId): void
    {
        $this->stockRepository->removeProduct($productId);
    }
}
