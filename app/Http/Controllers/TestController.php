<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;

class TestController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index() {
        echo 111;
    }
}
