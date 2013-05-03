<?php
//print('<pre>');print_r($_FILES);print('</pre>');die();
define('n', "\r\n");
$PHP_SELF=$_SERVER['PHP_SELF'];
$page='profil.php';
require_once('db_config.inc.php');
require_once('fonc.php');
include_once('skins/'.sid.'/header.php');
$page='profil.php';

if(usn=='Visiteur') {
 print('Vous devez vous connecter pour modifier votre profil.');include_once('skins/'.sid.'/footer.php');die();
}

if( isset($_REQUEST['act']) ) { $act=$_REQUEST['act']; } else { $act=''; }

if( isset($_REQUEST['act']) ) { $act=$_REQUEST['act']; } else { $act=''; }
if($act=='modif') {

if( isset($_REQUEST['username']) ) { $username=$_REQUEST['username']; } else { $username=''; } //die('$username');
if( isset($_REQUEST['password']) ) { $password=$_REQUEST['password']; } else { $password=''; }
if( isset($_REQUEST['password2']) ) { $password2=$_REQUEST['password2']; } else { $password2=''; }
if( isset($_REQUEST['email']) ) { $email=$_REQUEST['email']; } else { $email=''; }
if( isset($_REQUEST['aim']) ) { $aim=$_REQUEST['aim']; } else { $aim=''; }
if( isset($_REQUEST['msn']) ) { $msn=$_REQUEST['msn']; } else { $msn=''; }
if( isset($_REQUEST['icq']) ) { $icq=$_REQUEST['icq']; } else { $icq=''; }
if( isset($_REQUEST['yahoo']) ) { $yahoo=$_REQUEST['yahoo']; } else { $yahoo=''; }
if( isset($_REQUEST['show_email']) ) { $show_email=$_REQUEST['show_email']; } else { $show_email=''; }
if( isset($_REQUEST['site']) ) { $site=$_REQUEST['site']; } else { $site=''; }
if( isset($_REQUEST['signature']) ) { $signature=$_REQUEST['signature']; } else { $signature=''; }
if( isset($_REQUEST['commentaire']) ) { $commentaire=$_REQUEST['commentaire']; } else { $commentaire=''; }
//$signature=addslashes(strip_tags($signature));
$signature2=$signature;
$signature2=changer_specials_chars($signature,0);
//$commentaire=addslashes(strip_tags($commentaire));
$commentaire2=$commentaire;
$commentaire2=changer_specials_chars($commentaire2,0);
if( isset($_REQUEST['skin']) ) { $skin=$_REQUEST['skin']; } else { $skin='0'; }
if( isset($_REQUEST['avatar_adresse']) ) { $avatar_adresse=$_REQUEST['avatar_adresse']; } else { $avatar_adresse=''; }
if( isset($_REQUEST['avatar_file']) ) { $avatar_file=$_REQUEST['avatar_file']; } else { $avatar_file=''; }
if( isset($_FILES['avatar_file']) ) {
$value='avatar_file';
   if(isset($_FILES[$value]['type'])) $userfile_type=$_FILES[$value]['type'];
   if(isset($_FILES[$value]['error'])) $userfile_error=$_FILES[$value]['error'];
   if(isset($_FILES[$value]['name'])) $userfile_name=$_FILES[$value]['name'];
   if(isset($_FILES[$value]['size'])) $userfile_size=$_FILES[$value]['size'];
   if(isset($_FILES[$value]['tmp_name'])) $tmp_name=$_FILES[$value]['tmp_name'];
}
else {
$userfile_type='';$userfile_error='pas de fichier';$userfile_name='';$userfile_size='';$tmp_name='';
}
//die('$userfile_name');

 if($password2!='') {
  if(md5($password)!=pass ) {
   print('Mot de passe invalide !');include_once('skins/'.sid.'/footer.php');die();
  }
  if($password==$password2 && $login) {
   $password2=md5($password);
   $sql='UPDATE `users` SET `pass`="'.$password2.'" WHERE `login`="'.$login.'";';
   $res=send_sql($sql);
   if($res=='1') {
    print('Le mot de passe a &eacute;t&eacute; modifi&eacute; avec succ&egrave;s. Cliquer <a href="log.php?act=log">ici</a> pour vous reconnecter.');include_once('skins/'.sid.'/footer.php');die();
   }
   else {
    print('Echec du changement de mot de passe.');include_once('skins/'.sid.'/footer.php');die();
   }
  }
  else {
   print('Vous devez taper le m&ecirc;me mot de passe et &ecirc;tre loggu&eacute;.');include_once('skins/'.sid.'/footer.php');die();
  }
 }
 
 if($username!=usn) {
 if(md5($password)!=pass ) {
  print('Mot de passe invalide !');include_once('skins/'.sid.'/footer.php');die();
 }
  $password2=md5($password);
  $sql='UPDATE `users` SET `username`="'.$username.'" WHERE `login`="'.login.'" AND `pass`="'.$password2.'";';
  $res=send_sql($sql);
  if($res=='1') {
   print('Nom affich&eacute; modifi&eacute; avec succ&egrave;s.');include_once('skins/'.sid.'/footer.php');die();
  }
  else {
   print('Echec du changement du nom affich&eacute;.');include_once('skins/'.sid.'/footer.php');die();
  }
 }
 
 if($email!=email) {
 if(md5($password)!=pass ) {
  print('Mot de passe invalide !');include_once('skins/'.sid.'/footer.php');die();
 }
  $password2=md5($password);
  $sql='UPDATE `users` SET `email`="'.$email.'"';
  if($email_change=='validate') {
   list($usec, $sec) = explode(' ',microtime());
   $regkey=md5($sec).md5($usec);
   $sql.=', `status`="validating", `regkey`="$regkey"';
   $sql.=' WHERE `login`="'.login.'" AND `pass`="'.$password2.'";';
   //die('$sql');
   $res_mail=send_sql($sql);
   $message='<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="fr">'.n.
'<head>
<meta http-equiv="Content-Language" content="fr">
<title>Modification du compte "'.$username.'"</title>
</head>
<body>

<p>Votre profil sur <a href="http://ayumi-fr.bip2.com/forum/" target="_blank">AYUMI HAMASAKI FRENCH FORUMS</a> a bien &eacute;t&eacute; modifi&eacute;.
Cliquer <a href="'.$adress_site.'/validate.php?user='.$username.'&amp;regkey='.$regkey.'" target="_blank">ici</a> pour valider le changement de votre adresse e-mail</p>

<p>Je vous rappelle que votre login est "'.$username.'" et votre pass "'.$password.'".</p>

</body>
</html>';
   //die('<code>$message</code>');
   $mail=@mail($email,
   'Validation n&eacute;ccessaire pour le forum du site AYUMI HAMASAKI FRENCH', 
   '$message', 
   'From: Ayumi Hamasaki French Forums <zsbe17fr@yahoo.fr>\r\n'.
   'Content-Type: text/html\r\n');
   if($mail && $res_mail=='1') {
    print('<p>Votre inscription a &eacute;t&eacute; prise en compte. Vous devez valider votre compte avec l\'email que vous allez recevoir.</p>');
   }
   else {
    print('<p>Echec lors de l\'inscription, veuillez vous r&eacute;inscrire.</p>');
   }
  }
  else {
   $sql.=' WHERE `login`="'.login.'" AND `pass`="'.$password2.'";';
  }
  $res=send_sql($sql);
  if($res=='1') {
   print('Adresse e-mail modifi&eacute; avec succ&egrave;s.');
   
   include_once('skins/'.sid.'/footer.php');die();
  }
  else {
   print('Echec du changement de l\'adresse e-mail.');include_once('skins/'.sid.'/footer.php');die();
  }
 }
 
 if($avatar_adresse!='') {
  $sql='UPDATE `users` SET `avatar`="'.$avatar_adresse.'" WHERE `login`="'.login.'";';
  //die($sql);
  $res=send_sql($sql);
  if($res=='1') {
   print('Votre avatar a bien &eacute;t&eacute; pris en compte.');include_once('skins/'.sid.'/footer.php');die();
  }
  else {
   print('Echec de la prise en compte de l\'avatar.');include_once('skins/'.sid.'/footer.php');die();
  }
 }
 elseif($userfile_name!='') {
  require_once('avatar.inc.php');
  $avatar_file='$dest';
  $sql='UPDATE `users` SET `avatar`="'.$avatar_file.'" WHERE `login`="'.login.'";';
  $res=send_sql($sql);
  //die($sql);
  if($res=='1') {
   print('Votre avatar a bien &eacute;t&eacute; pris en compte.');include_once('skins/'.sid.'/footer.php');die();
  }
  else {
   print('Echec de la prise en compte de l\'avatar.');include_once('skins/'.sid.'/footer.php');die();
  }
 }
 
 if($username==usn && $email==email) { // && md5($password)==pass
  //print('en cour');die();
  $sql='UPDATE `users` SET `aim`="'.$aim.'", `msn`="'.$msn.'", `yahoo`="'.$yahoo.'", `icq`="'.$icq.'", `show_email`="'.$show_email.'", '.
  '`site`="'.$site.'", `signature`="'.$signature2.'", `commentaire`="'.$commentaire2.'", `sid`="'.$skin.'" WHERE `login`="'.login.'";';
  //die('$sql');
  $res=send_sql($sql);
  if($res=='1') {
   print('Votre profil a bien &eacute;t&eacute; modifi&eacute;.');include_once('skins/'.sid.'/footer.php');die();
  }
  else {
   print('Echec de la modification du profil.');include_once('skins/'.sid.'/footer.php');die();
  }
 }
/* else {
  print('Erreur dans la modification du profil.');include_once('skins/'.sid.'/footer.php');die();
 }*/
 
 print('Vous n\'avez rien modifi&eacute;.');include_once('skins/'.sid.'/footer.php');die();

}
else {
 $sql='SELECT `sid`, `nom` FROM `skins` ORDER BY `sid` ASC';
 $res=send_sql($sql);
 $nb_skin=mysql_num_rows($res);
 $sid2=array();
 $nom2=array();
 for($i=0;$i<$nb_skin;$i++) {
  $ligne=mysql_fetch_array($res, MYSQL_ASSOC);
  $sid2[$i]=$ligne['sid'];
  $nom2[$i]=$ligne['nom'];
 }
 mysql_free_result($res);
?>
<form action='<?php echo $PHP_SELF; ?>' method='post' enctype='multipart/form-data'><input type='hidden' name='act' value='modif'/><table class='reg_table'>
 <tr>
  <td colspan='2' class='reg_title'>Enregistrement</td>
 </tr>
 <tr>
  <td>nom affich&eacute; :</td>
  <td><input class='reg' type='text' name='username' value='<?php echo usn; ?>'/></td>
 </tr>
 <tr>
  <td>mot de passe :</td>
  <td><input class='reg' type='password' name='password'/></td>
 </tr>
 <tr>
  <td>mot de passe : ( retaper que si changement )</td>
  <td><input class='reg' type='password' name='password2'/></td>
 </tr>
 <tr>
  <td>adresse e-mail :<?php if($email_change=='validate') print('( revalidation n&eacute;cessaire )'); ?></td>
  <td><input class='reg' type='text' name='email' value='<?php echo email; ?>'/></td>
 </tr>
 <tr>
  <td colspan='2' class='reg_title'>Profil</td>
 </tr>
 <tr>
  <td>Num&eacute;ro ICQ :</td>
  <td><input class='reg' type='text' name='icq' value='<?php echo $icq; ?>'/></td>
 </tr>
 <tr>
  <td>Adresse AIM :</td>
  <td><input class='reg' type='text' name='aim' value='<?php echo $aim; ?>'/></td>
 </tr>
 <tr>
  <td>MSN Messenger :</td>
  <td><input class='reg' type='text' name='msn' value='<?php echo $msn; ?>'/></td>
 </tr>
 <tr>
  <td>Yahoo Messenger :</td>
  <td><input class='reg' type='text' name='yahoo' value='<?php echo $yahoo; ?>'/></td>
 </tr>
 <tr>
  <td>Montrer l&#039;adresse e-mail :</td>
  <td><input class='radio' type='radio' name='show_email' value='yes'<?php if($show_email=='yes') print(' checked="checked"'); ?>/>Yes
<input class='radio' type='radio' name='show_email' value='no<?php if($show_email=='no') print(' checked="checked"'); ?>'/>No</td>
 </tr>
 <tr>
  <td>Site web :</td>
  <td><input class='reg' type='text' name='site' value='<?php echo site; ?>'/></td>
 </tr>
 <tr>
  <td>Signature :</td>
  <td><textarea name='signature' rows='6' cols='30'><?php $signature2=$signature; $signature=changer_specials_chars($signature2,1); echo $signature2; ?></textarea></td>
 </tr>
 <tr>
  <td>Commentaire :</td>
  <td><textarea name='commentaire' rows='6' cols='30'><?php $commentaire2=$commentaire; $commentaire=changer_specials_chars($commentaire2,1); echo $commentaire2; ?></textarea></td>
 </tr>
 <tr>
  <td>Skin :</td>
  <td><select name='skin'>
<?php
$text='';
for($i=0;$i<$nb_skin;$i++) {
 $sid=$sid2[$i];
 $nom=$nom2[$i];
 if(sid2==$sid) { $text=' selected="selected"'; } else { $text=''; }
 print('<option value="'.$sid.'"'.$text.'>'.$nom.'</option>'.n);
}
unset($text)
?>
</select></td>
 </tr>
 <tr>
  <td colspan='2' class='reg_title'>Avatar</td>
 </tr>
 <tr>
  <td>Upload d'avatar :</td>
  <td><input type='file' name='avatar_file'/></td>
 </tr>
 <tr>
  <td>A partir d'un site :</td>
  <td><input type='text' name='avatar_adresse'/></td>
 </tr>
 <tr>
  <td>Avatar actuel :</td>
  <td><?php if($avatar=='') $avatar='skins/'.$sid.'/images/noavatar.gif'; print('<img class="avatar" src="'.$avatar.'" alt="avatar"/>');?></td>
 </tr>
 <tr>
  <td colspan='2' class='center'><input type='submit' value='Envoyer'/><input type='reset' value='R&eacute;initialiser'/></td>
 </tr>
</table></form>
<?php
}
include_once('skins/'.sid.'/footer.php');
?>
