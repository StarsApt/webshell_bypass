<?php
error_reporting(0);
/*
陌屿<2763994904@qq.com>
陌屿代码加密系统
QQ群：42103442
*/
include("../includes/common.php");
$title='混淆加密';
if($islogins==1){}else exit("<script language='javascript'>window.location.href='../login.php';</script>");
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
<?php
$row=$DB->get_row("SELECT * FROM moyu_daili WHERE user='".$udata['user']."'");
if(isset($_POST['sajm'])){
$price = $conf['hx'];
if($udata['rmb']>=$price){
$extension=explode('.',$_FILES['file']['name']);
if (($length = count($extension)) > 1) {
$jie = strtolower($extension[$length - 1]);
}
if($jie=='php'){
$DB->query("update `moyu_daili` set `rmb`=`rmb`-{$price} where `id`='{$udata['id']}'");
//加密缓存开始
if(($_FILES["file"]["size"]/1024)>$conf['sizekb']){
exit("<script language='javascript'>alert('上传的PHP文件不能超过限制大小！');window.location.href='phpjm.php';</script>");
}
$app = $_SERVER['DOCUMENT_ROOT'].'/Index';
$owner=$udata['id'];
$file=$_FILES['file']['name'];
$time=date("Y-m-d H:i:s");
$space=md5($owner.$file.time());
if (!is_dir($app.'/includes/download/'.$space.'/')) mkdir($app.'/includes/download/'.$space.'/');
$cache=$DB->query("INSERT INTO `moyu_cache` (`owner`, `file`, `space`, `type`, `upload`) VALUES ('{$owner}', '{$file}', '{$space}', '混淆加密', '{$time}')");
copy($_FILES['file']['tmp_name'],$app.'/includes/download/'.$space.'/'.$file.".txt");
if($_POST['url']!=""){file_put_contents(ROOT.'/includes/download/'.$space.'/'.$file.".txt",str_replace('<?php','<?php header("Content-type:text/html;charset=utf-8"); if($_SERVER["HTTP_HOST"]!=\''.$_POST['url'].'\'){echo\''.$_POST['content'].'\';exit();}',file_get_contents(ROOT.'/includes/download/'.$space.'/'.$file.".txt"))); }
$zhushi=daddslashes($_POST['zhushi']);
require_once('./includes/Weidong/encipher.min.php');
$dir1 =  $app.'/includes/download/'.$space.'/';
//加密缓存结束
$encipher = new Encipher($dir1, $dir1);
$encipher->advancedEncryption = true;
$encipher->comments = array(''.$zhushi.'');
echo "<div style='display: none;'>";
$encipher->encode();
echo "</div>";
echo <<<code
    <script type="text/javascript">
    var down = layer.confirm('加密成功点击确定下载？', {
      btn: ['确定','取消'],closeBtn:0,icon:1,
      title:'加密完成'
    }, function(){
      sajmts("$space");
      layer.close(down);
    }, function(){
      layer.msg('您也可以后续在加密记录里面下载哦！',{icon:5});
    });
    </script>
code;
}else{
echo "<script type='text/javascript'>layer.msg('请上传PHP文件！',{icon:5});</script>";
}
}else{
echo "<script type='text/javascript'>layer.msg('您的余额不足无法加密！',{icon:5});</script>";
}
}
?>
<div class="panel panel-default">
<div class="panel-body">
<h2 class="page-header" style="display:none">欢迎使用</h2>
<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief" >
<ul class="layui-tab-title">
<li class="layui-this">在线加密</li>
</ul>
<div class="layui-tab-content"></div>
</div>  
<div class="tab-pane active" id="sajm">
<form action="phpjm.php" method="POST"  enctype="multipart/form-data"  class="form-horizontal layui-form" role="form" >						 
<blockquote class="layui-elem-quote">选择PHP版本不宜过多，请确保代码兼容所选版本。<a rel="nofollow" href="tencent://message/?uin=<?php echo $conf["kfqq"] ?>&amp;Menu=yes" >QQ<?php echo $conf["kfqq"] ?> </a>
<br/><a target="_blank"  style="color:red">( 本站推荐PHP5.6版本 ) </a></blockquote>
<div class="layui-form-item">
<label class="layui-form-label">PHP版本</label>
<div class="layui-input-block">
<input id="ver_5.4" name="vers[]" type="checkbox" class="checkbox" title="5.4" value="5.4" />
<input id="ver_5.5" name="vers[]" type="checkbox" class="checkbox" title="5.5" value="5.5" />
<input id="ver_5.6" name="vers[]" type="checkbox" class="checkbox" title="5.6" value="5.6" checked/>
</div>
</div>
<table class="layui-table layui-form" lay-even="" lay-skin="nob">
<div class="layer-text" style="padding:20px 0 10px;">
<fieldset class="layui-elem-field layui-field-title">
<legend>其他功能</legend>
</fieldset>
</div>
<div class="layui-form-item">
<label class="layui-form-label">版权注释</label>
<div class="layui-input-block">
<input type="text" name="zhushi" class="layui-input" placeholder="如：QQ <?php echo $udata['qq']?>" />
</div>
</div>
<div class="layui-form-item">
<label class="layui-form-label">域名限制</label>
<div class="layui-input-block">
<input type="text" name="url" class="layui-input" placeholder="如：http://<?php echo $_SERVER['HTTP_HOST']?>/" />
</div>
</div> 	
<div class="layui-form-item">
<label class="layui-form-label">限制内容</label>
<div class="layui-input-block">
<input type="text" name="content" class="layui-input" placeholder="域名未绑定，非法调用" />
</div>
</div> 	
<div class="layui-form-item">
<label class="layui-form-label">选择文件</label>
<div class="layui-input-block">
<input type="file" name="file" id="file"/>
</div>
</div>
</div>
<div class="layui-form-item">
<label class="layui-form-label">加密费用</label>
<div class="layui-input-block">
<div class="layui-form-mid layui-word-aux" style="color:#F60 !important;font-family: arial"><?php echo $conf['hx'] ?>金币
</div>
</div>
</div>			
<div class="layui-form-item">
<div class="layui-input-block">
<button class="layui-btn" id="wd" name="sajm" lay-submit lay-filter="formDemo">立即提交</button>
</div>
</div>
</form>
<blockquote class="layui-elem-quote layui-quote-nm">
温馨提醒：混淆加密超强兼容性。
</blockquote>
</div>
</div>
</div>
</div>
</div>
<script>
$(function(){ ReadyDashboard.init(); });
setTimeout("document.getElementById('ts').style.display = 'none';", 2000);
function sajmts(id)
{
window.location.href='../down.php?id='+id;
}
</script>
<script src="../assets/layui/layui.js"></script>
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