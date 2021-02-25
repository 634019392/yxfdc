<!doctype html>
<html lang="en">
<head>
    {{--微信公众号侵权图片解锁--}}
    <meta name="referrer" content="never">
    {{--<meta charset="UTF-8">--}}
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no,minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    {{--<meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">--}}
    {{--<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0"/>--}}

    {{--<meta name="viewport"   content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">--}}
    {{--<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">--}}
    {{--<meta http-equiv="X-UA-Compatible" content="ie=edge">--}}
    {{--<meta name="viewport" content="user-scalable=0">--}}
    {{--<meta content="width=device-width,user-scalable=no" name="viewport">--}}
    <title>阳房通-地产资讯内容</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    {{--<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=1,viewport-fit=cover">--}}
    {{--<meta http-equiv="X-UA-Compatible" content="IE=edge">--}}
    {{--<meta name="color-scheme" content="light dark">--}}
    {{--<link rel="shortcut icon" type="image/x-icon" href="//res.wx.qq.com/a/wx_fed/assets/res/NTI4MWU5.ico">--}}
    {{--<link rel="mask-icon" href="//res.wx.qq.com/a/wx_fed/assets/res/MjliNWVm.svg" color="#4C4C4C">--}}
    {{--<link rel="apple-touch-icon-precomposed" href="//res.wx.qq.com/a/wx_fed/assets/res/OTE0YTAw.png">--}}
    {{--<meta name="apple-mobile-web-app-capable" content="yes">--}}
    {{--<meta name="apple-mobile-web-app-status-bar-style" content="black">--}}
    {{--<meta name="format-detection" content="telephone=no">--}}
    <style>
        body {
            margin: 0;
            /*overflow-x: hidden !important;*/
        }
        .container {
            /*display: flex;*/
            /*display: -webkit-flex; !* Safari *!*/
            /*display: flex;*/
            /*flex-direction: column;*/
            /*justify-content: flex-start;*/
            /*place-items: center;*/
            /*overflow-x:hidden;overflow-y:auto;*/
        }

        p {
            text-align: center;
            line-height: 1.6;
        }

        /*.container > * {*/
        /*white-space: nowrap;*/
        /*overflow: hidden;*/
        /*text-overflow: ellipsis;*/
        /*}*/

        /*body {*/
        /*width: 111px;*/
        /*}*/
    </style>

    {{--<meta name="viewport" content="width=device-width, initial-scale=0.5, minimum-scale=0.3, maximum-scale=2.0, user-scalable=yes" />--}}
    {{--<meta content="yes" name="apple-mobile-web-app-capable" />--}}
    {{--<meta content="black" name="apple-mobile-web-app-status-bar-style" />--}}
    {{--<meta content="telephone=no" name="format-detection" />--}}
</head>
<body>
{{--<div>--}}
{{--{{$board->id}}--}}
{{--{{$board->url}}--}}
{{--{{$board->title}}--}}
{{--{{$board->status}}--}}
{{--<div style="touch-action: none;touch-action: pan-y;overflow-x: hidden;">--}}
<div class="container">
    <p style="margin: 5%;">
        {{ $board->title }}
    </p>
    {!! $board->content !!}
</div>

<script src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>
{{--<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>--}}
<script>

    $("document").ready(function () {
        var win_w = $(window).width();

        $('.container').width(win_w)

        var img = $("body img");
        img.each(function (k, v) {
            var p_w = $(v).parent().width();
//            console.log(p_w);
            var data_src = $(v).attr('data-src');
            $(v).attr('src', data_src);
            var c_w = $(v).width();
            if (c_w > p_w) {
                $(v).width(p_w);
            }
            if (p_w == 0) {
                $(v).width(win_w);
            }
            if (c_w == 0) {
                $(v).width(win_w);
            }
//            var y_w = $(v).parent().parent().width();
//            console.log('p_w',p_w);
//            console.log('y_w',y_w);
//            console.log($(v));

//            var tes = $(v).attr('data-ratio');
//            console.log(tes);
//            console.log('>c_w', c_w);
//            console.log('>p_w', p_w);
        });

        var section = $("section");
        section.each((k, v) => {
            var section_width = $(v).width();
            if (section_width > win_w) {
                $(v).width(win_w)
            }

            if ($(v).attr('styleid') == 5435) {
                $(v).find('img').width('100px').height('100px')
            }
        })

    })
</script>
</body>
</html>