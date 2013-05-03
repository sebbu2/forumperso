<?php
if( isset($_REQUEST['act']) ) { $act=$_REQUEST['act']; } else { $act=''; }
require_once('db_config.inc.php');
if( isset($_REQUEST['user']) && isset($_REQUEST['pass']) && $_REQUEST['user']!="" && $_REQUEST['pass']!="" ) {
 $user=$_REQUEST['user'];
 $user2=md5($user);
 $pass=$_REQUEST['pass'];
 $pass2=md5($pass);
 $md5=true;
 $uid_s=false;
}
elseif( isset($_COOKIE['UID']) && isset($_COOKIE['USR']) && isset($_COOKIE['PWD']) ) {
 if( $_COOKIE['UID']!='' && $_COOKIE['USR']!="" && $_COOKIE['PWD']!='' ) {
  $uid2=$_COOKIE['UID'];
  $user=$_COOKIE['USR'];
  $user2=$user;
  $pass=$_COOKIE['PWD'];
  $pass2=$pass;
  $md5=true;
  $uid_s=true;
 }
 else {
  $user='Visiteur';
  $user2=md5($user);
  $pass='';
  $pass2=md5($pass);
  $md5=false;
  $uid_s=false;
 }
}
else {
 $user='Visiteur';
 $user2=md5($user);
 $pass='';
 $pass2=md5($pass);
 $md5=false;
 $uid_s=false;
}
//die($user.' '.$user2.' '.$pass.' '.$pass2");
if( $page=='log.php' && $act=='logout' ) {
 $user='Visiteur';
 $user2=md5($user);
 $pass='';
 $pass2=md5($pass);
 $md5=false;
 $uid_s=false;
}
$sql='SELECT * FROM `users` WHERE md5(`login`)="'.$user2.'"';
if($md5) {
 $sql.=' AND `pass`="'.$pass2.'"';
}
if($uid_s) {
 $sql.=' AND md5(`uid`)="'.$uid2.'"';
}
$sql .= ';';
$res=send_sql($sql);
$num=mysql_num_rows($res);
$ligne=mysql_fetch_array($res, MYSQL_ASSOC);
$opt=$ligne['opt'];
$opt2=explode('|', $opt);
if( $num==0 || in_array('ban',$opt2) ) {
 $user='Visiteur';$user2=md5($user);$pass='';$pass2=md5($pass);$md5=false;
 $sql='SELECT * FROM `users` WHERE md5(`login`)="'.$user2.'";';
 $res=send_sql($sql);
 $num=mysql_num_rows($res);
 $ligne=mysql_fetch_array($res, MYSQL_ASSOC);
 $opt=$ligne['opt'];
 $opt2=explode('|', $opt);
}
$uid=$ligne['uid'];
$login=$ligne['login'];
$username=$ligne['username'];
$password=$ligne['pass'];
$email=$ligne['email'];
$grade=$ligne['grade'];
$aim=$ligne['aim'];
$msn=$ligne['msn'];
$yahoo=$ligne['yahoo'];
$icq=$ligne['icq'];
$site=$ligne['site'];
$show_email=$ligne['show_email'];
$commentaire=$ligne['commentaire'];
$signature=$ligne['signature'];
$sid=$ligne['sid'];
$opt=$ligne['opt'];
$sid2=$sid;
$avatar=$ligne['avatar'];
$MP=$ligne['MP'];
mysql_free_result($res);
define('uid', $uid);
define('login', $login);
define('usn', $username);
define('email', $email);
define('pass', $password);
define('grade', $grade);
define('MP', $MP);
define('opt', $opt);
define('site', $site);
if( isset($_REQUEST['skinid']) ) {
 $sid=$_REQUEST['skinid'];
 if( !is_dir('skins/'.$sid.'/') ) die('pas de ca chez moi.');
}
define('sid', $sid);
define('sid2', $sid2);
if($login=='Visiteur') {
 setcookie('UID','',0,'/');
 setcookie('USN','',0,'/');
 setcookie('USR','',0,'/');
 setcookie('PWD','',0,'/');
 $login=false;
 $logout=true;
}
else {
 setcookie('UID',md5($uid),9999999999,'/');
 setcookie('USR',md5($login),9999999999,'/');
 setcookie('PWD',$pass2,9999999999,'/');
 $login=true;
 $logout=false;
}

?>
