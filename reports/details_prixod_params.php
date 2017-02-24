<?php
//$sdat1 = sprintf("01.%02d.%04d", date('m'), date('Y'));
$s_date1 = date("01.m.Y");
$s_date2 = date("d.m.Y");
?>


<br>
<table cellspacing=0 cellpadding=0 border=0>
<tr valign=top height=40>
 <td style='font-size: 12; font-style: italic;' width=70>
  Начало периода:
 </td>
 <td style='font-size: 12; font-style: italic;'>
  <input type='text' id='s_date1' name='s_date1' class='inp_txt' value='<?=$s_date1;?>'>&nbsp;<big>*</big><br>
  <small>*Формат: 01.01.2012</small>
 </td>
</tr>
<tr valign=top height=40>
 <td style='font-size: 12; font-style: italic;' width=70>
  Окончание периода:
 </td>
 <td style='font-size: 12; font-style: italic;'>
  <input type='text' id='s_date2' name='s_date2' class='inp_txt' value='<?=$s_date2;?>' >&nbsp;<big>*</big><br>
  <small>*Формат: 31.12.2012</small>
 </td>
</tr>
</table>