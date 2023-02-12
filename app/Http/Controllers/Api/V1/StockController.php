<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\StockService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StockController extends Controller
{
    private StockService $stockService;

    public function __construct()
    {
        $this->stockService = new StockService();
    }

    public function index(): JsonResponse
    {
        return $this->stockService->getStock();
    }

    public function store(Request $request): JsonResponse
    {
        $productId = $request->get('product_id');

        return $this->stockService->addProduct($productId);
    }

    public function destroy(int $productId): JsonResponse
    {
        return $this->stockService->removeProduct($productId);
    }
}
