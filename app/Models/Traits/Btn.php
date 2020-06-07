<?php
/**
 * Created by PhpStorm.
 * User: LL
 * Date: 2020/5/30
 * Time: 22:58
 */

namespace App\Models\Traits;

trait Btn
{
    // 判断权限的编辑按钮
    // {{ route('admin.users.edit', $user) }}
    public function editBtn($route_name)
    {
        if (auth()->user()->username != config('rbac.super') && !in_array($route_name, request()->admin_auth)) {
            return '';
        } else {
            return '<a href="' . route($route_name, $this) . '" class="label label-secondary radius">编辑</a>';
        }
    }

    public function deleteBtn($route_name)
    {
        if (auth()->user()->username != config('rbac.super') && !in_array($route_name, request()->admin_auth)) {
            return '';
        } else {
            return '<a href="' . route($route_name, $this) . '" class="label label-danger radius">删除</a>';
        }
    }
}