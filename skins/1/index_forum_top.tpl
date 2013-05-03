  <table class="index_table">
   <tr class='center'>
    <td class='index_icon'>&nbsp;</td>
    <td class='index_forum'>Forum</td>
    <td class='index_topics'>Sujets</td>
    <td class='index_posts'>R&eacute;ponses</td>
    <td class='index_last'>Dernier message</td>
    </tr>
{{foreach $forum}}
    <tr>
     <td class="index_icon"><img height="20" width="20" src="skins/{SID}/images/open.png" alt=""/></td>
     <td class="index_forum"><a href="viewforums.php?id={fid}">{title}</a><br/>{description}
{{if is_array $subforum}}
<br/>{{nb_subforum}} Sous {{if $nb_subforum > 1}}
forums
{{else}}
forum
{/{if}} {-1{foreach $subforum}}
 <a href="viewforums.php?id={{fid2}}">{{titre2}}</a>,
{{last}}
 <a href="viewforums.php?id={{fid2}}">{{titre2}}</a>
{-1/{foreach}}
{{else}}
&nbsp;
{/{if}}</td>
     <td class="index_topics">{nb_topic}</td>
     <td class="index_posts">{nb_post}</td>
     <td class="index_last">Le {date} &agrave; {heure}<br/>dans <a href="viewtopics.php?id={tid}">{sujet}</a><br/>par <a href="membres.php?id={uid}">{username}</a></td>
    </tr>
{/{foreach $forum}}
  </table>