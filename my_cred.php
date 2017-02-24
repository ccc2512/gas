<?php
 // head params
 $page_name         = 'my_cred';
 $page_cap          = 'Мои кредиты';
 $no_graph_head     = 0;
 $secure_page       = 1;
 $is_frame          = 0;
 $prev_page_must_be = ''; // Example: "page1,page2,page3"
 $no_refresh        = 0;
 require_once('head.php');
 // ---
 ?>
 
 <!--
 
 -->
 <script>
 function Init() {
  document.getElementById("e_date").value='';
  document.getElementById("e_summ").value='';
  document.getElementById("d_date").value='';
  document.getElementById("d_summ").value='';
  document.getElementById("pers").value='';
  document.getElementById("mod").value=1;
  document.getElementById("e_date").readOnly=true;
  document.getElementById("e_summ").readOnly=true;
  document.getElementById("d_date").readOnly=true;
  document.getElementById("d_summ").readOnly=true;
 }
 function FullRecalculation() {
   document.getElementById("hidden_frame").src="cred_calc.php?act=recal";
   //alert('FullRecalculation!');
   document.getElementById("frame_list").src="cred_inn_op.php";
 }
 function ShowCred(id, itogoplat1, itogoperc1, itogoplat2, itogoperc2, itogoplat, itogoperc, debtsumm) {
  document.getElementById("sum_itogo_plat_1").value=itogoplat1;
  document.getElementById("sum_itogo_perc_1").value=itogoperc1;
  document.getElementById("sum_itogo_plat_2").value=itogoplat2;
  document.getElementById("sum_itogo_perc_2").value=itogoperc2;
  document.getElementById("sum_itogo_plat").value=itogoplat;
  document.getElementById("sum_itogo_perc").value=itogoperc;
  document.getElementById("span_debt_summ").innerHTML=debtsumm;
  document.getElementById("frame_list").src="cred_inn_op.php?mid="+id;
  document.getElementById("idebt").src="cred_debt.php";
  document.getElementById("ibal").src="cred_bal.php";
  //alert('Show8');
 }
 function ShowAll(itogoplat1, itogoperc1, itogoplat2, itogoperc2, itogoplat, itogoperc, debtsumm) {
  document.getElementById("sum_itogo_plat_1").value=itogoplat1;
  document.getElementById("sum_itogo_perc_1").value=itogoperc1;
  document.getElementById("sum_itogo_plat_2").value=itogoplat2;
  document.getElementById("sum_itogo_perc_2").value=itogoperc2;
  document.getElementById("sum_itogo_plat").value=itogoplat;
  document.getElementById("sum_itogo_perc").value=itogoperc;
  //alert('Show8 - '+debtsumm);
  document.getElementById("span_debt_summ").innerHTML=debtsumm;
  document.getElementById("idebt").src="cred_debt.php";
  document.getElementById("ibal").src="cred_bal.php";
  document.getElementById("d_date").value='';
  document.getElementById("d_summ").value='';
  document.getElementById("pers").value='';
  document.getElementById("d_date").readOnly=true;
  document.getElementById("d_summ").readOnly=true;
  document.getElementById("span_person").innerHTML='Кредитор..';
 }
 function PreCalc(mod) {
  document.getElementById("pre").value=mod;
  document.getElementById("form_edit").submit();
  document.getElementById("e_date").value='';
  document.getElementById("e_summ").value='';
  document.getElementById("e_date").readOnly=true;
  document.getElementById("e_summ").readOnly=true;
 }
 function RecEdit(id, platdate, platsumm) {
  document.getElementById("mid").value=id;
  document.getElementById("e_date").value=platdate;
  document.getElementById("e_summ").value=platsumm;
  document.getElementById("e_date").readOnly=false;
  document.getElementById("e_summ").readOnly=false;
  document.getElementById("frame_list").src="cred_inn_op.php?mid="+id;
 }
 function DebtEdit(id,person) {
  var today = new Date();
  var curdate = today.getDate()+'/'+(today.getMonth()+1)+'/'+today.getFullYear();
  document.getElementById("span_person").innerHTML=person;
  document.getElementById("pers").value=id;
  document.getElementById("d_date").value=curdate;
  document.getElementById("d_summ").value=0.00;
  document.getElementById("d_date").readOnly=false;
  document.getElementById("d_summ").readOnly=false;
  
 }
 function DebtCalc() {
  document.getElementById("form_debt").submit();
  //alert(1);
 }
 function DebtCancel() {
  document.getElementById("d_date").value='';
  document.getElementById("d_summ").value='';
  document.getElementById("d_date").readOnly=true;
  document.getElementById("d_summ").readOnly=true;
  document.getElementById("span_person").innerHTML='Кредитор..';
 }
 </script>
 <!--
 
 -->
 
 <?php
  
   /*
 $ress=mysql_query('
 SELECT
  sum(d.debt_summ) dsumm
 FROM
  debt d
 WHERE
  d.status = 1
 ');
 $temp_debt_summ = mysql_result($ress, 0, 'dsumm');
 $temp_debt_summ = number_format($temp_debt_summ, 2, '.', ',');
 

 $b_id=quick_select('
  SELECT
    id
  FROM
    balance
  WHERE
    status = 1 and user_id = '.$uid.' and acc_id = 902
  ORDER BY bal_date DESC
 ');
 
 //echo "<script>alert('b_id = ".$b_id."');</script>";
 //echo "<script>alert('temp_debt_summ = ".$temp_debt_summ."');</script>";
 
 
 
 $temp_isx_summ = str_replace(",", "", $temp_debt_summ);
 $temp_isx_summ = str_replace(" ", "", $temp_isx_summ);
 $temp_isx_summ = -1 * $temp_isx_summ;
 mysql_query('
  UPDATE balance
  SET
   isx_902 = '.$temp_isx_summ.'
  WHERE
   id = '.$b_id.'
 ');
 */
 
 //echo mysql_error();
 
 
 ?>
 
 <table border=0 cellspacing=0 cellpadding=0 width=100% height=90% valign=top >
 <col width=10%><col width=1000><col width=10%>
 <tr>
 <td width=10% valign=top></td>
 <td width=1000 valign=top>
 <div class='cred_div' style='border-color: silver; display: block; margin-top: 10;' id='div_cred' name='div_cred'>
 <span id='cred_cap' name='cred_cap' style='color: blue; font-size: 20; font-style: italic; font-weight: bold; text-shadow: 0px 0px 1px #333;'>
 Мои кредиты</span>
 <div class='form_div'>
  <table border=0 rules=all cellspacing=0 cellpadding=2 width=100% style='font-size: 11;' >
  <col width=25%><col width=25%><col width=25%><col width=25%>
  <tr>
  <td colspan=3 valign=bottom > 
    <a href="javascript: FullRecalculation();"  target="_top" id='cred_recal'  name='cred_recal'    
                                         style='float: right; margin-right: 10; display: block;'>Full Recalculation</a>
    <iframe src='' target='' id='hidden_frame' name='hidden_frame' frameborder=0
            scrolling=none style='width: 1; height: 1;'>
    </iframe>
  </td>
  <td align=center valign=center></td>
  </tr>
  <tr height=200>
  <td valign=center>
  <br>
  <span style='float: left;  margin-left: 1;   color: darkblue; font-weight: bold;'>
  Кредиторы
  </span>
  <span id='span_debt_summ' name='span_debt_summ' style='float: right; margin-right: 35; color: darkblue; font-weight: bold;'><?= $temp_debt_summ?></span>
  <br><br>
  <iframe 
    src='cred_debt.php'
    id='idebt' name='idebt' frameborder=0 class='inp_txt2'
    scrolling=auto style='margin-left: 0; width: 210; height: 170;'>
  </iframe>
  </td>
  <td valign=top>
  <br>
  <span style='float: left;  margin-left: 5;   color: darkblue; font-weight: bold;'>
  Операции
  </span>
  <br><br><br>
  <form action='cred_inner.php?act=debt' target='hidden_frame' id='form_debt' name='form_debt' method='POST'>
  <input type='hidden' id='pers'  name='pers' value=''>
  <table border=0 cellspacing=1 cellpadding=1 width=100% style='font-size: 11;' >
    <col width=40%><col width=60%>
    <tr>
    <td>
    <span id='span_person' name='span_person' style='float: left;  margin-left: 1;   color: darkblue; font-weight: bold;'>
    Кредитор..
    </span>
    </td>
    <td>
    <Select name="mod" id="mod" style='font-size: 11;  width: 100;'>
      <Option Selected Value="1">Вернуть долг
      <Option Value="2">         Взять в долг
      <Option Value="3">         Дать  в долг
      <Option Value="4">         Возврат долга
      <Option Value="5">         Изменить остаток
    </Select>
    <!--
    <Select name="mod" id="mod" style='font-size: 11;  width: 100;'>
      <Option Selected Value="1">Я возвращаю
      <Option Value="2">Я беру в долг
      <Option Value="3">Я даю  в долг
      <Option Value="4">Мне возвращают
    </Select>
    
    <span id='span_op' name='span_op' style='float: left;  margin-left: 1;   color: darkblue; font-weight: bold;'>
    </span>
    -->
    </td>
    </tr>
    <tr>
    <td align=right>Дата:</td>
    <td><input type='text' id='d_date' name='d_date' value='' class='inp_txt' style='width: 70; color: black;'></td>
    </tr>
    <tr>
    <td align=right>Сумма:</td>
    <td><input type='text' id='d_summ' name='d_summ' value='' class='inp_dec' style='width: 70; color: black;'></td>
    </tr>
    <tr>
    <td>
    <br>
    <a href="javascript: DebtCalc();" target="_top" id='d_calc' name='d_calc'    
       style='float: right; margin-right: 1; font-size: 11;  font-weight: bold; text-shadow: 0px 0px 1px #333;'>
       OK</a>
    </td>
    <td>
    <br>
    <a href="javascript: DebtCancel();" target="_top" id='d_edit' name='d_cancel'    
       style='float: left; margin-left: 20; font-size: 11;  font-weight: bold; text-shadow: 0px 0px 1px #333;'>
       Отмена</a>
    </td>
    </tr>
  </table>
  </form>
  </td>
  <td>
  <br>
  <span style='float: left;  margin-left: 5;   color: darkblue; font-weight: bold;'>
  Ведомость остатков
  </span>
  <br><br>
  <iframe 
    src='cred_bal.php'
    id='ibal' name='ibal' frameborder=0 class='inp_txt2'
    scrolling=auto style='margin-left: 5; width: 210; height: 170;'>
  </iframe>
  </td>
  <td valign=top>
    <br>
    <span style='float: left;  margin-left: 5;   color: darkblue; font-weight: bold;'>
    Выплаченные суммы
    </span>
    <br><br>
    <table border=0 cellspacing=2 cellpadding=2 width=100% style='font-size: 11;' >
    <col width=60%><col width=40%>
    <tr>
    <td align=right>Выплачено Сбербанк:</td>
    <td>
    <input type='text' id='sum_itogo_plat_1' name='sum_itogo_plat_1' readonly value='<?=$itogo_plat_1?>' class='inp_dec' style='width: 70; color: black;'>
    </td>
    </tr>
    <tr>
    <td align=right>В т.ч. проценты:</td>
    <td>
    <input type='text' id='sum_itogo_perc_1' name='sum_itogo_perc_1' readonly value='<?=$itogo_perc_1?>' class='inp_dec' style='width: 70; color: black;'>
    </td>
    </tr>
    <tr>
    <td align=right>Выплачено СКБ банк:</td>
    <td>
    <input type='text' id='sum_itogo_plat_2' name='sum_itogo_plat_2' readonly value='<?=$itogo_plat_2?>' class='inp_dec' style='width: 70; color: black;'>
    </td>
    </tr>
    <tr>
    <td align=right>В т.ч. проценты:</td>
    <td>
    <input type='text' id='sum_itogo_perc_2' name='sum_itogo_perc_2' readonly value='<?=$itogo_perc_2?>' class='inp_dec' style='width: 70; color: black;'>
    </td>
    </tr>
    <tr>
    <td align=right>Итого выплачено:</td>
    <td>
    <input type='text' id='sum_itogo_plat' name='sum_itogo_plat' readonly value='<?=$itogo_plat?>' class='inp_dec' style='width: 70; color: black;'>
    </td>
    </tr>
    <tr>
    <td align=right>В т.ч. проценты:</td>
    <td>
    <input type='text' id='sum_itogo_perc' name='sum_itogo_perc' readonly value='<?=$itogo_perc?>' class='inp_dec' style='width: 70; color: black;'>
    </td>
    </tr>
    </table>
  </td>
  </tr> 
  <tr>
  <td colspan=3 style='text-align: center; background-color: #d2d6ff;'>
    <div >
    <table cellpadding=0 cellspacing=0 border=0 width=93% style='font-size: 11; margin-left: 12;'>
    <col width=17%><col width=14%><col width=14%><col width=5%> <col width=15%><col width=15%><col width=15%><col width=5%>
    <tr>
    <td style='text-align: center; background-color: #d2d6ff;'>Банк</td>
    <td style='text-align: center; background-color: #d2d6ff;'>Дата 1</td>
    <td style='text-align: center; background-color: #d2d6ff;'>Дата 2</td>
    <td style='text-align: center; background-color: #d2d6ff;'>Кол.дней</td>
    <td style='text-align: center; background-color: #d2d6ff;'>Сумма гашения</td>
    <td style='text-align: center; background-color: #d2d6ff;'>В т.ч. проценты</td>
    <td style='text-align: center; background-color: #d2d6ff;'>Остаток</td>
    <td style='text-align: center; background-color: #d2d6ff;'>Edit</td>
    </tr>
    </table>
    </div>
  </td>
  <td style='text-align: center; background-color: #d2d6ff;'></td>
  </tr>
  <tr height=200>
  <td colspan=3 rowspan=2 valign=top>
  <iframe src='cred_inn_op.php'
      id='frame_list' name='frame_list' frameborder=0
      scrolling=auto style='margin-left: 0; width: 720; height: 430;'>
  </iframe>
  </td>
  <td valign=top>
  <br>
  <span style='float: left;  margin-left: 5;   color: darkblue; font-weight: bold;'>
  Гашение
  </span>
  <br><br><br>
  <form action='cred_inner.php?act=edit' target='hidden_frame' id='form_edit' name='form_edit' method='POST'>
  <input type='hidden' id='mid'  name='mid' value=''>
  <input type='hidden' id='pre'  name='pre' value=''>
    <table border=0 cellspacing=2 cellpadding=2 width=100% style='font-size: 11;' >
    <col width=50%><col width=50%>
    <tr>
    <td align=right>Дата гашения:</td>
    <td>
    <input type='text' id='e_date' name='e_date' value='' class='inp_txt' style='width: 70; color: black;'>
    </td>
    </tr>
    <tr>
    <td align=right>Сумма гашения:</td>
    <td>
    <input type='text' id='e_summ' name='e_summ' value='' class='inp_dec' style='width: 70; color: black;'>
    </td>
    </tr>
    <tr height=30 valign=bottom>
    <td colspan=2 align=right>
    <a href="javascript: PreCalc(1);" target="_top" id='b_calc' name='b_calc'    
       style='float: left; margin-left: 25; display: block; font-size: 12; font-weight: bold; text-shadow: 0px 0px 1px #333;'> 
       Расчет</a>
    <a href="javascript: PreCalc(3);" target="_top" id='b_cancel' name='b_cancel'    
       style='float: right; margin-right: 5; display: block; font-size: 12;  font-weight: bold; text-shadow: 0px 0px 1px #333;'>
       Отмена</a>
    <a href="javascript: PreCalc(2);" target="_top" id='b_edit' name='b_edit'    
       style='float: right; margin-right: 15; display: block; font-size: 12;  font-weight: bold; text-shadow: 0px 0px 1px #333;'>
       Погасить</a>
    </td>
    </tr>
    </table>
    </form>
  </td>
  </tr>
  <tr height=230 >
  <td valign=top style='background-image: url(/pics/images5.jpg); background-position: right bottom; background-repeat: no-repeat;'>
  </td>
  </tr> 
  </table>
 </div>
 </div>
 </td>
 <td width=10% valign=top></td>
 </tr>
 </table>

 <?php
  echo '<script>Init();</script>';
  $err = ShowSumm(-1);
 ?>
 
 <?php
 // foot params
 $no_graph_foot = 0;
 require('foot.php');
 // ---
?>

