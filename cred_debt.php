<?php
 // head params
 $page_name         = 'cred_debt';
 $page_cap          = 'Мои кредиты';
 $no_graph_head     = 1;
 $secure_page       = 1;
 $is_frame          = 1;
 $prev_page_must_be = ''; // Example: "page1,page2,page3"
 $no_refresh        = 0;
 require_once('head.php');
 // ---
?>

<script>
 var prev_color='';
</script>

<?php

// SHOW SHOW SHOW SHOW SHOW SHOW SHOW SHOW SHOW SHOW SHOW SHOW SHOW SHOW SHOW SHOW SHOW SHOW SHOW SHOW SHOW SHOW SHOW SHOW SHOW SHOW

 $res=mysql_query('
 SELECT
  d.id,
  d.status,
  d.user_id,
  d.me,
  d.person_id,
  d.debt_summ,
  p.name
 FROM
  debt d, person p
 WHERE
  d.user_id = '.$uid.' AND
  d.status = 1 AND 
  d.person_id = p.id
 ORDER BY d.debt_summ DESC
 ');
 
 
 if (@mysql_num_rows($res)<1) { 
  echo 'Данные не найдены.';
 } else {
   echo "<table border=0 rules=rows cellpadding=0 cellspacing=0 style='font-size: 11; width: 100%'>";
   echo "<col width=60%><col width=40%>";
   for($i=0; $i<mysql_num_rows($res); $i++) {
    $temp_sum = -1*mysql_result($res, $i, 'd.me')*mysql_result($res, $i, 'd.debt_summ');
    $temp_sum = number_format($temp_sum, 2, '.', ',');
   if (mysql_result($res, $i, 'd.me')==-1) {$color='darkred';} else {$color='darkgreen';}
   echo '
    <tr onMouseOver="prev_color = this.style.backgroundColor; this.style.backgroundColor=\'#D2D6FF\';" onMouseOut="this.style.backgroundColor=prev_color;"
      class="a_debt_list" style="color: '.$color.';" id="a_debt_lnk_'.mysql_result($res, $i, 'id').'" name="a_debt_lnk_'.mysql_result($res, $i, 'id').'">
        <td class="inner_td">
        <a href="javascript: DebtEdit('.mysql_result($res, $i, 'id').', \''.mysql_result($res, $i, 'name').'\')" 
           target="_top">'.mysql_result($res, $i, 'name').'</a>
        </td>
        <td class="inner_td_right">
        '.$temp_sum.'
        </td>
    </tr>';
   } // for
   echo "</table>";
 } // if (mysql_num_rows($res)<1)
 ?>
<!-- 
<div style='padding: 10;'>
</div>
-->

<?php
 // foot params
 $no_graph_foot = 0;
 require('foot.php');
 // ---
?>