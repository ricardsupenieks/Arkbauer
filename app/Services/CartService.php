<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Money;
use App\Models\Product;
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
        $productsInCart = [];

        foreach ($cart as $product) {
            $productIds []= $product->product_id;
        }

        foreach ($productIds as $singleProductId) {
            $productsInCart []= $this->productRepository->getOne($singleProductId)[0];
        }
        $cart = new Cart();

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

        return [
            'products' => $products,
            'subtotal' => $cart->getSubtotal()->getEuros(),
            'vatAmount' => $cart->getVatAmount()->getEuros(),
            'total' => $cart->getTotal()->getEuros()
        ];
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
