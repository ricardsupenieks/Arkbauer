<?php

namespace App\Transformers;

use App\Models\Cart;
use League\Fractal\TransformerAbstract;

class CartTransformer extends TransformerAbstract
{
    public function transform(Cart $cart): array
    {
        return [
            'products' => $cart->getProducts(),
            'subtotal' => $cart->getSubtotal(),
            'vatAmount' => $cart->getVatAmount(),
            'total' => $cart->getTotal(),
        ];
    }
}
