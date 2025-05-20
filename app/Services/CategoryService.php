<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\Eloquent\CategoryRepository;

class CategoryService 
{
    public function __construct(protected CategoryRepository $categoryRepository) {}

    public function list(): array
    {
        return $this->categoryRepository->all();
    }

    public function find(int $id): ?Category
    {
        return $this->categoryRepository->find($id);
    }

    public function create(array $data): Category
    {
        return $this->categoryRepository->create($data);
    }

    public function update(Category $category, array $data): Category
    {
        return $this->categoryRepository->update($category, $data);
    }

    public function delete(Category $category): void
    {
        $this->categoryRepository->delete($category);
    }
}