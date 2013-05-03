<?php
define('n', "\r\n");
$page='index.php';
$PHP_SELF=$_SERVER['PHP_SELF'];
require_once('db_config.inc.php');
require_once('fonc.php');
include_once('skins/'.sid.'/header.php');
if( isset($_REQUEST['id']) && is_numeric($_REQUEST['id']) ) {
 $id=$_REQUEST['id'];
}
else {
 /*print('<p>pas de &ccedil;a chez moi !</p>');
 include_once('skins/'.sid.'/footer.php');
 die();*/
}
//echo 'moment 1 - '.memory_get_usage().'\n';
$sql='SELECT p2.`fid`, p2.`titre`, p2.`description`, p1.`uid`, p4.`username`,'.
' p1.`tid`, p1.`time` AS `timestamp`, p3.`sujet`, p2.`nb_topics`, p2.`nb_posts`, p2.`p_fid`'.
' FROM `forums_title` AS p2'.
' LEFT JOIN `forums` AS p1 ON p1.`pid`=p2.`last_pid`'.
' LEFT JOIN `forums_topics` AS p3 ON p1.`tid`=p3.`tid`'.
' LEFT JOIN `users` AS p4 ON p1.`uid`=p4.`uid`'.
' ORDER BY p2.`fid` ASC;';
//' p5.`fid` AS `fid2`, p5.`titre` AS `titre2`'. /* <-- select | from --> */' LEFT JOIN `forums_title` AS p5 On p2.`fid`=p5.`p_fid`'.
//' WHERE p2.`p_fid`='0''.
//$sql2='SELECT `fid`, `titre`, `description`, `nb_topics`, `nb_posts` FROM `forums_title` ORDER BY `fid` ASC;';
//die($sql);
//echo 'moment 2 - '.memory_get_usage().'\n';
$res=send_sql($sql);
//echo 'moment 3 - '.memory_get_usage().'\n';
$num=mysql_num_rows($res);
$posts = Array();
for($i=0;$i<$num;$i++) {
 $ligne=mysql_fetch_array($res, MYSQL_ASSOC);
 $posts[$i]=$ligne;
}
function root_forums($var) {
 return ($var['p_fid']==0);
}
$root_forums=array_filter($posts, 'root_forums');//var_dump($root_forums);die();
function sub_forums($var) {
 global $fid;
 return ($var['p_fid']==$fid);
}
mysql_free_result($res);
//echo 'moment 4 - '.memory_get_usage().'\n';
print('<table class="index_table">'.n);
include_once('skins/'.sid.'/index2_top.php');
//foreach($posts as $post) {
//var_dump($posts);die();
for($i=0;$i<count($root_forums);$i++) {
 $empty=false;
 $post=$root_forums[$i];
 $tid=$post['tid'];
 if(is_null($tid)) $empty=true;
 $fid=$post['fid'];
 $p_fid=$post['p_fid'];
 //$fid2=$post['fid2'];
 //var_dump($fid2);
 $titre=$post['titre'];
 //$titre2=$post['titre2'];
 $description=$post['description'];
 //$moderator=$post['moderator']; // + 'p1.`moderator`, '
 $uid=$post['uid'];
 $username=$post['username'];
 $sujet=$post['sujet'];
 $datetime=$post['timestamp'];
 $date=date('d/m/Y', $datetime);
 $time=date('H:i:s', $datetime);
 $sujet=$post['sujet'];
 $nb_topics=$post['nb_topics'];
 $nb_posts=$post['nb_posts'];
 //echo 'moment 5 - '.memory_get_usage().'\n';
 $sub_forums=array_filter($posts, 'sub_forums');
 //echo 'moment 6 - '.memory_get_usage().'\n';
 //var_dump($sub_forums);
 include('skins/'.sid.'/index2.php');
}
print('</table>');
include_once('skins/'.sid.'/footer.php');
//dump($res);
?>
