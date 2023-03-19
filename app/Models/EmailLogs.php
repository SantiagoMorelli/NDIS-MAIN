<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailLogs extends Model
{
    use HasFactory;
    protected $table;
    protected $primaryKey ='id';
    protected $fillable = ['from','to','subject','cc','bcc','email_sent_date','order_number'];
}
