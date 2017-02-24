<?php
 // head params
 $page_name         = 'reports';
 $page_cap          = '־עקועû';
 $show_cap          = 1;
 $no_graph_head     = 0;
 $is_frame          = 0;
 $prev_page_must_be = ''; // Example: "page1,page2,page3"
 $no_refresh        = 0;
 require('head.php');
 // ---
 // page
 ?>
 <div valign=center>
 <table border=0 cellspacing=0 cellpadding=0 width=100% valign=top > <!-- I -->
 <col width=5%><col width=90%><col width=5%>
 <tr height=20>
  <td></td>
  <td align=left ><br>
  </td>
  <td></td>
 </tr>
 <tr height=20>
  <td></td>
  <td align=left ><span style='font-size: 16; font-weight: bold; font-style: italic; color: #868bff;'>
  ־עקועû</span>
  </td>
  <td></td>
 </tr>
 
 
 <?php
 $res=mysql_query('
 SELECT
  DISTINCT
   r.id
  ,r.name
  ,r.ru_name
  ,CASE WHEN r.params=1 THEN 1 ELSE 0 END params
  FROM
   reports r
  WHERE
   r.status=1
 ');

  for($i=0; $i<mysql_num_rows($res); $i++) {
    echo '
    <tr height=20>
      <td></td>
      <td align=left ><a href="report.php?rep='.mysql_result($res, $i, 'name').'&params='.mysql_result($res, $i, 'params').'" class="report_lnk">'.mysql_result($res, $i, 'ru_name').'</a></td>
      <td></td>
    </tr>';
  }
 ?>
 </table>
 </div>
 <?php
  // ---
 // foot params
 $no_graph_foot = 0;
 require('foot.php');
 // ---
?>
