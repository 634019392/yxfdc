<?php

namespace App\Http\Controllers\Admin;

use App\Models\Recommender;
use Illuminate\Http\Request;

class BuyersController extends BaseController
{
    // 经纪人---推荐楼盘---客户
    public function index(Request $request)
    {
        $buyers = Recommender::with(['apiuser', 'buyer', 'house'])->paginate($this->pagesize);
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
}
