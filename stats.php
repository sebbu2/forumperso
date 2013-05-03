<?php
define('n', "\r\n");
$page='index2.php';
$PHP_SELF=$_SERVER['PHP_SELF'];
require_once('db_config.inc.php');
require_once('fonc.php');
include_once('skins/'.sid.'/header.php');
//$sql='SELECT count(p1.`pid`) AS `posts`, count(p2.`uid`) AS `membres` FROM `forums` AS p1, `users` AS p2;';
$sql='( SELECT COUNT(*) AS champ FROM `forums` ) UNION ( SELECT COUNT(*) AS champ FROM `users` ) UNION ( SELECT count(*) AS champ FROM `forums_topics` );';
//$sql='SELECT (SELECT count(`pid`) AS `posts` FROM `forums`), (SELECT count(`uid`) AS `membres` FROM `users`);';

$res=send_sql($sql);
$num=mysql_num_rows($res);
//die('$num');
if($num==3) {
$ligne=mysql_fetch_array($res, MYSQL_ASSOC);
$posts=$ligne['champ'];
$ligne=mysql_fetch_array($res, MYSQL_ASSOC);
$membres=$ligne['champ'];
$ligne=mysql_fetch_array($res, MYSQL_ASSOC);
$topics=$ligne['champ'];
}
mysql_free_result($res);
//tab_out($res);die();

//$membres=$ligne['membres'];
print('<table class="index_table">'.n);
print(' <tr>'.n);
print('  <td class="left_top">Nombre de messages : '.$posts.'<br/>
Nombre de sujets : '.$topics.'</td>'.n);
print('  <td class="left_top">Nombre de membres : '.$membres.'<br/>
Nombre de personne');
$online=count_user();
if($online>1) print('s');
print(' qui ont visit&eacute;');
if($online>1) print('s');
print(' ce forum : ');
//include('online.php');
//count_user();
print($online);
print('</td>'.n);
print(' </tr>'.n);
print('</table>'.n);
include_once('skins/'.sid.'/footer.php');
?>