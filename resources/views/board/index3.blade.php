<!doctype html>
<html lang="en">
<head>
    {{--微信公众号侵权图片解锁--}}
    <meta name="referrer" content="never">
    {{--<meta charset="UTF-8">--}}
    {{--<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">--}}
    {{--<meta http-equiv="X-UA-Compatible" content="ie=edge">--}}
    {{--<meta name="viewport" content="user-scalable=0">--}}
    {{--<meta content="width=device-width,user-scalable=no" name="viewport">--}}
    <title>阳房通-地产资讯内容</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=1,viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="color-scheme" content="light dark">
    {{--<link rel="shortcut icon" type="image/x-icon" href="//res.wx.qq.com/a/wx_fed/assets/res/NTI4MWU5.ico">--}}
    {{--<link rel="mask-icon" href="//res.wx.qq.com/a/wx_fed/assets/res/MjliNWVm.svg" color="#4C4C4C">--}}
    {{--<link rel="apple-touch-icon-precomposed" href="//res.wx.qq.com/a/wx_fed/assets/res/OTE0YTAw.png">--}}
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">


    {{--<meta name="viewport" content="width=device-width, initial-scale=0.5, minimum-scale=0.3, maximum-scale=2.0, user-scalable=yes" />--}}
    {{--<meta content="yes" name="apple-mobile-web-app-capable" />--}}
    {{--<meta content="black" name="apple-mobile-web-app-status-bar-style" />--}}
    {{--<meta content="telephone=no" name="format-detection" />--}}
</head>
<body style="margin: 0;padding: 0">
{{--<div>--}}
{{--{{$board->id}}--}}
{{--{{$board->url}}--}}
{{--{{$board->title}}--}}
{{--{{$board->status}}--}}
{{--<div style="touch-action: none;touch-action: pan-y;overflow-x: hidden;">--}}
<div id="img-content" class="rich_media_wrp">
<h2 class="rich_media_title" id="activity-name">



    全民“赢”销，一荐万金，赢现金奖励，上不封顶
</h2>
<div id="meta_content" class="rich_media_meta_list">
    <span class="rich_media_meta rich_media_meta_text">
        老阳说房
    </span>

    <span class="rich_media_meta rich_media_meta_nickname" id="profileBt">
        <a href="javascript:void(0);" id="js_name">
            老阳说房                      </a>
        <div id="js_profile_qrcode" class="profile_container" style="display:none;">
            <div class="profile_inner">
                <strong class="profile_nickname">老阳说房</strong>
                <img class="profile_avatar" id="js_profile_qrcode_img" src="" alt="">

                <p class="profile_meta">
                    <label class="profile_meta_label">微信号</label>
                    <span class="profile_meta_value">gh_bcc90d42aa68</span>
                </p>

                <p class="profile_meta">
                    <label class="profile_meta_label">功能介绍</label>
                    <span class="profile_meta_value">关注阳新房地产的这些事儿，理性分析、中立视角、客观评价。提供阳新第一首楼市动态信息。</span>
                </p>

            </div>
            <span class="profile_arrow_wrp" id="js_profile_arrow_wrp">
                <i class="profile_arrow arrow_out"></i>
                <i class="profile_arrow arrow_in"></i>
            </span>
        </div>
    </span>
    <em id="publish_time" class="rich_media_meta rich_media_meta_text">8月28日</em>
</div>
{!! $board->content !!}
</div>
{{--</div>--}}
{{--</div>--}}
<script src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>
{{--<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>--}}
<script>
    $("document").ready(function () {
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