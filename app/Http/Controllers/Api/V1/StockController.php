<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\StockService;
use App\Transformers\StockTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StockController extends Controller
{
    private StockService $stockService;

    public function __construct(StockService $service)
    {
        $this->stockService = $service;
    }

    public function index(): JsonResponse
    {
        $stock = $this->stockService->getStock();

        return fractal($stock, new StockTransformer())->respond();
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'productId' => 'unique:stock,product_id'
        ]);

        $productId = $request->get('productId');

        $product = $this->stockService->addProduct($productId);

        return fractal($product, new StockTransformer())->respond(201);
    }

    public function destroy(int $productId): JsonResponse
    {
        $this->stockService->removeProduct($productId);

        return response()->json([], 204);
    }
}
