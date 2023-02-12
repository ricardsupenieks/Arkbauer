<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Money;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct()
    {
        $this->productService = new ProductService();
    }

    public function index(): JsonResponse
    {
        $products = $this->productService->getAll();

        return response()->json($products);
    }

    public function store(Request $request): JsonResponse
    {
        $product = $this->createProduct($request);

        $productAdded = $this->productService->store($product);

        return response()->json($productAdded, 201);
    }

    public function destroy($product): JsonResponse
    {
        $this->productService->delete($product);

        return response()->json([], 204);
    }

    public function update(Request $request, $productId): JsonResponse
    {
        $product = $this->createProduct($request);

        $productUpdated = $this->productService->update($product, $productId);

        return response()->json($productUpdated);
    }

    public function show($productId): JsonResponse
    {
        $product = $this->productService->getOne($productId);

        return response()->json($product);
    }


    private function createProduct(Request $request): Product
    {
        $price = (new Money())->setEuros($request->get('price'));

        $product = new Product();
        $product->setName($request->get('name'));
        $product->setAvailable($request->get('available'));
        $product->setPrice($price);
        $product->setVatRate($request->get('vatRate'));
        $product->setImage($request->get('imageUrl'));
        return $product;
    }
}
