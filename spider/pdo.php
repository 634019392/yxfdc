<?php
/*********************************   PDO基础操作    ************************************/
$dbh = new PDO('mysql:host=localhost;dbname=access_control', 'root', '');
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dbh->exec('set names utf8');
/*添加*/
//$sql = "INSERT INTO `user` SET `login`=:login AND `password`=:password";
$sql = "INSERT INTO `user` (`login` ,`password`)VALUES (:login, :password)"; $stmt = $dbh->prepare($sql); $stmt->execute(array(':login'=>'kevin2',':password'=>''));
echo $dbh->lastinsertid();
/*修改*/
$sql = "UPDATE `user` SET `password`=:password WHERE `user_id`=:userId";
$stmt = $dbh->prepare($sql);
$stmt->execute(array(':userId'=>'7', ':password'=>'4607e782c4d86fd5364d7e4508bb10d9'));
echo $stmt->rowCount();
/*删除*/
$sql = "DELETE FROM `user` WHERE `login` LIKE 'kevin_'"; //kevin%
$stmt = $dbh->prepare($sql);
$stmt->execute();
echo $stmt->rowCount();
/*查询*/
$login = 'kevin%';
$sql = "SELECT * FROM `user` WHERE `login` LIKE :login";
$stmt = $dbh->prepare($sql);
$stmt->execute(array(':login'=>$login));
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    print_r($row);
}
print_r( $stmt->fetchAll(PDO::FETCH_ASSOC));