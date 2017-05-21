<?php

namespace App\Http\Controllers;

use Swagger\scan;

class SwaggerController extends Controller
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

    public function json(){
        define("API_HOST",trim(str_replace('http://','',env('APP_DOMAIN')),'/'));
        define("API_DEFAULT_TOKEN","60956478358d31d2b9c057790534965");
        $swagger = \Swagger\scan(base_path().'/app/Http/Controllers');
        header('Content-Type: application/json');
        return $swagger;
    }
}
