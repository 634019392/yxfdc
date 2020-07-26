<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CheckDataController extends Controller
{
    public static $OK = 0;
    public static $IllegalAesKey = -41001;
    public static $IllegalIv = -41002;
    public static $IllegalBuffer = -41003;
    public static $DecodeBase64Error = -41004;

    public function phone_num(Request $request)
    {
        $appId = config('swechat.appid');
        $encryptedDataStr = $request->get('encryptedDataStr');
        $iv = $request->get('iv');
        $session_id = $request->get('sessionID');
        $session_key = base64_decode($session_id);
        return $this->decryptData($encryptedDataStr, $iv, $appId, $session_key);
    }

    /**
     * 检验数据的真实性，并且获取解密后的明文.
     * @param $encryptedData string 加密的用户数据
     * @param $iv string 与用户数据一同返回的初始向量
     * @param $data string 解密后的原文
     *
     * @return int 成功0，失败返回对应的错误码
     */
    public function decryptData($encryptedData, $iv, $appid, $session_key)
    {
        if (strlen($session_key) != 24) {
            return self::$IllegalAesKey;
        }
        $aesKey=base64_decode($session_key);


        if (strlen($iv) != 24) {
            return self::$IllegalIv;
        }
        $aesIV=base64_decode($iv);

        $aesCipher=base64_decode($encryptedData);

        $result=openssl_decrypt( $aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);

        $dataObj=json_decode( $result );
        if( $dataObj  == NULL )
        {
            return self::$IllegalBuffer;
        }
        if( $dataObj->watermark->appid != $appid )
        {
            return self::$IllegalBuffer;
        }

        if (self::$OK === 0) {
            return $result;
        }
    }

}
