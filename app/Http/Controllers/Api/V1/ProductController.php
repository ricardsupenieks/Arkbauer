<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Money;
use App\Models\Product;
use App\Services\ProductService;
use App\Transformers\ProductTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $service)
    {
        $this->productService = $service;
    }

    public function index(): JsonResponse
    {
        $products = $this->productService->getAll();

        return fractal($products, new ProductTransformer())->respond();
    }

    public function store(Request $request): JsonResponse
    {
        $product = $this->createProduct($request);

        $product = $this->productService->store($product);

        return fractal($product, new ProductTransformer())->respond(201);
    }

    public function destroy($product): JsonResponse
    {
        $this->productService->delete($product);

        return response()->json([], 204);
    }

    public function update(Request $request, $productId): JsonResponse
    {
        $product = $this->createProduct($request);

        $product = $this->productService->update($product, $productId);

        return fractal($product, new ProductTransformer())->respond();
    }

    public function show($productId): JsonResponse
    {
        $product = $this->productService->getOne($productId);

        return fractal($product, new ProductTransformer())->respond();
    }


    private function createProduct(Request $request): Product
    {
        $price = (new Money())->setCents($request->get('price') * 100);

        $product = new Product();
        $product->setName($request->get('name'));
        $product->setAvailable($request->get('available'));
        $product->setPrice($price);
        $product->setVatRate($request->get('vatRate'));
        $product->setImage($request->get('imageUrl'));

        return $product;
    }
}
