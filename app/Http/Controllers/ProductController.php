<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }


    public function index(Request $request)
    {
        // $products = $this->service->getAllProducts($request->all())->paginate();
        return $this->service->getAllProducts($request->all())->paginate();
    }

    public function list(Request $request)
    {
        $products = $this->service->getAllProducts($request->all())->get();
        return $this->success($products, 'Products retrieved successfully.');
    }

    public function store(ProductRequest $request): JsonResponse
    {
        $product = $this->service->addUpdateProduct($request->validated());
        return $this->success($product, 'Product created successfully.', 201);
    }

    public function show($id)
    {
        $product = $this->service->getProduct($id);
        return $this->success($product, 'Product retrieved successfully.');
    }

    public function update(ProductRequest $request, $id): JsonResponse
    {

        $product = $this->service->addUpdateProduct($request->validated(), $id);
        return $this->success($product, 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $deleted = $this->service->deleteProduct($id);
        return $this->successResponse(null, 'Product deleted successfully.');
    }
}
