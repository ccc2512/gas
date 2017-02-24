<?php
 // head params
 $page_name         = 'buh_inn_cat';
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
$res=mysql_query('
 SELECT
  id,
  status,
  name,
  op
 FROM
  cat
 WHERE
  status = 1 and op = '.$op.' and user_id = '.$uid.'
 ORDER BY rating DESC
 ');
 
 if (@mysql_num_rows($res)<1) { echo 'Выберите вид операции..'; } else {
 echo "<table cellpadding=0 cellspacing=0 border=0 width=100% style='font-size: 11; '>";
 echo "<col width=95%><col width=5%>";
 for($i=0; $i<mysql_num_rows($res); $i++) {
    echo '<tr  onMouseOver="prev_color = this.style.backgroundColor; this.style.backgroundColor=\'#D2D6FF\';" 
              onMouseOut="this.style.backgroundColor=prev_color_contr;"
              id="a_gas_lnk_'.mysql_result($res, $i, 'id').'" name="a_gas_lnk_'.mysql_result($res, $i, 'id').'">
      <td style="text-align: left;">
        <a href="javascript: top.category(\''.mysql_result($res, $i, 'op').'\', \''.mysql_result($res, $i, 'id').'\', \''.mysql_result($res, $i, 'name').'\');">'
         .mysql_result($res, $i, 'name').'</a>
      </td>
      <td style="text-align: center;">
        <a href="javascript: top.cat_del(\''.mysql_result($res, $i, 'id').'\', \''.mysql_result($res, $i, 'op').'\');" style="color: red;"><b> x </b></a>
      </td>
      </tr>';
  } // for
  echo "</table>";
 }

//        <a href="buh_inn_sub.php?op='.$op.'&catid='.mysql_result($res, $i, 'id').'" target="frame_sub">
//        '.mysql_result($res, $i, 'name').'</a> 
 
 
 
?>
</div>

<?php
 // foot params
 $no_graph_foot = 0;
 require('foot.php');
 // ---
?>
