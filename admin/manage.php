<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-18 23:54:57
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-02-01 15:17:42
 */
require substr(dirname(__FILE__),0,-6).'/init.inc.php';
Validate::checkSession();
Validate::checkPremission('3','没有管理管理员的权限');
global $tpl;
//入口
$manage = new ManageAction($tpl);
$manage->action();
$tpl->display('manage.tpl');