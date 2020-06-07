<?php

namespace App\Models;

class Article extends Base
{
    protected $appends = ['action'];

    public function getActionAttribute()
    {
        return $this->editBtn('admin.articles.edit').'  '.$this->deleteBtn('admin.articles.destroy');
    }
}
