<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{

    private CartService $cartService;

    public function __construct()
    {
        $this->cartService = new CartService();
    }

    public function index(): JsonResponse
    {
        $products = $this->cartService->getProducts();

        return response()->json($products);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
           'productId' => 'unique:cart,product_id'
        ]);

        $productAdded = $this->cartService->addProduct($request->get('productId'));

        return response()->json($productAdded, 201);
    }

    public function destroy(int $productId): JsonResponse
    {
        $this->cartService->removeProduct($productId);

        return response()->json([], 204);
    }
}
