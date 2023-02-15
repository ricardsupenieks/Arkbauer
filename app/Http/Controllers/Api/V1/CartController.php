<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Money;
use App\Models\Product;
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
        $productsInCart = $this->cartService->getProducts();

        return response()->json($productsInCart);
    }

    public function store(Request $request): JsonResponse
    {
        $productId = $request->get('productId');

        $productAdded = $this->cartService->addProduct($productId);

        if ($productAdded === []) {
            return response()->json($productAdded);
        }
        return response()->json($productAdded, 201);
    }

    public function destroy(int $productId): JsonResponse
    {
        $this->cartService->removeProduct($productId);

        return response()->json([], 204);
    }
}
