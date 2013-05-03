<?php
define('n', "\r\n");
$page='quote.php';
if( isset($_REQUEST['id']) ) {
 $id=$_REQUEST['id'];
}
else {
 $id='';
}
$PHP_SELF=$_SERVER['PHP_SELF'];
require_once('db_config.inc.php');
require_once('fonc.php');
include_once('skins/'.sid.'/header.php');
if( $id!='' ) {
 $id=$_REQUEST['id'];
}
else {
 print('<p>pas de &ccedil;a chez moi !</p>');
 include_once('skins/'.sid.'/footer.php');
 die();
}
if( isset($_REQUEST['name']) ) $name=$_REQUEST['name'];
if( isset($_REQUEST['contenu']) ) $contenu=$_REQUEST['contenu'];
if( isset($name) && isset($contenu) && $name!='' && $contenu!='') {
 $sql='SELECT p1.`tid`, p2.`fid`, p3.`titre`, p2.`sujet`, p2.`status`'.
 ' FROM `forums` AS p1, `forums_topics` AS p2, `forums_title` AS p3'.
 ' WHERE p1.`tid`=p2.`tid` AND p1.`pid`="'.$id.'" AND p2.`fid`=p3.`fid`;';
 //die($sql);
 $res=send_sql($sql);
 $num=mysql_num_rows($res);
 if($num==0) { print('<p>pas de &ccedil;a chez moi !</p>');include_once('skins/'.sid.'/footer.php');die(); }
 $ligne=mysql_fetch_array($res, MYSQL_ASSOC);
 $fid=$ligne['fid'];
 //$pid=$ligne['pid']+1;
 $forum=$ligne['titre'];
 $sujet=$ligne['sujet'];
 $tid=$ligne['tid'];
 $status=$ligne['status'];
 mysql_free_result($res);
 $sql='select max(`pid`) AS `pid` from `forums`;';
 $res=send_sql($sql);
 $ligne=mysql_fetch_array($res, MYSQL_ASSOC);
 $pid=$ligne['pid']+1;
 mysql_free_result($res);
 if($status=='close') { print('<p>Sujet ferm&eacute;.</p>');include_once('skins/'.sid.'/footer.php');die(); }
 //$tid=$ligne['tid'];
 print('<h2><span class="top"><a href="viewforums.php?id='.$fid.'">'.$forum.'</a> > <a href="viewtopics.php?id='.$tid.'">'.$sujet.'</a></span></h2>');
 //die('$fid $pid'.n.'$sql');
 /*$sql='SELECT max(`pid`) AS `pid` FROM `forums`;';
 $res=send_sql($sql);
 $ligne=mysql_fetch_array($res, MYSQL_ASSOC);
 $pid=$ligne['pid']+1;*/
 $time=time();
 $contenu2=$contenu;
 $contenu2=changer_specials_chars($contenu2,0);
// $contenu2=addslashes(strip_tags($contenu2));
 //die('$contenu2');
 $sql='INSERT INTO `forums` VALUES("'.$tid.'", "'.$pid.'", "'.uid.'", "'.$contenu2.'", "R", "'.$time.'");';//''.$fid.'',
 //die('$fid $pid'.n.'$sql');
 $res=send_sql($sql);
 if($res!='1') { print('&eacute;chec'); }
 $sql='UPDATE `forums_title` SET `last_pid`="'.$pid.'", `nb_posts`=`nb_posts`+1 WHERE `fid`="'.$fid.'";';
 //die('$fid $pid'.n.'$sql');
 $res2=send_sql($sql);
 if($res2!='1') { print('&eacute;chec'); }
 $sql='UPDATE `forums_topics` SET `posts`=`posts`+1, `last_pid`="'.$pid.'" WHERE `tid`="'.$tid.'";';
 $res3=send_sql($sql);
 if($res3!='1') { print('&eacute;chec'); }
 if($res=='1' && $res2=='1' && $res3=='1') print('<p>Votre message a bien &eacute;t&eacute; post&eacute;.</p>');
}
else {
/*        Pseudo<br>
        <input name='tagname' maxlength='20'/><br/><br/>*/
 $sql='SELECT p2.`titre`, p3.`sujet`, p2.`fid`, p1.`tid`, p1.`message`, p4.`username` '.
 'FROM `forums` AS p1, `forums_title` AS p2, `forums_topics` AS p3, `users` AS p4 '.
 'WHERE p2.`fid`=p3.`fid` AND p1.`pid`="'.$id.'" AND p1.`tid`=p3.`tid` AND p1.`uid`=p4.`uid`;';
 $res=send_sql($sql);
 $num=mysql_num_rows($res);
 if($num==0) { mysql_free_result($res);print('<p>Pas de &ccedil;a chez moi !</p>');include_once('skins/'.sid.'/footer.php');die(); }
 $ligne=mysql_fetch_array($res, MYSQL_ASSOC);
 $forum=$ligne['titre'];
 $sujet=$ligne['sujet'];
 $fid=$ligne['fid'];
 $tid=$ligne['tid'];
 $username=$ligne['username'];
 $message=$ligne['message'];
 mysql_free_result($res);
// $message=stripslashes($message);
 $message=changer_specials_chars($message,1);
 $message=transform($message, false);
 print('<h2><span class="top"><a href="viewforums.php?id='.$fid.'">'.$forum.'</a> > <a href="viewtopics.php?id='.$tid.'">'.$sujet.'</a></span></h2>'.n);
 print('      <form action="'.$PHP_SELF.'?id='.$id.'" method="post" id="post_text"><div>
        <input type="hidden" name="name" value="ayumi-fr forum"/>
		<input type="radio" name="bbmode" value="ezmode" onclick="setmode(this.value)"/>&nbsp;<span class="bold">Mode Guid&eacute;</span><br/>
        <input type="radio" name="bbmode" value="normal" onclick="setmode(this.value)" checked="checked"/>&nbsp;<span class="bold">Mode Normal</span>
		<br/>
        Message
        <br/>');
 top_smile('text');
 print('        <textarea cols="60" rows="12" name="contenu">[quote='.$username.']'.$message.'[/quote]'."\n".'</textarea><br/>');
 bottom_smile('text', 10);
 print('<br/>');
 print('        <input class="button" type="submit" value="Envoyer"/>
      </div></form>');
}
 include_once('skins/'.sid.'/footer.php');
?>
