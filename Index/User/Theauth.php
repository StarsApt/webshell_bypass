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
  <title>联系方式-陌屿加密系统</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="../assets/layuiadmin/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="../assets/layuiadmin/style/admin.css" media="all">
</head>
<body>

  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header">联系方式</div>
          <div class="layui-card-body">
            <blockquote class="layui-elem-quote">客服QQ<br><font color=red>QQ：<?php echo $conf['kfqq']?></font></blockquote>
          </div>
        </div>
      </div>
    </div>
  </div>

  
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