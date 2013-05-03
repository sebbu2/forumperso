<?php
define('n', "\r\n");
$page='viewforums.php';
$PHP_SELF=$_SERVER['PHP_SELF'];
require_once('db_config.inc.php');
require_once('fonc.php');
include_once('skins/'.sid.'/header.php');
if($act=='search') {
 $pos_type=array('AND', 'OR');
 $pos_who=array('sujet', 'message', 'login');
 $pos_when=array('1', '7', '31', '365', 'all');
 $pos_show=array('post','topic');
 //print('<p>en cour</p>');include_once('skins/'.sid.'/footer.php');die();
 if( isset($_REQUEST['search_test']) ) { $search_test=$_REQUEST['search_test']; } else { $search_test=''; }
 $search2=explode(' ',$search_test);
 $search_type=$_REQUEST['search_type'];
 $search_who=$_REQUEST['search_who'];
 $search_when=$_REQUEST['search_when'];
 $search_show=$_REQUEST['search_show'];
 if( !in_array($search_type, $pos_type) || !in_array($search_show, $pos_show) || !in_array($search_who, $pos_who) || !in_array($search_when, $pos_when) ) {
  print('<p>Pas de ca chez moi !</p>'.n);
  include_once('skins/'.sid.'/footer.php');
  die();
 }
 if($search_who=='message') $search_who='p1.`'.$search_who.'`';
 if($search_who=='sujet') $search_who='p3.`'.$search_who.'`';
 if($search_who=='login') $search_who='p4.`'.$search_who.'`';
 $sql='SELECT p2.`fid`, p1.`tid`, p1.`pid`, p1.`uid`, p2.`titre`, p3.`sujet`, p4.`username`,
 ';
 if($search_show=='post') $sql.='p1. `message`, p4.`avatar`, p4.`grade`, p4.`signature`,
 ';
 $sql.='p1.`time` AS `timestamp`
 FROM `forums` AS p1, `forums_title` AS p2, `forums_topics` AS p3, `users` AS p4
 WHERE p2.`fid`=p3.`fid` AND p1.`tid`=p3.`tid` AND p1.`uid`=p4.`uid`';
 if(stripos($search_test, '*')===FALSE ) {
  if( is_array($search2) ) {
   $sql.=' AND ( ';
   $search_c=count($search2);
   $search=$search2[0];
   //$sql .=' $search_who LIKE '%$search%' ';
   $sql .=' LOCATE("'.$search.'",'.$search_who.') <> 0 ';
   for($i=1;$i<$search_c;$i++) {
   	$search=$search2[$i];
    //$sql.=' $search_type $search_who LIKE '%$search%' ';
    $sql.=' '.$search_type.' LOCATE("'.$search.'",'.$search_who.') <> 0 ';
   }
   $sql.=' ) ';
  }
 }
 $diff=$search_when*24*3600;
 $time2=time()-$diff;
 if($search_when!='all') $sql.=' AND "'.$time2.'" < p1.`time` ';
 $sql.=n.' ORDER BY p2.`fid` ASC, p1.`pid` DESC;';
 //die($sql);
 $res=send_sql($sql);
 $num=mysql_num_rows($res);
 print('<table class="index_table">'.n);
 if($num>0) {
  print(' <tr>'.n);
  $a=($num>1)?'s':'';
  print('  <td colspan="3">Il y a '.$num.' r&eacute;sultat'.$a.' &agrave; votre recherche.</td>'.n);
  print(' </tr>'.n);
 }
 $titre2='';
 for($i=0;$i<$num;$i++) {
  $ligne=mysql_fetch_array($res, MYSQL_ASSOC);
  $post=$ligne;
  $fid=$ligne['fid'];
  $tid=$ligne['tid'];
  $pid=$ligne['pid'];
  $uid=$ligne['uid'];
  $titre=$ligne['titre'];
  $sujet=$ligne['sujet'];
  $username=$ligne['username'];
  $datetime=$post['timestamp'];
  $date=date('d/m/Y', $datetime);
  $time=date('H:i:s', $datetime);
  if($search_show=='topic') {
   if($titre!=$titre2) {
    print(' <tr>'.n);
    print('  <td colspan="3" class="center"><a href="viewforums.php?id='.$fid.'">'.$titre.'</a></td>'.n);
    print(' </tr>'.n);
    $titre2=$titre;
   }
   print(' <tr>'.n);
   print('  <td class="sujet2"><a href="viewtopics.php?id='.$tid.'#'.$pid.'">'.$sujet.'</a></td>'.n);
   print('  <td class="user">auteur : <a href="membres.php?id='.$uid.'">'.$username.'</a></td>'.n);
   print('  <td class="datetime">'.$date.' &agrave; '.$time.'</td>'.n);
   print(' </tr>'.n);
  }
  if($search_show=='post') {
   $message=$ligne['message'];
   $message2=$message;
   $message2=changer_specials_chars($message2,1);
   $message2=transform($message2);
   $avatar=$ligne['avatar'];
   if($avatar=='') $avatar='skins/'.sid.'/images/noavatar.gif';
   $grade=$ligne['grade'];
   $signature=$ligne['signature'];
//   $signature2=stripslashes($signature);
   $signature2=changer_specials_chars($signature,false);
   $signature2=transform($signature2);
   if($signature2!='') $signature2='<div class=\'hr\'></div>'.$signature2;
   print(' <tr>'.n);
   print('  <td class="top_left"><a name="'.$pid.'">&eacute;crit par <a href="membres.php?id='.$uid.'">'.$username.'</a> <a href="mail.php?id='.$uid.
   '&amp;act=send">[PM]</a></a></td>'.n);
   print('  <td class="top_right">le '.$date.' &agrave; '.$time);
   if( grade=='administrateur' || ( $uid==uid && $uid!=0 ) ) print(' [<a href="editpost.php?id='.$pid.'">&eacute;diter</a>]');
   if( $i!=0 && ( grade=='administrateur' || ( $uid==uid && $uid!=0 ) ) ) print(' [<a href="delpost.php?id='.$pid.'">supprimer</a>]');
   print('</td>'.n);
   print(' </tr>'.n);
   print(' <tr>'.n);
   print('  <td class="mess_left"><img class="avatar" src="'.$avatar.'" alt="avatar"/><br/>'.$grade.'</td>'.n);
   print('  <td class="mess_right">'.$message2.$signature2.'</td>'.n);
   print(' </tr>'.n);
  }
 }
 mysql_free_result($res);
 if($num==0) {
  print(' <tr>'.n);
  print('  <td>Pas de r&eacute;sultat pour votre recherche.</td>'.n);
  print(' </tr>'.n);
 }
 print('</table>'.n);
 include_once('skins/'.sid.'/footer.php');
 die();
}
else {
?>
<form action='<?php echo $PHP_SELF; ?>' method='post'><input type='hidden' name='act' value='search'/>
<table class='index_table'>
 <tr>
  <td class='search'>Rechercher :</td>
  <td class='search'><input type='text' name='search_test'/> ( * pour tout )</td>
 </tr>
 <tr>
  <td class='search'>Type de recherche :</td>
  <td class='search'><input type='radio' name='search_type' value='OR' checked='checked'/>Un des mots
<input type='radio' name='search_type' value='AND'/>Tous les mots
</td>
 </tr>
 <tr>
  <td class='search'>Rechercher o&ugrave; :</td>
  <td class='search'><input type='radio' name='search_who' value='message' checked='checked'/>Message
<input type='radio' name='search_who' value='sujet'/>Sujet
<input type='radio' name='search_who' value='login'/>Utilisateur
</td>
 </tr>
 <tr>
  <td class='search'>Afficher les messages :</td>
  <td class='search'><select name='search_when'>
<option value='1'>d'Aujourd'hui</option><option value='7'>des 7 derniers jours</option>
<option value='31'>des 31 derniers jours</option><option value='365'>des 365 derniers jours</option>
<option value='all' selected='selected'>de toute date</option></select></td>
 </tr>
 <tr>
  <td class='search'>Afficher les r&eacute;sultats sous forme de :</td>
  <td class='search'><select name='search_show'><option value='topic' selected='selected'>Sujets</option>
<option value='post'>Messages</select></td>
 </tr>
 <tr>
 <td colspan='2' class='center'><input type='submit' value='Recherche'/><input type='reset' value='Reset'/></td>
 </tr>
</table>
</form>
<?php
}
include_once('skins/'.sid.'/footer.php');
?>
