<?php
error_reporting(0);
include("../includes/common.php");
$title='卡密充值';
if($islogins==1){}else exit("<script language='javascript'>window.location.href='../login.php';</script>");
$row=$DB->get_row("SELECT * FROM moyu_user WHERE user='".$udata['user']."'");
$kami=$DB->get_row("SELECT * FROM moyu_km WHERE km='{$_POST['km']}'");
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
  <link rel="stylesheet" href="../assets/layuiadmin/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="../assets/layuiadmin/style/admin.css" media="all">
</head>

<div class="layui-fluid" id="LAY-component-timeline">
<div class="layui-row layui-col-space15">
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header"><?=$title?></div>
<div class="layui-card-body">
<form action="./kmlist.php" method="POST">
<div class="layui-card-body layui-row layui-col-space10">
<div class="layui-col-md6">
<input type="text" name="km" value="" autocomplete="off"  placeholder="请输入卡密" class="layui-input" required/>
</div>
</div>
<div class="layui-card-body layui-row layui-col-space10">
<div class="layui-col-md6">
<button type="submit" id="submit" class="layui-btn layui-btn-radius">确定使用</button>
</div>
</div>
</div>
<script>
$("#submit").click(function(){
	var km=$("input[name='km']").val();
	if(!km){
		layer.msg('卡密输入不能为空 ！',{icon:5});
		return false;
	}
});
</script>
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
<?php 
$km = $_POST['km'];
if(!$km)
{
exit;
}
else
{
if($kami)
{
//
if($kami["state"] == '0')
{
echo "<script type='text/javascript'>layer.msg('卡密充值成功,充值余额:".$kami['money']."',{icon:1});</script>";
$state = '1';
	$sql="update `moyu_km` set `state` ='{$state}' where `km`='{$km}'";
	$DB->query($sql);

$rmb = $udata['rmb'] + $kami['money'];
$adds="update `moyu_daili` set `rmb`='{$rmb}' where `user`='".$udata['user']."'";
$DB->query($adds);
}
else
{
echo "<script type='text/javascript'>layer.msg('当前卡密已被使用！',{icon:5});</script>";
}
}
else
{
//
echo "<script type='text/javascript'>layer.msg('充值失败,请检查卡密格式是否正确！',{icon:3});</script>";
}}
?>