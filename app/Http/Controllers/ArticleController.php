<?php

namespace App\Http\Controllers;

use App\Common\Page;
use App\Models\Article;
use App\Models\ArticleCat;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    use Page;

    public $model;

    public function __construct(Article $model)
    {
        $this->set($model);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ArticleCat $articleCat)
    {
        $cat_id = intval($request->input('cat_id'));
        $request->offsetSet('cat_id', $cat_id);
        $query = $this->model->orderBy('add_time', 'desc');
        if ($cat_id > 0) {
            $query = $query->where('cat_id', $cat_id);
        }
        $result                    = $query->Paginate($this->page_num_check());
        $result                    = $this->add_params($result, $request->all());
        $category                  = $articleCat->with('child')->get();
        $this->assign['result']    = $result;
        $this->assign['category']  = $category;
        $this->assign['inputs']    = $request->all();
        $this->assign['top_title'] = '帮助中心';
        return view('article.index', $this->assign);
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
    public function show(ArticleCat $articleCat, $id)
    {
        $info                     = $this->model->find($id);
        $category                 = $articleCat->with('child')->get();
        $this->assign['info']     = $info;
        $this->assign['category'] = $category;
        return view('article.show', $this->assign);
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
