<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public $user;

    public $assign = [];

    public function __construct()
    {
        $this->user           = auth()->user();
        $this->assign['user'] = $this->user;
    }

    public function index()
    {
        return view('index', $this->assign);
    }
}
