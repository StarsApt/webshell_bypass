<?php
error_reporting(0);
include("../includes/common.php");
@header('Content-Type: text/html; charset=UTF-8');
if($islogins==1){}else exit("<script language='javascript'>window.location.href='../login.php';</script>");
$row=$DB->get_row("SELECT * FROM moyu_daili WHERE user='".$udata['user']."'");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>代理系统</title>
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
  <div class="layui-fluid" id="LAY-component-timeline">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header">个人信息</div>
          <div class="layui-card-body">
            <table class="layui-table">
              <colgroup>
                <col width="100">
                <col>
              </colgroup>
              <tbody>
                <tr>
                  <td>您的剩余次数</td>
                  <td>
                    <script type="text/html" template>
                     <?php echo $udata['rmb']?> 次
                    </script>
                 </td>
                </tr>
                <!-- <tr>
                  <td>您的 Q Q</td>
                  <td>
                      <a href="http://q4.qlogo.cn/headimg_dl?dst_uin=<?php echo $udata['qq']?>&spec=100" style="padding-left: 0px;"><?php echo $udata['qq']?></a>
                  </td>
                </tr> -->
                <tr>
                  <td>限制文件大小</td>
                  <td>
                      <?php echo $conf['sizekb']?> KB
                  </td>
                </tr>
                <tr>
                  <td>本站特色功能</td>
                  <td>高效稳定 / 安全保证  / 容易上手</td>
                </tr>
                <tr>
              </tbody>
            </table>
          </div>
          </div>
        <!-- <div class="layui-card">
          <div class="layui-card-header">官方信息</div>
          <div class="layui-card-body">
            <div class="layui-carousel layadmin-carousel layadmin-news" data-autoplay="true" data-anim="fade" lay-filter="news">
              <div carousel-item>
                <div><a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $conf['kfqq']?>&site=qq&menu=yes" target="_blank" class="layui-bg-red">联系网站客服</a></div>
                <div><a href="<?php echo $conf['qunhao']?>" target="_blank" class="layui-bg-green">加入官方交流群</a></div>
              </div>
            </div>
          </div>
        </div> -->       
        <div class="layui-card">
            <div class="layui-card-header">网站公告</div>
            <div class="layui-card-body">  
	            <ul class="layui-timeline">
		        	  <li class="layui-timeline-item">
                <i class="layui-icon layui-timeline-axis"></i>
                <div class="layui-timeline-content layui-text">
				<div class="layui-timeline-title">欢迎您的使用</div>
          		  <?php echo $conf['GongGao']; ?>
              <li class="layui-timeline-item">
                <i class="layui-icon layui-timeline-axis"></i>
                <div class="layui-timeline-content layui-text">
                  <div class="layui-timeline-title"><?php echo $conf["title"] ?></div>
          </div>
     </li>
</ul> 
<script src="../assets/layuiadmin/layui/layui.js"></script>  
<script>
layui.config({
base: '../assets/layuiadmin/' //静态资源所在路径
}).extend({
index: 'lib/index' //主入口模块
}).use(['index', 'sample']);
</script>  
  <!-- 百度统计 -->
  <script>
  var _hmt = _hmt || [];
  (function() {
    var hm = document.createElement("script");
    hm.src = "https://hm.baidu.com/hm.js?d214947968792b839fd669a4decaaffc";
    var s = document.getElementsByTagName("script")[0]; 
    s.parentNode.insertBefore(hm, s);
  })();
  </script>
</body>
</html>

