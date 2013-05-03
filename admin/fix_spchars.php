<?php
if(!defined('n')) define("n", "\r\n");
$page="fix_forums.php";
$PHP_SELF=$_SERVER['PHP_SELF'];
require_once("db_config.inc.php");
require_once("fonc.php");
include_once("skins/".sid."/header.php");

if( !grade=='administrateur' ) { //&& !grade=='moderateur' ) {
 print("<p>pas de &ccedil;a chez moi !</p>");
 include_once("skins/".sid."/footer.php");
 die();
}
$sql=$sql="( SELECT COUNT(*) AS champ FROM `forums` ) UNION ( SELECT COUNT(*) AS champ FROM `users` ) UNION ( SELECT count(*) AS champ FROM `forums_topics` ) UNION ( SELECT COUNT(*) AS champ FROM `forums_title` );";
$res=send_sql($sql);
$num=mysql_num_rows($res);
//die("$num");
if($num==4) {
 $ligne=mysql_fetch_array($res, MYSQL_ASSOC);
 $posts=$ligne['champ'];
 $ligne=mysql_fetch_array($res, MYSQL_ASSOC);
 $membres=$ligne['champ'];
 $ligne=mysql_fetch_array($res, MYSQL_ASSOC);
 $topics=$ligne['champ'];
 $ligne=mysql_fetch_array($res, MYSQL_ASSOC);
 $forums=$ligne['champ'];
 mysql_free_result($res);
}

for($i=1;$i<=$posts;$i++) {
 $sql='SELECT `message` FROM `forums` WHERE `pid`=\''.$i.'\';';
 $res=send_sql($sql);
 $ligne=mysql_fetch_array($res, MYSQL_ASSOC);
 $message=$ligne['message'];
 $message=changer_specials_chars($message,4);
 mysql_free_result($res);
 $sql='UPDATE `forums` SET `message`=\''.$message.'\' WHERE `pid`=\''.$i.'\';';
 //die($sql);
 $res=send_sql($sql);
}

print('Les accents des messages a bien &eacute;t&eacute; fix&eacute;.');

include_once("skins/".sid."/footer.php");
?>
