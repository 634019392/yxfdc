## 基础配置
#####1.安装依赖包
```base
$ composer install
```

#####2.小程序配置config中swechat appid和secret

#####3.七牛配置config中qiniu 的密钥

#####4.passport配置
```base
$ php artisan migrate
$ php artisan passport:install
```