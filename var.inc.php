<?php
//include_once('online.php');
function getmicrotime(){
 list($usec, $sec) = explode(' ',microtime());
 return ((float)$usec + (float)$sec);
}
$repere_1=getmicrotime();                       // repere 1
/*if( strcasecmp(ini_get('zlib.output_compression'),'On')!=0 && ini_get('zlib.output_compression')!=1 ) {
	$gz=ob_start('ob_gzhandler');               // compression gzip
}//*/
//$adress_site='http://www.localhost.com/~sebbu'; // adresse du site
$adress_site='http://localhost/forumperso'; // adresse du site
$email_change='validate';                       // validate/active lors du changement d'email
$new_user_email='validate';                     // validate/active lors de l'enregistrement
$meta=true;                                     // false par d&eacute;faut
$target=true;                                   // false par d&eacute;faut
$charset='UTF-8';                               // encodage utili&eacute; sur le forum
?>
