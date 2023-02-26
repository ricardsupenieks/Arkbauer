<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Services\CartService;
use App\Transformers\CartTransformer;
use App\Transformers\ProductTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private CartService $cartService;

    public function __construct(CartService $service)
    {
        $this->cartService = $service;
    }

    public function index(): JsonResponse
    {
        $products = $this->cartService->getProducts();

        $cart = new Cart();

        foreach ($products as $product) {
            $cart->addProduct($product);
        }
        return fractal($cart, new CartTransformer())->respond();
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
           'productId' => 'unique:cart,product_id'
        ]);

        $productAdded = $this->cartService->addProduct($request->get('productId'));

        return fractal($productAdded, new ProductTransformer())->respond(201);
    }

    public function destroy(int $productId): JsonResponse
    {
        $this->cartService->removeProduct($productId);

        return response()->json([], 204);
    }
}
