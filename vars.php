<?php
  require('pers_vars.php');

$g_vars_vers='2';
/*
2:
added get_static_page_2 from strahov.pp.ru
added default g_rand
*/
if (!$g_rand) { $grand='asdfoiuwejxcv9wer'; }
$g_vars_error='';
$g_rights_is_loaded=0;

function connect_to_db(){
global $g_db_pswd;
global $g_db_login;
global $g_db_name;
global $g_db_host;
  if (!@mysql_connect($g_db_host, $g_db_login, $g_db_pswd)) { echo "&#1054;&#1096;&#1080;&#1073;&#1082;&#1072; &#1087;&#1088;&#1080; &#1087;&#1086;&#1076;&#1082;&#1083;&#1102;&#1095;&#1077;&#1085;&#1080;&#1080; &#1082; &#1041;&#1044;!"; return 0;}
  if (!@mysql_select_db($g_db_name)) { echo "&#1054;&#1096;&#1080;&#1073;&#1082;&#1072; &#1087;&#1088;&#1080; &#1074;&#1099;&#1073;&#1086;&#1088;&#1077; &#1089;&#1093;&#1077;&#1084;&#1099; &#1074; &#1041;&#1044;!";  return 0;}
  $res = mysql_query("set names cp1251");
  return 1;
}

function asif($str) { // Anti SQL-injection funtion
  $str = str_replace('\"', '"', $str);
  $str = str_replace("'", '"', $str);
  $str = str_replace('"', '\"', $str);
  $str = strip_tags($str);
  return $str;
}

function asifq($str) { // Anti SQL-injection funtion, convert to &quot;
  $str = str_replace("'", "&quot;", $str);
  $str = str_replace('"', "&quot;", $str);
  $str = strip_tags($str);
  return $str;
}

function ahif($str) { // Anti HTML-injection funtion // now for support old files only
 return asif($str);
}

function asifi($str) { // Anti SQL-injection funtion with digit check
  if (ctype_digit($str)) {
   return $str;
  } else {
   return 0;
  }
}

function get_str($name){
  $name = asif($name);
  $res = @mysql_query("SELECT value FROM strings WHERE name = '".$name."'");
  if(@mysql_num_rows($res)>0) { return mysql_result($res, 0 ,'value'); } else { return ''; }
}

function set_str($name, $val){
  $name = asif($name);
  $res = mysql_query("UPDATE strings SET value = '".$val."' WHERE name = '".$name."'");
  return mysql_affected_rows();
}

function get_user_conf($name, $default_value){
global $uid;
  $name = asif($name);
  $res = mysql_query("SELECT value FROM user_configures WHERE u_id = ".$uid." AND name = '".$name."'");
  if(mysql_num_rows($res)>0) { return mysql_result($res, 0 ,'value'); } else { return $default_value; }
}

function set_user_conf($name, $val){
/*
Return:
 1 - conf changed to new value
 2 - conf is  not finded for that user and created
 3 - cont is already = value
*/
global $uid;
 $uc=get_user_conf($name, 'conf_is_empty');
 if ($uc!==$val) {
  $name = asif($name);
  $res = mysql_query("UPDATE user_configures SET value = '".$val."' WHERE u_id = ".$uid." AND name = '".$name."'");
  if (mysql_error()) { return 0; }
  if (mysql_affected_rows()>0) {
    return 1;
  } elseif ($uc=='conf_is_empty') {
    mysql_query("INSERT INTO user_configures (u_id, name, value) VALUES (".$uid.", '".$name."', '".$val."')");
    if (mysql_error()) { return 0; }
    return 2;
  } else {
    return 3;
  }
 }
}

function str_to_date($str){ // from string like 2008-12-31 to 31.12.208
  return substr($str, 8, 2).'.'.substr($str, 5, 2).'.'.substr($str, 0, 4);
}
function str_2_date($str){ // from string like 01/08/2010-12-31 or 01,08,2010 to 01.08.2010
  return substr($str, 0, 2).'.'.substr($str, 3, 2).'.'.substr($str, 6, 4);
}

function echo_head($f_title, $f_encoding, $f_style){
  if (!$f_encoding) { $f_encoding='windows-1251'; }
  echo '<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset='.$f_encoding.'">
  <title>'.$f_title.'</title>
  </head>
  ';
if ($f_style) { echo '  <LINK rel="stylesheet" title="SADmint style" id="style1" type="text/css" href="'.$f_style.'">'; }
echo '  <body>
';
}

function check_user(){ // use only after connect to db and before echo <html> (it's working with cookies). return num value from -4 to 5
/* return:
 -5 not logged in
 -4 login expired
 -3 account deleted phisicaly or not found or somebody loged in at another session
 -2 blocked
 -1 deleted
 0 not activated
 1 normal
 2-5 not specified.
*/
global $uid;
global $key;
global $g_user_active_time; // in minutes
global $g_user_status;
global $g_user_name;
global $g_user_fio;
 $g_user_name='';
 $user_status = -5; //not logged in
 if ($uid&&$key&&$uid!==''&&$key!=='') {
  $uid = asif($uid);
  $key = asif($key);
  $res = mysql_query("SELECT id, u_login, status, last_visit_dt, city_id, first_name, last_name, second_name FROM users WHERE id = ".$uid." AND u_key = ".$key);
  if (mysql_num_rows($res) > 0) {
   if ( (mysql_result($res, 0, 'last_visit_dt')+$g_user_active_time*60) > date('U') ) { // check does login expired
    if (mysql_result($res, 0, 'status')=='-2') { $user_status =-2; } // blocked
    if (mysql_result($res, 0, 'status')=='-1') { $user_status =-1; } // deleted
    if (mysql_result($res, 0, 'status')=='0')  { $user_status = 0; } // not activated
    if (mysql_result($res, 0, 'status')=='1')  { $user_status = 1; } // normal
    if (mysql_result($res, 0, 'status')=='2')  { $user_status = 2; } // not specified
    if (mysql_result($res, 0, 'status')=='3')  { $user_status = 3; } // not specified
    if (mysql_result($res, 0, 'status')=='4')  { $user_status = 4; } // not specified
    if (mysql_result($res, 0, 'status')=='5')  { $user_status = 5; } // not specified
   } else { // check does login expired
     $user_status = -4; //login expired
   }
  } else { // if (mysql_num_rows($res) > 0) {
    $user_status = -3; //account deleted phisicaly or not found
  }
 }
 // ---
 if ($user_status<0) {
   setcookie('uid', '');
   setcookie('key', '');
 } else {
   mysql_query("UPDATE users SET last_visit_dt=".date('U').", activity=activity+1 WHERE id = ".$uid." AND u_key = ".$key);
   $g_user_name=mysql_result($res, 0, 'u_login');
   $g_user_fio=mysql_result($res, 0, 'last_name').' '.mysql_result($res, 0, 'first_name').' '.mysql_result($res, 0, 'second_name');
   setcookie('uid', $uid, time()+$g_user_active_time*60);
   setcookie('key', $key, time()+$g_user_active_time*60);
 }
 $g_user_status=$user_status;
} // function


function try_login($p_login, $p_pass){
global $uid;
global $key;
global $g_user_active_time;
  $p_login = asif($p_login);
  $p_pass = asif($p_pass);
  $res = mysql_query("SELECT id FROM users WHERE u_login = '".$p_login."' AND u_pass = '".$p_pass."'");
  if ( @mysql_num_rows($res) > 0 && @mysql_result($res, 0, 'id') > 0 ) {
    mt_srand(time()+(double)microtime()*1000000);
    $key = mt_rand(1000000, 9999999);
    $uid = mysql_result($res, 0, 'id');
    setcookie('uid', $uid, time()+$g_user_active_time*60, '/');
    setcookie('key', $key, time()+$g_user_active_time*60, '/');
    mysql_query("UPDATE users SET last_visit_dt=".date('U').", activity=activity+1, u_key=".$key." WHERE id = ".$uid);
    return 1;
  } else { return 0; }
}

function try_logout(){
global $uid;
global $key;
  mysql_query("UPDATE users SET last_visit_dt=".date('U').", activity=activity+1, u_key=0 WHERE id = ".$uid);
  $uid = '';
  $key = '';
  setcookie('uid', '');
  setcookie('key', '');
}

function get_user($p_col){// return any column from users for current user. -1 if not found
global $uid;
  $p_col = asif($p_col);
  $res = mysql_query("SELECT ".$p_col." FROM users WHERE id = ".$uid);
  if ( @mysql_num_rows($res) > 0 ) {
    return mysql_result($res, 0, $p_col);
  } else {
    return -1;
  }
}

function register_user($p_cols, $p_values) { // register new user
// defin all cols and values except: key, last_visit_dt, reg_date, activity.
global $uid;
global $key;
global $g_admin_active_time;
  mt_srand(time()+(double)microtime()*1000000);
  $key = mt_rand(1000000000, 9999999999);
  mysql_query("INSERT INTO users (u_key, last_visit_dt, reg_date, activity, ".$p_cols.") VALUES (".$key.",".date('U').",'".date('Y-m-d')."', 1, ".$p_values.")");
  $uid = mysql_insert_id();
  @setcookie('uid', $uid, time()+$g_admin_active_time*60, '/');
  @setcookie('key', $key, time()+$g_admin_active_time*60, '/');
}

function resize_to_file($filename, $new_filename, $width, $height, $quality) {
    // Get new dimensions
    list($width_orig, $height_orig) = getimagesize($filename);
    $ratio_orig = $width_orig/$height_orig;
    if ($height=0||!$height) { $height= 10000; } // zero error fix
    if ($width/$height > $ratio_orig) {
      $width = $height*$ratio_orig;
    } else {
      $height = $width/$ratio_orig;
    }
    // Resample
    $image_p = imagecreatetruecolor($width, $height);
    $image = imagecreatefromjpeg($filename);
    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
    imagejpeg($image_p, $new_filename, $quality);
}

function resize_to_file_if_bigger($filename, $new_filename, $width, $height, $quality) {
    // Get new dimensions
    list($width_orig, $height_orig) = getimagesize($filename);
    if ($width_orig>$width||$height_orig>$height) {
      $ratio_orig = $width_orig/$height_orig;
      if ($width/$height > $ratio_orig) {
        $width = $height*$ratio_orig;
      } else {
        $height = $width/$ratio_orig;
      }
    } else {
      $width=$width_orig;
      $height=$height_orig;
    }
    // Resample
    $image_p = imagecreatetruecolor($width, $height);
    $image = imagecreatefromjpeg($filename);
    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
    imagejpeg($image_p, $new_filename, $quality);
}

function rep_quo ($inp_string) { // replace " with \"
 return str_replace('"', '\"', $inp_string);
}

function select_row($query) {
/*
Results:
 1 - ok
 2 - not one row returned (less or more)
 3 - mysql_error (saved in $g_vars_error)
*/
global $g_res;
global $g_vars_error;
 $g_res=mysql_query($query);
 if (mysql_num_rows($g_res)!==1) {
  return 2;
 }
 $err=mysql_error();
 if ($err) {
  $g_vars_error = 'MySql error in "select_row": '.$err;
  return 3;
 }
 return 1;
}

function get_col($col_name) {
global $g_res;
global $g_vars_error;
 $g_vars_error='';
 if (mysql_num_rows($g_res)==1) {
  $r=mysql_result($g_res, 0, $col_name);
  if ($r||$r==0) {
   return $r;
  } else {
   return '';
  }
 } else {
  return '';
  $g_vars_error='Error in "get_col": not one row in g_res';
 }
}

function qer($query_str, $echo_str, $limit_str, $echo_exception) { //Simple echo multi-line qeury result
/*
 EXAMPLES:
  qer('SELECT id, name FROM dual', '<tr><td>^id^</td><td>^name^</td><tr>', '0, 10', 'Nothing was found!');
  qer('SELECT id, name FROM dual', '<tr><td>^id^</td><td>^id^ - ^name^</td><tr>', '', '');

 RETURN
   1 - OK
  -1 - Error in SQL query
  -2 - Nothing was found (echo_exception was printed)
  global variable $vars_err = returning text of error

 SPECIAL NAMES:
  add_date - convert from U to d.m.Y
  add_datetime - convert from U to d.m.Y G:i:s
  full_text - nl2br
*/
global $g_vars_err;
global $page_name;
global $g_qer_rows_count;
global $g_qer_param;
 if ($limit_str) { $query_str.=' LIMIT '.$limit_str; }
 $res = mysql_query($query_str);
 $err=mysql_error();
 if ($err) {
  $g_vars_err = $err;
  echo $echo_exception;
  add_log_msg('Ошибка в запросе в функции qer', '<b>Файл:</b> '.$page_name.';<br><b>Ошибка:</b> <i>'.$err.'</i>;<br><b>Запрос:</b> <small>'.SUBSTR($query_str, 0, 1500).'</small>');
  return -1;
 }
 $col_cnt = mysql_num_fields($res);
 if (mysql_num_rows($res)<1) { $g_vars_err = 'Nothing was found.'; echo $echo_exception; return -2; }
 for($i=0; $i<mysql_num_rows($res); $i++) {
   // get field name and replace code by result
   $echo_str_t = $echo_str;
   for($f=0; $f<$col_cnt; $f++) {
     $from_s = mysql_field_name($res, $f);
     $to_s = mysql_result($res, $i, mysql_field_name($res, $f));
     if ($from_s=='add_date') { $to_s = date('d.m.Y', $to_s); }
     if ($from_s=='add_date2') { $to_s = date('d.m.Y', $to_s); }
     if ($from_s=='add_datetime') { $to_s = date('d.m.Y G:i:s', $to_s); }
     if ($from_s=='full_text') { $to_s = nl2br($to_s); }
     $echo_str_t = str_replace('^'.$from_s.'^',
                               $to_s, $echo_str_t);
   }
   if ($g_qer_param=='no_page_break') {
     echo $echo_str_t;
   } else {
     echo $echo_str_t.'
'; // adding page break
   }
 }
 $g_qer_rows_count = $i;
 return 1;
}

function exit_with_error($err_code, $message_text) {
/*
 err_code 5**** - in vars.php
*/
global $page_name;
if ($err_code&&!$message_text) {
 $message_text=$err_code;
 $err_code='0';
}
  echo '
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
  <title>Ошибка! '.$err_code.'</title>
  </head>
<body style="font-family: Arial;">
<!-- Design & Programming: http://Strahov.pp.ru -->
<table width=100% height=100%>
 <tr>
  <td></td>
  <td></td>
  <td></td>
 </tr>

 <tr>
  <td></td>
  <td width=500>
   <div style="padding: 15; padding-bottom: 5; font-size: 14; border-width: 4; border-color: #e01414; border-style: solid;" align=center>
    '.$message_text.'
    <div style="font-size: 9; color: gray;display: block; width: 100%; height: 10; text-align: right;">код ошибки: '.$err_code.'</div>
   </div>
  </td>
  <td></td>
 </tr>

 <tr>
  <td></td>
  <td></td>
  <td></td>
 </tr>
</table>
</body>
</html>
 ';
 add_log_msg('Ошибка', $page_name.' '.$err_code.': '.$message_text);
 exit();
}

/*function exit_with_error($message_text) {
  echo '
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
  <title>Ошибка!</title>
  </head>
<body style="font-family: Arial;">
<!-- Design & Programming: http://Strahov.pp.ru -->
<table width=100% height=100%>
 <tr>
  <td></td>
  <td></td>
  <td></td>
 </tr>

 <tr>
  <td></td>
  <td width=500>
   <div style="padding: 15; font-size: 14; border-width: 4; border-color: #e01414; border-style: solid;" align=center>
    '.$message_text.'
   </div>
  </td>
  <td></td>
 </tr>

 <tr>
  <td></td>
  <td></td>
  <td></td>
 </tr>
</table>
</body>
</html>
 ';
 exit();
}*/

// RIGHTS and ROLES ---------------------------------------------------------------------
function add_right($r_name, $r_name_ru, $r_desc) {
 $res = mysql_query("SELECT id FROM `rights` WHERE name='$r_name' AND ru_name='$r_name_ru' AND description='$r_desc';");
 if (mysql_num_rows($res)>0) { return false; }
 $res = mysql_query("INSERT INTO `rights` ( `id` , `name` , `ru_name` , `description` ) VALUES ('', '$r_name', '$r_name_ru', '$r_desc');");
 if ( mysql_affected_rows()>0 && !mysql_error() ) { return true; } else { return false; }
}

function add_role($r_name, $r_name_ru, $r_desc) {
 $res = mysql_query("SELECT id FROM `roles` WHERE name='$r_name' AND ru_name='$r_name_ru' AND description='$r_desc';");
 if (mysql_num_rows($res)>0) { return false; }
 $res = mysql_query("INSERT INTO `roles` ( `id` , `name` , `ru_name` , `description` ) VALUES ('', '$r_name', '$r_name_ru', '$r_desc');");
 if ( mysql_affected_rows()>0 && !mysql_error() ) { return true; } else { return false; }
}

function have_rights($right_name) {
global $uid;
global $g_rights_is_loaded;
// if ($g_rights_is_loaded==0) {
 $res = mysql_query("
  SELECT
   1
  FROM
   rights rig
  ,rights2roles rig2rol
  ,roles2users rol2use
  WHERE
   rig.name='$right_name'
  AND rig2rol.right_id = rig.id
  AND rol2use.role_id = rig2rol.role_id
  AND rol2use.user_id = $uid
  UNION ALL
  SELECT
   1
  FROM
   rights rig
  ,rights2users rig2use
  WHERE
   rig.name='$right_name'
  AND rig2use.right_id = rig.id
  AND rig2use.user_id = $uid
 ");
// } else { // if ($g_rights_is_loaded==0) {
//  exit();
// } // if ($g_rights_is_loaded==0) {
 if (mysql_num_rows($res)>0) { return true; } else { return false; }
}

function echo_rights() {
 $res = mysql_query("
  SELECT
   name
  FROM
   rights rig
 ");
 for ($i=0; $i<mysql_num_rows($res); $i++){
   echo mysql_result($res, $i, 'name')."  - "; if (have_rights(mysql_result($res, $i, 'name'))) { echo "yes<br>"; } else { echo "no<br>"; }
 }
}
// Page pair ----------------------------------------------------------------------------
function prev_page_check($prev) { // 'page1,page2' - for page1 and page2 only OR '' - for all
global $curr_page;
global $page_name;
 if ($curr_page==$page_name) {
  return true;
 }
 while (strpos($prev, ',')) {
  if (substr($prev, 0, strpos($prev, ','))==$curr_page) {
   return true;
  }
  $prev=substr($prev, strpos($prev, ',')+1, strlen($prev));
 }
 if ($prev==$curr_page) {
  return true;
 }
 exit_with_error(50001, "Ошибка в очередности перехода по страницам!");
}
// LOG ----------------------------------------------------------------------------------
function add_log_msg ($cat, $log_msg) {
global $uid;
global $g_vars_error;
 // check, is log enabled?
echo get_str('log_enabled').'!';
 $res=mysql_query('SELECT value FROM strings WHERE name = "log_enabled" AND value="1"');
echo mysql_error();
 if (@mysql_num_rows($res)<1) { return 0; }
 //
 if (!ctype_digit($uid)) { $uid=0; }
 $cat=asif($cat);
 $log_msg=asif($log_msg);
 if (strlen($cat)>50) { $g_vars_error='add_log_msg: length "cat" > 50';  return false; }
 if (strlen($log_msg)>2000) { $g_vars_error='add_log_msg: length "log_msg" > 2000';  return false; }
 $res = mysql_query('INSERT INTO users_actions_log (uid, add_date, cat, msg_text) VALUES ('.$uid.', '.date('U').', "'.$cat.'", "'.$log_msg.'")');
 if (mysql_affected_rows()<1) {
   $g_vars_error='add_log_msg: no affected rows'; return false;
   mysql_query('INSERT INTO users_actions_log (uid, add_date, cat, msg_text) VALUES ('.$uid.', '.date('U').', "'.$cat.'", "[Тект удален т.к. при его вставке возникли ошибки!]")');
 }
 return 1;
}
// --------------------------------------------------------------------------------------

function price_format($price){
 return $price;
}
// Internal -----------------------------------------------------------------------------
function confirm_receive($receive_id) {
global $uid;
// if (ctype_digit($receive_id)) {
  $res=mysql_query('
   SELECT
    item_id
   ,cnt
   ,price_buy
   ,price_sale
   FROM
    receive
   WHERE
    id = '.$receive_id.'
   AND status = 0
  ');
  if (mysql_num_rows($res)<1) { exit_with_error(50002, "Ошибка при получении товара!"); }

  $set_query='';
  if (mysql_result($res, 0, 'price_buy')>0&&mysql_result($res, 0, 'price_buy')) {
    $set_query.=' , price_buy = '.mysql_result($res, 0, 'price_buy');
  }
  if (mysql_result($res, 0, 'price_sale')>0&&mysql_result($res, 0, 'price_sale')) {
    $set_query.=' , price_sale = '.mysql_result($res, 0, 'price_sale');
  }
  mysql_query('
   UPDATE
    item
   SET
    cnt=cnt+'.mysql_result($res, 0, 'cnt')
   .$set_query.'
   WHERE
    id = '.mysql_result($res, 0, 'item_id').'
   AND status = 1
  ');
  if (mysql_error()||mysql_affected_rows()!==1) { exit_with_error(50003, "Ошибка при получении товара!!"); }

  mysql_query('
   UPDATE
    receive
   SET
    status=1
   ,approve_u_id='.$uid.'
   ,approve_date='.date('U').'
   WHERE
    id = '.$receive_id.'
   AND status = 0
  ');
  if (mysql_error()||mysql_affected_rows()!==1) { exit_with_error(50004, "Ошибка при получении товара!!!"); }
  return 1;
// } else { // if (ctype_digit($receive_id)) {
//  return 0;
// } // if (ctype_digit($receive_id)) {
}
// --------------------------------------------------------------------------------------

function quick_select($s_query) {
 $res=mysql_query($s_query.' LIMIT 0, 1');
 if (@mysql_num_rows($res)>0) { return mysql_result($res, 0, 0); } else { return ''; }
}

function month_to_text($month) { // возвращает текстовое название месяца
 switch ($month) {
  case "01": return "Январь"; break;
  case "02": return "Февраль"; break;
  case "03": return "Март"; break;
  case "04": return "Апрель"; break;
  case "05": return "Май"; break;
  case "06": return "Июнь"; break;
  case "07": return "Июль"; break;
  case "08": return "Август"; break;
  case "09": return "Сентябрь"; break;
  case "10": return "Октябрь"; break;
  case "11": return "Ноябрь"; break;
  case "12": return "Декабрь"; break;
 }
}

function get_static_page($name){
  $name = asif($name);
  $res = mysql_query("SELECT content FROM static_page WHERE name = '".$name."'");
  if($res) { return mysql_result($res, 0 ,'content'); } else { return ''; }
}

function get_static_page_2($name, $default){
  $name = asif($name);
  $res = mysql_query("SELECT content FROM static_page WHERE name = '".$name."'");
  if($res) { return mysql_result($res, 0 ,'content'); } else { return $default; }
}


function statistics() { // Insert into DB all statistic information if statistics enabled
 global $g_stat;
 global $g_stat_by_referer;
 global $page_cap;
 global $g_site;

  mysql_query("UPDATE stat_by_sections SET cnt = cnt+1 WHERE name = '".$page_cap."'");
  if (mysql_affected_rows()<1){
    mysql_query("INSERT INTO stat_by_sections (name, cnt) VALUES ('".$page_cap."', 1)");
  }


 mysql_query("UPDATE stat_by_day SET cnt = cnt+1 WHERE date = '".date('Y-m-d')."'");
 if (mysql_affected_rows()<1) {
   mysql_query("INSERT INTO stat_by_day (id, date, cnt) values ('', '".date('Y-m-d')."', 1)");
 }

 if (get_str('stat_by_referer')=='1') {
  if ($GLOBALS['HTTP_REFERER']&&!(STRPOS(strtolower($GLOBALS['HTTP_REFERER']), strtolower(SUBSTR($g_site, 7)))>-1)){
    mysql_query("INSERT INTO stat_by_referer (name, date) VALUES ('".$GLOBALS['HTTP_REFERER']."', '".date('Y-m-d')."')");
  }
 }
}//function

function str2u($s){
/*
 returns date in U format or -1 if error
 mask: d-d..d[any not digit]m-m..m[any not digit]y-y..y
 cons: no days in month check, works only to 2020 year
*/
 $s=trim($s);
 $m='';
 $d='';
 $y='';
 $j=1;

 //echo "<script>alert('s = ".$s."');</script>";

 for ($i=0; $i<strlen($s); $i++) {
  $c=substr($s, $i, 1);
  if (ctype_digit($c)) {
   if ($j==1) { $d.=$c; }
   elseif ($j==2) { $m.=$c; }
   elseif ($j==3) { $y.=$c; }
  } else {
   $j++;
  }
 }

 if (strlen($y)==1) { $y='201'.$y; }
 elseif (strlen($y)==2) { $y='20'.$y; }
 elseif (strlen($y)==3) { $y='2'.$y; }

 if ($d>31||$m>12||$y>2020||!$d||!$m||!$y) { return -1; }
 $Udate = mktime (0,0,0,$m,$d,$y);
 return $Udate;
}

function u2str($s){
 return date('d/m/Y', $s);
}

function ShowOst($acc){
/* Calc balance.isx for acc. */

global $uid;

$res=mysql_query('
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
  status = 1 and acc_id = '.$acc.' and user_id = '.$uid.'
 ORDER BY bal_date DESC
 ');

$ost_isx = @mysql_result($res, 0, 'isx');

return $ost_isx;
}

function CorBalance($mod, $baldate, $accid, $opvid, $opsumm) {
/*
$mod   - вид корректировки add del banks ...
$opvid - вид операции 1-расход, 2-доход, 3-гашение, 4-отмена.
 */
global $uid;


  // Правим balance
  $cnt=quick_select('
  SELECT
    COUNT(1)
  FROM
    balance
  WHERE
    status = 1 and user_id = '.$uid.' and bal_date = '.$baldate.' and acc_id = '.$accid.'
  ');
  //echo "<script>alert('cnt = ".$cnt."');</script>";
  $temp_norm = U2str($baldate);
  if ($cnt<1) {
  mysql_query('INSERT INTO balance
  (
  status,
  user_id,
  bal_date,
  ndat,
  acc_id
  ) VALUES (
  1,
  "'.$uid.'",
  "'.$baldate.'",
  "'.$temp_norm.'",
  "'.$accid.'"
  )'
  );
  if (mysql_error()) {echo mysql_error();}
  } // if ($cnt<1)

  if ($mod=='banks') {
    $resd=mysql_query('
    SELECT
      sum(debt_summ) dsumm
    FROM
      debt
    WHERE
      status = 1 and user_id = '.$uid.' and (person_id = 7 or person_id = 8)
    ');
    if     ($opvid==3) {$temp_dsumm = -1 * mysql_result($resd, 0, 'dsumm');}
    elseif ($opvid==4) {$temp_dsumm = 0;}

    mysql_query('
    UPDATE balance
    SET
     isx_902  = '.$temp_dsumm.'
    WHERE
     status = 1 and user_id = '.$uid.' and bal_date = '.$baldate.' and acc_id = '.$accid.'
    ');
    $err.='OK!';
    return $err;
  } else {
    if (($opvid==1&&$accid!==902)||($opvid==2&&$accid==902)) {
      $dbt=quick_select('
        SELECT
          debet
        FROM
          balance
        WHERE
          status = 1 and user_id = '.$uid.' and bal_date = '.$baldate.' and acc_id = '.$accid.'
        ');
      if     ($mod=='add') {$dbt = $dbt + $opsumm;}
      elseif ($mod=='del') {$dbt = $dbt - $opsumm;}

      //echo "<script>alert('dbt = ".$dbt."');</script>";
      mysql_query('
      UPDATE balance
      SET
       debet  = '.$dbt.'
      WHERE
       status = 1 and user_id = '.$uid.' and bal_date = '.$baldate.' and acc_id = '.$accid.'
      ');
    }
    elseif (($opvid==2&&$accid!==902)||($opvid==1&&$accid==902)) {
      $crd=quick_select('
        SELECT
          credit
        FROM
          balance
        WHERE
          status = 1 and user_id = '.$uid.' and bal_date = '.$baldate.' and acc_id = '.$accid.'
        ');
      if     ($mod=='add') {$crd = $crd + $opsumm;}
      elseif ($mod=='del') {$crd = $crd - $opsumm;}

      //echo "<script>alert('crd = ".$crd."');</script>";
      mysql_query('
      UPDATE balance
      SET
       credit  = '.$crd.'
      WHERE
       status = 1 and user_id = '.$uid.' and bal_date = '.$baldate.' and acc_id = '.$accid.'
      ');
    }
    //Правим остатки
    $resm=mysql_query('
    SELECT
      id,
      status,
      user_id,
      acc_id,
      bal_date,
	  ndat,
      bx,
      debet,
      credit,
      isx,
      isx_902
     FROM
      balance
     WHERE
      status = 1 and user_id = '.$uid.' and acc_id = '.$accid.'
     ORDER BY bal_date
    ');
    if ($accid==1)   {$nach_ost = 200;}
    if ($accid==2)   {$nach_ost = 158.76;}
    if ($accid==902) {$nach_ost = -69053.90;}
    for($m=0; $m<mysql_num_rows($resm); $m++) {
      $temp_id  = mysql_result($resm, $m, 'id');
      $temp_bx  = $nach_ost;
      $temp_isx = $nach_ost - mysql_result($resm, $m, 'debet') + mysql_result($resm, $m, 'credit');
      $temp_isx_902 = mysql_result($resm, $m, 'isx_902');
      if ($temp_isx_902==0) {$temp_isx_902 = $temp_isx_902_b;}
      if ($accid==902) {
        if (mysql_result($resm, $m, 'bal_date')>=1285794000) {
        mysql_query('
          UPDATE balance
          SET
           bx  = "'.$temp_bx.'",
           isx = "'.$temp_isx.'"
          WHERE
           status = 1 and user_id = '.$uid.' and acc_id = '.$accid.' and id = '.$temp_id.'
        ');
        }
      } else {
        mysql_query('
          UPDATE balance
          SET
           bx  = "'.$temp_bx.'",
           isx = "'.$temp_isx.'"
          WHERE
           status = 1 and user_id = '.$uid.' and acc_id = '.$accid.' and id = '.$temp_id.'
        ');
      }
      if ($temp_isx_902!==0) {
        mysql_query('
        UPDATE balance
        SET
          isx_902 = "'.$temp_isx_902.'"
        WHERE
         status = 1 and user_id = '.$uid.' and acc_id = '.$accid.' and id = '.$temp_id.'
        ');
      }
      $nach_ost = $temp_isx;
      $temp_isx_902_b = $temp_isx_902;
    } // for($m=0)
    $err.='OK!';
    return $err;
  }
}

function CorDebt($pers, $opvid, $opsumm) {
/*
$opvid - вид операции 1-увеличение долга, 2-уменьшение, 3-просто сумма долга.
 */
global $uid;

// Правим таблицу долгов debt
$temp_debt_summ=quick_select('
  SELECT
    debt_summ
  FROM
    debt
  WHERE
    status = 1 and user_id = '.$uid.' and person_id = '.$pers.'
');
if ($opvid==1) {
  $temp_debt_summ = $temp_debt_summ + $opsumm;
}
elseif ($opvid==2) {
  $temp_debt_summ = $temp_debt_summ - $opsumm;
}
elseif ($opvid==3) {
  $temp_debt_summ = $opsumm;
}
mysql_query('
  UPDATE debt
  SET
   debt_summ = '.$temp_debt_summ.'
  WHERE
   status = 1 and user_id = '.$uid.' and person_id = '.$pers.'
');
$err.='OK!';
return $err;
}

function ShowSumm($mid) {

global $uid;

$resr=mysql_query('
     SELECT
      bank_id,
      sum(plat_summ) sum_plat,
      sum(perc_summ) sum_perc
     FROM
      mycred
     WHERE
      status = 1 and user_id = '.$uid.' and plan_summ = 0
     GROUP BY bank_id
     ');
    $itogo_plat   = 0;
    $itogo_perc   = 0;
    $itogo_plat_1 = 0;
    $itogo_perc_1 = 0;
    $itogo_plat_2 = 0;
    $itogo_perc_2 = 0;
    for($r=0; $r<mysql_num_rows($resr); $r++) {
      $temp_bank = mysql_result($resr, $r, 'bank_id');
      if ($temp_bank==1) {
          $itogo_plat_1 = mysql_result($resr, $r, 'sum_plat');
          $itogo_perc_1 = mysql_result($resr, $r, 'sum_perc');
       }
      if ($temp_bank==2) {
          $itogo_plat_2 = mysql_result($resr, $r, 'sum_plat');
          $itogo_perc_2 = mysql_result($resr, $r, 'sum_perc');
       }
    }
    $itogo_plat = $itogo_plat_1 + $itogo_plat_2;
    $itogo_perc = $itogo_perc_1 + $itogo_perc_2;

    $itogo_plat_1 = number_format($itogo_plat_1,  2, '.', ',');
    $itogo_perc_1 = number_format($itogo_perc_1,  2, '.', ',');
    $itogo_plat_2 = number_format($itogo_plat_2,  2, '.', ',');
    $itogo_perc_2 = number_format($itogo_perc_2,  2, '.', ',');
    $itogo_plat   = number_format($itogo_plat,  2, '.', ',');
    $itogo_perc   = number_format($itogo_perc,  2, '.', ',');

    $ress=mysql_query('
     SELECT
      sum(d.debt_summ) dsumm
     FROM
      debt d
     WHERE
      d.status = 1 and user_id = '.$uid.'
     ');
     $temp_debt_summ = mysql_result($ress, 0, 'dsumm');
     $temp_debt_summ = number_format($temp_debt_summ, 2, '.', ',');

    if ($mid==-1) {
      echo '<script>top.ShowAll(\''.$itogo_plat_1.'\',
                                \''.$itogo_perc_1.'\',
                                \''.$itogo_plat_2.'\',
                                \''.$itogo_perc_2.'\',
                                \''.$itogo_plat.'\',
                                \''.$itogo_perc.'\',
                                \''.$temp_debt_summ.'\'
                               );</script>';
    } else {
      echo '<script>top.ShowCred('.$mid.',
                             \''.$itogo_plat_1.'\',
                             \''.$itogo_perc_1.'\',
                             \''.$itogo_plat_2.'\',
                             \''.$itogo_perc_2.'\',
                             \''.$itogo_plat.'\',
                             \''.$itogo_perc.'\',
                             \''.$temp_debt_summ.'\'
                             );</script>';
    }

    $err.='OK!';
    return $err;
}



?>