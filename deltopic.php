<?php
define('n', "\r\n");
$page='deltopic.php';
if( isset($_REQUEST['id']) ) {
 $id=$_REQUEST['id'];
}
else {
 $id='';
}
if( isset($_REQUEST['fid']) ) {
 $fid=$_REQUEST['fid'];
}
else {
 $fid='';
}
$PHP_SELF=$_SERVER['PHP_SELF'];
require_once('db_config.inc.php');
require_once('fonc.php');
include_once('skins/'.sid.'/header.php');
if( $id!='' || $fid!='' ) {
 $id=$_REQUEST['id'];
}
else {
 print('<p>pas de &ccedil;a chez moi !</p>');
 include_once('skins/'.sid.'/footer.php');
 die();
}
$sql='SELECT p2.`moderator` FROM `forums_topics` AS p1, `forums_title` AS p2, `forums_topics` AS p3'.
' WHERE p1.`tid`="'.$id.'" AND p2.`fid`=p3.`fid` AND p1.`tid`=p3.`tid`;';
$res5=send_sql($sql);
//$nb_posts=mysql_num_rows($res5);
$num=mysql_num_rows($res5);
if($num==0) { print('<p>pas de &ccedil;a chez moi !</p>');include_once('skins/'.sid.'/footer.php');die(); }
$ligne=mysql_fetch_array($res5);
$moderator=$ligne['moderator'];
$moderateurs=explode(',', $moderator);
mysql_free_result($res5);
if(grade!='administrateur' && grade!='moderateur' && !in_array(login, $moderateurs)) {
 print('<p>pas de &ccedil;a chez moi !</p>');include_once('skins/'.sid.'/footer.php');die();
}
$sql='DELETE FROM `forums` WHERE `tid`="'.$id.'";';
$res1=send_sql($sql);
$sql='DELETE FROM `forums_topics` WHERE `tid`="'.$id.'";';
$res4=send_sql($sql);
$sql='SELECT max(p1.`pid`) AS `pid`, count(p1.`pid`) AS `nb_posts` FROM `forums` AS p1 LEFT JOIN `forums_topics` AS p2 ON p1.`tid`=p2.`tid`'.
' WHERE p2.`fid`="'.$fid.'";';
$res2=send_sql($sql);
$num=mysql_num_rows($res2);
if($num==0) { print('<p>pas de &ccedil;a chez moi !</p>');include_once('skins/'.sid.'/footer.php');die(); }
$ligne=mysql_fetch_array($res2);
$pid=$ligne['pid'];
$nb_posts=$ligne['nb_posts'];
mysql_free_result($res2);
$sql='UPDATE `forums_title` SET `last_pid`="'.$pid.'", `nb_posts`="'.$nb_posts.'", `nb_topics`=`nb_topics`-1 WHERE `fid`="'.$fid.'";';
//print($sql);die();
$res3=send_sql($sql);
//die('$res1 $res2 $res3 $res4');
//die('$res2');
if( $res1=='1' && $res3=='1' && $res4=='1' ) {
 print('<p>Le sujet a bien &eacute;t&eacute; supprim&eacute;.</p>');
}
else {
 print('<p>Echec lors de la suppresion du sujet.</>');
}
include_once('skins/'.sid.'/footer.php');
?>
