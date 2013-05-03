<?php
define('n', "\r\n");
$page='viewforums.php';
$PHP_SELF=$_SERVER['PHP_SELF'];
require_once('db_config.inc.php');
require_once('fonc.php');
include_once('skins/'.sid.'/header.php');
if( isset($_REQUEST['user']) ) { $user=$_REQUEST['user']; } else { $user=''; }
if( isset($_REQUEST['regkey']) ) { $regkey=$_REQUEST['regkey']; } else { $regkey=''; }
$sql='SELECT `regkey` FROM `users` WHERE `login`="'.$user.'" AND `regkey`="'.$regkey.'";';
$res=send_sql($sql);
$num=mysql_num_rows($res);
if($num>0) {
 $ligne=mysql_fetch_array($res, MYSQL_ASSOC);
 $regkey2=$ligne['regkey'];
 if($regkey==$regkey) {
  $sql='UPDATE `users` SET `status`="active" WHERE `login`="'.$user.'" AND `regkey`="'.$regkey.'";';
  $res=send_sql($sql);
  if($res==1) {
   print('<p>Votre inscription a bien &eacute;t&eacute; valid&eacute;. Merci.</p>');
  }
  else {
   print('<p>Echec lors de la validation, veuillez la recommencer.</p>');
  }
 }
}
else {
 print('<p>Pas de &ccedil;a chez moi !</p>');
}
mysql_free_result($res);
include_once('skins/'.sid.'/footer.php');
?>