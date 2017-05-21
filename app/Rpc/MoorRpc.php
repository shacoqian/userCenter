<?php
/**
 * 7moor远程对接操作类
 */
namespace App\Rpc;

use Log;

class MoorRpc extends Rpc
{
    /**
     * 7moor账号
     * @var mixed
     */
    private $accountId;
    /**
     * 7moor APISecret
     * @var mixed
     */
    private $accountSecret;

    public function __construct()
    {
        parent::__construct();
        $this->rpc_domation = env("MOOR_API_LOCATION_PREFIX");
        $this->accountId = env("MOOR_ACCOUNT_ID");
        $this->accountSecret = env("MOOR_ACCOUNT_AECRET");
        $this->headers = [
            'Authorization' => $this->generateAuthorization()
        ];
    }

    /**
     * 生成7moor需要的授权签名
     * @return mixed
     */
    private function generateAuthorization()
    {
        return Base64($this->accountId . ':' . date('YmdHms', time()));
    }

    /**
     * 生成7moor需要的鉴权验签
     * @return mixed
     */
    private function generateSig()
    {
        return Base64($this->accountId . $this->accountSecret . date('YmdHms', time()));
    }

    /**
     * 根据座席工号查询坐席接口
     * @param $data ['Exten'] 座席工号
     * @return bool
     */
    public function getAccount($data)
    {
        try {
            $response = $this->client->request('GET',
                $this->rpc_domation . "v20160818/account/getCCAgentsByAcc/".$this->accountId,
                [
                    'header' => $this->headers ,
                    'query' => [
                        'sig' => $this->generateSig()
                    ],
                    'json' => $data
                ]
            );
            if ($response->getStatusCode() == 200) {
                $result = json_decode($response->getBody(), true);
                if ($result['code'] == 200) {
                    $this->result = $result['data'];
                    return true;
                } else {
                    $this->result = $result['message'];
                    Log::error('根据座席工号查询坐席接口失败', ['data' => $data, 'result' => $result]);
                    return false;
                }
            } else {
                Log::error('根据座席工号查询坐席接口失败,接口返回状态码非200', ['data' => $data]);
                return false;
            }
        } catch (RequestException $e) {
            Log::warning('根据座席工号查询坐席接口失败,网络请求异常');
        }

    }

}
