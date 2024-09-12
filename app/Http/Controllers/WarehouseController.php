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
        $Warehouses = $this->service->getAllWarehouses($request->all(), ['id', 'name'])->get();
        return $this->success($Warehouses);
    }

    public function store(WarehouseRequest $request): JsonResponse
    {
        $Warehouse = $this->service->addUpdateWarehouse($request->all());
        return $this->success($Warehouse, 'Warehouse created successfully.', 201);
    }

    public function show($id)
    {
        $Warehouse = $this->service->getWarehouse(['id' => $id]);
        return $this->success($Warehouse);
    }

    public function update(WarehouseRequest $request, $id): JsonResponse
    {

        $Warehouse = $this->service->addUpdateWarehouse($request->all(), $id);
        return $this->success($Warehouse, 'Warehouse updated successfully.');
    }

    public function destroy($id)
    {
        $deleted = $this->service->deleteWarehouse(['id' => $id]);
        return $this->success(null, 'Warehouse deleted successfully.');
    }
}
