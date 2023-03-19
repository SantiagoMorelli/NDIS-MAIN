<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticketing extends Model
{
    use HasFactory;
    protected $table = 'ticketing';
    protected $primaryKey = 'id';
    protected $fillable = [
        'subject','status',"due_date","notes",'order_number','type'
    ];
}
