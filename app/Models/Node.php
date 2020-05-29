<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class Node extends Base
{
    use SoftDeletes;

    public function getMenuAttribute()
    {
        $info = [
            0 => ['否', 'warning'],
            1 => ['是', 'success'],
        ];
        $value = $this->is_menu;

        return '<span class="label label-'. $info[$value][1] .' radius">'. $info[$value][0] .'</span>';
    }
}
