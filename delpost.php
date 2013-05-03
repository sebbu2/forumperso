<?php
define('n', "\r\n");
$page='delpost.php';
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
//die('en cour.');
$sql='SELECT p1.`status`, p1.`tid`, p2.`fid`, p2.`moderator`'.
' FROM `forums` AS p1, `forums_title` AS p2, `forums_topics` AS p3 WHERE p1.`pid`="'.$id.'" AND p1.`tid`=p3.`tid` AND p2.`fid`=p3.`fid`;';
$res=send_sql($sql);
$num=mysql_num_rows($res);
if($num==0) { print('<p>pas de &ccedil;a chez moi !</p>');include_once('skins/'.sid.'/footer.php');die(); }
$ligne=mysql_fetch_array($res, MYSQL_ASSOC);
$status=$ligne['status'];
$tid=$ligne['tid'];
$fid=$ligne['fid'];
$moderator=$ligne['moderator'];
mysql_free_result($res);
$moderateurs=explode(',', $moderator);
if(grade!='administrateur' && grade!='moderateur' && !in_array(login, $moderateurs)) {
 print('<p>pas de &ccedil;a chez moi !</p>');include_once('skins/'.sid.'/footer.php');die();
}
//die($status);
if( $status!='R' or (substr($status, 0, 2)!='R:'&&strlen($status)>=2) ) {
 print('<p>pas possible de supprimer le 1° post d\'un sujet.</p>');
 include_once('skins/'.sid.'/footer.php');die();
}

$sql='DELETE FROM `forums` WHERE `pid`="'.$id.'";';
//print($sql.n);
$res1=send_sql($sql);
$sql='SELECT max(`pid`) AS `pid` FROM `forums` AS p1 LEFT JOIN `forums_topics` AS p3 ON p1.`tid`=p3.`tid` WHERE `fid`="'.$fid.'";';
$res=send_sql($sql);
$num=mysql_num_rows($res);
if($num==0) { print('<p>pas de &ccedil;a chez moi !</p>');include_once('skins/'.sid.'/footer.php');die(); }
$ligne=mysql_fetch_array($res, MYSQL_ASSOC);
$pid=$ligne['pid'];
mysql_free_result($res);
$sql='UPDATE `forums_title` SET `last_pid`="'.$pid.'", `nb_posts`=`nb_posts`-1 WHERE `fid`="'.$fid.'";';
//print($sql.n);
$res2=send_sql($sql);
$sql='SELECT max(`pid`) AS `pid` FROM `forums` WHERE `tid`="'.$tid.'";';
$res=send_sql($sql);
$ligne=mysql_fetch_array($res, MYSQL_ASSOC);
$pid=$ligne['pid'];
mysql_free_result($res);
//, `post`=`post`-1
$sql='UPDATE `forums_topics` SET `last_pid`="'.$pid.'", `posts`=`posts`-1 WHERE `fid`="'.$fid.'" AND `tid`="'.$tid.'";';
//print($sql.n);
$res3=send_sql($sql);
//die('$res1 $res2 $res3 $res4');
//die('$res2');
if($res1=='1'&&$res2=='1'&&$res3=='1') {
 print('<p>Le message a bien &eacute;t&eacute; supprim&eacute;.</p>');
}
else {
 print('<p>Echec lors de la suppresion du message.</>');
}
include_once('skins/'.sid.'/footer.php');
?>
