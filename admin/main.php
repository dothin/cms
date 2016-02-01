<?php
require substr(dirname(__FILE__),0,-6).'/init.inc.php';
global $tpl;
Validate::checkSession();
$main=new MainAction($tpl);
$main->action();
$tpl->display('main.tpl');
?>