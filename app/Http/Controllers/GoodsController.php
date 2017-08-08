<?php

namespace App\Http\Controllers;

use App\Common\Page;
use App\Models\Category;
use App\Models\Goods;
use App\Models\GoodsGallery;
use App\Models\KxpzPrice;
use Illuminate\Http\Request;

class GoodsController extends Controller
{
    use Page;

    public $model;

    public function __construct(Goods $goods)
    {
        $this->model = $goods;
        $this->middleware(function ($request, $next) {
            $this->user           = auth()->user();
            $this->assign['user'] = $this->user;
            return $next($request);
        });
    }

    public function search(Request $request)
    {
        $key    = $request->input('keywords');
        $result = $this->model->where(function ($query) use ($key) {
            $query->where('goods_name', 'like', "%$key%")->orwhere('ZJMID', 'like', "%$key%");
        })->where('is_on_sale', 1)->where('is_alone_sale', 1)
            ->where('is_delete', 0)->select('goods_name')
            ->take(10)
            ->groupBy('goods_name')->pluck('goods_name');
        return $result;
    }

    public function index(Request $request, Category $category)
    {
        $keywords     = trim($request->input('keywords'));
        $step         = trim($request->input('step'));
        $cat_id       = intval($request->input('cat_id'));
        $jx           = trim($request->input('jx'));
        $product_name = trim($request->input('product_name'));
        $ypgg         = trim($request->input('ypgg'));
        $style        = trim($request->input('style', 'l'));
        $query        = $this->model->where('is_on_sale', 1)
            ->where('is_alone_sale', 1)->where('is_delete', 0);
        $this->user_tj($query);
        $this->step($query, $step);
        $filter_arr = [
            'ypgg'  => [],
            'sccj'  => [],
            'cat_c' => [],
            'jx'    => [],
        ];
        if (!empty($keywords)) {
            $query->where(function ($where) use ($keywords) {
                $where->where('goods_name', 'like', '%' . $keywords . '%')
                    ->orwhere('product_name', 'like', '%' . $keywords . '%')
                    ->orwhere('ZJMID', 'like', '%' . $keywords . '%');
            });
        } else {
            $filter_category = $category->get_filter_category();
            $cat_ids         = [];
            if ($cat_id > 0) {
                $cat_ids[]              = $cat_id;
                $cat_info               = $filter_category->where('cat_id', $cat_id)->first();
                $cat_p                  = $filter_category->where('parent_id', $cat_info->parent_id)
                    ->pluck('cat_name', 'cat_id');
                $filter_arr['cat_info'] = $cat_info;
                $filter_arr['cat_p']    = $cat_p;
                if ($cat_info->parent_id > 0) {
                    $cat_p_info               = $filter_category->where('cat_id', $cat_info->parent_id)->first();
                    $cat_p1                   = $filter_category->where('parent_id', $cat_p_info->parent_id)
                        ->pluck('cat_name', 'cat_id');
                    $filter_arr['cat_p_info'] = $cat_p_info;
                    $filter_arr['cat_p1']     = $cat_p1;
                    if ($cat_p_info->parent_id > 0) {
                        $cat_p1_info               = $filter_category->where('cat_id', $cat_p_info->parent_id)->first();
                        $cat_p2                    = $filter_category->where('parent_id', $cat_p1_info->parent_id)
                            ->pluck('cat_name', 'cat_id');
                        $filter_arr['cat_p1_info'] = $cat_p1_info;
                        $filter_arr['cat_p2']      = $cat_p2;
                    }
                }
                $cat_c               = $filter_category->where('parent_id', $cat_info->cat_id);
                $filter_arr['cat_c'] = $cat_c;
            } else {
                $cat_c               = $filter_category->where('parent_id', 0);
                $filter_arr['cat_c'] = $cat_c;
            }
            if (count($cat_ids) > 0) {
                $query->where(function ($query) use ($cat_ids) {
                    foreach ($cat_ids as $v) {
                        $query->orwhere('cat_ids', 'like', '%' . $v . '%');
                    }
                });
            }
        }
        if (!empty($ypgg)) {
            $query->where('ypgg', 'like', '%' . $ypgg . '%');//药品规格
        }
        if (!empty($product_name)) {
            $query->where('product_name', 'like', '%' . $product_name . '%');//厂家
            $query_ypgg = clone $query;
            if (!empty($jx)) {
                $query_ypgg->where('jx', 'like', '%' . $jx . '%');//剂型
            }
            $filter_arr['ypgg'] = $query_ypgg->where('ypgg', '!=', '')
                ->orderBy('ypgg')->groupBy('ypgg')->pluck('ypgg');
        }
        $query_jx = clone $query;
        if (!empty($jx)) {
            $query->where('jx', 'like', '%' . $jx . '%');//剂型
        }
        $query2           = clone $query;
        $filter_arr['jx'] = $query_jx->where('jx', '!=', '')
            ->orderBy('jx')->groupBy('jx')->pluck('jx');
        if (count($filter_arr['cat_c']) == 0) {
            $sccj = $query2->where('product_name', '!=', '')
                ->orderBy('product_name')->groupBy('product_name')
                ->pluck('product_name');
            if (count($sccj) > 0) {
                foreach ($sccj as $v) {
                    $v  = trim($v);
                    $py = $this->shoupin($v);
                    if (!empty($py)) {
                        $filter_arr['sccj'][$py][] = $v;
                    }
                }
            }
        }
        $query->with(['goods_attr', 'member_price']);
        $this->sort_order($query);
        $result = $query->Paginate($this->page_num_check(40, 40));
        foreach ($result as $v) {
            $v = $this->model->attr($v, $this->user);
        }
        $request->offsetSet('style', $style);
        $inputs                 = $request->all();
        $result                 = $this->add_params($result, $inputs);
        $sort_arr               = [
            'sort_order',
            'click_count',
            'sales_volume',
            'goods_name',
            'product_name',
            'shop_price',
        ];
        $result->sort           = $this->sort_arr($result->url($result->currentPage()), $sort_arr);
        $weeksale               = xl_top(strtotime('-7 days'));
        $this->assign['result'] = $result;
        if (count($result) == 0) {
            $where                = function ($query) {
                $query->where('is_wntj', 1);
            };
            $this->assign['wntj'] = $this->model->goods_list($this->user, 15, $where);
        }
        $this->assign['inputs']     = $request->all();
        $this->assign['filter_arr'] = $filter_arr;
        $this->assign['week_sale']  = $weeksale;
        return view('goods.index', $this->assign);
    }

    private function shoupin($str)
    {
        if (empty($str)) {
            return '';
        }
        $fchar = ord($str{0});
        if ($fchar >= ord('A') && $fchar <= ord('z')) return strtoupper($str{0});
        $s1  = iconv('UTF-8', 'GBK', $str);
        $s2  = iconv('GBK', 'UTF-8', $s1);
        $s   = $s2 == $str ? $s1 : $str;
        $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
        if ($asc >= -20319 && $asc <= -20284) return 'A';
        if ($asc >= -20283 && $asc <= -19776) return 'B';
        if ($asc >= -19775 && $asc <= -19219) return 'C';
        if ($asc >= -19218 && $asc <= -18711) return 'D';
        if ($asc >= -18710 && $asc <= -18527) return 'E';
        if ($asc >= -18526 && $asc <= -18240) return 'F';
        if ($asc >= -18239 && $asc <= -17923) return 'G';
        if ($asc >= -17922 && $asc <= -17418) return 'H';
        if ($asc >= -17417 && $asc <= -16475) return 'J';
        if ($asc >= -16474 && $asc <= -16213) return 'K';
        if ($asc >= -16212 && $asc <= -15641) return 'L';
        if ($asc >= -15640 && $asc <= -15166) return 'M';
        if ($asc >= -15165 && $asc <= -14923) return 'N';
        if ($asc >= -14922 && $asc <= -14915) return 'O';
        if ($asc >= -14914 && $asc <= -14631) return 'P';
        if ($asc >= -14630 && $asc <= -14150) return 'Q';
        if ($asc >= -14149 && $asc <= -14091) return 'R';
        if ($asc >= -14090 && $asc <= -13319) return 'S';
        if ($asc >= -13318 && $asc <= -12839) return 'T';
        if ($asc >= -12838 && $asc <= -12557) return 'W';
        if ($asc >= -12556 && $asc <= -11848) return 'X';
        if ($asc >= -11847 && $asc <= -11056) return 'Y';
        if ($asc >= -11055 && $asc <= -10247) return 'Z';
        return null;
    }

    private function user_tj($query)
    {
        if ($this->user) {
            $query->where(function ($query) {
                //如果已经登陆，获取地区、会员id
                $country  = $this->user->country;
                $province = $this->user->province;
                $city     = $this->user->city;
                $district = $this->user->district;
                if ($this->user->is_zhongduan == 0) {
                    $query
                        ->where('yy_regions', 'not like', '%.' . $country . '.%')//没有医院限制1,6,7
                        ->where('yy_regions', 'not like', '%.' . $province . '.%')
                        ->where('yy_regions', 'not like', '%.' . $city . '.%')
                        ->where('yy_regions', 'not like', '%.' . $district . '.%')
                        ->where('yy_user_ids', 'not like', '%.' . $this->user->user_id . '.%');

                } else {
                    $query
                        ->where('zs_regions', 'not like', '%.' . $country . '.%')//没有诊所限制
                        ->where('zs_regions', 'not like', '%.' . $province . '.%')
                        ->where('zs_regions', 'not like', '%.' . $city . '.%')
                        ->where('zs_regions', 'not like', '%.' . $district . '.%')
                        ->where('zs_user_ids', 'not like', '%.' . $this->user->user_id . '.%');
                }
                $query
                    ->where(function ($query) {
                        $query->where('ls_ranks', 'not like', '%' . $this->user->user_rank . '%')->orwhereNull('ls_ranks');
                    })//没有等级限制;
                    ->where('ls_regions', 'not like', '%.' . $country . '.%')//没有区域限制
                    ->where('ls_regions', 'not like', '%.' . $province . '.%')
                    ->where('ls_regions', 'not like', '%.' . $city . '.%')
                    ->where('ls_regions', 'not like', '%.' . $district . '.%')
                    ->where('ls_user_ids', 'not like', '%.' . $this->user->user_id . '.%')
                    ->orwhere('xzgm', 1)
                    ->orwhere('ls_buy_user_id', 'like', '%.' . $this->user->user_id . '.%');//允许购买的用户
            });
        }
    }

    private function step($query, $step)
    {
        switch ($step) {
            case 'cx':
                $query->where(function ($where) {
                    $where->where('zyzk', '>', 0)->orwhere('is_zx', 1);
                });
                $this->sort                 = 'zyzk';
                $this->assign['page_title'] = '促销产品-';
                break;
            case 'nextpro':
                $query->where('is_promote', 1)->where('promote_price', '>', 0)
                    ->where('promote_start_date', '>', time())->where('is_xkh_tj', '!=', 1);//不查新客户特价
                if (auth()->check()) {
                    $kx_ids = self::kx_goods();
                    if (count($kx_ids) > 0) {
                        $query->whereNotIn('goods_id', $kx_ids);
                    }
                }
                break;
            case 'promotion':
                $query->where('is_promote', 1)->where('promote_price', '>', 0)
                    ->where('promote_start_date', '<=', time())->where('promote_end_date', '>=', time())->where('is_xkh_tj', '!=', 1);
                if (auth()->check()) {
                    $kx_ids = self::kx_goods();
                    if (count($kx_ids) > 0) {
                        $query->whereNotIn('goods_id', $kx_ids);
                    }
                }
                break;
            case 'gzbl_nextpro':
                $query->where('is_promote', 1)->where('promote_price', '>', 0)
                    ->whereIn('goods_sn', ['01012570', '01020715', '01020748', '01040522', '01041143', '01042072', '01042314',
                        '01042451', '01042707', '01042944', '01042947', '01043986', '01043987', '01045353', '01060599'])
                    ->where('promote_start_date', '>', time())->where('is_xkh_tj', '!=', 1);//不查新客户特价
                break;
            case 'gzbl_promotion':
                $query->where('is_promote', 1)->where('promote_price', '>', 0)
                    ->whereIn('goods_sn', ['01012570', '01020715', '01020748', '01040522', '01041143', '01042072', '01042314',
                        '01042451', '01042707', '01042944', '01042947', '01043986', '01043987', '01045353', '01060599'])
                    ->where('promote_start_date', '<=', time())->where('promote_end_date', '>=', time())->where('is_xkh_tj', '!=', 1);
                break;
            case 'jzqb':
                $query->where('tsbz', 'like', '%y%');
                break;
            case 'mjy':
                $query->where('product_name', 'like', '%成都岷江源药业股份有限公司%');
                break;
            case 'drt':
                $query->where('product_name', 'like', '%四川德仁堂中药%');
                break;
            case 'zy':
                $query->where('show_area', 'like', '%4%');
                break;
            case 'zyhd':
                $query->where(function ($query) {
                    $query
                        ->where('product_name', 'like', '%湖北金贵中药饮片有限公司%')
                        ->orwhere('product_name', 'like', '%四川天然生中药饮片有限公司%')
                        ->orwhere('product_name', 'like', '%成都岷江源药业股份有限公司%')
                        ->orwhere('product_name', 'like', '%广东正韩药业股份有限公司%');
                });
                break;
            case 'zk':
                $query->where('goods_weight', '>', 0);
                break;
            case 'hg':
                $query->where('tsbz', 'like', '%h%');
                break;
            case 'id':
                $query->whereIn('goods_id', [18046, 9758]);
                break;
            case 'trt':
                $query->whereIn('goods_sn', ['01031633', '01012257', '01012258', '01031921', '01044781', '01012259', '01031630', '01031631']);
                break;
            case 'tj':
                $query->whereIn('goods_sn', ['01060652', '01060413', '01061238', '01042625', '01061239', '01060585']);
                break;
            case 'tjhz':
                $query->whereIn('goods_sn', ['0600448', '01012832', '01021335', '01032154', '01045851', '01032155', '01021332', '01021334',
                    '01021337', '01021374', '01012834', '03030703', '03030704', '01045821', '01032275', '03030719', '01045636', '01044561', '01012833']);
                break;
            case 'tjhzhd':
                $query->whereIn('goods_sn', ['01012834', '01021332', '01012832', '01045851', '01032154', '01021374', '01021337', '01021334', '01021335'
                    , '03030704', '01032275', '01045821', '03030703']);
                break;
            case 'ydyy':
                $query->whereIn('goods_sn', ['01070317', '01071624', '01070540', '01071666', '01070935']);
                break;
            case 'njzd':
                $query->whereIn('goods_sn', ['01040453', '01046206', '01021186', '01045762', '01046207', '01045453']);
                break;
            case 'jrzz':
                $query->where('tsbz', 'like', '%j%');
                break;
            case 'jwxsp':
                $query->whereIn('goods_sn', ['01043977', '01042502']);
                break;
            case 'cjhd':
                $query->whereIn('goods_sn', ['01042444', '01070198']);
                break;
            case 'wtgk':
                $query->whereIn('goods_sn', ['01043628', '01043988']);
                break;
            case 'fys':
                $query->whereIn('goods_sn', ['03020086', '03020167', '03040329', '03040328', '03040327', '02010547',
                    '02010546', '02010495', '02010497', '03030309', '03030304', '03030305', '03030307', '03030308',
                    '06000288', '0600287', '06000428', '03030626', '0600427', '06000427', '06000426', '0600426',
                    '03030625', '03030440', '03030441', '03030442', '03030443', '03030444', '03030445', '03030446', '03030447']);
                break;
            //慢严舒柠
            case 'mysn':
                $query->whereIn('goods_sn', ['01031260', '03030019', '03030020', '03030215', '03030022']);
                break;
            //丽珠医药
            case 'lzyy':
                $query->whereIn('goods_sn', ['01010149', '01030090', '01030092']);
                break;
            //韩金靓
            case 'hjl':
                $query->whereIn('goods_sn', ['03010085', '03010055', '03010056', '03010054', '03010086']);
                break;
            case 'sht':
                $query->whereIn('goods_sn', ['06000385', '06000384', '0600386', '0600387', '0600384',
                    '0600389', '0600390', '0600383', '0600380', '06000389', '0600388', '0600381', '0600385', '06000390', '06000391', '06000395', '0600382']);
                break;
            case 'mz':
                $query->where('tsbz', 'like', '%m%');
                break;
            case 'zyzk':
                $query->where(function ($where) {
                    $where->where('zyzk', '>', 0)->orwhere('is_zx', 1);
                });
                break;
            default:
                if ($step != '' && $step > 0) {
                    $query->where('brand_id', intval($step));
                }
        }
    }

    public function kx_goods()
    {
        $ids = [];
        if (auth()->check()) {
            $user = auth()->user()->is_zhongduan();
            $kxpz = KxpzPrice::where(function ($query) use ($user) {
                $query->where('ls_regions', 'like', '%.' . $user->country . '.%')//区域限制
                ->orwhere('ls_regions', 'like', '%.' . $user->province . '.%')
                    ->orwhere('ls_regions', 'like', '%.' . $user->city . '.%')
                    ->orwhere('ls_regions', 'like', '%.' . $user->district . '.%')
                    ->orwhere('user_id', $user->user_id);//会员限制
            })->select('area_price', 'company_price', 'goods_id')->get();
            if (count($kxpz) > 0) {
                foreach ($kxpz as $v) {
                    if ($user->is_zhongduan && $v->area_price > 0) {//终端客户
                        $ids[] = $v->goods_id;
                    } elseif (!$user->is_zhongduan && $v->company_price > 0) {
                        $ids[] = $v->goods_id;
                    }
                }
            }
        }
        return $ids;

    }

    public function show($id)
    {
        $info = $this->model->find($id);
        if (!$info) {
            tips('商品不存在');
        }
        $info->load('goods_attr', 'member_price');
        $info                      = $this->model->attr($info, $this->user);
        $img                       = GoodsGallery::where('goods_id', $info->goods_id)->get();
        $this->assign['info']      = $info;
        $this->assign['img']       = $img;
        $this->assign['weekSales'] = xl_top(strtotime('-7 days'));
        return view('goods.show', $this->assign);
    }
}
