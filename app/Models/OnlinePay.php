<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnlinePay extends Model
{
    protected $table = 'online_pay';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
