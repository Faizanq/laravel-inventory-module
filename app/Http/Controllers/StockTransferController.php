<?php

namespace App\Http\Controllers;

use App\Services\StockTransferService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StockTransferController extends Controller
{
    protected $service;

    public function __construct(StockTransferService $service)
    {
        $this->service = $service;
    }


    public function index(Request $request)
    {
        return $this->service->getAllStockTransfers($request->all())->paginate();
    }


    public function store(Request $request): JsonResponse
    {
        $StockTransfer = $this->service->addStockTransfer($request->all());
        return $this->success($StockTransfer, 'StockTransfer created successfully.', 201);
    }

    public function warehouseStockHistory(Request $request): JsonResponse
    {
        return $this->service->getWareHouseStockHistory($request->all())->paginate();
    }

    public function show($id)
    {
        $StockTransfer = $this->service->getStockTransfer(['id' => $id]);
        return $this->success($StockTransfer);
    }


    public function destroy($id)
    {
        $deleted = $this->service->deleteStockTransfer(['id' => $id]);
        return $this->success(null, 'StockTransfer Record deleted successfully.');
    }
}
