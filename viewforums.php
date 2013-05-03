<?php
define('n', "\r\n");
$page='viewforums.php';
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
$sql1='SELECT p2.`fid`, p2.`titre`, p2.`description`, p1.`uid`, p4.`username`,'.
' p1.`tid`, p1.`time` AS `timestamp`, p3.`sujet`, p2.`nb_topics`, p2.`nb_posts`, p2.`p_fid`'.
' FROM `forums_title` AS p2'.
' LEFT JOIN `forums` AS p1 ON p1.`pid`=p2.`last_pid`'.
' LEFT JOIN `forums_topics` AS p3 ON p1.`tid`=p3.`tid`'.
' LEFT JOIN `users` AS p4 ON p1.`uid`=p4.`uid`'.
' ORDER BY p2.`fid` ASC;';
$res1=send_sql($sql1);
$num1=mysql_num_rows($res1);
$posts1 = Array();
$list_fid=Array();$list_p_fid=Array();$list_titre=Array();
$fid=$id;
for($i=0;$i<$num1;$i++) {
 $ligne=mysql_fetch_array($res1, MYSQL_ASSOC);
 $posts1[$i]=$ligne;
 $list_fid[$i]=$ligne['fid'];$list_p_fid[$i]=$ligne['p_fid'];$list_titre[$i]=$ligne['titre'];
}
//var_dump($list_fid);die();
function sub_forums($var) {
 global $fid;
 return ($var['p_fid']==$fid);
}
$sub_forums1=array_filter($posts1, 'sub_forums');//var_dump($sub_forums);die();
$sql='SELECT p2.`titre`, p2.`description`, p2.`moderator`, p2.`nb_topics`, p2.`nb_posts`,'.
' p2.`p_fid`,'.// p7.`titre` AS `titre2`, p7.`p_fid` AS `p_fid2`, p8.`titre` AS `titre3`, p8.`p_fid` AS `p_fid3`,'.
' p3.`sujet`, p1.`tid`, p4.`uid`, p4.`username` , p3.`status`, p1.`time` AS `timestamp`, p3.`posts`, p6.`uid` AS `luid`, p6.`username` AS `lusername`,'.
' p5.`time` AS `ltimestamp`'.
' FROM `forums_title` AS p2'.
' LEFT JOIN `forums_topics` AS p3 ON p2.`fid`=p3.`fid`'.//' LEFT JOIN `forums_topics` AS p3 ON ( p1.`tid`=p3.`tid` AND p1.`fid`=p3.`fid` )'.
' LEFT JOIN `forums` AS p1 ON ( p1.`status` <> "R%" AND p1.`status` <> "R" AND p1.`tid`=p3.`tid` )'.
' LEFT JOIN `users` AS p4 ON p1.`uid`=p4.`uid`'.
' LEFT JOIN `forums` AS p5 ON p3.`last_pid`=p5.`pid`'.
' LEFT JOIN `users` AS p6 ON p5.`uid`=p6.`uid`'.
//' LEFT JOIN `forums_title` AS p7 ON p2.`p_fid`=p7.`fid`'.
//' LEFT JOIN `forums_title` AS p8 ON p7.`p_fid`=p8.`fid`'.
' WHERE p2.`fid`="'.$id.'"'.
' ORDER BY p3.`last_pid` DESC;';
//var_dump($sql);
//die($sql);
$res=send_sql($sql);
$num=mysql_num_rows($res);
//var_dump($num);die();
//tab_out($res);
$posts = Array();
//$list_fid=Array();$list_p_fid=Array();$list_titre=Array();$list_fid[$i]=$ligne['fid'];$list_p_fid[$i]=$ligne['p_fid'];$list_titre[$i]=$ligne['titre'];
for($i=0;$i<$num;$i++) {
 $ligne=mysql_fetch_array($res, MYSQL_ASSOC);
 $posts[$i]=$ligne;
}
//var_dump($posts);die();
mysql_free_result($res);
//print('<pre>');print_r($posts);print('</pre>');//die();
if($num!=0) {
 $forum=$posts['0']['titre'];
 //$forum2=$posts['0']['titre2'];
 //$forum3=$posts['0']['titre3'];
 $description=$posts['0']['description'];
 $p_fid1=$posts['0']['p_fid'];
 //$p_fid2=$posts['0']['p_fid2'];
 //$p_fid3=$posts['0']['p_fid3'];
 print('<table class="index_table_top">'.n);
 print(' <tr>'.n);
 print('  <td class="titre">');
 $p_fid_t=$p_fid1;
 $forums_list=Array();
 while($p_fid_t>0) {
  $test=array_search($p_fid_t,$list_fid);
  if($test===FALSE) {
   die('bug sur le forum');
  }
  else {
   $p_fid_t=$list_p_fid[$test];
   $forums_list[]='<a href="viewforums.php?id="'.$list_fid[$test].'">'.$list_titre[$test].'</a> > ';
  }
 }
 $forums_list=array_reverse($forums_list);
 foreach($forums_list as $k=>$v) {
  print($v);
 }
 print('<a href="viewforums.php?id='.$id.'">'.$forum.'</a></td>'.n);
 print('  <td class="desc">'.$description.'</td>'.n);
 print(' </tr>'.n);
 print('</table><br/>'.n);
}
else {
 print('pas de &ccedil;a chez moi!');include_once('skins/'.sid.'/footer.php');die();
}

if(count($sub_forums1)>0 ) {
 print('<table class="index_table">'.n);
 include_once('skins/'.sid.'/index2_top.php');
 foreach($sub_forums1 as $k=>$v) {
  $empty=false;
  $post=$v;
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
  $sub_forums=array_filter($posts1, 'sub_forums');
  //echo 'moment 6 - '.memory_get_usage().'\n';
  //var_dump($sub_forums);die();
  include('skins/'.sid.'/index2.php');
 }
 print('</table><br/>'.n);
}

print('<table class="index_table">'.n);
foreach($posts as $post) {
 //print_r($post);
 $tid=$post['tid'];
 if(is_null($tid)) { break; }
 $sujet=$post['sujet'];
 $username=$post['username'];
 $uid=$post['uid'];
 $datetime=$post['timestamp'];
 $date=date('d/m/Y', $datetime);
 $time=date('H:i:s', $datetime);
 $ldatetime=$post['ltimestamp'];
 $ldate=date('d/m/Y', $ldatetime);
 $ltime=date('H:i:s', $ldatetime);
 $status=$post['status'];
 $luid=$post['luid'];
 $lusername=$post['lusername'];
 $post=$post['posts']-1;
 print(' <tr>'.n);
 print('  <td class="icon"><img height="20" width="20" src="skins/'.$sid.'/images/'.$status.'.png" alt=""/></td>'.n);
 print('  <td class="sujet"><a href="viewtopics.php?id='.$tid.'">'.$sujet.'</a> ['.$post.'&nbsp;r&eacute;ponses]');
 if(grade=='administrateur') print(' [<a href="deltopic.php?fid='.$id.'&amp;id='.$tid.'">supprimer</a>]');
 print('</td>'.n);
 print('  <td class="user">auteur : <a href="membres.php?id='.$uid.'">'.$username.'</a><br/>dernier post : <a href="membres.php?id='.$luid.'">'.
 $lusername.'</a></td>'.n);
 print('  <td class="datetime">'.$ldate.' &agrave; '.$ltime.'</td>'.n);
 print(' </tr>'.n);
}
if( isset($posts) && count($posts)==1 && is_null($posts[0]['tid']) ) {
 print(' <tr>'.n);
 print('  <td class="index_table_bottom">Aucun message dans ce forum.</td>'.n);
 print(' </tr>'.n);
}
//print('<pre>'.n);print_r($posts);print('</pre>'.n);//die();
print('</table><br/>'.n);

print('<table class="index_table_bottom">'.n);
print(' <tr>'.n);
print('  <td class="reply"><a href="newtopic.php?id='.$id.'">Nouveau sujet</a></td>');
print(' </tr>'.n);
print('</table>'.n);

include_once('skins/'.sid.'/footer.php');
?>
