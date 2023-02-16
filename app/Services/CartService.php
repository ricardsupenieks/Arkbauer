<?php

namespace App\Services;

use App\Models\Money;
use App\Models\Product;
use App\Repositories\CartRepository;
use App\Repositories\ProductRepository;

class CartService
{
    private CartRepository $cartRepository;
    private ProductRepository $productRepository;

    public function __construct(CartRepository $cartRepository, ProductRepository $productRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
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
            $productInformation = $this->productRepository->getOne($singleProductId)[0];

            $product = new Product();
            $price = (new Money())->setCents($productInformation->price);

            $product->setId($productInformation->id);
            $product->setName($productInformation->name);
            $product->setVatRate($productInformation->vat_rate);
            $product->setPrice($price);
            $product->setAvailable($productInformation->available);
            $product->setImage($productInformation->image);

            $products [] = $product;
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
