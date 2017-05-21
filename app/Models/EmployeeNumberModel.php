<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeNumberModel extends Model
{
    protected $table = 'employee_number';

    protected $fillable = ['user_id','job_number','department','user_name','nickname','channel_id',
        'status','account','password','created_at','updated_at'
    ];

}
