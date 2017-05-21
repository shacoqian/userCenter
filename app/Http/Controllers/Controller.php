<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

/**
 * @SWG\Swagger(
 *     basePath="",
 *     host=API_HOST,
 *     produces={"application/json"},
 *     schemes={"http"},
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="客服系统 API",
 *         description="客服系统 API文档"
 *     ),
 *     @SWG\Definition(
 *         definition="Error",
 *         required={"code", "message"},
 *         @SWG\Property(
 *             property="code",
 *             type="integer",
 *             format="int32"
 *         ),
 *         @SWG\Property(
 *             property="message",
 *             type="string"
 *         )
 *     )
 * )
 */
class Controller extends BaseController
{
    //

    /**
     * 操作成功
     * @param $data
     * @param $msg
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($data,$msg)
    {
        return response()->json(['apistatus'=>1,'result'=>$data,'msg'=>$msg]);
    }

    /**
     * 操作失败
     * @param $data
     * @param $msg
     * @return \Illuminate\Http\JsonResponse
     */
    protected function fail($data,$msg)
    {
        return response()->json(['apistatus' => 0, 'result' => $data, 'msg' => $msg]);
    }

}
