<?php
require substr(dirname(__FILE__),0,-6).'/init.inc.php';
Validate::checkSession();
Validate::checkPremission('7','没有管理文档操作的权限');
global $tpl;
$content = new ContentAction($tpl);   //入口
$content->action();

$tpl->display('content.tpl');

?>