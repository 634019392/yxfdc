<?php

namespace App\Http\Controllers\Admin;

use App\Models\Node;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexsController extends Controller
{
    public function index()
    {
        $query = Node::where('is_menu', '1');
        if (is_array(session('admin.auth'))) {
            $c_user_node_ids = array_keys(session('admin.auth'));
            $query->whereIn('id', $c_user_node_ids);
        }
        $nodes = $query->get()->toArray();

        // 主菜单转换渲染格式
        $menus = subTree($nodes);
        return view('admin.index.index', compact('menus'));
    }

    public function welcome()
    {
        return view('admin.index.welcome');
    }
}
