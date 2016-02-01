<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-20 10:20:11
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-02-01 15:19:59
 */
require substr(dirname(__FILE__),0,-6).'/init.inc.php';
global $tpl;
Validate::checkSession();
Validate::checkPremission('5','没有管理权限的权限');
//入口
$premission=new PremissionAction($tpl);
$premission->action();
$tpl->display('premission.tpl');