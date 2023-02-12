<?php

namespace App\Repositories;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ProductRepository
{
    public function getAll(): array
    {
        return DB::select('select * from products');
    }

    public function store(Product $product): array
    {
        DB::table('products')->insert([
            'name' => $product->getName(),
            'available' => $product->getAvailable(),
            'price' => $product->getPrice()->getCents(),
            'vat_rate' => $product->getVatRate(),
            'image' => $product->getImage(),
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now(),
        ]);

        return DB::select('select * from products where name = ? and  available = ? and price = ? and vat_rate = ? and image = ?', [
            $product->getName(),
            $product->getAvailable(),
            $product->getPrice()->getCents(),
            $product->getVatRate(),
            $product->getImage(),
        ]);
    }

    public function delete(int $productId): void
    {
        DB::delete('delete from products where id = ?', [$productId]);
    }

    public function update(Product $product, int $productId): array
    {
        DB::table('products')
            ->where('id', $productId)
            ->update([
                'name' => $product->getName(),
                'available' => $product->getAvailable(),
                'price' => $product->getPrice()->getCents(),
                'vat_rate' => $product->getVatRate(),
                'image' => $product->getImage(),
                'updated_at' => Carbon::now(),
            ]);

        return $this->getProduct($productId);
    }

    public function getOne(int $productId): array
    {
        return $this->getProduct($productId);
    }


    private function getProduct(int $productId): array
    {
        return DB::select('select * from products where id = ?', [$productId]);
    }
}
