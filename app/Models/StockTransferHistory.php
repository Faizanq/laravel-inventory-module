<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockTransferHistory extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'stock_transfer_history';
    protected $guarded = [];
}
