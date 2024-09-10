<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    private $model;

    /**
     * Instantiate a new instance.
     *
     * @return void
     */
    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function getAllProducts($params, $select = [])
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

    public function getProduct($params)
    {
        return $this->model->where($params)->with([])->first();
    }


    public function addUpdateProduct($params, $id = null)
    {
        if (!empty($id)) {
            $detail = $this->getProduct(['id' => $id]);
            if ($detail) {
                $detail->update($this->formatParams($params));
                return $detail;
            }
            throw new \Exception('Product not found');
        } else {
            return $this->model->forceCreate($this->formatParams($params));
        }
    }

    public function deleteProduct($params)
    {
        return $this->model->where($params)->delete();
    }

    private function formatParams($params)
    {
        $keysToInclude = ['name', 'sku', 'quantity_in_stock', 'supplier_id'];
        foreach ($keysToInclude as $key) {
            if (isset($params[$key])) {
                $formatted[$key] = trim($params[$key]);
            }
        }
        return $formatted;
    }
}
