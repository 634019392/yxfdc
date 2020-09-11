<?php

namespace App\Http\Controllers\Api;

use App\Models\Apiuser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

class BokersController extends Controller
{
    // 发送验证码
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function send_code(Request $request)
    {
        $openid = $request->get('openid');
        $phone = $request->get('phone');
        if (!$phone) {
            return response()->json(['status' => 1005, 'msg' => '手机号必须填写'], 403);
        }
        if ($openid) {
            $user = Apiuser::where('openid', $openid)->first();
        } else {
            return response()->json(['status' => 1005, 'msg' => '用户尚未登录，请刷新重试'], 401);
        }

        // 发送验证码
        $ak = config('alibaba.accessKeyId');
        $sk = config('alibaba.accessSecret');
        $sn = config('alibaba.SignName');
        $tc = config('alibaba.TemplateCode');
        $code = random_int(100000, 999999);
        $json_code = json_encode(['code' => $code]);

        AlibabaCloud::accessKeyClient($ak, $sk)
            ->regionId('cn-hangzhou')
            ->asDefaultClient();

        try {
            $send_result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                // ->scheme('https') // https | http
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->host('dysmsapi.aliyuncs.com')
                ->options([
                    'query' => [
                        'RegionId' => "cn-hangzhou",
                        'PhoneNumbers' => $phone,
                        'SignName' => $sn,
                        'TemplateCode' => $tc,
                        'TemplateParam' => $json_code,
                    ],
                ])
                ->request();

            $query_result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                // ->scheme('https') // https | http
                ->version('2017-05-25')
                ->action('QuerySendDetails')
                ->method('POST')
                ->host('dysmsapi.aliyuncs.com')
                ->options([
                    'query' => [
                        'RegionId' => "cn-hangzhou",
                        'PhoneNumber' => $phone,
                        'SendDate' => date('Ymd'),
                        'PageSize' => "50",
                        'CurrentPage' => "1",
                    ],
                ])
                ->request();
            $q = $query_result->toArray();
            $send_num = $q['TotalCount'];
            if ($send_num > 5) {
                return response()->json(['status' => 1005, 'msg' => '超出当天5次'], 412);
            }

            $im_arr = [$code, time(), $phone];
            $code_attr = implode('#', $im_arr); // code和当前发送时间，已#分割
            $user->phone_node = $code_attr;
            $user->save();
            return response()->json(['status' => 1000, 'msg' => '短信验证码发送成功,请稍后'], 200);
        } catch (ClientException $e) {
            $err = $e->getErrorMessage() . PHP_EOL;
            return response()->json(['status' => 1005, 'msg' => $err], 412);
        } catch (ServerException $e) {
            $err = $e->getErrorMessage() . PHP_EOL;
            return response()->json(['status' => 1006, 'msg' => $err], 500);
        }
    }

    // 认证
    public function check(Request $request)
    {
        $openid = $request->get('openid');
        $truename = $request->get('truename');
        $sex = $request->get('sex');
        $age = $request->get('age');
        $phone = $request->get('phone');
        $phone_node = $request->get('phone_node');
        $id_card = $request->get('id_card');

        if (!$openid) {
            return response()->json(['status' => 1005, 'msg' => '用户没有登录，请刷新重试'], 412);
        }
        if (!$truename) {
            return response()->json(['status' => 1005, 'msg' => '真实姓名不能为空'], 412);
        }
        if (!$sex) {
            return response()->json(['status' => 1005, 'msg' => '性别不能为空'], 412);
        }
        if (!$age) {
            return response()->json(['status' => 1005, 'msg' => '年龄不能为空'], 412);
        }
        if (!$phone) {
            return response()->json(['status' => 1005, 'msg' => '手机号不能为空'], 412);
        }
        if (!$phone_node) {
            return response()->json(['status' => 1005, 'msg' => '短信验证码不能为空'], 412);
        }
        if (!$id_card) {
            return response()->json(['status' => 1005, 'msg' => '身份证号码不能为空'], 412);
        }

        $user = Apiuser::where('openid', $openid)->first();
        if ($user->is_phone_auth == 1) {
            return response()->json(['status' => 1005, 'msg' => '已经认证无须重复认证'], 204);
        }
        $user_phone_node = $user->phone_node;//格式为 验证码#时间戳
        if ($user_phone_node == '') {
            return response()->json(['status' => 1005, 'msg' => '请先核实号码再点击发送短信'], 412);
        }
        list($mysql_phone_node, $mysql_time, $mysql_phone) = explode('#', $user_phone_node);
        // 获取的验证码和数据库中的相同且时间没有超过5分钟
        if ($mysql_phone_node == $phone_node && $mysql_phone == $phone && time() < ($mysql_time + 60 * 5)) {
            $user->truename = $truename;
            $user->sex = $sex;
            $user->age = $age;
            $user->phone = $phone;
            $user->is_phone_auth = '1';
            $user->id_card = $id_card;
            $user->save();
            return response()->json(['status' => 1000, 'msg' => '认证成功', 'data' => ['is_phone_auth' => 1]], 200);
        } else {
            return response()->json(['status' => 1005, 'msg' => '验证码不正确或验证码超时'], 412);
        }
    }

    // 经纪人推荐客户到楼盘
    public function reave(Request $request)
    {
        $openid = $request->get('openid');
        $phone = $request->get('phone');
        $card_alert_six = $request->get('card_alert_six');
        $sex = $request->get('sex');
        $age = $request->get('age');
        $truename = $request->get('truename');
        $house_ids = trim($request->get('house_ids'), ',');
        if (empty($house_ids) || $house_ids == '') {
            return response()->json(['status' => 1005, 'msg' => '必须勾选推荐楼盘'], 412);
        }
        $house_arr = explode(',', $house_ids);

        if (!$openid) {
            return response()->json(['status' => 1005, 'msg' => '用户没有登录，请刷新重试'], 412);
        }
        if (!$phone) {
            return response()->json(['status' => 1005, 'msg' => '手机号必填'], 412);
        }
        if (!$card_alert_six) {
            $card_alert_six = '000000'; // 默认身份证后6位为 000000，后期如需要添加身份证后6位排除 000000，如果与手机号不匹配即提示
//            return response()->json(['status' => 1005, 'msg' => '身份证后六位必填'], 412);
        }
        if (!$age) {
            $age = 0;
        }
        if (!$truename) {
            return response()->json(['status' => 1005, 'msg' => '姓名不能为空'], 412);
        }

        $user = Apiuser::where('openid', $openid)->first();
        $buyer = [
            'phone' => $phone,
            'card_alert_six' => $card_alert_six,
            'sex' => $sex,
            'age' => $age,
            'truename' => $truename
        ];

        if ($user->is_phone_auth == 0) {
            // 必须是经纪人
            return response()->json(['status' => 1005, 'msg' => '请先进行经纪人认证']);
        }
        $callback_params = $user->recommend($buyer, $house_arr);
//        $callback_params = $user->recommend1($openid, $buyer, $house_arr);
        if (isset($callback_params['status']) && $callback_params['status'] == 412) {
            return response()->json(['status' => 1005, 'msg' => $callback_params['msg']], $callback_params['status']);
        }
        if ($callback_params['status'] === 200) {
            return response()->json(['status' => 1000, 'msg' => $callback_params['msg']], $callback_params['status']);
        }

    }

    // 我的客户
    public function my_client(Request $request)
    {
        $openid = $request->get('openid');
        $ret = Apiuser::with('apiusers')
            ->where('openid', $openid)
            ->first()->centre_info();
        $my_client = $ret['apiusers'];
        return response()->json(['status' => 1000, 'msg' => '查找成功', 'data' => $my_client], 200);
    }


}
