<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginsController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            return redirect()->route('admin.index');
        }

        return view('admin.logins.index');
    }

    public function login(Request $request)
    {
        $post = $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => '用户名 是不是忘记填了?',
            'password.required' => '密码 是不是忘记填了?'
        ]);

        if (auth()->attempt($post, $request->has('remember'))) {
            $c_user_node = auth()->user()->role->nodes()->pluck('route_name', 'id')->toArray();
            if (auth()->user()->username != config('rbac.super')) {
                session(['admin.auth' => $c_user_node]);
            } else {
                session(['admin.auth' => true]);
            }

            return redirect()->route('admin.index');
        } else {
            return redirect()->route('admin.login')->withErrors(['error' => '登录失败  /(ㄒoㄒ)/~~']);
        }
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('admin.login')->with('success', "用户成功退出 (●'◡'●)");
    }
}
