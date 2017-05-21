<?php
/**
 * Created by PhpStorm.
 * User: qianfeng
 * Date: 17-5-8
 * Time: 上午9:51
 */

namespace App\Services;

use App\Models\JobLogModel;


class JobLogService {

    //根据工单id获取工单日志
    public function listByJobId_default($job_id) {
        return JobLogModel::where('job_id', '=', $job_id)->get()->toArray();
    }

    //增加工单日志
    public function addJobLog($params) {
        return (new JobLogModel())->fill($params)->save();
    }


}