<?php
if(!defined('n')) define("n", "\r\n");
$page="gest_forums.php";
$PHP_SELF=$_SERVER['PHP_SELF'];
require_once("db_config.inc.php");
require_once("fonc.php");
include_once("skins/".sid."/header.php");

if( !grade=='administrateur' ) { //&& !grade=='moderateur' ) {
 print("<p>pas de &ccedil;a chez moi !</p>");
 include_once("skins/".sid."/footer.php");
 die();
}
include_once("skins/".sid."/footer.php");
?>
