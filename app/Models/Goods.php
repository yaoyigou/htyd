<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $table = 'goods';
    protected $primaryKey = 'goods_id';

    public function goods_attr()
    {
        return $this->hasMany(GoodsAttr::class, 'goods_id', 'goods_id');
    }

    public function member_price()
    {
        return $this->hasMany(MemberPrice::class, 'goods_id', 'goods_id');
    }

    public function attr($v, $user)
    {
        //$v->sycx = isset($v->is_cx)?$v->is_cx:0;

        /**
         * 判断效期是否标红
         */
        $v->is_xq_red = 0;
        if (!empty($v->xq)) {
            $xq_end_time = strtotime('+8 month');
            if ($xq_end_time > strtotime($v->xq)) {//效期在8个月内 标红
                $v->is_xq_red = 1;
            }
        }

        $v->goods_sms  = str_replace('/images/upload/Image/', get_img_path('images/upload/Image/'), $v->goods_sms);
        $v->goods_desc = str_replace('/images/upload/Image/', get_img_path('images/upload/Image/'), $v->goods_desc);
        if (empty($v)) {
            return false;
        };
        $v->is_cx       = 0;
        $v->goods_img   = !empty($v->goods_img) ? $v->goods_img : 'images/no_picture.gif';
        $v->goods_thumb = !empty($v->goods_thumb) ? $v->goods_thumb : 'images/no_picture.gif';
        $v->goods_img   = get_img_path($v->goods_img);
        $v->goods_thumb = get_img_path($v->goods_thumb);
        if (strpos($v->show_area, '2') !== false) {//精品专区
            $v->is_jp = 1;
        } else {
            $v->is_jp = 0;
        }

        if (strpos($v->cat_ids, '180') !== false) {//麻黄碱
            $v->is_mhj = 1;
        } else {
            $v->is_mhj = 0;
        }
        if (strpos($v->cat_ids, '398') !== false) {//食品
            $v->is_shiping = 1;
        } else {
            $v->is_shiping = 0;
        }
        if (strpos($v->cat_ids, '425') !== false) {//生物制品
            $v->is_swzp = 1;
        } else {
            $v->is_swzp = 0;
        }
        if ($v->goods_attr->where('attr_id', 1)->first()) {//生产厂家存在
            $v->sccj = $v->goods_attr->where('attr_id', 1)->first()->attr_value;
        }
        if ($v->goods_attr->where('attr_id', 2)->first()) {//单位存在
            $v->dw = $v->goods_attr->where('attr_id', 2)->first()->attr_value;
        }
        if ($v->goods_attr->where('attr_id', 3)->first()) {//规格存在
            $v->spgg = $v->goods_attr->where('attr_id', 3)->first()->attr_value;
        }
        if ($v->goods_attr->where('attr_id', 4)->first()) {//国药准字存在
            $v->gyzz = $v->goods_attr->where('attr_id', 4)->first()->attr_value;
        }
        if ($v->goods_attr->where('attr_id', 5)->first()) {//件装量存在
            $v->jzl = trim($v->goods_attr->where('attr_id', 5)->first()->attr_value);
        }
        if ($v->goods_attr->where('attr_id', 211)->first()) {//中包装存在
            $v->zbz = trim($v->goods_attr->where('attr_id', 211)->first()->attr_value);
        }
        if ($v->goods_attr->where('attr_id', 213)->first()) {//促销信息
            $v->cxxx = trim($v->goods_attr->where('attr_id', 213)->first()->attr_value);
        }
        $v->goods_url = route('goods.index', ['id' => $v->goods_id]);
        if ($v->erp_shangplx == '血液制品' || $v->erp_shangplx == '冷藏药品') {
            $v->is_zyyp = 2;
        }

        $v->ls_gg = trim($v->ls_gg);
        if ($v->ls_gg > 0) {//最低购买量转中包装
            $v->zbz   = $v->ls_gg;
            $v->ls_gg = 0;
        }
        if ($v->goods_number < $v->zbz && $v->goods_number > 0) {
            $v->zbz = $v->goods_number;
        }
        $now           = time();
        $v->xg_num     = 0;
        $v->real_price = $v->shop_price;
        $v->is_can_see = 0;
        if ($v->is_promote == 1 && $v->promote_start_date <= $now && $v->promote_end_date >= $now) {
            $v->is_cx      = 1;
            $v->real_price = $v->promote_price;
        }

        /**
         * 换购
         */
        if ($v->is_change == 1 && $v->change_start_date <= $now && $v->change_end_date >= $now) {
            $v->is_hg = 1;
        } else {
            $v->is_hg = 0;
        }

        if ($v->xg_type == 3) {
            $v->xg_type       = 2;
            $v->xg_start_date = strtotime(date("Ymd"));
            $v->xg_end_date   = strtotime(date("Ymd")) + 3600 * 24;
        }
        if ($v->xg_type == 4) {
            $v->xg_type       = 2;
            $v->xg_start_date = strtotime('last monday');
            $v->xg_end_date   = strtotime('next monday');
        }
        if ($v->xg_type == 1) {
            $v->is_xg = 1;
        } else {
            $v->is_xg = self::is_xg($v->xg_type, $v->xg_start_date, $v->xg_end_date);
        }
        $v->real_price_format = "会员可见";
        if (auth()->check()) {//会员已登录
            /**
             * 处理区域新人特价
             */
            //$v = area_xrtj($v,$user->city,$user->district);
            //$user = auth()->user()->is_new_user();
            if ($user->ls_review) {//已审核
                if ($v->is_zx == 1) {//勾选了赠品
                    if (count($v->zx_ranks) > 0) {
                        if (!in_array($user->user_rank, $v->zx_ranks)) {//没有受到限制享受
                            if (strpos(strtolower($v->tsbz), 'z') === false) {//特殊标识里面不带z字母 添加上
                                $v->tsbz .= 'z';
                            }
                        } else {
                            $v->is_zx = 0;
                        }
                    } else {
                        if (strpos(strtolower($v->tsbz), 'z') === false) {//特殊标识里面不带z字母 添加上
                            $v->tsbz .= 'z';
                        }
                    }
                }
                /**
                 * 处理赠品 start
                 */
                $zengping = [17973, 19492, 3181, 3154];//赠品集合
                if (strpos(strtolower($v->tsbz), 'z') !== false && in_array($v->goods_id, $zengping)) {//属于赠品集合中赠品 限购四川终端
                    if ($user->is_zhongduan && $user->province == 26) {//四川终端
                        $v->tsbz = $v->tsbz;
                    } else {//不属于四川终端去掉z字母 is_zx=0
                        $v->tsbz  = str_replace('z', '', $v->tsbz);
                        $v->tsbz  = str_replace('Z', '', $v->tsbz);
                        $v->is_zx = 0;
                    }
                }
                $zengping1 = [339];//赠品集合
                if (strpos(strtolower($v->tsbz), 'z') !== false && in_array($v->goods_id, $zengping1)) {//属于赠品集合中赠品 限购终端
                    if ($user->is_zhongduan) {//终端
                        $v->tsbz = $v->tsbz;
                    } else {//不属于终端去掉z字母 is_zx=0
                        $v->tsbz  = str_replace('z', '', $v->tsbz);
                        $v->tsbz  = str_replace('Z', '', $v->tsbz);
                        $v->is_zx = 0;
                    }
                }
                /**
                 * 处理赠品 end
                 */
                $v->is_can_see = 1;
                if (!$user->is_zhongduan) {//非终端用户
                    if ($v->is_cx == 1 && $v->is_xg == 2) {//商品在进行促销限购

                        $v->is_xg = 0;

                    }
                    $v->is_cx = 0;
                    $v->zyzk  = 0;

                    $v->is_hg   = 0;
                    $rank_price = $v->member_price->where('user_rank', 1)->first();
                    if (!empty($rank_price)) {
                        $v->shop_price = $rank_price->user_price;
                        $v->real_price = $rank_price->user_price;
                    } else {
                        $v->real_price = $v->shop_price;
                    }
                } else {//终端用户
                    /**
                     * 促销
                     */
                    if ($v->is_cx == 1 && $user->is_zhongduan && $v->is_xkh_tj == 0) {//促销 终端 未参与新客户特价
                        $v->is_cx      = 1;
                        $v->real_price = $v->promote_price;
                    } elseif ($v->is_cx == 1 && $v->is_xkh_tj == 1 && $user->is_new_user) {
                        $v->is_cx      = 1;
                        $v->real_price = $v->promote_price;
                    } else {
                        $v->is_cx      = 0;
                        $v->real_price = $v->shop_price;
                    }

                    /**
                     * 换购
                     */
                    if ($v->is_hg == 1 && ($user->province == 26 || $user->province == 28 || $user->province == 29)) {
                        $v->is_hg = 1;
                    } else {
                        $v->is_hg = 0;
                    }
                }

                /**
                 * 限购
                 */

                if ($v->is_cx == 1 && $v->is_xkh_tj == 1 && $user->is_new_user == 1) {//新人特价 新人 设成单张限购
                    $v->xg_num = $v->xrtj_xg_num;
                    $v->ls_ggg = $v->xg_num;
                    if ($v->xg_num > 0) {
                        $v->is_xg = 1;
                    } else {
                        $v->is_xg = 0;
                    }
                } else {

                    if ($v->is_xg == 1) {//单张订单限购 终端
                        $v->is_xg  = 1;
                        $v->xg_num = $v->ls_ggg;
                    } elseif ($v->is_xg == 2) {//时间段内限购 终端
                        $num       = OrderGoods::xg_num($v->goods_id, $user->user_id, [$v->xg_start_date, $v->xg_end_date]);//已购买的数量
                        $v->xg_num = $v->ls_ggg - $num;
                        if ($v->xg_num <= 0) {//没有余量 限购结束 特价结束
                            if ($v->is_cx == 1) {//原来在促销中
                                $v->is_xg = 0;
                                $v->is_cx = 0;
                            }
                            $v->real_price = $v->shop_price;
                        }
                    }
                }

                /**
                 * 控销
                 */
                $v->qyhy_sp = 0;
//                if($v->hy_price>0){//哈药
//                    $v->real_price = $v->hy_price;
//                    $v->is_cx = 0;
//                }else
                if ($v->qyhy_price > 0 && $user->qyhy == 1) {//签约会员价
                    $v->real_price = $v->qyhy_price;
                    $v->qyhy_sp    = 1;
                    $v->tsbz       .= '签';
                    $v->is_cx      = 0;
                }
                if ($v->is_kxpz == 1) {
                    $kxpz = kxpzPrice::where('goods_id', $v->goods_id)->where(function ($query) use ($user) {
                        $query->where('ls_regions', 'like', '%.' . $user->country . '.%')//区域限制
                        ->orwhere('ls_regions', 'like', '%.' . $user->province . '.%')
                            ->orwhere('ls_regions', 'like', '%.' . $user->city . '.%')
                            ->orwhere('ls_regions', 'like', '%.' . $user->district . '.%')
                            ->orwhere('user_id', $user->user_id)
//                            ->orwhere(function($query)use($user){
//                                $query->where('user_id',$user->user_id)->where('user_name',$user->user_name)
//                                    ->where('country',$user->country)->where('province',$user->province)
//                                    ->where('city',$user->city)->where('district',$user->district)
//                                    ->where('user_rank',$user->user_rank);
//                            })
                        ;//会员限制
                    })->select('area_price', 'company_price')
                        ->orderBy('price_id', 'desc')->first();
                    if ($kxpz) {//有控销价
                        if ($user->is_zhongduan && $kxpz->area_price > 0) {//终端客户
                            $v->real_price = $kxpz->area_price;
                            $v->is_cx      = 0;
                        } elseif (!$user->is_zhongduan && $kxpz->company_price > 0) {
                            $v->real_price = $kxpz->company_price;
                            $v->is_cx      = 0;
                        }
                    }
                }
                $v->real_price_format = formated_price($v->real_price);
            }
            $v = self::area_xg($v, $user);
        }
        $v->market_price_format = formated_price($v->market_price);
        return $v;
    }

    public static function is_xg($status,$start,$end){
        if($status!=0&&time()>=$start&&time()<=$end){//商品限购
            return $status;
        }
        else{
            return 0;
        }
    }
}
