<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\FangRequest;
use App\Models\Apiuser;
use App\Models\City;
use App\Models\Fang;
use App\Models\Fangattr;
use App\Models\House;
use App\Models\Mating;
use App\Models\Recommender;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class FangsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fangs = Fang::with(['fangowner'])->paginate($this->pagesize);
        return view('admin.fangs.index', compact('fangs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Fang $fang)
    {
        // 方案一
//        $data = (new Fang())->relationData();

        // 方案二
        $data = $fang->relationData();
        return view('admin.fangs.create', $data);
    }


    public function store(FangRequest $request)
    {
        $post = $request->except('_token', 'file');
        $model = Fang::create($post);
        $fang_province = City::find($model->fang_province)->name;
        $fang_city = City::find($model->fang_city)->name;
        $fang_region = City::find($model->fang_region)->name;
        // 详细地址
        $address = $fang_province . $fang_city . $fang_region . $model->fang_addr;

        $ser_url = config('gaode.geocode');
        $client = new Client(['timeout' => 5,]);
        $url = sprintf($ser_url, config('gaode.key'), $address);
        $res = $client->get($url);
        $arr = json_decode((string)$res->getBody(), true);

        // 如果找到了对应经纬度，存入数据表中
        if (count($arr['geocodes']) > 0) {
            $locationArr = explode(',', $arr['geocodes'][0]['location']);
            $model->update([
                'longitude' => $locationArr[0],
                'latitude' => $locationArr[1]
            ]);
        }

        return redirect()->route('admin.fangs.index')->with('success', '添加成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fang $fang
     * @return \Illuminate\Http\Response
     */
    public function show(Fang $fang)
    {
        //
    }

    //
    public function edit(Fang $fang)
    {
        // 房源属性关联数据
        $data = (new Fang())->relationData();

        // 三级联动显示
        // 市
        $data['currentCityData'] = City::where('pid', $fang->fang_province)->get();
        // 区\县
        $data['currentRegionData'] = City::where('pid', $fang->fang_city)->get();
        $data['fang'] = $fang;
        return view('admin.fangs.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Fang $fang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fang $fang)
    {
        $postData = $request->except('_token', 'file', '__method');
        $fang->update($postData);

        $fang_province = City::find($fang->fang_province)->name;
        $fang_city = City::find($fang->fang_city)->name;
        $fang_region = City::find($fang->fang_region)->name;
        // 详细地址
        $address = $fang_province . $fang_city . $fang_region . $fang->fang_addr;

        $ser_url = config('gaode.geocode');
        $client = new Client(['timeout' => 5,]);
        $url = sprintf($ser_url, config('gaode.key'), $address);
        $res = $client->get($url);
        $arr = json_decode((string)$res->getBody(), true);

        // 如果找到了对应经纬度，存入数据表中
        if (count($arr['geocodes']) > 0) {
            $locationArr = explode(',', $arr['geocodes'][0]['location']);
            $fang->update([
                'longitude' => $locationArr[0],
                'latitude' => $locationArr[1]
            ]);
        }


        // 跳转
        return redirect(route('admin.fangs.index'))->with('success', '修改成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fang $fang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fang $fang)
    {
        //
    }

    /**
     * 图片上传
     */
    public function upfile(Request $request)
    {
        // 默认图标
        $pic = config('up.pic');
        if ($request->hasFile('file')) {
            // 上传
            // 参数2 配置的节点名称
            $ret = $request->file('file')->store('', 'fangs');
            $pic = '/uploads/fangs/' . $ret;
        }
        return ['status' => 0, 'url' => $pic];
    }

    public function delfile(Request $request)
    {
        if ($request->get('url') && $request->get('status') == 'edit') {
            $url = $request->get('url');
            $fang = Fang::find($request->id);
            $img = trim($fang->fang_pic, '#');
            $items = explode('#', $img);

            unlink(public_path($url));
            $val = [];
            foreach ($items as $item) {
                if ($url == $item) {
                    continue;
                }
                $val[] = $item;
            }
            if (!empty($val)) {
                $chang_val = implode('#', $val);
            } else {
                $chang_val = '';
            }
            $fang->fang_pic = $chang_val;
            $fang->save();
        } elseif ($request->get('url')) {
            unlink(public_path($request->get('url')));
        }
        return ['status' => 0, 'msg' => '删除成功!'];
    }

    // 三级联动
    public function city(Request $request)
    {
        $id = $request->id;
        return City::where('pid', $id)->get(['id', 'name']);
    }

    // 改变房源状态
    public function changestatus(Request $request)
    {
        $id = $request->get('id');
        $model = Fang::find($id);
        $model->fang_status = !$model->fang_status;
        $model->save();
        $model->fang_status ? $msg = '已租' : $msg = '未租';
        return ['status' => 0, 'msg' => $msg];
    }
}
