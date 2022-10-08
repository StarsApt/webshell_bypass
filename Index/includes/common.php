<?php
error_reporting(0);
define("CACHE_FILE", 0);
define("IN_CRONLITE", true);
define("SYSTEM_ROOT", dirname(__FILE__) . "/");
define("ROOT", dirname(SYSTEM_ROOT) . "/");
date_default_timezone_set("PRC");
define("SYS_KEY", "moyu_key");
define("CC_Defender", 1);
$date = date("Y-m-d H:i:s");
if (is_file(SYSTEM_ROOT . '360safe/360webscan.php')) {
    require_once(SYSTEM_ROOT . '360safe/360webscan.php');
}
session_start();
$scriptpath = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
$sitepath = substr($scriptpath, 0, strrpos($scriptpath, '/'));
$siteurl = ($_SERVER['SERVER_PORT']==443 ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $sitepath . '/';
require(ROOT."config.php");
require(SYSTEM_ROOT."version.php");

if (!defined("SQLITE") && (!$dbconfig["user"] || !$dbconfig["pwd"] || !$dbconfig["dbname"])) {
	header("Content-type:text/html;charset=utf-8");
	echo "你还没安装！<a href=\"/Index/install/\">点此安装</a>";
	exit(0);
}

include_once(SYSTEM_ROOT."db.class.php");
$DB = new DB($dbconfig['host'], $dbconfig['user'], $dbconfig['pwd'], $dbconfig['dbname'], $dbconfig['port']);
if ($DB->query('select * from moyu_config where 1')==false) {
    header('Content-type:text/html;charset=utf-8');
    echo '你还没安装！<a href="/Index/install/">点此安装</a>';
    exit(0);
}

include(SYSTEM_ROOT."cache.class.php");
$CACHE = new CACHE();
$conf = unserialize($CACHE->pre_fetch());//获取系统配置

if (empty($conf['version'])) {
    $conf = $CACHE->update();
}

if (($conf['qqjump']==1 && (!strpos($_SERVER['HTTP_USER_AGENT'],'QQ/')===false || !strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')===false))) {if ($_GET['open']==1 && !strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')===false) {
header('Content-Disposition: attachment; filename="load.doc"');
header('Content-Type: application/vnd.ms-word;charset=utf-8');
}
 else {
	 header('Content-type:text/html;charset=utf-8');
}
include_once(SYSTEM_ROOT."jump.php");
exit(0);
}

$row=$DB->get_row("SELECT * FROM moyu_daili WHERE user='".$udata['user']."'");

$password_hash='!@#%!s!';
include_once(SYSTEM_ROOT.'authcode.php');
define('authcode',$authcode);
include SYSTEM_ROOT."SecretUtilTools.php";
include SYSTEM_ROOT."function.php";
include SYSTEM_ROOT."member.php";

if(!file_exists(ROOT."install/install.lock") && file_exists(ROOT."install/index.php")) {
	sysmsg("<h3>检测到无 install.lock 文件</h3></br><h3>点击重新安装<a href=\"./install/\"> (重新安装) </a><h3>", true);
}
?>