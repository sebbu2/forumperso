<?php
// Connexion &agrave; la BD
//define("n", "\r\n");
//$page="online.php";
$PHP_SELF=$_SERVER['PHP_SELF'];
require_once('db_config.inc.php');
require_once('fonc.php');
//$host=$dbhost;$user=$dbuser;$pass=$dbpass;$bdd=$dbb;

// l'ID du site appelant est d&eacute;j&agrave; dans $site !
$site=1;

// IP du visiteur
$IP = $_SERVER['REMOTE_ADDR'];

// Date/heure courante en minutes
/*$date=date("Y-m-d");
$time=date("H:i:s");
$datetime=date("Y-m-d H:i:s");*/
$time=time();
// Dur&eacute;e de vie max
$vie = 5;

// Suppression des anciens
/*$SQL = "DELETE FROM matable2 WHERE site=".$site;
$SQL.= " AND start<".($date0-$vie);
$result = send_sql ($dbb, $SQL);*/

// Stockage du hit courant
   //'$date','$time',
   $sql = 'REPLACE INTO `online` VALUES("'.$IP.'","'.$time.'","'.$site.'","'.login.'");';
   //print($SQL);
   $result = send_sql($sql);

//define("nu", $new_user);

function count_user() {
 global $db, $dbb, $dbuser, $dbpass, $link;
 global $site;
 // Nombre de visiteurs en ligne
 $sql = 'SELECT count(`IP`) FROM `online` WHERE `site`="'.$site.'";';
 $res=send_sql($sql);
 $val= mysql_fetch_array($res, MYSQL_NUM);
 $online = $val[0];//var_dump($val);
 mysql_free_result($res);
 // Retour valeur
 return $online;
}

function show_users1() {
 global $db, $dbb, $dbuser, $dbpass, $link;
 global $site;
 $sql='SELECT p1.`user`, p2.`uid`, p2.`grade` FROM `online` AS p1, `users` AS p2 WHERE p1.`user`=p2.`login` AND p1.`site`="'.$site.'" ';
 $sql.='AND p1.`time` > UNIX_TIMESTAMP()-300;';
 $res=send_sql($sql);
 $num=mysql_num_rows($res);
 $users=Array();
 $users_uid=Array();
 $users_grade=Array();
 $j=0;
 for($i=0;$i<$num;$i++) {
  $ligne=mysql_fetch_array($res, MYSQL_ASSOC);
  $user=$ligne['user'];
  $user_uid=$ligne['uid'];
  $user_grade=$ligne['grade'];
  if($user!='Visiteur') {
   $users[$j]=$user;
   $users_uid[$j]=$user_uid;
   $users_grade[$j]=$user_grade;
   $j++;
  }
 }
 mysql_free_result($res);
 $num_reg=count($users);
 $num_inv=$num-$num_reg;
 define('num', $num);
 define('num_reg', $num_reg);
 define('num_inv', $num_inv);
 return array($users, $users_uid, $users_grade);
}

function show_users2($users, $users_uid, $users_grade) {
 $num=num;
 $num_reg=num_reg;
 $num_inv=num_inv;
 print('Il y a en tout '.$num.' utilisateur');
 if($num>1) print('s');
 print(' en ligne :: '.$num_reg.' Enregistr&eacute;');
 if($num_reg>1) print('s');
 print(' et '.$num_inv.' Invit&eacute;');
 if($num_inv>1) print('s');
 print('<br/>Utilisateur');
 if($num_reg>1) print('s');
 print(' enregistr&eacute;');
 if($num_reg>1) print('s');
 print(' :');
 //print_r($users);
 if($num_reg>1) {
  for($i=0; $i<$num_reg-1;$i++) {
   $grade=$users_grade[$i];
   $user=$users[$i];
   $uid=$users_uid[$i];
   print(' <span class="user_'.$grade.'"><a href="membres.php?id='.$uid.'">'.$user.'</a></span>,');
  }
  //$i++;
  $grade=$users_grade[$i];
  $user=$users[$i];
  $uid=$users_uid[$i];
  print(' <span class="user_'.$grade.'"><a href="membres.php?id='.$uid.'">'.$user.'</a></span>');
 }
 elseif($num_reg==1) {
  $i=0;
  $grade=$users_grade[$i];
  $user=$users[$i];
  $uid=$users_uid[$i];
  print(' <span class="user_'.$grade.'"><a href="membres.php?id='.$uid.'">'.$user.'</a></span>');
 }
 else {
  print(' aucun');
 }
}
?>
