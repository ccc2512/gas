<?php
 // head params
 $page_name         = 'my_buh';
 $page_cap          = 'Моя бухгалтерия';
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
 function init(beg_date, end_date) {
  //document.getElementById("hidden_frame").src="buh_calc.php";
  //document.getElementById("hidden_frame").src="buh_calc.php?act=recal";
  // потом убрать recal после того как будет сделана правка balance после каждой операции
  
  var mod = document.getElementById("s_diagramm").value;
  document.getElementById("i_beg_date").value=beg_date;
  document.getElementById("i_end_date").value=end_date;
  document.getElementById("frame_diagramm").src="buh_diagramm.php?mod="+mod+"&&b_date="+beg_date+"&&e_date="+end_date;
 }
 function filter() {
  var val_filt = document.getElementById("filter_cat").value;
  var beg_date = document.getElementById("i_beg_date").value;
  var end_date = document.getElementById("i_end_date").value;
  var mod      = document.getElementById("s_diagramm").value;
  //alert('val_filt = '+val_filt);
  //alert('beg_date = '+beg_date);
  //alert('end_date = '+end_date);
  //alert('mod      = '+mod);
  document.getElementById("frame_op").src="buh_inn_op.php?filt="+val_filt+"&&b_date="+beg_date+"&&e_date="+end_date;
  document.getElementById("frame_diagramm").src="buh_diagramm.php?mod="+mod+"&&b_date="+beg_date+"&&e_date="+end_date;
 }
 function diagramm() {
  var beg_date = document.getElementById("i_beg_date").value;
  var end_date = document.getElementById("i_end_date").value;
  var mod      = document.getElementById("s_diagramm").value;
  document.getElementById("frame_diagramm").src="buh_diagramm.php?mod="+mod+"&&b_date="+beg_date+"&&e_date="+end_date;
  //alert('mod      = '+mod);
 }
 function show_filt(str_filt, dat_filt) {
  document.getElementById("span_filt").innerHTML=str_filt;
  document.getElementById("span_period").innerHTML=dat_filt;
 }
 function show_ost(ost_isx_1, ost_isx_2, ost_isx_3, ost_isx_4, ost_isx_5, ost_isx_6, ost_isx_7) {
  //alert('ost_isx_1 = '+ost_isx_1);
  document.getElementById("isx_ost1").value=ost_isx_1;
  document.getElementById("isx_ost2").value=ost_isx_2;
  document.getElementById("isx_ost3").value=ost_isx_3;
  //document.getElementById("isx_ost4").value=ost_isx_4;
  document.getElementById("isx_ost5").value=ost_isx_5;
  document.getElementById("isx_ost6").value=ost_isx_6;
  document.getElementById("isx_ost7").value=ost_isx_7;
 }
 function op_add() {
  document.getElementById("form_add").submit();
 }
 function cat_add(op, catid, catname) {
  document.getElementById("tadd_cat").value='';
  document.getElementById("frame_cat").src="buh_inn_cat.php?op="+op;
  document.getElementById("frame_sub").src="buh_inn_sub.php?op="+op+"&catid="+catid;
  document.getElementById("op_cat_name").value=catname;
 }
 function sub_add(subid, catid, subname) {
  document.getElementById("tadd_sub").value='';
  document.getElementById("frame_sub").src="buh_inn_sub.php?catid="+catid;
 }
 function op_debet() {
  var today = new Date();
  var curdate = today.getDate()+'/'+(today.getMonth()+1)+'/'+today.getFullYear();
  document.getElementById("f_op_vid").value=1;
  document.getElementById("cat_add_op").value=1;
  document.getElementById("f_op_date").value=curdate;
  document.getElementById("op_name").value='Расход';
  document.getElementById("op_cat_name").value='';
  document.getElementById("op_sub_name").value='';
  document.getElementById("f_acc_id").value=0;
  document.getElementById("f_op_summ").value=0.00;
  document.getElementById("titl_acc").innerHTML='Расход из:';
  document.getElementById("form_debet").submit();
  document.getElementById("form_sub").submit();
 }
 function op_credit() {
  var today = new Date();
  var curdate = today.getDate()+'/'+(today.getMonth()+1)+'/'+today.getFullYear();
  document.getElementById("f_op_vid").value=2;
  document.getElementById("cat_add_op").value=2;
  document.getElementById("f_op_date").value=curdate;
  document.getElementById("op_name").value='Доход';
  document.getElementById("op_cat_name").value='';
  document.getElementById("op_sub_name").value='';
  document.getElementById("f_acc_id").value=0;
  document.getElementById("f_op_summ").value=0.00;
  document.getElementById("titl_acc").innerHTML='Доход в:';
  document.getElementById("form_credit").submit();
  document.getElementById("form_sub").submit();
 }
 function category(op, catid, catname) {
  document.getElementById("f_cat_id").value=catid;
  document.getElementById("sub_add_catid").value=catid;
  document.getElementById("f_sub_id").value=-1;
  document.getElementById("op_cat_name").value=catname;
  document.getElementById("op_sub_name").value='';
  document.getElementById("frame_sub").src="buh_inn_sub.php?op="+op+"&catid="+catid;
 }
 function subcategory(subid, subname) {
  document.getElementById("f_sub_id").value=subid;
  document.getElementById("op_sub_name").value=subname;
 }
 function buh_fresh(op, catname, subname) {
  document.getElementById("op_name").value='';
  document.getElementById("op_cat_name").value='';
  document.getElementById("op_sub_name").value='';
  document.getElementById("f_acc_id").value=0;
  document.getElementById("f_op_summ").value=0.00;
  document.getElementById("f_op_vid").value=-1;
  document.getElementById("form_sub").submit();
  //alert('4');
 }
 function op_del(id) {
  if (confirm("Удалить запись?")) {
  //alert('1');
  //alert('id='+id);
  document.getElementById("hidden_frame").src="buh_inner.php?act=del_op&opid="+id;
  //alert('2');
  }
 }
 function cat_del(catid, op) {
  if (confirm("Удалить запись?")) {
  document.getElementById("hidden_frame").src="buh_inner.php?act=cat_del&catid="+catid+"&op="+op;
  }
 }
 function sub_del(op, catid, subid) {
  if (confirm("Удалить запись?")) {
   document.getElementById("hidden_frame").src="buh_inner.php?act=sub_del&op="+op+"&catid="+catid+"&subid="+subid;
   document.getElementById("f_sub_id").value=-1;
   document.getElementById("op_sub_name").value='';
  }
 }
 function sub_fresh(op, catid) {
  document.getElementById("frame_sub").src="buh_inn_sub.php?op="+op+"&catid="+catid;
 }
 </script>
 <!--
 
 -->
 
 <?php
   //Расчет остатков
   $ost_isx_1 = ShowOst(1);
   $ost_isx_2 = ShowOst(2);
   $ost_isx_3 = ShowOst(3);
   $ost_isx_4 = ShowOst(4);
   $ost_isx_5 = ShowOst(5);
   $ost_isx_6 = ShowOst(6);
   $ost_isx_7 = ShowOst(7);
      
   $i_beg_date = date("01.m.Y");
   $i_end_date = date("d.m.Y");
   
 ?>
 
 
 <table border=0 cellspacing=0 cellpadding=0 width=100% height=90% valign=top >
 <col width=10%><col width=1000><col width=10%>
 <tr>
 <td width=10% valign=top></td>
 <td width=1000 valign=top>
 <div class='gas_div' style='border-color: silver; display: block; margin-top: 10;' id='div_gas' name='div_gas'>
 <span id='gas_cap' name='gas_cap' style='color: blue; font-size: 20; font-style: italic; font-weight: bold; text-shadow: 0px 0px 1px #333;'>
 Моя бухгалтерия</span>
 <div class='form_div'>
  <table border=0 rules=all cellspacing=0 cellpadding=2 width=100% style='font-size: 11;' >
  <col width=25%><col width=25%><col width=25%><col width=25%>
  <tr>
  <td colspan=3 valign=bottom >
    Диаграмма: 
    <Select name="s_diagramm" id="s_diagramm" style='font-size: 11; width: 250;' onChange='diagramm();'>
      <Option Value="1">Структура расходов
      <Option Value="8">Остатков SMP Card
      <Option Value="3">Остатков карты Open Debet
      <Option Value="4">Остатков карты Open Credit
      <Option Value="5">Остатков карты Open Web
      <Option Value="6">Остатков карты SberCard
	  <Option Value="2">Остатков карты СКБ банка
      <Option Value="7">Остатков кошелька
      <Option Value="9">Чего-то ещё
    </Select>
    
    <a href="buh_calc.php?act=recal"    target="hidden_frame" id='buh_recal'  name='buh_recal'    
                                        style='float: right; margin-right: 10; display: block;'>Full Recalculation</a>
                                        
  </td>
  <td valign=center>
  С: 
  <input type='text' id='i_beg_date' name='i_beg_date' value='<?=$i_beg_date;?>' class='inp_txt' style='width: 65; color: black;'>
  по 
  <input type='text' id='i_end_date' name='i_end_date' value='<?=$i_end_date;?>' class='inp_txt' style='width: 65; color: black;'>
  <a href="javascript: filter();" target="_top" id='refresh_date'   name='refresh_date'    
     style='display: block; font-size: 11;  font-weight: bold; text-shadow: 0px 0px 1px #333; float: right; margin-right: 10;'>
  Применить</a>
  </td>
  </tr>
  <tr height=200>
  <td colspan=3 valign=bottom>
    <iframe src='buh_diagramm.php?' 
      id='frame_diagramm' name='frame_diagramm' frameborder=0
      scrolling=auto style='margin-left: 0; width: 670; height: 200;'>
    </iframe>
  </td>
  <td>
    <table border=0 cellspacing=2 cellpadding=2 width=100% style='font-size: 11;' >
    <col width=50%><col width=50%>
    
    <tr>
    <td align=left><b><i>Текущие остатки:</i></b></td>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td align=right>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td align=right style='color: blue;'>Кошелёк:</td>
    <td>
    <input type='text' id='isx_ost1' name='isx_ost1' readonly value='' class='inp_dec' style='width: 70; color: black;'>
    </td>
    </tr>
    <tr>
    <td align=right style='color: blue;'>SMP Card:</td>
    <td>
    <input type='text' id='isx_ost7' name='isx_ost7' readonly value='' class='inp_dec' style='width: 70; color: black;'>
    </td>
    </tr>
  	<tr>
    <td align=right style='color: green;'>Openbank Debet:</td>
    <td>
    <input type='text' id='isx_ost3' name='isx_ost3' readonly value='' class='inp_dec' style='width: 70; color: black;'>
    </td>
    </tr>
	<!--
    <tr>
	<td align=right style='color: red;'>Openbank Credit:</td>
    <td>
    <input type='text' id='isx_ost4' name='isx_ost4' readonly value='' class='inp_dec' style='width: 70; color: black;'>
    </td>
    </tr>
	-->
    <tr>
    <td align=right style='color: red;'>Webmoney:</td>
    <td>
    <input type='text' id='isx_ost5' name='isx_ost5' readonly value='' class='inp_dec' style='width: 70; color: black;'>
    </td>
    </tr>
    <tr>
    <td align=right style='color: green;'>SberCard:</td>
    <td>
    <input type='text' id='isx_ost6' name='isx_ost6' readonly value='' class='inp_dec' style='width: 70; color: black;'>
    </td>
    </tr>
	<tr>
    <td align=right style='color: blue;'>Карта СКБ банка:</td>
    <td>
    <input type='text' id='isx_ost2' name='isx_ost2' readonly value='' class='inp_dec' style='width: 70; color: black;'>
    </td>
    </tr>
  	<tr>
    </table>
  </td>
  </tr> 
  <tr>
  <td style='text-align: center; background-color: #d2d6ff;'><b>1. Вид операции</b></td>
  <td style='text-align: center; background-color: #d2d6ff;'><b>2. Категория</b></td>
  <td style='text-align: center; background-color: #d2d6ff;'><b>3. Подкатегория</b></td>
  <td style='text-align: center; background-color: #d2d6ff;'><b>4. Совершение операции</b></td>
  </tr>
  <tr height=200>
  <td>
  <form action='buh_inn_cat.php?op=1' target='frame_cat' id='form_debet' name='form_debet' method='POST'>
    <input type='hidden' id='op'  name='op' value='1'>
    <a href="javascript: op_debet();"  target="_top" id='buh_debet'   name='buh_debet'    
       style='float: right; margin-right: 90; display: block; font-size: 20; font-style: italic; font-weight: bold; text-shadow: 0px 0px 1px #333;'>
       Расход</a>
  </form>
  <br>
  <br>
  <br>
  <br>
  <form action='buh_inn_cat.php?op=2' target='frame_cat' id='form_credit' name='form_credit' method='POST'>
    <input type='hidden' id='op'  name='op' value='2'>
    <a href="javascript: op_credit();"  target="_top" id='buh_credit'   name='buh_credit'    
       style='float: right; margin-right: 90; display: block; font-size: 20; font-style: italic; font-weight: bold; text-shadow: 0px 0px 1px #333;'>
       Доход</a>
  </form>
  </td>
  <td valign=top>
  <form action='buh_inn_cat.php?op=<?=$op?>' target='frame_cat' id='form_cat' name='form_cat' method='POST'>
  <iframe src='buh_inn_cat.php?op=<?=$op?>' 
      id='frame_cat' name='frame_cat' frameborder=0
      scrolling=auto style='margin-left: 0; width: 230; height: 120;'>
  </iframe>
  </form>
  <br><br>
  <!-- Add category --> <!-- Add category --><!-- Add category --><!-- Add category --><!-- Add category --><!-- Add category -->
  <form action='buh_inner.php?act=cat_add' target='hidden_frame' id='form_cat_add' name='form_cat_add' method='POST'>
  <input type='text' id='tadd_cat'   name='tadd_cat' value='' 
  class='inp_txt' style='width: 200; color: black; float: left; margin-left: 10;'>
  <input type='hidden' id='cat_add_op'  name='cat_add_op' value=''>
  <input type='image' src='/pics/img2.jpg' alt='Добавить категорию' id='tbuh_cat' name='tbuh_cat' 
         style='float: right; margin-right: 10;'>
  </form>
  <!-- Add category --> <!-- Add category --><!-- Add category --><!-- Add category --><!-- Add category --><!-- Add category -->
  </td>
  <td valign=top> 
  <form action='buh_inn_sub.php?catid=<?=$catid?>' target='frame_sub' id='form_sub' name='form_sub' method='POST'>
  <iframe src='buh_inn_sub.php?catid=<?=$catid?>' 
      id='frame_sub' name='frame_sub' frameborder=0
      scrolling=auto style='margin-left: 0; width: 230; height: 120;'>
  </iframe>
  </form>
  <br><br>
  <!-- Add subcategory --><!-- Add subcategory --><!-- Add subcategory --><!-- Add subcategory --><!-- Add subcategory -->
  <form action='buh_inner.php?act=sub_add' target='hidden_frame' id='form_sub_add' name='form_sub_add' method='POST'>
  <input type='text' id='tadd_sub'   name='tadd_sub' value='' 
  class='inp_txt' style='width: 200; color: black; float: left; margin-left: 10;'>
  <input type='hidden' id='sub_add_catid'  name='sub_add_catid' value=''>
  <input type='image' src='/pics/img2.jpg' alt='Добавить подкатегорию' id='tbuh_subcat' name='tbuh_subcat' 
         style='float: right; margin-right: 10;'>
  </form>
  <!-- Add subcategory --><!-- Add subcategory --><!-- Add subcategory --><!-- Add subcategory --><!-- Add subcategory -->
  </td>
  <td>
    <form action='buh_inner.php?act=add' target='hidden_frame' id='form_add' name='form_add' method='POST'>
    <input type='hidden' id='f_op_vid'  name='f_op_vid'>
    <input type='hidden' id='f_cat_id'  name='f_cat_id'>
    <input type='hidden' id='f_sub_id'  name='f_sub_id'>
    <iframe src='' id='hidden_frame' name='hidden_frame' frameborder=0
            scrolling=none style='width: 1; height: 1;'>
    </iframe>
    <table border=0 cellspacing=2 cellpadding=2 width=100% style='font-size: 11;' >
    <col width=50%><col width=50%>
    <tr>
    <td align=right>Дата операции:</td>
    <td>
    <input type='text' id='f_op_date'      name='f_op_date'                 value='' class='inp_txt' style='width: 70; color: black;'>
    </td>
    </tr>
    <tr>
    <td align=right>Вид операции:</td>
    <td>
    <input type='text' id='op_name'      name='op_name'       readonly  value='' class='inp_txt' style='width: 130; color: black;'>
    </td>
    </tr>
    <tr>
    <td align=right>Категория:</td>
    <td>
    <input type='text' id='op_cat_name'  name='op_cat_name'   readonly  value='' class='inp_txt' style='width: 130; color: black;'>
    </td>
    </tr>
    <tr>
    <td align=right>Подкатегория:</td>
    <td>
    <input type='text' id='op_sub_name'  name='op_sub_name'   readonly  value='' class='inp_txt' style='width: 130; color: black;'>
    </td>
    </tr>
    <tr>
    <td align=right><span id='titl_acc' name='titl_acc'>Счет:</span></td>
    <td>
    <Select name="f_acc_id" id="f_acc_id" style='font-size: 11; width: 130;'>
        <?php
        $res = mysql_query("SELECT id, name FROM accounts WHERE status = 1 ORDER BY id");
        for ($i=0; $i<mysql_num_rows($res); $i++){
          echo '<Option Value="'.mysql_result($res,$i,'id').'">'.mysql_result($res,$i,'name');
        }
        ?>
    </Select>
    </td>
    </tr>
    <tr>
    <td align=right>Сумма:</td>
    <td>
    <input type='text' id='f_op_summ' name='f_op_summ' value='' class='inp_dec' style='width: 70; color: black;'>
    </td>
    </tr>
    <tr height=30 valign=bottom>
    <td align=right></td>
    <td align=left>
    <a href="javascript: op_add();"      target="_top" id='buh_add'   name='buh_add'    
       style='display: block; font-size: 14;  font-weight: bold; text-shadow: 0px 0px 1px #333;'>
       Акцептовать</a>
    </td>
    </tr>
    </table>
    </form>
  </td>
  </tr>
  <tr>
  <td style='background-color: #d2d6ff;' colspan=4>
    <div >
    <table cellpadding=0 cellspacing=0 border=0 width=98% style='font-size: 11; margin-left: 12;'>
    <col width=12%><col width=12%><col width=25%><col width=26%> <col width=12%><col width=12%>
    <tr>
    <td style='text-align: center;'>Дата</td>
    <td style='text-align: center;'>Вид операции</td>
    <td style='text-align: center;'>
      <Select name="filter_cat" id="filter_cat" style="font-size: 11; width: 230; background-color: #d2d6ff;" onChange="filter();">
          <?php
          $res = mysql_query("
          SELECT 
            id, 
            CASE WHEN id = 0 THEN '' WHEN op = 1 THEN 'Расход-' WHEN op = 2 THEN 'Доход-' ELSE '' END vid,
            name,            
            rating
          FROM cat 
          WHERE user_id = ".$uid." or id = 0
          ORDER BY op, rating DESC, name
          ");
          for ($i=0; $i<mysql_num_rows($res); $i++){
            echo '<Option Value="'.mysql_result($res,$i,'id').'">'.mysql_result($res,$i,'vid').''.mysql_result($res,$i,'name');
          }
          ?>
      </Select>
    </td>
    <td style='text-align: center;'>Подкатегория</td>
    <td style='text-align: center;'>Счет</td>
    <td style='text-align: center;'>Сумма</td>
    </tr>
    </table>
    </div>
  </td>
  </tr>
  <tr>
  <td  colspan=4>
    <span id='span_period' name='span_period' style='float: left; color: blue;'></span>
    <span id='span_filt'   name='span_filt'   style='float: right; color: blue;'></span>
  </td>
  </tr>
  <tr height=200>
  <td colspan=4 valign=top>
  <iframe src='buh_inn_op.php?'
      id='frame_op' name='frame_op' frameborder=0
      scrolling=auto style='margin-left: 0; width: 970; height: 190;'>
  </iframe>
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
  echo '<script>filter();</script>';
 ?>
 <?php
  echo '<script>buh_fresh(\''.$op.'\', \''.$catname.'\', \''.$subname.'\');</script>';
 ?>
 <?php
  echo '<script>show_ost(\''.$ost_isx_1.'\', \''.$ost_isx_2.'\', \''.$ost_isx_3.'\', \''.$ost_isx_4.'\', \''.$ost_isx_5.'\', \''.$ost_isx_6.'\', \''.$ost_isx_7.'\');</script>';
 ?>
 <?php
  echo '
  <script>
  var beg_date = document.getElementById("i_beg_date").value;
  var end_date = document.getElementById("i_end_date").value;
  //alert(\'BD = \'+beg_date);
  init(beg_date, end_date);
  </script>';
 ?>
  
 <?php
 // foot params
 $no_graph_foot = 0;
 require('foot.php');
 // ---
?>
