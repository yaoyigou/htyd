<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class IndexController extends Controller
{
    public $user;

    public $assign = [];

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user           = auth()->user();
            $this->assign['user'] = $this->user;
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        //Cache::flush();
        $this->assign['ad121']  = get_ads(121);
        $this->assign['ad123']  = get_ads(123);
        $this->assign['ad126']  = get_ads(126);
        $this->assign['ad127']  = get_ads(127);
        $this->assign['ad128']  = get_ads(128);
        $this->assign['ad129']  = get_ads(129);
        $this->assign['ad130']  = get_ads(130);
        $this->assign['ad131']  = get_ads(131);
        $this->assign['ad133']  = get_ads(133);
        $this->assign['ad134']  = get_ads(134);
        $this->assign['ad135']  = get_ads(135);
        $this->assign['floor1'] = get_floor(1);
        $this->assign['floor2'] = get_floor(2);
        $this->assign['floor3'] = get_floor(3);
        return view('index', $this->assign);
    }
}
