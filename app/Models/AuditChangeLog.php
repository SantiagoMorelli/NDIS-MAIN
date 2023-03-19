<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditChangeLog extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table;
	
	public $timestamps = false;
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
		$this->table = 'audit_change_log';
	}

}
