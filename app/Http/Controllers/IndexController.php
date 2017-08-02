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
        $this->user           = auth()->user();
        $this->assign['user'] = $this->user;
    }

    public function index(Request $request)
    {
        //Cache::flush();
        $this->assign['ad121']       = get_ads(121);
        $this->assign['ad123']       = get_ads(123);
        $this->assign['ad126']       = get_ads(129);
        $this->assign['floors']      = get_floors();
        return view('index', $this->assign);
    }
}
