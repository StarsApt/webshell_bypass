<?php
require 'inc.php';

/*微信公众号支付
开发步骤：https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=7_3
*/

$trade_no=daddslashes($_GET['trade_no']);

@header('Content-Type: text/html; charset=UTF-8');
$row=$DB->get_row("SELECT * FROM moyu_pay WHERE trade_no='{$trade_no}' limit 1");
if(!$row)exit('该订单号不存在，请返回来源地重新发起请求！');

require_once SYSTEM_ROOT."wxpay/WxPay.Api.php";
require_once SYSTEM_ROOT."wxpay/WxPay.JsApiPay.php";
if(WxPayConfig::BASE_DOMAIN!='' && WxPayConfig::BASE_DOMAIN!=$_SERVER['HTTP_HOST']){
	echo '<script>window.location.href=\'http://'.WxPayConfig::BASE_DOMAIN.'/other/wxjspay.php?trade_no='.$trade_no.'&d='.$_GET['d'].'\';</script>';
	exit;
}
//①、获取用户openid
$tools = new JsApiPay();
$openId = $tools->GetOpenid();
//②、统一下单
$input = new WxPayUnifiedOrder();
$input->SetBody($row['name']);
$input->SetOut_trade_no($trade_no);
$input->SetTotal_fee($row['money']*100);
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetNotify_url($siteurl.'wxpay_notify.php');
$input->SetTrade_type("JSAPI");
$input->SetProduct_id("01001");
$input->SetOpenid($openId);
$order = WxPayApi::unifiedOrder($input);
$jsApiParameters = $tools->GetJsApiParameters($order);

if($order["result_code"]=='SUCCESS'){

}else{
	sysmsg('微信支付下单失败！['.$order["err_code"].'] '.$order["err_code_des"]);
}

if($_GET['d']==1){
	$redirect_url='data.backurl';
}else{
	$redirect_url='\'wxwap_ok.php\'';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">
    <link href="//cdn.bootcss.com/ionic/1.3.1/css/ionic.min.css" rel="stylesheet" />
</head>
<body>
<div class="bar bar-header bar-light" align-title="center">
	<h1 class="title">微信安全支付</h1>
</div>
<div class="has-header" style="padding: 5px;position: absolute;width: 100%;">
<div class="text-center" style="color: #a09ee5;">
<i class="icon ion-information-circled" style="font-size: 80px;"></i><br>
<span>正在跳转...</span>
<script src="//cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<script>
	$(document).on('touchmove',function(e){
		e.preventDefault();
	});
    //调用微信JS api 支付
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			<?php echo $jsApiParameters; ?>,
			function(res){
				if(res.err_msg == "get_brand_wcpay_request:ok" ) {
					loadmsg();
				}
				//WeixinJSBridge.log(res.err_msg);
				//alert(res.err_code+res.err_desc+res.err_msg);
			}
		);
	}

	function callpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}
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
                        window.location.href=<?php echo $redirect_url?>;
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
                    alert('创建连接失败！');
                }
            }
        });
    }
    window.onload = callpay();
</script>
</div>
</div>
</body>
</html>