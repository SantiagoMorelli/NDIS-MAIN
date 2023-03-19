<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BcmOrder extends Model
{
    use HasFactory;
    protected $table = 'bcm_order';
    protected $primaryKey = 'order_number';
 /**
     * Get the items for the order.
     */
    public function orderitems()
    {
        return $this->hasMany(BcmOrderItems::class);
    }
    public function shipping()
    {
        return $this->hasMany(Shipping::class);
    }
}
