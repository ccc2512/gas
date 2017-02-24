<?php
 // head params
 $page_name         = 'cred_calc';
 $page_cap          = 'Мои кредиты';
 $no_graph_head     = 1;
 $secure_page       = 1;
 $is_frame          = 1;
 $prev_page_must_be = ''; // Example: "page1,page2,page3"
 $no_refresh        = 0;
 require_once('head.php');
 // ---
?>

<?php

?>

<?php
 if ($act='recal') { // ------------------------------- Full Recalculation -------------------------------
  // id 	status 	user_id 	bic 	name 	begin_date 	summa 	stavka
  //Выбор всех банков
  $resb=mysql_query('
   SELECT
    id,
    name,
    begin_date,
    summa,
    stavka,
    gash_sum
   FROM
    banks
   WHERE
    status = 1 and user_id = '.$uid.'
   ');
  //echo "<script>alert('num_rows=".mysql_num_rows($resb)."');</script>";
  for($b=0; $b<mysql_num_rows($resb); $b++) {
    $temp_bank = mysql_result($resb, $b, 'id');
    //echo "<script>alert('temp_bank=".$temp_bank."');</script>";
    $b_date    = mysql_result($resb, $b, 'begin_date');
    $b_summ    = mysql_result($resb, $b, 'summa');
    $b_stavka  = mysql_result($resb, $b, 'stavka');
    $b_gash    = mysql_result($resb, $b, 'gash_sum');
    $temp_plat = 0;
    $temp_plan = 0;
    $resc=mysql_query('
     SELECT
      id,
      plat_date,
      plat_summ
     FROM
      mycred
     WHERE
      status = 1 and user_id = '.$uid.' and bank_id = '.$temp_bank.'
     ORDER BY plat_date
    ');
    //echo "<script>alert('num_rows=".mysql_num_rows($resc)."');</script>";
    // Заполнили prev и next id
    $temp_prev_id = 0;
    for($c=0; $c<mysql_num_rows($resc); $c++) {
      mysql_query('
        UPDATE mycred
        SET
         prev_id = '.$temp_prev_id.'
        WHERE
         id = '.mysql_result($resc, $c, 'id').'
      ');
      $temp_prev_id = mysql_result($resc, $c, 'id');
    }
    
    $resn=mysql_query('
     SELECT
      id,
      plat_date,
      plat_summ
     FROM
      mycred
     WHERE
      status = 1 and user_id = '.$uid.' and bank_id = '.$temp_bank.'
     ORDER BY plat_date DESC
    ');
    //echo "<script>alert('num_rows=".mysql_num_rows($resc)."');</script>";
    
    $temp_next_id = 0;
    for($n=0; $n<mysql_num_rows($resn); $n++) {
      mysql_query('
        UPDATE mycred
        SET
         next_id = '.$temp_next_id.'
        WHERE
         id = '.mysql_result($resn, $n, 'id').'
      ');
      $temp_next_id = mysql_result($resn, $n, 'id');
    }
    // Собственно пересчет
    for($c=0; $c<mysql_num_rows($resc); $c++) {
        $temp_days = round((((mysql_result($resc, $c, 'plat_date') - $b_date)/60)/60)/24, 0);
        $temp_perc = round($b_summ*($temp_days/365)*($b_stavka/100), 2);
        $temp_goz  = mysql_result($resc, $c, 'plat_summ') - $temp_perc;
        if ($temp_goz < 0)  {$temp_goz = 0;}
        if ($temp_goz == 0) {$temp_plan = $b_gash + $temp_perc;} else {$temp_plan = 0;}
        //if ($temp_goz == 0) {$temp_summ = $temp_plat;} else {$temp_summ = mysql_result($resc, $c, 'plat_summ');}
                  
        mysql_query('
          UPDATE mycred
          SET
           prev_date = '.$b_date.',
           days      = '.$temp_days.',
           plan_summ = '.$temp_plan.',
           perc_summ = '.$temp_perc.',
           oz        = '.$b_summ.'
          WHERE
           id = '.mysql_result($resc, $c, 'id').'
         ');
         
         $b_date = mysql_result($resc, $c, 'plat_date');
         $b_summ = $b_summ - $temp_goz;
         
    } // for $c (mycred)
  
  
  } // for $b (banks)
  
  // Корректировка баланса
  $resd=mysql_query('
   delete FROM balance WHERE acc_id = 902
  ');
  
  // Заполнить обороты по долгам 902
  $resi=mysql_query('
   SELECT
    op_date,
    sum(op_summ) s,
    cat_id,
    op_vid
   FROM
    op
   WHERE
    status = 1 and user_id = '.$uid.' and (op_vid = 1 or op_vid = 2) and 
   (cat_id = 110 or cat_id = 111 or cat_id = 112 or cat_id = 113 or cat_id = 114)
   GROUP BY op_vid, op_date
  ');
  for($i=0; $i<mysql_num_rows($resi); $i++) {
    $cnt=quick_select('
      SELECT
        COUNT(1)
      FROM
        balance
      WHERE
        status = 1 and user_id = '.$uid.' and bal_date = '.mysql_result($resi, $i, 'op_date').' and acc_id = 902
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
      902
      )'
      );
      if (mysql_error()) {echo mysql_error();}
    }
    if (mysql_result($resi, $i, 'op_vid')==2) {
      mysql_query('
      UPDATE balance
      SET
       debet  = "'.mysql_result($resi, $i, 's').'"
      WHERE
       status = 1 and user_id = '.$uid.' and bal_date = '.mysql_result($resi, $i, 'op_date').' and acc_id = 902
      ');
    } //if (mysql_result($resi, $i, 'op_vid')==1)
    if (mysql_result($resi, $i, 'op_vid')==1) {
      mysql_query('
      UPDATE balance
      SET
       credit  = "'.mysql_result($resi, $i, 's').'"
      WHERE
       status = 1 and user_id = '.$uid.' and bal_date = '.mysql_result($resi, $i, 'op_date').' and acc_id = 902
      ');
    }
  } // for($i
  // Заполнить остатки по долгам 902
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
    status = 1 and user_id = '.$uid.' and acc_id = 902
   ORDER BY bal_date
  ');
  $nach_ost = -69053.90;
  for($m=0; $m<mysql_num_rows($resm); $m++) {
    $temp_id  = mysql_result($resm, $m, 'id');
    $temp_bx  = $nach_ost;
    $temp_isx = $nach_ost - mysql_result($resm, $m, 'debet') + mysql_result($resm, $m, 'credit');
    //echo "<script>alert('".$temp_id."');</script>";
    if (mysql_result($resm, $m, 'bal_date')>=1285794000) {
      mysql_query('
        UPDATE balance
        SET
         bx  = "'.$temp_bx.'",
         isx = "'.$temp_isx.'"
        WHERE
         id = '.$temp_id.'
      ');
    }
    $nach_ost = $temp_isx;
  } // for($m=0
    
  // Сумма остатков по банкам
  $curdate = date('U');
  $resm=mysql_query('
   SELECT
    prev_date,
    bank_id,
    oz
   FROM
    mycred
   WHERE
    status = 1 and user_id = '.$uid.' and prev_date <= '.$curdate.'
   ORDER BY prev_date
  ');
  for($m=0; $m<mysql_num_rows($resm); $m++) {
    //$temp_id   = mysql_result($resm, $m, 'id');
    $temp_date = mysql_result($resm, $m, 'prev_date');
    
    if (mysql_result($resm, $m, 'bank_id')==1) {
      $bost1 = mysql_result($resm, $m, 'oz');
    }
    if (mysql_result($resm, $m, 'bank_id')==2) {
      $bost2 = mysql_result($resm, $m, 'oz');
    }
    $bosd=0;
    $bosd=quick_select('
     SELECT
      isx
     FROM
      balance
     WHERE
      status = 1 and user_id = '.$uid.' and bal_date <= '.$temp_date.' and isx > 0 and acc_id = 902
     ORDER BY bal_date
    ');
    
    $bost = -1*($bost1 + $bost2);
    
    //echo "<script>alert('".$bost2."');</script>";
    
    mysql_query('INSERT INTO balance
      (
      status,
      user_id,
      bal_date,
      acc_id,
      isx,
      isx_902
      ) VALUES (
      1,
      "'.$uid.'",
      "'.$temp_date.'",
      902,
      0,
      "'.$bost.'"
      )'
    );
  } // for($m=0
  
  // Заполнить дырки по долгам 902
  $resq=mysql_query('
   SELECT
    id,
    status,
    user_id,
    acc_id,
    bal_date,
    bx,
    debet,
    credit,
    isx,
    isx_902
   FROM
    balance
   WHERE
    status = 1 and user_id = '.$uid.' and acc_id = 902
   ORDER BY bal_date
  ');
  $temp_isx = 0;
  $temp_isx_b = 0;
  $temp_isx_902_b = 0;
  //echo "<script>alert('".mysql_num_rows($resq)."');</script>";
  
  for($q=0; $q<mysql_num_rows($resq); $q++) {
    $temp_id  = mysql_result($resq, $q, 'id');
    $temp_debet = mysql_result($resq, $q, 'debet');
    $temp_credit = mysql_result($resq, $q, 'credit');
    $temp_isx_902 = mysql_result($resq, $q, 'isx_902');
    if ($temp_debet==0&&$temp_credit==0) {$temp_isx = $temp_isx_b;}
    else {$temp_isx = mysql_result($resq, $q, 'isx');}
    if ($temp_isx_902==0) {$temp_isx_902 = $temp_isx_902_b;}
    //echo "<script>alert('".$temp_isx_902."');</script>";
    mysql_query('
      UPDATE balance
      SET
       isx = '.$temp_isx.',
       isx_902 = '.$temp_isx_902.'
      WHERE
       id = '.$temp_id.'
    ');
    $temp_isx_b = $temp_isx;
    $temp_isx_902_b = $temp_isx_902;
  }
  
  

 } //if ($act='recal')
 
 echo "<script>alert('Ready!');</script>";
 echo "<script>top.document.location='my_cred.php';</script>";
 
?>

<?php
 // foot params
 $no_graph_foot = 0;
 require('foot.php');
 // ---
?>

