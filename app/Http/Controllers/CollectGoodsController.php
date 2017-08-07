<?php

namespace App\Http\Controllers;

use App\Common\Page;
use App\Models\CollectGoods;
use Illuminate\Http\Request;

class CollectGoodsController extends Controller
{
    use Page;

    public $model;

    public function __construct(CollectGoods $model)
    {
        $this->set($model, 'collect_goods');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cat_id = intval($request->input('cat_id'));
        $query  = $this->model->with([
            'goods' => function ($query) {
                $query->with('goods_attr', 'member_price');
            }
        ])->where('user_id', $this->user->user_id);
        $request->offsetSet('cat_id', $cat_id);
        $query  = $this->sort_order($query);
        $result = $query->Paginate($this->page_num);
        $delete = [];
        foreach ($result as $v) {
            if ($v->goods) {
                $v->goods = $v->goods->attr($v->goods, $this->user);
            } else {
                $delete[] = $v->rec_id;
            }
        }
        if (count($delete) > 0) {
            $this->model->whereIn('rec_id', $delete)->delete();
        }
        $result                 = $this->add_params($result, $request->all());
        $this->assign['result'] = $result;
        return view('collect_goods.index', $this->assign);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id             = intval($request->input('id'));
        $info           = new $this->model;
        $info->user_id  = $this->user->user_id;
        $info->goods_id = $id;
        $info->save();
        tips('加入收藏夹成功');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $info = $this->model->find($id);
        if ($this->user->cant('delete', $info)) {
            tips('错误！', 1);
        }
        $info->delete();
        tips('从收藏夹删除成功！');
    }

    public function plsc(Request $request)
    {
        $ids = trim($request->input('ids'), ',');
        if (!empty($ids)) {
            $ids = explode(',', $ids);
            $this->model->whereIn('goods_id', $ids)
                ->where('user_id', $this->user->user_id)->delete();
        }
        tips('从收藏夹删除成功！');
    }
}
