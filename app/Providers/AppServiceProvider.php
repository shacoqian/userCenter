<?php

namespace App\Providers;

use App\Libraries\RequestRate;
use Illuminate\Support\ServiceProvider;
use Log;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $_this = $this;
        //
        if (env('APP_DEBUG')) {
            $this->app['db']->listen(function ($query) use ($_this) {
                $_this->record($query->sql, $query->bindings, $query->time);
            });
        }

    }

    /**
     * 记录sql
     * @param $sql
     */
    public function record($sql, $bindings, $time)
    {
        Log::info("SQL语句:", ['sql' => $sql, 'bindings' => $bindings, 'time' => $time]);
    }

}
