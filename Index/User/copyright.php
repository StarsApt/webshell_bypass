<?php
error_reporting(0);
/*
陌屿<2763994904@qq.com>
陌屿代码加密系统
QQ群：42103442
*/
include("../includes/common.php");
@header('Content-Type: text/html; charset=UTF-8');
if($islogins==1){}else exit("<script language='javascript'>window.location.href='../login.php';</script>");
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>站长主页</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <script src="//lib.baomitu.com/jquery/1.12.4/jquery.min.js"></script>
  <script src="//lib.baomitu.com/layer/2.3/layer.js"></script>
  <script src="//lib.baomitu.com/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="../assets/layuiadmin/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="../assets/layuiadmin/style/admin.css" media="all">
  <link rel="stylesheet" href="../assets/layuiadmin/style/template.css" media="all">
</head>
<body>
<div class="layui-fluid layadmin-homepage-fluid">
  <div class="layui-row layui-col-space8">
    <div class="layui-col-md2">
      <div class="layadmin-homepage-panel layadmin-homepage-shadow">
        <div class="layui-card text-center">
          <div class="layui-card-body">
            <div class="layadmin-homepage-pad-ver">
              <img class="layadmin-homepage-pad-img" src="http://q4.qlogo.cn/headimg_dl?dst_uin=<?php echo $conf['kfqq']?>&spec=100" width="96" height="96">
            </div>
            <h4 class="layadmin-homepage-font"></h4>
           <p class="layadmin-homepage-min-font"><?php echo $conf["title"] ?></p>
            <div class="layadmin-homepage-pad-ver">
              <a href="javascript:;" class="layui-icon layui-icon-cellphone"></a>
              <a href="javascript:;" class="layui-icon layui-icon-login-wechat"></a>
              <a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $conf['kfqq']?>&site=qq&menu=yes" class="layui-icon layui-icon-login-qq"></a>
            </div>
            <button id="qqkefu" class="layui-btn layui-btn-fluid" >点击联系我</button>
          </div>
        </div>
        <p class="layadmin-homepage-about">
          关于我
        </p>
        <ul class="layadmin-homepage-list-group">
          <li class="list-group-item"><i class="layui-icon layui-icon-location"></i> 中国深圳</li>
          <li class="list-group-item"><a href="#" class="color"><i class="layui-icon layui-icon-vercode"></i> <span style="word-wrap:break-word;"><?php echo $_SERVER['SERVER_NAME'];?></span></a></li>
        </ul>
        <div class="layadmin-homepage-pad-hor">
          <mdall>欢迎您使用本加密系统，开发框架layUIadmin。</mdall>
        </div>
        <p class="layadmin-homepage-about">
          系统特点
        </p>
        <ul class="layadmin-homepage-list-inline">
          <a href="javascript:;" class="layui-btn layui-btn-primary">高效</a>
          <a href="javascript:;" class="layui-btn layui-btn-primary">稳定</a>
        </ul> 
		     </div>
  	   </div>
<script>
$("#qqkefu").click(function(){
	var my=$("input[name='my']").val();
	if(!my){
layer.confirm('点击确定添加管理员！',{
btn:['确定','取消'],closeBtn:0,icon:1},
function(){
window.location.href='http://wpa.qq.com/msgrd?v=3&uin=<?php echo $conf['kfqq']?>&site=qq&menu=yes';
}, function(){
  layer.msg('为什么又不添加了哼！', {icon: 3});
});		return false;
	}
});
</script>
</body>
</html>