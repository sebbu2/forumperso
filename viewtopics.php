<?php
define('n', "\r\n");
$page='viewtopics.php';
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
$sql='SELECT p2.`titre`, p2.`description`, p2.`moderator`, p3.`sujet`, '.
'p2.`fid`, p1.`pid`, p4.`uid`, p4.`username`, p4.`avatar` , p4.`grade` , p1.`message`, p4.`signature`, '.
'p1.`status`, p3.`status` AS `t_status`, p1.`time` AS `timestamp` '.
'FROM `forums_title` AS p2'.
' LEFT JOIN `forums_topics` AS p3 ON p2.`fid`=p3.`fid`'.
' LEFT JOIN `forums` AS p1 ON p1.`tid`=p3.`tid`'.
' LEFT JOIN `users` AS p4 ON p1.`uid`=p4.`uid`'.
'WHERE p1.`tid`="'.$id.'" '.
'ORDER BY p1.`pid` ASC;';
//die($sql);
$res=send_sql($sql);
$num=mysql_num_rows($res);
//tab_out($res);
$posts = Array();
for($i=0;$i<$num;$i++) {
 $ligne=mysql_fetch_array($res, MYSQL_ASSOC);
 $posts[$i]=$ligne;
}
mysql_free_result($res);
if(count($posts)>0) {
 $forum=$posts['0']['titre'];
 $sujet=$posts['0']['sujet'];
 $fid=$posts['0']['fid'];
 $t_status=$posts['0']['t_status'];
 $moderator=$posts['0']['moderator'];
 $moderateurs=explode(',', $moderator);
 print('<table class="index_table_top">'.n);
 print(' <tr>'.n);
 print('  <td class="titre"><a href="viewforums.php?id='.$fid.'">'.$forum.'</a></td>'.n);
 print('  <td class="topic"><a href="viewtopics.php?id='.$id.'">'.$sujet.'</a></td>'.n);
 print(' </tr>'.n);
 print('</table><br/>'.n);
 print('<table class="index_table">'.n);
 $i=0;
 foreach($posts as $post) {
  //print_r($post);
  $pid=$post['pid'];
  $message=$post['message'];
  //$message2=stripslashes($message);
  $message2=$message;
  $message2=changer_specials_chars($message2,1);
  $message2=transform($message2);
  $username=$post['username'];
  $uid=$post['uid'];
  $datetime=$post['timestamp'];
  $date=date('d/m/Y', $datetime);
  $time=date('H:i:s', $datetime);
  $status=$post['status'];
  $avatar=$post['avatar'];
  if($avatar=='') $avatar='skins/'.$sid.'/images/noavatar.gif';
  $grade=$post['grade'];
  $signature=$post['signature'];
  //$signature2=stripslashes($signature);
  $signature2=changer_specials_chars($signature,1);
  $signature2=transform($signature2);
  if($signature2!='') $signature2='<div class=\'hr\'></div>'.$signature2;
  print(' <tr>'.n);
  print('  <td class="top_left"><a class="normal" name="'.$pid.'">&eacute;crit par <a href="membres.php?id='.$uid.'">'.$username.'</a>');
  if(uid!=0) print(' [<a href="mail.php?id='.$uid.'&amp;act=send">PM</a>]');
  print('</a></td>'.n);
  print('  <td class="top_right">le '.$date.' &agrave; '.$time.'');
  print(' [<a href="quote.php?id='.$pid.'">Citer</a>]');
  if( grade=='administrateur' || ( $uid==uid && $uid!=0 ) ) {
   if($i!=0) {
    print(' [<a href="editpost.php?id='.$pid.'">&eacute;diter</a>]');
   }
   else {
    print(' [<a href="edittopic.php?id='.$pid.'">&eacute;diter</a>]');
   }
  }
  if( $i!=0 && ( grade=='administrateur' || ( $uid==uid && $uid!=0 ) ) ) print(' [<a href="delpost.php?id='.$pid.'">supprimer</a>]');
  print('</td>'.n);
  print(' </tr>'.n);
  print(' <tr>'.n);
  print('  <td class="mess_left"><img class="avatar" src="'.$avatar.'" alt="avatar"/><br/>'.$grade.'</td>'.n);
  print('  <td class="mess_right">'.$message2.$signature2.'</td>'.n);
  print(' </tr>'.n);
  //print('  <td class='user'>$username</td>'.n);
  //print('  <td class='datetime'>$date &agrave; $time</td>'.n);
  $i++;
 }
 //print('<pre>'.n);print_r($posts);print('</pre>'.n);
 print('</table><br/>'.n);
 
 print('<table class="index_table_bottom">'.n);
 print(' <tr>'.n);
 print('  <td class="reply">');
 if($t_status=='open' && ( grade=='administrateur' || grade=='moderateur' || in_array(login, $moderateurs) ) )
  print('<a href="close.php?id='.$id.'">Fermer</a> | ');
 if($t_status=='open')
  print('<a href="replytopic.php?id='.$id.'">R&eacute;pondre</a>');
 if($t_status=='close' && ( grade=='administrateur' || grade=='moderateur' || in_array(login, $moderateurs) ) )
  print('<a href="open.php?id='.$id.'">Ouvrir</a> | ');
 if($t_status=='close') print('Sujet ferm&eacute;');
 print('</td>');
 print(' </tr>'.n);
 print('</table>'.n);
}
else {
print('<table class="index_table_bottom">'.n);
 print(' <tr>'.n);
 print('  <td class="center">');
 print('Ce sujet n\'existe pas');
 print('</td>');
 print(' </tr>'.n);
 print('</table>'.n);	
}
include_once('skins/'.sid.'/footer.php');
?>
