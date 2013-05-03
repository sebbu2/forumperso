<?xml version="1.0" encoding="{CHARSET}"?>
{HEADER}
<html>
<head>
 <title>{TITLE}</title>
 <meta http-equiv="Content-Type" content="text/html; charset={charset}"/>
 <meta http-equiv="Content-Language" content="fr"/>
 <link type="text/css" rel="stylesheet" href="skins/{SID}/style.css"/>
</head>
<body>

<table class='table1'>
 <tr class="row1">
  <td colspan="3" class="center"><img src="skins/{SID}/images/haut.jpg" alt=""/></td>
 </tr>
 <tr class="row2">
  <td class="cell2_1"><img src="skins/{SID}/images/left_h.jpg" alt=""/></td>
  <td class="design_contenu">
  <table class="design_top">
   <tr>
    <td>Forum Ayumi French
- <a href="index.php">Index du forum</a>
- <a href="search.php">Recherche</a>
- <a href="stats.php">Statistiques</a>
- <a href="membres.php">Liste des membres</a></td>
   </tr>
   <tr>
    <td>Connect&eacute; en tant que : {LOGIN}&nbsp;&nbsp;&nbsp;&nbsp;
{{if $UID ne 0}}
<a href="log.php?act=logout">Se d&eacute;connecter</a> - <a href="profil.php">Mon profil</a> - <a href="mail.php">Messagerie priv&eacute;e</a> ({NB_MAIL})
{{else}}
<a href="log.php?act=log">Se connecter</a> - <a href="register.php">S'enregistrer</a>
{/{if}}</td>
   </tr>
  </table><br/>
{{{index_forum_top}}}
  </td>
  <td class="cell2_3"><img src="skins/{SID}/images/right_h.jpg" alt=""/></td>
 </tr>
 <tr class="row4">
  <td class="design_left"><img src="skins/{SID}/images/left_b.jpg" alt=""/></td>
  <td class="design_milieu"><div class="center">
  <table class="design_stats">
   <tr>
    <td class="stats_h">&nbsp; Statistiques :</td>
    <td rowspan="2" class="stats_d">
{{if $HORLOGE eq true}}
<object type="application/x-shockwave-flash" data="horloge.swf" width="100" height="100">
<param name="movie" value="horloge.swf"/>
<!--img src="images/header_Img0.jpg" width="800" height="119" alt=""/-->
</object>
{{else}}
&nbsp;
{/{if}}</td>
   </tr>
   <tr>
    <td class="stats_b">Il y a en tout {online_user} utilisateur en ligne :: {online_user_reg} Enregistr&eacute; et {online_user_inv} Invit&eacute;<br/>Utilisateur enregistr&eacute; : {online_list_users}<br/>&nbsp;<a href="admin.php">Administration</a></td>
   </tr>
  </table></div></td>
  <td class="design_right"><img src="skins/{SID}/images/right_b.jpg" alt=""/></td>
 </tr>
</table>

<div class="design_bas">[ Temps d'Ex&eacute;cution du Script: {EXEC_TIME} ]&nbsp;&nbsp; [ {SQL_REQUEST} requ&ecirc;tes utilis&eacute;es ]&nbsp;&nbsp; [ GZIP Activ&eacute; ]<br/>
Reproduction interdite - Tous droits r&eacute;serv&eacute;s - Forum by Sebbu - Skin by The_Duc</div>

</body>
</html>