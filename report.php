<?php
 // head params
 $page_name         = 'reports';
 $page_cap          = 'Отчет';
 $show_cap          = 0;
 $no_graph_head     = 0;
 $is_frame          = 0;
 $prev_page_must_be = ''; // Example: "page1,page2,page3"
 $no_refresh        = 0;
 require('head.php');
 // ---
 // page
$rep=asif($rep);
?>
<script>
function start_report(par) {
 document.getElementById('btn_go').style.display='none';
 document.getElementById("rep_form").submit();
 document.getElementById('btn_file').style.display='block';
}
function show_date(txt_date, par) {
 document.getElementById('btn_go').style.display='block';
 document.getElementById('rep_date').innerHTML=txt_date;
 if (par==1) {
 document.getElementById('span_go').innerHTML='Пересчитать';
 }
 else {
 document.getElementById('btn_go').style.display='none';
 }
}
function out2file(rep) {
 //alert("reports/"+rep+"_2file.php");
 document.getElementById("hidden_frame").src="reports/"+rep+"_2file.php";
 //alert(2);
}
</script>



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
  Отчет:</span>
  </td>
  <td></td>
 </tr>
 <tr height=20>
  <td></td>
  <td align=left ><span style='font-size: 12; color: black;'>
  <?=quick_select('SELECT ru_name FROM reports WHERE name="'.$rep.'" AND status>0')?>
  </span>
  <span name='rep_date' id='rep_date' style='font-size: 12; color: black;'></span>
  </td>
  <td></td>
 </tr>
 <tr height=20>
  <td></td>
  <td>
<form name='rep_form' id='rep_form' action="report_show.php?rep=<?=$rep?>" method="POST" target='ifr'>
<?php
 if ($params==1) {
  require('reports/'.$rep.'_params.php');
 }
?>
  </td>
  <td></td>
 </tr>
 </table>
 <br>
 
 <a href="javascript: start_report(<?=$params?>);" id='btn_go'   name='btn_go' 
    style='float: left; margin-left: 70; font-size: 12; font-weight: bold; font-style: italic; color: #868bff;'>
    <span id='span_go' name='span_go' style='font-size: 12; font-style: italic;'>
    Запустить расчет
    </span></a>
    <br>
 <!--
 <a href="javascript: out2file('<?=$rep?>');"    id='btn_file' name='btn_file'  
    style='display: none; float: left; margin-left: 70; font-size: 12; font-weight: bold; font-style: italic; color: #868bff;'>
    Вывести в файл</a>
 
 <br>
 -->
</form>
<br>
<iframe id='ifr' name='ifr' frameborder=0 src='' width=1750 height=500
style='padding: 20; padding-top: 10; padding-bottom: 10; background-color: white; border-style: solid; border-color: silver; border-width: 1;'>
</iframe><br><br><br>
<iframe src='' id='hidden_frame' name='hidden_frame' frameborder=0
        scrolling=none style='width: 1; height: 1;'>
</iframe>
<?php
 // ---
 // foot params
 $no_graph_foot = 0;
 require('foot.php');
 // ---
?>
