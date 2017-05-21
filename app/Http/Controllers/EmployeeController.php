<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeNumberModel;
use App\RPC\MoorRpc;
use Log;
use DB;

class EmployeeController extends Controller
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
     * 分页获取客服信息列表
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/employees",
     *     summary="分页获取客服信息列表",
     *     description="分页获取客服信息列表",
     *     operationId="employee.pageList",
     *     produces={"application/json"},
     *     tags={"工号设置"},
     *     @SWG\Parameter(in="header",name="token",default="60956478358d31d2b9c057790534965",type="string",description="认证token"),
     *     @SWG\Parameter(in="query",name="page",default="1",type="integer",description="页码"),
     *     @SWG\Parameter(in="query",name="pageSize",default="10",type="integer",description="每页数据量"),
     *     @SWG\Response(
     *        response=200,
     *        description="分页获取客服信息列表",
     *        @SWG\Schema(),
     *        examples={
     *              "data": {
     *                  "no":"int序号列",
     *                  "user_id":"int用户ID",
     *                  "job_number": "string客服工号",
     *                  "department": "string工号部门",
     *                  "user_name": "stiring系统帐号",
     *                  "nickname": "stiring姓名",
     *                  "channel_name": "stiring渠道商",
     *                  "status": "int状态1:有效;2:无效",
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
    public function pageList(Request $request)
    {
        $page = intval($request->input('page', 1));
        $pageSize = intval($request->input('pageSize', 10));

        $employeeNumberModel = EmployeeNumberModel::query();
        $employeeNumberModel->select('user_id', 'job_number', 'department', 'user_name', 'nickname',
            'channel_id', 'status', 'created_at', 'updated_at');
        $total = $employeeNumberModel->count();

        $result = [];

        $result['total'] = $total;      //总记录数
        $result['page'] = $page;        //当前页
        $result['pageSize'] = $pageSize;    //每页数量

        if ($total > 0) {
            $result['data'] = $employeeNumberModel->orderBy('id', 'DESC')->skip(($page - 1) * $pageSize)->take($pageSize)->get()->toArray();
            $serial_number = ($page - 1) * $pageSize;
            foreach ($result['data'] as $key=>$val){
                $result['data'][$key]['no'] = ++$serial_number;
            }
        } else {
            $result['data'] = [];
        }
        $this->success($result,'操作成功!');
    }
    /**
     * 获取客服详细信息
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/employees/{user_id}",
     *     summary="获取客服详细信息",
     *     description="获取客服详细信息",
     *     operationId="employee.find",
     *     produces={"application/json"},
     *     tags={"工号设置"},
     *     @SWG\Parameter(in="header",name="token",default="60956478358d31d2b9c057790534965",type="string",description="认证token"),
     *     @SWG\Parameter(in="path",name="user_id",default="1",type="integer",description="用户ID"),
     *     @SWG\Parameter(in="query",name="channel_id",default="1",type="integer",description="渠道ID"),
     *     @SWG\Response(
     *        response=200,
     *        description="获取客服详细信息",
     *        @SWG\Schema(),
     *        examples={
     *              "user_id":"int用户id",
     *              "job_number": "string客服工号",
     *              "department": "string工号部门",
     *              "user_name": "stiring系统帐号",
     *              "nickname": "stiring姓名",
     *              "channel_id": "stiring渠道ID",
     *              "channel_name": "stiring渠道商",
     *              "status": "int状态1:有效;2:无效",
     *        }
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized action.",
     *     ),
     * )
     */
    public function find(Request $request,$user_id)
    {
        $data = EmployeeNumberModel::select('user_id', 'job_number', 'department', 'user_name', 'nickname',
            'channel_id', 'status', 'account', 'password', 'created_at', 'updated_at')
            ->where('user_id',$user_id)->find();
        if(!empty($data)){
            $this->success($data,'操作成功');
        }else{
            $this->fail([],'操作失败!');
        }
    }
    /**
     * 根据渠道获取渠道下的所有客服信息
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/cuservices",
     *     summary="根据渠道获取渠道下的所有客服信息",
     *     description="根据渠道获取渠道下的所有客服信息",
     *     operationId="employee.cuservice",
     *     produces={"application/json"},
     *     tags={"工号设置"},
     *     @SWG\Parameter(in="header",name="token",default="60956478358d31d2b9c057790534965",type="string",description="认证token"),
     *     @SWG\Parameter(in="query",name="channel_id",default="1",type="integer",description="渠道ID"),
     *     @SWG\Response(
     *        response=200,
     *        description="根据渠道获取渠道下的所有客服信息",
     *        @SWG\Schema(),
     *        examples={
     *              "id":"int用户ID",
     *              "user_name":"string系统帐号",
     *              "full_name": "string姓名",
     *        }
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized action.",
     *     ),
     * )
     */
    public function cuservices()
    {
        $users = DB::connection('permissions')->table('user')->select('id','user_name','full_name')
            ->where('user_type',9)->where('status',1)->get()->toArray();
        $this->success($users,'操作成功');
    }
    /**
     *  创建客服
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Post(
     *     path="/employees",
     *     summary="创建客服",
     *     description="创建客服",
     *     operationId="employees.create",
     *     produces={"application/json"},
     *     tags={"工号设置"},
     *     @SWG\Parameter(in="header",name="token",default="60956478358d31d2b9c057790534965",type="string",description="认证token"),
     *     @SWG\Response(
     *        response=200,
     *        description="创建客服",
     *        @SWG\Schema(),
     *        examples={
     *              "user_id":"int用户id",
     *              "job_number":"int工号",
     *              "department":"string部门",
     *              "user_name":"string用户账号",
     *              "nickname":"string姓名",
     *              "channel_id":"int渠道id",
     *              "status": "int状态1:有效;2:无效",
     *        }
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized action.",
     *     ),
     * )
     */
    public function create(Request $request)
    {
        $data = $request->intersect(['user_id', 'job_number','department','user_name','nickname',
            'channel_id','status']);
        $employeeNumberModel = new EmployeeNumberModel();
        //在7陌7moor注册账号
        $moorRpc = new MoorRpc();
        $moorRpc->getAccount([
            'Exten'=> $data['job_number']
        ]);
        if(!$moorRpc->getResultData()){
            $this->fail([],'关联客服账号失败!');
        }
        $moorAccount = $moorRpc->getResultData();
        if(!(is_array($moorAccount) && count($moorAccount) > 0)){
            $this->fail([],'工单号输入错误!');
        }
        $data['account'] = $moorAccount[0]['loginName'];
        $data['password'] = $moorAccount[0]['password'];
        $result = $employeeNumberModel->fill($data)->save();
        if($result){
            $this->success($employeeNumberModel->toArray(),'操作成功!');
        }else{
            $this->fail([],'操作失败!');
        }
    }
    /**
     *  修改客服详细信息
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Put(
     *     path="/employees/{user_id}",
     *     summary="修改客服详细信息",
     *     description="修改客服详细信息",
     *     operationId="employees.modify",
     *     produces={"application/json"},
     *     tags={"工号设置"},
     *     @SWG\Parameter(in="header",name="token",default="60956478358d31d2b9c057790534965",type="string",description="认证token"),
     *     @SWG\Parameter(in="path",name="user_id",default="1",type="integer",description="用户ID"),
     *     @SWG\Parameter(in="query",name="status",default="1",type="integer",description="状态1:有效;2:无效"),
     *     @SWG\Response(
     *        response=200,
     *        description="修改客服详细信息",
     *        @SWG\Schema(),
     *        examples={
     *              "user_id":"int用户id",
     *              "status": "int状态1:有效;2:无效",
     *        }
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized action.",
     *     ),
     * )
     */
    public function modify(Request $request, $user_id)
    {
        $data = $request->intersect(['status']);
        $employeeNumberModel = new EmployeeNumberModel();
        $result = $employeeNumberModel->where('user_id', $user_id)->update($data);
        if($result){
            $this->success([],'操作成功!');
        }else{
            $this->fail([],'操作失败!');
        }
    }
}
