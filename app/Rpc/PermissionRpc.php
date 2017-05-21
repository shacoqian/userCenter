<?php
/**
 * 管家数据库远程调用操作类
 */
namespace App\Rpc;

use Log;

class PermissionRpc extends Rpc
{
    public function __construct()
    {
        parent::__construct();
        $this->rpc_domation = env("PERMISSION_API_LOCATION_PREFIX");
    }

    /**
     * 用商户id取服务社信息
     * @param $data
     * @return bool
     */
    public function getServerIno($data){
        try{
            $response = $this->client->request('GET',
                $this->rpc_domation."v1/api/get_service_center",
                [
                    'query' => $data
                ]
            );
            if($response->getStatusCode() == 200){
                $result = json_decode($response->getBody(),true);
                if($result['status'] == 0){
                    $this->result = $result['data'];
                    return true;
                }else{
                    $this->result = $result['msg'];
                    Log::error('用商户id取服务社信息失败', ['data' => $data, 'result' => $result]);
                    return false;
                }
            }else{
                Log::error('用商户id取服务社信息失败,接口返回状态码非200', ['data' => $data]);
                return false;
            }
        } catch(RequestException $e){
            Log::warning('分页获取管家数据失败,网络请求异常');
        }

    }
    /**
     * 判断用户是否有某功能编号的权限
     * @param $query
     * @return bool true if status = 0 and data != false
     * false if status != 0
     */
    public function checkFunctionPermission($data){
        try{
            $response = $this->client->request('GET',
                $this->rpc_domation."v1/api/check_function_permission",
                [
                    'query' => $data
                ]
            );
            if($response->getStatusCode() == 200){
                $result = json_decode($response->getBody(), true);
                if($result['status'] == 0){
                    $this->result = $result['data'];
                    return true;
                }else{
                    $this->result = $result['msg'];
                    Log::error('判断用户是否有某功能编号的权限失败', ['data' => $data, 'result' => $result]);
                    return false;
                }
            }else{
                Log::error('判断用户是否有某功能编号的权限失败,接口返回状态码非200', ['data' => $data]);
                return false;
            }
        } catch(RequestException $e){
            Log::warning('判断用户是否有某功能编号的权限失败,网络请求异常');
        }

    }

    /**
     * 获取当前用户下的全部服务社
     * @param $data
     * @param String $data['userid']
     * @param String $data['city']
     * @return bool
     */
    public function getServiceAgency($data){
        try{
            $response = $this->client->request('GET',
                $this->rpc_domation."v1/api/get_company_agent",
                [
                    'query' => $data
                ]
            );
            if($response->getStatusCode() == 200){
                $result = json_decode($response->getBody(),true);
                if($result['status'] == 0){
                    $this->result = $result['data'];
                    return true;
                }else{
                    $this->result = $result['msg'];
                    Log::error('获取当前用户下的全部服务社失败', ['data' => $data, 'result' => $result]);
                    return false;
                }
            }else{
                Log::error('获取当前用户下的全部服务社失败失败,接口返回状态码非200', ['data' => $data]);
                return false;
            }
        } catch(Exception $e){
            Log::warning('获取当前用户下的全部服务社失败失败,网络请求异常');
        }

    }

    /**
     * 获取登陆管理员信息
     * @param $data
     * @return bool|mixed
     */
    public function getInfo($data){
        try{
            $response = $this->client->request('POST',
                $this->rpc_domation."v1/api/get_user_info",
                [
                    'form_params' => $data,
                    'force_ip_resolve' => 'v4'
                ]
            );
            if($response->getStatusCode() == 200){
                $result = json_decode($response->getBody(),true);
                if($result['status'] == 0){
                    $this->result = $result['data'];
                    return true;
                }else{
                    $this->result = $result['msg'];
                    Log::error('获取登陆管理员信息失败', ['data'=>$data,'result'=>$result]);
                    return false;
                }
            }else{
                Log::error('获取登陆管理员信息失败,接口返回状态码非200', ['data'=>$data]);
                return false;
            }
        } catch(RequestException $e){
            Log::warning('获取登陆管理员信息失败,网络请求异常');
        }
    }
}
