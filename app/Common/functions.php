<?php
/**
 * Created by PhpStorm.
 * User: chunyang
 * Date: 2017-07-27
 * Time: 13:21
 */
use App\Models\ShopConfig;
use App\Models\OrderInfo;
use Illuminate\Support\Facades\Cache;


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
    function tips($message = '', int $error = 0, array $params = [], array $headers = [])
    {
        $params['error'] = $error;
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
                        return $list;
                    });
        }
        foreach ($list as $v) {
            $v->ad1 = get_ads($v->filter_attr[0]);
            $v->ad2 = get_ads($v->filter_attr[0]);
            $v->ad3 = get_ads($v->filter_attr[1]);
            $v->ad4 = get_ads($v->filter_attr[2]);
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

if (!function_exists('order_status')) {
    function order_status($order_id, $order_status, $pay_status, $shipping_status, $name = '')
    {
        $result = [
            'status'  => 0,
            'content' => '',
            'tip'     => '',
            'handle'  => '',
        ];
        if ($order_status == 1 && $pay_status == 0 && $shipping_status == 0) {
            $result = [
                'status'  => 1,//订单已确认，未付款，未发货
                'content' => '请您尽快完成付款，订单为未付款。',
                'tip'     => '未付款',
                'handle'  => "<a href='" . route('order.show', ['id' => $order_id]) . "'>付款</a>",
            ];
        }
        if ($order_status == 1 && $pay_status == 2 && $shipping_status == 0) {
            $result = [
                'status'  => 2,//订单已确认，已付款，未发货
                'content' => '您的订单商家正在积极备货中，未发货。',
                'tip'     => '已付款',
                'handle'  => "<span>已付款</span>",
            ];
        }
        if ($order_status == 1 && $pay_status == 2 && $shipping_status == 1) {
            $result = [
                'status'  => 3,//订单已确认，已付款，已开票
                'content' => '您的订单商家已开票。',
                'tip'     => '待发货',
                'handle'  => "<span>已付款</span>",
            ];
        }
        if ($order_status == 1 && $pay_status == 2 && $shipping_status == 2) {
            $result = [
                'status'  => 4,//订单已确认，已付款，出库中
                'content' => '您的订单正在出库中，请您耐心等待。',
                'tip'     => '出库中',
                'handle'  => "<span>已付款</span>",
            ];
        }
        if ($order_status == 1 && $pay_status == 2 && $shipping_status == 3) {
            $result = [
                'status'  => 5,//订单已确认，已付款，已出库
                'content' => '您的订单现已出库。',
                'tip'     => '已出库',
                'handle'  => "<span>已付款</span>",
            ];
        }
        if ($order_status == 1 && $pay_status == 2 && $shipping_status == 4) {
            $result = [
                'status'  => 6,//订单已确认，已付款，已发货
                'content' => '您的订单已发货。',
                'tip'     => '已发货',
                'handle'  => "<a href='" . route('order.show', ['id' => $order_id]) . "'>确认收货</a>",
            ];
        }
        if ($order_status == 1 && $pay_status == 2 && $shipping_status == 5) {
            $result = [
                'status'  => 7,//订单已确认，已付款，已完成
                'content' => "<font color='red'>您的订单已送达成功！已完成。</font>",
                'tip'     => "已完成",
                'handle'  => "<span>已完成</span>",
            ];
        }
        if ($order_status == 2 && $pay_status == 0) {
            $result = [
                'status'  => 8,//订单已取消，未付款，未发货
                'content' => "<font color='red'>您的订单已取消。</font>",
                'tip'     => "已取消",
                'handle'  => "<span style='color:red'>已取消</span>",
            ];
        }
        if ($name == '') {
            return $result;
        } else {
            return $result[$name];
        }
    }
}

if (!function_exists('get_region_list')) {
    function get_region_list($parent_id = 1)
    {
        $region = Cache::rememberForever('region', function () {
            return \App\Models\Region::all();
        });
        $result = $region->where('parent_id', 1)->pluck('region_name', 'region_id');
        return $result;
    }
}

if (!function_exists('get_region_name')) {
    function get_region_name(array $ids, string $fh = '')
    {
        $region = Cache::rememberForever('region', function () {
            return \App\Models\Region::all();
        });
        $result = $region->whereIn('region_id', $ids)->pluck('region_name')->toArray();
        $str    = explode($fh, $result);
        return $str;
    }
}

if (!function_exists('get_user_rank')) {
    function get_user_rank()
    {
        Cache::forget('user_rank');
        $user_rank = Cache::rememberForever('user_rank', function () {
            return \App\Models\UserRank::pluck('rank_name', 'rank_id')->toArray();
        });
        return $user_rank;
    }
}