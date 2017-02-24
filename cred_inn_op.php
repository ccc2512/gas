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
 $cur_day   = date("d");
 $cur_month = date("m");
 $cur_year  = date("Y");
 if ($cur_month==12) {$calc_month = 1;  $calc_year = $cur_year + 1;} else {$calc_month = $cur_month + 1; $calc_year = $cur_year;}
 $calc_date  = $cur_day.'.'.$calc_month.'.'.$calc_year;
 $calc_date  = str2U($calc_date);
 //echo "<script>alert('calc_date=".$cur_date."');</script>";
 //$beg_date   = str2U('05.11.2009');
 //echo $beg_date;
 $resb=mysql_query('
   SELECT
    id,
    name,
    begin_date,
    summa,
    stavka,
    gash_sum
   FROM
    banks
   WHERE
    status = 1 and user_id = '.$uid.'
 ');
 //echo "<script>alert('num_rows=".mysql_num_rows($resb)."');</script>";
 for($b=0; $b<mysql_num_rows($resb); $b++) {
    $temp_bank = mysql_result($resb, $b, 'id');
    $resc=mysql_query('
     SELECT
      id,
      plat_date,
      plat_summ
     FROM
      mycred
     WHERE
      status = 1 and user_id = '.$uid.' and bank_id = '.$temp_bank.' and plat_summ = 0
     ORDER BY plat_date
    ');
    $temp_date = @mysql_result($resc, 0, 'plat_date');
    if ($temp_date>$calc_date) {$calc_date = $temp_date;}
 }
 $res=mysql_query('
 SELECT
  m.id,
  m.status,
  m.prev_date,
  m.plat_date,
  m.days,
  m.plat_summ,
  m.perc_summ,
  m.plan_summ,
  m.oz,
  m.bank_id,
  CASE WHEN m.id = "'.$mid.'" THEN "_a" ELSE "" END style,
  b.name b_name
 FROM
  mycred m, banks b
 WHERE
  m.status = 1 and m.bank_id = b.id and m.user_id = '.$uid.' and m.plat_date <= '.$calc_date.'
 ORDER by plat_date DESC
 ');
 
 if (@mysql_num_rows($res)<1) { echo 'Нет операций..'; } else {
 echo "<table cellpadding=0 cellspacing=0 border=0 rules=rows width=100% style='font-size: 11; '>";
 echo "<col width=15%><col width=15%><col width=15%> <col width=5%> <col width=15%><col width=15%><col width=15%> <col width=5%>";
 for($i=0; $i<mysql_num_rows($res); $i++) {
    
    $temp_plat_date = date("d/m/Y", mysql_result($res, $i, 'plat_date'));
    $temp_prev_date = date("d/m/Y", mysql_result($res, $i, 'prev_date'));
    
    if (mysql_result($res, $i, 'plat_summ')==0) {
      $temp_plat_summ = mysql_result($res, $i, 'plan_summ');
    } 
    else {
      $temp_plat_summ = mysql_result($res, $i, 'plat_summ');
    }
    $temp_plat_summ = number_format($temp_plat_summ, 2, '.', ',');
    
    $temp_perc_summ = mysql_result($res, $i, 'perc_summ');
    $temp_perc_summ = number_format($temp_perc_summ, 2, '.', ',');
    
    $temp_oz = mysql_result($res, $i, 'oz');
    $temp_oz = number_format($temp_oz, 2, '.', ',');
    
    switch (mysql_result($res, $i, 'bank_id')) {
     case '1':
      //$backcolor='#fbfbd8';
      $backcolor='white';
      //$temp_acc='из '.$temp_acc;
      break;
     case '2': 
      $backcolor='#d8fbd8'; 
      //$temp_acc='в '.$temp_acc;
      break;
     $backcolor='white';
    }
    if (mysql_result($res, $i, 'style')=='_a') {$backcolor='yellow';}
    if (mysql_result($res, $i, 'plat_summ')==0) {$color='darkred';} else {$color='darkgreen';}
    //#fbfbd8 = желтый #d8fbd8 = зеленоватый #d8fbfb синеватый #D2D6FF = сиреневый
    /*
    echo '<tr style="color: '.$color.'; background-color: '.$backcolor.';"
              onMouseOver="prev_color_contr = this.style.backgroundColor; this.style.backgroundColor=\'#D2D6FF\';" 
              onMouseOut="this.style.backgroundColor=prev_color_contr;"
              
              onMouseOver="this.style.fontWeight=\'bold\';" 
              onMouseOut="this.style.fontWeight=\'normal\';"
              
              id="a_gas_lnk_'.mysql_result($res, $i, 'id').'" name="a_gas_lnk_'.mysql_result($res, $i, 'id').'">
    */
    echo '<tr style="color: '.$color.'; background-color: '.$backcolor.';"
              
              class="a_cred_list'.mysql_result($res, $i, 'style').'"
              id="a_cred_lnk_'.mysql_result($res, $i, 'id').'" name="a_cred_lnk_'.mysql_result($res, $i, 'id').'">
      <td style="text-align: left;">'.mysql_result($res, $i, 'b_name').'</td>
      <td style="text-align: center;">'.$temp_prev_date.'</td>
      <td style="text-align: center;">'.$temp_plat_date.'</td>
      <td style="text-align: right;">'.mysql_result($res, $i, 'days').'</td>
      <td style="text-align: right;">'.$temp_plat_summ.'</td>
      <td style="text-align: right;">'.$temp_perc_summ.'</td>
      <td style="text-align: right;">'.$temp_oz.'</td>
      <td style="text-align: center;">
        <a href="javascript: RecEdit('.mysql_result($res, $i, 'id').', \''.$temp_plat_date.'\', \''.$temp_plat_summ.'\')" 
           target="_top">Edit</a>
      </td>
      
      </tr>';
  } // for
  echo "</table>";
 }

 ?>

</div>

<?php
 // foot params
 $no_graph_foot = 0;
 require('foot.php');
 // ---
?>
