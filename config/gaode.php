<?php
return [
    // 高德地图的key
    'key' => env('GAODE_KEY', ''),
    // 把地址转为经纬度  %s 占位符
    'geocode' => 'https://restapi.amap.com/v3/geocode/geo?key=%s&address=%s'
];
