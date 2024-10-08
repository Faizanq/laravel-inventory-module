<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockTransfer extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    protected $appends = ['type'];

    public function getTypeAttribute()
    {
        return !empty($this->from_suppplier_id) ? "Delivery" : "Supply";
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id')->withTrashed();
    }

    public function fromWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'from_warehouse_id')->withTrashed();
    }

    public function toWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'to_warehouse_id')->withTrashed();
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'from_supplier_id')->withTrashed();
    }
}
