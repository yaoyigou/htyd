<?php

namespace App\Http\Controllers;

use App\Common\Page;
use App\Models\OrderAction;
use App\Models\OrderInfo;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use Page;

    public $model;

    public function __construct(OrderInfo $model)
    {
        $this->model = $model;
        $this->middleware(function ($request, $next) {
            $this->user             = auth()->user();
            $this->assign['user']   = $this->user;
            $this->assign['action'] = 'order';
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date        = intval($request->input('date'));
        $order_sn    = trim($request->input('order_sn'));
        $this->sort  = trim($request->input('sort', 'order_id'));
        $this->order = trim($request->input('order', 'desc'));
        $query       = $this->model->where('user_id', $this->user->user_id);
        switch ($date) {
            case 0:
                $query = $query->where('add_time', '>=', strtotime('-3 month'));
                break;
            case 1:
                $query = $query->where('add_time', '>=', strtotime(date('Y') . '-01-01'))
                    ->where('add_time', '<', strtotime((date('Y') + 1) . '-01-01'));
                break;
            case 2:
                $query = $query->where('add_time', '<', strtotime(date('Y') . '-01-01'));
                break;
        }
        if (!empty($order_sn)) {
            $query = $query->where('order_sn', 'like', '%' . $order_sn . '%');
        }
        $request->offsetSet('date', $date);
        $request->offsetSet('order_sn', $order_sn);
        $query                  = $this->sort_order($query);
        $result                 = $query->Paginate($this->page_num);
        $result                 = $this->add_params($result, $request->all());
        $this->assign['result'] = $result;
        return view('order.index', $this->assign);
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

    public function ddgz(Request $request, OrderAction $orderAction)
    {
        if ($request->ajax()) {
            $order_id = $request->input('order_ids');
            $rows     = $orderAction->where('order_id', $order_id)->orderBy('log_time', 'desc')->get();
            $status   = [];  //订单操作记录
            //llPrint($status);
            if ($rows->isEmpty()) {
                $rs       = $this->model->where('order_id', $order_id)
                    ->select('add_time')
                    ->first();
                $status[] = [
                    'status' => 0,
                    'con'    => '您的订单已提交，等待系统审核。',
                    'times'  => date('Y-m-d H:i:s', $rs['add_time']),
                ];
            } else {
                foreach ($rows as $row) {
                    if ($row->order_status == 1 && $row->pay_status == 0 && $row->shipping_status == 0) {
                        $status[] = [
                            'status' => 1,
                            'con'    => '请您尽快完成付款，订单为未付款。',
                            'times'  => date('Y-m-d H:i:s', $row['log_time']),
                        ];
                    }
                    if ($row->order_status == 1 && ($row->pay_status == 2 || $row->pay_status == 1) && $row->shipping_status == 0) {
                        $status[] = [
                            'status' => 2,
                            'con'    => '您的订单商家正在积极备货中，未发货。',
                            'times'  => date('Y-m-d H:i:s', $row['log_time']),
                        ];
                    }
                    if ($row->order_status == 1 && ($row->pay_status == 2 || $row->pay_status == 1) && $row->shipping_status == 1) {
                        $status[] = [
                            'status' => 3,
                            'con'    => '您的订单商家已开票。',
                            'times'  => date('Y-m-d H:i:s', $row['log_time']),
                        ];
                    }
                    if ($row->order_status == 1 && ($row->pay_status == 2 || $row->pay_status == 1) && $row->shipping_status == 2) {
                        $status[] = [
                            'status' => 4,
                            'con'    => '您的订单正在出库中，请您耐心等待。',
                            'times'  => date('Y-m-d H:i:s', $row['log_time']),
                        ];
                    }
                    if ($row->order_status == 1 && ($row->pay_status == 2 || $row->pay_status == 1) && $row->shipping_status == 3) {
                        $status[] = [
                            'status' => 5,
                            'con'    => '您的订单现已出库。',
                            'times'  => date('Y-m-d H:i:s', $row['log_time']),
                        ];
                    }
                    if ($row->order_status == 1 && ($row->pay_status == 2 || $row->pay_status == 1) && $row->shipping_status == 4) {
                        $status[] = [
                            'status' => 6,
                            'con'    => '您的订单已发货。',
                            'times'  => date('Y-m-d H:i:s', $row['log_time']),
                        ];
                    }
                    if ($row->order_status == 1 && ($row->pay_status == 2 || $row->pay_status == 1) && $row->shipping_status == 5) {
                        $status[] = [
                            'status' => 7,
                            'con'    => '<font color="red">您的订单已送达成功！已完成。</font>',
                            'times'  => date('Y-m-d H:i:s', $row['log_time']),
                        ];
                    }
                    if ($row->order_status == 2 && $row->pay_status == 0) {
                        $status[] = [
                            'status' => 8,
                            'con'    => '<font color="red">您的订单已取消。</font>',
                            'times'  => date('Y-m-d H:i:s', $row['log_time']),
                        ];
                    }
                }
            }
            return view('layouts.ddgz')->with(['status' => $status]);
        } else {
            exit;
        }
    }
}
