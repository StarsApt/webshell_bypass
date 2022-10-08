<?php
require 'inc.php';

@header('Content-Type: text/html; charset=UTF-8');

$trade_no=daddslashes($_GET['trade_no']);
if($conf['alipay_api']!=3)exit('当前支付接口未开启');
$row=$DB->get_row("SELECT * FROM moyu_pay WHERE trade_no='{$trade_no}' limit 1");
if(!$row)exit('该订单号不存在，请返回来源地重新发起请求！');

require_once(SYSTEM_ROOT."f2fpay/model/builder/AlipayTradePrecreateContentBuilder.php");
require_once(SYSTEM_ROOT."f2fpay/AlipayTradeService.php");

// 创建请求builder，设置请求参数
$qrPayRequestBuilder = new AlipayTradePrecreateContentBuilder();
$qrPayRequestBuilder->setOutTradeNo($trade_no);
$qrPayRequestBuilder->setTotalAmount($row['money']);
$qrPayRequestBuilder->setSubject($row['name']);

// 调用qrPay方法获取当面付应答
$qrPay = new AlipayTradeService($config);
$qrPayResult = $qrPay->qrPay($qrPayRequestBuilder);

//	根据状态值进行业务处理
$status = $qrPayResult->getTradeStatus();
$response = $qrPayResult->getResponse();
if($status == 'SUCCESS'){
	$code_url = $response->qr_code;
}elseif($status == 'FAILED'){
	sysmsg('支付宝创建订单二维码失败！['.$response->sub_code.']'.$response->sub_msg);
}else{
	print_r($response);
	sysmsg('系统异常，状态未知！');
}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Language" content="zh-cn">
<meta name="renderer" content="webkit">
<title>支付宝扫码支付 - <?php echo $conf['sitename']?></title>
<link href="assets/css/alipay_pay.css" rel="stylesheet" media="screen">
</head>
<body>
<div class="body">
<h1 class="mod-title">
<span class="ico-wechat"></span><span class="text">支付宝扫码支付</span>
</h1>
<div class="mod-ct">
<div class="order">
</div>
<div class="amount">￥<?php echo $row['money']?></div>
<div class="qr-image" id="qrcode">
</div>
 
<div class="detail" id="orderDetail">
<dl class="detail-ct" style="display: none;">
<dt>购买物品</dt>
<dd id="productName"><?php echo $row['name']?></dd>
<dt>商户订单号</dt>
<dd id="billId"><?php echo $row['trade_no']?></dd>
<dt>创建时间</dt>
<dd id="createTime"><?php echo $row['addtime']?></dd>
</dl>
<a href="javascript:void(0)" class="arrow"><i class="ico-arrow"></i></a>
</div>
<div class="tip">
<span class="dec dec-left"></span>
<span class="dec dec-right"></span>
<div class="ico-scan"></div>
<div class="tip-text">
<p>请使用支付宝扫一扫</p>
<p>扫描二维码完成支付</p>
</div>
</div>
<div class="tip-text">
</div>
</div>
<div class="foot">
<div class="inner">
<div id="J_downloadInteraction" class="download-interaction download-interaction-opening">
	<div class="inner-interaction">
		<p class="download-opening">正在打开支付宝<span class="download-opening-1">.</span><span class="download-opening-2">.</span><span class="download-opening-3">.</span></p>
		<p class="download-asking">如果没有打开支付宝，<a id="J_downloadBtn" href="javascript:;" onclick="openAli();">请点此重新唤起</a></p>
</div>
</div>
</div>
</div>
<script src="//cdn.staticfile.org/jquery/1.12.4/jquery.min.js"></script>
<script src="//cdn.staticfile.org/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
<script>
	var code_url = '<?php echo $code_url?>';
    $('#qrcode').qrcode({
        text: code_url,
        width: 230,
        height: 230,
        foreground: "#000000",
        background: "#ffffff",
        typeNumber: -1
    });
    // 订单详情
    $('#orderDetail .arrow').click(function (event) {
        if ($('#orderDetail').hasClass('detail-open')) {
            $('#orderDetail .detail-ct').slideUp(500, function () {
                $('#orderDetail').removeClass('detail-open');
            });
        } else {
            $('#orderDetail .detail-ct').slideDown(500, function () {
                $('#orderDetail').addClass('detail-open');
            });
        }
    });
    // 检查是否支付完成
    function loadmsg() {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "getshop.php",
            timeout: 10000, //ajax请求超时时间10s
            data: {type: "wxpay", trade_no: "<?php echo $row['trade_no']?>"}, //post数据
            success: function (data, textStatus) {
                //从服务器得到数据，显示数据并继续查询
                if (data.code == 1) {
					if (confirm("您已支付完成，需要跳转到订单页面吗？")) {
                        window.location.href=data.backurl;
                    } else {
                        // 用户取消
                    }
                }else{
                    setTimeout("loadmsg()", 4000);
                }
            },
            //Ajax请求超时，继续查询
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                if (textStatus == "timeout") {
                    setTimeout("loadmsg()", 1000);
                } else { //异常
                    setTimeout("loadmsg()", 4000);
                }
            }
        });
    }
    window.onload = loadmsg();
</script>
<script>
        if (typeof AlipayWallet !== 'object') {
            AlipayWallet = {};
        }

        (function () {
            var ua = navigator.userAgent.toLowerCase(),
                locked = false,
                domLoaded = document.readyState === 'complete',
                delayToRun;
            //alert(ua);
            function customClickEvent() {
                var clickEvt;
                if (window.CustomEvent) {
                    clickEvt = new window.CustomEvent('click', {
                        canBubble: true,
                        cancelable: true
                    });
                } else {
                    clickEvt = document.createEvent('Event');
                    clickEvt.initEvent('click', true, true);
                }

                return clickEvt;
            }

            function getAndroidVersion() {
                var match = ua.match(/android\s([0-9\.]*)/);
                return match ? match[1] : false;
            }

            var noIntentTest = /aliapp|360 aphone|weibo|windvane|ucbrowser|baidubrowser/.test(ua);
            var hasIntentTest = /chrome|samsung/.test(ua);
            var isAndroid = /android|adr/.test(ua) && !(/windows phone/.test(ua));
            var canIntent = !noIntentTest && hasIntentTest && isAndroid;
            var openInIfr = /weibo|m353/.test(ua);
            var inWeibo = ua.indexOf('weibo') > -1;

            if (ua.indexOf('m353') > -1 && !noIntentTest) {
                canIntent = false;
            }

            // 是否在 webview
            var inWebview = '';
            if (inWebview) {
                canIntent = false;
            }


            /**
             * 打开钱包
             * @@param   {string}    params  唤起钱包的参数设置('alipays://platformapi/startapp?'后面的值)
             * @@param   {boolean}   jumpUrl 唤起钱包后，android下要跳转到的URL；
             *                      若传"default"，则为https://d.alipay.com/i/index.htm?nojump=1#once
             */
            AlipayWallet.open = function (params, jumpUrl) {
                //alert(domLoaded);
                //alert(canIntent);
                //alert(ua.indexOf('360 aphone'));
                if (!domLoaded && (ua.indexOf('360 aphone') > -1 || canIntent)) {
                    var arg = arguments;
                    delayToRun = function () {
                        AlipayWallet.open.apply(null, arg);
                        delayToRun = null;
                    };
                    return;
                }

                // 唤起锁定，避免重复唤起
                if (locked) {
                    return;
                }
                locked = true;

                var o;
                // 参数容错
                if (typeof params === 'object') {
                    o = params;
                } else {
                    o = {
                        params: params,
                        jumpUrl: jumpUrl
                    };
                }

                // 参数容错
                if (typeof o.params !== 'string') {
                    o.params = '';
                }
                if (typeof o.openAppStore !== 'boolean') {
                    o.openAppStore = true;
                }

                o.params = o.params || 'appId=20000001';
                o.params = o.params + '';
                o.params = o.params + '&_t=' + (new Date() - 0);

                if (o.params.indexOf('startapp?') > -1) {
                    o.params = o.params.split('startapp?')[1];
                } else if (o.params.indexOf('startApp?') > -1) {
                    o.params = o.params.split('startApp?')[1];
                }

                // 是否为RC环境
                var isRc = '';

                // 是否唤起re包
                var isRe = '';
                if (typeof o.isRe === 'undefined') {
                    o.isRe = !!isRe;
                }

                // 通过alipays协议唤起钱包
                var schemePrefix;
                if (ua.indexOf('mac os') > -1 && ua.indexOf('mobile') > -1) {
                    // IOS RC包前缀为 alipaysrc
                    if (isRc) {
                        if (o.isRe) {
                            schemePrefix = 'alipayrerc';
                        } else {
                            schemePrefix = 'alipaysrc';
                        }
                    }
                }
                if (!schemePrefix && o.isRe) {
                    schemePrefix = 'alipayre';
                }
                schemePrefix = schemePrefix || 'alipays';

                // 由于历史原因，对 alipayqr 前缀做特殊处理
                if (location.href.indexOf('scheme=alipayqr') > -1) {
                    schemePrefix = 'alipayqr';
                    isRc = false;
                }




                if (!canIntent) {
                    var alipaysUrl = schemePrefix + '://platformapi/startapp?' + o.params;

                    if (ua.indexOf('qq/') > -1 || (ua.indexOf('safari') > -1 && (ua.indexOf('os 9_') > -1 || ua.indexOf('os 10_') > -1))) {
                        var openSchemeLink = document.getElementById('openSchemeLink');
                        if (!openSchemeLink) {
                            openSchemeLink = document.createElement('a');
                            openSchemeLink.id = 'openSchemeLink';
                            openSchemeLink.style.display = 'none';
                            document.body.appendChild(openSchemeLink);
                        }
                        openSchemeLink.href = alipaysUrl;
                        // 执行click
                        openSchemeLink.dispatchEvent(customClickEvent());
                    } else {
                        var ifr = document.createElement('iframe');
                        ifr.src = alipaysUrl;
                        ifr.style.display = 'none';
                        document.body.appendChild(ifr);
                    }
                } else {
                    // android 下 chrome 浏览器通过 intent 协议唤起钱包
                    var packageKey = 'AlipayGphone';
                    if (isRc) {
                        packageKey = 'AlipayGphoneRC';
                    }
                    var intentUrl = 'intent://platformapi/startapp?' + o.params + '#Intent;scheme=' + schemePrefix + ';package=com.eg.android.' + packageKey + ';end';

                    var openIntentLink = document.getElementById('openIntentLink');
                    if (!openIntentLink) {
                        openIntentLink = document.createElement('a');
                        openIntentLink.id = 'openIntentLink';
                        openIntentLink.style.display = 'none';
                        document.body.appendChild(openIntentLink);
                    }
                    openIntentLink.href = intentUrl;
                    // 执行click
                    openIntentLink.dispatchEvent(customClickEvent());
                }

                // 延迟移除用来唤起钱包的IFRAME并跳转到下载页
                setTimeout(function () {
                    if (typeof o.jumpUrl !== 'string') {
                        o.jumpUrl = '';
                    }

                    // URL白名单
                    var urlPattern = /^http(s)?:\/\/([a-z0-9_\-]+\.)*(alipay|taobao|alibaba|alibaba-inc|tmall|koubei)\.(com|net|cn|com\.cn)(:\d+)?([/;?].*)?$/;
                    // 默认跳转地址
                    if (o.jumpUrl === 'default') {
                        o.jumpUrl = 'https://ds.alipay.com/?nojump=true';
                    }

                    if (o.jumpUrl && typeof o.jumpUrl === 'string' && urlPattern.test(o.jumpUrl)) {
                        location.href = o.jumpUrl;
                    }
                }, 1000)


                // 唤起加锁，避免短时间内被重复唤起
                setTimeout(function () {
                    locked = false;
                }, 2500)
            }

            if (!domLoaded) {
                document.addEventListener('DOMContentLoaded', function () {
                    domLoaded = true;
                    if (typeof delayToRun === 'function') {
                        delayToRun();
                    }
                }, false);
            }
        })();
    </script>
    <script type="text/javascript">
        (function () {
            var schemeParam = 'saId=10000007&amp;clientVersion=3.7.0.0718&amp;qrcode='+code_url+'?_s=web-other';
            schemeParam = schemeParam.replace(/&amp;/ig, '&');


            if (!location.hash) {
                AlipayWallet.open({
                    params: schemeParam,
                    jumpUrl: '',
                    openAppStore: false
                });
            }



            function pageFuntion() {
                var interactionNode = document.getElementById('J_downloadInteraction');
                setTimeout(function () {
                    interactionNode.className = "download-interaction download-interaction-asking";
                }, 3000);
            }

            if (/complete|loaded|interactive/.test(document.readyState && document.body)) {
                pageFuntion();
            } else {
                document.addEventListener('DOMContentLoaded', function () {
                    pageFuntion();
                }, true);
            }
        })();
        function openAli()
        {
            var schemeParam = 'saId=10000007&amp;clientVersion=3.7.0.0718&amp;qrcode='+code_url+'?_s=web-other';
            schemeParam = schemeParam.replace(/&amp;/ig, '&');
            if (!location.hash) {
                AlipayWallet.open({
                    params: schemeParam,
                    jumpUrl: '',
                    openAppStore: false
                });
            }
        }
    </script>
</body>
</html>