<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Money;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $products = DB::select('select * from products');

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $price = (new Money())->setEuros($request->get('price'));

        $product = new Product();
        $product->setName($request->get('name'));
        $product->setAvailable($request->get('available'));
        $product->setPrice($price);
        $product->setVatRate($request->get('vatRate'));

        DB::table('products')->insert([
            'name' => $product->getName(),
            'available' => $product->getAvailable(),
            'price' => $product->getPrice()->getCents(),
            'vat_rate' => $product->getVatRate(),
            'image_url' => $request->get('imageUrl'),
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now(),
        ]);

        $productResult = DB::select('select * from products where name = ? and  available = ? and price = ? and vat_rate = ? and image_url = ?', [
            $product->getName(),
            $product->getAvailable(),
            $product->getPrice()->getCents(),
            $product->getVatRate(),
            $request->get('imageUrl')
        ]);

        return response()->json($productResult, 201);
    }

    public function destroy($product): JsonResponse
    {
        DB::delete('delete from products where id = ?', [$product]);

        return response()->json([], 204);
    }

    public function update(Request $request, $product): JsonResponse
    {
        DB::table('products')
            ->where('id', $product)
            ->update([
                'name' => $request->get('name'),
                'available' => $request->get('available'),
                'price' => $request->get('price'),
                'vat_rate' => $request->get('vat_rate'),
                'image_url' => $request->get('imageUrl'),
                'updated_at' => Carbon::now(),
        ]);

        return response()->json($this->getProduct($product));
    }

    public function show($product): JsonResponse
    {
        return response()->json($this->getProduct($product));
    }

    private function getProduct($productId): array
    {
        return DB::select('select * from products where id = ?', [$productId]);
    }
}
