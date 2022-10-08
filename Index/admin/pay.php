<?php
error_reporting(0);
/**
 * 平台设置
**/
include("../includes/common.php");
$title='支付设置';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>
支付设置
</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
<script src="//lib.baomitu.com/jquery/1.12.4/jquery.min.js"></script>
<script src="//lib.baomitu.com/layer/2.3/layer.js"></script>
<script src="//lib.baomitu.com/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../assets/layuiadmin/layui/css/layui.css" media="all">
<link rel="stylesheet" href="../assets/layuiadmin/style/admin.css" media="all">
</head>
<body>
<?php
$mod=isset($_GET['mod'])?$_GET["mod"]:NULL;
if($mod=='pay_n'){
if (!file_exists('unlockpay') && file_exists('pay.lock') && !empty($conf['epay_pid']) && is_numeric($conf['epay_pid']) && strlen($conf['epay_key']) > 20 && ($_POST['epay_pid'] != $conf['epay_pid'] || $_POST['epay_key'] != $conf['epay_key'])) {
echo "<script type='text/javascript'>layer.alert('为保障你的资金安全，如需修改支付商户和密钥，请删除admin/pay.lock！',{icon:5,closeBtn:0},function(){history.go(-1)});</script>";
}
if (!file_exists('unlockpay') && file_exists('pay.lock') && !empty($_POST['codepay_id']) && !empty($_POST['codepay_key']) && is_numeric($_POST['codepay_id']) && ($_POST['codepay_id'] != $conf['codepay_id'] || $_POST['codepay_key'] != $conf['codepay_key'])) {
echo "<script type='text/javascript'>layer.alert('为保障你的资金安全，如需修改支付商户和密钥，请删除admin/pay.lock！',{icon:5,closeBtn:0},function(){history.go(-1)});</script>";
}
saveSetting('alipay_api',$_POST['alipay_api']);
saveSetting('tenpay_api',$_POST['tenpay_api']);
saveSetting('qqpay_api',$_POST['qqpay_api']);
saveSetting('wxpay_api',$_POST['wxpay_api']);
if(($conf['alipay_api']==1 || $conf['tenpay_api']==1) || $conf['qqpay_api']==1 || $conf['wxpay_api']==1){
saveSetting('payapi',$_POST['payapi']);
saveSetting('epay_url',($_POST['payapi']==(-1)?$_POST['epay_url']:NULL));
saveSetting('epay_pid',$_POST['epay_pid']);
saveSetting('epay_key',$_POST['epay_key']);
}
if($conf['alipay_api']==2 || $conf['qqpay_api']==2 || $conf['wxpay_api']==2){
saveSetting('codepay_id',$_POST['codepay_id']);
saveSetting('codepay_key',$_POST['codepay_key']);
}
$ad=$CACHE->clear();
if($ad){
echo "<script type='text/javascript'>layer.alert('修改成功!',{icon:6,closeBtn:0},function(){window.location.href='pay.php?mod=pay'});</script>";
}else{
echo "<script type='text/javascript'>layer.alert('修改失败!',{icon:5,closeBtn:0},function(){window.location.href='pay.php?mod=pay'});</script>";
}
}elseif($mod=='pay'){
echo'
<div class="layui-fluid">
<div class="layui-row layui-col-space15">
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header">支付接口配置</div>
<div class="layui-card-body" pad15>
<form action="./pay.php?mod=pay_n" method="post" class="form-horizontal" role="form">

<div class="layui-form" wid100 lay-filter="">
<div class="layui-form-item">
<label class="layui-form-label">支付宝接口配置</label>
<div class="layui-input-block">
<div class="layui-col-md12">
<select name="alipay_api" default="';echo $conf['alipay_api'];echo '" lay-verify="">
<option value="0">关闭</option>
<option value="1">易支付免签约接口</option>
<option value="2">码支付免签约接口</option>
</select>
</div>
</div>
</div>';

echo'
<div class="layui-form-item">
<label class="layui-form-label">财付通接口配置</label>
<div class="layui-input-block">
<div class="layui-col-md12">
<select name="tenpay_api" default="'.$conf['tenpay_api'].'" lay-verify="">
<option value="0">关闭</option>
<option value="2">易支付免签约接口</option>
</select>
</div>
</div>
</div>

<div class="layui-form-item">
<label class="layui-form-label">QQ钱包接口配置</label>
<div class="layui-input-block">
<div class="layui-col-md12">
<select name="qqpay_api" default="'.$conf['qqpay_api'].'" lay-verify="">
<option value="0">关闭</option>
<option value="1">易支付免签约接口</option>
<option value="2">码支付免签约接口</option>
</select>
</div>
</div>
</div>

<div class="layui-form-item">
<label class="layui-form-label">微信接口配置</label>
<div class="layui-input-block">
<div class="layui-col-md12">
<select name="wxpay_api" default="'.$conf['wxpay_api'].'" lay-verify="">
<option value="0">关闭</option>
<option value="1">易支付免签约接口</option>
<option value="2">码支付免签约接口</option>
</select>
</div>
</div>
</div>';

if($conf['alipay_api']==1 || $conf['tenpay_api']==1 || $conf['tenpay_api']==1 || $conf['wxpay_api']==1){
	

echo'
<div class="layui-form-item">
<label class="layui-form-label">接入商选择</label>
<div class="layui-input-block">
<div class="layui-col-md12">
<select name="payapi" default="'.$conf['payapi'].'">
<option value="0">默认ABC支付</option>
<option value="1">需要改请到other/inc.php修改</option>
</select>
</div>
</div>
</div>

<div class="layui-form-item">
<label class="layui-form-label">支付商户ID</label>
<div class="layui-input-block">
<input type="text" name="epay_pid" value="'.$conf['epay_pid'].'" class="layui-input">
</div>
</div>

<div class="layui-form-item">
<label class="layui-form-label">支付商户秘钥</label>
<div class="layui-input-block">
<input type="text" name="epay_key" value="'.$conf['epay_key'].'" class="layui-input">
</div>
</div>';
}

if ($conf['alipay_api']==2 || $conf['qqpay_api']==2 || $conf['wxpay_api']==2){
echo'
<div class="layui-form-item">
<label class="layui-form-label">码支付ID</label>
<div class="layui-input-block">
<input type="text" name="codepay_id" value="'.$conf['codepay_id'].'" class="layui-input">
</div>
</div>

<div class="layui-form-item">
<label class="layui-form-label">码支付通信密钥</label>
<div class="layui-input-block">
<input type="text" name="codepay_key" value="'.$conf['codepay_key'].'" class="layui-input">
<pre><font color="green">codepay.fateqq.com 码支付支付宝和QQ需要挂电脑软件，微信不需要挂软件</font></pre>
</div>
</div>
';
}

echo'
<div class="layui-form-item">
<div class="layui-input-block">
<button class="layui-btn" type="submit" name="submit" lay-submit lay-filter="set_website">确认保存</button>
</form>
</div>
</div>
<script>
$("select[name=\'alipay_api\']").change(function(){
	if($(this).val() == 1){
		$("#paymoyu_01").css("display","inherit");
		$("#paymoyu_06").css("display","none");
	}else if($(this).val() == 3){
		$("#paymoyu_01").css("display","none");
		$("#paymoyu_06").css("display","inherit");
	}else{
		$("#paymoyu_01").css("display","none");
		$("#paymoyu_06").css("display","none");
	}
});
$("select[name=\'tenpay_api\']").change(function(){
	if($(this).val() == 1){
		$("#paymoyu_03").css("display","inherit");
	}else{
		$("#paymoyu_03").css("display","none");
	}
});
$("select[name=\'wxpay_api\']").change(function(){
	if($(this).val() == 1 || $(this).val() == 3){
		$("#paymoyu_04").css("display","inherit");
	}else{
		$("#paymoyu_04").css("display","none");
	}
});
$("select[name=\'qqpay_api\']").change(function(){
	if($(this).val() == 1){
		$("#paymoyu_05").css("display","inherit");
	}else{
		$("#paymoyu_05").css("display","none");
	}
});
$("select[name=\'alipay2_api\']").change(function(){
	if($(this).val() == 1){
		$("#paymoyu_02").css("display","inherit");
	}else{
		$("#paymoyu_02").css("display","none");
	}
});
$("select[name=\'payapi\']").change(function(){
	if($(this).val() == -1){
		$("#paymoyu_07").css("display","inherit");
	}else{
		$("#paymoyu_07").css("display","none");
	}
});
function Addstr(id, str) {
	$("#"+id).val($("#"+id).val()+str);
}
var items = $("select[default]");
for (i = 0; i < items.length; i++) {
	$(items[i]).val($(items[i]).attr("default")||0);
}
</script>';
}?>
<script src="../assets/layuiadmin/layui/layui.js"></script>  
<script>
  layui.config({
    base: '../assets/layuiadmin/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index', 'form'], function(){
    var $ = layui.$
    ,admin = layui.admin
    ,element = layui.element
    ,form = layui.form;
    
    form.render(null, 'component-form-element');
    element.render('breadcrumb', 'breadcrumb');
    
    form.on('submit(component-form-element)', function(data){
      layer.msg(JSON.stringify(data.field));
      return false;
    });
  });
</script>
</body>
</html>