<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $table = 'ad';
    protected $primaryKey = 'ad_id';

    public function get_ads($position_id, $num = 0)
    {
        $query = self::where('start_time', '<', time())
            ->where('end_time', '>', time())
            ->where('position_id', $position_id)
            ->where('enabled', 1)
            ->select('position_id', 'ad_id', 'ad_name', 'ad_code',
                'start_time', 'ad_link', 'end_time', 'ad_bgc', 'ad_tongji')
            ->orderBy('sort_order', 'desc')
            ->orderBy('ad_id', 'desc');
        if ($num > 0) {
            $query->take($num);
        }
        $ads = $query->get();
        return $ads;
    }
}
