<?php
if(!defined('n')) define('n', "\r\n");
$page="admin.php";
$PHP_SELF=$_SERVER['PHP_SELF'];
require_once('db_config.inc.php');
require_once('fonc.php');
include_once('skins/'.sid.'/header.php');
if( isset($_REQUEST['page']) && is_string($_REQUEST['page']) ) {
 $page=$_REQUEST['page'];
}
else {
 $page='home';
 /*print("<p>pas de &ccedil;a chez moi !</p>");
 include_once("skins/".sid."/footer.php");
 die();*/
}
if( grade != 'administrateur' && grade != 'moderateur' ) {
 print('<p>pas de &ccedil;a chez moi !</p>');
 include_once('skins/'.sid.'/footer.php');
 die();
}

if( !file_exists('admin/'.$page.'.php') ) {
 print('<p>pas de &ccedil;a chez moi !</p>');
 include_once('skins/'.sid.'/footer.php');
 die();
}

include_once('admin/'.$page.'.php');

include_once('skins/'.sid.'/footer.php');
?>
