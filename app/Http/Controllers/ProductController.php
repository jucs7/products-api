<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Services\ProductService;

class ProductController extends Controller
{

    public function __construct(protected ProductService $service) {}

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
    public function store(StoreProductRequest $request)
    {
        $product = $this->service->create($request->validated());
        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json($this->service->find($product->id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product = $this->service->update($product, $request->validated());
        return response()->json($product, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->service->delete($product);
        return response()->json(['message' => 'El producto ha sido eliminado'], 200);
    }
}
