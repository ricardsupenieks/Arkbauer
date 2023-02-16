<?php

namespace App\Transformers;

use App\Models\Cart;
use League\Fractal\TransformerAbstract;

class CartTransformer extends TransformerAbstract
{
    public function transform(Cart $cart): array
    {
        $products = $cart->getProducts();

        $productsModified = [];

        foreach($products as $product) {
            $productsModified [] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'available' => $product->getAvailable(),
                'price' => $product->getPrice()->getCents(),
                'vatRate' => $product->getVatRate(),
                'image' => $product->getImage(),
            ];
        }

        return [
            'products' => $productsModified,
            'subtotal' => $cart->getSubtotal()->getCents(),
            'vatAmount' => $cart->getVatAmount()->getCents(),
            'total' => $cart->getTotal()->getCents(),
        ];
    }
}
