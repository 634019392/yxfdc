<?php
include __DIR__ . '/function.php';

$url = 'https://news.ke.com/bj/baike/0033/';
$html = http_request($url);

/***************  正则爬取   **************/
//$preg = '#<title>(.*)</title>#iUs';
//
//preg_match_all($preg, $html, $arr);
//
//print_r($arr);


/***************  Xpath爬取  **************/
// 忽略html不严格的格式
libxml_use_internal_errors(1);
$dom = new DOMDocument();
$dom->loadHTML($html);
// 转为Xpath
$xpath = new DOMXPath($dom);

//// 可以通过谷歌浏览器查看xpath地址
//$query = '/html/head/title';
//$nodeList = $xpath->query($query);
//foreach ($nodeList as $item) {
//    var_dump($item);
//}


// 查询所有图片 方法1
//$query = '//img/@data-original';
//$nodeList = $xpath->query($query);
//foreach ($nodeList as $item) {
//    echo $item->nodeValue . "\n";
//}

// 查询所有图片 方法2
$query = '/html/body/div[3]/div[2]/div/div[2]/div[2]//img/@data-original';
$nodeList = $xpath->query($query);
foreach ($nodeList as $item) {
    echo $item->nodeValue . "\n";
}