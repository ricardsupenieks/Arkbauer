<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StockRepository
{
    public function getStock(): array
    {
        return DB::select('select * from products join stock on products.id = product_id');
    }

    public function addProduct(int $productId): array
    {
        DB::table('stock')->insert([
            'product_id' => $productId,
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now(),
        ]);

        $stockResult = DB::select('select * from stock where product_id = ?', [$productId]);

        return $stockResult;
    }

    public function removeProduct(int $productId): void
    {
        DB::delete('delete from stock where product_id = ?', [$productId]);
    }
}
