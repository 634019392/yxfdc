<?php

namespace App\Http\Controllers\Admin;

use App\Models\Advimg;
use Illuminate\Http\Request;

class AdvimgsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $advimgs = Advimg::paginate($this->pagesize);
        return view('admin.advimgs.index', compact('advimgs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.advimgs.create');
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
            'slideshow' => 'required'
        ], [
            'slideshow.required' => '轮播图 不能为空值'
        ]);
        $postArr = $request->except(['_token', 'file']);
        if ($postArr['slideshow']) {
            $img_url = $postArr['slideshow'] . '?imageView2/%s/w/%s/h/%s/q/85';
            if (!$postArr['mode']) {
                $postArr['mode'] = 2;
            }
            if (!$postArr['width']) {
                $postArr['width'] = 320;
            }
            if (!$postArr['height']) {
                $postArr['height'] = 220;
            }
            $saveArr['slideshow'] = sprintf($img_url, $postArr['mode'], $postArr['width'], $postArr['height']);

            Advimg::create($saveArr);
        }
        return redirect()->route('admin.advimgs.index')->with('success', '添加成功!');
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
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Advimg $advimg)
    {
        $str = $advimg->slideshow;
        preg_match("/\?imageView2\/.*/", $str, $newstr);
        if ($newstr) {
            $arr = explode('/', $newstr[0]);
            $advimg->mode = $arr[1];
            $advimg->width = $arr[3];
            $advimg->height = $arr[5];
        } else {
            $advimg->mode = 2;
            $advimg->width = '';
            $advimg->height = '';
        }

        return view('admin.advimgs.edit', compact('advimg'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Advimg $advimg)
    {
        $this->validate($request, [
            'slideshow' => 'required'
        ], [
            'slideshow.required' => '轮播图 不能为空值'
        ]);
        $postArr = $request->except(['_method', '_token', 'file']);
        if ($postArr['slideshow']) {
            $first_len = stripos($postArr['slideshow'], '?imageView2');
            if ($first_len) {
                $postArr['slideshow'] = substr($postArr['slideshow'], 0, $first_len);
            }
            if (!$postArr['mode']) {
                $postArr['mode'] = 2;
            }
            if (!$postArr['width']) {
                $postArr['width'] = 320;
            }
            if (!$postArr['height']) {
                $postArr['height'] = 220;
            }
            $img_url = $postArr['slideshow'] . '?imageView2/%s/w/%s/h/%s/q/85';
            $saveArr['slideshow'] = sprintf($img_url, $postArr['mode'], $postArr['width'], $postArr['height']);

            $advimg->slideshow = $saveArr['slideshow'];
            $advimg->save();

        }
        return redirect()->route('admin.advimgs.index')->with('success', '修改成功!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Advimg $advimg)
    {
        $advimg->delete();
        return ['status' => 0, 'msg' => '删除成功!'];
    }
}
