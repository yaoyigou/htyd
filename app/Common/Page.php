<?php
/**
 * Created by PhpStorm.
 * User: chunyang
 * Date: 2017-08-03
 * Time: 17:28
 */

namespace App\Common;


use Illuminate\Support\Facades\Request;

trait Page
{
    private $user;

    private $sort;

    private $order;

    private $page_num = 15;

    private $assign;

    private $fh = '';

    public function sort_order($query)
    {
        $this->sort  = trim(Request::input('sort', $this->model->get_key($this->fh)));
        $this->order = trim(Request::input('order', 'desc'));
        $query       = $query->orderBy($this->sort, $this->order);
        return $query;
    }

    private function add_params($result, $params = [])
    {
        $params = array_merge($params, [
            'sort'     => $this->sort,
            'order'    => $this->order,
            'page_num' => $this->page_num,
        ]);
        foreach ($params as $k => $v) {
            $this->assign[$k] = $v;
            $result->appends([$k => $v]);
        }
        return $result;
    }

    private function sort_arr($page, $sort_arr)
    {
        $arr       = [];
        $order_arr = [
            'desc' => 'asc',
            'asc'  => 'desc',
        ];
        foreach ($sort_arr as $v) {
            if ($v == $this->sort) {
                $this_page = str_replace($this->order, $order_arr[$this->order], $page);
                $arr[$v]   = 'class="sorting_' . $this->order . '" onclick="go_sort(\'' . $this_page . '\')"';
            } else {
                $this_page = str_replace($this->order, 'desc', $page);
                $this_page = str_replace($this->sort, $v, $this_page);
                $arr[$v]   = 'class="sorting" onclick="go_sort(\'' . $this_page . '\')"';
            }
        }
        return $arr;
    }

    public function page_num_check($max_num = 50, $default = 15)
    {
        $this->page_num = intval(Request::input('page_num', $default));
        if ($this->page_num > $max_num) {
            $this->page_num = $max_num;
        }
        return $this->page_num;
    }

    public function set($model, $action = '')
    {
        $this->model = $model;
        $this->middleware(function ($request, $next) use ($action) {
            $this->user             = auth()->user();
            $this->assign['user']   = $this->user;
            $this->assign['action'] = $action;
            return $next($request);
        });
    }

}