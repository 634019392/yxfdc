<?php

namespace App\Models;

class Fangattr extends Base
{
    protected $appends = ['action'];

    // 附带权限的编辑和单个删除按钮
    public function getActionAttribute()
    {
        return $this->editBtn('admin.fangattrs.edit').'  '.$this->deleteBtn('admin.fangattrs.destroy');
    }

    // 获取数据
    public function getList() {
        // 获取全部的数据
        $data = self::get()->toArray();
        // 调用父类中的递归层级函数
        return treeLevel($data);
    }
}
