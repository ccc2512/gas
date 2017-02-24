<?php
 // head params
 $page_name         = 'buh_inn_sub';
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

 if (ctype_digit($catid)) {
   $res=mysql_query('
   SELECT
    id,
    name,
    op,
    rating
   FROM
    cat
   WHERE
    id = "'.$catid.'"
   ');
   if (@mysql_num_rows($res)==1) {
    $catname = mysql_result($res, $i, 'name');
    $op = mysql_result($res, $i, 'op');
   }
 }
 
$res=mysql_query('
 SELECT
  id,
  status,
  name
 FROM
  subcat
 WHERE
  status = 1 and cat_id = '.$catid.' and user_id = '.$uid.'
 ORDER BY rating DESC
 ');
 //if ($op==1&&@mysql_num_rows($res)<1) {$temp_echo='Выберите категорию..';}
 $temp_echo='Выберите категорию..';
 //if (@mysql_num_rows($res)<1) {$temp_echo='Нет..';}
 //if ($op==2) {$temp_echo='Нет';}
 if (@mysql_num_rows($res)<1) { echo $temp_echo; } else {
 echo "<table cellpadding=0 cellspacing=0 border=0 width=100% style='font-size: 11; '>";
 echo "<col width=95%><col width=5%>";
 for($i=0; $i<mysql_num_rows($res); $i++) {
    echo '<tr  onMouseOver="prev_color = this.style.backgroundColor; this.style.backgroundColor=\'#D2D6FF\';" 
              onMouseOut="this.style.backgroundColor=prev_color_contr;"
              id="a_gas_lnk_'.mysql_result($res, $i, 'id').'" name="a_gas_lnk_'.mysql_result($res, $i, 'id').'">
      <td style="text-align: left;">
        <a href="javascript: top.subcategory(\''.mysql_result($res, $i, 'id').'\', \''.mysql_result($res, $i, 'name').'\');">'
         .mysql_result($res, $i, 'name').'</a>
      </td>
      <td style="text-align: center;">
        <a href="javascript: top.sub_del(\''.$op.'\', \''.$catid.'\', \''.mysql_result($res, $i, 'id').'\');" style="color: red;"><b> x </b></a>
      </td>
      </tr>';
  } // for
  echo "</table>";
 }
?>
</div>

<?php
  //echo '<script>top.category(\''.$catid.'\', \''.$catname.'\');</script>';
 ?>

<?php
 // foot params
 $no_graph_foot = 0;
 require('foot.php');
 // ---
?>
