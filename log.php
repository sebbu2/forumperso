<?php
define('n', "\r\n");
$page='log.php';
$PHP_SELF=$_SERVER['PHP_SELF'];
require_once('db_config.inc.php');
require_once('fonc.php');
include_once('skins/'.sid.'/header.php');
if( isset($_REQUEST['act']) ) { $act=$_REQUEST['act']; } else { $act=''; }
if( $act=='logout' ) {
 if($logout) { print('<p>Vous avez bien &eacute;t&eacute; d&eacute;connect&eacute;.</p>'); }
 else { print('<p>Echec de la d&eacute;connection.</p>'); }
}
elseif( $act=='login' ) {
 if($login) { print('<p>Vous avez bien &eacute;t&eacute; connect&eacute;.</p>'); }
 elseif( in_array('ban',$opt2) ) { print('<p>Vous êtes banni du forum. Contacter un administrateur si ce bannissement vous semble sans raison.</p>'); }
 else { print('<p>Echec de la connection.</p>'); }
}
elseif( $act=='log' ) {
 print('<form action="log.php?act=login" method="post">');
 print('<table class="index_table_top">'.n);
 print(' <tr>'.n);
 print('  <td class="left">
<input type="text" name="user"/> LOGIN<br/>
<input type="password" name="pass"/> PASSWORD<br/>
<input type="submit" value="Se connecter"/></td>'.n);
 print(' </tr>'.n);
 print('</table></form><br/>'.n);
}
else {
 print('<p>Pas de &ccedil;a chez moi !</p>');
}
include_once('skins/'.sid.'/footer.php');
?>
