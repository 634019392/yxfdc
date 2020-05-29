<?php

namespace App\Http\Controllers\Admin;

use App\Models\Node;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class NodesController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $kw = $request->get('kw');
        $nodes = Node::withTrashed()->when($kw, function($query) use ($kw) {
            $query->where('name', 'like', "%{$kw}%");
        })->get();
        $nodes = treeLevel($nodes->toArray());

        return view('admin.nodes.index', compact('nodes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pids_0 = Node::where('pid', 0)->get();
        return view('admin.nodes.create', compact('pids_0'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required|unique:nodes,name',
                'is_menu' => 'required'
            ]);
        } catch (\Exception $e) {
            return ['status' => '422', 'msg' => '验证信息没通过'];
        }
        $create_data = $request->only(['name', 'route_name', 'is_menu', 'pid']);
        Node::create($create_data);
        return ['status' => 0, 'msg' => '添加成功'];

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Node  $node
     * @return \Illuminate\Http\Response
     */
    public function show(Node $node)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Node  $node
     * @return \Illuminate\Http\Response
     */
    public function edit(Node $node)
    {
        $pids_0 = Node::where('pid', 0)->get();
        return view('admin.nodes.edit', compact('node', 'pids_0'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Node  $node
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Node $node)
    {
        try {
            $this->validate($request, [
                'name' => "required|unique:nodes,name,{$node->id},id",
                'is_menu' => 'required'
            ]);
        } catch (\Exception $e) {
            return ['status' => '422', 'msg' => '验证信息没通过'];
        }
        $update_data = $request->only('name', 'route_name', 'is_menu', 'pid');
        $node->update($update_data);
        return ['status' => 0, 'msg' => '修改成功'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Node  $node
     * @return \Illuminate\Http\Response
     */
    public function destroy(Node $node)
    {
        //
    }
}
