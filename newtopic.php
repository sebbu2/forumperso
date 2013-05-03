<?php
define('n', "\r\n");
$page='newtopic.php';
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
if( isset($_REQUEST['sujet']) ) $sujet=$_REQUEST['sujet'];
if( isset($name) && isset($contenu) && isset($sujet) && $name!='' && $contenu!='' && $sujet!='' ) {
// $sql='SELECT p1.`fid`, max(p1.`last_pid`) AS `pid`, max(p2.`tid`) AS `tid`, `titre`, `description` FROM `forums_title` AS p1, `forums_topics` AS p2 WHERE p1.`fid`=p2.`fid` GROUP BY `fid`;';
 $sql='SELECT max(`last_pid`) AS `pid`, max(`tid`) AS `tid` FROM `forums_topics`;';
 // AND p1.`fid`='$id'
 //print($sql);
 $res=send_sql($sql);
 $num=mysql_num_rows($res);
 $ligne=mysql_fetch_array($res, MYSQL_ASSOC);
 mysql_free_result($res);
 //$ligne=mysql_fetch_array($res, MYSQL_ASSOC);
 $fid=$id;
 $pid=$ligne['pid']+1;
 $tid=$ligne['tid']+1;
 $sql='SELECT `titre`, `description` FROM `forums_title` WHERE `fid`="'.$id.'";';
 $res=send_sql($sql);
 $num=mysql_num_rows($res);
 $ligne=mysql_fetch_array($res, MYSQL_ASSOC);
 mysql_free_result($res);
 $forum=$ligne['titre'];
 $description=$ligne['description'];
 //print('$fid $tid $pid');
 print('<h2><span class="top"><a href="viewforums.php?id='.$fid.'">'.$forum.'</a> > '.$description.'</span></h2>');
 //die();
 $time=time();
 $contenu2=$contenu;
 $contenu2=changer_specials_chars($contenu2,0);
// $contenu2=addslashes(strip_tags($contenu2));
 $sujet2=changer_specials_chars($sujet,0);
// $sujet=addslashes(strip_tags($sujet));
 $sql='INSERT INTO `forums` VALUES("'.$tid.'", "'.$pid.'", "'.uid.'", "'.$contenu2.'", "open", "'.$time.'");';//"'.$fid.'",
 //die($sql);
 //print($sql);
 $res1=send_sql($sql);

 $sql='UPDATE `forums_title` SET `last_pid`="'.$pid.'", `nb_topics`=`nb_topics`+1, `nb_posts`=`nb_posts`+1 WHERE `fid`="'.$fid.'";';
 //print($sql);
 $res2=send_sql($sql);
 $sql='INSERT INTO `forums_topics` VALUES("'.$fid.'", "'.$tid.'", "'.uid.'", "'.$sujet2.'", "open", "1", "'.$pid.'", "'.$pid.'");';
 //die($sql);
 //print($sql);
 $res3=send_sql($sql);
 if($res1!='1' || $res2!='1' || $res3!='1') print('<p>Echec lors du postage du message.</>');
 if($res1=='1' && $res2=='1' && $res3=='1') print('<p>Votre message a bien &eacute;t&eacute; post&eacute;.</p>');
}
else {
/*        Pseudo<br>
        <input name='tagname' maxlength='20'/><br/><br/>*/
 $sql='SELECT * FROM `forums_title` AS p2 WHERE p2.`fid`="'.$id.'";';
 $res=send_sql($sql);
 $num=mysql_num_rows($res);
 if($num==0) { print('<p>Pas de &ccedil;a chez moi !</p>');include_once('skins/'.sid.'/footer.php');die(); }
 $ligne=mysql_fetch_array($res, MYSQL_ASSOC);
 $forum=$ligne['titre'];
 //$sujet=$ligne['sujet'];
 $fid=$ligne['fid'];
 $description=$ligne['description'];
 //$tid=$ligne['tid'];
 mysql_free_result($res);
 print('<h2><span class="top"><a href="newtopic.php?id='.$fid.'">'.$forum.'</a> > '.$description.'</span></h2>'.n);
 // > <a href='viewtopics.php?id=$tid'>$sujet</a></span></h2>'.n);
 print('      <form action="'.$PHP_SELF.'?id='.$id.'" method="post" id="post_text"><div>
        <input type="hidden" name="name" value="ayumi-fr forum"/>
		<input type="radio" name="bbmode" value="ezmode" onclick="setmode(this.value)"/>&nbsp;<span class="bold">Mode Guid&eacute;</span><br/>
        <input type="radio" name="bbmode" value="normal" onclick="setmode(this.value)" checked="checked"/>&nbsp;<span class="bold">Mode Normal</span>
		<br/>Sujet<br/><input type="text" name="sujet" size="81"/><br/>
        Message
        <br/>');
 top_smile('text');
 print('        <textarea cols="60" rows="12" name="contenu"></textarea><br/>');
 bottom_smile('text', 10);
 print('<br/>');
 print('        <input class="button" type="submit" value="Envoyer"/>
      </div></form>');
}
 include_once('skins/'.sid.'/footer.php');
?>
