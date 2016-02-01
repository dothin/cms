<?php
require substr(dirname(__FILE__),0,-6).'/init.inc.php';
global $tpl;
Validate::checkSession();
$tpl->assign('admin_user',$_SESSION['admin']['admin_user']);
$tpl->assign('level_name',$_SESSION['admin']['level_name']);
$tpl->display('top.tpl');
?>