<?php
if($page=='profil.php') {
  $destination='avatars';
  //$a_image=$image;
  //$a_description=$description;
  // Taille maximale autoris&eacute;e en octets
  $taille=409600;
//  print('<pre>');print_r($_FILES);print('</pre>');die();
  $file=Array('avatar_file');
  $value='avatar_file';
//  foreach($file as $value) {
   if(isset($_FILES[$value]['type'])) $userfile_type=$_FILES[$value]['type'];
   if(isset($_FILES[$value]['error'])) $userfile_error=$_FILES[$value]['error'];
   if(isset($_FILES[$value]['name'])) $userfile_name=$_FILES[$value]['name'];
   if(isset($_FILES[$value]['size'])) $userfile_size=$_FILES[$value]['size'];
   if(isset($_FILES[$value]['tmp_name'])) $tmp_name=$_FILES[$value]['tmp_name'];
   //if(isset($_FILES[$value])) $userfile=$_FILES[$value];
   //print_r($_FILES);die();
   $userfile='';
   if(isset($userfile)) $userfile=$tmp_name;
   
   if(isset($userfile)) $userfile=str_replace('\\','/',$userfile);
   //print_r($userfile);die();
   if(substr($userfile_type,0,6)!='image/') { print('<h2>Vous n\'avez pas s&eacute;lectionn&eacute; une image.</h2>'); break; }
   if ($userfile_size!=0) {$taille_ko=$userfile_size/1024;} else {$taille_ko=0;}
   if ($userfile=='none') {$message='<h2>Vous n\'avez pas s&eacute;lectionn&eacute; de fichier.</h2>';}
   if ($userfile_size>$taille) {
    if($taille!=0) {
     $taille_max_ko=$taille/1024;
    }
    $message='<h2>Votre fichier est trop gros ('.$taille_max_ko.' ko max)</h2>';
   }
   if ($userfile!='none' && $userfile_size<$taille && $userfile_size!=0) {
    $userfile=stripslashes($userfile); 		// pour windows
    /*$name=explode('.',$userfile_name);
    $ext=$name[count($name)-1];
    die($ext);*/
	//die($userfile.'<br>'.'$destination/$userfile_name');
	//$userfile_name=$id.'-manche'.($key+1).'.jpg';
	//die($userfile_name);
	//die($key.':'.$value);
	//print('copy(\'$userfile\', \'$destination/$userfile_name\');');die();
	$dest=$destination.'/'.$userfile_name;
	$name=explode('.',$userfile_name);
	$name_c=count($name);
	$ext=$name[$name_c-1];
	$dest=$destination.'/'.login.'.'.$ext;
	//die('$dest');
    if (!copy($userfile, $dest)) {
     $message='<br/>Probleme de transfert !<br/>';
    }
    else {
     $message='<h2>Fichier enregistr&eacute;</h2>';
    }
	//die();
   }
   //printf ('$message<br>taille=%.2f ko.',$taille_ko);
   print($message.'');
//   print('<img src='img2.php?imgmini=$dest' alt='$dest'><br>'');
   //die('now cr&eacute;ation miniature en construction.');
//  }
}
else {
 print('Pas de &ccedil;a chez moi !');include_once('skins/'.sid.'/footer.php');die();
}
?>
