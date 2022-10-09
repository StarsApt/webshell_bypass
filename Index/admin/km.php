<?php
error_reporting(0);
$mod='blank';
include("../includes/common.php");
$title='生成卡密';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
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
<body>
<?php
function randomkeys($length) 
{ 
   $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
    for($i=0;$i<$length;$i++) 
    { 
        $key .= $pattern{mt_rand(0,35)};
    } 
    return $key; 
} 
$kms = randomkeys(10);
?>
<div class="layui-fluid">
<div class="layui-row layui-col-space15">
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header">卡密生成</div>
<div class="layui-card-body" pad15>
<?php
if(isset($_POST['count']) && isset($_POST['money'])){
$count=intval($_POST['count']);
$money=daddslashes($_POST['money']);
$row=$DB->get_row("SELECT * FROM moyu_km WHERE km='{$km}' limit 1");
if($row!='')exit("error");
for ($i=0; $i < $count; $i++) { 
	$kami[$i]=randomkeys(10);
}
foreach ($kami as $value) {
	$sql="insert into `moyu_km` (`km`,`money`,`state`) values ('$value','$money','0')";
	$DB->query($sql);
}
echo "<script type='text/javascript'>layer.alert('添加成功！',{icon:6,closeBtn:0},function(){window.location.href='kmlist.php'});</script>";
} ?>
<form action="./km.php" method="POST">
<div class="layui-form" wid100 lay-filter="">
<div class="layui-form-item">
<label class="layui-form-label">生成数量</label>
<div class="layui-input-block">
<input type="text" name="count" value="<?=@$_POST['count']?>" autocomplete="off"  placeholder="请输入数量" class="layui-input">
</div>
</div>
<div class="layui-form" wid100 lay-filter="">
<div class="layui-form-item">
<label class="layui-form-label">生成金额</label>
<div class="layui-input-block">
<input type="text" name="money" value="<?=@$_POST['money']?>" autocomplete="off"  placeholder="请输入次数" class="layui-input">
</div>
</div>
<div class="layui-form-item">
<div class="layui-input-block">
<button class="layui-btn" type="submit" id="km" lay-submit lay-filter="set_website">确认保存</button>
</div>
</div>
</div>
<script src="../assets/layui/layui.js"></script>