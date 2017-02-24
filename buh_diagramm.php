<?php
 // head params
 $page_name         = 'buh_diagramm';
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

<table border=0 cellspacing=1 cellpadding=1 width=100% style='font-size: 11;' >
<tr valign=bottom height=170>
<?php
  if ($mod==1) {    //расходы
    $b_date = str2u($b_date);
    $e_date = str2u($e_date);
    if ($b_date!=-1) {$query .= ' and o.op_date >= '.$b_date; }
    if ($e_date!=-1) {$query .= ' and o.op_date <= '.$e_date; }
    $resm=mysql_query('
      Select MAX(x1.sum_by_cat) max100 FROM (
        SELECT
          c.name, 
          sum(o.op_summ) sum_by_cat
        FROM
          cat c, op o
        WHERE
          c.op = 1 and c.id = o.cat_id and c.status = 1 and o.status = 1 and c.user_id = '.$uid.' 
		  and c.id <> 100 and c.id <> 101 and c.id <> 119 and c.id <> 120 and c.id <> 124 and c.id <> 125 and c.id <> 127 and c.id <> 129
          '.$query.'
        GROUP BY o.cat_id 
      ) x1
    ');
    
    $res=mysql_query('
     SELECT
      c.name, 
      sum(o.op_summ) sss
     FROM
      cat c, op o
     WHERE
      c.op = 1 and c.id = o.cat_id and c.status = 1 and o.status = 1 and c.user_id = '.$uid.' and c.isoborot = 1
	  and c.id <> 100 and c.id <> 101 and c.id <> 119 and c.id <> 120 and c.id <> 124 and c.id <> 125 and c.id <> 127 and c.id <> 129
      '.$query.'
     GROUP BY o.cat_id
    ');
    $perc_all = 0;
    for($i=0; $i<mysql_num_rows($res); $i++) {
      $perc_all = $perc_all + mysql_result($res, $i, 'sss');
    }
    for($i=0; $i<mysql_num_rows($res); $i++) {
      $temp_height = 0;
      $temp_height = round(((mysql_result($res, $i, 'sss'))/(mysql_result($resm, 0, 'max100')))*100, 0);
      if ($perc_all!=0) {
        $temp_perc   = round(((mysql_result($res, $i, 'sss'))/$perc_all)*100, 0);
      } else {
        $temp_perc = 0;
      }
      //echo '<td><div style="filter=\'progid:DXImageTransform.Microsoft.BasicImage(rotation=3)\';width:40;">текст</div> </td>';
      //echo '<div style="writing-mode : tb-rl; width:1px;">text</div>';
      if ($temp_perc >= 1) {
        echo '<td align=center valign=bottom style="width: 10"><div class="vertical-text">'
               .mysql_result($res, $i, 'name').' - '
               .$temp_perc.'%</div></td>';
        echo '<td align=center valign=bottom><input type="text" id="graph'.$i.'" name="graph'.$i.'" readonly 
              value="" class="inp_dec" style="background-color: navy;  height: '.$temp_height.'; width: 30;"></td>';
      }
    } // for
  } //if ($mod==1)
  
  if ($mod==2) {    //Остатки на карте СКБ
    $b_date = str2u($b_date);
    $e_date = str2u($e_date);
    if ($b_date!=-1) {$query .= ' and bal_date >= '.$b_date; }
    if ($e_date!=-1) {$query .= ' and bal_date <= '.$e_date; }
    $resm=mysql_query('
      SELECT 
        MAX(isx) isx100 
      FROM   
        balance
      WHERE  
        status = 1 and user_id = '.$uid.' and acc_id = 2
        '.$query.'
    ');
    
    $res=mysql_query('
     SELECT
      isx,
      acc_id,
      bal_date
     FROM
      balance
     WHERE
      status = 1 and user_id = '.$uid.'  and acc_id = 2
      '.$query.'
      ORDER BY bal_date
    ');
    for($i=0; $i<mysql_num_rows($res); $i++) {
      $temp_height = 0;
      $temp_height = round(((mysql_result($res, $i, 'isx'))/(mysql_result($resm, 0, 'isx100')))*100, 0);
      $temp_date = date("d/m/Y", mysql_result($res, $i, 'bal_date'));
      echo '<td align=center valign=bottom style="width: 10"><div class="vertical-text">'
             .$temp_date.'</div></td>';
      echo '<td align=center valign=bottom><input type="text" id="isx'.$i.'" name="isx'.$i.'" readonly 
            value="" class="inp_dec" style="background-color: navy;  height: '.$temp_height.'; width: 10;"></td>';
    } // for
  } //if ($mod==2)
  
  if ($mod==3) {    //Остатки на карте Open Debet
    $b_date = str2u($b_date);
    $e_date = str2u($e_date);
    if ($b_date!=-1) {$query .= ' and bal_date >= '.$b_date; }
    if ($e_date!=-1) {$query .= ' and bal_date <= '.$e_date; }
    $resm=mysql_query('
      SELECT 
        MAX(isx) isx100 
      FROM   
        balance
      WHERE  
        status = 1 and user_id = '.$uid.' and acc_id = 3
        '.$query.'
    ');
    
    $res=mysql_query('
     SELECT
      isx,
      acc_id,
      bal_date
     FROM
      balance
     WHERE
      status = 1 and user_id = '.$uid.'  and acc_id = 3
      '.$query.'
      ORDER BY bal_date
    ');
    for($i=0; $i<mysql_num_rows($res); $i++) {
      $temp_height = 0;
      $temp_height = round(((mysql_result($res, $i, 'isx'))/(mysql_result($resm, 0, 'isx100')))*100, 0);
      $temp_date = date("d/m/Y", mysql_result($res, $i, 'bal_date'));
      echo '<td align=center valign=bottom style="width: 10"><div class="vertical-text">'
             .$temp_date.'</div></td>';
      echo '<td align=center valign=bottom><input type="text" id="isx'.$i.'" name="isx'.$i.'" readonly 
            value="" class="inp_dec" style="background-color: navy;  height: '.$temp_height.'; width: 10;"></td>';
    } // for
  } //if ($mod==3)
  
    if ($mod==4) {    //Остатки на карте Open Credit
    $b_date = str2u($b_date);
    $e_date = str2u($e_date);
    if ($b_date!=-1) {$query .= ' and bal_date >= '.$b_date; }
    if ($e_date!=-1) {$query .= ' and bal_date <= '.$e_date; }
    $resm=mysql_query('
      SELECT 
        MAX(isx) isx100 
      FROM   
        balance
      WHERE  
        status = 1 and user_id = '.$uid.' and acc_id = 4
        '.$query.'
    ');
    
    $res=mysql_query('
     SELECT
      isx,
      acc_id,
      bal_date
     FROM
      balance
     WHERE
      status = 1 and user_id = '.$uid.'  and acc_id = 4
      '.$query.'
      ORDER BY bal_date
    ');
    for($i=0; $i<mysql_num_rows($res); $i++) {
      $temp_height = 0;
      $temp_height = round(((mysql_result($res, $i, 'isx'))/(mysql_result($resm, 0, 'isx100')))*100, 0);
      $temp_date = date("d/m/Y", mysql_result($res, $i, 'bal_date'));
      echo '<td align=center valign=bottom style="width: 10"><div class="vertical-text">'
             .$temp_date.'</div></td>';
      echo '<td align=center valign=bottom><input type="text" id="isx'.$i.'" name="isx'.$i.'" readonly 
            value="" class="inp_dec" style="background-color: navy;  height: '.$temp_height.'; width: 10;"></td>';
    } // for
  } //if ($mod==4)
  
  if ($mod==5) {    //Остатки на карте Open Web
    $b_date = str2u($b_date);
    $e_date = str2u($e_date);
    if ($b_date!=-1) {$query .= ' and bal_date >= '.$b_date; }
    if ($e_date!=-1) {$query .= ' and bal_date <= '.$e_date; }
    $resm=mysql_query('
      SELECT 
        MAX(isx) isx100 
      FROM   
        balance
      WHERE  
        status = 1 and user_id = '.$uid.' and acc_id = 5
        '.$query.'
    ');
    
    $res=mysql_query('
     SELECT
      isx,
      acc_id,
      bal_date
     FROM
      balance
     WHERE
      status = 1 and user_id = '.$uid.'  and acc_id = 5
      '.$query.'
      ORDER BY bal_date
    ');
    for($i=0; $i<mysql_num_rows($res); $i++) {
      $temp_height = 0;
      $temp_height = round(((mysql_result($res, $i, 'isx'))/(mysql_result($resm, 0, 'isx100')))*100, 0);
      $temp_date = date("d/m/Y", mysql_result($res, $i, 'bal_date'));
      echo '<td align=center valign=bottom style="width: 10"><div class="vertical-text">'
             .$temp_date.'</div></td>';
      echo '<td align=center valign=bottom><input type="text" id="isx'.$i.'" name="isx'.$i.'" readonly 
            value="" class="inp_dec" style="background-color: navy;  height: '.$temp_height.'; width: 10;"></td>';
    } // for
  } //if ($mod==5)
  
    if ($mod==6) {    //Остатки на карте Open Web
    $b_date = str2u($b_date);
    $e_date = str2u($e_date);
    if ($b_date!=-1) {$query .= ' and bal_date >= '.$b_date; }
    if ($e_date!=-1) {$query .= ' and bal_date <= '.$e_date; }
    $resm=mysql_query('
      SELECT 
        MAX(isx) isx100 
      FROM   
        balance
      WHERE  
        status = 1 and user_id = '.$uid.' and acc_id = 6
        '.$query.'
    ');
    
    $res=mysql_query('
     SELECT
      isx,
      acc_id,
      bal_date
     FROM
      balance
     WHERE
      status = 1 and user_id = '.$uid.'  and acc_id = 6
      '.$query.'
      ORDER BY bal_date
    ');
    for($i=0; $i<mysql_num_rows($res); $i++) {
      $temp_height = 0;
      $temp_height = round(((mysql_result($res, $i, 'isx'))/(mysql_result($resm, 0, 'isx100')))*100, 0);
      $temp_date = date("d/m/Y", mysql_result($res, $i, 'bal_date'));
      echo '<td align=center valign=bottom style="width: 10"><div class="vertical-text">'
             .$temp_date.'</div></td>';
      echo '<td align=center valign=bottom><input type="text" id="isx'.$i.'" name="isx'.$i.'" readonly 
            value="" class="inp_dec" style="background-color: navy;  height: '.$temp_height.'; width: 10;"></td>';
    } // for
  } //if ($mod==6)
  
  if ($mod==7) {    //Остатки в кошельке
    $b_date = str2u($b_date);
    $e_date = str2u($e_date);
    if ($b_date!=-1) {$query .= ' and bal_date >= '.$b_date; }
    if ($e_date!=-1) {$query .= ' and bal_date <= '.$e_date; }
    $resm=mysql_query('
      SELECT 
        MAX(isx) isx100 
      FROM   
        balance
      WHERE  
        status = 1 and user_id = '.$uid.' and acc_id = 1
        '.$query.'
    ');
    
    $res=mysql_query('
     SELECT
      isx,
      acc_id,
      bal_date
     FROM
      balance
     WHERE
      status = 1 and user_id = '.$uid.'  and acc_id = 1
      '.$query.'
      ORDER BY bal_date
    ');
    for($i=0; $i<mysql_num_rows($res); $i++) {
      $temp_height = 0;
      $temp_height = round(((mysql_result($res, $i, 'isx'))/(mysql_result($resm, 0, 'isx100')))*100, 0);
      $temp_date = date("d/m/Y", mysql_result($res, $i, 'bal_date'));
      echo '<td align=center valign=bottom style="width: 10"><div class="vertical-text">'
             .$temp_date.'</div></td>';
      echo '<td align=center valign=bottom><input type="text" id="isx'.$i.'" name="isx'.$i.'" readonly 
            value="" class="inp_dec" style="background-color: navy;  height: '.$temp_height.'; width: 10;"></td>';
    } // for
  } //if ($mod==7)
  
  
  
?>
</tr>
</table>

</div>

<?php
 // foot params
 $no_graph_foot = 0;
 require('foot.php');
 // ---
?>
