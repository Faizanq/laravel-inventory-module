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
        $query = $this->model->query()->with([]);
        unset($params['page']);

        if (!empty($params)) {
            $query->where($params);
        }

        if (count($select)) {
            $query->select($select);
        }

        return $query;
    }

    public function getStockTransfer($params)
    {
        return $this->model->where($params)->with([])->first();
    }


    public function addUpdateStockTransfer($params, $id = null)
    {
        $formattedParams = $this->formatParams($params);

        if (!empty($id)) {
            $record = $this->getStockTransfer(['id' => $id]);
            if ($record) {
                $record->update($formattedParams);
            } else {
                throw new \Exception('StockTransfer not found');
            }
        } else {
            $record = $this->model->forceCreate($formattedParams);
        }
        $this->updateStockTransferStock($params, $record);

        return $record;
    }



    public function updateStockTransferStock(array $stocks, $warehouse)
    {
        foreach ($stocks as $stockData) {
            $stockRecord = $this->warehouseStock->where([
                'product_id' => $stockData['product_id'],
                'warehouse_id' => $warehouse->id
            ])->first();

            if ($stockRecord) {
                $stockRecord->available_stock = $stockData['available_stock'];
                $stockRecord->min_stock = $stockData['min_stock'];
                $stockRecord->save();
            } else {
                $this->warehouseStock->forceCreate(array_merge($stockData, [
                    'warehouse_id' => $warehouse->id
                ]));
            }
        }
    }


    public function deleteStockTransfer($params)
    {
        return $this->model->where($params)->delete();
    }

    private function formatParams($params)
    {
        $keysToInclude = ['name', 'location'];
        foreach ($keysToInclude as $key) {
            if (isset($params[$key])) {
                $formatted[$key] = trim($params[$key]);
            }
        }
        return $formatted;
    }
}
