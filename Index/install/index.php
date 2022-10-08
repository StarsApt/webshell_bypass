<?php
error_reporting(0);
@header('Content-Type: text/html; charset=UTF-8');
$do=isset($_GET['do'])?$_GET['do']:'0';
if(file_exists('install.lock')){
	$installed=true;
	$do='0';
}

function checkfunc($f,$m = false) {
	if (function_exists($f)) {
		return '<font color="green">可用</font>';
	} else {
		if ($m == false) {
			return '<font color="black">不支持</font>';
		} else {
			return '<font color="red">不支持</font>';
		}
	}
}

function checkclass($f,$m = false) {
	if (class_exists($f)) {
		return '<font color="green">可用</font>';
	} else {
		if ($m == false) {
			return '<font color="black">不支持</font>';
		} else {
			return '<font color="red">不支持</font>';
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<title>陌屿加密系统 - 安装向导</title>
<link href="../assets/layui/inst.css" rel="stylesheet">
</head>
<body>
<div class="container"><br>
<div class="row">
<div class="col-xs-12">
<div class="alert alert-success" role="alert"><center>欢迎使用陌屿加密系统</center></div>
</div>
<?php if($do=='0'){?>
<div class="col-xs-12">
<div class="panel panel-primary">
<div class="panel-heading text-center">更新日志</div>
<div class="panel-body">
<p>
<iframe Language="JavaScript" src="readme.txt" style="width:100%;height:465px;"></iframe>
</p>
<?php if($installed){ ?>
<div class="alert alert-success">您已经安装过，如需重新安装请删除<font color=red> install/install.lock </font>文件后再安装！</div>
<?php }else{?>
<a href="?do=1" class="btn list-group-item">开始安装</a>
<?php }?>
</div>
</div>
</div>
<?php }elseif($do=='1'){?>
<div class="col-xs-12">
<div class="panel panel-primary">
<div class="panel-heading text-center">安装环境检测</div>
<div class="panel-body">
<?php
$install=true;
if(checkfunc('curl_exec',true)){
$check[0]='<span class="badge">支持</span>';
}else{
$check[0]='<span class="badge">不支持</span>';
$install=false;
}
if(checkfunc('file_get_contents',true)){
$check[1]='<span class="badge">支持</span>';
}else{
$check[1]='<span class="badge">不支持</span>';
$install=false;
}
if(version_compare(PHP_VERSION,'5.3.0','<')){
$check[2]='<span class="badge">不支持</span>';
}else{
$check[2]='<span class="badge">支持</span>';
}
?>
<ul class="list-group">
<li class="list-group-item">抓取网页权限 <?php echo $check[0];?></li>
<li class="list-group-item">目录读取权限 <?php echo $check[1];?></li>
<li class="list-group-item">PHP版本>=5.6 <?php echo $check[2];?></li>
<li class="list-group-item">成功安装后安装文件就会锁定，如需重新安装，请手动删除install/目录下install.lock文件！</li>
<?php
if($install) echo'<a href="?do=2" class="btn list-group-item">检测通过，下一步</a>';
?>
</ul>
</div>
</div>
</div>
<?php }elseif($do=='2'){?>
<div class="col-xs-12">
<div class="panel panel-primary">
<div class="panel-heading text-center">MYSQL数据库信息配置</div>
<div class="panel-body">
<div class="list-group text-success">

<form action="?do=3" class="form-horizontal" method="post">
<input type="hidden" name="action" class="form-control" value="install">

<div class="form-group">
<label class="col-sm-2 control-label">数据库地址</label>
<div class="col-sm-10">
<input type="text" name="db_host" class="form-control" value="localhost">
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">数据库端口</label>
<div class="col-sm-10">
<input type="text" name="db_port" class="form-control" value="3306">
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">数据库库名</label>
<div class="col-sm-10">
<input type="text" name="db_name" class="form-control">
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">数据库用户名</label>
<div class="col-sm-10">
<input type="text" name="db_user" class="form-control">
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">数据库密码</label>
<div class="col-sm-10">
<input type="password" name="db_pwd" class="form-control">
</div>
</div>

<div class="form-group">
<div class="col-sm-offset-2 col-sm-10">
<button type="submit" class="btn btn-success btn-block">确认无误，下一步</button>
</div>
</div>
</form>
<br/>
<center>（如果已事先填写好config.php相关数据库配置，请 <a href="?do=3&jump=1">点击此处</a> 跳过这一步！）</center>
</div>
</div>
</div>
</div>
<?php }elseif($do=='3'){?>
<div class="col-xs-12">
<div class="panel panel-primary">
<div class="panel-heading text-center">MYSQL数据库信息配置</div>
<div class="panel-body">
<div class="list-group text-success">
<?php
require './db.class.php';
if(defined("SAE_ACCESSKEY") || $_GET['jump']==1){
if(defined("SAE_ACCESSKEY"))include_once '../includes/sae.php';
else include_once '../config.php';
if(!$dbconfig['user']||!$dbconfig['pwd']||!$dbconfig['dbname']) {
echo '<div class="alert alert-danger">请先填写好数据库并保存后再安装！<hr/><a href="javascript:history.back(-1)"><< 返回上一页</a></div>';
} else {
if(!$con=DB::connect($dbconfig['host'],$dbconfig['user'],$dbconfig['pwd'],$dbconfig['dbname'],$dbconfig['port'])){
if(DB::connect_errno()==2002)
echo '<div class="alert alert-warning">连接数据库失败，数据库地址填写错误！</div>';
elseif(DB::connect_errno()==1045)
echo '<div class="alert alert-warning">连接数据库失败，数据库用户名或密码填写错误！</div>';
elseif(DB::connect_errno()==1049)
echo '<div class="alert alert-warning">连接数据库失败，数据库名不存在！</div>';
else
echo '<div class="alert alert-warning">连接数据库失败，['.DB::connect_errno().']'.DB::connect_error().'</div>';
}else{
echo '<div class="alert alert-success">数据库配置文件保存成功！</div>';
if(DB::query("select * from moyu_config where 1")==FALSE)
echo '<p align="right"><a class="btn btn-primary btn-block" href="?do=4">创建数据表>></a></p>';
else
echo '<div class="list-group-item list-group-item-info">系统检测到你已安装过陌屿加密系统</div>
<div class="list-group-item">
<a href="?do=6" class="btn btn-block btn-info">跳过安装</a>
</div>
<div class="list-group-item">
<a href="?do=4" onclick="if(!confirm(\'全新安装将会清空所有数据，是否继续？\')){return false;}" class="btn btn-block btn-warning">强制全新安装</a>
</div>';
}
}
}else{
$db_host=isset($_POST['db_host'])?$_POST['db_host']:NULL;
$db_port=isset($_POST['db_port'])?$_POST['db_port']:NULL;
$db_user=isset($_POST['db_user'])?$_POST['db_user']:NULL;
$db_pwd=isset($_POST['db_pwd'])?$_POST['db_pwd']:NULL;
$db_name=isset($_POST['db_name'])?$_POST['db_name']:NULL;

if($db_host==null || $db_port==null || $db_user==null || $db_pwd==null || $db_name==null){
echo '<div class="alert alert-danger">保存错误,请确保每项都不为空<hr/><a href="javascript:history.back(-1)"><< 返回上一页</a></div>';
} else {
$config="<?php
/*数据库配置*/
\$dbconfig=array(
	'host' => '{$db_host}', //数据库服务器
	'port' => {$db_port}, //数据库端口
	'user' => '{$db_user}', //数据库用户名
	'pwd' => '{$db_pwd}', //数据库密码
	'dbname' => '{$db_name}', //数据库名
);
?>";
if(!$con=DB::connect($db_host,$db_user,$db_pwd,$db_name,$db_port)){
if(DB::connect_errno()==2002)
echo '<div class="alert alert-warning">连接数据库失败，数据库地址填写错误！</div>';
elseif(DB::connect_errno()==1045)
echo '<div class="alert alert-warning">连接数据库失败，数据库用户名或密码填写错误！</div>';
elseif(DB::connect_errno()==1049)
echo '<div class="alert alert-warning">连接数据库失败，数据库名不存在！</div>';
else
echo '<div class="alert alert-warning">连接数据库失败，['.DB::connect_errno().']'.DB::connect_error().'</div>';
}elseif(file_put_contents('../config.php',$config)){
echo '<div class="alert alert-success">数据库配置文件保存成功！</div>';
if(DB::query("select * from moyu_config where 1")==FALSE)
echo '<p align="right"><a class="btn btn-primary btn-block" href="?do=4">创建数据表>></a></p>';
else
echo '<div class="list-group-item list-group-item-info">系统检测到你已安装过陌屿加密系统</div>
<div class="list-group-item">
<a href="?do=6" class="btn btn-block btn-info">跳过安装</a>
</div>
';
}else
echo '<div class="alert alert-danger">保存失败，请确保网站根目录有写入权限<hr/><a href="javascript:history.back(-1)"><< 返回上一页</a></div>';
}
}
?>
</div>
</div>
</div>
</div>
<?php }elseif($do=='4'){?>
<div class="col-xs-12">
<div class="panel panel-primary">
<div class="panel-heading text-center">MYSQL数据库信息配置</div>
<div class="panel-body">
<?php
if(defined("SAE_ACCESSKEY"))include_once '../includes/sae.php';
else include_once '../config.php';
if(!$dbconfig['user']||!$dbconfig['pwd']||!$dbconfig['dbname']) {
echo '<div class="alert alert-danger">请先填写好数据库并保存后再安装！<hr/><a href="javascript:history.back(-1)"><< 返回上一页</a></div>';
} else {
require './db.class.php';
$sql=file_get_contents("install.sql");
$sql=explode(';',$sql);
$cn = DB::connect($dbconfig['host'],$dbconfig['user'],$dbconfig['pwd'],$dbconfig['dbname'],$dbconfig['port']);
if (!$cn) die('err:'.DB::connect_error());
DB::query("set sql_mode = ''");
DB::query("set names utf8");
$t=0; $e=0; $error='';
for($i=0;$i<count($sql);$i++) {
if ($sql[$i]=='')continue;
if(DB::query($sql[$i])) {
++$t;
} else {
++$e;
$error.=DB::error().'<br/>';
}
}
}
echo '<div class="alert alert-success">安装成功！<br/>SQL成功'.$t.'句/失败'.$e.'句</div><p align="right"><a class="btn btn-block btn-primary" href="index.php?do=5">下一步>></a></p>';
?>
</div>
</div>
</div>
<?php }elseif($do=='5'){?>
<div class="col-xs-12">
<div class="panel panel-primary">
<div class="panel-heading text-center">安装完成</div>
<div class="panel-body">
<?php
@file_put_contents("install.lock", 'By陌屿');
echo '<div class="alert alert-success"><font color="green">安装完成！管理账号和密码是:admin/123456</font><br/><br/><a href="https://jq.qq.com/?_wv=1027&k=5iSP8fW">>>网站首页</a>｜<a href="https://jq.qq.com/?_wv=1027&k=5iSP8fW">>>后台管理</a><hr/>更多设置选项请登录后台管理进行修改。<br/><br/><font color="#FF0033">如果你的空间不支持本地文件读写，请自行在install/ 目录建立 install.lock 文件！</font></div>';
?>
</div>
</div>
</div>
<?php }elseif($do=='6'){?>
<div class="col-xs-12">
<div class="panel panel-primary">
<div class="panel-heading text-center">安装完成</div>
<div class="panel-body">
<?php
@file_put_contents("install.lock", 'By陌屿');
echo '<div class="alert alert-success"><font color="green">安装完成！管理账号和密码是:admin/123456</font><br/><br/><a href="https://jq.qq.com/?_wv=1027&k=5iSP8fW">>>网站首页</a>｜<a href="https://jq.qq.com/?_wv=1027&k=5iSP8fW">>>后台管理</a><hr/>更多设置选项请登录后台管理进行修改。<br/><br/><font color="#FF0033">如果你的空间不支持本地文件读写，请自行在install/ 目录建立 install.lock 文件！</font></div>';
?>
</div>
</div>
</div>
<?php }?>
</div>
</div>
</body>
</html>