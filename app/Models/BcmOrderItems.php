<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BcmOrderItems extends Model
{
    use HasFactory;
    protected $table = 'bcm_order_items';
    protected $primaryKey = 'id';
}
