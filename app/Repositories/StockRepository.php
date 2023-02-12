<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class StockRepository
{
    public function getStock(): JsonResponse
    {
        $productIds = DB::select('select * from stock');

        return response()->json($productIds);
    }

    public function addProduct(int $productId): JsonResponse
    {
        DB::table('stock')->insert([
            'product_id' => $productId,
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now(),
        ]);

        $stockResult = DB::select('select * from stock where product_id = ?', [$productId]);

        return response()->json($stockResult, 201);
    }

    public function removeProduct(int $productId): JsonResponse
    {
        DB::delete('delete from stock where product_id = ?', [$productId]);

        return response()->json([], 204);
    }
}
