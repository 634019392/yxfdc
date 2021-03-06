<?php

namespace App\Http\Controllers\Wechat;

use Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WechatController extends Controller
{
    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {
        Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        $app = app('wechat.official_account');
        $type = 'news';
        $offset = 0;
        $count = 10;
        return $resource = $app->material->get('Y2tOYeVtpPXrabipVx8YGMrkvkRPzMqEM4X06WybFYM');
        return $app->material->list($type, $offset, $count);

//        $app->server->push(function ($message) {
//            return json_encode($message);
////            switch ($message['MsgType']) {
////                case 'event':
////                    return '收到事件消息';
////                    break;
////                case 'text':
////                    return '收到文字消息';
////                    break;
////                case 'image':
////                    return '收到图片消息';
////                    break;
////                case 'voice':
////                    return '收到语音消息';
////                    break;
////                case 'video':
////                    return '收到视频消息';
////                    break;
////                case 'location':
////                    return '收到坐标消息';
////                    break;
////                case 'link':
////                    return '收到链接消息';
////                    break;
////                case 'file':
////                    return '收到文件消息';
////                // ... 其它消息
////                default:
////                    return '收到其它消息';
////                    break;
////            }
//
//            // ...
//        });
//
////        $app->server->push(function($message){
////            return "欢迎关注 overtrue！";
////        });
////
//        $response =$app->server->serve();
////        // 将响应输出
//        return $response;
    }
}
