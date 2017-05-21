<?php

namespace App\Rpc;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class Rpc
{

    protected $client;
    protected $rpc_domation;
    protected $headers;
    protected $result;
    protected $error_message;
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * 获取错误消息
     * @return mixed
     */
    public function getErrorMessage(){
        return $this->error_message;
    }

    /**
     * 获取返回数据
     * @return mixed
     */
    public function getResultData(){
        return $this->result;
    }

}
