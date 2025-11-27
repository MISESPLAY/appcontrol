<?php

namespace App\Models\Home\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class HomeController extends controller

{
    public function index():view {
        return view('index');


    }


}
