<?php

namespace App\Repositories\Contracts;

use App\Models\Category;

interface CategoryRepositoryInterface 
{
    public function all(): array;
    public function find(int $id): ?Category;
    public function create(array $data): Category;
    public function update(Category $category, array $data): Category;
    public function delete(Category $category): void;
}