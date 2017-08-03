<?php

namespace App\Http\Controllers;

use App\Models\Youhuiq;
use Illuminate\Http\Request;

class YouhuiqController extends Controller
{
    public $model;

    public $user;

    public $assign = [];

    public $sort;

    public $order;

    public $page_num;

    public function __construct(Youhuiq $model)
    {
        $this->model = $model;
        $this->middleware(function ($request, $next) {
            $this->user           = auth()->user();
            $this->assign['user'] = $this->user;
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_rank = get_user_rank();
        $now       = time();
        $query     = $this->model->where('user_id', $this->user->user_id)
            ->where('status', 0)
            ->where('union_type', '!=', 3)
            ->where('sctj', '!=', 7)
            ->where('end', '>=', $now)
            ->where('enabled', 1);
        $result    = $query->orderBy('union_type')
            ->orderBy('end')->orderBy('start')->orderBy('je')
            ->get();

        $province = get_region_list(1);
        return view('youhuiq/index', $this->assign);
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
