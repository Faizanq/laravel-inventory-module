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
        return $this->service->getAllStockTransfer($request->all())->paginate();
    }


    public function store(Request $request): JsonResponse
    {
        $StockTransfer = $this->service->addUpdateStockTransfer($request->all());
        return $this->success($StockTransfer, 'StockTransfer created successfully.', 201);
    }

    public function show($id)
    {
        $StockTransfer = $this->service->getStockTransfer(['id' => $id]);
        return $this->success($StockTransfer);
    }

    public function update(Request $request, $id): JsonResponse
    {

        $StockTransfer = $this->service->addUpdateStockTransfer($request->all(), $id);
        return $this->success($StockTransfer, 'StockTransfer updated successfully.');
    }

    public function destroy($id)
    {
        $deleted = $this->service->deleteTransfer(['id' => $id]);
        return $this->success(null, 'StockTransfer deleted successfully.');
    }
}
