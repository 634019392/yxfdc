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

    // 带弹框class的删除
    public function destroyBtn($route_name)
    {
        if (auth()->user()->username != config('rbac.super') && !in_array($route_name, request()->admin_auth)) {
            return '';
        } else {
            return '<a href="' . route($route_name, $this) . '" class="label label-danger radius delbtn">删除</a>';
        }
    }

    // 判断权限的自定义按钮
    // {{ route('admin.users.edit', $user) }}
    public function atWillBtn($route_name, $btnName = '跟踪', $class = 'label-secondary')
    {
        if (auth()->user()->username != config('rbac.super') && !in_array($route_name, request()->admin_auth)) {
            return '';
        } else {
            return '<a href="' . route($route_name, $this) . '" class="label '.$class.' radius">'.$btnName.'</a>';
        }
    }

    // 模态框
    public function atWillModal($route_name, $btnName = '编辑', $is_permission = true, $class = 'btn-secondary')
    {
        if (auth()->user()->username != config('rbac.super') && !in_array($route_name, request()->admin_auth) && !$is_permission) {
            return '';
        } else {
            return '<button class="btn '.$class.' radius size-S at-will-modal" data-id='.$this->id.'>'.$btnName.'</button>';
        }
    }
}