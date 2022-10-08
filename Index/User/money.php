<?php
error_reporting(0);
include("../includes/common.php");
$title='在线充值';
if($islogins==1){}else exit("<script language='javascript'>window.location.href='../login.php';</script>");
$row=$DB->get_row("SELECT * FROM moyu_user WHERE user='".$udata['user']."'");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?=$title?></title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <script src="//lib.baomitu.com/jquery/1.12.4/jquery.min.js"></script>
  <script src="//lib.baomitu.com/layer/2.3/layer.js"></script>
  <script src="//lib.baomitu.com/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="//cdn.bootcss.com/layer/3.0.1/layer.min.js"></script> 
  <link rel="stylesheet" href="../assets/layuiadmin/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="../assets/layuiadmin/style/admin.css" media="all">
</head>
<?php
if($conf["alipay_api"]==0 && $conf["tenpay_api"]==0 && $conf["qqpay_api"]==0 && $conf["wxpay_api"]==0){
	echo "<script type='text/javascript'>layer.alert('平台还没配置支付接口,如有问题联系站长！',{icon:5,closeBtn:0},function(){window.location.href='./index.php'});</script>";
}
?>
<div class="layui-fluid" id="LAY-component-timeline">
<div class="layui-row layui-col-space15">
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header"><?=$title?></div>
<div class="layui-card-body">
<div class="layui-card-body layui-row layui-col-space10">
<div class="layui-col-md12">
<input type="text" name="value" autocomplete="off"  placeholder="输入你要充值的余额" class="layui-input" required/>
</div>
</div>
<div class="layui-card-body layui-row layui-col-space10">
</p>
<?php 
if($conf['alipay_api'])echo '<button type="submit" class="btn btn-default" id="buy_alipay"><img src="../assets/icon/alipay.ico" width="15" height="17" class="logo">支付宝</button>&nbsp;';
if($conf['qqpay_api'])echo '<button type="submit" class="btn btn-default" id="buy_qqpay"><img src="../assets/icon/qqpay.ico" class="logo">QQ钱包</button>&nbsp;';
if($conf['wxpay_api'])echo '<button type="submit" class="btn btn-default" id="buy_wxpay"><img src="../assets/icon/wechat.ico" class="logo">微信支付</button>&nbsp;';
if($conf['tenpay_api'])echo '<button type="submit" class="btn btn-default" id="buy_tenpay"><img src="../assets/icon/tenpay.ico" class="logo">财付通</button>&nbsp;';
?>
</div>
</div>
<script src="//cdn.bootcss.com/clipboard.js/1.7.1/clipboard.min.js"></script>
<script src="//cdn.bootcss.com/toastr.js/latest/toastr.min.js"></script>
<script src="../assets/layui/layui.js"></script>
</body>
</html>