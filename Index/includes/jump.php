<?php
if(!defined('IN_CRONLITE'))exit();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>请使用浏览器打开</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport"/>
    <meta content="yes" name="apple-mobile-web-app-capable"/>
    <meta content="black" name="apple-mobile-web-app-status-bar-style"/>
    <meta name="format-detection" content="telephone=no"/>
    <meta content="false" name="twcClient" id="twcClient"/>
    <meta name="aplus-touch" content="1"/>
    <style>
body,html{width:100%;height:100%}
*{margin:0;padding:0}
body{background-color:#fff}
.top-bar-guidance{font-size:15px;color:#fff;height:70%;line-height:1.8;padding-left:20px;padding-top:20px;background:url(//gw.alicdn.com/tfs/TB1eSZaNFXXXXb.XXXXXXXXXXXX-750-234.png) center top/contain no-repeat}
.top-bar-guidance .icon-safari{width:25px;height:25px;vertical-align:middle;margin:0 .2em}
.app-download-tip{margin:0 auto;width:290px;text-align:center;font-size:15px;color:#2466f4;background:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAAcAQMAAACak0ePAAAABlBMVEUAAAAdYfh+GakkAAAAAXRSTlMAQObYZgAAAA5JREFUCNdjwA8acEkAAAy4AIE4hQq/AAAAAElFTkSuQmCC) left center/auto 15px repeat-x}
.app-download-tip .guidance-desc{background-color:#fff;padding:0 5px}
.app-download-btn{display:block;width:214px;height:40px;line-height:40px;margin:18px auto 0 auto;text-align:center;font-size:18px;color:#2466f4;border-radius:20px;border:.5px #2466f4 solid;text-decoration:none}
    </style>
</head>
<body>
<div class="top-bar-guidance">
    <p>点击右上角<img src="//gw.alicdn.com/tfs/TB1xwiUNpXXXXaIXXXXXXXXXXXX-55-55.png" class="icon-safari" /> <span id="openm">Safari打开</span></p>
    <p>可以继续浏览本站哦~</p>
</div>
<div class="app-download-tip">
    <span class="guidance-desc">您也可以复制本站网址，到其它浏览器打开</span>
</div>
<a data-clipboard-text="<?php echo $_SERVER['HTTP_HOST']?>" class="app-download-btn" id="J_BtnDowanloadApp">点此复制本站网址</a>

<script src="//lib.baomitu.com/clipboard.js/1.7.1/clipboard.min.js"></script>
<script src="//open.mobile.qq.com/sdk/qqapi.js?_bid=152"></script>
<script>
	document.querySelector('body').addEventListener('touchmove', function (event) {
		event.preventDefault();
	});
	if(navigator.userAgent.indexOf("Android") > -1){
		document.getElementById("openm").innerHTML='浏览器打开';
	}
	if(navigator.userAgent.indexOf("QQ/") > -1){
		mqq.ui.openUrl({ target: 2,url: window.location.href});
	}else if(navigator.userAgent.indexOf("MicroMessenger") > -1){
		if(navigator.userAgent.indexOf("Android") > -1){
			var iframe = document.createElement("iframe");
			iframe.style.display = "none";
			iframe.src = '?open=1';
			document.body.appendChild(iframe);
		}
	}
    var clipboard = new Clipboard('#J_BtnDowanloadApp');
	clipboard.on('success', function(e) {
		document.getElementById("J_BtnDowanloadApp").innerHTML='复制成功';
	});
	clipboard.on('error', function(e) {
		alert('复制失败，请点击右上角用浏览器打开');
	});
</script>
</body>
</html>