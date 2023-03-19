<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
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
	protected $fillable = [
		
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	public function __construct(array $attributes = []) {
		parent::__construct($attributes);
		$this->table = 'orders';
	}

	 /**
     * Get the items for the order.
     */
    public function orderitems()
    {
        return $this->hasMany(OrderItems::class);
    }
/**
     * Get the shipping information for the order.
     */
	public function shipping()
    {
        return $this->hasMany(Shipping::class);
    }

	// * Get the shipping information for the order.
	// */
   public function ticketing()
   {
	   return $this->hasMany(Ticketing::class);
   }

}
