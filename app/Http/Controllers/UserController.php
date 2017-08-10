<?php

namespace App\Http\Controllers;

use App\Common\Page;
use App\Models\AccountLog;
use App\Models\CollectGoods;
use App\Models\Goods;
use App\Models\OrderInfo;
use App\Models\Shipping;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use Page;

    public $model;

    public function __construct(User $model)
    {
        $this->set($model);
    }

    public function index(OrderInfo $orderInfo, CollectGoods $collectGoods, Goods $goods)
    {
        $pay_amount                  = $orderInfo->pay_amount($this->user);// 消费总额
        $wait_amount                 = $orderInfo->wait_amount($this->user);//待付款金额
        $pay_order                   = $orderInfo->pay_order($this->user);//待发货数量
        $wait_order                  = $orderInfo->wait_order($this->user);//待付款数量
        $yyzz_time                   = $this->check_date($this->user->yyzz_time);
        $xkz_time                    = $this->check_date($this->user->xkz_time);
        $zs_time                     = $this->check_date($this->user->zs_time);
        $yljg_time                   = $this->check_date($this->user->yljg_time);
        $near_order                  = $orderInfo->near_order($this->user, 3);//最近的订单
        $collection                  = $collectGoods->collect_near($this->user, 3);//我的收藏
        $this->assign['action']      = '';
        $this->assign['pay_amount']  = $pay_amount;
        $this->assign['wait_amount'] = $wait_amount;
        $this->assign['pay_order']   = $pay_order;
        $this->assign['wait_order']  = $wait_order;
        $this->assign['yyzz_time']   = $yyzz_time;
        $this->assign['xkz_time']    = $xkz_time;
        $this->assign['zs_time']     = $zs_time;
        $this->assign['yljg_time']   = $yljg_time;
        $this->assign['near_order']  = $near_order;
        $this->assign['collection']  = $collection;
        $where                       = function ($query) {
            $query->where('is_wntj', 1);
        };
        $this->assign['wntj']        = $goods->goods_list($this->user, 15, $where);
        return view('user.index', $this->assign);
    }

    public function zncg(Request $request)
    {
        $query  = DB::table('order_goods as og')
            ->leftJoin('order_info as oi', 'og.order_id', '=', 'oi.order_id')
            ->where('oi.order_status', 1)->where('oi.pay_status', 2)
            ->where('oi.user_id', $this->user->user_id)
            ->groupBy('og.goods_id')->orderBy('og.goods_id', 'desc')
            ->select(DB::raw('count(ecs_og.goods_id) as count'), 'og.goods_id');
        $result = $query->Paginate($this->page_num_check());
        $ids    = $result->pluck('goods_id');
        $goods  = Goods::with('goods_attr', 'member_price')->whereIn('goods_id', $ids)->get();
        $arr    = [];
        foreach ($goods as $v) {
            $v                 = $v->attr($v, $this->user);
            $arr[$v->goods_id] = $v;
        }
        foreach ($result as $v) {
            $v->goods = $arr[$v->goods_id];
        }
        $result                 = $this->add_params($result, $request->all());
        $this->assign['result'] = $result;
        return view('user.zncg', $this->assign);
    }

    public function account_log(AccountLog $accountLog)
    {
        $result                 = $accountLog->where('user_id', $this->user->user_id)
            ->where('user_money', '!=', 0)
            ->orderBy('log_id', 'desc')->Paginate($this->page_num_check());
        $this->assign['result'] = $result;
        return view('user.account_log', $this->assign);
    }

    public function profile()
    {
        $birth = explode('-', $this->user->birthday);
        $year  = "";
        for ($i = 2010; $i > 1949; $i--) {
            if ($birth[0] == $i) {
                $year .= "<option value='$i' selected >$i</option>";
            } else {
                $year .= "<option value='$i'>$i</option>";
            }
        }
        $month = "";
        for ($i = 1; $i < 13; $i++) {
            if ($birth[1] == $i) {
                $month .= "<option value='" . sprintf('%02d', $i) . "' selected >" . sprintf('%02d', $i) . "</option>";
            } else {
                $month .= "<option value='" . sprintf('%02d', $i) . "'>" . sprintf('%02d', $i) . "</option>";
            }
        }
        $day = "";
        for ($i = 1; $i < 32; $i++) {
            if ($birth[2] == $i) {
                $day .= "<option value='" . sprintf('%02d', $i) . "' selected >" . sprintf('%02d', $i) . "</option>";
            } else {
                $day .= "<option value='" . sprintf('%02d', $i) . "'>" . sprintf('%02d', $i) . "</option>";
            }
        }
        $this->assign['action'] = 'profile';
        $this->assign['year']   = $year;
        $this->assign['month']  = $month;
        $this->assign['day']    = $day;
        return view('user.profile', $this->assign);
    }

    protected function check_date($date)
    {
        if (empty(($date))) {
            return 1;
        }

        $year = substr($date, 0, 4);
        $now  = date('Y');
        if ($year > $now) {
            return 1;
        } else {
            $time = strtotime($date);
            if ($time > $now) {
                return 1;
            }
        }
        return 0;
    }

    public function update(Request $request)
    {
        $act = trim($request->input('act'));
        if ($act == 'profile') {
            $year                     = $request->input('year');
            $month                    = $request->input('month');
            $day                      = $request->input('day');
            $sex                      = $request->input('sex');
            $email                    = $request->input('email');
            $qq                       = $request->input('qq');
            $mobile_phone             = $request->input('mobile_phone');
            $birth                    = $year . "-" . $month . "-" . $day;
            $this->user->birthday     = $birth;
            $this->user->sex          = $sex;
            $this->user->email        = $email;
            $this->user->qq           = $qq;
            $this->user->mobile_phone = $mobile_phone;
            if ($request->hasFile('ls_file')) {
                $file = $request->file('ls_file');
                if ($file->isValid()) {

                    $extension = $file->getClientOriginalExtension();

                    //$mimeTye = $file->getMimeType();//文件格式

                    $newName = md5(date('ymdhis') . rand(0, 9)) . "." . $extension;

                    $path                = $file->move('upload/user', $newName); //图片存放的地址
                    $this->user->ls_file = $path->getFilename();
                }
            }
            if ($this->user->save()) {
                tips('您的个人资料已经成功修改', 0, ['link1' => route('user.profile'), 'link1_text' => '查看我的个人资料']);
            }
        } elseif ($act == 'password') {
            $validator = Validator::make($request->all(), [
                'old_password' => 'required|min:6',
                'password'     => 'required|min:6|confirmed',
            ], [
                'old_password.required' => '原密码不能为空',
                'old_password.min'      => '原密码长度至少为6位',
                'password.required'     => '新密码不能为空',
                'password.confirmed'    => '新密码确认密码不符',
                'password.min'          => '新密码长度至少为6位',
            ]);
            if ($validator->fails()) {
                return redirect(route('user.profile'))
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $oldPwd = $request->input('old_password');
                $newPwd = $request->input('password');
                //dd($this->user->password, $oldPwd_hash, $oldPwd);
                if (Hash::check($oldPwd, $this->user->password)) {
                    $newPwd_hash          = Hash::make($newPwd);
                    $this->user->password = $newPwd_hash;
                    if ($this->user->save()) {
                        tips('密码重置成功', 0, ['link1' => route('user.profile'), 'link1_text' => '查看我的个人资料']);
                    }
                } else {
                    tips('原密码错误', 1, ['link1' => route('user.profile'), 'link1_text' => '查看我的个人资料']);
                }
            }
        }
    }

    public function pswl()
    {
        if ($this->user->shipping_id > 0) {//不是其他物流
            $pswl = Shipping::where('shipping_id', $this->user->shipping_id)->value('shipping_name');
        } else {
            $pswl = $this->user->shipping_name;
        }
        $this->assign['action'] = 'pswl';
        $this->assign['pswl']   = $pswl;
        return view('user.pswl', $this->assign);
    }
}
