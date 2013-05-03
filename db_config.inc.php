<?php
require_once('var.inc.php');
$dbhost='localhost';
$dbuser='sebbu';
$dbpass='pass';
$dbb='sebbu';
//$host=$dbhost;$user=$dbuser;$pass=$dbpass;$bdd=$dbb;
$count_requete=0;

$link = @mysql_connect($dbhost, $dbuser, $dbpass) or die(readfile('no_db.php'));
mysql_select_db($dbb, $link);

if (!function_exists('send_sql')) {
 function send_sql($sql) {
  //print($sql.'<br/>');
  //var_dump($sql);print('<br/>');
  global $link, $count_requete;
  $count_requete++;
  if( !$res=mysql_query($sql, $link) ) {
   echo 'requ&ecirc;te : '.$sql.'<br/>&eacute;rreur : '.mysql_error();
   exit();
  }
  return $res;
 }
}

require_once('online.php');
require_once('auth.inc.php');
?>
