<?php
 // head params
 $page_name         = 'cred_bal';
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
    id,
    status,
    user_id,
    acc_id,
    bal_date,
	ndat,
    bx,
    debet,
    credit,
    isx,
    isx_902
   FROM
    balance
   WHERE
    status = 1 and user_id = '.$uid.' and acc_id = 902 and (debet <> 0 or credit <> 0 or isx_902 <> 0)
   ORDER BY bal_date DESC
 ');
 
 
 if (@mysql_num_rows($res)<1) { 
  echo 'Данные не найдены.';
 } else {
   echo "<table border=0 rules=rows cellpadding=0 cellspacing=0 style='font-size: 11; width: 100%'>";
   echo "<col width=20%><col width=40%><col width=40%>";
   for($i=0; $i<mysql_num_rows($res); $i++) {
    $temp_sum = -1*mysql_result($res, $i, 'isx');
    $temp_sum = number_format($temp_sum, 2, '.', ',');
    if ($temp_sum==0) {$temp_sum='';}
    $temp_isx = -1*mysql_result($res, $i, 'isx_902');
    $temp_isx = number_format($temp_isx, 2, '.', ',');
    if ($temp_isx==0) {$temp_isx='';}
    $temp_date = date("d/m/Y", mysql_result($res, $i, 'bal_date'));
   echo '
    <tr onMouseOver="prev_color = this.style.backgroundColor; this.style.backgroundColor=\'#D2D6FF\';" onMouseOut="this.style.backgroundColor=prev_color;"
      class="a_debt_list" style="color: darkblue" id="a_debt_lnk_'.mysql_result($res, $i, 'id').'" name="a_debt_lnk_'.mysql_result($res, $i, 'id').'">
        <td class="inner_td">
        '.$temp_date.'
        </td>
        <td class="inner_td_right">
        '.$temp_sum.'
        </td>
        <td class="inner_td_right">
        '.$temp_isx.'
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