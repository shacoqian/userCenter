<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class FieldsMiddleware
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $is_validate = $request->header(env("IS_VALIDATE"));
        if (! in_array($is_validate , ['on', 'off'])) {
            return response()->json(['apistatus'=>301,'msg'=>'auth 参数错误!']);
        }
        $request->attributes->set('auth', $is_validate);
        //todo: 设置场景
        //验证领域
        $field_code = $request->header(env("FIELD_CODE"), 'default');
        $request->attributes->set('senario', $field_code);
        if ($is_validate == 'on') {
            return (new Authenticate($this->auth))->handle($request, $next);
        }
        return $next($request);
    }
}
