<?php
error_reporting(0);
/**
 * 后台管理
**/
$mod='blank';
include("../includes/common.php");
$title='后台管理';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>
网站管理
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
</script>
';
$mod=isset($_GET['mod'])?$_GET["mod"]:NULL;
if($mod=='site_n' && $_POST["do"] == "submit"){
saveSetting('title',$_POST['title']);
saveSetting('keywords',$_POST['keywords']);
saveSetting('description',$_POST['description']);
saveSetting('qunhao',$_POST['qunhao']);
saveSetting('qqjump',$_POST['qqjump']);
saveSetting('GongGao',$_POST['GongGao']);
$ad=$CACHE->clear();
if($ad){
echo "<script type='text/javascript'>layer.alert('修改成功!',{icon:6,closeBtn:0},function(){window.location.href='set.php?mod=site'});</script>";
}else
echo "<script type='text/javascript'>layer.alert('修改失败!',{icon:5,closeBtn:0},function(){window.location.href='set.php?mod=site'});</script>";
}else{
if($mod == "site"){
echo'
<div class="layui-fluid">
<div class="layui-row layui-col-space15">
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header">网站设置</div>
<div class="layui-card-body" pad15>
<form action="./set.php?mod=site_n" method="post" class="form-horizontal" role="form">
<input type="hidden" name="do" value="submit">
';
echo'
<div class="layui-form" wid100 lay-filter="">
<div class="layui-form-item">
<label class="layui-form-label">网站名称</label>
<div class="layui-input-block">
<input type="text" name="title" value="'.$conf['title'].'" class="layui-input">
</div>
</div>
';
echo'
<div class="layui-form-item">
<label class="layui-form-label">网站关键词</label>
<div class="layui-input-block">
<input type="text" name="keywords" value="'.$conf['keywords'].'" class="layui-input">
</div>
</div>
';
echo'
<div class="layui-form-item">
<label class="layui-form-label">网信息描述</label>
<div class="layui-input-block">
<input type="text" name="description" value="'.$conf['description'].'" class="layui-input">
</div>
</div>
';
echo'
<div class="layui-form-item">
<label class="layui-form-label">QQ群链接地址</label>
<div class="layui-input-block">
<input type="text" name="qunhao" value="'.$conf['qunhao'].'" class="layui-input">
</div>
</div>
';
echo'
<div class="layui-form-item">
<label class="layui-form-label">QQ跳转浏览器</label>
<div class="layui-input-block">
<div class="layui-col-md12">
<select name="qqjump" lay-verify="">
';
if(($conf['qqjump'])=="1"){
echo'<option value="1">开启</option><option value="0">关闭</option>';}
elseif(($conf['qqjump'])=="0"){
echo'<option value="0">关闭</option><option value="1">开启</option>';} 
echo'</select>
</div>
</div>
</div>
';
echo'
<div class="layui-form-item layui-form-text">
<label class="layui-form-label">网站公告</label>
<div class="layui-input-block">
<textarea name="GongGao" class="layui-textarea">'.$conf['GongGao'].'</textarea>
</div>
</div>
';
echo'  
<div class="layui-form-item">
<div class="layui-input-block">
<button class="layui-btn" type="submit"lay-submit lay-filter="set_website">确认保存</button>
</div>
</div>
</div>
';
}elseif ($mod == 'jiage_n' && $_POST['do'] == 'submit') {
saveSetting('hx',$_POST['hx']);
saveSetting('wd',$_POST['wd']);
saveSetting('mzphp',$_POST['mzphp']);
saveSetting('zym',$_POST['zym']);
saveSetting('sizekb',$_POST['sizekb']);
$ad=$CACHE->clear();
if($ad){
echo "<script type='text/javascript'>layer.alert('修改成功!',{icon:6,closeBtn:0},function(){window.location.href='set.php?mod=jiage'});</script>";
}else
echo "<script type='text/javascript'>layer.alert('修改失败!',{icon:5,closeBtn:0},function(){window.location.href='set.php?mod=jiage'});</script>";
}else{
if($mod == "jiage"){
echo'
<div class="layui-fluid">
<div class="layui-row layui-col-space15">
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header">价格设置</div>
<div class="layui-card-body" pad15>
<form action="./set.php?mod=jiage_n" method="post" class="form-horizontal" role="form">
<input type="hidden" name="do" value="submit">
';
echo'
<div class="layui-form" wid100 lay-filter="">
<div class="layui-form-item">
<label class="layui-form-label">混淆加密价格</label>
<div class="layui-input-block">
<input type="text" name="hx" value="'.$conf['hx'].'" class="layui-input">
</div>
</div>
';
echo'
<div class="layui-form-item">
<label class="layui-form-label">威盾加密价格</label>
<div class="layui-input-block">
<input type="text" name="wd" value="'.$conf['wd'].'" class="layui-input">
</div>
</div>
';
echo'
<div class="layui-form-item">
<label class="layui-form-label">php免杀方式1次数</label>
<div class="layui-input-block">
<input type="text" name="mzphp" value="'.$conf['mzphp'].'" class="layui-input">
</div>
</div>
';
echo'
<div class="layui-form-item">
<label class="layui-form-label">找源码解密价格</label>
<div class="layui-input-block">
<input type="text" name="zym" value="'.$conf['zym'].'" class="layui-input">
</div>
</div>
';
echo'
<div class="layui-form-item">
<label class="layui-form-label">上传文件限制大小（KB）</label>
<div class="layui-input-block">
<input type="text" name="sizekb" value="'.$conf['sizekb'].'" class="layui-input">
</div>
</div>
';
echo'  
<div class="layui-form-item">
<div class="layui-input-block">
<button class="layui-btn" type="submit"lay-submit lay-filter="set_website">确认保存</button>
</div>
</div>
</div>
';
}elseif ($mod == 'pass_n' && $_POST['do'] == 'submit') {
$admin_user=$_POST['admin_user'];
$admin_pass=$_POST['admin_pass'];

$pass=md5($admin_pass);
saveSetting('admin_user',$admin_user);
saveSetting('kfqq',$_POST['kfqq']);
if(!empty($admin_pass)){
saveSetting('admin_pass',$pass);
}$ad=$CACHE->clear();
if($ad){
echo "<script type='text/javascript'>layer.alert('修改成功!',{icon:6,closeBtn:0},function(){window.location.href='set.php?mod=pass'});</script>";
}else
echo "<script type='text/javascript'>layer.alert('修改失败!',{icon:5,closeBtn:0},function(){window.location.href='set.php?mod=pass'});</script>";
}else{
if($mod == "pass"){
echo'
<div class="layui-fluid">
<div class="layui-row layui-col-space15">
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header">个人设置</div>
<div class="layui-card-body" pad15>
<form action="./set.php?mod=pass_n" method="post" class="form-horizontal" role="form">
<input type="hidden" name="do" value="submit">
';
echo'			
<div class="layui-form-item">
<label class="layui-form-label">您的账号</label>
<div class="layui-input-block">
<input type="text" name="admin_user" value="'.$conf['admin_user'].'" class="layui-input">
</div>
</div>
';
echo'
<div class="layui-form-item">
<label class="layui-form-label">修改密码</label>
<div class="layui-input-block">
<input type="text" name="admin_pass" placeholder="不修改留空" class="layui-input">
</div>
</div>
';
echo'
<div class="layui-form-item">
<label class="layui-form-label">您的 Q Q</label>
<div class="layui-input-block">
<input type="text" name="kfqq" value="'.$conf['kfqq'].'" class="layui-input">
</div>
</div>
';
echo'  
<div class="layui-form-item">
<div class="layui-input-block">
<button class="layui-btn" type="submit" lay-submit lay-filter="set_website">确认保存</button>
</div>
</div>
</div>';
echo '
</form>
</div>
</div>
</div>
';
}
}
}
}
echo "<script>\r\nvar items = \$(\"select[default]\");\r\nfor (i = 0; i < items.length; i++) {\r\n\t\$(items[i]).val(\$(items[i]).attr(\"default\")||0);\r\n}\r\n</script>\r\n    </div>\r\n  </div>";
?>
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