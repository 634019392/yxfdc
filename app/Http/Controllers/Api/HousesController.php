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
        foreach ($houses as $k => $item) {
            if ($item['tag']) {
                $item['tag'] = explode('#', $item['tag']);
            } else {
                $item['tag'] = '';
            }
        }

        return response()->json(['status' => 1000, 'data' => $houses], 200);
    }

    // 参与全民经纪人的楼盘
    public function boker_houses(Request $request)
    {
        $boker_houses = House::where('is_marketing', '1')->get()->load(['act_param'])->transform(function ($item, $key) {
            $item_array = $item->toArray();
            // 推荐费说明
            if ($item_array['act_param']) {
                $fee_text = $item_array['act_param']['fee_text'];
            } else {
                $fee_text = '';
            }
            return $data = ['id' => $item_array['id'], 'name' => $item_array['name'], 'fee_text' => $fee_text];
        });
        return response()->json(['status' => 1000, 'data' => $boker_houses], 200);
    }

    public function show(Request $request)
    {
        $house_id = $request->get('house_id');
        $house = House::find($house_id)->load(['mating','houseFloors','houseOutlines','act_param'])->toArray();
        if ($house['tag']) {
            $house['tag'] = explode('#', $house['tag']);
        } else {
            $house['tag'] = '';
        }

        if ($house['act_param']) {
            $house['fee_text'] = $house['act_param']['fee_text'];
        } else {
            $house['fee_text'] = '';
        }

        return response()->json(['status' => 1000, 'data' => $house], 200);
    }
}
