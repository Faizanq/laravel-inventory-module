<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Services\SupplierService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    protected $service;

    public function __construct(SupplierService $service)
    {
        $this->service = $service;
    }


    public function index(Request $request)
    {
        $Suppliers = $this->service->getAllSuppliers($request->all())->paginate();
        return $this->success($Suppliers, 'Suppliers retrieved successfully.');
    }

    public function list(Request $request)
    {
        $Suppliers = $this->service->getAllSuppliers($request->all())->get();
        return $this->success($Suppliers, 'Suppliers retrieved successfully.');
    }

    public function store(SupplierRequest $request): JsonResponse
    {
        $Supplier = $this->service->addUpdateSupplier($request->validated());
        return $this->success($Supplier, 'Supplier created successfully.', 201);
    }

    public function show($id)
    {
        $Supplier = $this->service->getSupplier($id);
        return $this->success($Supplier, 'Supplier retrieved successfully.');
    }

    public function update(SupplierRequest $request, $id): JsonResponse
    {

        $Supplier = $this->service->addUpdateSupplier($request->validated(), $id);
        return $this->success($Supplier, 'Supplier updated successfully.');
    }

    public function destroy($id)
    {
        $deleted = $this->service->deleteSupplier($id);
        return $this->successResponse(null, 'Supplier deleted successfully.');
    }
}
