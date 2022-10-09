<?php
error_reporting(0);

include("./includes/common.php");
$title='用户注册';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"><title>
  <?php echo $conf["title"] ?> - <?=$title?></title>
  <meta name="description" content="<?php echo $conf['description']?>">
  <meta name="keywords" content="<?php echo $conf['keywords']?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
   <script src="//lib.baomitu.com/jquery/1.12.4/jquery.min.js"></script>
  <script src="//lib.baomitu.com/layer/2.3/layer.js"></script>
  <script src="//lib.baomitu.com/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="./assets/layuiadmin/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="./assets/layuiadmin/style/admin.css" media="all">
  <link rel="stylesheet" href="./assets/layuiadmin/style/login.css" media="all">
</head>
<body>
  <div class="layadmin-user-login layadmin-user-display-show" id="LAY-user-login" style="display: none;">
    <div class="layadmin-user-login-main">
      <div class="layadmin-user-login-box layadmin-user-login-header">
        <h3><?php echo $conf["title"] ?></h3>
        <p>web免杀系统</p>
      </div>
       <form action="./reg.php" method="POST" role="form" class="form-horizontal">
      <div class="layadmin-user-login-box layadmin-user-login-body layui-form">
        <div class="layui-form-item">
          <label class="layadmin-user-login-icon layui-icon layui-icon-login-qq" for="LAY-user-login-cellphone"></label>
          <input type="text" name="qq" lay-verify="phone" placeholder="QQ号" class="layui-input">
        </div>
        <div class="layui-form-item">
          <div class="layui-row">
            <div class="layui-col-xs7">
            </div>
          </div>
        </div>
        <div class="layui-form-item">
          <label class="layadmin-user-login-icon  layui-icon layui-icon-username" for="LAY-user-login-password"></label>
          <input type="text"  name="user" value="<?php echo @$_POST['user']?>"  placeholder="登入账号" class="layui-input">
        </div>
        <div class="layui-form-item">
          <label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-repass"></label>
          <input type="password"  name="pass"lay-verify="required" placeholder="登入密码" class="layui-input">
        </div>
        <div class="layui-form-item">
          <button class="layui-btn layui-btn-fluid"  type="submit" id="zc" name="submit" ng-disabled='form.$invalid' lay-submit lay-filter="LAY-user-reg-submit">注 册</button>
       </div>
        <div class="layui-trans layui-form-item layadmin-user-login-other">
         
          
          <a href="login.php" class="layadmin-user-jump-change layadmin-link layui-hide-xs">用已有帐号登入</a>
          <a href="login.php" class="layadmin-user-jump-change layadmin-link layui-hide-sm layui-show-xs-inline-block">登入</a>
        </div>
      </div>
    </div>
<?php
if(isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['qq'])){
$user=htmlentities(daddslashes($_POST['user']));
$pass=htmlentities(daddslashes($_POST['pass']));
$qq=daddslashes($_POST['qq']);
if(strlen($user) < 5) {
echo "<script type='text/javascript'>layer.alert('用户名太短！',{icon:5,closeBtn:0},function(){window.location.href='reg.php'});</script>";
exit();
}elseif(strlen($user) > 10){
echo "<script type='text/javascript'>layer.alert('用户名太长！',{icon:5,closeBtn:0},function(){window.location.href='reg.php'});</script>";
exit();
}elseif(strlen($qq) < 6) {
echo "<script type='text/javascript'>layer.alert('请输入正确QQ！',{icon:5,closeBtn:0},function(){window.location.href='reg.php'});</script>";
exit();
}elseif(strlen($qq) > 11){
echo "<script type='text/javascript'>layer.alert('QQ超出限制！',{icon:5,closeBtn:0},function(){window.location.href='reg.php'});</script>";
exit();
}else
$rows=$DB->get_row("select * from moyu_daili where user='$user' limit 1");
if($rows){
echo "<script type='text/javascript'>layer.alert('用户名已存在！',{icon:5,closeBtn:0},function(){window.location.href='reg.php'});</script>";
}else
$sql="insert into `moyu_daili` (`user`,`pass`,`qq`,`active`) values ('".$user."','".$pass."','".$qq."','1')";
if($DB->query($sql)){
echo "<script type='text/javascript'>layer.alert('注册成功！',{icon:6,closeBtn:0},function(){window.location.href='login.php'});</script>";
}elseif($islogins==1){
@header('Content-Type: text/html; charset=UTF-8');
echo "<script type='text/javascript'>layer.alert('进入控制面板！',{icon:6,closeBtn:0},function(){window.location.href='reg.php'});</script>";
}
}
?>
    <div class="layui-trans layadmin-user-login-footer">
     <p>© 2022 <a href="./" target="_blank"><?php echo $conf["title"] ?></a></p>
    </div>
  </div>
<script src="./assets/layui/layui.js"></script>
</body>
</html>