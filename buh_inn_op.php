<?php
 // head params
 $page_name         = 'buh_inn_op';
 $page_cap          = 'Моя бухгалтерия';
 $no_graph_head     = 1;
 $secure_page       = 1;
 $is_frame          = 1;
 $prev_page_must_be = ''; // Example: "page1,page2,page3"
 $no_refresh        = 0;
 require_once('head.php');
 // ---
?>

<script>
 var prev_color_contr='';
</script>

<div style='padding: 10;'>
<?php
 //echo $b_date;
 $b_date = str2u($b_date);
 $e_date = str2u($e_date);
 if ($filt!=0) {$query .= ' and o.cat_id = '.$filt; } else {$query = '';}
 if ($b_date!=-1) {$query .= ' and o.op_date >= '.$b_date; }
 if ($e_date!=-1) {$query .= ' and o.op_date <= '.$e_date; }
 //echo $query;
 $res=mysql_query('
 SELECT
  o.id,
  o.status,
  o.op_date,
  o.norm_date,
  o.op_vid,
  CASE WHEN o.op_vid = 1 THEN "Расход" WHEN op_vid = 2 THEN "Доход" ELSE "" END vid,
  o.op_summ,
  o.cat_id,
  o.sub_id,
  o.acc_id,
  o.pers_id,
  c.name catname
 FROM
  op o, cat c
 WHERE
  o.status = 1 and o.cat_id = c.id and o.user_id = '.$uid.'
  '.$query.'
 ORDER by op_date DESC, op_vid
 ');
 $all_in  = 0;
 $kol_in  = 0;
 $all_out = 0;
 $kol_out = 0;
 for($i=0; $i<mysql_num_rows($res); $i++) {
  if (mysql_result($res, $i, 'o.op_vid')==1) {$all_out = $all_out  + mysql_result($res, $i, 'op_summ'); $kol_out = $kol_out + 1;}
  if (mysql_result($res, $i, 'o.op_vid')==2) {$all_in  = $all_in   + mysql_result($res, $i, 'op_summ'); $kol_in  = $kol_in  + 1;}
 } //for
 $kol_in  = number_format($kol_in,  0, '.', ',');
 $kol_out = number_format($kol_out, 0, '.', ',');
 $all_in  = number_format($all_in,  2, '.', ',');
 $all_out = number_format($all_out, 2, '.', ',');
 $str_filt = '';
 if ($kol_in<>0) {
  $str_filt.='Операций дохода: '.$kol_in.' на сумму '.$all_in.' ';
 }
 if ($kol_out<>0)  {
  $str_filt .= 'Операций расхода: '.$kol_out.' на сумму '.$all_out.'';
 }
 if ($kol_in==0&&$kol_out==0)  {
  $str_filt .= 'Нет данных..';
 }
 if ($b_date==-1&&$e_date==-1) {$dat_filt .= 'Весь период';} else {$dat_filt .= 'Период:';}
 if ($b_date!=-1) {$b_date = U2str($b_date); $dat_filt .= ' c '.$b_date; }
 if ($e_date!=-1) {$e_date = U2str($e_date); $dat_filt .= ' по '.$e_date; }
 
 if (@mysql_num_rows($res)<1) { echo 'Нет операций..'; } else {
 echo "<table cellpadding=0 cellspacing=0 border=0 rules=rows width=100% style='font-size: 11; '>";
 echo "<col width=13%><col width=12%><col width=27%><col width=26%> <col width=13%><col width=7%><col width=2%>";
 for($i=0; $i<mysql_num_rows($res); $i++) {
    $temp_date = date("d/m/Y", mysql_result($res, $i, 'op_date'));
    $temp_summ = mysql_result($res, $i, 'op_summ');
    $temp_summ = number_format($temp_summ, 2, '.', ',');
    $temp_sub=quick_select('
    SELECT
     name
    FROM
     subcat
    WHERE
     id = '.mysql_result($res, $i, 'sub_id').'
   ');
   
   if (mysql_result($res, $i, 'sub_id')==-1) {
    $temp_sub = 'Нет';
    
    if (mysql_result($res, $i, 'o.pers_id')<>0) {
      //$temp_sub = mysql_result($res, $i, 'o.pers_id');
      $resp=mysql_query('
      SELECT
        name,
        r_name,
        d_name
      FROM
        person
      WHERE
        id = '.mysql_result($res, $i, 'pers_id').'
      ');
      if     (mysql_result($res, $i, 'op_vid')==1) {
        $temp_sub = mysql_result($resp, 0, 'd_name');
      }
      elseif (mysql_result($res, $i, 'o.op_vid')==2) {
        $temp_sub = mysql_result($resp, 0, 'r_name');
      } else {
        $temp_sub = 'Нет';
      }
      
    }
    
   }
   
   $temp_acc=quick_select('
    SELECT
     name
    FROM
     accounts
    WHERE
     id = '.mysql_result($res, $i, 'acc_id').'
   ');
   
   switch (mysql_result($res, $i, 'op_vid')) {
     case '1':
      $color='darkred';
      //$temp_acc='из '.$temp_acc;
      break;
     case '2': 
      $color='#249925'; 
      //$temp_acc='в '.$temp_acc;
      break;
     $color='black';
    }
   
   echo '<tr style="color: '.$color.'"
              onMouseOver="prev_color = this.style.backgroundColor; this.style.backgroundColor=\'#D2D6FF\';" 
              onMouseOut="this.style.backgroundColor=prev_color_contr;"
              id="a_gas_lnk_'.mysql_result($res, $i, 'id').'" name="a_gas_lnk_'.mysql_result($res, $i, 'id').'">
      <td style="text-align: center;">'.$temp_date.'</td>
      <td style="text-align: center;">'.mysql_result($res, $i, 'vid').'</td>
      <td style="text-align: left;">'.mysql_result($res, $i, 'catname').'</td>
      <td style="text-align: left;">'.$temp_sub.'</td>
      <td style="text-align: left;">'.$temp_acc.'</td>
      <td style="text-align: right;">'.$temp_summ.'</td>
      <td style="text-align: center;">
        <a href="javascript: top.op_del(\''.mysql_result($res, $i, 'id').'\');" style="color: red;"><b> x </b></a>
      </td>
      </tr>';
  } // for
  echo "</table>";
 }

 echo '<script>top.show_filt(\''.$str_filt.'\', \''.$dat_filt.'\');</script>';
 
?>

</div>

<?php
 // foot params
 $no_graph_foot = 0;
 require('foot.php');
 // ---
?>
