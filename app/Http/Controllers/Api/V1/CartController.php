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
        $cart = new Cart();

        $productsInCart = $this->cartService->getProducts();

        $products = [];

        foreach ($productsInCart as $productInCart) {
            $product = new Product();
            $product->setName($productInCart->name);
            $product->setVatRate($productInCart->vat_rate);

            $price = (new Money())->setCents($productInCart->price);

            $product->setPrice($price);
            $product->setAvailable($productInCart->available);
            $product->setImage($productInCart->image);

            $cart->addProduct($product);

            $products []= [
                'id' => $productInCart->id,
                'name' => $product->getName(),
                'vatRate' => $product->getVatRate(),
                'price' => $product->getPrice()->getEuros(),
                'available' => $product->getAvailable(),
                'image' => $product->getImage()
            ];
        }

        return response()->json([
            'products' => $products,
            'subtotal' => $cart->getSubtotal()->getEuros(),
            'vatAmount' => $cart->getVatAmount()->getEuros(),
            'total' => $cart->getTotal()->getEuros()
        ]);
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
