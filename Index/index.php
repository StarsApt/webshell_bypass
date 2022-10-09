<?php
error_reporting(0);

include("./includes/common.php");
$title='控制首页';
if($islogins==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php echo $conf["title"] ?> - <?=$title?></title>
  <meta name="description" content="<?php echo $conf['description']?>">
  <meta name="keywords" content="<?php echo $conf['keywords']?>">
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <script src="//lib.baomitu.com/jquery/1.12.4/jquery.min.js"></script>
  <script src="//lib.baomitu.com/layer/2.3/layer.js"></script>
  <script src="//lib.baomitu.com/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="./assets/layuiadmin/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="./assets/layuiadmin/style/admin.css" media="all">
</head>
<body class="layui-layout-body">
  
  <div id="LAY_app">
    <div class="layui-layout layui-layout-admin">
      <div class="layui-header">
        <!-- 头部区域 -->
        <ul class="layui-nav layui-layout-left">
          <li class="layui-nav-item layadmin-flexible" lay-unselect>
            <a href="javascript:;" layadmin-event="flexible" title="侧边伸缩">
              <i class="layui-icon layui-icon-shrink-right" id="LAY_app_flexible"></i>
            </a>
          </li>
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="./" target="_blank" title="前台">
              <i class="layui-icon layui-icon-website"></i>
            </a>
          </li>
          <li class="layui-nav-item" lay-unselect>
            <a href="javascript:;" layadmin-event="refresh" title="刷新">
              <i class="layui-icon layui-icon-refresh-3"></i>
            </a>
          </li>
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <input type="text" placeholder="搜索..." autocomplete="off" class="layui-input layui-input-search" layadmin-event="serach" lay-action="template/search.html?keywords="> 
          </li>
        </ul>
        <ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right">
            </a>
          </li>
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="theme">
              <i class="layui-icon layui-icon-theme"></i>
            </a>
          </li>
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="note">
              <i class="layui-icon layui-icon-note"></i>
            </a>
          </li>
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="fullscreen">
              <i class="layui-icon layui-icon-screen-full"></i>
            </a>
          </li>
          <li class="layui-nav-item" lay-unselect>
            <a href="javascript:;">
              <cite><?php echo $udata['user'];?></cite>
            </a>
            <dl class="layui-nav-child">
              <dd><a lay-href="User/User.php">基本资料</a></dd>
              <hr>
              <a href="" id="logout" style="text-align: center;">退出</a>
            </dl>
          </li>
          
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="about"><i class="layui-icon layui-icon-more-vertical"></i></a>
          </li>
          <li class="layui-nav-item layui-show-xs-inline-block layui-hide-sm" lay-unselect>
            <a href="javascript:;" layadmin-event="more"><i class="layui-icon layui-icon-more-vertical"></i></a>
          </li>
        </ul>
      </div>
      <!-- 侧边菜单 -->
      <div class="layui-side layui-side-menu">
        <div class="layui-side-scroll">
          <div class="layui-logo" lay-href="User/index.php">
            <span><?php echo $conf["title"] ?></span>
          </div>
          
          <ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu" lay-filter="layadmin-system-side-menu">
            <li data-name="user" class="layui-nav-item layui-nav-itemed">
              <a href="javascript:;" lay-tips="主页" lay-direction="2">
                <i class="layui-icon layui-icon-user"></i>
                <cite>主页</cite>
              </a>
              <dl class="layui-nav-child">
                <dd>
                    <dd><a lay-href="User/">首页</a></dd>
                  </dl>
                </dd>
              </dl>
            </li>
            <li data-name="template" class="layui-nav-item">
              <a href="javascript:;" lay-tips="PHP免杀管理" lay-direction="2">
                <i class="layui-icon layui-icon-template"></i>
                <cite>PHP免杀管理</cite>
              </a>
              <dl class="layui-nav-child">
                    <!-- <dd><a lay-href="User/vipjm.php">PHP加密</a></dd>
                    <dd><a lay-href="User/phpjm.php">混淆加密</a></dd> -->
                    <dd><a lay-href="User/enphp.php">免杀方式1</a></dd>
                    <!-- <dd><a lay-href="User/decipher.php">找源码解密</a></dd> -->
              </dl>
            </li>
            <li data-name="template" class="layui-nav-item">
              <a href="javascript:;" lay-tips="JSP免杀管理" lay-direction="2">
                <i class="layui-icon layui-icon-template"></i>
                <cite>JSP免杀管理</cite>
              </a>
              <dl class="layui-nav-child">
                    <!-- <dd><a lay-href="User/vipjm.php">PHP加密</a></dd>
                    <dd><a lay-href="User/phpjm.php">混淆加密</a></dd> -->
                    <dd><a lay-href="User/enjsp.php">免杀方式1</a></dd>
                    <!-- <dd><a lay-href="User/decipher.php">找源码解密</a></dd> -->
              </dl>
            </li>
            <li data-name="template" class="layui-nav-item">
              <a href="javascript:;" lay-tips="APSX免杀管理" lay-direction="2">
                <i class="layui-icon layui-icon-template"></i>
                <cite>APSX免杀管理</cite>
              </a>
              <dl class="layui-nav-child">
                    <!-- <dd><a lay-href="User/vipjm.php">PHP加密</a></dd>
                    <dd><a lay-href="User/phpjm.php">混淆加密</a></dd> -->
                    <dd><a lay-href="User/enaspx.php">免杀方式1</a></dd>
                    <!-- <dd><a lay-href="User/decipher.php">找源码解密</a></dd> -->
              </dl>
            </li>
           <!--  <li data-name="user" class="layui-nav-item">
              <a href="javascript:;" lay-tips="购买管理" lay-direction="2">
                <i class="layui-icon layui-icon-user"></i>
                <cite>购买管理</cite>
              </a>
              <dl class="layui-nav-child">
                <dd>
                  <a lay-href="User/kmlist.php">卡密充值</a>
                </dd>
				<dd>			
                  <a lay-href="User/money.php">在线充值</a>
				</dd>
              </dl>
            </li> -->
            <li data-name="set" class="layui-nav-item">
              <a href="javascript:;" lay-tips="主体信息" lay-direction="2">
                <i class="layui-icon layui-icon-set"></i>
                <cite>主体信息</cite>
              </a>
              <dl class="layui-nav-child">
                    <dd><a lay-href="User/log.php">免杀记录</a></dd>
                    <dd><a lay-href="User/User.php">修改信息</a></dd>
                    <!-- <dd><a lay-href="User/copyright.php">站长主页</a></dd> -->
                    <dd><a lay-href="User/Theauth.php">联系管理</a></dd>
                  </dl>
                </dd>
              </dl>
            </li>
          </ul>
        </div>
      </div>

      <!-- 页面标签 -->
      <div class="layadmin-pagetabs" id="LAY_app_tabs">
        <div class="layui-icon layadmin-tabs-control layui-icon-prev" layadmin-event="leftPage"></div>
        <div class="layui-icon layadmin-tabs-control layui-icon-next" layadmin-event="rightPage"></div>
        <div class="layui-icon layadmin-tabs-control layui-icon-down">
          <ul class="layui-nav layadmin-tabs-select" lay-filter="layadmin-pagetabs-nav">
            <li class="layui-nav-item" lay-unselect>
              <a href="javascript:;"></a>
              <dl class="layui-nav-child layui-anim-fadein">
                <dd layadmin-event="closeThisTabs"><a href="javascript:;">关闭当前标签页</a></dd>
                <dd layadmin-event="closeOtherTabs"><a href="javascript:;">关闭其它标签页</a></dd>
                <dd layadmin-event="closeAllTabs"><a href="javascript:;">关闭全部标签页</a></dd>
              </dl>
            </li>
          </ul>
        </div>
        <div class="layui-tab" lay-unauto lay-allowClose="true" lay-filter="layadmin-layout-tabs">
          <ul class="layui-tab-title" id="LAY_app_tabsheader">
            <li lay-id="User/index.php" lay-attr="User/index.php" class="layui-this"><i class="layui-icon layui-icon-user"></i></li>
          </ul>
        </div>
      </div>
      <!-- 主体内容 -->
      <div class="layui-body" id="LAY_app_body">
        <div class="layadmin-tabsbody-item layui-show">
          <iframe src="User/index.php" frameborder="0" class="layadmin-iframe"></iframe>
        </div>
      </div>
      
      <!-- 辅助元素，一般用于移动设备下遮罩 -->
      <div class="layadmin-body-shade" layadmin-event="shade"></div>
    </div>
  </div>
<script>
$("#logout").click(function(){
	var logout=$("input[name='logout']").val();
	if(!logout){
layer.confirm('主人不要离开我~>_<~！',{
btn:['确定','取消'],closeBtn:0,icon:5},
function(){
window.location.href='/Index/login.php?logout';
}, function(){
  layer.msg('欢迎回来^ω^！', {icon: 6});
});		return false;
	}
});
</script>
<script src="./assets/layuiadmin/layui/layui.js"></script>
<script>
  layui.config({
    base: './assets/layuiadmin/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use('index');
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

