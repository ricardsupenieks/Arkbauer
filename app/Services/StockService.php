<?php

namespace App\Services;

use App\Models\Money;
use App\Models\Product;
use App\Models\Stock;
use App\Repositories\ProductRepository;
use App\Repositories\StockRepository;

class StockService
{
    private StockRepository $stockRepository;
    private ProductRepository $productRepository;

    public function __construct(StockRepository $stockRepository, ProductRepository $productRepository)
    {
        $this->stockRepository = $stockRepository;
        $this->productRepository = $productRepository;
    }

    public function getStock(): array
    {
        $stock = $this->stockRepository->getStock();

        $productIds = [];
        $products = new Stock();

        foreach ($stock as $product) {
            $productIds []= $product->product_id;
        }

        foreach ($productIds as $singleProductId) {
            $singleProduct = $this->productRepository->getOne($singleProductId)[0];

            $product = new Product();
            $price = (new Money())->setCents($singleProduct->price);

            $product->setId($singleProductId);
            $product->setName($singleProduct->name);
            $product->setPrice($price);
            $product->setVatRate($singleProduct->vat_rate);
            $product->setAvailable($singleProduct->available);
            $product->setImage($singleProduct->image);

            $products->addProduct($product);
        }
        return $products->getProducts();
    }

    public function addProduct(int $productId): Product
    {
        $productId = $this->stockRepository->addProduct($productId)[0]->product_id;
        $productInformation = $this->productRepository->getOne($productId)[0];

        $product = new Product();
        $price = (new Money())->setCents($productInformation->price);

        $product->setId($productInformation->id);
        $product->setName($productInformation->name);
        $product->setPrice($price);
        $product->setAvailable($productInformation->available);
        $product->setVatRate($productInformation->vat_rate);
        $product->setImage($productInformation->image);

        return $product;
    }

    public function removeProduct(int $productId): void
    {
        $this->stockRepository->removeProduct($productId);
    }
}
