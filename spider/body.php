<?php
set_time_limit(0);
include __DIR__ . '/function.php';
include __DIR__ . '/vendor/autoload.php';
use QL\QueryList;
$html = http_request('https://news.ke.com/bj/baike/0033/');

$dbh = new PDO('mysql:host=localhost;dbname=yxfdc', 'root', '');
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dbh->exec('set names utf8');
/*查询*/
$sql = "SELECT id,url FROM `sy_articles` WHERE `body`=''";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $data) {
    $id = $data['id'];
    $body_html = http_request($data['url']);
    $queryList = QueryList::Query($body_html, [
        'body' => ['.bd', 'html']
    ])->data;
    /*修改*/
    $sql = "UPDATE `sy_articles` SET `body`=:body WHERE `id`=:id";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([':body'=>$queryList[0]['body'], ':id'=>$id]);
    echo $stmt->rowCount();
}
