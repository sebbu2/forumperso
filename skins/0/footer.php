
<br/><table class='row1'>
 <tr>
  <td class="left"><?php show_users2($users_total, $users_uid_total, $users_grade_total); ?>
<br/>&nbsp;<!--5 utilisateur(s) actif(s) durant les 5 derni&egrave;res minutes--><?php if(grade=='administrateur' || grade=='moderateur' ) {
 echo '<a href="admin.php">Administration</a>';
} ?></td>
  <td rowspan='2'><object
type="application/x-shockwave-flash" data="horloge.swf" 
width="100" height="100">
<param name="movie" value="horloge.swf"/>
<!--img src="images/header_Img0.jpg" width="800" height="119" alt=""/-->
</object></td>
  </tr>
 <tr>
  <td class="center">[ Temps d'Ex&eacute;cution du Script: <?php
$repere_2=getmicrotime(); // repere 2
$generation=$repere_2-$repere_1; // temps de g&eacute;n&eacute;ration
$nombre = number_format($generation, 4, ',', ' ');
echo $nombre;
?> ] &nbsp; [ <?php echo $count_requete; ?> requ&ecirc;tes utilis&eacute;es ] &nbsp; [ GZIP <?php
if(isset($gz) && $gz) {
 print("Activ&eacute;");
}
else {
 print("Desactiv&eacute;");
}
?> ] </td>
 </tr>
</table>
</div>

</body>
</html><?php mysql_close($link); ?>
