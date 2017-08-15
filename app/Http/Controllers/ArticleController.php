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
        $this->assign['top_title'] = '帮助中心';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ArticleCat $articleCat)
    {
        $cat_id = intval($request->input('cat_id'));
        $type   = intval($request->input('type'));
        $request->offsetSet('cat_id', $cat_id);
        $query = $articleCat->with('child', 'article');
        if ($type > 0) {
            $query->where('cat_type', $type);
        }
        $category = $query->get();
        $ids      = [];
        foreach ($category as $v) {
            $ids[] = $v->cat_id;
        }
        $query = $this->model->whereIn('cat_id', $ids)->orderBy('add_time', 'desc');
        if ($cat_id > 0) {
            $query      = $query->where('cat_id', $cat_id);
            $page_title = $articleCat->where('cat_id', $cat_id)->value('cat_name');
        } else {
            $page_title = $type == 1 ? '帮助中心' : '新闻中心';
        }
        $result                     = $query->Paginate($this->page_num_check(10, 10));
        $result                     = $this->add_params($result, $request->all());
        $this->assign['result']     = $result;
        $this->assign['category']   = $category;
        $this->assign['type']       = $type;
        $this->assign['page_title'] = $page_title;
        $this->assign['inputs']     = $request->all();
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
    public function show(Request $request, ArticleCat $articleCat, $id)
    {
        $info        = $this->model->find($id);
        $article_cat = $articleCat->find($info->cat_id);
        $top         = '
        <div class="top">
        <span class="title">当前位置:</span>
        <a class="end"><span></span></a><a href="' . route('index') . '">首页</a>
        <code>&gt;</code> <a href="' . route('article.index', ['cat_id' => $article_cat->cat_id, 'type' => $article_cat->cat_type]) . '">' . $article_cat->cat_name . '</a>
        <code>&gt;</code> <a href="' . route('article.show', ['id' => $info->article_id]) . '">' . $info->title . '</a>
        </div>';
        $type        = $article_cat->cat_type;
        $query       = $articleCat->with('child', 'article');
        if ($type > 0) {
            $query->where('cat_type', $type);
        }
        $category                   = $query->get();
        $this->assign['info']       = $info;
        $this->assign['top']        = $top;
        $this->assign['type']       = $type;
        $this->assign['page_title'] = $article_cat->cat_name;
        $this->assign['cat_id']     = $info->cat_id;
        $this->assign['category']   = $category;
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
