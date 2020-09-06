<?php

namespace App\Http\Controllers\Admin;

use App\Exports\RecommendersExport;
use App\Models\ClientRecord;
use App\Models\Recommender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;

class BuyersController extends BaseController
{
    // 经纪人---推荐楼盘---客户
    public function index(Request $request)
    {
        $buyers = Recommender::with(['apiuser', 'buyer', 'house'])->orderBy('created_at', 'desc')->paginate($this->pagesize);
        return view('admin.buyers.index', compact('buyers'));
    }

    // 编辑审核状态渲染
    public function edit(Request $request, Recommender $recommender)
    {
        $recommender_status = Recommender::$statusMap;
        return view('admin.buyers.edit', compact('recommender', 'recommender_status'));
    }

    // 功能---审核状态
    public function update(Request $request, Recommender $recommender)
    {
        $status = $request->get('status');
        $recommender->status = $status;
        $recommender->save();
        return redirect()->route('admin.buyers.index')->with('success', '修改成功');
    }

    // 导出客户
    public function export(Request $request)
    {
        $start_time = $request->input('start_time');
        $end_time = $request->input('end_time');
        if (!$start_time) {
            $start_time = date('Y-m-d', time());
        }
        if (!$end_time) {
            $end_time = date('Y-m-d', time());
        }
        $file_path = date('Ymd', time()) . '/' . bin2hex(random_bytes(10)) . '.xlsx';
        Excel::store(new RecommendersExport($start_time, $end_time), $file_path, 'excel');
        $down_url = $_SERVER['HTTP_ORIGIN'] . '/uploads/excel_images' . '/' . $file_path;
//        $down_url = public_path('/uploads/excel_images') . '/' . $file_path;
        return ['status' => 0, 'down_url' => $down_url];
    }

    // 客户跟踪显示
    public function tail(Recommender $recommender)
    {
        $client_records = ClientRecord::where('recommender_id', $recommender->id)->get();
        return view('admin.buyers.tail', compact('recommender', 'client_records'));
    }

    // 客户跟踪创建-客户记录
    public function tail_create(Request $request, $recommender)
    {
        $postData = $request->except('_token', '_method');
        $postData['recommender_id'] = $recommender;
        $client_record = ClientRecord::create($postData);
        if ($client_record) {
            return redirect()->route('admin.buyers.tail', $recommender);
        }
    }

    // 更新客户记录
    public function tail_update(Request $request, ClientRecord $clientRecord)
    {
        $postArr = $request->except(['_token', '_method']);
        $clientRecord->update($postArr);
        return redirect()->route('admin.buyers.tail', $clientRecord->recommender_id);
    }
}
