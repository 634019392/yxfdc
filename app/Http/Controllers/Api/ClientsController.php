<?php

namespace App\Http\Controllers\Api;

use App\Models\ClientRecord;
use App\Models\Recommender;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientsController extends Controller
{
    public function records(Request $request)
    {
//        return $apiuser_ids = Recommender::where('apiuser_id', $apiuser->id)->pluck('id')->unique()->toArray(); // 去重
        $recommender_id = $request->recommender_id;
        $client_records = ClientRecord::where('recommender_id', $recommender_id)->orderBy('created_at', 'asc')->get();
        $active = bcsub((int)$client_records->count(), 1);
        $data = [];
        $data['active'] = $active;
        foreach ($client_records as $k => $record) {
            $data['steps'][$k]['id'] = $record->id;
            $data['steps'][$k]['text'] = $record->created_at . ' ' . $record->text;
            $data['steps'][$k]['desc'] = $record->desc;
        }
        return response()->json(['status' => 1000, 'msg' => '查找成功', 'data' => $data], 200);
    }
}
