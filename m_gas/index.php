<?php
 // head params
 $page_name         = 'index';
 $page_cap          = 'Меню';
 $no_graph_head     = 0;
 $secure_page       = 1;
 $is_frame          = 0;
 $prev_page_must_be = ''; // Example: "page1,page2,page3"
 $no_refresh        = 0;
 require_once('head.php');
 // ---
?>
<table border=0 cellspacing=0 cellpadding=0 width=100% height=90%>

 <tr height=30%>
  <td width=40%>&nbsp;&nbsp;&nbsp;</td><td width=300>&nbsp;&nbsp;&nbsp;</td><td width=40%>&nbsp;&nbsp;&nbsp;</td>
 </tr>

 <tr>
  <td>&nbsp;&nbsp;&nbsp;</td><td valign=top align=left>
   <a href='gas.php'    class='menu_item_gas'>Бензин</a>
   <a href='m_gas.php'    class='menu_item_gas'>Бензин (моб)</a>
   <a href='my_buh.php'  class='menu_item_buh'>Моя бухгалтерия</a>
   <a href='my_cred.php'  class='menu_item_cred'>Мои кредиты</a>
   </td><td>&nbsp;&nbsp;&nbsp;</td>
 </tr>

 <tr height=30%>
  <td>&nbsp;&nbsp;&nbsp;</td><td>
   <!-- preload imgs -->
   <img src='/pics/fuel_a.png' width=1 height=1>
   </td><td>&nbsp;&nbsp;&nbsp;</td>
 </tr>

</table>

 <?php
 // foot params
 $no_graph_foot = 0;
 require('foot.php');
 // ---
?>
