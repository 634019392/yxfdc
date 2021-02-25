<?php

use Carbon\Carbon;

// 配置文件中更正时区
date_default_timezone_set('PRC');
return [
    // 小程序 Appid
    'appid' => env('WECHAT_MINI_PROGRAM_APPID', ''),
    'secret' => env('WECHAT_MINI_PROGRAM_SECRET', ''),

    'expires' => Carbon::now()->addDays(3)
];