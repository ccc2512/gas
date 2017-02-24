<?php
 // head params
 $page_name         = 'buh_calc';
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
//echo "<script>alert('buh_calc.php');</script>";
?>

<?php
 if ($act='recal') { // ------------------------------- Full Recalculation -------------------------------
  // op >> id status user_id op_date op_vid op_summ cat_id sub_id acc_id
  //echo "<script>alert('".$act."');</script>";
  
  $resd=mysql_query('
   delete FROM balance WHERE acc_id <> 902
  ');
  $resj=mysql_query('
   SELECT
    id,
    name
   FROM
    accounts
   WHERE
    status = 1 and user_id = '.$uid.'
  ');
  //echo "<script>alert('num_rows=".mysql_num_rows($resj)."');</script>";
  for($j=0; $j<mysql_num_rows($resj); $j++) {
    $temp_acc = mysql_result($resj, $j, 'id');
    
    
    // Заполнить обороты дебет Заполнить обороты дебет Заполнить обороты дебет Заполнить обороты дебет Заполнить обороты дебет
    $resi=mysql_query('
     SELECT
      op_date,
      sum(op_summ) s
     FROM
      op
     WHERE
      status = 1 and user_id = '.$uid.' and acc_id = '.$temp_acc.' and op_vid = 1
     GROUP BY op_date
    ');
    for($i=0; $i<mysql_num_rows($resi); $i++) {
      $cnt=quick_select('
        SELECT
          COUNT(1)
        FROM
          balance
        WHERE
          status = 1 and user_id = '.$uid.' and bal_date = '.mysql_result($resi, $i, 'op_date').' and acc_id = '.$temp_acc.'
        ');
      if ($cnt<1) {
        mysql_query('INSERT INTO balance
        (
        status,
        user_id,
        bal_date,
        acc_id
        ) VALUES (
        1,
        "'.$uid.'",
        "'.mysql_result($resi, $i, 'op_date').'",
        "'.$temp_acc.'"
        )'
        );
        if (mysql_error()) {echo mysql_error();}
      }
      mysql_query('
      UPDATE balance
      SET
       debet  = "'.mysql_result($resi, $i, 's').'"
      WHERE
       status = 1 and user_id = '.$uid.' and bal_date = '.mysql_result($resi, $i, 'op_date').' and acc_id = '.$temp_acc.'
      ');
    } // for($i
    
    // Заполнить обороты кредит Заполнить обороты кредит Заполнить обороты кредит Заполнить обороты кредит Заполнить обороты кредит
    $resk=mysql_query('
     SELECT
      op_date,
      sum(op_summ) s
     FROM
      op
     WHERE
      status = 1 and user_id = '.$uid.' and acc_id = '.$temp_acc.' and op_vid = 2 and cat_id <> 110
     GROUP BY op_date
    ');
    for($k=0; $k<mysql_num_rows($resk); $k++) {
      $cnt=quick_select('
        SELECT
          COUNT(1)
        FROM
          balance
        WHERE
          status = 1 and user_id = '.$uid.' and bal_date = '.mysql_result($resk, $k, 'op_date').' and acc_id = '.$temp_acc.'
        ');
      if ($cnt<1) {
        mysql_query('INSERT INTO balance
        (
        status,
        user_id,
        bal_date,
        acc_id
        ) VALUES (
        1,
        "'.$uid.'",
        "'.mysql_result($resk, $k, 'op_date').'",
        "'.$temp_acc.'"
        )'
        );
        if (mysql_error()) {echo mysql_error();}
      }
      mysql_query('
      UPDATE balance
      SET
       credit  = "'.mysql_result($resk, $k, 's').'"
      WHERE
       status = 1 and user_id = '.$uid.' and bal_date = '.mysql_result($resk, $k, 'op_date').' and acc_id = '.$temp_acc.'
      ');
    } // for($k=0;
    // Заполнить остатки Заполнить остатки Заполнить остатки Заполнить остатки Заполнить остатки Заполнить остатки Заполнить остатки
    $resm=mysql_query('
     SELECT
      id,
      status,
      user_id,
      acc_id,
      bal_date,
      bx,
      debet,
      credit,
      isx
     FROM
      balance
     WHERE
      status = 1 and user_id = '.$uid.' and acc_id = '.$temp_acc.'
     ORDER BY bal_date
    ');
    if ($temp_acc==1) {$nach_ost = 200;}
    if ($temp_acc==2) {$nach_ost = 158.76;}
	if ($temp_acc==3) {$nach_ost = 0.00;}
  if ($temp_acc==4) {$nach_ost = 0.00;}
  if ($temp_acc==5) {$nach_ost = 0.00;}
  if ($temp_acc==6) {$nach_ost = 0.00;}
    for($m=0; $m<mysql_num_rows($resm); $m++) {
      $temp_id  = mysql_result($resm, $m, 'id');
      $temp_bx  = $nach_ost;
      $temp_isx = $nach_ost - mysql_result($resm, $m, 'debet') + mysql_result($resm, $m, 'credit');
      //echo "<script>alert('".$temp_id."');</script>";
      mysql_query('
        UPDATE balance
        SET
         bx  = "'.$temp_bx.'",
         isx = "'.$temp_isx.'"
        WHERE
         status = 1 and user_id = '.$uid.' and acc_id = '.$temp_acc.' and id = '.$temp_id.'
      ');
      $nach_ost = $temp_isx;
    } // for($m=0
  } //for j acc
} //if ($act='recal')
 echo "<script>alert('Ready!');</script>";
?>





<?php
  //Расчет остатков
  $ost_isx_1 = ShowOst(1);
  $ost_isx_2 = ShowOst(2);
  $ost_isx_3 = ShowOst(3);
  $ost_isx_4 = ShowOst(4);
  $ost_isx_5 = ShowOst(5);
  $ost_isx_6 = ShowOst(6);
  echo '<script>top.show_ost(\''.$ost_isx_1.'\', \''.$ost_isx_2.'\', \''.$ost_isx_3.'\', \''.$ost_isx_4.'\', \''.$ost_isx_5.'\', \''.$ost_isx_6.'\');</script>';
?>
 

<?php
 // foot params
 $no_graph_foot = 0;
 require('foot.php');
 // ---
?>

