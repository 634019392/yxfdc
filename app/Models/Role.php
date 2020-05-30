<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Base
{
    use SoftDeletes;

    // 参1 关联模型
    // 参2 中间表的表名，没有前缀
    // 参3 本模型对应的外键ID
    // 参4 关联模型对应的外键ID
    public function nodes()
    {
        return $this->belongsToMany(Node::class, 'role_node', 'role_id', 'node_id');
    }
}
