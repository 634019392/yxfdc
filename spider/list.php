<?php
set_time_limit(0);
include __DIR__ . '/function.php';
include __DIR__ . '/vendor/autoload.php';
use QL\QueryList;
$html = http_request('https://news.ke.com/bj/baike/0033/');

// 单页面爬取
//$data = QueryList::Query($html, [
//    'title' => ['.m-col .item .text .LOGCLICK', 'text'],
//    'href' => ['.m-col .item > .LOGCLICK', 'href'],
//    'pic' => ['.m-col .item .lj-lazy', 'data-original', '', function($item) {
//        // 获取拓展名
//        $ext = pathinfo($item, PATHINFO_EXTENSION);
//        // 生成新的文件名
//        $filename = md5($item) . '_' . time() . '.' . $ext;
//        // 新文件生成的本地路径
//        $filepath = dirname(__DIR__) . '/public/uploads/article/' . $filename;
//        file_put_contents($filepath, http_request($item));
//        return '/uploads/article/' . $filename;
//    }],
//    'desn' => ['.m-col .item .text .summary', 'text']
//])->data;


/********** pdo实例化 **********/
header("Content-type: text/html; charset=utf-8");
$dbms='mysql';
$dbName='yxfdc';
$user='root';
$pwd='';
$host='localhost';
$charset = 'utf8';
$dsn="$dbms:host=$host;dbname=$dbName;charset=$charset";
try{
    $pdo=new PDO($dsn,$user,$pwd);
}
catch(Exception $e)
{
    echo $e->getMessage();
}


// 多页面爬取
$pages = range('1', '1');
$data_all = [];
foreach ($pages as $item) {
    $html = 'https://news.ke.com/bj/baike/0033/pg'.$item.'/';
    $data_all[] = QueryList::Query($html, [
        'title' => ['.m-col .item .text .LOGCLICK', 'text'],
        'desn' => ['.m-col .item .text .summary', 'text'],
        'pic' => ['.m-col .item .lj-lazy', 'data-original'],
        'url' => ['.m-col .item > .LOGCLICK', 'href'],
    ])->data;
}

foreach ($data_all as $data) {
    foreach ($data as $child) {
        $sql = "SELECT id FROM `sy_articles` WHERE `title`=:title";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['title'=>$child['title']]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($rows) {
            // 扒取的内容存在则跳过
            continue;
        } else {
            $item = $child['pic'];
            // 获取拓展名
            $ext = pathinfo($item, PATHINFO_EXTENSION);
            // 生成新的文件名
            $filename = md5($item) . '_' . time() . '.' . $ext;
            // 新文件生成的本地路径
            $filepath = dirname(__DIR__) . '/public/uploads/article/' . $filename;
            file_put_contents($filepath, http_request($item));
            $child['pic'] = '/uploads/article/' . $filename;
        }
        //插入
        $sql = "insert into sy_articles(title,desn,pic,url,body) values(?,?,?,?,'')";
        //准备sql模板
        $stmt = $pdo->prepare($sql);

        //执行预处理语句
        $stmt->execute([$child['title'], $child['desn'], $child['pic'], $child['url']]);
        $insert_id = $pdo->lastInsertId();
    }
}
//释放查询结果
$stmt = null;
//关闭连接
$pdo = null;

