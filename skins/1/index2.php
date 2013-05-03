<?php
/* print(" <tr>".n);
 print("  <td class='index_titre'>"."<a href='viewforums.php?id=$fid'>$titre</a>"."</td>".n);
 print("  <td class='index_description'>"."$description"."</td>".n);
 print("  <td class='index_user'>"."<a href='membres.php?id=$uid'>$username</a>"."</td>".n);
 print("  <td class='index_time'>"."$date &agrave; $time"."</td>".n);
 print(" </tr>");*/
 print(' <tr>'.n);
 print('  <td class="index_icon"><img height="20" width="20" src="skins/'.$sid.'/images/open.png" alt=""/></td>'.n);
 print('  <td class="index_forum"><a href="viewforums.php?id='.$fid.'">'.$titre.'</a><br/>'.$description.'');
 if(count($sub_forums)>0) {
  $nb_subforums=count($sub_forums);
  print('<br/>'.$nb_subforums.' Sous forum');
  if($nb_subforums>1) print('s');
  print(': ');
  $last=array_pop($sub_forums);
  foreach($sub_forums as $value) {
   $fid2=$value['fid'];
   $titre2=$value['titre'];
   print('<a href="viewforums.php?id='.$fid2.'">'.$titre2.'</a>, ');
  }
  $fid2=$last['fid'];
  $titre2=$last['titre'];
  print('<a href="viewforums.php?id='.$fid2.'">'.$titre2.'</a>');
 }
 print('</td>'.n);
 print('  <td class="index_topics">'.$nb_topics.'</td>'.n);
 print('  <td class="index_posts">'.$nb_posts.'</td>'.n);
 if($empty) {
  print('  <td class="index_last">Aucun message</td>'.n);
 }
 else {
  print('  <td class="index_last">Le '.$date.' &agrave; '.$time.'<br/>dans <a href="viewtopics.php?id='.$tid.'">'.$sujet.
  '</a><br/>par <a href="membres.php?id='.$uid.'">'.$username.'</a></td>'.n);
 }
 print(' </tr>'.n);
?>
