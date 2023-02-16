<?php

namespace App\Transformers;

use App\Models\Product;
use League\Fractal\TransformerAbstract;

class StockTransformer extends TransformerAbstract
{
    public function transform(Product $product): array
    {
        return [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'price' => $product->getPrice()->getCents(),
            'vatRate' => $product->getVatRate(),
            'available' => $product->getAvailable(),
            'image' => $product->getImage(),
        ];
    }
}
