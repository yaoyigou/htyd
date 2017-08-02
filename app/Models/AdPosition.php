<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdPosition extends Model
{
    protected $table = 'ad_position';
    protected $primaryKey = 'position_id';

    public function ad()
    {
        return $this->hasMany(Ad::class, 'position_id');
    }
}
