<?php

namespace App\Services;

use App\Models\StockTransfer;
use App\Models\WarehouseStock;
use App\Models\StockTransferHistory;

class StockTransferService
{
    private $model;
    private $warehouseStock;
    private $history;

    /**
     * Instantiate a new instance.
     *
     * @return void
     */
    public function __construct(StockTransfer $model, WarehouseStock $warehouseStock, StockTransferHistory $history)
    {
        $this->model = $model;
        $this->warehouseStock = $warehouseStock;
        $this->history = $history;
    }

    public function getAllStockTransfers($params, $select = [])
    {
        $query = $this->model->with(['product', 'fromWarehouse', 'toWarehouse', 'supplier']);
        unset($params['page']);

        if (!empty($params)) {
            $query->where($params);
        }

        if (count($select)) {
            $query->select($select);
        }

        return $query->orderBy('transfer_date', 'desc');
    }

    public function getStockTransfer($params)
    {
        return $this->model->where($params)->with([])->first();
    }


    public function addStockTransfer($params, $id = null)
    {
        $formattedParams = $this->formatParams($params);
        try {
            \DB::beginTransaction();
            $record = $this->model->forceCreate($formattedParams);
            $this->updateWarehouseStock($record);
            \DB::commit();
            return $record;
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function updateWarehouseStock($record)
    {
        if (!empty($record->from_warehouse_id)) {

            $fromStockRecord = $this->warehouseStock->where([
                'product_id' => $record->product_id,
                'warehouse_id' => $record->from_warehouse_id
            ])->first();

            if ($fromStockRecord && (int)$fromStockRecord->available_stock >=  $record->quantity) {
                $fromStockRecord->decrement('available_stock', $record->quantity);
            } else {
                throw new \Exception('No stock available to transfer. Please check stock');
            }

            $historyParams = [
                'product_id' => $record->product_id,
                'warehouse_id' => $record->from_warehouse_id,
                'type' => 'STOCK_OUT',
                'quantity_change' => $record->quantity,
                'stock_transfer_id' => $record->id,
                'quantity' => $fromStockRecord->available_stock,
            ];
            $this->history->forceCreate($historyParams);
        }

        if (!empty($record->from_supplier_id)) {
            $historyParams = [
                'product_id' => $record->product_id,
                'supplier_id' => $record->from_supplier_id,
                'type' => 'STOCK_OUT',
                'quantity_change' => $record->quantity,
                'stock_transfer_id' => $record->id,
            ];
            $this->history->forceCreate($historyParams);
        }

        $toStockRecord = $this->warehouseStock->where([
            'product_id' => $record->product_id,
            'warehouse_id' => $record->to_warehouse_id
        ])->first();

        if ($toStockRecord) {
            $toStockRecord->increment('available_stock', $record->quantity);
        } else {
            $toStockRecord = $this->warehouseStock->forceCreate([
                'warehouse_id' => $record->to_warehouse_id,
                'product_id' => $record->product_id,
                'available_stock' => $record->quantity,
            ]);
        }

        $historyParams = [
            'product_id' => $record->product_id,
            'warehouse_id' => $record->to_warehouse_id,
            'type' => 'STOCK_IN',
            'quantity_change' => $record->quantity,
            'quantity' => $toStockRecord->available_stock,
            'stock_transfer_id' => $record->id,
        ];
        $this->history->forceCreate($historyParams);
    }


    public function deleteStockTransfer($params)
    {
        return $this->model->where($params)->delete();
    }

    private function formatParams($params)
    {
        $keysToInclude = ['transfer_date', 'quantity', 'to_warehouse_id', 'from_warehouse_id', 'from_supplier_id', 'product_id'];
        foreach ($keysToInclude as $key) {
            if (isset($params[$key])) {
                $formatted[$key] = trim($params[$key]);
                if ($key == 'quantity')
                    $formatted[$key] = (int)($params[$key]);
            }
        }
        return $formatted;
    }
}
