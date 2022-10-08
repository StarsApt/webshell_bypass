<?php
/**
 * 检查版本更新
**/
include("../includes/common.php");
$title='检查版本更新';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");

//函数
function zipExtract ($src, $dest)
{
$zip = new ZipArchive();
if ($zip->open($src)===true)
{
$zip->extractTo($dest);
$zip->close();
return true;
}
return false;
}
function delMoeft($dir) {
  if(!is_dir($dir))return false;
  $dh=opendir($dir);
  while ($file=readdir($dh)) {
    if($file!="." && $file!="..") {
      $fullpath=$dir."/".$file;
      if(!is_dir($fullpath)) {
          unlink($fullpath);
      } else {
          deldir($fullpath);
      }
    }
  }
  closedir($dh);
  if(rmdir($dir)) {
    return true;
  } else {
    return false;
  }
}

$scriptpath=str_replace('\\','/',$_SERVER['SCRIPT_NAME']);
$scriptpath = substr($scriptpath, 0, strrpos($scriptpath, '/'));
$admin_path = substr($scriptpath, strrpos($scriptpath, '/')+1);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?=$title?></title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="../assets/layuiadmin/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="../assets/layuiadmin/style/admin.css" media="all">
</head>
<div class="layui-fluid" id="LAY-component-timeline">
<div class="layui-row layui-col-space15">
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header"><?=$title?></div>
<div class="layui-card-body">
<?php 
$act = isset($_GET['act']) ? $_GET['act'] : null;
switch ($act) {
default:

$res=update_version();

if(!$res['msg'])$res['msg']='啊哦，更新服务器开小差了，请刷新此页面。';


echo '<div class="alert alert-info">'.$res['msg'].'</div>';
echo '<hr/>';

if($res['code']==1) {
if(!class_exists('ZipArchive') || defined("SAE_ACCESSKEY") || defined("BAE_ENV_APPID")) {
echo '您的空间不支持自动更新，请手动下载更新包并覆盖到程序根目录！<br/>
更新包下载：<a href="'.$res['file'].'" class="btn btn-primary">点击下载</a>';
} else {
echo '<a href="update.php?act=do"class="layui-btn layui-btn-radius">立即更新到最新版本</a>';
}

echo ''.$res['uplog'].'             
';
}
break;

case 'do':
$res=update_version();
$RemoteFile = $res['file'];
$ZipFile = "Archive.zip";
copy($RemoteFile,$ZipFile) or die("无法下载更新包文件！".'<a href="update.php">返回上级</a>');
if (zipExtract($ZipFile,ROOT)) {
if($admin_path!='admin'){ //修改后台地址
	delMoeft(ROOT.$admin_path);
	rename(ROOT.'admin',ROOT.$admin_path);
}
if(function_exists("opcache_reset"))@opcache_reset();
if(!empty($res['sql'])){
	$sql=$res['sql'];
	$t=0; $e=0; $error='';
	for($i=0;$i<count($sql);$i++) {
		if (trim($sql[$i])=='')continue;
		if($DB->query($sql[$i])) {
			++$t;
		} else {
			++$e;
			$error.=$DB->error().'<br/>';
		}
	}
	$addstr='<br/>数据库更新成功。SQL成功'.$t.'句/失败'.$e.'句';
}
echo "程序更新成功！".$addstr."<br>";
echo '<a href="update.php">返回上级</a>';
unlink($ZipFile);
}
else {
echo "无法解压文件！<br>";
echo '<a href="update.php">返回上级</a>';
if (file_exists($ZipFile))
unlink($ZipFile);
}
break;
}
echo '</div></div>';
?>
    </div>
  </div>