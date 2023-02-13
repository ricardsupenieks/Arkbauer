<?php

namespace App\Services;

use App\Repositories\CartRepository;

class CartService
{

    private CartRepository $cartRepository;

    public function __construct()
    {
        $this->cartRepository = new CartRepository();
    }

    public function getProducts(): array
    {
        return $this->cartRepository->getProducts();
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
