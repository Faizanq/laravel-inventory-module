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
        $formattedParams = $this->formatParams($params);

        if (!empty($id)) {
            $record = $this->getProduct(['id' => $id]);
            if ($record) {
                $record->update($formattedParams);
            } else {
                throw new \Exception('Product not found');
            }
        } else {
            $record = $this->model->forceCreate($formattedParams);
        }

        return $record;
    }

    public function deleteProduct($params)
    {
        return $this->model->where($params)->delete();
    }

    private function formatParams($params)
    {
        $keysToInclude = ['name', 'sku'];
        foreach ($keysToInclude as $key) {
            if (isset($params[$key])) {
                $formatted[$key] = trim($params[$key]);
            }
        }
        return $formatted;
    }
}
