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
        $stock = $this->stockService->getStock();

        return response()->json($stock);
    }

    public function store(Request $request): JsonResponse
    {
        $productId = $request->get('product_id');

        $stockAdded = $this->stockService->addProduct($productId);

        return response()->json($stockAdded, 201);
    }

    public function destroy(int $productId): JsonResponse
    {
        $this->stockService->removeProduct($productId);

        return response()->json([], 204);
    }
}
