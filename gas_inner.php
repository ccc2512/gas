<?php
 // head params
 $page_name         = 'gas_inner';
 $page_cap          = 'Учет расхода бензина';
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

if ($act=='recal') { // ------------------------------- Full Recalculation -------------------------------
$res=mysql_query('
 SELECT
  id
 ,odo
 FROM
  gas
 WHERE
  status = 1 and user_id = "'.$uid.'"
 ORDER BY odo DESC
 ');
 $temp_next_odo = 0;
 $temp_next_id = 0;
 for($i=0; $i<mysql_num_rows($res); $i++) {
    $temp_id   = mysql_result($res, $i, 'id');
    $temp_odo  = mysql_result($res, $i, 'odo');
    mysql_query('
    UPDATE gas
    SET
      user_id  = "'.$uid.'",
      next_odo = "'.$temp_next_odo.'",
      next_id  = "'.$temp_next_id.'"
    WHERE
      id = '.$temp_id.'
    ');
    $temp_next_odo  = $temp_odo;
    $temp_next_id   = $temp_id;
 } //for I
 
 $res=mysql_query('
 SELECT
  id
 FROM
  gas
 WHERE
  status = 1 and user_id = "'.$uid.'"
 ORDER BY odo
 ');
 
 $temp_prev_id = 0;
 for($i=0; $i<mysql_num_rows($res); $i++) {
    $temp_id   = mysql_result($res, $i, 'id');
    mysql_query('
    UPDATE gas
    SET
      prev_id  = "'.$temp_prev_id.'"
    WHERE
      id = '.$temp_id.'
    ');
    $temp_prev_id   = $temp_id;
 } //for I
 
 
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
 ,CASE WHEN id = "'.$gid.'" THEN "_a" ELSE "" END style
 FROM
  gas
 WHERE
  status = 1 and user_id = "'.$uid.'"
 ORDER BY odo
 ');
 if (@mysql_num_rows($res)<1) { echo ''; } else {
 for($i=0; $i<mysql_num_rows($res); $i++) {
    $temp_id   = mysql_result($res, $i, 'id');
    $temp_dat = date("d/m/Y", mysql_result($res, $i, 'z_date'));
    $temp_odo  = mysql_result($res, $i, 'odo');
    $temp_next_odo  = mysql_result($res, $i, 'next_odo');
    $temp_litr = mysql_result($res, $i, 'litr');
    $temp_summ = mysql_result($res, $i, 'summ');
    $temp_rul  = $temp_summ / $temp_litr;
    if (($temp_next_odo - $temp_odo)<0) {$temp_km = 0;} else {$temp_km = ($temp_next_odo - $temp_odo);}
    if ($temp_km==0) {$temp_lkm = 0;} else {$temp_lkm = ($temp_litr*100)/$temp_km;}
    if ($temp_km==0) {$temp_rkm = 0;} else {$temp_rkm = $temp_summ / $temp_km;}
    mysql_query('
    UPDATE gas
    SET
      rubl2litr  = "'.$temp_rul.'",
      km         = "'.$temp_km.'",
      litr2100km = "'.$temp_lkm.'",
      rubl2km    = "'.$temp_rkm.'"
    WHERE
      id = '.$temp_id.'
    ');
  } // for
  
 } //else
} //if ($act=='recal')


if ($act=='add') { // ------------------------------- ADD -------------------------------
  $gas_dat=asif($gas_dat);
  $gas_summ=asif($gas_summ);
  $gas_litr=asif($gas_litr);
  $gas_odo=asif($gas_odo);
  
  // fields check
  $err='';
  //if (!ctype_digit($gid)) { $err.=' Не указан id.'; }
  if (!$gas_dat)          { $err.=' Не указана дата.'; }
  if (!$gas_summ)         { $err.=' Не указана сумма.'; }
  if (!$gas_litr)         { $err.=' Не указано количество литров.'; }
  if (!$gas_odo)          { $err.=' Не указаны показания одометра.'; }
   
  $gas_dat  = str2U($gas_dat);
  $gas_summ = str_replace(",", "", $gas_summ);
  $gas_litr = str_replace(",", "", $gas_litr);
  $gas_odo  = str_replace(",", "", $gas_odo);
    
  $cnt=quick_select('
  SELECT
    COUNT(1)
  FROM
    gas
  WHERE
    odo = "'.$gas_odo.'" and status > 0 and user_id = "'.$uid.'"
  ');
  
  if (mysql_error()) { $err.=' Ошибка при попытке проверки уникальности записи.'; }
  if ($cnt > 0)      { $err.='Такие показания одометра уже существуют.'; }
  
  $cnt=quick_select('
  SELECT
    COUNT(1)
  FROM
    gas
  WHERE
    status = 1 and user_id = "'.$uid.'"
  ');
  
  if (mysql_error()) { $err.=' Ошибка при подсчете записей.'; }
  if ($cnt==0) {
    $last_id   = 0;
    $last_odo  = 0;
    $last_litr = 0;
    $last_summ = 0;
  } else {
    $res=mysql_query('
    SELECT
     id,
     odo,
     litr,
     summ
    FROM
     gas
    WHERE
     status = 1 and user_id = "'.$uid.'"
    ORDER BY odo DESC
    ');
    
    $last_id   = mysql_result($res, 0, 'id');
    $last_odo  = mysql_result($res, 0, 'odo');
    $last_litr = mysql_result($res, 0, 'litr');
    $last_summ = mysql_result($res, 0, 'summ');
  }
  
  if ($gas_odo > $last_odo) {
  
    if (($gas_odo - $last_odo)<0) {$temp_km = 0;} else {$temp_km = ($gas_odo - $last_odo);}
    if ($temp_km==0) {$temp_lkm = 0;} else {$temp_lkm = ($last_litr*100)/$temp_km;}
    if ($temp_km==0) {$temp_rkm = 0;} else {$temp_rkm = $last_summ / $temp_km;}
    
    if ($last_id!==0) {
      mysql_query('
      UPDATE gas
        SET
          km         = "'.$temp_km.'",
          litr2100km = "'.$temp_lkm.'",
          rubl2km    = "'.$temp_rkm.'",
          next_odo   = "'.$gas_odo.'"
      WHERE
        id = '.$last_id.'
      ');
        
      if (mysql_error()) {
        echo mysql_error();
        echo "<script>alert(' Ошибка при изменении записи в таблице!');</script>";
        $err.='Ошибка при изменении записи в таблице!';
      }
    }
    
    if ($err!=='') { 
      echo "<script>alert('".$err."');</script>";
    } else {
    
    $temp_rubl2litr = ($gas_summ / $gas_litr);
    
    mysql_query('INSERT INTO gas
    (
    status,
    prev_id,
    user_id,
    z_date,
    summ,
    litr,
    odo,
    rubl2litr
    ) VALUES (
    1,
    "'.$last_id.'",
    "'.$uid.'",
    "'.$gas_dat.'",
    "'.$gas_summ.'",
    "'.$gas_litr.'",
    "'.$gas_odo.'",
    "'.$temp_rubl2litr.'"
    )');
    
    if (mysql_error()) {echo mysql_error();}
      
    $id = mysql_insert_id();
    echo mysql_error();
    if (!$id || mysql_error()) {
     echo "<script>alert('Ошибка при вставке записи!');</script>";
     $err.=' Ошибка при вставке записи!';
    } else {
     echo "<script>top.document.location='gas.php?gid=".$id."';</script>";
    }
   } // if ($err!=='')
  } else {//if ($gas_odo>$last_odo) 
  // Вставка в середину Вставка в середину Вставка в середину Вставка в середину Вставка в середину Вставка в середину
  $temp_rubl2litr = ($gas_summ / $gas_litr);
  mysql_query('INSERT INTO gas
  (
  status,
  user_id,
  z_date,
  summ,
  litr,
  odo,
  rubl2litr
  ) VALUES (
  1,
  "'.$uid.'",
  "'.$gas_dat.'",
  "'.$gas_summ.'",
  "'.$gas_litr.'",
  "'.$gas_odo.'",
  "'.$temp_rubl2litr.'"
  )');
  
  if (mysql_error()) {echo mysql_error();}
    
  $id = mysql_insert_id();
  echo mysql_error();
  if (!$id || mysql_error()) {
   echo "<script>alert('Ошибка при вставке записи!');</script>";
   $err.=' Ошибка при вставке записи!';
  } else {
    $res=mysql_query('
    SELECT
     id,
     prev_id,
     odo,
     litr,
     summ
    FROM
     gas
    WHERE
     status = 1 and user_id = "'.$uid.'"
    ORDER BY odo DESC
    ');
    for($i=0; $i<mysql_num_rows($res); $i++) {
      $tmp_odo  = mysql_result($res, $i, 'odo');
      $tmp_id   = mysql_result($res, $i, 'id');
      $tmp_prev = mysql_result($res, $i, 'prev_id');
      if ($gas_odo<$tmp_odo) {
        $temp_next_id = $tmp_id;
        $temp_prev_id = $tmp_prev;
      } // if
    } //for
    //Править следующую
    mysql_query('
    UPDATE gas
    SET
     prev_id = "'.$id.'"
    WHERE
    id = '.$temp_next_id.'
    ');
    
    if (mysql_error()) {echo "<script>alert('Ошибка при изменении записи!');</script>";}
    
    //Править предыдущую
    $res=mysql_query('
    SELECT
     id,
     odo,
     litr,
     summ
    FROM
     gas
    WHERE
     id = '.$temp_prev_id.'
    ');
    
    $temp_odo  = mysql_result($res, 0, 'odo');
    $temp_litr = mysql_result($res, 0, 'litr');
    $temp_summ = mysql_result($res, 0, 'summ');
    
    if (($gas_odo - $temp_odo)<0) {$temp_km = 0;} else {$temp_km = ($gas_odo - $temp_odo);}
    if ($temp_km==0) {$temp_lkm = 0;} else {$temp_lkm = ($temp_litr*100)/$temp_km;}
    if ($temp_km==0) {$temp_rkm = 0;} else {$temp_rkm = $temp_summ / $temp_km;}
    
    mysql_query('
    UPDATE gas
    SET
      next_id    = "'.$id.'",
      next_odo   = "'.$gas_odo.'",
      km         = "'.$temp_km.'",
      litr2100km = "'.$temp_lkm.'",
      rubl2km    = "'.$temp_rkm.'"
    WHERE
    id = '.$temp_prev_id.'
    ');
    
    if (mysql_error()) {echo "<script>alert('Ошибка при изменении записи!');</script>";}
    
    //Править вставленную
    $res=mysql_query('
    SELECT
     id,
     odo,
     litr,
     summ
    FROM
     gas
    WHERE
     id = '.$temp_next_id.'
    ');
    
    $temp_odo  = mysql_result($res, 0, 'odo');
    
    if (($temp_odo - $gas_odo)<0) {$temp_km = 0;} else {$temp_km = ($temp_odo - $gas_odo);}
    if ($temp_km==0) {$temp_lkm = 0;} else {$temp_lkm = ($gas_litr*100)/$temp_km;}
    if ($temp_km==0) {$temp_rkm = 0;} else {$temp_rkm = $gas_summ / $temp_km;}
    
    mysql_query('
    UPDATE gas
    SET
      next_id    = "'.$temp_next_id.'",
      prev_id    = "'.$temp_prev_id.'",
      next_odo   = "'.$temp_odo.'",
      km         = "'.$temp_km.'",
      litr2100km = "'.$temp_lkm.'",
      rubl2km    = "'.$temp_rkm.'"
    WHERE
    id = '.$id.'
    ');
    
    } // else if (!$id || mysql_error())
  echo "<script>top.document.location='gas.php?gid=".$id."';</script>";
 } // else {//if ($gas_odo>$last_odo) 
 
 } // if ($act=='add')

if ($act=='edit') { // ------------------------------- EDIT -------------------------------
  $gas_dat=asif($gas_dat);
  $gas_summ=asif($gas_summ);
  $gas_litr=asif($gas_litr);
  $gas_odo=asif($gas_odo);
  
  // fields check
  $err='';
  if (!ctype_digit($gid)) { $err.=' Не указан id.'; }
  if (!$gas_dat)          { $err.=' Не указана дата.'; }
  if (!$gas_summ)         { $err.=' Не указана сумма.'; }
  if (!$gas_litr)         { $err.=' Не указано количество литров.'; }
  if (!$gas_odo)          { $err.=' Не указаны показания одометра.'; }
   
  $gas_dat  = str2U($gas_dat);
  $gas_summ = str_replace(",", "", $gas_summ);
  $gas_litr = str_replace(",", "", $gas_litr);
  $gas_odo  = str_replace(",", "", $gas_odo);
  
  if (ctype_digit($gid)) {
  $cnt=quick_select('
  SELECT
   COUNT(1)
  FROM
   gas
  WHERE
   id = '.$gid.' and status > 0 and user_id = "'.$uid.'"
  ');
  if (mysql_error()) { $err.=' Ошибка при поиске изменяемой записи.'; } else { $err = '';}
  if ($cnt < 1) { $err.='Запись не найдена (id).'; } else { $err = '';}
  // ---
  } // if (ctype_digit($cid))
  
  $res=mysql_query('
  SELECT
   id,
   next_id,
   next_odo,
   prev_id
  FROM
   gas
  WHERE
   id = '.$gid.'
  ');
  
  $temp_next_id  = mysql_result($res, 0, 'next_id');
  $temp_next_odo = mysql_result($res, 0, 'next_odo');
  $temp_prev_id  = mysql_result($res, 0, 'prev_id');
  
  if (($temp_next_odo - $gas_odo)<0) {$temp_km = 0;} else {$temp_km = ($temp_next_odo - $gas_odo);}
  if ($temp_km==0) {$temp_lkm = 0;} else {$temp_lkm = ($gas_litr*100)/$temp_km;}
  if ($temp_km==0) {$temp_rkm = 0;} else {$temp_rkm = $gas_summ / $temp_km;}
  
  if ($err!=='') { echo "<script>alert('".$err."');</script>";
  } else { // if ($err!=='')
    mysql_query('
     UPDATE gas
     SET
      z_date     = "'.$gas_dat.'",
      summ       = "'.$gas_summ.'",
      litr       = "'.$gas_litr.'",
      odo        = "'.$gas_odo.'",
      km         = "'.$temp_km.'",
      litr2100km = "'.$temp_lkm.'",
      rubl2km    = "'.$temp_rkm.'"
     WHERE
     id = '.$gid.'
    ');
  
    /*  Предыдущая запись */
    
    $res=mysql_query('
    SELECT
     id,
     odo,
     litr,
     summ
    FROM
     gas
    WHERE
     id = '.$temp_prev_id.'
    ');
    
    $temp_prev_odo  = mysql_result($res, 0, 'odo');
    $temp_prev_litr = mysql_result($res, 0, 'litr');
    $temp_prev_summ = mysql_result($res, 0, 'summ');
    
    if (($gas_odo - $temp_prev_odo)<0) {$temp_km = 0;} else {$temp_km = ($gas_odo - $temp_prev_odo);}
    if ($temp_km==0) {$temp_lkm = 0;} else {$temp_lkm = ($temp_prev_litr*100)/$temp_km;}
    if ($temp_km==0) {$temp_rkm = 0;} else {$temp_rkm = $temp_prev_summ / $temp_km;}
    
    mysql_query('
    UPDATE gas
    SET
     next_odo   = "'.$gas_odo.'",
     km         = "'.$temp_km.'",
     litr2100km = "'.$temp_lkm.'",
     rubl2km    = "'.$temp_rkm.'"
    WHERE
    id = '.$temp_prev_id.'
    ');
    
    
    if (mysql_error()) {
      echo mysql_error();
      echo "<script>alert(' Ошибка при изменении записи в таблице!');</script>";
      $err.='Ошибка при изменении записи в таблице!';
    } else {
      if (!$err) { echo "<script>top.document.location='gas.php?gid=".$gid."';</script>"; }
    }
  } // else if ($err!=='')
  
} //if ($act=='edit'

if ($act=='del') { // ------------------------------- DELETE -------------------------------
  $err='';
  if (!ctype_digit($gid)) { $err.=' Не указан id удаляемой записи.'; }
  if (ctype_digit($gid)) {
    $cnt=quick_select('
    SELECT
      COUNT(1)
    FROM
      gas
    WHERE
    id = '.$gid.' and status > 0 and user_id = "'.$uid.'"
    ');
    if (mysql_error()) { $err.=' Ошибка при поиске удаляемой записи.'; }
    if ($cnt < 1) { $err.='Запись не найдена.'; }
  } //if (ctype_digit($cid))
  
  // Удаляемая 
  $res=mysql_query('
  SELECT
   id,
   next_id,
   prev_id
  FROM
   gas
  WHERE
   id = '.$gid.'
  ');
  $temp_next_id  = mysql_result($res, 0, 'next_id');
  $temp_prev_id  = mysql_result($res, 0, 'prev_id');
  
  if ($temp_next_id==0) {
  
  // Предыдущая
  mysql_query('
    UPDATE gas
    SET
     next_id    = 0,
     next_odo   = 0,
     km         = 0,
     litr2100km = 0,
     rubl2km    = 0
    WHERE
    id = '.$temp_prev_id.'
    ');
  } else {
  
  // Следующая
  $res=mysql_query('
  SELECT
   id,
   next_id,
   prev_id,
   odo
  FROM
   gas
  WHERE
   id = '.$temp_next_id.'
  ');
  $temp_odo_next = mysql_result($res, 0, 'odo');
  $temp_id_next  = mysql_result($res, 0, 'id');
  
  // Предыдущая
  $res=mysql_query('
  SELECT
   id,
   next_id,
   prev_id,
   odo,
   litr,
   summ
  FROM
   gas
  WHERE
   id = '.$temp_prev_id.'
  ');
  $temp_odo_prev = mysql_result($res, 0, 'odo');
  $temp_id_prev  = mysql_result($res, 0, 'id');
  $temp_litr_prev  = mysql_result($res, 0, 'litr');
  $temp_summ_prev  = mysql_result($res, 0, 'summ');
  
  //Править следующую
  mysql_query('
    UPDATE gas
    SET
     prev_id    = "'.$temp_id_prev.'"
    WHERE
    id = '.$temp_next_id.'
    ');
    
  //Править предыдущую
  if (($temp_odo_next - $temp_odo_prev)<0) {$temp_km = 0;} else {$temp_km = ($temp_odo_next - $temp_odo_prev);}
  if ($temp_km==0) {$temp_lkm = 0;} else {$temp_lkm = ($temp_litr_prev*100)/$temp_km;}
  if ($temp_km==0) {$temp_rkm = 0;} else {$temp_rkm = $temp_summ_prev / $temp_km;}
  
  mysql_query('
    UPDATE gas
    SET
     next_id    = "'.$temp_id_next.'",
     next_odo   = "'.$temp_odo_next.'",
     km         = "'.$temp_km.'",
     litr2100km = "'.$temp_lkm.'",
     rubl2km    = "'.$temp_rkm.'"
    WHERE
    id = '.$temp_prev_id.'
    ');
    
  } //if ($temp_next_id==0)
  
  if ($err!=='') { echo "<script>alert('Error: ".$err."');</script>";
  } else {        // if ($err!=='')
  mysql_query('
  UPDATE gas
  SET
    status=-1
  WHERE
    id = '.$gid.'
  ');
  if (mysql_error()) {
   echo "<script>alert('Ошибка при удалении записи!');</script>";
   $err.=' Ошибка при удалении записи!';
  } else {
    if (!$err) { echo "<script>top.document.location='gas.php';</script>"; }
  }
 } // if ($err!=='') {
 
} // if ($act=='del') {

// ------------------------------- SELECT LIST -------------------------------

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
  status = 1 and user_id = "'.$uid.'"
  '.$query.'
 ORDER BY z_date DESC, odo DESC
 ');
 
 if (@mysql_num_rows($res)<1) { echo 'Записи не найдены.'; } else {
 echo "<table cellpadding=0 cellspacing=0 border=0 rules=rows width=100% style='font-size: 11; '>";
 echo "<col width=13%><col width=7%><col width=15%><col width=10%> <col width=10%><col width=10%><col width=10%><col width=15%><col width=5%><col width=5%>";
 for($i=0; $i<mysql_num_rows($res); $i++) {
    $temp_odo  = mysql_result($res, $i, 'odo');
    $temp_odo  = number_format($temp_odo, 2, '.', ',');
    $temp_litr = mysql_result($res, $i, 'litr');
    $temp_litr = number_format($temp_litr, 2, '.', ',');
    $temp_summ = mysql_result($res, $i, 'summ');
    $temp_summ = number_format($temp_summ, 2, '.', ',');
    $temp_rul  = mysql_result($res, $i, 'rubl2litr');
    $temp_rul  = number_format($temp_rul, 2, '.', ',');
    $temp_km   = mysql_result($res, $i, 'km');
    $temp_km  = number_format($temp_km, 2, '.', ',');
    $temp_lkm  = mysql_result($res, $i, 'litr2100km');
    $temp_lkm  = number_format($temp_lkm, 4, '.', ',');
    $temp_rkm  = mysql_result($res, $i, 'rubl2km');
    $temp_rkm  = number_format($temp_rkm, 4, '.', ',');
    $temp_dat = date("d/m/Y", mysql_result($res, $i, 'z_date'));
    
    echo '<tr  onMouseOver="prev_color = this.style.backgroundColor; this.style.backgroundColor=\'#D2D6FF\';" 
               onMouseOut="this.style.backgroundColor=prev_color_contr;"
               class="a_gas_list'.mysql_result($res, $i, 'style').'"
               id="a_gas_lnk_'.mysql_result($res, $i, 'id').'" name="a_gas_lnk_'.mysql_result($res, $i, 'id').'">
      <td style="text-align: center;">'.$temp_dat.'</td>
      <td style="text-align: right;">'.$temp_litr.'</td>
      <td style="text-align: right;">'.$temp_odo.'</td>
      <td style="text-align: right;">'.$temp_rul.'</td>
      <td style="text-align: right;">'.$temp_km.'</td>
      <td style="text-align: right;">'.$temp_lkm.'</td>
      <td style="text-align: right;">'.$temp_rkm.'</td>
      <td style="text-align: right;">'.$temp_summ.'</td>
      <td style="text-align: center;">
        <a href="gas.php?gid='.mysql_result($res, $i, 'id').'&act=edit" target="_top">Edit</a>
      </td>
      <td style="text-align: center;">
        <a href="gas.php?gid='.mysql_result($res, $i, 'id').'&act=del"  target="_top">Del</a>
      </td>
      </tr>';
  } // for
  echo "</table>";
 }

?>
</div>

<?php
 // foot params
 $no_graph_foot = 0;
 require('foot.php');
 // ---
?>
