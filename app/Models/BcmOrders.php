<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BcmOrders extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'bcm_order';
    }

    /**
     * Get the items for the order.
     */
    public function orderitems()
    {
        return $this->hasMany(BcmOrderItems::class);
    }
}