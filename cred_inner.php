<?php
 // head params
 $page_name         = 'cred_inner';
 $page_cap          = '��� �������';
 $no_graph_head     = 1;
 $secure_page       = 1;
 $is_frame          = 1;
 $prev_page_must_be = ''; // Example: "page1,page2,page3"
 $no_refresh        = 0;
 require_once('head.php');
 // ---
?>

<?php
 if ($act=='edit') { // ------------------------------- EDIT -------------------------------
  $e_date=asif($e_date);
  $e_summ=asif($e_summ);
  // fields check
  $err='';
  if (!$e_date)         { $err.=' �� ������� ����.'; }
  if (!$e_summ)         { $err.=' �� ������� �����.'; }
     
  $e_date  = str2U($e_date);
  $e_summ = str_replace(",", "", $e_summ);
  $e_summ = str_replace(" ", "", $e_summ);
  
  //echo "<script>alert('mid=".$mid."');</script>";
  //echo "<script>alert('e_date=".$e_date."');</script>";
  //echo "<script>alert('e_summ=".$e_summ."');</script>";
  // ������ ������� ������ ������� ������ ������� ������ ������� ������ ������� ������ ������� ������ ������� 
  if ($pre==3) {  
  if ($err!=='') { echo "<script>alert('".$err."');</script>";
    } else {
    // ����� ����� �������� ����� �� ������!!!
    $resm=mysql_query('
     SELECT
      id,
      prev_id,
      next_id,
      plat_date,
      prev_date,
      plat_summ,
      bank_id,
      op_id,
      oz
     FROM
      mycred
     WHERE
      id = '.$mid.'
    ');
    
    $temp_bank = mysql_result($resm, 0, 'bank_id');
    $cur_summ  = mysql_result($resm, 0, 'plat_summ');
    $b_date    = mysql_result($resm, 0, 'prev_date');
    $b_summ    = mysql_result($resm, 0, 'oz');
    $b_nextid  = mysql_result($resm, 0, 'next_id');
    $temp_opid = mysql_result($resm, 0, 'op_id');
    
    //echo "<script>alert('b_summ=".$b_summ."');</script>";
    
    $resp=mysql_query('
     SELECT
      id,
      plat_summ
     FROM
      mycred
     WHERE
      id = '.$b_nextid.'
    ');
    
    $next_plat_summ = mysql_result($resp, 0, 'plat_summ');
    
    //echo "<script>alert('num_rows=".mysql_num_rows($resp)."');</script>";
    //echo "<script>alert('plat_summ=".$next_plat_summ."');</script>";
    
    if ($next_plat_summ == 0 && $cur_summ > 0) {
      
      //echo "<script>alert('1plat_summ=".$next_plat_summ."');</script>"; 
      
      mysql_query('
       UPDATE mycred
       SET
        plat_date = "'.$e_date.'",
        plat_summ = 0
       WHERE
        id = '.$mid.'
      ');
      
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
        id = '.$temp_bank.'
      ');
      
      $b_stavka  = mysql_result($resb, 0, 'stavka');
      $b_gash    = mysql_result($resb, 0, 'gash_sum');
      
      $temp_plan = 0;
      $temp_perc = 0;

    

      //Full
      $resc=mysql_query('
       SELECT
        id,
        plat_date,
        plat_summ
       FROM
        mycred
       WHERE
        status = 1 and user_id = '.$uid.' and bank_id = '.$temp_bank.' and plat_date >= '.$e_date.'
       ORDER BY plat_date
      ');
      //echo "<script>alert('num_rows=".mysql_num_rows($resc)."');</script>";
    
      
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
      //Full
      //echo "<script>alert('Ready');</script>";
      
      
                         
      //�������� ��������� ��������
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
       id = '.$temp_opid.'
      ');
      $temp_date = mysql_result($resb, 0, 'op_date');
      $temp_summ = mysql_result($resb, 0, 'op_summ');
      $temp_vid  = mysql_result($resb, 0, 'op_vid');
      $temp_acc  = mysql_result($resb, 0, 'acc_id');
      $temp_pers = mysql_result($resb, 0, 'pers_id');
      //echo "<script>alert('temp_date = ".$temp_date."');</script>";
      //echo "<script>alert('temp_summ = ".$temp_summ."');</script>";
      //echo "<script>alert('temp_vid = ".$temp_vid."');</script>";
      //echo "<script>alert('temp_acc = ".$temp_acc."');</script>";
      
      // ������ ��������
      mysql_query('
        UPDATE op
        SET
        status = -1
        WHERE
        id = '.$temp_opid.'
        ');
      
      //������ ������� balance
      $mod = 'del';
      $err = CorBalance($mod, $temp_date, $temp_acc, $temp_vid, $temp_summ);
      
      if ($temp_pers!==0) {
        //������ ������� ������ debt
        $temp_debt_summ=quick_select('
        SELECT
          oz
        FROM
          mycred
        WHERE
          id = '.$mid.'
        ');
        $temp_vid = 3;
        $err = CorDebt($temp_pers, $temp_vid, $temp_debt_summ);
        
        //������ balance 902
        $mod = 'banks';
        $temp_vid = 4;
        $err = CorBalance($mod, $temp_date, 902, $temp_vid, $temp_summ);
        
      }
      
      $err = ShowSumm($mid);
      
      //echo "<script>top.document.location='my_cred.php';</script>";
    } else {
      
      echo "<script>alert('��� �� ��������� �������!');</script>";
      
    }
    
  } // if ($err!=='')  
  } // if ($pre==3)
  
  
  // ������� � ���������� ������� � ���������� ������� � ���������� ������� � ���������� ������� � ���������� ������� � ���������� 
  if ($pre==2) {
    
    $rest=mysql_query('
     SELECT
      plat_summ
     FROM
      mycred
     WHERE
      id = '.$mid.'
    ');
    
    $test_summ = mysql_result($rest, 0, 'plat_summ');
    
    if ($test_summ > 0) {$err.='��� �������!';}
    
  
  if ($err!=='') { echo "<script>alert('".$err."');</script>";
    } else {
    //echo "<script>alert('mid=".$mid."');</script>";
    mysql_query('
     UPDATE mycred
     SET
      plat_date = "'.$e_date.'",
      plat_summ = '.$e_summ.'
     WHERE
      id = '.$mid.'
    ');
    
    $resm=mysql_query('
     SELECT
      id,
      prev_id,
      next_id,
      plat_date,
      prev_date,
      plat_summ,
      bank_id,
      oz
     FROM
      mycred
     WHERE
      id = '.$mid.'
    ');
    
    $temp_bank = mysql_result($resm, 0, 'bank_id');
    $temp_next = mysql_result($resm, 0, 'next_id');
    $b_date    = mysql_result($resm, 0, 'prev_date');
    $b_summ    = mysql_result($resm, 0, 'oz');
    $test_summ = mysql_result($resm, 0, 'plat_summ');
    
    //echo "<script>alert('b_date=".$b_date."');</script>";
    //echo "<script>alert('b_summ=".$b_summ."');</script>";
    //echo "<script>alert('temp_summ=".$temp_summ."');</script>";
        
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
      id = '.$temp_bank.'
    ');
    
    $b_stavka  = mysql_result($resb, 0, 'stavka');
    $b_gash    = mysql_result($resb, 0, 'gash_sum');
    
    $temp_plan = 0;
    $temp_perc = 0;

    
  

    //Full
    $resc=mysql_query('
     SELECT
      id,
      plat_date,
      plat_summ
     FROM
      mycred
     WHERE
      status = 1 and user_id = '.$uid.' and bank_id = '.$temp_bank.' and plat_date >= '.$e_date.'
     ORDER BY plat_date
    ');
    //echo "<script>alert('num_rows=".mysql_num_rows($resc)."');</script>";
  
    
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
    //Full
    // echo "<script>alert('Ready');</script>";
    
    // ��������� ��������
    $temp_acc=quick_select('
      SELECT
        acc_id
      FROM
        banks
      WHERE
        status = 1 and user_id = '.$uid.' and id = '.$temp_bank.'
    ');
    $temp_sub=quick_select('
      SELECT
        sub_id
      FROM
        banks
      WHERE
        status = 1 and user_id = '.$uid.' and id = '.$temp_bank.'
    ');
    $pers=quick_select('
      SELECT
        pers_id
      FROM
        banks
      WHERE
        status = 1 and user_id = '.$uid.' and id = '.$temp_bank.'
    ');
	$temp_norm = U2str($e_date);
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
    acc_id,
    pers_id
    ) VALUES (
    1,
    "'.$uid.'",
    "'.$e_date.'",
	"'.$temp_norm.'",
    1,
    "'.$e_summ.'",
    115,
    "'.$temp_sub.'",
    "'.$temp_acc.'",
    "'.$pers.'"
    )');
    if (mysql_error()) {echo mysql_error();}
    $id = mysql_insert_id();
    //echo mysql_error();
    if (!$id || mysql_error()) {
      echo "<script>alert('������ ��� ������� ������!');</script>";
      $err.=' ������ ��� ������� ������!';
    } else {
      // ��������� �������� � mycred
      mysql_query('
        UPDATE mycred
        SET
         op_id = '.$id.'
        WHERE
         id = '.$mid.'
      ');
      
      //������ ������� ������ debt
      $temp_oz=quick_select('
      SELECT
        oz
      FROM
        mycred
      WHERE
        id = '.$temp_next.'
      ');
      $temp_vid = 3;
      $err = CorDebt($pers, $temp_vid, $temp_oz);
      
      //������ balance 902
      $mod = 'banks';
      $temp_vid = 3;
      $err = CorBalance($mod, $e_date, 902, $temp_vid, $e_summ);
      
      //������ ������� balance
      $mod = 'add';
      $temp_vid = 1;
      $err = CorBalance($mod, $e_date, $temp_acc, $temp_vid, $e_summ);
      
      $err = ShowSumm($mid);
      
      //echo "<script>top.document.location='my_cred.php';</script>";
    } //if (!$id || mysql_error())
  } // if ($err!=='')  
  } //if ($pre==2)
  
  // ������ ����� ������ ������ ����� ������ ������ ����� ������ ������ ����� ������ ������ ����� ������ ������ ����� ������ 
  if ($pre==1) {
  
    $rest=mysql_query('
     SELECT
      plat_summ
     FROM
      mycred
     WHERE
      id = '.$mid.'
    ');
    
    $test_summ = mysql_result($rest, 0, 'plat_summ');
    
    if ($test_summ > 0) {$err.='��� ��������!';}
  
  if ($err!=='') { echo "<script>alert('".$err."');</script>";
    } else {
    
    //echo "<script>alert('mid=".$mid."');</script>";
    
    $resm=mysql_query('
     SELECT
      id,
      plat_date,
      prev_date,
      plat_summ,
      bank_id,
      oz
     FROM
      mycred
     WHERE
      id = '.$mid.'
    ');
    
    $temp_bank = mysql_result($resm, 0, 'bank_id');
    $temp_days = round(((($e_date - mysql_result($resm, 0, 'prev_date'))/60)/60)/24, 0);
  
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
      id = '.$temp_bank.'
    ');
    
    $b_stavka  = mysql_result($resb, 0, 'stavka');
    $b_gash    = mysql_result($resb, 0, 'gash_sum');
    
    $temp_plan = 0;
    $temp_perc = 0;
       
    $temp_perc = round(mysql_result($resm, 0, 'oz')*($temp_days/365)*($b_stavka/100), 2);
    $temp_plan = $b_gash + $temp_perc;
    //echo "<script>alert('days=".$temp_days."');</script>";
    mysql_query('
     UPDATE mycred
     SET
      plat_date = "'.$e_date.'",
      days      = '.$temp_days.',
      perc_summ = '.$temp_perc.',
      plan_summ = '.$temp_plan.'
     WHERE
      id = '.$mid.'
    ');
    
    //echo "<script>alert('Ready');</script>";
    
    $err = ShowSumm($mid);
    
  } // if ($err!=='')
  } //if ($pre==1)
  
  
 } //if ($act=='edit')
 
 if ($act=='debt') { // ------------------------------- DEBT -------------------------------
  $d_date=asif($d_date);
  $d_summ=asif($d_summ);
  // fields check
  $err='';
  if (!$pers)           { $err.=' ��� ���������.'; }
  if (!$d_date)         { $err.=' �� ������� ����.'; }
  if (!$d_summ)         { $err.=' �� ������� �����.'; }
     
  $d_date  = str2U($d_date);
  $d_summ = str_replace(",", "", $d_summ);
  $d_summ = str_replace(" ", "", $d_summ);
  
  //echo "<script>alert('pers=".$pers."');</script>";
  //echo "<script>alert('mod=".$mod."');</script>";
  //echo "<script>alert('d_date=".$d_date."');</script>";
  //echo "<script>alert('d_summ=".$d_summ."');</script>";
  
  if ($err!=='') { 
    echo "<script>alert('".$err."');</script>";
  } else {
  
  //if ($mod==1) { // � ��������� ����
  //if ($mod==2) { // � ���� � ����
  //if ($mod==3) { // � ��� � ����
  //if ($mod==4) { // ��� ���������� ����
  //if ($mod==5) { // ��������� �������
  
  
  if ($mod==5) {
    $before_summ = quick_select('
      SELECT
        debt_summ
      FROM
        debt
      WHERE
        status = 1 and user_id = '.$uid.' and person_id = '.$pers.'
    ');
    $dif_summ = $before_summ - $d_summ;
    if ($dif_summ<0) {
      $dif_summ = -1 * $dif_summ;
      $temp_opvid = 2;
    } else {
      $dif_summ = $dif_summ;
      $temp_opvid = 1;
    }
    //echo "<script>alert('dif_summ=".$dif_summ."');</script>";
    //echo "<script>alert('temp_opvid=".$temp_opvid."');</script>";
    
    $temp_catid = 110;
    
    //echo "<script>alert('mod=".$mod."');</script>";
    // ��������� ��������
	$temp_norm = U2str($d_date);
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
    acc_id,
    pers_id
    ) VALUES (
    1,
    "'.$uid.'",
    "'.$d_date.'",
	"'.$temp_norm.'",
    "'.$temp_opvid.'",
    "'.$dif_summ.'",
    "'.$temp_catid.'",
    -1,
    1,
    "'.$pers.'"
    )');
    if (mysql_error()) {echo mysql_error();}
    $id = mysql_insert_id();
    //echo mysql_error();
    
    
    //������ ������� ������ debt
    $temp_vid = 3;
    $err = CorDebt($pers, $temp_vid, $d_summ);
    
    //������ 902 balance
    $fmod = 'add';
    $err = CorBalance($fmod, $d_date, 902, $temp_opvid, $dif_summ);
    
    $err = ShowSumm(-1);
  }
  else {
  
    $temp_catid = 0;
    if     ($mod==1) { $temp_catid = 111; $temp_opvid = 1;}
    elseif ($mod==2) { $temp_catid = 112; $temp_opvid = 2;}
    elseif ($mod==3) { $temp_catid = 113; $temp_opvid = 1;}
    elseif ($mod==4) { $temp_catid = 114; $temp_opvid = 2;}
    //elseif ($mod==5) { $temp_catid = 114; $temp_opvid = 2;}
    
    //echo "<script>alert('mod=".$mod."');</script>";
    // ��������� ��������
	$temp_norm = U2str($d_date);
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
    acc_id,
    pers_id
    ) VALUES (
    1,
    "'.$uid.'",
    "'.$d_date.'",
	"'.$temp_norm.'",
    "'.$temp_opvid.'",
    "'.$d_summ.'",
    "'.$temp_catid.'",
    -1,
    1,
    "'.$pers.'"
    )');
    if (mysql_error()) {echo mysql_error();}
    $id = mysql_insert_id();
    //echo mysql_error();
    
    if (!$id || mysql_error()) {
     echo "<script>alert('������ ��� ������� ������!');</script>";
     $err.=' ������ ��� ������� ������!';
    } else {
      $temp_summ=quick_select('
        SELECT
          debt_summ
        FROM
          debt
        WHERE
          status = 1 and user_id = '.$uid.' and person_id = '.$pers.'
      ');
      
      if ($mod==1||$mod==3) {
        $temp_summ = $temp_summ - $d_summ;
      }
      if ($mod==2||$mod==4) {
        $temp_summ = $temp_summ + $d_summ;
      }
      
      //echo "<script>alert('temp_summ=".$temp_summ."');</script>";
      
      //������ ������� ������ debt
      $temp_vid = 3;
      $err = CorDebt($pers, $temp_vid, $temp_summ);
      
      //������ ������� balance
      $fmod = 'add';
      $temp_acc = 1;
      $err = CorBalance($fmod, $d_date, $temp_acc, $temp_opvid, $d_summ);
      
      //������ 902 balance
      $fmod = 'add';
      $err = CorBalance($fmod, $d_date, 902, $temp_opvid, $d_summ);
      
      $err = ShowSumm(-1);
      
    } // if (!$id || mysql_error())
 
  } // if ($mod == 5)
  
 // echo "<script>top.document.location='my_cred.php';</script>";
  
 } // if ($err!=='')

 } // if ($act=='debt')
?> 
 
 
 
<?php
 // foot params
 $no_graph_foot = 0;
 require('foot.php');
 // ---
?>

