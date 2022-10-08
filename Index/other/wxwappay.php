<?php
require 'inc.php';

@header('Content-Type: text/html; charset=UTF-8');

$trade_no=daddslashes($_GET['trade_no']);
$row=$DB->get_row("SELECT * FROM moyu_pay WHERE trade_no='{$trade_no}' limit 1");
if(!$row)exit('该订单号不存在，请返回来源地重新发起请求！');

if($conf['wxpay_api']==3){
require_once SYSTEM_ROOT."wxpay/WxPay.Api.php";
require_once SYSTEM_ROOT."wxpay/WxPay.NativePay.php";
if(WxPayConfig::BASE_DOMAIN!='' && WxPayConfig::BASE_DOMAIN!=$_SERVER['HTTP_HOST']){
	echo '<script>window.location.href=\'http://'.WxPayConfig::BASE_DOMAIN.'/other/wxwappay.php?trade_no='.$trade_no.'\';</script>';
	exit;
}
$notify = new NativePay();
$input = new WxPayUnifiedOrder();
$input->SetBody($row['name']);
$input->SetOut_trade_no($trade_no);
$input->SetTotal_fee($row['money']*100);
$input->SetSpbill_create_ip($clientip);
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetNotify_url($siteurl.'wxpay_notify.php');
$input->SetTrade_type("MWEB");
$result = $notify->GetPayUrl($input);
if($result["result_code"]=='SUCCESS'){
	if($conf['wxpay_api']==3){
		$redirect_url=$siteurl.'wxwap_return.php?trade_no='.$trade_no;
		$url=$result['mweb_url'].'&redirect_url='.urlencode($redirect_url);
		exit("<script>window.location.replace('{$url}');</script>");
	}else{
		$code_url = $result['code_url'];
	}
}else{
	sysmsg('微信支付下单失败！['.$result["err_code"].'] '.$result["err_code_des"]);
}
}else{
	$target_url = $siteurl.'wxjspay.php?trade_no='.$trade_no;
}
?>
<html lang="zh-cn">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>微信安全支付</title>
  <link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>

<div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 center-block" style="float: none;">
<div class="panel panel-primary">
	<div class="panel-heading" style="text-align: center;"><h3 class="panel-title">
		微信安全支付
	</div>
		<div class="list-group" style="text-align: center;">
			<div class="list-group-item list-group-item-info">长按保存到相册使用扫码扫码完成支付</div>
			<div class="list-group-item">
			<div class="qr-image" id="qrcode"></div>
			</div>
			<div class="list-group-item list-group-item-info">或复制以下链接到微信打开：</div>
			<div class="list-group-item">
			<a href="<?php echo $target_url?>"><?php echo $target_url?></a><br/><button id="copy-btn" data-clipboard-text="<?php echo $target_url?>" class="btn btn-info btn-sm">一键复制</button>
			</div>
			<div class="list-group-item"><small>提示：你可以将以上链接发到自己微信的聊天框（在微信顶部搜索框可以搜到自己的微信），即可点击进入支付</small></div>
			<div class="list-group-item"><a href="weixin://" class="btn btn-primary">打开微信</a>&nbsp;<a href="#" onclick="checkresult()" class="btn btn-success">检测支付状态</a></div>
		</div>
</div>
</div>
<script src="//cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<script src="assets/js/qrcode.min.js"></script>
<script src="//lib.baomitu.com/clipboard.js/1.7.1/clipboard.min.js"></script>
<script>
	var clipboard = new Clipboard('#copy-btn');
	clipboard.on('success', function(e) {
		layer.msg('复制成功，请到微信里面粘贴');
	});
	clipboard.on('error', function(e) {
		layer.msg('复制失败，请长按链接后手动复制');
	});
	var qrcode = new QRCode("qrcode", {
        text: "<?php echo $target_url?>",
        width: 180,
        height: 180,
        colorDark: "#000000",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H
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
	function checkresult() {
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
                }
            }
        });
    }
    window.onload = loadmsg();
</script>
</body>
</html>