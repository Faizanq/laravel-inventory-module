<?php

namespace App\Services;

use App\Models\Warehouse;
use App\Models\WarehouseStock;

class WarehouseService
{
    private $model;
    private $warehouseStock;

    /**
     * Instantiate a new instance.
     *
     * @return void
     */
    public function __construct(Warehouse $model, WarehouseStock $warehouseStock)
    {
        $this->model = $model;
        $this->warehouseStock = $warehouseStock;
    }

    public function getAllWarehouses($params, $select = [])
    {
        $query = $this->model->query()->with(['stocks']);
        unset($params['page']);

        if (!empty($params)) {
            $query->where($params);
        }

        if (count($select)) {
            $query->select($select);
        }

        return $query;
    }

    public function getWarehouse($params)
    {
        return $this->model->where($params)->with(['stocks'])->first();
    }


    public function addUpdateWarehouse($params, $id = null)
    {
        $formattedParams = $this->formatParams($params);

        if (!empty($id)) {
            $record = $this->getWarehouse(['id' => $id]);
            if ($record) {
                $record->update($formattedParams);
            } else {
                throw new \Exception('Warehouse not found');
            }
        } else {
            $record = $this->model->forceCreate($formattedParams);
        }
        $this->updateWarehouseStock($params['stocks'], $record);

        return $record;
    }



    public function updateWarehouseStock(array $stocks, $warehouse)
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


    public function deleteWarehouse($params)
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
