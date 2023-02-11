<?php

namespace App\Repositories;

use App\Models\Money;
use App\Models\Product;
use App\Services\ProductService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductRepository
{
    public function getAll(): JsonResponse
    {
        $products = DB::select('select * from products');

        return response()->json($products);
    }

    public function store(Product $product): JsonResponse
    {
        DB::table('products')->insert([
            'name' => $product->getName(),
            'available' => $product->getAvailable(),
            'price' => $product->getPrice()->getCents(),
            'vat_rate' => $product->getVatRate(),
            'image_url' => $product->getImage(),
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now(),
        ]);

        $productResult = DB::select('select * from products where name = ? and  available = ? and price = ? and vat_rate = ? and image_url = ?', [
            $product->getName(),
            $product->getAvailable(),
            $product->getPrice()->getCents(),
            $product->getVatRate(),
            $product->getImage(),
        ]);

        return response()->json($productResult, 201);
    }

    public function delete(int $productId): JsonResponse
    {
        DB::delete('delete from products where id = ?', [$productId]);

        return response()->json([], 204);
    }

    public function update(Product $product, int $productId): JsonResponse
    {
        DB::table('products')
            ->where('id', $productId)
            ->update([
                'name' => $product->getName(),
                'available' => $product->getAvailable(),
                'price' => $product->getPrice()->getCents(),
                'vat_rate' => $product->getVatRate(),
                'image_url' => $product->getImage(),
                'updated_at' => Carbon::now(),
            ]);

        return response()->json($this->getProduct($productId));
    }

    public function getOne(int $productId): JsonResponse
    {
        return response()->json($this->getProduct($productId));
    }


    private function getProduct(int $productId): array
    {
        return DB::select('select * from products where id = ?', [$productId]);
    }
}
