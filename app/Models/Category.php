<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'cat_id';

    public function get_category($show_in_nav = 0, $parent_id = 0, $grade = 0, $num = 0)
    {
        $query = self::where('is_show', 1)
            ->where('show_in_nav', $show_in_nav)
            ->where('grade', $grade)->where('parent_id', $parent_id);
        if ($num > 0) {
            $query->take($num);
        }
        $category = $query->orderBy('sort_order', 'desc')->get();
        return $category;
    }

    public function get_floor($grade, $num = 0)
    {
        $query = self::where('is_show', 1)
            ->where('grade', $grade);
        if ($num > 0) {
            $query->take($num);
        }
        $category = $query->orderBy('sort_order', 'desc')->get();
        return $category;
    }

    public function get_filter_category()
    {
        $query    = self::where('is_show', 1);
        $category = $query->orderBy('sort_order', 'desc')->get();
        return $category;
    }

    public function child()
    {
        return $this->hasMany(Category::class, 'parent_id', 'cat_id');
    }

    public function brother()
    {
        return $this->hasMany(Category::class, 'parent_id', 'parent_id');
    }

    public function ad_position()
    {
        return $this->hasMany(AdPosition::class, 'status', 'cat_id');
    }


    public function getFilterAttrAttribute($value)
    {
        if (empty($value)) {
            $value = [];
        } else {
            $value = explode(',', $value);
        }
        return $value;
    }
}
