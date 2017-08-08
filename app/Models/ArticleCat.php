<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleCat extends Model
{
    protected $table = 'article_cat';
    protected $primaryKey = 'cat_id';

    public function article()
    {
        return $this->hasMany(Article::class, 'cat_id');
    }

    public function child()
    {
        return $this->hasMany(ArticleCat::class, 'parent_id');
    }

    public function get_article_cat($show_in_nav = 1, $num = 0)
    {
        $query = self::where('show_in_nav', $show_in_nav)
            ->orderBy('sort_order', 'desc')
            ->orderBy('cat_id', 'desc');
        if ($num > 0) {
            $query->take($num);
        }
        $ads = $query->get();
        return $ads;
    }
}
