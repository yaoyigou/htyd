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
        $query  = $this->model->with('goods')->where('user_id', $this->user->user_id);
        $request->offsetSet('cat_id', $cat_id);
        $query                  = $this->sort_order($query);
        $result                 = $query->Paginate($this->page_num);
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
        //
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
        //
    }
}
