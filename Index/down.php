<?php
error_reporting(0);
include("./includes/common.php");
if(isset($_GET["id"])){
$id=daddslashes($_GET["id"]);
$row=$DB->get_row("SELECT * FROM moyu_cache WHERE space='".$id."'");
Header( "Content-type:   application/octet-stream "); 
Header( "Accept-Ranges:   bytes "); 
header( "Content-Disposition:   attachment;   filename=".$row["file"]); 
header( "Expires:   0 "); 
header( "Cache-Control:   must-revalidate,   post-check=0,   pre-check=0 "); 
header( "Pragma:   public ");
$filename = fopen("./includes/download/".$row["space"]."/".$row["file"].".txt", "r") or die("免杀失败，请重试！");
echo fread($filename,filesize("./includes/download/".$row["space"]."/".$row["file"].".txt"));
fclose($filename);
exit();
}
?>