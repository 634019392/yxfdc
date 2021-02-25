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
<div id="header1"></div>
<div>
    {{--<iframe src="https://learnku.com/" scrolling="no" frameborder="0" id="c_body">--}}
    {{--</iframe>--}}
    {{--<iframe src="https://mp.weixin.qq.com/s/rL-Cfm1ujY5UMmy69TkzCA" scrolling="no" frameborder="0" id="c_body">--}}
    {{--</iframe>--}}

    {{--<iframe src="https://mp.weixin.qq.com/s/rL-Cfm1ujY5UMmy69TkzCA" scrolling="no" frameborder="0" id="c_body">--}}
    {{--</iframe>--}}
</div>
{{--<div>--}}
    {{--{{$board->id}}--}}
    {{--{{$board->url}}--}}
    {{--{{$board->title}}--}}
    {{--{{$board->status}}--}}
    {{--<div style="touch-action: none;touch-action: pan-y;overflow-x: hidden;">--}}
        {{--{!! $board->content !!}--}}
    {{--</div>--}}
{{--</div>--}}
<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
<script>
    $("document").ready(function () {
        $("#header1").load("https://mp.weixin.qq.com/s/rL-Cfm1ujY5UMmy69TkzCA");
        console.log($('#c_body'));
        var iframeHeight = $("#c_body").contents().height();
        console.log(iframeHeight);
//        console.log($('#c_body').height(screen.height));
//        console.log($('#c_body').width(screen.width));
//        console.log(screen.width);

        var img = $("body img");
        img.each(function (k, v) {
            var data_src = $(v).attr('data-src');
            $(v).attr('src', data_src);
//            if ($(v).width() > screen.width) {
//                $(v).width(screen.width);
//            }
        })

    })

    //    三个方法都可获取
    //    img.get(i).src
    //    img[i].src
    //    img.eq(i).attr("src")
    //
    //    原生+jq会报错，返回的是DOM对象而不是jq对象
    //    img[i].attr("src");
</script>
</body>
</html>