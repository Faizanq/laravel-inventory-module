<?php

namespace App\Services;

use App\Models\Supplier;

class SupplierService
{
    private $model;

    /**
     * Instantiate a new instance.
     *
     * @return void
     */
    public function __construct(Supplier $model)
    {
        $this->model = $model;
    }

    public function getAllSuppliers($params, $select = [])
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

    public function getSupplier($params)
    {
        return $this->model->where($params)->with([])->first();
    }


    public function addUpdateSupplier($params, $id = null)
    {
        if (!empty($id)) {
            $detail = $this->getSupplier(['id' => $id]);
            if ($detail) {
                $detail->update($this->formatParams($params));
                return $detail;
            }
            throw new \Exception('Supplier not found');
        } else {
            return $this->model->forceCreate($this->formatParams($params));
        }
    }

    public function deleteSupplier($params)
    {
        return $this->model->where($params)->delete();
    }

    private function formatParams($params)
    {
        $keysToInclude = ['name', 'email'];
        foreach ($keysToInclude as $key) {
            if (isset($params[$key])) {
                $formatted[$key] = trim($params[$key]);
            }
        }
        return $formatted;
    }
}
