<?php
 // head params
 $page_name         = 'gas';
 $page_cap          = 'Учет расхода бензина';
 $no_graph_head     = 0;
 $secure_page       = 1;
 $is_frame          = 0;
 $prev_page_must_be = ''; // Example: "page1,page2,page3"
 $no_refresh        = 0;
 require_once('head.php');
 // ---
 ?>

<script>
function gas_stat(period) {
document.getElementById("stat_period").innerHTML=period;
}
function gas_fresh(all_km, all_litr, all_rubl, avr_l2km, avr_r2km) {
document.getElementById("gas_all_km").value=all_km;
document.getElementById("gas_all_litr").value=all_litr;
document.getElementById("gas_all_rubl").value=all_rubl;
document.getElementById("gas_avr_l2km").value=avr_l2km;
document.getElementById("gas_avr_r2km").value=avr_r2km;
}
function gas_edit() {
 document.getElementById("div_add_gas").style.display='none';
 document.getElementById("div_show_gas").style.display='none';
 document.getElementById("div_edit_gas").style.display='block';
 // ---
 document.getElementById("gasb_add").style.display='none';
 document.getElementById("gasb_create").style.display='none';
 document.getElementById("gasb_save").style.display='block';
 // ---
 document.getElementById("gas_act").value='edit';
}
function gas_save() {
 document.getElementById("gas_act").value='edit';
 document.getElementById("edit_gas_form").submit();
}
function gas_add() {
 document.getElementById("div_add_gas").style.display='block';
 document.getElementById("div_show_gas").style.display='none';
 document.getElementById("div_edit_gas").style.display='none';
 // ---
 document.getElementById("gasb_add").style.display='none';
 document.getElementById("gasb_create").style.display='block';
 document.getElementById("gasb_save").style.display='none';
 // ---
 document.getElementById("gas_act").value='add';
}
function gas_create() {
 document.getElementById("gas_act").value='add';
 document.getElementById("add_gas_form").submit();
}
function gas_cancel() {
 //document.getElementById("but_form").reset();
 document.getElementById("div_add_gas").style.display='none';
 document.getElementById("div_show_gas").style.display='block';
 document.getElementById("div_edit_gas").style.display='none';
 // ---
 document.getElementById("gasb_add").style.display='block';
 document.getElementById("gasb_create").style.display='none';
 document.getElementById("gasb_save").style.display='none';
 // ---
 document.getElementById("gas_act").value='';
 document.getElementById("gas_form").reset();
 document.getElementById("gas_form").submit();
}
function gas_del(id) {
 if (confirm("Удалить запись?")) {
 //alert('1');
 //alert('id='+id);
 document.getElementById("frame_gas").src="gas_inner.php?act=del&gid="+id;
 //alert('2');
 document.getElementById("gas_act").value='';
 document.getElementById("gas_form").reset();
 document.getElementById("gas_form").submit();
 }
}
</script>


<?php
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
  status = 1 and user_id = "'.$uid.'" and km > 0 and z_date > 0
 ORDER BY odo
 ');
 $all_km   = 0;
 $all_litr = 0;
 $all_rubl = 0;
 $avr_l2km = 0;
 $avr_r2km = 0;
 if (@mysql_num_rows($res)<1) { echo ''; } else {
 for($i=0; $i<mysql_num_rows($res); $i++) {
 $all_km   = $all_km + mysql_result($res, $i, 'km');
 $all_litr = $all_litr + mysql_result($res, $i, 'litr');
 $all_rubl = $all_rubl + mysql_result($res, $i, 'summ');
 if ($all_km==0) {$avr_l2km = 0;} else {$avr_l2km = ($all_litr*100)/$all_km;}
 if ($all_km==0) {$avr_r2km = 0;} else {$avr_r2km = $all_rubl/$all_km;}
 } //for
 } //else
 $all_km    = number_format($all_km,   2, '.', ',');
 $all_litr  = number_format($all_litr, 2, '.', ',');
 $all_rubl  = number_format($all_rubl, 2, '.', ',');
 $avr_l2km  = number_format($avr_l2km, 4, '.', ',');
 $avr_r2km  = number_format($avr_r2km, 4, '.', ',');
 
 echo '<script>top.gas_fresh(\''.$all_km.'\', \''.$all_litr.'\', \''.$all_rubl.'\', \''.$avr_l2km.'\', \''.$avr_r2km.'\');</script>';
 
?>


 <?php
 if (ctype_digit($gid)) {
 $res=mysql_query('
 SELECT
  id
 ,status
 ,z_date
 ,summ
 ,litr
 ,odo
 ,rubl2litr
 ,km  
 ,litr2100km
 ,rubl2km
 ,CASE WHEN id = "'.$gid.'" THEN "_a" ELSE "" END style
 FROM
  gas
 WHERE
  status = 1 and user_id = "'.$uid.'" and id = "'.$gid.'"
 ORDER BY z_date
 ');
 
  $cur_id         = '';
  $cur_status     = '';
  $cur_date       = '';
  $cur_summ       = '';
  $cur_litr       = '';
  $cur_odo        = '';
  $cur_rubl2litr  = '';
  $cur_km         = '';
  $cur_litr2100km = '';
  $cur_rubl2km    = '';
  
  if (mysql_error()) {
    echo "<script>alert('Ошибка при загрузке данных. Возможно не задан id.');</script>";
  } else {
    if (mysql_num_rows($res)!==1) {
    echo "<script>alert('Запись не найдена.');</script>";
    } else {
      if (mysql_result($res, 0, 'status') <> 1) {
        echo "<script>alert('Неверный статус.');</script>";
      } else {
        $cur_id         = mysql_result($res, 0, 'id');
        $cur_status     = mysql_result($res, 0, 'status');
        $cur_date       = date("d/m/Y", mysql_result($res, 0, 'z_date'));
        $cur_summ       = mysql_result($res, 0, 'summ');
        $cur_summ       = number_format($cur_summ, 2, '.', ',');
        $cur_litr       = mysql_result($res, 0, 'litr');
        $cur_litr       = number_format($cur_litr, 2, '.', ',');
        $cur_odo        = mysql_result($res, 0, 'odo');
        $cur_odo        = number_format($cur_odo, 2, '.', ',');
        $cur_rubl2litr  = mysql_result($res, 0, 'rubl2litr');
        $cur_rubl2litr  = number_format($cur_rubl2litr, 2, '.', ',');
        $cur_km         = mysql_result($res, 0, 'km');
        $cur_km         = number_format($cur_km, 2, '.', ',');
        $cur_litr2100km = mysql_result($res, 0, 'litr2100km');
        $cur_litr2100km = number_format($cur_litr2100km, 4, '.', ',');
        $cur_rubl2km    = mysql_result($res, 0, 'rubl2km');
        $cur_rubl2km    = number_format($cur_rubl2km, 4, '.', ',');
      }
    }
  }
 } // if (ctype_digit($gid))
 
 ?>

<table border=0 cellspacing=0 cellpadding=0 width=100% valign=top >
<col width=10%><col width=1000><col width=10%>
<tr><td width=10% valign=top></td>
<td width=1000 valign=top>
  <div class='gas_div' style='border-color: silver; height: 95%; display: block; margin-top: 10;' id='div_gas' name='div_gas'>
  <span id='gas_cap' name='gas_cap' style='color: blue; font-size: 20; font-style: italic; font-weight: bold; text-shadow: 0px 0px 1px #333;'>
  Учет расхода бензина</span>
  <div class='form_div'>
  <table border=0 rules=all cellspacing=0 cellpadding=2 width=100% style='font-size: 11;' >
  <col width=60%><col width=40%>
  <tr>
    <td align=right style='background-image: url(/pics/fuel.jpg); background-position: left center; background-repeat: no-repeat;'>
    <!--
    <img src='/pics/gas2.jpg'  width=350 height=120 align=left>
    <img src='/pics/fuel.jpg'   width=110 height=110 align=left>
    -->
      <table border=0 rules=rows cellspacing=0 cellpadding=2 width=35% style='font-size: 11;' >
      <col width=50%><col width=50%>
      <tr><td align=right>
      Всего, км:
      </td><td>
      <input type='text' id='gas_all_km'   name='gas_all_km'   readonly  value='' class='inp_dec_c' style='width: 75; color: black;'><br>
      </td></tr>
      <tr><td align=right>
      Всего, литр:
      </td><td>
      <input type='text' id='gas_all_litr' name='gas_all_litr' readonly  value='' class='inp_dec_c' style='width: 75; color: black;'><br>
      </td></tr>
      <tr><td align=right>
      Всего, руб.: 
      </td><td>
      <input type='text' id='gas_all_rubl' name='gas_all_rubl' readonly  value='' class='inp_dec_c' style='width: 75; color: black;'><br>
      </td></tr>
      <tr><td align=right>
      Средний расход: 
      </td><td>
      <input type='text' id='gas_avr_l2km' name='gas_avr_l2km' readonly  value='' class='inp_dec_c' style='width: 75; color: black;'><br>
      </td></tr>
      <tr><td align=right>
      Ср. цена 1 км: 
      </td><td>
      <input type='text' id='gas_avr_r2km' name='gas_avr_r2km' readonly  value='' class='inp_dec_c' style='width: 75; color: black;'><br>
      </td></tr>
      </table>
    </td>
    <td valign=top align=center>
    
    <!-- show show show show show show show show show show show show show show show show show show show show show show show --> 
    <div id='div_show_gas' name='div_show_gas' class='gas_div_vvod' style='border-color: silver; display: block; margin-top: 10;' >
    <table border=0 cellspacing=2 cellpadding=0 width=100% style='font-size: 11;' >
    <col width=30%><col width=70%>
    <tr><td>Просмотр</td><td></td></tr>
    <tr><td align=right valign=center>
    Дата:
    </td><td  align=left valign=center>
    <input type='hidden' id='gas_act' name='gas_act' maxlength=50 value='none'>
    <input type='hidden' id='gas_id'  name='gas_id'  maxlength=50 value=''>
    <input type='text'   id='gas_dat' name='gas_dat' readonly value='<?=$cur_date;?>' class='inp_txt' style='width: 70; color: black;'>
    </td></tr>
    <tr><td align=right valign=center>
    Odo:
    </td><td  align=left valign=center>
    <input type='text'   id='gas_odo' name='gas_odo' readonly value='<?=$cur_odo;?>' class='inp_dec' style='width: 100; color: black;'>
    </td></tr>
    <tr><td align=right valign=center>
    Литр:
    </td><td  align=left valign=center>
    <input type='text'   id='gas_litr' name='gas_litr' readonly value='<?=$cur_litr;?>' class='inp_dec' style='width: 100; color: black;'>
    </td></tr>
    <tr><td align=right valign=center>
    Сумма:
    </td><td  align=left valign=center>
    <input type='text' id='gas_summ' readonly name='gas_summ'  value='<?=$cur_summ;?>' class='inp_dec' style='width: 100; color: black;'>
    </td></tr>
    </table>
    </div>
    
    <!-- add add add add add add add add add add add add add add add add add add add add add add add add add add  --> 
    <form action='gas_inner.php?act=add' target='frame_gas' id='add_gas_form' name='adda_gas_form' method='POST'>
    <div id='div_add_gas' name='div_add_gas' class='gas_div_vvod' style='border-color: silver; display: none; margin-top: 10;' >
    <table border=0 cellspacing=2 cellpadding=0 width=100% style='font-size: 11;' >
    <col width=30%><col width=70%>
    <tr><td>Добавление</td><td></td></tr>
    <tr><td align=right valign=center>
    Дата:
    </td><td  align=left valign=center>
    <input type='hidden' id='gas_act' name='gas_act' maxlength=50 value='none'>
    <input type='hidden' id='gas_id'  name='gas_id'  maxlength=50 value=''>
    
    <input type='text'   id='gas_dat' name='gas_dat'   value='' class='inp_txt' style='width: 70; color: black;'>
    </td></tr>
    <tr><td align=right valign=center>
    Odo:
    </td><td  align=left valign=center>
    <input type='text'   id='gas_odo' name='gas_odo'   value='' class='inp_dec' style='width: 100; color: black;'>
    </td></tr>
    <tr><td align=right valign=center>
    Литр:
    </td><td  align=left valign=center>
    <input type='text'   id='gas_litr' name='gas_litr' value='' class='inp_dec' style='width: 100; color: black;'>
    </td></tr>
    <tr><td align=right valign=center>
    Сумма:
    </td><td  align=left valign=center>
    <input type='text' id='gas_summ' name='gas_summ'   value='' class='inp_dec' style='width: 100; color: black;'>
    
    </td></tr>
    </table>
    </div>
    </form>
    
    <!-- edit edit edit edit edit edit edit edit edit edit edit edit edit edit edit edit edit edit edit edit edit edit --> 
    <form action='gas_inner.php<?php if (ctype_digit($gid)) { echo '?gid='.$gid; }?>&act=edit' target='frame_gas' id='edit_gas_form' name='edit_gas_form' method='POST'>
    <div id='div_edit_gas' name='div_edit_gas' class='gas_div_vvod' style='border-color: silver; display: none; margin-top: 10;' >
    <table border=0 cellspacing=2 cellpadding=0 width=100% style='font-size: 11;' >
    <col width=30%><col width=70%>
    <tr><td>Редактирование</td><td></td></tr>
    <tr><td align=right valign=center>
    Дата:
    </td><td  align=left valign=center>
    <input type='hidden' id='gas_act' name='gas_act' maxlength=50 value='none'>
    <input type='hidden' id='gas_id'  name='gas_id'  maxlength=50 value=''>
    <input type='text'   id='gas_dat' name='gas_dat'   value='<?=$cur_date?>' class='inp_txt' style='width: 70; color: black;'>
    </td></tr>
    <tr><td align=right valign=center>
    Odo:
    </td><td  align=left valign=center>
    <input type='text'   id='gas_odo' name='gas_odo'   value='<?=$cur_odo?>' class='inp_dec' style='width: 100; color: black;'>
    </td></tr>
    <tr><td align=right valign=center>
    Литр:
    </td><td  align=left valign=center>
    <input type='text'   id='gas_litr' name='gas_litr' value='<?=$cur_litr?>' class='inp_dec' style='width: 100; color: black;'>
    </td></tr>
    <tr><td align=right valign=center>
    Сумма:
    </td><td  align=left valign=center>
    <input type='text' id='gas_summ' name='gas_summ'   value='<?=$cur_summ?>' class='inp_dec' style='width: 100; color: black;'>
    </td></tr>
    </table>
    </div>
    </form>
    
    </td>
  </tr>
  <tr>
    <td>
      <div >
      <table cellpadding=0 cellspacing=0 border=0 rules=cols width=93% style='font-size: 11; margin-left: 12;'>
      <col width=13%><col width=7%><col width=15%><col width=10%> <col width=10%><col width=10%><col width=10%><col width=15%><col width=5%><col width=5%>
      <tr>
      <td style='text-align: center; background-color: #d2d6ff;'>Дата</td>
      <td style='text-align: center; background-color: #d2d6ff;'>л</td>
      <td style='text-align: center; background-color: #d2d6ff;'>odo</td>
      <td style='text-align: center; background-color: #d2d6ff;'>руб/л</td>
      <td style='text-align: center; background-color: #d2d6ff;'>км</td>
      <td style='text-align: center; background-color: #d2d6ff;'>л/100км</td>
      <td style='text-align: center; background-color: #d2d6ff;'>руб/км</td>
      <td style='text-align: center; background-color: #d2d6ff;'>Сумма</td>
      <td style='text-align: center; background-color: #d2d6ff;'>Edit</td>
      <td style='text-align: center; background-color: #d2d6ff;'>Del</td>
      </tr>
      </table>
      </div>
    </td>
    <td>
      <a href="gas.php"                   target="_top" id='gasb_cancel' name='gasb_cancel' 
                                          style='float: right; margin-right: 10; display: block;'>Отмена</a>
      <a href="javascript: gas_add();"    target="_top" id='gasb_add'    name='gasb_add'    
                                          style='float: right; margin-right: 10; display: block;'>Добавить</a>
      <a href="javascript: gas_create();" target="_top" id='gasb_create' name='gasb_create' 
                                          style='float: right; margin-right: 10; display: none;'>Создать</a>
      <a href="javascript: gas_save();"   target="_top" id='gasb_save'   name='gasb_save'   
                                          style='float: right; margin-right: 10; display: none;'>Сохранить</a>
    </td>
  </tr>
  <tr>
    <td>
      <iframe src='gas_inner.php<?php if (ctype_digit($gid)) { echo '?gid='.$gid; }?>'
      id='frame_gas' name='frame_gas' frameborder=0 scrolling=auto style='margin-left: 0; width: 585; height: 385;'>
      </iframe>
    </td>
    <td valign=top style='background-image: url(/pics/gs.jpg); background-position: right bottom; background-repeat: no-repeat;'>
    Статистика за 20<span id='stat_period' name='stat_period'>17</span> год.
      <iframe src='gas_stat.php?period=17&<?php if (ctype_digit($gid)) { echo 'gid='.$gid; }?>
              'id='frame_stat' name='frame_stat' frameborder=0
              scrolling=auto style='margin-left: 0; width: 385; height: 240;'>
      </iframe>
    <br>      
    <a href="gas_inner.php?act=recal"    target="frame_gas" id='gasb_recal'    name='gasb_recal'    
                                         style='float: right; margin-right: 10; display: block;'>Recalc</a>
    <a href="gas_stat.php?period=17"     target="frame_stat" id='gasb_2017' name='gasb_2017'
                                         style='float: right; margin-right: 10; display: block;'>2017</a>
    <a href="gas_stat.php?period=16"     target="frame_stat" id='gasb_2016' name='gasb_2016'
                                         style='float: right; margin-right: 10; display: block;'>2016</a>
    <a href="gas_stat.php?period=15"     target="frame_stat" id='gasb_2015' name='gasb_2015'
                                         style='float: right; margin-right: 10; display: block;'>2015</a>
    <a href="gas_stat.php?period=14"     target="frame_stat" id='gasb_2014' name='gasb_2014'
                                         style='float: right; margin-right: 10; display: block;'>2014</a>
    <a href="gas_stat.php?period=13"     target="frame_stat" id='gasb_2013' name='gasb_2013'
                                         style='float: right; margin-right: 10; display: block;'>2013</a>
    <a href="gas_stat.php?period=12"     target="frame_stat" id='gasb_2012' name='gasb_2012'
                                         style='float: right; margin-right: 10; display: block;'>2012</a>
    <a href="gas_stat.php?period=11"     target="frame_stat" id='gasb_2011' name='gasb_2011'
                                         style='float: right; margin-right: 10; display: block;'>2011</a>
    <a href="gas_stat.php?period=10"     target="frame_stat" id='gasb_2010' name='gasb_2010'
                                         style='float: right; margin-right: 10; display: block;'>2010</a>
    <a href="gas_stat.php?period=09"     target="frame_stat" id='gasb_2009' name='gasb_2009'
                                         style='float: right; margin-right: 10; display: block;'>2009</a>
    <!--
    <a href="gas_inner.php?act=fresh"    target="frame_gas" id='gasb_fresh'    name='gasb_fresh'    
                                         style='float: right; margin-right: 10; display: block;'>Refresh</a>
    -->
    </td>
  </tr>
  </table>
  </div>
  
  </div>
  
  </td>
  <td width=10%></td>
  </td>
  </tr>
 </table>

 <?php
  echo '<script>top.gas_fresh(\''.$all_km.'\', \''.$all_litr.'\', \''.$all_rubl.'\', \''.$avr_l2km.'\', \''.$avr_r2km.'\');</script>';
 
  if ($act=='edit') {
    echo '<script>top.gas_edit();</script>';
  }
  if ($act=='del') {
    echo '<script>top.gas_del(\''.$gid.'\');</script>';
  }
 ?>
 
 <?php
 // foot params
 $no_graph_foot = 0;
 require('foot.php');
 // ---
?>
