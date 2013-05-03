<?php
define('n', "\r\n");
$page='editpost.php';
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
 $sql='SELECT p2.`uid`, p2.`fid`, p2.`tid`, p3.`titre`, p2.`sujet`, p3.`moderator` FROM `forums` AS p1, `forums_topics` AS p2, `forums_title` AS p3 '.
 'WHERE p1.`tid`=p2.`tid` AND p2.`fid`=p3.`fid` AND p1.`pid`="'.$id.'";';
 $res=send_sql($sql);
 $ligne=mysql_fetch_array($res, MYSQL_ASSOC);
 $uid=$ligne['uid'];
 $moderator=$ligne['moderator'];
 $moderateurs=explode(',', $moderator);
 if( grade!='administrateur' && grade!='moderateur' && !in_array(login, $moderateurs) ) {
  if( $uid==0 || $uid!=uid ) {
   print('<p>pas de &ccedil;a chez moi !2</p>');include_once('skins/'.sid.'/footer.php');die();
  }
 }
 $fid=$ligne['fid'];
 $forum=$ligne['titre'];
 $sujet=$ligne['sujet'];
 $tid=$ligne['tid'];
 mysql_free_result($res);
 print('<h2><span class="top"><a href="viewforums.php?id='.$fid.'">'.$forum.'</a> > <a href="viewtopics.php?id='.$tid.'">'.$sujet.'</a></span></h2>');
 $date=date('d/m/Y');
 $time=date('H:i:s');
 $contenu2=$contenu;
 $contenu2=changer_specials_chars($contenu2,0);
 //$contenu2=addslashes(strip_tags($contenu2));
 //die($contenu2);
 //, `date`='$date', `time`='$time'
 $sql='UPDATE `forums` SET `message`="'.$contenu2.'" WHERE `tid`="'.$tid.'" AND `pid`="'.$id.'";';//`fid`="'.$fid.'" AND
 //die($sql);
 $res=send_sql($sql);
 if($res!='1') print('&eacute;chec');
 if($res=='1') print('<p>Le message a bien &eacute;t&eacute; &eacute;dit&eacute;.</p>');
}
else {
/*        Pseudo<br>
        <input name='tagname' maxlength='20'/><br/><br/>*/
 $sql='SELECT p2.`titre`, p3.`sujet`, p2.`fid`, p1.`tid`, p1.`message` FROM `forums` AS p1, `forums_title` AS p2, `forums_topics` AS p3'.
 ' WHERE p2.`fid`=p3.`fid` AND p1.`pid`="'.$id.'" AND p1.`tid`=p3.`tid`;';
 $res=send_sql($sql);
 $num=mysql_num_rows($res);
 if($num==0) { mysql_free_result($res);print('<p>Pas de &ccedil;a chez moi !</p>');include_once('skins/'.sid.'/footer.php');die(); }
 $ligne=mysql_fetch_array($res, MYSQL_ASSOC);
 $forum=$ligne['titre'];
 $sujet=$ligne['sujet'];
 $fid=$ligne['fid'];
 $tid=$ligne['tid'];
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
 print('        <textarea cols="60" rows="12" name="contenu">'.$message.'</textarea><br/>');
 bottom_smile('text', 10);
 print('<br/>');
 print('        <input class="button" type="submit" value="Envoyer"/>
      </div></form>');
}
 include_once('skins/'.sid.'/footer.php');
?>
