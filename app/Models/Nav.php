<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nav extends Model
{
    protected $table = 'nav';
    protected $primaryKey = 'id';

    public function get_nav($type, $num = 0)
    {
        $query = self::where('ifshow', 1)
            ->where('type', $type)->orderBy('vieworder', 'asc');
        if ($num > 0) {
            $query->take($num);
        };
        $nav = $query->get();
        return $nav;
    }
}
