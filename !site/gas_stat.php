<?php
 // head params
 $page_name         = 'gas_stat';
 $page_cap          = 'Учет расхода бензина';
 $no_graph_head     = 1;
 $secure_page       = 1;
 $is_frame          = 1;
 $prev_page_must_be = ''; // Example: "page1,page2,page3"
 $no_refresh        = 0;
 require_once('head.php');
 // ---
?>


<div style='padding: 10;'>

 <?php

 $thisyear = $period;
 //$thisyear = '10';
 $res=mysql_query('
 SELECT
  id
 ,status
 ,z_date
 ,summ
 ,litr
 ,odo
 ,next_odo
 ,rubl2litr
 ,km  
 ,litr2100km
 ,rubl2km
 FROM
  gas
 WHERE
  status = 1 and user_id = "'.$uid.'" and km > 0 
 ORDER BY z_date Desc
 ');

 $all_km   = 0;
 $all_litr = 0;
 $all_rubl = 0;
 $avr_l2km = 0;
 $avr_r2km = 0;
 
 $km1 = 0;
 $km2 = 0;
 $km3 = 0;
 $km4 = 0;
 $km5 = 0;
 $km6 = 0;
 $km7 = 0;
 $km8 = 0;
 $km9 = 0;
 $km10 = 0;
 $km11 = 0;
 $km12 = 0;
 $kmthisyear = 0;
 
 $litr1 = 0;
 $litr2 = 0;
 $litr3 = 0;
 $litr4 = 0;
 $litr5 = 0;
 $litr6 = 0;
 $litr7 = 0;
 $litr8 = 0;
 $litr9 = 0;
 $litr10 = 0;
 $litr11 = 0;
 $litr12 = 0;
 $litrthisyear = 0;
 
 $rubl1 = 0;
 $rubl2 = 0;
 $rubl3 = 0;
 $rubl4 = 0;
 $rubl5 = 0;
 $rubl6 = 0;
 $rubl7 = 0;
 $rubl8 = 0;
 $rubl9 = 0;
 $rubl10 = 0;
 $rubl11 = 0;
 $rubl12 = 0;
 $rublthisyear = 0;
 
 $l2km1 = 0;
 $l2km2 = 0;
 $l2km3 = 0;
 $l2km4 = 0;
 $l2km5 = 0;
 $l2km6 = 0;
 $l2km7 = 0;
 $l2km8 = 0;
 $l2km9 = 0;
 $l2km10 = 0;
 $l2km11 = 0;
 $l2km12 = 0;
 $l2kmthisyear = 0;
 
 $r2km1 = 0;
 $r2km2 = 0;
 $r2km3 = 0;
 $r2km4 = 0;
 $r2km5 = 0;
 $r2km6 = 0;
 $r2km7 = 0;
 $r2km8 = 0;
 $r2km9 = 0;
 $r2km10 = 0;
 $r2km11 = 0;
 $r2km12 = 0;
 $r2kmthisyear = 0;
 
 if (@mysql_num_rows($res)<1) { echo ''; } else {
 for($i=0; $i<mysql_num_rows($res); $i++) {
 $all_km   = $all_km   + mysql_result($res, $i, 'km');
 $all_litr = $all_litr + mysql_result($res, $i, 'litr');
 $all_rubl = $all_rubl + mysql_result($res, $i, 'summ');
 if (date('y', mysql_result($res, $i, 'z_date')) == $thisyear) {
 switch (date('m', mysql_result($res, $i, 'z_date'))) {
  case '01':
  $km1 = $km1 + mysql_result($res, $i, 'km');
  $litr1 = $litr1 + mysql_result($res, $i, 'litr');
  $rubl1 = $rubl1 + mysql_result($res, $i, 'summ');
  break;
  case '02':
  $km2 = $km2 + mysql_result($res, $i, 'km');
  $litr2 = $litr2 + mysql_result($res, $i, 'litr');
  $rubl2 = $rubl2 + mysql_result($res, $i, 'summ');
  break;
  case '03':
  $km3 = $km3 + mysql_result($res, $i, 'km');
  $litr3 = $litr3 + mysql_result($res, $i, 'litr');
  $rubl3 = $rubl3 + mysql_result($res, $i, 'summ');
  break;
  case '04':
  $km4 = $km4 + mysql_result($res, $i, 'km');
  $litr4 = $litr4 + mysql_result($res, $i, 'litr');
  $rubl4 = $rubl4 + mysql_result($res, $i, 'summ');
  break;
  case '05':
  $km5 = $km5 + mysql_result($res, $i, 'km');
  $litr5 = $litr5 + mysql_result($res, $i, 'litr');
  $rubl5 = $rubl5 + mysql_result($res, $i, 'summ');
  break;
  case '06':
  $km6 = $km6 + mysql_result($res, $i, 'km');
  $litr6 = $litr6 + mysql_result($res, $i, 'litr');
  $rubl6 = $rubl6 + mysql_result($res, $i, 'summ');
  break;
  case '07':
  $km7 = $km7 + mysql_result($res, $i, 'km');
  $litr7 = $litr7 + mysql_result($res, $i, 'litr');
  $rubl7 = $rubl7 + mysql_result($res, $i, 'summ');
  break;
  case '08':
  $km8 = $km8 + mysql_result($res, $i, 'km');
  $litr8 = $litr8 + mysql_result($res, $i, 'litr');
  $rubl8 = $rubl8 + mysql_result($res, $i, 'summ');
  break;
  case '09':
  $km9 = $km9 + mysql_result($res, $i, 'km');
  $litr9 = $litr9 + mysql_result($res, $i, 'litr');
  $rubl9 = $rubl9 + mysql_result($res, $i, 'summ');
  break;
  case '10':
  $km10 = $km10 + mysql_result($res, $i, 'km');
  $litr10 = $litr10 + mysql_result($res, $i, 'litr');
  $rubl10 = $rubl10 + mysql_result($res, $i, 'summ');
  break;
  case '11':
  $km11 = $km11 + mysql_result($res, $i, 'km');
  $litr11 = $litr11 + mysql_result($res, $i, 'litr');
  $rubl11 = $rubl11 + mysql_result($res, $i, 'summ');
  break;
  case '12':
  $km12 = $km12 + mysql_result($res, $i, 'km');
  $litr12 = $litr12 + mysql_result($res, $i, 'litr');
  $rubl12 = $rubl12 + mysql_result($res, $i, 'summ');
  break;
 } //switch (date('m', mysql_result($res, $i, 'z_date')))
 } //if (date('y', mysql_result($res, $i, 'z_date')) == $thisyear)
 } //for
 $kmthisyear = $km1 + $km2 + $km3 + $km4 + $km5 + $km6 + $km7 + $km8 + $km9 + $km10 + $km11 + $km12;
 $litrthisyear = $litr1 + $litr2 + $litr3 + $litr4 + $litr5 + $litr6 + $litr7 + $litr8 + $litr9 + $litr10 + $litr11 + $litr12;
 $rublthisyear = $rubl1 + $rubl2 + $rubl3 + $rubl4 + $rubl5 + $rubl6 + $rubl7 + $rubl8 + $rubl9 + $rubl10 + $rubl11 + $rubl12;
 
 if ($all_km==0) {$avr_l2km = 0;} else {$avr_l2km = ($all_litr*100)/$all_km;}
 if ($all_km==0) {$avr_r2km = 0;} else {$avr_r2km = $all_rubl/$all_km;}
 if ($km1==0) {$l2km1 = 0;} else {$l2km1 = ($litr1*100)/$km1;}
 if ($km1==0) {$r2km1 = 0;} else {$r2km1 = $rubl1/$km1;}
 if ($km2==0) {$l2km2 = 0;} else {$l2km2 = ($litr2*100)/$km2;}
 if ($km2==0) {$r2km2 = 0;} else {$r2km2 = $rubl2/$km2;}
 if ($km3==0) {$l2km3 = 0;} else {$l2km3 = ($litr3*100)/$km3;}
 if ($km3==0) {$r2km3 = 0;} else {$r2km3 = $rubl3/$km3;}
 if ($km4==0) {$l2km4 = 0;} else {$l2km4 = ($litr4*100)/$km4;}
 if ($km4==0) {$r2km4 = 0;} else {$r2km4 = $rubl4/$km4;}
 if ($km5==0) {$l2km5 = 0;} else {$l2km5 = ($litr5*100)/$km5;}
 if ($km5==0) {$r2km5 = 0;} else {$r2km5 = $rubl5/$km5;}
 if ($km6==0) {$l2km6 = 0;} else {$l2km6 = ($litr6*100)/$km6;}
 if ($km6==0) {$r2km6 = 0;} else {$r2km6 = $rubl6/$km6;}
 if ($km7==0) {$l2km7 = 0;} else {$l2km7 = ($litr7*100)/$km7;}
 if ($km7==0) {$r2km7 = 0;} else {$r2km7 = $rubl7/$km7;}
 if ($km8==0) {$l2km8 = 0;} else {$l2km8 = ($litr8*100)/$km8;}
 if ($km8==0) {$r2km8 = 0;} else {$r2km8 = $rubl8/$km8;}
 if ($km9==0) {$l2km9 = 0;} else {$l2km9 = ($litr9*100)/$km9;}
 if ($km9==0) {$r2km9 = 0;} else {$r2km9 = $rubl9/$km9;}
 if ($km10==0) {$l2km10 = 0;} else {$l2km10 = ($litr10*100)/$km10;}
 if ($km10==0) {$r2km10 = 0;} else {$r2km10 = $rubl10/$km10;}
 if ($km11==0) {$l2km11 = 0;} else {$l2km11 = ($litr11*100)/$km11;}
 if ($km11==0) {$r2km11 = 0;} else {$r2km11 = $rubl11/$km11;}
 if ($km12==0) {$l2km12 = 0;} else {$l2km12 = ($litr12*100)/$km12;}
 if ($km12==0) {$r2km12 = 0;} else {$r2km12 = $rubl12/$km12;}
 
 if ($kmthisyear==0) {$l2kmthisyear = 0;} else {$l2kmthisyear = ($litrthisyear*100)/$kmthisyear;}
 if ($kmthisyear==0) {$r2kmthisyear = 0;} else {$r2kmthisyear = $rublthisyear/$kmthisyear;}
 } //else
 $all_km    = number_format($all_km,   2, '.', ',');
 $all_litr  = number_format($all_litr, 2, '.', ',');
 $all_rubl  = number_format($all_rubl, 2, '.', ',');
 $avr_l2km  = number_format($avr_l2km, 4, '.', ',');
 $avr_r2km  = number_format($avr_r2km, 4, '.', ',');
 
 $km1 = number_format($km1, 2, '.', ',');
 $km2 = number_format($km2, 2, '.', ',');
 $km3 = number_format($km3, 2, '.', ',');
 $km4 = number_format($km4, 2, '.', ',');
 $km5 = number_format($km5, 2, '.', ',');
 $km6 = number_format($km6, 2, '.', ',');
 $km7 = number_format($km7, 2, '.', ',');
 $km8 = number_format($km8, 2, '.', ',');
 $km9 = number_format($km9, 2, '.', ',');
 $km10 = number_format($km10, 2, '.', ',');
 $km11 = number_format($km11, 2, '.', ',');
 $km12 = number_format($km12, 2, '.', ',');
 $kmthisyear = number_format($kmthisyear, 2, '.', ',');
 
 $litr1 = number_format($litr1, 2, '.', ',');
 $litr2 = number_format($litr2, 2, '.', ',');
 $litr3 = number_format($litr3, 2, '.', ',');
 $litr4 = number_format($litr4, 2, '.', ',');
 $litr5 = number_format($litr5, 2, '.', ',');
 $litr6 = number_format($litr6, 2, '.', ',');
 $litr7 = number_format($litr7, 2, '.', ',');
 $litr8 = number_format($litr8, 2, '.', ',');
 $litr9 = number_format($litr9, 2, '.', ',');
 $litr10 = number_format($litr10, 2, '.', ',');
 $litr11 = number_format($litr11, 2, '.', ',');
 $litr12 = number_format($litr12, 2, '.', ',');
 $litrthisyear = number_format($litrthisyear, 2, '.', ',');
 
 $rubl1 = number_format($rubl1, 2, '.', ',');
 $rubl2 = number_format($rubl2, 2, '.', ',');
 $rubl3 = number_format($rubl3, 2, '.', ',');
 $rubl4 = number_format($rubl4, 2, '.', ',');
 $rubl5 = number_format($rubl5, 2, '.', ',');
 $rubl6 = number_format($rubl6, 2, '.', ',');
 $rubl7 = number_format($rubl7, 2, '.', ',');
 $rubl8 = number_format($rubl8, 2, '.', ',');
 $rubl9 = number_format($rubl9, 2, '.', ',');
 $rubl10 = number_format($rubl10, 2, '.', ',');
 $rubl11 = number_format($rubl11, 2, '.', ',');
 $rubl12 = number_format($rubl12, 2, '.', ',');
 $rublthisyear = number_format($rublthisyear, 2, '.', ',');
  
 $l2km1 = number_format($l2km1, 4, '.', ',');
 $r2km1 = number_format($r2km1, 4, '.', ',');
 $l2km2 = number_format($l2km2, 4, '.', ',');
 $r2km2 = number_format($r2km2, 4, '.', ',');
 $l2km3 = number_format($l2km3, 4, '.', ',');
 $r2km3 = number_format($r2km3, 4, '.', ',');
 $l2km4 = number_format($l2km4, 4, '.', ',');
 $r2km4 = number_format($r2km4, 4, '.', ',');
 $l2km5 = number_format($l2km5, 4, '.', ',');
 $r2km5 = number_format($r2km5, 4, '.', ',');
 $l2km6 = number_format($l2km6, 4, '.', ',');
 $r2km6 = number_format($r2km6, 4, '.', ',');
 $l2km7 = number_format($l2km7, 4, '.', ',');
 $r2km7 = number_format($r2km7, 4, '.', ',');
 $l2km8 = number_format($l2km8, 4, '.', ',');
 $r2km8 = number_format($r2km8, 4, '.', ',');
 $l2km9 = number_format($l2km9, 4, '.', ',');
 $r2km9 = number_format($r2km9, 4, '.', ',');
 $l2km10 = number_format($l2km10, 4, '.', ',');
 $r2km10 = number_format($r2km10, 4, '.', ',');
 $l2km11 = number_format($l2km11, 4, '.', ',');
 $r2km11 = number_format($r2km11, 4, '.', ',');
 $l2km12 = number_format($l2km12, 4, '.', ',');
 $r2km12 = number_format($r2km12, 4, '.', ',');
 $l2kmthisyear = number_format($l2kmthisyear, 4, '.', ',');
 $r2kmthisyear = number_format($r2kmthisyear, 4, '.', ',');
 
?>

<table>
      <table cellpadding=0 cellspacing=0 border=0 rules=rows width=95% style='font-size: 11; margin-left: 9;'>
      <col width=25%><col width=15%><col width=15%><col width=15%> <col width=15%><col width=15%>
      <tr>
      <td style='text-align: center; background-color: #d2d6ff;'>Период</td>
      <td style='text-align: center; background-color: #d2d6ff;'>км</td>
      <td style='text-align: center; background-color: #d2d6ff;'>л</td>
      <td style='text-align: center; background-color: #d2d6ff;'>руб</td>
      <td style='text-align: center; background-color: #d2d6ff;'>л/100км</td>
      <td style='text-align: center; background-color: #d2d6ff;'>руб/км</td>
      </tr>
      <tr>
      <td style='text-align: center;'>Январь</td>
      <td style='text-align: right;'><?=$km1?></td>
      <td style='text-align: right;'><?=$litr1?></td>
      <td style='text-align: right;'><?=$rubl1?></td>
      <td style='text-align: right;'><?=$l2km1?></td>
      <td style='text-align: right;'><?=$r2km1?></td>
      </tr>
      <tr>
      <td style='text-align: center;'>Февраль</td>
      <td style='text-align: right;'><?=$km2?></td>
      <td style='text-align: right;'><?=$litr2?></td>
      <td style='text-align: right;'><?=$rubl2?></td>
      <td style='text-align: right;'><?=$l2km2?></td>
      <td style='text-align: right;'><?=$r2km2?></td>
      </tr>
      <tr>
      <td style='text-align: center;'>Март</td>
      <td style='text-align: right;'><?=$km3?></td>
      <td style='text-align: right;'><?=$litr3?></td>
      <td style='text-align: right;'><?=$rubl3?></td>
      <td style='text-align: right;'><?=$l2km3?></td>
      <td style='text-align: right;'><?=$r2km3?></td>
      </tr>
      <tr>
      <td style='text-align: center;'>Апрель</td>
      <td style='text-align: right;'><?=$km4?></td>
      <td style='text-align: right;'><?=$litr4?></td>
      <td style='text-align: right;'><?=$rubl4?></td>
      <td style='text-align: right;'><?=$l2km4?></td>
      <td style='text-align: right;'><?=$r2km4?></td>
      </tr>
      <tr>
      <td style='text-align: center;'>Май</td>
      <td style='text-align: right;'><?=$km5?></td>
      <td style='text-align: right;'><?=$litr5?></td>
      <td style='text-align: right;'><?=$rubl5?></td>
      <td style='text-align: right;'><?=$l2km5?></td>
      <td style='text-align: right;'><?=$r2km5?></td>
      </tr>
      <tr>
      <td style='text-align: center;'>Июнь</td>
      <td style='text-align: right;'><?=$km6?></td>
      <td style='text-align: right;'><?=$litr6?></td>
      <td style='text-align: right;'><?=$rubl6?></td>
      <td style='text-align: right;'><?=$l2km6?></td>
      <td style='text-align: right;'><?=$r2km6?></td>
      </tr>
      <tr>
      <td style='text-align: center;'>Июль</td>
      <td style='text-align: right;'><?=$km7?></td>
      <td style='text-align: right;'><?=$litr7?></td>
      <td style='text-align: right;'><?=$rubl7?></td>
      <td style='text-align: right;'><?=$l2km7?></td>
      <td style='text-align: right;'><?=$r2km7?></td>
      </tr>
      <tr>
      <td style='text-align: center;'>Август</td>
      <td style='text-align: right;'><?=$km8?></td>
      <td style='text-align: right;'><?=$litr8?></td>
      <td style='text-align: right;'><?=$rubl8?></td>
      <td style='text-align: right;'><?=$l2km8?></td>
      <td style='text-align: right;'><?=$r2km8?></td>
      </tr>
      <tr>
      <td style='text-align: center;'>Сентябрь</td>
      <td style='text-align: right;'><?=$km9?></td>
      <td style='text-align: right;'><?=$litr9?></td>
      <td style='text-align: right;'><?=$rubl9?></td>
      <td style='text-align: right;'><?=$l2km9?></td>
      <td style='text-align: right;'><?=$r2km9?></td>
      </tr>
      <tr>
      <td style='text-align: center;'>Октябрь</td>
      <td style='text-align: right;'><?=$km10?></td>
      <td style='text-align: right;'><?=$litr10?></td>
      <td style='text-align: right;'><?=$rubl10?></td>
      <td style='text-align: right;'><?=$l2km10?></td>
      <td style='text-align: right;'><?=$r2km10?></td>
      </tr>
      <tr>
      <td style='text-align: center;'>Ноябрь</td>
      <td style='text-align: right;'><?=$km11?></td>
      <td style='text-align: right;'><?=$litr11?></td>
      <td style='text-align: right;'><?=$rubl11?></td>
      <td style='text-align: right;'><?=$l2km11?></td>
      <td style='text-align: right;'><?=$r2km11?></td>
      </tr>
      <tr>
      <td style='text-align: center;'>Декабрь</td>
      <td style='text-align: right;'><?=$km12?></td>
      <td style='text-align: right;'><?=$litr12?></td>
      <td style='text-align: right;'><?=$rubl12?></td>
      <td style='text-align: right;'><?=$l2km12?></td>
      <td style='text-align: right;'><?=$r2km12?></td>
      </tr>
      <td style='text-align: center; background-color: #d2d6ff;'>Итого</td>
      <td style='text-align: right; background-color: #d2d6ff;'><?=$kmthisyear?></td>
      <td style='text-align: right; background-color: #d2d6ff;'><?=$litrthisyear?></td>
      <td style='text-align: right; background-color: #d2d6ff;'><?=$rublthisyear?></td>
      <td style='text-align: right; background-color: #d2d6ff;'><?=$l2kmthisyear?></td>
      <td style='text-align: right; background-color: #d2d6ff;'><?=$r2kmthisyear?></td>
      </table>
      <?php
      echo '<script>top.gas_stat(\''.$period.'\');</script>';
      ?>
      
</div>

<?php
 // foot params
 $no_graph_foot = 0;
 require('foot.php');
 // ---
?>
