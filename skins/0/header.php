<?php
//define("n", "\r\n");
//require_once("auth.inc.php");
//ob_start('ob_gzhandler'); // compression gzip
 print('<?xml version="1.0" encoding="'.$charset.'"?>'.chr(10));
if($target) print('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'.chr(10));
if(!$target) print('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'.chr(10));
 ///*print('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML Basic 1.0//EN" "http://www.w3.org/TR/xhtml-basic/xhtml-basic10.dtd">'.chr(10));*/
 //print('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">'.chr(10));
?>
<html>
<head>
<title>FORUMS ( en construction )</title>
<?php
if( isset($_REQUEST['name']) ) { $name=$_REQUEST['name']; } else { $name=''; }
if($meta && $name=='ayumi-fr forum') {
 if($page=='replytopic.php') {
  print("<meta http-equiv='Refresh' CONTENT='3;URL=viewtopics.php?id=$id'/>");
 }
}
list($users_total, $users_uid_total, $users_grade_total)=show_users1();
?>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset; ?>"/>
<meta http-equiv="Content-Language" content="fr"/>
<link type="text/css" rel="stylesheet" href="skins/<?php echo sid; ?>/style.css"/>
</head>
<body>

<div class="tout">
<table class="top">
 <tr>
  <td class="left">Connect&eacute; en tant que : <?php echo usn; ?></td>
 </tr>
 <tr>
  <td class="left"><a href="index.php">Index du forum</a> <?php
if(usn=="Visiteur") { 
?><a href="log.php?act=log">Se connecter</a> <a href="register.php">S'enregistrer</a>
<?php
}
else {
?><a href="log.php?act=logout">Se d&eacute;connecter</a> <a href="profil.php">Mon profil</a>
<a href="mail.php">Messagerie priv&eacute;e</a> (<?php echo $MP; ?>)
<?php
}
?><a href="search.php">Recherche</a>
<a href="stats.php">Statistiques</a>
<a href="membres.php">Liste des membres</a></td>
 </tr>
</table><br/>
