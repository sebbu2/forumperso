<?php
 print(" <tr>".n);
 print("  <td class='index_titre'>"."<a href='viewforums.php?id=$fid'>$titre</a>"."</td>".n);
 print("  <td class='index_description'>"."$description"."</td>".n);
 if($empty) {
  print("  <td class='index_notopic' colspan='2'>Aucun message</td>".n);
 }
 else {
  print("  <td class='index_user'>"."<a href='membres.php?id=$uid'>$username</a>"."</td>".n);
  print("  <td class='index_time'>"."$date &agrave; $time"."</td>".n);
 }
 print(" </tr>");
?>
