<?php
define('n', "\r\n");
$page='mail.php';
$PHP_SELF=$_SERVER['PHP_SELF'];
require_once('db_config.inc.php');
require_once('fonc.php');
include_once('skins/'.sid.'/header.php');
if( isset($_REQUEST['act']) ) { $act=$_REQUEST['act']; } else { $act=''; }
if( isset($_REQUEST['id']) && is_numeric($_REQUEST['id']) ) { $id=$_REQUEST['id']; } else { $id=''; }
if( $user=='Visiteur' ) { print('<p>Les visiteurs n\'ont pas droits aux messages priv&eacute;s.</p>');include_once('skins/'.sid.'/footer.php');die(); }
if($id=='') {
 $sql='SELECT p1.`mid`, p1.`uid1`, p1.`sujet`, p1.`time` AS `timestamp`, p2.`username`
FROM `priv_msg` AS p1, `users` AS p2, `users` AS p3 
WHERE p1.`uid1`=p2.`uid` AND p1.`uid2`=p3.`uid` AND p1.`uid2`="'.$uid.'"
ORDER BY p1.`mid` ASC;';
 $res=send_sql($sql);
 $num=mysql_num_rows($res);
 print('<table class="index_table">'.n);
 for($i=0;$i<$num;$i++) {
  $ligne=mysql_fetch_array($res, MYSQL_ASSOC);
  $post=$ligne;
  $uid1=$ligne['uid1'];
  $username=$ligne['username'];
  $sujet=$ligne['sujet'];
  $datetime=$post['timestamp'];
  $date=date('d/m/Y', $datetime);
  $time=date('H:i:s', $datetime);
  $mid=$ligne['mid'];
  print(' <tr>'.n);
  print('  <td class="user"><a href="membres.php?id='.$uid1.'">'.$username.'</a></td>'.n);
  print('  <td class="sujet2"><a href="mail.php?id='.$mid.'">'.$sujet.'</a> <a href="mail.php?id='.$mid.'&amp;act=del">[&eacute;ffacer]</a></td>'.n);
  print('  <td class="datetime">le '.$date.' &agrave; '.$time.'</td>'.n);
  print(' </tr>'.n);
 }
 mysql_free_result($res);
 if($num==0) {
  print(' <tr>'.n.'  <td>Pas de messages priv&eacute;s</td>'.n.' </tr>'.n);
 }
 print('</table>'.n);
 include_once('skins/'.sid.'/footer.php');die();
}
else {
 if($act=='del') {
  if( isset($_REQUEST['uid']) ) { $uid2=$_REQUEST['uid']; } else { $uid2=''; }
  $sql='SELECT `uid1`, `uid2` FROM `priv_msg` WHERE `mid`="'.$id.'";';
  $res=send_sql($sql);
  $ligne=mysql_fetch_array($res, MYSQL_ASSOC);
  $uid1=$ligne['uid1'];
  $uid2=$ligne['uid2'];
  mysql_free_result($res);
  //die('de $uid1 &agrave; $uid2');
  $sql='DELETE FROM `priv_msg` WHERE `uid2`="'.$uid2.'" AND `mid`="'.$id.'";';
  //die($sql);
  $res1=send_sql($sql);
  $sql='UPDATE `users` SET `MP`=`MP`-1 WHERE `uid`="'.$uid2.'";';
  $res2=send_sql($sql);
  if($res1=='1') {
   print('<p>Le message a bien &eacute;t&eacute; &eacute;ffac&eacute;.</p>');
  }
  else {
   print('<p>Echec lors de la suppression du message</p>');
  }
  include_once('skins/'.sid.'/footer.php');die();
 }
 elseif($act=='post') {
  if( isset($_REQUEST['uid2']) ) { $uid2=$_REQUEST['uid2']; } else { $uid2=''; }
  if( isset($_REQUEST['contenu']) ) { $contenu=$_REQUEST['contenu']; } else { $contenu=''; }
  if( isset($_REQUEST['sujet']) ) { $sujet=$_REQUEST['sujet']; } else { $sujet=''; }
  if ($sujet=='') { $sujet='Sans Titre'; }
  if( $uid2=='' || $contenu=='' || $sujet=='' ) { print('<p>Pas de &ccedil;a chez moi !</p>');include_once('skins/'.sid.'/footer.php');die(); }
  if( $uid2==0 ) { print('<p>Les visiteurs n\'ont pas droits aux messages priv&eacute;s.</p>');include_once('skins/'.sid.'/footer.php');die(); }
  $sql='SELECT max(`mid`) AS `max` FROM `priv_msg`;';
  $res=send_sql($sql);
  $ligne=mysql_fetch_array($res, MYSQL_ASSOC);
  $mid=$ligne['max']+1;
  mysql_free_result($res);
  $time=time();
  $sujet2=changer_specials_chars($sujet,0);
  $contenu2=changer_specials_chars($contenu,0);
  $sql='INSERT INTO `priv_msg` VALUES ("'.$mid.'", "'.$uid.'", "'.$uid2.'", "'.$sujet2.'", "'.$contenu2.'", "'.$time.'");';
  //die('$sql');
  $res1=send_sql($sql);
  $sql='UPDATE `users` SET `MP`=`MP`+1 WHERE `uid`="'.$uid2.'";';
  $res2=send_sql($sql);
  if($res1=='1'&&$res2=='1') {
   print('<p>Votre message a &eacute;t&eacute; envoy&eacute;.</p>');
  }
  else {
   print('<p>Echec lors de l\'envoit du message.</p>');
  }
  include_once('skins/'.sid.'/footer.php');die();
 }
 elseif($act=='send') {
  if( $id==0 ) { print('<p>Les visiteurs n\'ont pas droits aux messages priv&eacute;s.</p>');include_once('skins/'.sid.'/footer.php');die(); }
  $sql='SELECT `username` FROM `users` AS p2 WHERE `uid`="'.$id.'";';
  $res=send_sql($sql);
  $num=mysql_num_rows($res);
  if($num==0) { print('<p>Pas de &ccedil;a chez moi !</p>');include_once('skins/'.sid.'/footer.php');die(); }
  if( isset($_REQUEST['topic']) ) { $topic=$_REQUEST['topic']; } else { $topic=''; }
  $ligne=mysql_fetch_array($res, MYSQL_ASSOC);
  if( substr($topic,0,5)!='Re : ' && strlen($topic)>0 ) $topic='Re : '.$topic;
  $username=$ligne['username'];
  mysql_free_result($res);
  print('<h2><span class="top"><a href="membres.php?id='.$id.'">'.$username.'</a> ></span></h2>'.n);
  print('      <form action="mail.php?id='.$id.'" method="post" id="post_text"><div>
        <input type="hidden" name="name" value="ayumi-fr forum"/>
        <input type="hidden" name="act" value="post"/>
		<input type="hidden" name="uid2" value="'.$id.'"/>
		<input type="radio" name="bbmode" value="ezmode" onclick="setmode(this.value)"/>&nbsp;<span class="bold">Mode Guid&eacute;</span><br/>
        <input type="radio" name="bbmode" value="normal" onclick="setmode(this.value)" checked="checked"/>&nbsp;<span class="bold">Mode Normal</span>
		<br/>Sujet<br/>
		<input class="new_sujet" type="text" name="sujet" value="'.$topic.'"/>
		<br/>
        Message
        <br/>');
  top_smile('text');
  print('        <textarea cols="30" rows="6" name="contenu"></textarea><br/>');
  bottom_smile('text', 10);
  print('<br/>');
  print('        <input class="button" type="submit" value="Envoyer"/>
      </div></form>');
  include_once('skins/'.sid.'/footer.php');die();
 }
 else {
  $sql='SELECT p1.`mid`, p1.`uid1`, p1.`sujet`, p1.`message`, p1.`time` AS `timestamp`, p2.`username`, p2.`avatar`, p2.`grade`, p2.`signature` 
FROM `priv_msg` AS p1, `users` AS p2, `users` AS p3
WHERE p1.`uid1`=p2.`uid` AND p1.`uid2`=p3.`uid` AND p1.`uid2`="'.$uid.'" AND p1.`mid`="'.$id.'"
ORDER BY p1.`mid` ASC;';
  $res=send_sql($sql);
  $num=mysql_num_rows($res);
  print('<table class="index_table">'.n);
  for($i=0;$i<$num;$i++) {
   $ligne=mysql_fetch_array($res, MYSQL_ASSOC);
   $post=$ligne;
   $datetime=$post['timestamp'];
   $date=date('d/m/Y', $datetime);
   $time=date('H:i:s', $datetime);
   $uid1=$ligne['uid1'];
   $username=$ligne['username'];
   $sujet=$ligne['sujet'];
   $message=$ligne['message'];
   $message2=changer_specials_chars($message,1);
   $message2=transform($message2);
   $sujet=$ligne['sujet'];
   $sujet2=changer_specials_chars($sujet,1);
   $sujet2=transform($sujet2);
   $sujet2=str_ireplace(' ','+',$sujet2);
   $mid=$ligne['mid'];
   $avatar=$ligne['avatar'];
   if($avatar=='') $avatar='skins/'.$sid.'/images/noavatar.gif';
   $grade=$ligne['grade'];
   $signature=$ligne['signature'];
   $signature2=changer_specials_chars($signature,1);
   if($signature2!='') $signature2='<div class=\'hr\'></div>'.$signature2;
   print(' <tr>'.n);
   print('  <td class="top_left">&eacute;crit par <a href="membres.php?id='.$uid1.'">'.$username.'</a></td>'.n);
   print('  <td class="top_right">le '.$date.' &agrave; '.$time.' <a href="mail.php?id='.$mid.'&amp;act=del">[&eacute;ffacer]</a></td>'.n);
   print(' </tr>'.n);
   print(' <tr>'.n);
   print('  <td class="mess_left"><img class="avatar" src="'.$avatar.'" alt="avatar"/><br/>'.$grade.'</td>'.n);
   print('  <td class="mess_right">'.$message2.$signature2.'</td>'.n);
   print(' </tr>'.n);
   print('</table><br/>'.n);
   print('<table class="index_table_bottom">'.n);
   print(' <tr>'.n);
   print('  <td class="reply"><a href="mail.php?id='.$uid1.'&amp;act=send&amp;topic='.$sujet2.'">R&eacute;pondre</a></td>');
   print(' </tr>'.n);
   print('</table>'.n);
   include_once('skins/'.sid.'/footer.php');die();
  }
 }
 mysql_free_result($res);
 if($num==0) {
  print(' <tr>'.n.'  <td>Ce message n\'existe pas ou ne vous appartient pas</td>'.n.' </tr>'.n);
  print('</table>'.n);
  include_once('skins/'.sid.'/footer.php');die();
 }
}
?>
