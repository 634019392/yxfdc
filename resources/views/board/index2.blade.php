<!doctype html>
<html lang="en">
<head>
    <meta name="referrer" content="never">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="user-scalable=0">
    <meta content="width=device-width,user-scalable=no" name="viewport">
    <link rel="import" href="https://learnku.com">
    <title>阳房通-地产资讯内容</title>
</head>
<body style="margin: 0;padding: 0">
<iframe width="750" height="500" src=""></iframe>

<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
<script>
    $("document").ready(function () {

        $.ajaxPrefilter(function (options) {
            if (options.crossDomain && jQuery.support.cors) {
                var http = (window.location.protocol === 'http:' ? 'http:' : 'https:');
                options.url = http + '//cors-anywhere.herokuapp.com/' + options.url;
            }
        });

        var share_link = "https://mp.weixin.qq.com/s/rL-Cfm1ujY5UMmy69TkzCA";//微信文章地址
        $.get(
            share_link,
            function (response) {
                console.log("> ", response);
                var html = response;
                html = html.replace(/data-src/g, "src");
                var html_src = 'data:text/html;charset=utf-8,' + html;
                $("iframe").attr("srcdoc", html_src);
            }
        );

//        $("iframe").attr("srcdoc", html_src);

//        $.get(
//            share_link,
//            function (response) {
//                console.log("> ", response);
//                var html = response;
//                html=html.replace(/data-src/g, "src");
//                var html_src = 'data:text/html;charset=utf-8,' + html;
//                $("iframe").attr("src" , html_src);
//            }
//        );

    })
</script>
</body>
</html>