<?php

namespace App\Http\Controllers\Admin;

use App\Models\Node;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RolesController extends BaseController
{
    /**
     * 角色列表显示
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $kw = $request->get('kw');
        $roles = Role::withTrashed()->when($kw, function ($query) use ($kw) {
            $query->where('name', 'like', "%{$kw}%");
        })->paginate($this->pagesize);
        return view('admin.roles.index', compact('roles', 'kw'));
    }

    /**
     * Show the form for creating a new resource.
     * 角色添加显示
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     * 角色添加处理
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required|unique:roles,name'
            ]);
        } catch (\Exception $e) {
            return ['status' => 422, 'msg' => '验证不通过'];
        }
        $role = $request->only('name');
        Role::create($role);
        return ['status' => 0, 'msg' => '添加成功'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * 角色编辑显示
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        return view('admin.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     * 角色编辑处理
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'name' => "required|unique:roles,name,{$id},id"
            ]);
        } catch (\Exception $e) {
            return ['status' => 422, 'msg' => '验证不通过'];
        }

        $update_data = $request->only(['name']);
        Role::where('id', $id)->update($update_data);
        return ['status' => 0, 'msg' => '修改完成'];

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::find($id)->delete();
        return ['status' => 0, 'msg' => '删除成功'];
    }

    /**
     * 还原
     * @param $user_id
     * @return $this
     */
    public function restore($user_id)
    {
        Role::withTrashed()
            ->where('id', $user_id)
            ->restore();
        return redirect()->route('admin.roles.index')->with('success', '还原成功');
    }

    /**
     * 全选删除
     * @param Request $request
     * @return array
     */
    public function delall(Request $request)
    {
        $ids = $request->get('ids');
        Role::destroy($ids);
        return ['status' => 0, 'msg' => '全选删除成功'];
    }

    // 显示给角色分配权限页面
    public function node(Role $role)
    {
        // 读取出所有的权限
        $nodeAll =  treeLevel((new Node())->all()->toArray());
        // 读取当前角色所拥有的权限
        $nodes = $role->nodes()->pluck('id')->toArray();
        return view('admin.roles.node', compact('role', 'nodeAll', 'nodes'));
    }

    // 给角色分配权限处理
    public function nodeSave(Request $request, Role $role)
    {
        $node_ids = $request->get('node_ids');
        $role->nodes()->sync($node_ids);
        return redirect()->route('admin.roles.node', $role)->with('success', '修改成功');
    }
}
