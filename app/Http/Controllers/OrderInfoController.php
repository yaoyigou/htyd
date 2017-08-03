<?php

namespace App\Http\Controllers;

use App\Models\OrderAction;
use App\Models\OrderInfo;
use Illuminate\Http\Request;

class OrderInfoController extends Controller
{
    public $model;

    public $user;

    public $assign = [];

    public $sort;

    public $order;

    public $page_num;

    public function __construct(OrderInfo $orderInfo)
    {
        $this->model          = $orderInfo;
        $this->user           = auth()->user();
        $this->assign['user'] = $this->user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
