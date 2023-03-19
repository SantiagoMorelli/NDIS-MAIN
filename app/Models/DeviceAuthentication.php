<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceAuthentication extends Model
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
		'access_token', 'token_expiry', 'expires_in', 'device_expiry', 'key_expiry', 'token_type', 'scope'
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	public function __construct(array $attributes = []) {
		parent::__construct($attributes);
		$this->table = 'device_authentication';
	}

}
