<?php
require_once('auth.inc.php');
require_once('str_ireplace.php');
require_once('stripos.php');
/* Les fonctions d’une interface base de donn&eacute;es simple */
/*function send_sql($db, $sql) 
{
	if (! $res=mysql_db_query($db, $sql)){
		echo mysql_error();
		exit;
	}
	return $res;
}*/

function tab_out($result)
{
	$n='\r\n';
	$nb=mysql_num_fields($result);
	$largeur=100/$nb.'%';
	echo '<table width="100%" border="0" cellpadding="2" cellspacing="2">'.$n;
	echo '<tr bgcolor="#D0D0D0">'.$n;
	for ($i=0;$i<$nb;$i++)
	{
		echo '<th width="'.$largeur.'"><font size="1"> ';
		echo mysql_field_name($result,$i);
		echo '</font> </th>'.$n;
	}
	echo '</tr>'.$n;
	echo '<tr>'.$n;
	$num = mysql_num_rows($result);
	for ($j = 0; $j < $num; $j++)
	{
		$ligne = mysql_fetch_array($result, MYSQL_NUM);
		echo '<tr bgcolor="#00FFFF">'.$n;
		for ($k=0;$k<$nb;$k++)
		{
			$fn=mysql_field_name($result,$k);
			echo ' <td width="'.$largeur.'"> <font size="1"> '.$ligne[$fn].' </font> </td> '.$n ;
		}
		echo '<tr>'.$n;
		echo '</tr>'.$n;
	}
	echo '</table>'.$n;
	echo $n;
}

function recup_smile() {
 /* recup des smileys + bbcode commenc&eacute; */
 global $site_smile, $site_image, $site_adress, $site_titre, $site_bbcode, $site_html;
 //if(!defined('admin2')) { define('admin2', false); }
 if(array_key_exists('smile_recup',$GLOBALS)) { $smile_recup=$GLOBALS['smile_recup']; } else { $smile_recup=NULL; }
 if($smile_recup!=NULL) return;
 $smile_recup=true;
 $GLOBALS['smile_recup']=$smile_recup;
 $smile_recup=true;
 $prefix='';
 $db='smile';
 $sql='SELECT `smile`, `image`, `titre` FROM `'.$prefix.$db.'`;';
 $res=send_sql($sql);
 $num=mysql_num_rows($res);
 $site_smile = Array();
 $site_image = Array();
 $site_adress = Array();
 $site_titre = Array();
 for($i=0;$i<$num;$i++) {
  $ligne=mysql_fetch_array($res, MYSQL_ASSOC);
  $smile=$ligne['smile'];
  $image=$ligne['image'];
  $titre=$ligne['titre'];
  $site_smile[$i]=' '.$smile.' ';
   $site_image[$i]=' <img class="smileys" src="smiley/'.$image.'" alt="smile"/> ';
  $site_adress[$i]=$image;
  $site_titre[$i]=$titre;
 }
 mysql_free_result($res);
 $site_bbcode=Array('[b]','[/b]','[i]','[/i]','[u]','[/u]');
 $site_html = Array('<span class="bold">','</span>','<span class="italic">','</span>','<span class="underline">','</span>');
 //global $site_smile, $site_image, $site_adress, $site_titre, $site_bbcode, $site_html;
 /* recup des smileys + bbcode termin&eacute; */
 return array($site_smile, $site_image, $site_adress, $site_titre, $site_bbcode, $site_html);
}

global $site_smile, $site_image, $site_adress, $site_titre, $site_bbcode, $site_html;

function transform_smile($contenu, $sens=true) {
 if(!array_key_exists('smile_recup',$GLOBALS)) {
  list($site_smile, $site_image, $site_adress, $site_titre, $site_bbcode, $site_html) = recup_smile();
 }
 else {
  global $site_smile, $site_image, $site_adress, $site_titre, $site_bbcode, $site_html;
 }
 if($sens) {
  $contenu = str_replace($site_smile, $site_image, $contenu); // smile --> image
 }
 else {
  $contenu = str_replace($site_image, $site_smile, $contenu); // image --> smile
 }
 return $contenu;
}
function transform_bbcode($contenu, $sens=true) {
 if(!array_key_exists('smile_recup',$GLOBALS)) {
  list($site_smile, $site_image, $site_adress, $site_titre, $site_bbcode, $site_html) = recup_smile();
 }
 else {
  global $site_smile, $site_image, $site_adress, $site_titre, $site_bbcode, $site_html;
 }
 global $target;
 if($sens) {
  $contenu = str_ireplace ($site_bbcode, $site_html, $contenu); // bbcode --> html
  $contenu = str_ireplace ('\n', '<br/>', $contenu);
  if($target) $contenu = eregi_replace( '\[url\]http://([^]]*)\[/url\]', '<a href="http://\\1" target="_blank">http://\\1</a>', $contenu);
  if(!$target) $contenu = eregi_replace( '\[url\]http://([^]]*)\[/url\]', '<a href="http://\\1">http://\\1</a>', $contenu);
  $contenu = eregi_replace( '\[email\]([^]]*)\[/email\]', '<a href="mailto:\\1">http://\\1</a>', $contenu);
  if($target) $contenu = eregi_replace( '\[url=http://([^]]*)\]([^]]*)\[/url\]', '<a href="http://\\1" target="_blank">\\2</a>', $contenu);
  if(!$target) $contenu = eregi_replace( '\[url=http://([^]]*)\]([^]]*)\[/url\]', '<a href="http://\\1">\\2</a>', $contenu);
  $contenu = eregi_replace( '\[img\]http://([^]]*)\[/img\]', '<img class="img" src="http://\\1" alt="" />', $contenu);
  //$contenu = eregi_replace( '\[color=([^]]*)\]([^]]*)\[/color\]', '<span style="color: \\1">\\2</span>', $contenu);
  $contenu = eregi_replace( '\[color=([^]]*)\]', '<span style="color: \\1">', $contenu);
  $contenu = str_ireplace ( '[/color]', '</span>', $contenu);
  //$contenu = eregi_replace( '\[size=([^]]*)\]([^]]*)\[/size\]', '<span style='font-size: \\1pt;'>\\2</span>', $contenu);
  $contenu = eregi_replace( '\[size=([^]]*)\]', '<span class="t\\1">', $contenu);
  $contenu = str_ireplace ( '[/size]', '</span>', $contenu);
  //$contenu = eregi_replace( '\[quote\]([^]]*)\[/quote]', '<blockquote>\\1</blockquote>', $contenu);
  $contenu = str_ireplace ('[quote]', '<div class="quote">', $contenu);
  $contenu = eregi_replace( '\[quote=([^]]*)\]', '<div class="quote_title">\\1</div>&nbsp;'."\n".'<div class="quote">', $contenu);
  //$contenu = eregi_replace( '\[quote=([^]]*)\]', '<div class="quote_title"><strong>\\1</strong> a dit </div>&nbsp;'."\n".'<div class="quote">', $contenu);
  $contenu = str_ireplace ('[/quote]', '</div>', $contenu);
 }
 else {
  $contenu = str_replace($site_html, $site_bbcode, $contenu); // html --> bbcode
 }
 return $contenu;
}

function transform($contenu, $sens=true, $transform=true) {
 if(!array_key_exists('smile_recup',$GLOBALS)) {
  list($site_smile, $site_image, $site_adress, $site_titre, $site_bbcode, $site_html) = recup_smile();
 }
 else {
  global $site_smile, $site_image, $site_adress, $site_titre, $site_bbcode, $site_html;
 }
 $contenu=strip_tags($contenu);
 $contenu=transform_smile($contenu, $sens); // smile
 $contenu=transform_bbcode($contenu, $sens); // bbcode
 $contenu=nl2br($contenu);
 return $contenu;
}

function censor($messagein,$word) {
 $messagein=eregi_replace($word,' [censure] ',$messagein);
 return $messagein;
}

function changer_specials_chars($message,$choix=0) {
 global $charset;
 $message=strip_tags($message);
 //$message=changer_encodage($message);
 //var_dump($message);//die();
 switch($choix) {
  case 0:
   $message=htmlentities($message,ENT_QUOTES,$charset);//
   //var_dump($message);//die();
   if( ini_get('magic_quotes_sybase') ) {
    //$message=addslashes(str_replace($message,'\\\'','\''));
    $message=addslashes(str_replace($message,'\\\'','\''));
    //var_dump($message);die('1');
   }
   //elseif ( !get_magic_quotes_gpc() ) {
   elseif( !ini_get('magic_quotes_gpc') ) {
    $message=addslashes($message);
    //var_dump($message);die('2');
   }
   else {
    $message=$message;
    //var_dump($message);die('3');
   }
   //var_dump($message);
   //$message=str_replace($message,'\0','');
   //var_dump($message);//die();
   $message=preg_replace('/&amp;#([0-9]*);/is','&#\\1;',$message);
   //var_dump($message);//die();
   break;
  case 1:
   $message=stripslashes($message);
   $message=html_entity_decode(htmlentities($message,ENT_QUOTES,$charset));//
   break;
  case 2:
   $message=stripslashes($message);
   $message=htmlentities($message,ENT_QUOTES,$charset);//
   break;
  case 3:
   $message=addslashes(stripslashes($message));
   $message=htmlentities($message,ENT_QUOTES,$charset);//
   break;
  case 4:
   //$message=stripslashes($message);
   $message=addslashes($message);
   //$message=html_entity_decode($message,ENT_QUOTES,$charset);//
   $message=html_entity_decode(htmlentities($message,ENT_QUOTES,$charset));//
   break;
 }
 //var_dump($message);//die();
 //$message=changer_encodage($message);
 //var_dump($message);//die();
 //$message=nl2br($message);
 //var_dump($message);//die();
 return $message;
}

function changer_encodage($texte) {
 global $charset;
 /* 'auto' signifie 'ASCII,JIS,UTF-8,EUC-JP,SJIS' */
 //print(mb_detect_encoding($texte,'auto').'<br/>\n<br/>\n');
 //return (mb_detect_encoding($texte,'auto')!=$charset)?mb_convert_encoding($texte,$charset,'UTF-8'):$texte;
 //print(mb_detect_encoding($texte,'auto'));var_dump($texte);die();
 return (mb_detect_encoding($texte,'auto')!=$charset)?mb_convert_encoding($texte,$charset,mb_detect_encoding($texte,'auto')):$texte;
 //return $texte;
 //die(mb_detect_encoding($texte,'auto'));
}

function top_smile($text='', $number=5) {
 if(!array_key_exists('smile_recup',$GLOBALS)) {
  list($site_smile, $site_image, $site_adress, $site_titre, $site_bbcode, $site_html) = recup_smile();
 }
 else {
  global $site_smile, $site_image, $site_adress, $site_titre, $site_bbcode, $site_html;
 }
 //if(defined('admin2')==true) { $before='../'; } else { }
 $before='';
 global $site_smile, $site_image, $site_adress, $site_titre, $site_bbcode, $site_html;
?>
<script type='text/javascript' src='add.php<?php if(isset($text)&&$text!='') { print('?text='.$text); } ?>'></script>
<script type='text/javascript' src='add2.php<?php if(isset($text)&&$text!='') { print('?text='.$text); } ?>'></script>
      <table class='border'>
	   <tr>
 	    <td><div class='center'><input type='button' onclick='javascript:bbstyle<?php if(isset($text)&&$text!='') print('_'.$text); ?>(0);' onmouseover="window.status='Mettre en gras le texte. Syntaxe : [b]texte[/b]'" onmouseout="window.status=''" name='B' value=' B '/></div></td>
        <td><div class='center'><input type='button' onclick='javascript:bbstyle<?php if(isset($text)&&$text!='') print('_'.$text); ?>(2);' onmouseover="window.status='Mettre en italique le texte. Syntaxe : [i]texte[/i]'" onmouseout="window.status=''" name='I' value=' I '/></div></td>
        <td><div class='center'><input type='button' onclick='javascript:bbstyle<?php if(isset($text)&&$text!='') print('_'.$text); ?>(4);'  onmouseover="window.status='Souligner le texte. Syntaxe : [u]texte[/u]'" onmouseout="window.status=''" name='U' value=' U '/></div></td>
        <td><div class='center'><input type='button' onclick='javascript:tag_image<?php if(isset($text)&&$text!='') print('__'.$text); ?>();'  onmouseover="window.status='Inserer une image. Syntaxe : [img]adresse[/img]'" onmouseout="window.status=''" name='IMG' value=' IMG '/></div></td>
        <td><div class='center'><input type='button' onclick='javascript:tag_url<?php if(isset($text)&&$text!='') print('__'.$text); ?>();'  onmouseover="window.status='Inserer un hyperlien.'" onmouseout="window.status=''" name='URL' value=' URL '/></div></td>
        <td><div class='center'><input type='button' onclick='javascript:tag_email<?php if(isset($text)&&$text!='') print('__'.$text); ?>();'  onmouseover="window.status='Ins&eacute;rer une adresse email.'" onmouseout="window.status=''" name='EMAIL' value=' EMAIL '/></div></td>
       </tr>
      </table>
<?php
}

function bottom_smile($text='', $number=10) {
 if(!array_key_exists('smile_recup',$GLOBALS)) {
  list($site_smile, $site_image, $site_adress, $site_titre, $site_bbcode, $site_html) = recup_smile();
 }
 else {
  global $site_smile, $site_image, $site_adress, $site_titre, $site_bbcode, $site_html;
 }
?>
<table class='border'>
<?php
 global $site_smile, $site_image, $site_adress, $site_titre, $site_bbcode, $site_html;
 //die($text);
 //require_once('interne/config_fonc.inc.php');
 $num=count($site_smile);
 if($num!=0&&$num>0) print('<tr align=\'center\' valign=\'middle\'>'.chr(10));
 for($i=0;$i<$num;$i++) {
  $smile=$site_smile[$i];
  $image=$site_adress[$i];
  $titre=$site_titre[$i];
  if(fmod($i,$number)==0&&$i!=0) {
   print(' </tr>'.chr(10).
   ' <tr align=\'center\' valign=\'middle\'>'.chr(10));
   //
  }
  if($text!='') { $text2='_'.$text; } else { $text2=''; }
  if(defined('admin2')==true) { $before='../'; } else { $before=''; }
  if($i<$num-1) {
   print('  <td><a class="smileys_link" href=\'javascript:insertElt'.$text2.'("'.$smile.'",4)\'><img src="'.$before.'smiley/'.$image.
   '" alt="'.$titre.'"/></a></td>'.chr(10));
  }
  else {
   $colspan = $number-fmod((int)$i,$number);
   //die($colspan);
   print('  <td colspan="'.$colspan.'"><a class="smileys_link" href=\'javascript:insertElt'.$text2.'("'.$smile.'",4)\'><img src="'.$before.
   'smiley/'.$image.'" alt="'.$titre.'"/></a></td>'.chr(10));
  }
 }
 if($num!=0&&$num>0) print(' </tr>'.chr(10));
?>
</table>
<?php
}

?>
