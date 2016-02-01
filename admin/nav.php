<?php
require substr(dirname(__FILE__),0,-6).'/init.inc.php';
Validate::checkSession();
Validate::checkPremission('6','没有管理网站导航的权限');
global $tpl;
$nav = new NavAction($tpl);   //入口
$nav->action();
$tpl->display('nav.tpl');
?>