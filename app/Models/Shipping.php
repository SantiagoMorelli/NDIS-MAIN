<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;
    protected $table = 'shipping';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tracking_number', 'courier_company',"expected_time_of_arrival","dispatch_time","item_name","supplier_id","product_sku","notes",'order_number'
    ];
}
