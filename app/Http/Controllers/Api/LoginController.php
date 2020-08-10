<?php

namespace App\Http\Controllers\Api;

use App\Models\Apiuser;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\PassportToken;

class LoginController extends Controller
{
    use PassportToken;

    // 小程序登录，如果不存在则创建
    public function swxlogin(Request $request)
    {
        // 小程序注册
        // 通过code查询openid是否存在，不存在创建用户返回token和openid，存在返回token和openid
        if ($request->get('code')) {
            $appid = config('swechat.appid');
            $secret = config('swechat.secret');
            $code = $request->get('code');
            $url = 'https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code';
            $new_url = sprintf($url, $appid, $secret, $code);
            $client = new Client(['timeout' => 5]);
            $res = $client->get($new_url);
            $val = (string)$res->getBody();
            $arr = json_decode($val, true);// openid  session_key
            if (isset($arr['errcode'])) {
                // code输入错误或者过期或者使用过
                return response()->json(['status' => 500, $arr], 500);
            }

            $userModel = Apiuser::where('openid', $arr['openid'])->first();
            $openid = $arr['openid'];
            $session_key = $arr['session_key'];
            $session_id = base64_encode($session_key);
            $token_expires = ((int)strtotime(config('swechat.expires'))) * 1000;

            if ($userModel) {
                // 个人令牌永久有效的问题优化
//                $token = $userModel->createToken('api')->accessToken;
                $result = $this->getBearerTokenByUser($userModel, '1', false);
                $token = $result['access_token'];

                // 此步骤passport7.4版本可以忽略
                $userModel->api_token = $token;
                $userModel->save();
                $res_info = ['status' => 1000, 'openid' => $openid, 'token' => $token, 'token_expires' => $token_expires, 'session_id' => $session_id];
                if ($userModel->is_phone_auth == 1) {
                    $res_info['is_phone_auth'] = $userModel->is_phone_auth;
                }
                return response()->json($res_info, 200);
            } else {
                $userData = [
                    'openid' => $openid
                ];
                $newModel = Apiuser::create($userData);

                // 个人令牌永久有效的问题优化
//                $token = $newModel->createToken('api')->accessToken;
                $result = $this->getBearerTokenByUser($newModel, '1', false);
                $token = $result['access_token'];

                $newModel->api_token = $token;
                $newModel->save();
                // http状态码201为创建完成
                // http状态码页面 https://www.runoob.com/http/http-status-codes.html
                $res_info = ['status' => 1000, 'openid' => $openid, 'token' => $token, 'token_expires' => $token_expires, 'session_key' => $session_key];
                if ($newModel->is_phone_auth == 1) {
                    $res_info['is_phone_auth'] = $userModel->is_phone_auth;
                }
                return response()->json($res_info, 201);
            }
        }
    }

    // 获取用户信息
    public function user(Request $request)
    {
        $openid = $request->get('openid');
        $type = $request->get('type');
        $user_info = $request->get('user_info');

        $postData['nickname'] = $user_info['nickName'];
        $postData['sex'] = $user_info['gender'];
        $postData['avatar'] = $user_info['avatarUrl'];
        $postData['country'] = $user_info['country'];// 数据库无
        $postData['province'] = $user_info['province'];// 数据库无
        $postData['city'] = $user_info['city'];// 数据库无
        $postData['language'] = $user_info['language'];// 数据库无
        if ($type == 'edit_user' && $openid) { // 更新用户
            $user = Apiuser::where('openid', $openid)->first();
            $user->nickname = $user_info['nickName'];
            $user->sex = $user_info['gender'] == 1 ? '男' : '女';
            $user->avatar = $user_info['avatarUrl'];
            $user->save();
            return response()->json(['status' => 1000, 'msg' => '授权成功！'], 201);
        }
    }


}
