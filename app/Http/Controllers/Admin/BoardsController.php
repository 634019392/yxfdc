<?php

namespace App\Http\Controllers\Admin;

use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BoardsController extends BaseController
{
    public function index()
    {
        $boards = Board::paginate($this->pagesize);
        return view('admin.board.index', compact('boards'));
    }

    public function create()
    {
        return view('admin.board.create');
    }

    public function store(Request $request)
    {
        $postArr = $request->except(['_token']);
        $postArr['status'] = '1';
        $postArr['url'] = '';
        $postArr['cover_img'] = '';
        $postArr['content'] = '';
        $postArr['wechat_url'] = '';
        $postArr['content_source_url'] = '';
        if ($request->hasFile('cover_img')) {
            $path = $request->file('cover_img')->store('', 'images');
            $filePath = 'uploads/images/' . $path;
            qiniu_update($filePath);
            $file = basename($path);
            $cover_img = config('qiniu.http') . $file;
            $postArr['cover_img'] = $cover_img;
        }
        if ($request->has('content')) {
            $postArr['content'] = $request->get('content');
        }
        Board::create($postArr);
        return redirect()->route('admin.boards.index')->with('success', '新增成功！');
    }

    public function create_news()
    {
        return view('admin.board.create_news');
    }

    public function wechat_gather(Request $request)
    {
        $start_num = $request->get('start_num');
        $app = app('wechat.official_account');
        $result = $app->material->list('news', $start_num, $count = 20); // 默认统计20个（最高也是20）

//        try {
//            $result = $app->material->list('news', $start_num, $count = 20); // 默认统计20个（最高也是20）
//
//            //中间逻辑代码
//        } catch (\Exception $e) {
//            //接收异常处理并回滚
//            \Log::info($e);
//            return response()->json([
//                'status' => 1006,
//                'errmsg' => 'easyWechat请求异常，请查看日志'
//            ], 500);
//        }
//        return $result;

        if (isset($result['errcode'])) {
            return response()->json([
                'status' => 1005,
                'errcode' => $result['errcode'],
                'errmsg' => $result['errmsg']
            ], 502);
        } else {
            foreach ($result['item'] as $k => $value) {
                $content = $value['content']['news_item'][0]; // 微信详细图文信息
                $board = Board::where('media_id', $value['media_id'])->first();
                $postData = [
                    'status' => 2,
                    'url' => '',
                    'title' => $content['title'],
                    'author' => $content['author'],
                    'cover_img' => '',
                    'digest' => $content['digest'],
                    'content' => $content['content'],
                    'thumb_media_id' => $content['thumb_media_id'],
                    'thumb_url' => $content['thumb_url'],
                    'show_cover_pic' => $content['show_cover_pic'],
                    'media_id' => $value['media_id'],
                    'wechat_url' => $content['url'],
                    'content_source_url' => $content['content_source_url'],
                    'wechat_create_time' => $value['content']['create_time'],
                    'wechat_update_time' => $value['update_time']
                ];
                if (!$board) { // 1、不存在即创建
                    //开启事务
                    DB::beginTransaction();
                    try {
                        //中间逻辑代码
                        $board = Board::create($postData);
                        $result['item'][$k]['status_msg'] = '入库成功!';
                        DB::commit();
                    } catch (\Exception $e) {
                        //接收异常处理并回滚
                        \Log::info($e);
                        DB::rollBack();
                    }
                }

                $result['item'][$k]['id'] = $board->id;

                if ($board && $board->wechat_update_time == $value['update_time']) { // 2、存在且微信素材更新时间与数据库更新时间相等即跳过
                    $result['item'][$k]['status_msg'] = '不变!';
                    continue;
                }

                if ($board && $board->wechat_update_time < $value['update_time']) { // 3、素材存在更新时间不等，则数据库同步至最新
                    $postData['url'] = $board->url;
                    //开启事务
                    DB::beginTransaction();
                    try {
                        //中间逻辑代码
                        $board->update($postData);
                        $result['item'][$k]['status_msg'] = '更新成功!';
                        DB::commit();
                    } catch (\Exception $e) {
                        //接收异常处理并回滚
                        \Log::info($e);
                        DB::rollBack();
                    }
                }

            }
        }

        $page = ceil(bcdiv($result['total_count'], $count, 2));
        $start_num = $start_num + $count;
        if ($start_num > $result['total_count']) { // 起始值超过统计值就清除
            $start_num = '';
        }

        $data = [
            'start_num' => $start_num,
            'page' => $page,
            'result' => $result
        ];
        return response()->json($data, 200);
    }

    public function store_news(Request $request)
    {
        return 1234;
    }
}
