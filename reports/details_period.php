<?php

//$s_date1 = '01.01.2012';
$first_date_s = $s_date1;
$first_date_u = date('U',  mktime(0, 0, 0, substr($first_date_s,3,2)  , substr($first_date_s,0,2), substr($first_date_s,6,4)));

//$s_date2 = '31.01.2012';
$second_date_s = $s_date2;
$second_date_u = date('U',  mktime(0, 0, 0, substr($second_date_s,3,2)  , substr($second_date_s,0,2), substr($second_date_s,6,4)));

$current_date = date('d/m/Y H:i:s', time());

$d_date1 = mktime(0, 0, 0, substr($s_date1,3,2), substr($s_date1,0,2), substr($s_date1,6,4));
$d_date2 = mktime(0, 0, 0, substr($s_date2,3,2), substr($s_date2,0,2), substr($s_date2,6,4));

$fname1 = date("Ymd", $d_date1);
$fname2 = date("Ymd", $d_date2);

?>

<table rules=all cellpadding=0 cellspacing=0 class='rep_table'>
<tr class="rep_table_cap">
<td width=50></td>
<td width=200></td>
<td width=200></td>
<td width=100></td>
</tr>
<?php
  // По категориям По категориям По категориям По категориям По категориям По категориям По категориям По категориям По кат
  echo '
    <tr class="inner_td_bg">
      <td align=center colspan=4 class="inner_td">По категориям:</td>
    </tr>
    ';
  $res3=mysql_query('
  SELECT
     o.id, o.op_date, o.op_summ, c.id, c.name catname, o.sub_id, s.name subname, c.isoborot, sum(o.op_summ) sumop
  FROM
     op o, cat c, subcat s
  WHERE
    o.status = 1
    and o.user_id = '.$uid.' and c.user_id = '.$uid.' and s.user_id = '.$uid.'
    and o.op_vid = 1
    and c.isoborot = 1
    and c.id = o.cat_id and s.id = o.sub_id
    and o.op_date >= '.$first_date_u.' and o.op_date <= '.$second_date_u.'
  GROUP BY o.cat_id ORDER BY sumop DESC
  ');
  
  $sum_op = 0;
  $all_sum_op = 0;
  for($i=0; $i<mysql_num_rows($res3); $i++) {
    $sum_op = mysql_result($res3, $i, 'sumop');
    $all_sum_op = $all_sum_op + $sum_op;
    $sum_op = number_format($sum_op,  2, '.', ',');
    echo '
      <tr class="rep_table">
        <td align=left class="inner_td"></td>
        <td align=left  colspan=2 class="inner_td">'.mysql_result($res3, $i, 'catname').'</td>
        <td align=right class="inner_td">'.$sum_op.'</td>
      </tr>';

  } // for
  
  $all_sum_op = number_format($all_sum_op,  2, '.', ',');
  
  echo '
    <tr class="inner_td_bg">
      <td align=right colspan=3 class="inner_td">Итого:</td>
      <td align=right class="inner_td">'.$all_sum_op.'</td>
    </tr>
    <tr></tr>
    ';
  // По категориям По категориям По категориям По категориям По категориям По категориям По категориям По категориям По кат
  echo '
    <tr>
      <td align=center colspan=4 >&nbsp;</td>
    </tr>
    ';
  // По подкатегориям По подкатегориям По подкатегориям По подкатегориям По подкатегориям По подкатегориям По подкатегориям 
  echo '
    <tr class="inner_td_bg">
      <td align=center colspan=4 >По подкатегориям:</td>
    </tr>
    ';
  $res2=mysql_query('
  SELECT
     o.id oid, o.op_date, o.op_summ, c.id, c.name catname, o.sub_id, s.name subname, c.isoborot, sum(o.op_summ) sumop
  FROM
     op o, cat c, subcat s
  WHERE
    o.status = 1
    and o.user_id = '.$uid.' and c.user_id = '.$uid.' and s.user_id = '.$uid.'
    and o.op_vid = 1
    and c.isoborot = 1
    and c.id = o.cat_id and s.id = o.sub_id
    and o.op_date >= '.$first_date_u.' and o.op_date <= '.$second_date_u.'
  GROUP BY o.cat_id, o.sub_id ORDER BY catname
  ');
  
  $sum_op = 0;
  $all_sum_op = 0;
  for($i=0; $i<mysql_num_rows($res2); $i++) {
    $sum_op = mysql_result($res2, $i, 'sumop');
    $all_sum_op = $all_sum_op + $sum_op;
    $sum_op = number_format($sum_op,  2, '.', ',');
    echo '
      <tr class="rep_table">
        <td align=left  class="inner_td"></td>
        <td align=left  class="inner_td">'.mysql_result($res2, $i, 'catname').'</td>
        <td align=left  class="inner_td">'.mysql_result($res2, $i, 'subname').'</td>
        <td align=right class="inner_td">'.$sum_op.'</td>
      </tr>';

  } // for
  
  $all_sum_op = number_format($all_sum_op,  2, '.', ',');
  
  echo '
    <tr class="inner_td_bg">
      <td align=right colspan=3 >Итого:</td>
      <td align=right >'.$all_sum_op.'</td>
    </tr>
    ';
  // По подкатегориям По подкатегориям По подкатегориям По подкатегориям По подкатегориям По подкатегориям По подкатегориям 
  echo '
    <tr>
      <td align=center colspan=4 >&nbsp;</td>
    </tr>
    <tr class="inner_td_bg">
      <td align=center width=50>Дата</td>
      <td width=200>Категория</td>
      <td width=200>Подкатегория</td>
      <td align=center width=100>Сумма</td>
    </tr>
    ';
  // Расшифровка Расшифровка Расшифровка Расшифровка Расшифровка Расшифровка Расшифровка Расшифровка Расшифровка 
  $res=mysql_query('
  SELECT
     o.id, o.op_date opdate, o.op_summ opsum, c.name catname, o.sub_id, s.name subname, c.isoborot
  FROM
     op o, cat c, subcat s
  WHERE
     o.status = 1
     and o.user_id = '.$uid.' and c.user_id = '.$uid.' and s.user_id = '.$uid.'
     and o.op_vid = 1
     and c.isoborot = 1
     and c.id = o.cat_id and s.id = o.sub_id 
     and o.op_date >= '.$first_date_u.' and o.op_date <= '.$second_date_u.'
  ORDER BY o.op_date, o.cat_id, o.sub_id
  ');
  
  $sum_op = 0;
  $all_sum_op = 0;
  
  for($i=0; $i<mysql_num_rows($res); $i++) {
    $temp_op_dat = date("d/m/Y", mysql_result($res, $i, 'opdate'));
    $sum_op = mysql_result($res, $i, 'opsum');
    $all_sum_op = $all_sum_op + $sum_op;
    $sum_op = number_format($sum_op,  2, '.', ',');
    echo '
      <tr class="rep_table">
        <td class="inner_td">'.$temp_op_dat.'</td>
        <td class="inner_td">'.mysql_result($res, $i, 'catname').'</td>
        <td class="inner_td">'.mysql_result($res, $i, 'subname').'</td>
        <td align=right class="inner_td">'.$sum_op.'</td>
      </tr>';

  } // for
  
  $all_sum_op = number_format($all_sum_op,  2, '.', ',');
  echo '
    <tr class="inner_td_bg">
      <td align=right colspan=3 >Итого:</td>
      <td align=right>'.$all_sum_op.'</td>
    </tr>
    <tr class="rep_table">
    </tr>
    ';
  // Расшифровка Расшифровка Расшифровка Расшифровка Расшифровка Расшифровка Расшифровка Расшифровка Расшифровка 
   
  
  
  $txt_date = ' с '.$first_date_s.' по '.$second_date_s.'.';
  
  echo '<script>top.show_date(\''.$txt_date.'\', 1);</script>';
  
  
?>
</table>
