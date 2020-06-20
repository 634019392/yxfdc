<?php

namespace App\Http\Controllers\Admin;

use App\Models\Fangattr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FangattrsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = new Fangattr();
        $fangattrs = $model->getList();
        return view('admin.fangattrs.index', compact('fangattrs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pids_0 = Fangattr::where('pid', 0)->get();
        return view('admin.fangattrs.create', compact('pids_0'));
    }

    /**
     * 图片上传
     */
    public function upfile(Request $request) {
        // 默认图标
        $pic = config('up.pic');
        if ($request->hasFile('file')) {
            // 上传
            // 参数2 配置的节点名称
            $ret = $request->file('file')->store('', 'fangattrs');
            $pic = '/uploads/fangattrs/' . $ret;
        }
        return ['status' => 0, 'url' => $pic];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 表单验证
        $this->validate($request, [
            'name' => 'required',
            //'field_name' => 'required'
        ]);

        // 验证通过后，入库并跳转到列表页面
        // 获取数据
        $postData = $request->except(['_token', 'file']);
        // 因为字段不能为null，而我们没有传数据，所以一定解决手段
        $postData['field_name'] = !empty($postData['field_name']) ? $postData['field_name'] : '';
        // 入库
        Fangattr::create($postData);
        // 跳转
        return redirect(route('admin.fangattrs.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Fangattr $fangattr)
    {
        $pids_0 = Fangattr::where('pid', 0)->get();
        return view('admin.fangattrs.edit', compact('fangattr', 'pids_0'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fangattr $fangattr)
    {
        // 表单验证
        $this->validate($request, [
            'name' => 'required',
            //'field_name' => 'required'
        ]);

        // 验证通过后，入库并跳转到列表页面
        // 获取数据
        $postData = $request->except(['_token', 'file', '_method']);
        // 如果pid为0(首级)则不允许更新
        if ($fangattr->pid == 0) {
            $postData['pid'] = 0;
        }
        // 因为字段不能为null，而我们没有传数据，所以一定解决手段
        $postData['field_name'] = !empty($postData['field_name']) ? $postData['field_name'] : '';
        $fangattr->update($postData);
        return redirect()->route('admin.fangattrs.index')->with('success', '编辑成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
