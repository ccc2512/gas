<?php
  foreach ($_REQUEST as $k=>$val) {
    ${$k}=$val;
  } // foreach
  foreach ($_COOKIE as $k=>$val) {
    ${$k}=$val;
  } // foreach
  $g_site = 'http://ccc.kostya-strahov.ru';
  $g_site_name = 'www.ccc.kostya-strahov.ru';
  $g_db_host   = 'localhost';
  $g_db_login  = 'c2npru_ccc';
  $g_db_pswd   = 'c2klkb87ykjh35vx';
  $g_db_name   = 'c2npru_ccc';
  $g_pics      = $g_site.'/scans/';
  $g_rand      = 'sk55c3kljelk2h4s1dv';
//--- config  ---
  $g_user_active_time = 90; // in minutes
  $show_in_new_win    = 0;  // Show images in new window
  $g_max_files        = 30; // Max images for contract
  $ce_rid             = 1;  //
  $g_log              = 1;  // 1 - write log
//--- modules ---
  $g_stat                   = 1; //main trigger for all kind of stat
  $g_stat_by_day            = 1;
  $g_stat_by_sections       = 1;
  $g_stat_by_referer        = 1;
  $g_admin                  = 1;
  $g_admin_stat             = 1;
  $g_admin_news             = 0;
  $g_admin_actions          = 0;
  $g_admin_articles         = 0;
  $g_admin_strings          = 1;
  $g_admin_edit_css         = 0;
  $g_admin_text             = 0;
  $g_admin_upload           = 0;
  $g_admin_pass             = 1;
  $g_admin_catalogue        = 0;
  $g_admin_catalogue_config = 0;
  $g_admin_comments         = 0;
  $g_admin_blog             = 0;
  $g_admin_static_page      = 1;
  $g_admin_menu             = 0;
  $g_admin_ddmenu           = 0;
  $g_admin_fotos            = 0;
  $g_admin_price_upload     = 0;
  $g_admin_topics           = 0;
?>