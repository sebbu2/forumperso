<?php
define('n', "\r\n");
$page='close.php';
$PHP_SELF=$_SERVER['PHP_SELF'];
require_once('db_config.inc.php');
require_once('fonc.php');
include_once('skins/'.sid.'/header.php');
if( isset($_REQUEST['id']) && is_numeric($_REQUEST['id']) ) {
 $id=$_REQUEST['id'];
}
else {
 print('<p>pas de &ccedil;a chez moi !</p>');
 include_once('skins/'.sid.'/footer.php');
 die();
}
$sql='SELECT p3.`fid`, p3.`tid`, p2.`titre`, p3.`sujet`, p2.`moderator` FROM `forums_title` AS p2, `forums_topics` AS p3'.
' WHERE p3.`fid`=p2.`fid` and p3.`tid`="'.$id.'";';
$res=send_sql($sql);
$num=mysql_num_rows($res);
if($num==0) { print('<p>Pas de ca chez moi !</p>');include_once('skins/'.sid.'/footer.php');die(); }
$ligne=mysql_fetch_array($res, MYSQL_ASSOC);
$fid=$ligne['fid'];
$tid=$ligne['tid'];
$titre=$ligne['titre'];
$forum=$titre;
$sujet=$ligne['sujet'];
$moderator=$ligne['moderator'];
mysql_free_result($res);
$moderateurs=explode(',', $moderator);
if(grade!='administrateur' && grade!='moderateur' && !in_array(login, $moderateurs) ) {
 print('<p>Pas de ca chez moi !</p>');include_once('skins/'.sid.'/footer.php');die();
}
//print('<h1><a href='viewforums.php?id=$fid'>$titre</a> > <a href='viewtopics.php?id=$id'>$sujet</a></h1>');
print('<h2><span class="top"><a href="viewforums.php?id='.$fid.'">'.$forum.'</a> > <a href="viewtopics.php?id='.$id.'">'.$sujet.'</a></span></h2>');
$sql='UPDATE `forums_topics` SET `status`="open" WHERE `tid`="'.$id.'";';
$res=send_sql($sql);
if($res==1) print('<h2>Sujet ouvert.</h2>');
if($res!=1) print('<p>&eacute;chec lors de l\'ouverture du sujet.</p>');

include_once('skins/'.sid.'/footer.php');
?>