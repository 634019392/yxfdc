<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\URL;

class CheckAdminLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->check()) {
            session()->flash('danger', '请登录');
            return redirect()->route('admin.login');
        }

        // 中间件权限控制
        $current_route_name = $request->route()->getName();
        $c_user_node = [];
        // 如果传入的是数组则不是超级管理员
        if (is_array(session('admin.auth'))) {
            $c_user_node = array_filter(session('admin.auth'));
        }
        $allow_route = array_merge(config('rbac.allow_route'), $c_user_node);
        if (auth()->user()->username != config('rbac.super') && !in_array($current_route_name, $allow_route)) {
            $previousUrl = URL::previous();
            return response()->view('admin.common._permission', compact('previousUrl'));
            exit('没有权限，此处页面要优化');
        }

        // 自定义请求对象（允许的权限数组）
        $request->admin_auth = $allow_route;

        return $next($request);
    }
}
