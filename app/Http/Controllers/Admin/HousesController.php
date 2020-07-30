<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\HouseRequest;
use App\Models\House;
use App\Models\HouseFloor;
use App\Models\HouseIntroduce;
use Illuminate\Http\Request;

class HousesController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $houses = House::all();
        return view('admin.houses.index', compact('houses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.houses.create');
    }


    /**
     * @param HouseRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(HouseRequest $request)
    {
        $postArr = $request->all();
        $postArr['img'] = trim($postArr['image_pic'], '#');//ps: 此处前端传过来的不是img名称需要转换一下
        $house = collect($postArr)->except(['_token', 'image_pic', 'file', 'mating', 'foolr_plan'])->toArray();
        $mating = $postArr['mating']; // 配套参数
        if ($request->has('foolr_plan')) {
            $foolr_plan = $postArr['foolr_plan']; // 户型图参数
        } else {
            $foolr_plan = [];
        }

        // 创建楼盘主信息
        $houseModel = House::create($house);
        $house_id = $houseModel->id;
        // 查找house_id是否存在，不存在则创建
        HouseIntroduce::firstOrCreate(['house_id' => $house_id], $mating);
        // 添加户型图
        $houseModel->houseFloors()->createMany($foolr_plan);
        session()->flash('success', '项目添加成功');
        return redirect()->route('admin.houses.index');
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
    public function edit(House $house)
    {
        $data = $house->load(['mating', 'houseFloors']);
        return view('admin.houses.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HouseRequest $request, House $house)
    {
        $postArr = $request->all();
        $postArr['img'] = $postArr['image_pic'];//ps: 此处前端传过来的不是img名称需要转换一下
        $postMating = $postArr['mating'];
        $postHouse = collect($postArr)->except(['image_pic', '_token', '_method', 'file', 'mating', 'foolr_plan'])->toArray();
        $house->update($postHouse);// 1.更新house数据
        HouseIntroduce::updateOrCreate(['house_id' => $house->id], $postMating);// 2.查找出楼盘参数模型,有则更新否则创建

        // 3.存在则更新或新增户型图信息
        if ($request->has('foolr_plan')) {
            $postFloorPlan = $postArr['foolr_plan'];
            foreach ($postFloorPlan as $item) {
                if (array_key_exists('id',$item)) {
                    HouseFloor::updateOrCreate(['id' => $item['id']], $item);
                } else {
                    $item['house_id'] = $house->id;
                    HouseFloor::create($item);
                }
            }
        }

        session()->flash('success', '项目修改成功');
        return redirect()->route('admin.houses.index');
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
