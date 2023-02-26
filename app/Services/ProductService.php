<?php

namespace App\Services;

use App\Models\Money;
use App\Models\Product;
use App\Repositories\ProductRepository;

class ProductService
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAll(): array
    {
        $products = $this->productRepository->getAll();

        $productsArr = [];

        foreach ($products as $product) {
            $model = new Product();
            $money = new Money();
            $money->setCents($product->price);

            $model->setId($product->id);
            $model->setName($product->name);
            $model->setPrice($money);
            $model->setAvailable($product->available);
            $model->setVatRate($product->vat_rate);
            $model->setImage($product->image);

            $productsArr[]= $model;
        }

        return $productsArr;
    }

    public function store(Product $product): Product
    {
        $productInformation = $this->productRepository->store($product)[0];

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

    public function delete(int $productId): void
    {
        $this->productRepository->delete($productId);
    }

    public function update(Product $product,int $productId): Product
    {
        $productInformation = $this->productRepository->update($product, $productId)[0];

        $product = new Product();
        $price = (new Money())->setCents($productInformation->price);

        $product->setId($productInformation->id);
        $product->setName($productInformation->name);
        $product->setAvailable($productInformation->available);
        $product->setPrice($price);
        $product->setVatRate($productInformation->vat_rate);
        $product->setImage($productInformation->image);

        return $product;
    }

    public function getOne(int $productId): Product
    {
        $productInformation = $this->productRepository->getOne($productId)[0];
        $price = (new Money())->setCents($productInformation->price);

        $product = new Product();
        $product->setId($productInformation->id);
        $product->setName($productInformation->name);
        $product->setAvailable($productInformation->available);
        $product->setPrice($price);
        $product->setVatRate($productInformation->vat_rate);
        $product->setImage($productInformation->image);

        return $product;
    }
}
