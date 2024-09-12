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
        return $this->service->getAllProducts($request->all())->paginate();
    }

    public function list(Request $request)
    {
        $products = $this->service->getAllProducts($request->all(), ['id', 'name', 'sku'])->get();
        return $this->success($products);
    }

    public function store(ProductRequest $request): JsonResponse
    {
        $product = $this->service->addUpdateProduct($request->all());
        return $this->success($product, 'Product created successfully.', 201);
    }

    public function show($id)
    {
        $product = $this->service->getProduct(['id' => $id]);
        return $this->success($product);
    }

    public function update(ProductRequest $request, $id): JsonResponse
    {

        $product = $this->service->addUpdateProduct($request->all(), $id);
        return $this->success($product, 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $deleted = $this->service->deleteProduct(['id' => $id]);
        return $this->success(null, 'Product deleted successfully.');
    }
}
