<?php

namespace App\Http\Controllers\Api;

use App\Models\House;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class HousesController extends Controller
{
    // 所有在售楼盘
    public function index(Request $request)
    {
        $houses = House::all();
        return response()->json(['status' => 1000, 'data' => $houses], 200);
    }

    // 参与全民经纪人的楼盘
    public function boker_houses(Request $request)
    {
        $boker_houses = House::where('is_marketing', '1')->get()->transform(function ($item, $key) {
            $item_array = $item->toArray();
            return $data = ['id' => $item_array['id'], 'name' => $item_array['name']];
        });
        return response()->json(['status' => 1000, 'data' => $boker_houses], 200);
    }

    public function show(Request $request)
    {
        $house_id = $request->get('house_id');
        $house = House::find($house_id)->load(['mating','houseFloor'])->toArray();

        return $house;
        return response()->json(['status' => 1000, 'data' => $house], 200);
    }
}
