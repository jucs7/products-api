<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\Eloquent\ProductRepository;

class ProductService 
{
    public function __construct(protected ProductRepository $productRepository) {}

    public function list(): array
    {
        return $this->productRepository->all();
    }

    public function find(int $id): ?Product
    {
        return $this->productRepository->find($id);
    }

    public function create(array $data): Product
    {
        return $this->productRepository->create($data);
    }

    public function update(Product $product, array $data): Product
    {
        return $this->productRepository->update($product, $data);
    }

    public function delete(Product $product): void 
    {
        $this->productRepository->delete($product);
    }
}