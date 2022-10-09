<?php
error_reporting(0);
/**
 * 代理管理
**/
include("../includes/common.php");
$title='用户管理';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title><?php echo $conf["title"] ?> - <?=$title?></title>
<meta name="description" content="<?php echo $conf['description']?>">
<meta name="keywords" content="<?php echo $conf['keywords']?>">
<link href="//cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.css" rel="stylesheet">
<script src="//lib.baomitu.com/jquery/1.12.4/jquery.min.js"></script>
<script src="//lib.baomitu.com/layer/2.3/layer.js"></script>
<script src="//lib.baomitu.com/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!--[if lt IE 9]>
<script src="http://libs.useso.com/js/html5shiv/3.7/html5shiv.min.js"></script>
<script src="http://libs.useso.com/js/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<div class="container" style="padding-top:30px;">
<div class="col-sm-12 col-md-10 center-block" style="float: none;">
<div class="modal fade" align="left" id="search" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
<h4 class="modal-title" id="myModalLabel">搜索用户</h4>
</div>
<div class="modal-body">
<form action="ulist.php" method="GET">
<input type="text" class="form-control" name="kw" placeholder="请输入用户名或QQ"><br/>
<input type="submit" class="btn btn-primary btn-block" value="搜索"></form>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>
<div class="modal fade" id="modal-rmb">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">生成次数修改</h4>
			</div>
			<div class="modal-body">
				<form id="form-rmb">
					<input type="hidden" name="id" value="">
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon p-0">
								<select name="do"
										style="-webkit-border-radius: 0;height:20px;border: 0;outline: none !important;border-radius: 5px 0 0 5px;padding: 0 5px 0 5px;">
									<option value="0">增加</option>
									<option value="1">扣除</option>
								</select>
							</span>
							<input type="number" class="form-control" name="rmb" placeholder="输入金额">
							<span class="input-group-addon">次</span>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-info" data-dismiss="modal">取消</button>
				<button type="button" class="btn btn-primary" id="recharge">确定</button>
			</div>
		</div>
	</div>
</div>
<?php
$my=isset($_GET['my'])?$_GET['my']:null;

if($my=='add')
{
echo '<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">添加用户</h3></div>';
echo '<div class="panel-body">';
echo '<form action="./ulist.php?my=add_submit" method="POST">
<div class="input-group">
<span class="input-group-addon">用户账号</span>
<input type="text" class="form-control" name="user" value="" required>
</div><br/>

<div class="input-group">
<span class="input-group-addon">用户密码</span>
<input type="text" class="form-control" name="pwd" value="" required>
</div><br/>

<div class="input-group">
<span class="input-group-addon">联系ＱＱ</span>
<input type="text" class="form-control" name="qq" value=""　required>
</div><br/>

<div class="input-group">
<span class="input-group-addon">用户状态</span>
<select name="active" class="form-control"><option value="1">开启</option><option value="0">关闭</option></select>
</div><br/>

<input type="submit" class="btn btn-primary btn-block" value="确定添加"></form>';
echo '<br/><a href="./ulist.php">>>返回用户列表</a>';
echo '</div></div>';
}
elseif($my=='edit')
{
$id=intval($_GET['id']);
$row=$DB->get_row("select * from moyu_daili where id='$id' limit 1");
echo '<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">修改代理用户信息</h3></div>';
echo '<div class="panel-body">';
echo '<form action="./ulist.php?my=edit_submit&id='.$id.'" method="POST">
<div class="input-group">
<span class="input-group-addon">用户账号</span>
<input type="text" class="form-control" name="user" value="'.htmlentities($row['user']).'" required>
</div><br/>

<div class="input-group">
<span class="input-group-addon">用户密码</span>
<input type="text" class="form-control" name="pwd" value="'.htmlentities($row['pass']).'" required>
</div><br/>

<div class="input-group">
<span class="input-group-addon">联系ＱＱ</span>
<input type="text" class="form-control" name="qq" value="'.$row['qq'].'">
</div><br/>

<div class="input-group">
<span class="input-group-addon">常用登陆</span>
<input type="text" class="form-control" name="citylist" value="'.$row['citylist'].'" placeholder="多个登录地用,隔开">
</div><br/>

<div class="input-group">
<span class="input-group-addon">用户状态</span>
<select name="active" class="form-control">';
if(($row['active'])=="1"){
echo'<option value="1">激活</option><option value="0">封禁</option>';}
elseif(($row['active'])=="0"){
echo'<option value="0">封禁</option><option value="1">激活</option>';} 
echo'</select>
</div><br/>

<input type="submit" class="btn btn-primary btn-block" value="确定修改"></form>';
echo '<br/><a href="./ulist.php">>>返回代理列表</a>';
echo '</div></div>';
}
elseif($my=='add_submit')
{
$user=$_POST['user'];
$pwd=$_POST['pwd'];
$qq=$_POST['qq'];
$active=$_POST['active'];
if($user==NULL or $pwd==NULL or $active==NULL){
showmsg('保存错误,请确保每项都不为空!',3);
} else {
$rows=$DB->get_row("select * from auth_daili where user='$user' limit 1");
if($rows)
	showmsg('用户名已存在！',3);

$sql="insert into `moyu_daili` (`user`,`pass`,`qq`,`active`) values ('".$user."','".$pwd."','".$qq."','".$active."')";
if($DB->query($sql)){
echo "<script type='text/javascript'>layer.alert('添加用户成功！',{icon:6,closeBtn:0},function(){window.location.href='./ulist.php'});</script>";
}else
echo "<script type='text/javascript'>layer.alert('添加用户失败！',{icon:5,closeBtn:0},function(){window.location.href='./ulist.php'});</script>";
}
}
elseif($my=='edit_submit')
{
$id=intval($_GET['id']);
$rows=$DB->get_row("select * from moyu_daili where id='$id' limit 1");
if(!$rows)
showmsg('当前记录不存在！',3);
$user=$_POST['user'];
$pwd=$_POST['pwd'];
$qq=$_POST['qq'];
$active=$_POST['active'];

if($active=="0"){
	$active=0;
}else if($active=="1"){
	$active=1;
}
if($user==NULL or $pwd==NULL or $active==NULL){
showmsg('保存错误,请确保每项都不为空!',3);
} else {
if($DB->query("update moyu_daili set user='$user',pass='$pwd',qq='$qq',citylist='$citylist',active='$active' where id='{$id}'"))
echo "<script type='text/javascript'>layer.alert('修改用户成功！',{icon:6,closeBtn:0},function(){window.location.href='./ulist.php'});</script>";
else
echo "<script type='text/javascript'>layer.alert('修改用户失败！',{icon:5,closeBtn:0},function(){window.location.href='./ulist.php'});</script>";
}
}
elseif($my=='delete')
{
$id=intval($_GET['id']);

$sql="alter table `moyu_daili` AUTO_INCREMENT=1";
$DB->query("DELETE FROM moyu_daili WHERE id='$id'");
if($DB->query($sql))
showmsg('删除成功！<br/><br/><a href="./ulist.php">>>返回代理列表</a>',1);
else
showmsg('删除失败！'.$DB->error(),4);
}
else
{

$numrows=$DB->count("SELECT count(*) from moyu_daili");
if(isset($_GET['id'])){
$sql = " id={$_GET['id']}";
}elseif(isset($_GET['kw'])){
$sql = " user='{$_GET['kw']}' or qq='{$_GET['kw']}'";
}else{
$sql = " 1";
}
$con='系统共有 <b>'.$numrows.'</b> 个代理用户<br/><a href="./ulist.php?my=add" class="btn btn-primary">添加用户</a>&nbsp;<a href="#" data-toggle="modal" data-target="#search" id="search" class="btn btn-success">搜索</a>';

echo '<div class="alert alert-info">';
echo $con;
echo '</div>';

?>
<div class="table-responsive">
<table class="table table-striped">
<thead><tr><th>id</th><th>用户名</th><th>QQ</th><th>上次登录</th><th>剩余次数</th><th>状态</th><th>操作</th></tr></thead>
<tbody>
<?php
$pagesize=30;
$pages=intval($numrows/$pagesize);
if ($numrows%$pagesize)
{
 $pages++;
 }
if (isset($_GET['page'])){
$page=intval($_GET['page']);
}
else{
$page=1;
}
$offset=$pagesize*($page - 1);

$rs=$DB->query("SELECT * FROM moyu_daili WHERE{$sql} order by id desc limit $offset,$pagesize");
while($res = $DB->fetch($rs))
{
if($res['active']==0){$q="封禁";}elseif($res['active']==1){$q="正常";}
echo '<tr><td><b>'.$res['id'].'</b></td><td>'.htmlentities($res['user']).'</td><td><a href="tencent://message/?uin='.$res['qq'].'&amp;Site=qq&amp;Menu=yes">'.$res['qq'].'</a></td><td>'.$res['last'].'</td><td>'.$res['rmb'].'</td><td>'.$q.'</td><td><a href="./ulist.php?my=edit&id='.$res['id'].'" class="btn btn-info btn-xs">编辑</a>&nbsp;<a href="javascript:showRecharge('.$res['id'].')"class="btn btn-success btn-xs">授权修改</a>&nbsp;</a>&nbsp;<a href="./ulist.php?my=delete&id='.$res['id'].'" class="btn btn-xs btn-danger" onclick="return confirm(\'你确实要删除此代理用户吗？\');">删除</a></td></tr>';
}
?>
</tbody>
</table>
</div>
<center>
<?php
echo'<ul class="pagination">';
$first=1;
$prev=$page-1;
$next=$page+1;
$last=$pages;
if ($page>1)
{
echo '<li><a href="ulist.php?page='.$first.$link.'">首页</a></li>';
echo '<li><a href="ulist.php?page='.$prev.$link.'">&laquo;</a></li>';
} else {
echo '<li class="disabled"><a>首页</a></li>';
echo '<li class="disabled"><a>&laquo;</a></li>';
}
for ($i=1;$i<$page;$i++)
echo '<li><a href="ulist.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="disabled"><a>'.$page.'</a></li>';
if($pages>=10)$pages=10;
for ($i=$page+1;$i<=$pages;$i++)
echo '<li><a href="ulist.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$pages)
{
echo '<li><a href="ulist.php?page='.$next.$link.'">&raquo;</a></li>';
echo '<li><a href="ulist.php?page='.$last.$link.'">尾页</a></li>';
} else {
echo '<li class="disabled"><a>&raquo;</a></li>';
echo '<li class="disabled"><a>尾页</a></li>';
}
echo'</ul>';
#分页
}
?>
    </div>
  </div>
  <script src="//cdn.staticfile.org/layer/2.3/layer.js"></script>
<script>
function showRecharge(id) {
	$("input[name='id']").val(id);
	$('#modal-rmb').modal('show');
}
$(document).ready(function(){
	$("#recharge").click(function(){
		var id=$("input[name='id']").val();
		var actdo=$("select[name='do']").val();
		var rmb=$("input[name='rmb']").val();
		if(rmb==''){layer.alert('请输入金额');return false;}
		var ii = layer.load(2, {shade:[0.1,'#fff']});
		$.ajax({
			type : "POST",
			url : "ajax.php?act=siteRecharge",
			data : {id:id,actdo:actdo,rmb:rmb},
			dataType : 'json',
			success : function(data) {
				layer.close(ii);
				if(data.code == 0){
					layer.msg('修改授权成功');
					$('#modal-rmb').modal('hide');
					listTable();
				}else{
					layer.alert(data.msg);
				}
			},
			error:function(data){
				layer.msg('服务器错误');
				return false;
			}
		});
	});
	$("#search_submit").click(function(){
		var kw=$("input[name='kw']").val();
		$("#search").modal('hide');
		if(kw == ''){
			listTable('start');
		}else{
			listTable('kw='+kw);
		}
	});
});
$(document).ready(function(){
	listTable();
})
</script>