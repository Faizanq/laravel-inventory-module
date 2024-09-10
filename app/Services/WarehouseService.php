<?php

namespace App\Services;

use App\Models\Warehouse;

class WarehouseService
{
    private $model;

    /**
     * Instantiate a new instance.
     *
     * @return void
     */
    public function __construct(Warehouse $model)
    {
        $this->model = $model;
    }

    public function getAllWarehouses($params, $select = [])
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

    public function getWarehouse($params)
    {
        return $this->model->where($params)->with([])->first();
    }


    public function addUpdateWarehouse($params, $id = null)
    {
        if (!empty($id)) {
            $detail = $this->getWarehouse(['id' => $id]);
            if ($detail) {
                $detail->update($this->formatParams($params));
                return $detail;
            }
            throw new \Exception('Warehouse not found');
        } else {
            return $this->model->forceCreate($this->formatParams($params));
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
