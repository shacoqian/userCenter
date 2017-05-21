<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobLogModel extends Model
{
    protected $table = 'job_log';

    protected $fillable = ['user_id','employee_id','user_id','user_name','store_name','job_status_text',
        'operate_log','remarks','created_at','channel_id',
    ];

}
