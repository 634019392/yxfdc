## 基础配置
#####1.安装依赖包
```base
$ composer install
```
#####2.阿里云短信配置config中alibaba accessKeyId和accessSecret
`创建config/alibaba.php`
```php
<?php
return [
    'accessKeyId' => '',
    'accessSecret' => '',
    'SignName' => '',
    'TemplateCode' => '',
];
```


#####3.小程序配置config中swechat appid和secret
`创建config/swechat.php`
```php
<?php
return [
    // 小程序 Appid
    'appid' => '',
    'secret' => '',

    'expires' => now()->addDays(3),
];
```

#####4.七牛配置config中qiniu 的密钥
`创建config/qiniu.php`
```php
<?php
return [
    'accessKey' => '',
    'secretKey' => '',
    'bucket' => '',
    'http' => '',
];
```

#####5.passport配置
```base
$ php artisan migrate
$ php artisan passport:install
```

#####6.数据库配置
users数据：
```
|  id   | role_id | username | password |
| ----- | ------- | -------- | -------- |
|   1   |    1    |    ll    |          |
```
roles
```
|  id   |   name   |
| ----- | -------- |
|   1   |   开发者  |
```
role_node
```
| role_id | node_id |
| ------- | ------- |
|    1    |    1    |
```
nodes
![avatar](http://w20.top/nodes.png)
表中需要填充数据

#####6.服务器定时任务配置
```bash
$ crontab -e
# 定时任务中加入，CTRL+O保存，CTRL+X退出
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```