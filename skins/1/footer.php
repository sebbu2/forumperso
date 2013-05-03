</td>
  <td class="cell2_3"><img src="skins/<?php echo sid; ?>/images/right_h.jpg" alt=""/></td>
 </tr>
 <tr class="row4">
  <td class="design_left"><img src="skins/<?php echo sid; ?>/images/left_b.jpg" alt=""/></td>
  <td class="design_milieu"><div class="center">
<table class="design_stats">
 <tr>
  <td class="stats_h">&nbsp; Statistiques :</td>
  <td rowspan="2" class="stats_d">
  <object type="application/x-shockwave-flash" data="horloge.swf" width="100" height="100">
<param name="movie" value="horloge.swf"/>
<!--img src="images/header_Img0.jpg" width="800" height="119" alt=""/-->
</object></td>
 </tr>
 <tr>
  <td class="stats_b"><?php show_users2($users_total, $users_uid_total, $users_grade_total); ?>
<br/>&nbsp;<!--5 utilisateur(s) actif(s) durant les 5 derni&egrave;res minutes--><?php if(grade=='administrateur' || grade=='moderateur' ) {
 echo '<a href="admin.php">Administration</a>';
} ?></td>
 </tr>
</table></div></td>
  <td class="design_right"><img src="skins/<?php echo sid; ?>/images/right_b.jpg" alt=""/></td>
 </tr>
</table>
<div class="design_bas">[ Temps d'Ex&eacute;cution du Script: <?php
$repere_2=getmicrotime(); // repere 2
$generation=$repere_2-$repere_1; // temps de g&eacute;n&eacute;ration
$nombre = number_format($generation, 4, ',', ' ');
echo $nombre;
?> ]&nbsp;&nbsp; [ <?php echo $count_requete; ?> requ&ecirc;tes utilis&eacute;es ]&nbsp;&nbsp; [ GZIP <?php
if(isset($gz) && $gz) {
 print("Activ&eacute;");
}
else {
 print("Desactiv&eacute;");
}
?> ]<br/>
Reproduction interdite - Tous droits r&eacute;serv&eacute;s - Forum by Sebbu - Skin by The_Duc</div>

</body>
</html><?php mysql_close($link); ?>
