<?php
if(!defined('n')) define("n", "\r\n");
$page="home.php";
$PHP_SELF=$_SERVER['PHP_SELF'];
require_once("db_config.inc.php");
require_once("fonc.php");
include_once("skins/".sid."/header.php");
if( isset($_REQUEST["id"]) && is_numeric($_REQUEST["id"]) ) {
 $id=$_REQUEST["id"];
}
else {
 /*print("<p>pas de &ccedil;a chez moi !</p>");
 include_once("skins/".sid."/footer.php");
 die();*/
}
if( !grade=='administrateur' && !grade=='moderateur' ) {
 print("<p>pas de &ccedil;a chez moi !</p>");
 include_once("skins/".sid."/footer.php");
 die();
}

print('Bienvenue sur l&#039;administration du forum.');
print('<br/>'.n);
print('<br/>'.n);
if( grade=='administrateur' ) {
 print('<a href="'.$PHP_SELF.'?page=fix_index">Fixer s&#039;il y a des &eacute;rreurs sur l&#039;index (forum oubli&eacute; par exemple)</a>'.
 ' attention: se base sur viewforums');
 print('<br/>'.n);
 print('<a href="'.$PHP_SELF.'?page=fix_forums">Fixer s&#039;il y a des &eacute;rreurs sur viewforums (posts ou topics)</a>');
 print('<br/>'.n);
 print('<a href="'.$PHP_SELF.'?page=fix_spchars">Fixer les accents</a>');
 print('<br/>'.n);
}
print('<a href="'.$PHP_SELF.'?page=gest_forums">Gestion des forums</a>');
print('<br/>'.n);

include_once("skins/".sid."/footer.php");
?>
