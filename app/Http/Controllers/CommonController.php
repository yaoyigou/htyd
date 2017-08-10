<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function get_region_list(Request $request)
    {
        $pid         = intval($request->input('pid'));
        $region_list = get_region_list($pid);
        return $region_list;
    }
}
