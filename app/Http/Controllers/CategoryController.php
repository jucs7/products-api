<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;

class CategoryController extends Controller
{

    public function __construct(protected CategoryService $service) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json($this->service->list());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = $this->service->create($request->validated());
        return response()->json($category, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return response()->json($this->service->find($category->id));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category = $this->service->update($category, $request->validated());
        return response()->json($category, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->service->delete($category);
        return response()->json(['message' => 'La caregoria ha sido eliminada.'], 200);
    }
}
