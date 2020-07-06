<?php

namespace App\Http\Controllers\Admin;

use App\Models\Fangowner;
use Illuminate\Http\Request;
use App\Exports\FangownersExport;
use Maatwebsite\Excel\Facades\Excel;

class FangownersController extends BaseController
{
    // 列表
    public function index()
    {
        // 获取用户数据
        $fangowners = Fangowner::paginate($this->pagesize);
        // 赋值给视图模板
        return view('admin.fangowners.index', compact('fangowners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.fangowners.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'card' => 'required',
            'address' => 'required',
            'pic' => 'required',
        ]);
        $postData = $request->except('_token', 'file');
        // 去除#
        $postData['pic'] = trim($postData['pic'], '#');

        Fangowner::create($postData);
        session()->flash('success', '添加成功');
        return redirect()->route('admin.fangowners.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fangowner $fangowner
     * @return \Illuminate\Http\Response
     */
    public function show(Fangowner $fangowner)
    {
        $imgs = trim($fangowner->pic, '#');
        $imgList = explode('#', $imgs);
        array_map(function($item) {
            echo "
            <div><img src=$item style='max-height: 180px;max-width: 180px;float: left;padding-top: 120px;padding-left: 60px'></div>
            ";
        }, $imgList);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fangowner $fangowner
     * @return \Illuminate\Http\Response
     */
    public function edit(Fangowner $fangowner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Fangowner $fangowner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fangowner $fangowner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fangowner $fangowner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fangowner $fangowner)
    {
        //
    }

    // 全选删除
    public function delall(Request $request)
    {
        $ids = $request->get('ids');
        Fangowner::destroy($ids);
        return ['status' => 0, 'msg' => '全选删除成功'];
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
            $ret = $request->file('file')->store('', 'fangowners');
            $pic = '/uploads/fangowners/' . $ret;
        }
        return ['status' => 0, 'url' => $pic];
    }

    public function delfile(Request $request) {
        if ($request->get('url')) {
            unlink(public_path($request->get('url')));
        }
        return ['status' => 0, 'msg' => '删除成功!'];
    }

    // 导出excel
    public function export() {
        return Excel::download(new FangownersExport, 'fangowners.xlsx');
    }
}
