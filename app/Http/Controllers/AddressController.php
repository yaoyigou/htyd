<?php

namespace App\Http\Controllers;

use App\Common\Page;
use App\Models\UserAddress;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    use Page;

    public $model;

    public function __construct(UserAddress $model)
    {
        $this->set($model);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result   = $this->model->where('user_id', $this->user->user_id)->get();
        $province = get_region_list();
        foreach ($result as $v) {
            if ($v->province > 0) {
                $v->city_list = get_region_list($v->province);
            } else {
                $v->city_list = [];
            }
            if ($v->city > 0) {
                $v->district_list = get_region_list($v->city);
            } else {
                $v->district_list = [];
            }
        }
        //dd($result);
        $this->assign['result']   = $result;
        $this->assign['province'] = $province;
        return view('address.index', $this->assign);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $province                 = get_region_list();
        $this->assign['province'] = $province;
        return view('address.create', $this->assign);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $info                = new $this->model;
        $info->user_id       = $this->user->user_id;
        $info->consignee     = trim($request->input('consignee', ''));
        $info->email         = trim($request->input('email', ''));
        $info->country       = 1;
        $info->province      = intval($request->input('province'));
        $info->city          = intval($request->input('city'));
        $info->district      = intval($request->input('district'));
        $info->address       = trim($request->input('address', ''));
        $info->zipcode       = trim($request->input('zipcode', ''));
        $info->mobile        = trim($request->input('mobile', ''));
        $info->tel           = trim($request->input('tel', ''));
        $info->sign_building = trim($request->input('sign_building', ''));
        $info->best_time     = trim($request->input('sign_building', ''));
        $info->save();
        $action                 = trim($request->input('action', ''));
        $this->user->address_id = $info->address_id;
        $this->user->save();
        if ($action == 'jiesuan') {
            return redirect()->route('cart.jiesuan');
        }
        tips('您的收货地址信息已成功更新', 0, ['link1' => route('address.index'), 'link1_text' => '返回地址列表']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $info = $this->model->where('user_id', $this->user->user_id)->find($id);
        if (!$info) {
            tips('没有权限执行该操作', 1, ['link1' => route('address.index'), 'link1_text' => '返回地址列表']);
        }
        $info->user_id       = $this->user->user_id;
        $info->consignee     = trim($request->input('consignee', ''));
        $info->email         = trim($request->input('email', ''));
        $info->country       = 1;
        $info->province      = intval($request->input('province'));
        $info->city          = intval($request->input('city'));
        $info->district      = intval($request->input('district'));
        $info->address       = trim($request->input('address', ''));
        $info->zipcode       = trim($request->input('zipcode', ''));
        $info->mobile        = trim($request->input('mobile', ''));
        $info->tel           = trim($request->input('tel', ''));
        $info->sign_building = trim($request->input('sign_building', ''));
        $info->best_time     = trim($request->input('sign_building', ''));
        $info->save();
        $action                 = trim($request->input('action', ''));
        $this->user->address_id = $info->address_id;
        $this->user->save();
        tips('您的收货地址信息已成功更新', 0, ['link1' => route('address.index'), 'link1_text' => '返回地址列表']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $info = $this->model->where('user_id', $this->user->user_id)->find($id);
        if (!$info) {
            tips('没有权限这样做', 1);
        }
        $info->delete();
        tips('删除成功');
    }
}
