<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;

class DeployController extends Controller
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

    public function run(Request $request){
        if($request->input("ref") === 'refs/heads/test'){
            if(env('APP_ENV') == "testing"){
                Log::info('开始发布程序');
                exec("/usr/bin/sudo /bin/sh /srv/deploy_script/hmp_api.sh",$output,$retval);
                var_dump($output);
                var_dump($retval);
                if($retval === 0){
                    Log::info('程序发布成功');
                }else{
                    Log::info('程序发布失败');
                }
            }
        }


    }
}
