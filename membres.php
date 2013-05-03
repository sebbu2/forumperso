<?php
define('n', "\r\n");
$page='membres.php';
$PHP_SELF=$_SERVER['PHP_SELF'];
require_once('db_config.inc.php');
require_once('fonc.php');
include_once('skins/'.sid.'/header.php');
if( isset($_REQUEST['id']) && is_numeric($_REQUEST['id']) ) {
 $id=$_REQUEST['id'];
 $sql='SELECT * FROM `users` WHERE `uid`="'.$id.'";';
 $res=send_sql($sql);
 $num=mysql_num_rows($res);
 //tab_out($res);
 $posts = Array();
 for($i=0;$i<$num;$i++) {
  $ligne=mysql_fetch_array($res, MYSQL_ASSOC);
  $posts[$i]=$ligne;
 }
 mysql_free_result($res);
 //print('<pre>');print_r($ligne);print('</pre>');//die();
 print('<table class="index_table">'.n);
 foreach($posts as $post) {
  $uid=$post['uid'];
  $username=$post['username'];$grade=$post['grade'];$avatar=$post['avatar'];
  if($avatar=='') $avatar='skins/'.$sid.'/images/noavatar.gif';
  $aim=$post['aim'];if($aim=='') $aim='non';
  $msn=$post['msn'];if($msn=='') $msn='non';
  $yahoo=$post['yahoo'];if($yahoo=='') $yahoo='non';
  $icq=$post['icq'];if($icq=='') $icq='non';
  $site=$post['site'];$email=$post['email'];
  if($target) { $target2=' target="_blank"'; } else { $target2=''; }
  if($site!='') { $site2='<a href="'.$site.'"'.$target2.'>site web</a>'; } else { $site2='non'; }
  $show_email=$post['show_email'];if($username=='Visiteur') $email='non';
  if($show_email=='yes') {
   $mail='<a href="mailto:'.$email.'">'.$email.'</a>';
  }
  else {
   $mail='<span class="italic">Priv&eacute;e';
   if(grade=='administrateur') $mail.=' : <a href="mailto:'.$email.'">'.$email.'</a>';
   $mail.='</span>';
  }
  $commentaire=$post['commentaire'];if($commentaire=='') $commentaire='non';
  $commentaire=stripslashes($commentaire);
  $commentaire=transform($commentaire);
  $signature=$post['signature'];if($signature=='') $signature='non';
  $signature=stripslashes($signature);
  $signature=transform($signature);
  print(' <tr>'.n);
  print('  <td class="membres_left">'.$username.'<br/>
<img class="avatar" src="'.$avatar.'" alt="avatar"/><br/>'.$grade.'</td>'.n);
  print('  <td class="membres_right">MSN : '.$msn.'<br/>
AIM : '.$aim.'<br/>
YAHOO : '.$yahoo.'<br/>
ICQ : '.$icq.'<br/><br/>
Site web: '.$site2.'<br/>
E-mail : '.$mail.'<br/>
<br/>Signature : '.$signature.'<br/>
<br/>Commentaire : '.$commentaire.'<br/>');
  if(uid!=0) print('
<br/><a href="mail.php?id='.$uid.'&amp;act=send">PM</a>');
  print('</td>'.n);
  print(' </tr>'.n);
 }
 print('</table>'.n);
}
else {
 /*print('<p>pas de &ccedil;a chez moi !</p>');
 include_once('skins/'.sid.'/footer.php');
 die();*/
 if( isset($_REQUEST['show']) ) { $show=$_REQUEST['show']; } else { $show='normal'; }
 if( grade=='administrateur' && $show=='all' ) {
  /*
  S'il s'agit d'un administrateur qui veut voir tout les membres
  */
  if( isset($_REQUEST['order']) ) { $order=$_REQUEST['order']; } else { $order='uid'; }
  if( isset($_REQUEST['other']) ) { $other=$_REQUEST['other']; } else { $other='no'; }
  $order_pos=Array('uid','login','username','grade');
  $other_pos=Array('yes', 'no');
  if( !in_array ($order, $order_pos) ) { print('<p>Pas de &ccedil;a chez moi !</p>');include_once('skins/'.sid.'/footer.php');die(); }
  if( !in_array ($other, $other_pos) ) { print('<p>Pas de &ccedil;a chez moi !</p>');include_once('skins/'.sid.'/footer.php');die(); }
  print('<a href="membres.php">Liste des membres</a><br/>'.n);
  print('<a href="membres.php?show=all&amp;order='.$order.'&amp;other=yes">montrer</a> / '.
  '<a href="membres.php?show=all&amp;order='.$order.'&amp;other=no">cacher</a> les utilisateurs non-standard<br/>');
  print('Tri par : <a href="membres.php?show=all&amp;order=uid&amp;other='.$other.'">uid</a> , '.
  '<a href="membres.php?show=all&amp;order=login&amp;other='.$other.'">login</a>'.
  ' , <a href="membres.php?show=all&amp;order=username&amp;other='.$other.'">username</a> , '.
  '<a href="membres.php?show=all&amp;order=grade&amp;other='.$other.'">grade</a><br/><br/>'.n);
  //$sqladd=($other)?'':'WHERE `status`='active' OR `status`='validating'';
  $sqladd = ($other=='yes')?'':'WHERE `status`="active" OR `status`="validating"';
  $sql='SELECT * FROM `users` $sqladd ORDER BY `'.$order.'` ASC;';
  $res=send_sql($sql);
  $num=mysql_num_rows($res);
  //tab_out($res);
  $posts = Array();
  for($i=0;$i<$num;$i++) { $ligne=mysql_fetch_array($res, MYSQL_ASSOC); $posts[$i]=$ligne; }
  mysql_free_result($res);
  //print('<pre>');print_r($ligne);print('</pre>');//die();
  print('<table class="index_table">'.n);
  foreach($posts as $post) {
   $uid=$post['uid'];
   $username=$post['username'];$grade=$post['grade'];$avatar=$post['avatar'];
   if($avatar=='') $avatar='skins/'.$sid.'/images/noavatar.gif';
   $aim=$post['aim'];if($aim=='') $aim='non';
   $msn=$post['msn'];if($msn=='') $msn='non';
   $yahoo=$post['yahoo'];if($yahoo=='') $yahoo='non';
   $icq=$post['icq'];if($icq=='') $icq='non';
   $site=$post['site'];$email=$post['email'];
   if($target) { $target2=' target="_blank"'; } else { $target2=''; }
   if($site!='') { $site2='<a href="'.$site.'"'.$target2.'>site web</a>'; } else { $site2='non'; }
   $show_email=$post['show_email'];if($username=='Visiteur') $email='non';
   if($show_email=='yes') {
    $mail='<a href="mailto:'.$email.'">'.$email.'</a>';
   }
   else {
    $mail='<span class="italic">Priv&eacute;e';
    if(grade=='administrateur') $mail.=' : <a href="mailto:'.$email.'">'.$email.'</a>';
    $mail.='</span>';
   }
   $commentaire=$post['commentaire'];if($commentaire=='') $commentaire='non';
   $commentaire=stripslashes($commentaire);
   $commentaire=transform($commentaire);
   $signature=$post['signature'];if($signature=='') $signature='non';
   $signature=stripslashes($signature);
   $signature=transform($signature);
   print(' <tr>'.n);
   print('  <td class="membres_left"><a href="membres.php?id='.$uid.'">'.$username.'</a><br/>
<img class="avatar" src="'.$avatar.'" alt="avatar"/><br/>'.$grade.'</td>'.n);
   print('  <td class="membres_right">MSN : '.$msn.'<br/>
AIM : '.$aim.'<br/>
YAHOO : '.$yahoo.'<br/>
ICQ : '.$icq.'<br/><br/>
Site web: '.$site2.'</a><br/>
E-mail : '.$mail.'<br/>
<br/>Signature : '.$signature.'<br/>
<br/>Commentaire : '.$commentaire.'<br/>
<br/><a href="mail.php?id='.$uid.'&amp;act=send">PM</a></td>'.n);
   print(' </tr>'.n);
  }
  print('</table>'.n);

 }
 else {
  /*
  Sinon...
  */
  if( grade=='administrateur' ) print('<a href="membres.php?show=all">Voir tout les profils</a><br/>'.n);
  if( isset($_REQUEST['order']) ) { $order=$_REQUEST['order']; } else { $order='uid'; }
  $order_pos=Array('uid','login','username','grade');
  if( !in_array ($order, $order_pos) ) { print('<p>Pas de &ccedil;a chez moi !</p>');include_once('skins/'.sid.'/footer.php');die(); }
  $sql='SELECT * FROM `users`
  WHERE `status`="active" OR `status`="validating" ORDER BY `'.$order.'`;';
  $res=send_sql($sql);
  $num=mysql_num_rows($res);
  $posts = Array();
  for($i=0;$i<$num;$i++) {
   $ligne=mysql_fetch_array($res, MYSQL_ASSOC);
   $posts[$i]=$ligne;
  }
  mysql_free_result($res);
  // , <a href='membres.php?order=login'>login</a>
  print('Tri par : <a href="membres.php?order=uid">uid</a>'.
  ' , <a href="membres.php?order=username">username</a> , <a href="membres.php?order=grade">grade</a><br/><br/>'.n);
  print('<table class="index_table">'.n);
  foreach($posts as $post) {
   $uid=$post['uid'];
   $username=$post['username'];$grade=$post['grade'];$avatar=$post['avatar'];
   if($avatar=='') $avatar='skins/'.$sid.'/images/noavatar.gif';
   $aim=$post['aim'];if($aim=='') $aim='non';
   $msn=$post['msn'];if($msn=='') $msn='non';
   $yahoo=$post['yahoo'];if($yahoo=='') $yahoo='non';
   $icq=$post['icq'];if($icq=='') $icq='non';
   $site=$post['site'];$email=$post['email'];
   if($target) { $target2=' target="_blank"'; } else { $target2=''; }
   if($site!='') { $site2='<a href="'.$site.'"'.$target2.'>site web</a>'; } else { $site2='non'; }
   $show_email=$post['show_email'];if($username=='Visiteur') $email='non';
   if($show_email=='yes') {
    $mail='<a href="mailto:'.$email.'">email</a>';
   }
   else {
    $mail='<span class="italic">Priv&eacute;e';
    if(grade=='administrateur') $mail.=' : <a href="mailto:'.$email.'">email</a>';
    $mail.='</span>';
   }
   $commentaire=$post['commentaire'];if($commentaire=='') $commentaire='non';
   $commentaire=stripslashes($commentaire);
   $commentaire=transform($commentaire);
   $signature=$post['signature'];if($signature=='') $signature='non';
   $signature=stripslashes($signature);
   $signature=transform($signature);
   print(' <tr class="membres2">'.n);
   print('  <td class="membres2_1"><a href="membres.php?id='.$uid.'">'.$username.'</a><br/>'.$grade.'</td>'.n);
   print('  <td class="membres2_2">'.$mail.'</td>'.n);
   print('  <td class="membres2_3">'.$site2);
   if(uid!=0) print('<br/><a href="mail.php?id='.$uid.'&amp;act=send">PM</a>');
   print('</td>'.n);
   print('  <td class="membres2_4">MSN:&nbsp;'.$msn.' AIM:&nbsp;'.$aim.' YAHOO:&nbsp;'.$yahoo.' ICQ:&nbsp;'.$icq.'</td>'.n);
   print(' </tr>'.n);
  }
  print('</table>'.n);
  /*
  Fin
  */
 }
}
include_once('skins/'.sid.'/footer.php');
?>