<?php
 require "vars.php";
 connect_to_db();
 // Page consequence control
 if ($no_refresh==1) {
  if ($curr_page==$page_name) {
   exit_with_error(13, 'Обновление этой страницы запрещено!');
  }
 }
 if ($prev_page_must_be&&$prev_page_must_be!=='') {
   prev_page_check($prev_page_must_be);
 }
 if (!$curr_page) { $curr_page = '-'; }
 $prev_page = $curr_page;
 $curr_page = $page_name;

 if ($is_frame==0) {
   setcookie('curr_page', $curr_page);
   setcookie('prev_page', $prev_page);
 }
 // ---
 // user session

 if (@$act=='logout') { try_logout(); }
 if (@$s_login&&@$s_pswd) {
  if (try_login($s_login, $s_pswd)==0) { $login_error=1; } else { $login_error=0; }
 }

 check_user();
?>
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
 <title>Gas<?php if ($page_cap) { echo ' - '.$page_cap; } ?></title>
</head>
<LINK rel="stylesheet" title="Style by CCC" id="style1" type="text/css" href="style.css">
<body style='margin: 0px; padding: 0px;'>


<?php
if ($g_user_status<1) {
// vvv LOGIN FORM -------------------------------------------------------------------
 if ($is_frame==1) {
 echo "<br><br><div align=center><b>Сессия просрочена.<br>Выполните <a target='_top' href='index.php'>вход</a> в систему</b></div>"; exit();
 }
?>
<table border=0 cellspacing=0 cellpadding=0 width=100% height=100%>
<tr><td valign=center  align=center>
  <form action="index.php?act=login" method="POST" class='login_form'>
    <div >
    <table border=3 rules=none cellspacing=5 cellpadding=1 width=250 height=100% style='background-color: #d2d6ff; border-color: blue;' >
       <?php
       if (@$login_error==1)   { echo "<tr><td valign=bottom align=center class='td_err' colspan=2>Имя или пароль ошибочны.<br></td></tr>"; }
       if ($g_user_status==-4) { echo "<tr><td valign=bottom align=center class='td_err' colspan=2>Сессия просрочена.<br></td></tr>"; }
       if ($g_user_status==-3) { echo "<tr><td valign=bottom align=center class='td_err' colspan=2>Ваша учетная запись удалена или не найдена или кто-то осуществил вход в систему под вашим именем!<br></td></tr>"; }
       if ($g_user_status==-2) { echo "<tr><td valign=bottom align=center class='td_err' colspan=2>Ваша учетная запись заблокирована!<br></td></tr>"; }
       if ($g_user_status==-1) { echo "<tr><td valign=bottom align=center class='td_err' colspan=2>Ваша учетная запись удалена!<br></td></tr>"; }
       if ($g_user_status== 0) { echo "<tr><td valign=bottom align=center class='td_err' colspan=2>Ваша учетная запись не активирована!<br></td></tr>"; }
       ?>

      <!--<tr><td valign=center align=center class='td3_cap' colspan=2>Введите Ваши данные</td></tr>-->
      <?php
      $curtime = date("H");
      settype($curtime, "integer");
      if     ($curtime >= 0  && $curtime <  5)  {$wellcome = 'Доброй ночи!';}
      elseif ($curtime >= 5  && $curtime <  10) {$wellcome = 'Доброе утро!';}
      elseif ($curtime >= 10 && $curtime <  17) {$wellcome = 'Добрый день!';}
      elseif ($curtime >= 17 && $curtime <= 23) {$wellcome = 'Добрый вечер!';}
      else {$wellcome = 'Доброе время суток!';}
      if ($act == 'logout') {$wellcome = 'До свидания!  Или.. ';}
      //if ($g_user_status <> 1) {$wellcome = ' ';}
      ?>
      <tr><td valign=bottom align=center class='td2_cap' colspan=2><?=$wellcome?></td></tr>
      <tr><td valign=top    align=center class='td2_cap' colspan=2>Введите, пожалуйста, Ваши данные:</td></tr>
      <tr>
      <td valign=bottom align=right class='td_pass'>Имя:</td>
      <td><input type='text' class='text_inp' size=20 name='s_login' id='s_login'></td>
      </tr>
      <tr>
      <td valign=bottom align=right class='td_pass'>Пароль:</td>
      <td><input type='password' class='text_inp' size=20 name='s_pswd' id='s_pswd'></td>
      </tr>
      <tr>
      <td colspan=2 align=center><input type='submit' class='inp_btn' value='Вход'></td>
      </tr>
    </table>
    </div>
 </form>
</td></tr>
</table>
<?php
require "foot.php";
exit();
// ^^^ LOGIN FORM -------------------------------------------------------------------
} // if ($g_user_status<1)


if ($no_graph_head!==1) {
?>
<table border=0 cellspacing=0 cellpadding=0 width=100% height=20>
 <tr class='head_tr'>
  <td width=150 class='ver'>&nbsp;&nbsp;&nbsp;Gas ver.<?=get_str('vers');?></td>
  <td>
   <a href='index.php' class='a_black<?php if ($page_name=='index') { echo "_cur"; } ?>'>Главное меню</a>
   &nbsp;&nbsp;&nbsp;
   <a href='gas.php' class='a_black<?php if ($page_name=='gas') { echo "_cur"; } ?>'>Бензин</a>
   &nbsp;&nbsp;&nbsp;
   <a href='my_buh.php'  class='a_black<?php if ($page_name=='my_buh') { echo "_cur"; } ?>'>Моя бухгалтерия</a>
   <?php
   if ($page_name == 'my_buh'||$page_name == 'reports') {
   ?>
   &nbsp;&nbsp;&nbsp;
   <a href='reports.php' class='a_black<?php if ($page_name=='reports') { echo "_cur"; } ?>'>Отчеты</a>
   <?php
   }
   ?>
   &nbsp;&nbsp;&nbsp;
   <a href='my_cred.php'  class='a_black<?php if ($page_name=='my_cred') { echo "_cur"; } ?>'>Мои кредиты</a>
   &nbsp;&nbsp;&nbsp;
  </td>
  <td align=right>
   <?=$g_user_fio?>
   &nbsp;&nbsp;&nbsp;
   <a href='index.php?act=logout' class='exit_lnk'>Выход</a>
   &nbsp;&nbsp;&nbsp;
  </td>
 </tr>
</table>

<?php
} // if ($no_graph_head!==1)
?>
