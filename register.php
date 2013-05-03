<?php
define('n', "\r\n");
$page='viewforums.php';
$PHP_SELF=$_SERVER['PHP_SELF'];
require_once('db_config.inc.php');
require_once('fonc.php');
include_once('skins/'.sid.'/header.php');
if( isset($_REQUEST['act']) ) { $act=$_REQUEST['act']; } else { $act=''; }
if( isset($_REQUEST['username']) ) { $username=$_REQUEST['username']; } else { $username=''; } //die('$username');
if( isset($_REQUEST['password']) ) { $password=$_REQUEST['password']; } else { $password=''; }
if( isset($_REQUEST['password2']) ) { $password2=$_REQUEST['password2']; } else { $password2=''; }
if( isset($_REQUEST['email']) ) { $email=$_REQUEST['email']; } else { $email=''; }

if($act=='reg' || $act=='new') {
 if( $username=='' || $password=='' || $password2=='' || $password!=$password2 || $email=='' ) {
  if( $password=='' && $password2=='' ) {
   if( $username!='' || $email!='' ) {
    print('<p>Vous devez taper un mot de passe !</p>');include_once('skins/'.sid.'/footer.php');die();
   }
  }
  if( $username=='' ) { print('<p>Vous devez taper un nom d\'utilisateur !</p>');include_once('skins/'.sid.'/footer.php');die(); }
  if( $email=='' ) { print('<p>Vous devez taper une adresse e-mail !</p>');include_once('skins/'.sid.'/footer.php');die(); }
  if($password!=$password2) { print('<p>Vous devez taper le m&ecirc;me mot de passe !</p>');include_once('skins/'.sid.'/footer.php');die(); }
 }
}
if( $username!='' && $password!='' && $password2!='' && $password==$password2 && $email!='' && ( $act=='new' || $act=='reg' ) ) {
 //print('Enregistrement en construction');
 if( isset($_REQUEST['aim']) ) { $aim=$_REQUEST['aim']; } else { $aim=''; }
 if( isset($_REQUEST['msn']) ) { $msn=$_REQUEST['msn']; } else { $msn=''; }
 if( isset($_REQUEST['icq']) ) { $icq=$_REQUEST['icq']; } else { $icq=''; }
 if( isset($_REQUEST['yahoo']) ) { $yahoo=$_REQUEST['yahoo']; } else { $yahoo=''; }
 $show_email=$_REQUEST['show_email'];
 $site=$_REQUEST['site'];
 if( isset($_REQUEST['signature']) ) { $signature=$_REQUEST['signature']; } else { $signature=''; }
 if( isset($_REQUEST['commentaire']) ) { $commentaire=$_REQUEST['commentaire']; } else { $commentaire=''; }
 $signature=changer_specials_chars($signature,0);
 $commentaire=changer_specials_chars($commentaire,0);
 //print('$signature $commentaire');
 $sql='SELECT max(`uid`) AS `max` FROM `users`;';
 $res=send_sql($sql);
 $ligne=mysql_fetch_array($res, MYSQL_ASSOC);
 $uid=$ligne['max']+1;
 $password2=md5($password);
 list($usec, $sec) = explode(' ',microtime());
 $regkey=md5('$sec').md5('$usec');
 //die('$regkey');
 $time=time();
 $sql='INSERT INTO `users` VALUES ("'.$uid.'", "'.$username.'", "'.$username.'", "'.$password2.'", "'.$email.'", "'.$show_email.'", "'.$site.'",'.
 ' "'.$commentaire.'", "'.$signature.'", "", "'.$aim.'", "'.$msn.'", "'.$yahoo.'", "'.$icq.'", "'.$new_user_email.'", "'.$regkey.'", "membre", "0",'.
 ' "", "'.$time.'", "0");';
 $res_mail=send_sql($sql);
 //die($sql);
 /* test */
 if($new_user_email=='validate') {
  $message='<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">'.
 '<html lang="fr">'.n.
 '<head>'.
 '<meta http-equiv="Content-Language" content="fr">'.
 '<title>Validation du compte "'.$username.'"</title>'.
 '</head>'.
 '<body>'.
 ''.
 '<p>Votre inscription sur <a href="http://ayumi-fr.bip2.com/forum/" target="_blank">AYUMI HAMASAKI FRENCH FORUMS</a> a bien &eacute;t&eacute; prise en'.
 'compte. Cliquer <a href="'.$adress_site.'/validate.php?user='.$username.'&amp;regkey='.$regkey.'" target="_blank">ici</a> pour valider votre inscription</p>'.
 ''.
 '</body>'.
 '</html>';
 //die('<code>$message</code>');
 $mail=@mail('$email',
 'Validation n&eacute;ccessaire pour le forum du site AYUMI HAMASAKI FRENCH', 
 '$message', 
 'From: Ayumi Hamasaki French Forums <zsbe17fr@yahoo.fr>\r\n'.
 'Content-Type: text/html\r\n');
 }
 if($mail && $res_mail=='1') {
  print('<p>Votre inscription a &eacute;t&eacute; prise en compte. Vous devez valider votre compte avec l\'email que vous allez recevoir.</p>');
 }
 else {
  print('<p>Echec lors de l\'inscription, veuillez vous r&eacute;inscrire.</p>');
 }
}
else {
?>
<form action='register.php' method='post'><input type='hidden' name='act' value='reg'/><table class='reg_table'>
 <tr>
  <td colspan='2' class='center'><span class='reg_title'>Enregistrement</span></td>
 </tr>
 <tr>
  <td>Nom d'utilisateur :</td>
  <td><input class='reg' type='text' name='username'/></td>
 </tr>
 <tr>
  <td>Adresse e-mail :</td>
  <td><input class='reg' type='text' name='email'/></td>
 </tr>
 <tr>
  <td>Mot de passe :</td>
  <td><input class='reg' type='password' name='password'/></td>
 </tr>
 <tr>
  <td>Confirmer le mot de passe :</td>
  <td><input class='reg' type='password' name='password2'/></td>
 </tr>
 <tr>
  <td colspan='2' class='center'><span class='reg_title'>Profil</span></td>
 </tr>
 <tr>
  <td>Num&eacute;ro ICQ :</td>
  <td><input class='reg' type='text' name='icq'/></td>
 </tr>
 <tr>
  <td>Adresse AIM :</td>
  <td><input class='reg' type='text' name='aim'/></td>
 </tr>
 <tr>
  <td>MSN Messenger :</td>
  <td><input class='reg' type='text' name='msn'/></td>
 </tr>
 <tr>
  <td>Yahoo Messenger :</td>
  <td><input class='reg' type='text' name='yahoo'/></td>
 </tr>
 <tr>
  <td>Montrer l'adresse e-mail :</td>
  <td><input class='radio' type='radio' name='show_email' value='yes' checked='checked'/>Oui
<input class='radio' type='radio' name='show_email' value='no'/>Non</td>
 </tr>
 <tr>
  <td>Site web :</td>
  <td><input class='reg' type='text' name='site'/></td>
 </tr>
 <tr>
  <td>Signature :</td>
  <td><textarea name='signature' rows='6' cols='30'></textarea></td>
 </tr>
 <tr>
  <td>Commentaire :</td>
  <td><textarea name='commentaire' rows='6' cols='30'></textarea></td>
 </tr>
 <tr>
  <td colspan='2' class='center'><input type='submit' value='Envoyer'/><input type='reset' value='R&eacute;initialiser'/></td>
 </tr>
</table></form>
<?php
}
include_once('skins/'.sid.'/footer.php');
?>
