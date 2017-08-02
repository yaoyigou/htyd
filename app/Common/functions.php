<?php
/**
 * Created by PhpStorm.
 * User: chunyang
 * Date: 2017-07-27
 * Time: 13:21
 */
use App\Models\ShopConfig;
use App\Models\OrderInfo;


if (!function_exists('shop_config')) {
    function shop_config($code)
    {
        return Cache::tags('shop', 'config')->rememberForever($code, function () use ($code) {
            return ShopConfig::where('code', $code)->value('value');
        });
    }
}

if (!function_exists('path')) {
    function path($path, $secure = null)
    {
        return app('url')->asset($path, $secure);

    }
}


if (!function_exists('tips')) {
    function tips($message = '', int $errors = 0, array $params = [], array $headers = [])
    {
        $params['errors'] = $errors;
        throw new \App\Exceptions\TipsException($message, $params, $headers);
    }
}

if (!function_exists('get_ads')) {
    function get_ads($position_id, $num = 0, $cache = 1)
    {
        if ($cache == 0) {
            $model = new \App\Models\Ad();
            $list  = $model->get_ads($position_id, $num);
        } else {
            $list = \Illuminate\Support\Facades\Cache::tags('ads', date('Ymd'))
                ->rememberForever($position_id, function () use ($position_id, $num) {
                    $model = new \App\Models\Ad();
                    $list  = $model->get_ads($position_id, $num);
                    return $list;
                });
        }
        foreach ($list as $v) {
            $v->ad_code = get_img_path('data/afficheimg/' . $v->ad_code);
        }
        return $list;
    }
}

if (!function_exists('get_category')) {
    function get_category($cache = 1)
    {
        if ($cache == 0) {
            $model = new \App\Models\Category();
            $list  = $model->get_category(1, 0, 0, 7);
            $list->load([
                'child' => function ($query) {
                    $query->where('is_show', 1);
                }
            ]);
        } else {
            $list = \Illuminate\Support\Facades\Cache::tags('category')
                ->rememberForever(1,
                    function () {
                        $model = new \App\Models\Category();
                        $list  = $model->get_category(1, 0, 0, 7);
                        $list->load([
                            'child' => function ($query) {
                                $query->where('is_show', 1);
                            }
                        ]);
                        return $list;
                    });
        }
        return $list;
    }
}

if (!function_exists('get_floors')) {
    function get_floors($cache = 1)
    {
        if ($cache == 0) {
            $model = new \App\Models\Category();
            $list  = $model->get_category(2);
            $list->load([
                'child' => function ($query) {
                    $query->where('show_in_nav', 2)->where('is_show', 1);
                }
            ]);
            foreach ($list as $v) {
                $v->ad1 = get_ads($v->filter_attr[0]);
                $v->ad2 = get_ads($v->filter_attr[0]);
                $v->ad3 = get_ads($v->filter_attr[1]);
                $v->ad4 = get_ads($v->filter_attr[2]);
            }
        } else {
            $list = \Illuminate\Support\Facades\Cache::tags('category')
                ->rememberForever(2,
                    function () {
                        $model = new \App\Models\Category();
                        $list  = $model->get_category(2);
                        $list->load([
                            'child' => function ($query) {
                                $query->where('show_in_nav', 2)->where('is_show', 1);
                            }
                        ]);
                        foreach ($list as $v) {
                            $v->ad1 = get_ads($v->filter_attr[0]);
                            $v->ad2 = get_ads($v->filter_attr[0]);
                            $v->ad3 = get_ads($v->filter_attr[1]);
                            $v->ad4 = get_ads($v->filter_attr[2]);
                        }
                        return $list;
                    });
        }
        return $list;
    }
}

if (!function_exists('get_article_cat')) {
    function get_article_cat($cache = 1)
    {
        if ($cache == 0) {
            $model = new \App\Models\ArticleCat();
            $list  = $model->get_article_cat(2);
            $list->load([
                'article' => function ($query) {
                    $query->where('is_open', 1);
                }
            ]);
        } else {
            $list = \Illuminate\Support\Facades\Cache::tags('article_cat')
                ->rememberForever(2,
                    function () {
                        $model = new \App\Models\ArticleCat();
                        $list  = $model->get_article_cat(2);
                        $list->load([
                            'article' => function ($query) {
                                $query->where('is_open', 1);
                            }
                        ]);
                        return $list;
                    });
        }
        return $list;
    }
}

if (!function_exists('get_nav')) {
    function get_nav($type, $num = 0, $cache = 1)
    {
        if ($cache == 0) {
            $model = new \App\Models\Nav();
            $list  = $model->get_nav($type, $num);
        } else {
            $list = \Illuminate\Support\Facades\Cache::tags('nav')
                ->rememberForever($type, function () use ($type, $num) {
                    $model = new \App\Models\Nav();
                    $list  = $model->get_nav($type, $num);
                    return $list;
                });
        }
        return $list;
    }
}

if (!function_exists('get_img_path')) {
    function get_img_path($img)
    {
        $http = "http://images.hezongyy.com/";
        return $http . $img;
    }
}

if (!function_exists('formated_price')) {
    function formated_price($price)
    {
        return '￥' . sprintf('%.2f', $price);
    }
}

if (!function_exists('xl_top')) {
    function xl_top($time, $tag = 'week', $num = 10)
    {
        $result = Cache::tags('goods')->remember($tag, 60 * 24, function () use ($time, $num) {
            $order_id = OrderInfo::where('add_time', '>', $time)
                ->orderBy('order_id', 'asc')->value('order_id');
            $result   = DB::table('order_goods as og')
                ->leftJoin('order_info as oi', 'og.order_id', '=', 'oi.order_id')
                ->leftJoin('goods as g', 'g.goods_id', '=', 'og.goods_id')
                ->where('og.order_id', '>=', $order_id)->where('oi.order_status', 1)
                ->orderBy('num', 'desc')
                ->groupBy('og.goods_id')
                ->take($num)
                ->select('g.goods_name', 'g.goods_id', 'g.goods_thumb', 'g.ypgg',
                    DB::raw('sum(ecs_og.goods_number) as num'))
                ->get();
            foreach ($result as $v) {
                $v->goods_thumb = !empty($v->goods_thumb) ? $v->goods_thumb : 'images/no_picture.gif';
                $v->goods_thumb = get_img_path($v->goods_thumb);
                $v->goods_url   = route('goods.show', ['id' => $v->goods_id]);
            }
            return $result;
        });
        return $result;
    }
}