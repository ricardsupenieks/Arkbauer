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
        return $this->productService->getAll();
    }

    public function store(Request $request): JsonResponse
    {
        $price = (new Money())->setEuros($request->get('price'));

        $product = new Product();
        $product->setName($request->get('name'));
        $product->setAvailable($request->get('available'));
        $product->setPrice($price);
        $product->setVatRate($request->get('vatRate'));
        $product->setImage($request->get('imageUrl'));

        return $this->productService->store($product);
    }

    public function destroy($product): JsonResponse
    {
        return $this->productService->delete($product);
    }

    public function update(Request $request, $productId): JsonResponse
    {
        $price = (new Money())->setEuros($request->get('price'));

        $product = new Product();
        $product->setName($request->get('name'));
        $product->setAvailable($request->get('available'));
        $product->setPrice($price);
        $product->setVatRate($request->get('vatRate'));
        $product->setImage($request->get('imageUrl'));

        return $this->productService->update($product, $productId);
    }

    public function show($product): JsonResponse
    {
        return $this->productService->getOne($product);
    }
}
