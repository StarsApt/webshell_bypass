<?php
error_reporting(0);

include("../includes/common.php");
$title='修改资料';
if($islogins==1){}else exit("<script language='javascript'>window.location.href='../login.php';</script>");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>
个人信息
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
<div class="layui-fluid">
<div class="layui-row layui-col-space15">
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header">网站设置</div>
<div class="layui-card-body" pad15>
<form action="./User.php" method="post" class="form-horizontal" role="form">

<div class="layui-form" wid100 lay-filter="">
<div class="layui-form-item">
<label class="layui-form-label">UID</label>
<div class="layui-input-block">
<input type="text" value="<?php echo $udata['id']?>" disabled class="layui-input">
</div>
</div>

<div class="layui-form-item">
<label class="layui-form-label">用户名</label>
<div class="layui-input-block">
<input type="text"  placeholder="用户名"  value="<?php echo $udata['user']?>" class="layui-input">
</div>
</div>

<div class="layui-form-item">
<label class="layui-form-label">您的QQ</label>
<div class="layui-input-block">
<input type="text" name="qq" placeholder="绑定QQ"  value="<?php echo $udata['qq']?>"  class="layui-input">
</div>
</div>

<div class="layui-form-item">
<label class="layui-form-label">新的密码</label>
<div class="layui-input-block">
<input type="text" name="pass" placeholder="新密码不修改留空" class="layui-input">
</div>
</div>

<div class="layui-form-item">
<div class="layui-input-block">
<button class="layui-btn" type="submit" name="submit"lay-submit lay-filter="set_website">确认保存</button>
</div>
</div>
</div>
<?php
if(isset($_POST['submit'])) {
$rows=$DB->get_row("select * from moyu_daili where id='{$udata['id']}' limit 1");
$pass=daddslashes($_POST['pass']);
if($_POST['pass']==""){
	$pass=$rows['pass'];
}else{
	$pass=daddslashes($_POST['pass']);
}
$sql="update `moyu_daili` set pass='$pass' where `id`='{$udata['id']}'";
if($DB->query($sql)){
@header('Content-Type: text/html; charset=UTF-8');
echo "<script type='text/javascript'>layer.alert('修改成功！',{icon:6,closeBtn:0},function(){window.location.href='User.php'});</script>";
}
}
?>
</body>
</html>