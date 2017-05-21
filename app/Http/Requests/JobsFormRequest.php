<?php
/**
 * Created by PhpStorm.
 * User: qianfeng
 * Date: 17-5-5
 * Time: 上午10:10
 */

namespace App\Http\Requests;


Class JobsFormRequest extends FormRequest {
    public function rules() {
        return [
            ['phone', 'required', 'message' => '手机号不能为空', 'on' => 'getJobsByShUserId_default'],
            ['phone', 'regex:/^1[3-9][0-9]{9}$/', 'message' => '请输入正确的手机号', 'on' => 'getJobsByShUserId_default'],
        ];
    }
}