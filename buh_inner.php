<?php
 // head params
 $page_name         = 'buh_inner';
 $page_cap          = 'Моя бухгалтерия';
 $no_graph_head     = 1;
 $secure_page       = 1;
 $is_frame          = 1;
 $prev_page_must_be = ''; // Example: "page1,page2,page3"
 $no_refresh        = 0;
 require_once('head.php');
 // ---
?>

<?php

 //echo "<script>alert('buh_inner');</script>";

 if ($act=='add') { // ------------------------------- ADD_OP -------------------------------
  // echo fields
  
  // echo "<script>alert('".$f_op_date."');</script>";
  // echo "<script>alert('".$op_name."');</script>";
  // echo "<script>alert('".$f_op_vid."');</script>";
  // echo "<script>alert('".$f_cat_id."');</script>";
  // echo "<script>alert('".$f_sub_id."');</script>";
  // echo "<script>alert('".$f_op_summ."');</script>";
  // echo "<script>alert('".$f_acc_id."');</script>";
  
  
  $f_op_vid=asif($f_op_vid);
  $f_cat_id=asif($f_cat_id);
  $f_sub_id=asif($f_sub_id);
  $f_op_summ=asif($f_op_summ);
  
  // fields check
  $err='';
  if ($f_op_vid==-1||!ctype_digit($f_op_vid))  { $err.=' Не указан вид операции.'; }
  if ($f_cat_id==-1||!ctype_digit($f_cat_id))  { $err.=' Не указана категория.'; }
  if ($f_acc_id==0)                            { $err.=' Не указан счет.'; }
  if (!$f_op_summ||$f_op_summ==0)              { $err.=' Не указана сумма операции.'; }
   
  $f_op_summ    = str_replace(",", "", $f_op_summ);
  $f_op_date    = str2U($f_op_date);
  $f_norm_date  = U2str($f_op_date);
  
  //echo "<script>alert('".$f_op_summ."');</script>";
  
  if ($err!=='') { 
    echo "<script>alert('".$err."');</script>";
  } else {
  
    mysql_query('INSERT INTO op
    (
    status,
    user_id,
    op_date,
	norm_date,
    op_vid,
    op_summ,
    cat_id,
    sub_id,
    acc_id
    ) VALUES (
    1,
    "'.$uid.'",
    "'.$f_op_date.'",
	"'.$f_norm_date.'",
    "'.$f_op_vid.'",
    "'.$f_op_summ.'",
    "'.$f_cat_id.'",
    "'.$f_sub_id.'",
    "'.$f_acc_id.'"
    )');
    
    if (mysql_error()) {echo mysql_error();}
    $id = mysql_insert_id();
    echo mysql_error();
    if (!$id || mysql_error()) {
     echo "<script>alert('Ошибка при вставке записи!');</script>";
     $err.=' Ошибка при вставке записи!';
    } else {
      $mod = 'add';
      $err = CorBalance($mod, $f_op_date, $f_acc_id, $f_op_vid, $f_op_summ);
      //echo "<script>alert('".$err."');</script>";
      // Правим рейтинг
      $resc=mysql_query('
      SELECT
       id,
       rating
      FROM
       cat
      WHERE
       id = '.$f_cat_id.'
      ');
      mysql_query('
      UPDATE cat
      SET
       rating = '.mysql_result($resc, 0, 'rating').' + 1
      WHERE
       id = "'.$f_cat_id.'"
      ');
      $ress=mysql_query('
      SELECT
       id,
       rating
      FROM
       subcat
      WHERE
       id = '.$f_sub_id.'
      ');
      mysql_query('
      UPDATE subcat
      SET
       rating = '.mysql_result($ress, 0, 'rating').' + 1
      WHERE
       id = "'.$f_sub_id.'"
      ');
      echo "<script>top.document.location='my_buh.php';</script>";
    } // if (!$id || mysql_error())
  } // if ($err!=='') else
 } //  if ($act=='add')

 if ($act=='del_op') { // ------------------------------- DEL_OP -------------------------------
 
 $err='';
  if (!ctype_digit($opid)) { $err.=' Не указан id удаляемой записи.'; }
  if (ctype_digit($opid)) {
    $cnt=quick_select('
    SELECT
      COUNT(1)
    FROM
      op
    WHERE
    id = '.$opid.' and status > 0
    ');
    if (mysql_error()) { $err.=' Ошибка при поиске удаляемой записи.'; }
    if ($cnt < 1) { $err.='Запись не найдена.'; }
  } //if (ctype_digit($cid))
  $temp_catid = quick_select('
    SELECT
      cat_id
    FROM
      op
    WHERE
      id = '.$opid.'
    ');
  if ($temp_catid==115) { $err.=' Нужно сделать Отмену в модуле Мои Кредиты.'; }
    
  if ($err!=='') { echo "<script>alert('Error: ".$err."');</script>";
  } else {        // if ($err!=='')
  mysql_query('
  UPDATE op
  SET
    status=-1
  WHERE
    id = '.$opid.'
  ');
  if (mysql_error()) {
   echo "<script>alert('Ошибка при удалении записи!');</script>";
   $err.=' Ошибка при удалении записи!';
  } else {
    //Правим balance
    $resb=mysql_query('
    SELECT
     id,
     op_summ,
     op_vid,
     op_date,
     acc_id,
     pers_id
    FROM
     op
    WHERE
     id = '.$opid.'
    ');
    $temp_date = mysql_result($resb, 0, 'op_date');
    $temp_summ = mysql_result($resb, 0, 'op_summ');
    $temp_vid  = mysql_result($resb, 0, 'op_vid');
    $temp_acc  = mysql_result($resb, 0, 'acc_id');
    $temp_pers = mysql_result($resb, 0, 'pers_id');

    //Правим обычный balance
    $mod = 'del';
    $err = CorBalance($mod, $temp_date, $temp_acc, $temp_vid, $temp_summ);
    if ($temp_pers!==0) {
      //Правим balance 902
      $mod = 'del';
      $err = CorBalance($mod, $temp_date, 902, $temp_vid, $temp_summ);
      //Правим таблицу долгов debt
      $err = CorDebt($temp_pers, $temp_vid, $temp_summ);
    }
    echo "<script>top.document.location='my_buh.php';</script>";
  }
 } // if ($err!=='') {
 
 } //if ($act=='del_op')
 
 if ($act=='cat_del') { // ------------------------------- CAT_DEL -------------------------------
 
  //echo "<script>alert('".$catid."');</script>";
  
  $err='';
  if (!ctype_digit($catid)) { $err.=' Не указан id удаляемой записи.'; }
  if (ctype_digit($catid)) {
    $cnt=quick_select('
    SELECT
      COUNT(1)
    FROM
      cat
    WHERE
      id = '.$catid.' and status > 0
    ');
    if (mysql_error()) { $err.=' Ошибка при поиске удаляемой записи.'; }
    if ($cnt < 1) { $err.='Запись не найдена.'; }
    
    $cnt=quick_select('
    SELECT
      COUNT(1)
    FROM
      op
    WHERE
      cat_id = '.$catid.' and status > 0
    ');
    if (mysql_error()) { $err.=' Ошибка при поиске связанной записи.'; }
    if ($cnt > 0) { $err.='Есть связанные операции!'; }
    
  } //if (ctype_digit($cid))
  
  if ($err!=='') { echo "<script>alert('Error: ".$err."');</script>";
  } else {        // if ($err!=='')
  mysql_query('
  UPDATE cat
  SET
    status=-1
  WHERE
    id = '.$catid.'
  ');
  mysql_query('
  UPDATE subcat
  SET
    status=-1
  WHERE
    cat_id = '.$catid.'
  ');
  if (mysql_error()) {
   echo "<script>alert('Ошибка при удалении записи!');</script>";
   $err.=' Ошибка при удалении записи!';
  } else {
    if (!$err) { 
    //echo '<script>top.document.location=\'my_buh.php\';</script>';
    if ($op==1)     {echo '<script>top.op_debet();</script>';}
    elseif ($op==2) {echo '<script>top.op_credit();</script>';}
    else {echo "<script>top.document.location='my_buh.php';</script>";}
    }
  }
 } // if ($err!=='') {
 
 } //if ($act=='del_cat')
 
 if ($act=='sub_del') { // ------------------------------- SUB_DEL -------------------------------
  //echo "<script>alert('".$act."');</script>";
  
  //echo "<script>alert('op=".$op."');</script>";
  //echo "<script>alert('catid=".$catid."');</script>";
  //echo "<script>alert('subid=".$subid."');</script>";
 
 
 $err='';
  if (!ctype_digit($subid)) { $err.=' Не указан id удаляемой записи.'; }
  if (ctype_digit($subid)) {
    $cnt=quick_select('
    SELECT
      COUNT(1)
    FROM
      subcat
    WHERE
    id = '.$subid.' and status > 0
    ');
    if (mysql_error()) { $err.=' Ошибка при поиске удаляемой записи.'; }
    if ($cnt < 1) { $err.='Запись не найдена.'; }
    
    $cnt=quick_select('
    SELECT
      COUNT(1)
    FROM
      op
    WHERE
      sub_id = '.$subid.' and status > 0
    ');
    if (mysql_error()) { $err.=' Ошибка при поиске связанной записи.'; }
    if ($cnt > 0) { $err.='Есть связанные операции!'; }
    
  } //if (ctype_digit($cid))
  
  if ($err!=='') { echo "<script>alert('Error: ".$err."');</script>";
  } else {        // if ($err!=='')
  mysql_query('
  UPDATE subcat
  SET
    status=-1
  WHERE
    id = '.$subid.'
  ');
  if (mysql_error()) {
   echo "<script>alert('Ошибка при удалении записи!');</script>";
   $err.=' Ошибка при удалении записи!';
  } else {
    if (!$err) {
      echo '<script>top.sub_fresh(\''.$op.'\', \''.$catid.'\');</script>';
      //echo '<script>top.sub_fresh(\''.$op.'\', \''.$catid.'\');</script>';}
      //else {echo "<script>top.document.location='my_buh.php';</script>";}
    }
  }
 } // if ($err!=='') {
 
 } //if ($act=='del_sub')
 
 if ($act=='cat_add') { // ------------------------------- CAT_ADD -------------------------------
  // echo fields
  //echo "<script>alert('".$act."');</script>";
  //echo "<script>alert('".$cat_add_op."');</script>";
  //echo "<script>alert('".$tadd_cat."');</script>";
    
  $tadd_cat=asif($tadd_cat);
  
  // fields check
  $err='';
  if (!$tadd_cat) { $err.=' Нет названия категории.'; }
   
  //echo "<script>alert('".$f_op_summ."');</script>";
  
  $cnt=quick_select('
  SELECT
    COUNT(1)
  FROM
    cat
  WHERE
    name = "'.$tadd_cat.'" and status > 0
  ');
  
  if (mysql_error()) { $err.=' Ошибка при попытке проверки уникальности записи.'; }
  if ($cnt > 0)      { $err.='Категория с таким наименованием уже существуют.'; }
  
  if ($err!=='') { 
    echo "<script>alert('".$err."');</script>";
  } else {
  
    mysql_query('INSERT INTO cat
    (
    status,
    user_id,
    name,
    op,
    isoborot
    ) VALUES (
    1,
    "'.$uid.'",
    "'.$tadd_cat.'",
    "'.$cat_add_op.'",
    1
    )');
    
    if (mysql_error()) {echo mysql_error();}
      
    $id = mysql_insert_id();
    echo mysql_error();
    if (!$id || mysql_error()) {
     echo "<script>alert('Ошибка при вставке записи!');</script>";
     $err.=' Ошибка при вставке записи!';
    } else {
     echo '<script>top.cat_add(\''.$cat_add_op.'\', \''.$id.'\', \''.$tadd_cat.'\');</script>';
     //echo "<script>alert('Pause');</script>";
     echo '<script>top.category(\''.$cat_add_op.'\', \''.$id.'\', \''.$tadd_cat.'\');</script>';
     //echo "<script>alert('Pause');</script>";
     //echo '<script>top.cat_add(\''.$id.'\');</script>;
    }
  } // if ($err!=='') else
 } //if ($act=='cat_add')
 
 if ($act=='sub_add') { // ------------------------------- SUB_ADD -------------------------------
  // echo fields
  //echo "<script>alert('".$act."');</script>";
  //echo "<script>alert('".$sub_add_catid."');</script>";
  //echo "<script>alert('".$tadd_sub."');</script>";
    
  $tadd_sub=asif($tadd_sub);
  
  // fields check
  $err='';
  if (!$tadd_sub) { $err.=' Нет названия подкатегории.'; }
   
  //echo "<script>alert('".$f_op_summ."');</script>";
  
  $cnt=quick_select('
  SELECT
    COUNT(1)
  FROM
    subcat
  WHERE
    name = "'.$tadd_sub.'" and status > 0
  ');
  
  if (mysql_error()) { $err.=' Ошибка при попытке проверки уникальности записи.'; }
  if ($cnt > 0)      { $err.='Подкатегория с таким наименованием уже существуют.'; }
  
  if ($err!=='') { 
    echo "<script>alert('".$err."');</script>";
  } else {
  
    mysql_query('INSERT INTO subcat
    (
    status,
    user_id,
    name,
    cat_id
    ) VALUES (
    1,
    "'.$uid.'",
    "'.$tadd_sub.'",
    "'.$sub_add_catid.'"
    )');
    
    if (mysql_error()) {echo mysql_error();}
      
    $id = mysql_insert_id();
    echo mysql_error();
    if (!$id || mysql_error()) {
     echo "<script>alert('Ошибка при вставке записи!');</script>";
     $err.=' Ошибка при вставке записи!';
    } else {
     echo '<script>top.sub_add(\''.$id.'\', \''.$sub_add_catid.'\', \''.$tadd_sub.'\');</script>';
     echo '<script>top.subcategory(\''.$id.'\', \''.$tadd_sub.'\');</script>';
     //echo '<script>top.cat_add(\''.$id.'\');</script>;
    }
  } // if ($err!=='') else
 } //if ($act=='cat_add')
 
 ?>

<?php
 //Расчет остатков
 $ost_isx_1 = ShowOst(1);
 $ost_isx_2 = ShowOst(2);
 $ost_isx_3 = ShowOst(3);
 $ost_isx_4 = ShowOst(4);
 $ost_isx_5 = ShowOst(5);
 $ost_isx_6 = ShowOst(6);
 $ost_isx_7 = ShowOst(7);
 echo '<script>top.show_ost(\''.$ost_isx_1.'\', \''.$ost_isx_2.'\', \''.$ost_isx_3.'\', \''.$ost_isx_4.'\', \''.$ost_isx_5.'\', \''.$ost_isx_6.'\',  \''.$ost_isx_7.'\');</script>';
?> 
 
 
 
<?php
 // foot params
 $no_graph_foot = 0;
 require('foot.php');
 // ---
?>
