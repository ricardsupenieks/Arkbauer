<?php

namespace App\Services;

use App\Repositories\CartRepository;
use App\Repositories\ProductRepository;

class CartService
{

    private CartRepository $cartRepository;
    private ProductRepository $productRepository;

    public function __construct()
    {
        $this->cartRepository = new CartRepository();
        $this->productRepository = new ProductRepository();
    }

    public function getProducts(): array
    {
        $cart = $this->cartRepository->getCart();

        $productIds = [];
        $products = [];

        foreach ($cart as $product) {
            $productIds []= $product->product_id;
        }

        foreach ($productIds as $singleProductId) {
            $products []= $this->productRepository->getOne($singleProductId)[0];
        }

        return $products;
    }

    public function addProduct(int $productId): array
    {
        return $this->cartRepository->addProduct($productId);
    }

    public function removeProduct(int $productId): void
    {
        $this->cartRepository->removeProduct($productId);
    }
}
