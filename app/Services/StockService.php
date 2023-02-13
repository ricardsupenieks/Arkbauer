<?php

namespace App\Services;

use App\Repositories\StockRepository;
use Illuminate\Http\JsonResponse;

class StockService
{
    private StockRepository $stockRepository;

    public function __construct()
    {
        $this->stockRepository = new StockRepository();
    }

    public function getStock(): array
    {
        return $this->stockRepository->getStock();
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
