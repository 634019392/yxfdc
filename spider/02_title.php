<?php
include __DIR__ . '/function.php';
include __DIR__ . '/vendor/autoload.php';

use QL\QueryList;

$html = http_request('https://news.ke.com/bj/baike/0033/');

$data = QueryList::Query('https://news.ke.com/bj/baike/0033/', [
    'title' => ['.m-col .item .text .LOGCLICK', 'text'],
    'href' => ['.m-col .item > .LOGCLICK', 'href'],
    'pic' => ['.m-col .item .lj-lazy', 'data-original'],
    'desn' => ['.m-col .item .text .summary', 'text']
])->data;

print_r($data);