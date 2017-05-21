<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\JobLogService;
use Log;

class JobLogController extends Controller
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
     * 根据工单id获取工单记录列表
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api/joblogs/{id}",
     *     summary="根据工单id获取工单记录列表",
     *     description="根据工单id获取工单记录列表",
     *     operationId="JobLog.listByJobId",
     *     produces={"application/json"},
     *     tags={"工单日志"},
     *     @SWG\Parameter(in="header",name="token",default="60956478358d31d2b9c057790534965",type="string",description="认证token"),
     *     @SWG\Parameter(in="header",name="auth",default="on",type="string",description="是否开启验证token"),
     *     @SWG\Parameter(in="header",name="field_code",default="default",type="string",description="领域值 默认default"),
     *     @SWG\Response(
     *        response=200,
     *        description="根据工单id获取工单记录列表",
     *        @SWG\Schema(),
     *        examples={
     *              "data": {
     *                  "id":"int序号列",
     *                  "employee_id":"int工号id",
     *                  "user_name": "string客服工号或者用户账号",
     *                  "store_name": "string 门店名称",
     *                  "job_status_text": "stiring 工单状态",
     *                  "operate_log": "stiring 工单操作日志",
     *                  "remarks": "stiring 备注",
     *                  "channel_id": "int 渠道id",
     *                  "created_at": "date 创建时间",
     *               }
     *        }
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized action.",
     *     ),
     * )
     */
    public function listByJobId(Request $request, $id)
    {
        $result['data'] = (new JobLogService())->listByJobId_default($id);
        return $this->success($result, '请求成功!');
    }




}
