<?php

namespace App\Http\Controllers;

use App\Http\Requests\WarehouseRequest;
use App\Services\WarehouseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    protected $service;

    public function __construct(WarehouseService $service)
    {
        $this->service = $service;
    }


    public function index(Request $request)
    {
        return $this->service->getAllWarehouses($request->all())->paginate();
    }

    public function list(Request $request)
    {
        $Warehouses = $this->service->getAllWarehouses($request->all())->get();
        return $this->success($Warehouses, 'Warehouses retrieved successfully.');
    }

    public function store(WarehouseRequest $request): JsonResponse
    {
        $Warehouse = $this->service->addUpdateWarehouse($request->validated());
        return $this->success($Warehouse, 'Warehouse created successfully.', 201);
    }

    public function show($id)
    {
        $Warehouse = $this->service->getWarehouse(['id' => $id]);
        return $this->success($Warehouse, 'Warehouse retrieved successfully.');
    }

    public function update(WarehouseRequest $request, $id): JsonResponse
    {

        $Warehouse = $this->service->addUpdateWarehouse($request->validated(), $id);
        return $this->success($Warehouse, 'Warehouse updated successfully.');
    }

    public function destroy($id)
    {
        $deleted = $this->service->deleteWarehouse($id);
        return $this->successResponse(null, 'Warehouse deleted successfully.');
    }
}
