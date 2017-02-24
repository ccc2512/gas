<?php
 // head params
 $page_name         = 'report_show';
 $page_cap          = 'Показ отчета';
 $show_cap          = 0;
 $no_graph_head     = 1;
 $is_frame          = 0;
 $prev_page_must_be = ''; // Example: "page1,page2,page3"
 $no_refresh        = 0;
 require('head.php');
 // ---
 // page
$rep=asif($rep);

 foreach ($_POST as $key=>$val) {
   $_POST[$key]=asif($val);
   $GLOBALS[$key]=asif($val);
 }
 ?>
 <?php

  require('reports/'.$rep.'.php');

 // ---
 // foot params
 $no_graph_foot = 1;
 require('foot.php');
 // ---
?>
