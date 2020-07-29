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