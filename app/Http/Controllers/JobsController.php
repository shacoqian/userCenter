<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobsModel;
use Log;

class JobsController extends Controller
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

    /**
     * 分页获取工单信息列表
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api/jobs",
     *     summary="分页获取工单信息列表",
     *     description="分页获取工单信息列表",
     *     operationId="jobs.index",
     *     produces={"application/json"},
     *     tags={"工单管理"},
     *     @SWG\Parameter(in="header",name="token",default="60956478358d31d2b9c057790534965",type="string",description="认证token"),
     *     @SWG\Parameter(in="query",name="page",default="1",type="integer",description="页码"),
     *     @SWG\Parameter(in="query",name="pageSize",default="10",type="integer",description="每页数据量"),
     *     @SWG\Parameter(in="query",name="job_number",type="string",description="工单号"),
     *     @SWG\Parameter(in="query",name="order_number",type="string",description="订单号"),
     *     @SWG\Parameter(in="query",name="phone",type="string",description="电话"),
     *     @SWG\Parameter(in="query",name="status",type="integer",description="工单状态1待处理 2处理中 3完成"),
     *     @SWG\Parameter(in="query",name="service_type",type="integer",description="服务类型"),
     *     @SWG\Parameter(in="query",name="channel_id",type="integer",description="渠道商"),
     *     @SWG\Response(
     *        response=200,
     *        description="分页获取工单信息列表",
     *        @SWG\Schema(),
     *        examples={
     *              "data": {
     *                  "no":"int序号列",
     *                  "job_number":"string工单号",
     *                  "type":"int工单类型",
     *                  "status":"int工单状态1待处理 2处理中 3完成",
     *                  "service_type": "int服务类型",
     *                  "channel_id": "int渠道id",
     *                  "channel_name": "string渠道名称",
     *                  "sh_user_id": "int用户ID",
     *                  "phone": "string电话",
     *                  "order_number": "stiring订单号",
     *                  "create_user_name": "stiring创建者工号/帐号",
     *               },
     *              "page": "int页码",
     *              "pageSize": "int每页数据量",
     *              "total": "int总数据量"
     *        }
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized action.",
     *     ),
     * )
     */
    public function index(Request $request)
    {

    }

    /**
     * 根据手机号获取工单列表
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api/jobs",
     *     summary="根据手机号获取工单列表",
     *     description="根据手机号获取工单列表",
     *     operationId="jobs.index",
     *     produces={"application/json"},
     *     tags={"工单管理"},
     *     @SWG\Parameter(in="header",name="token",default="60956478358d31d2b9c057790534965",type="string",description="认证token"),
     *     @SWG\Parameter(in="header",name="auth",default="on",type="string",description="是否需要验证token"),
     *     @SWG\Parameter(in="header",name="field_code",default="default",type="string",description="参数验证码"),
     *     @SWG\Parameter(in="query",name="phone",default="",type="integer",description="手机号"),
     *     @SWG\Response(
     *        response=200,
     *        description="根据手机号获取工单列表",
     *        @SWG\Schema(),
     *        examples={
     *              "data": {
     *                  "id":"int序号列",
     *                  "job_number":"string工单号",
     *                  "type":"int工单类型",
     *                  "status":"int工单状态1待处理 2处理中 3完成",
     *                  "service_type": "int服务类型",
     *                  "channel_id": "int渠道id",
     *                  "channel_name": "string渠道名称",
     *                  "sh_user_id": "int用户ID",
     *                  "phone": "string电话",
     *                  "order_number": "stiring订单号",
     *               },
     *              "page": "int页码",
     *              "pageSize": "int每页数据量",
     *              "total": "int总数据量"
     *        }
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized action.",
     *     ),
     * )
     */
    public function getJobsByShUserId(Request $request) {
        $phone = $request->input('phone');

        $result['data'] = JobsModel::select(
            'id',
            'job_number',
            'status',
            'created_at',
            'service_type',
            'channel_id',
            'type',
            'order_number'
        )->where('phone', '=', $phone)->get()->toArray();

        return $this->success($result, '请求成功!');
    }



}
