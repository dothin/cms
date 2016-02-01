<?php
require substr(dirname(__FILE__),0,-6).'/init.inc.php';
Validate::checkSession();
Validate::checkPremission('13','警告，权限不足，您不能管理会员！');
global $tpl;
$user = new UserAction($tpl);    //入口
$user->action();
$tpl->display('user.tpl');
?>