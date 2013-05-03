<?php
if(!defined('n')) define("n", "\r\n");
$page="fix_index.php";
$PHP_SELF=$_SERVER['PHP_SELF'];
require_once("db_config.inc.php");
require_once("fonc.php");
include_once("skins/".sid."/header.php");

if( !grade=='administrateur' ) { //&& !grade=='moderateur' ) {
 print("<p>pas de &ccedil;a chez moi !</p>");
 include_once("skins/".sid."/footer.php");
 die();
}
$sql=$sql="( SELECT COUNT(*) AS champ FROM `forums` ) UNION ( SELECT COUNT(*) AS champ FROM `users` ) UNION ( SELECT count(*) AS champ FROM `forums_topics` );";
$res=send_sql($sql);
$num=mysql_num_rows($res);
//die("$num");
if($num==3) {
 $ligne=mysql_fetch_array($res, MYSQL_ASSOC);
 $posts=$ligne['champ'];
 $ligne=mysql_fetch_array($res, MYSQL_ASSOC);
 $membres=$ligne['champ'];
 $ligne=mysql_fetch_array($res, MYSQL_ASSOC);
 $topics=$ligne['champ'];
}
mysql_free_result($res);
for($i=1;$i<=$posts;$i++) {
 $sql="SELECT `pid` FROM `forums` WHERE `tid`='$i';";
 //die($sql);
 $res=send_sql($sql);
 $nb_posts=mysql_num_rows($res);
 $pid=array();
 for($j=0;$j<$nb_posts;$j++) {
  $ligne=mysql_fetch_array($res, MYSQL_ASSOC);
  $pid[$j]=$ligne['pid'];
 }
 $first_pid=array_shift($pid);
 $last_pid=array_pop($pid);
 if($last_pid==NULL) { $last_pid=$first_pid; }
 $sql="UPDATE `forums_topics` SET `posts`='$nb_posts', `first_pid`='$first_pid', `last_pid`='$last_pid' WHERE `tid`='$i';";
 //die($sql);
 $res=send_sql($sql);
}
print('L&#039;index a bien &eacute;t&eacute; fix&eacute;.');

include_once("skins/".sid."/footer.php");
?>
