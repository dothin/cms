<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-20 10:20:11
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-02-01 17:16:30
 */
require substr(dirname(__FILE__),0,-6).'/init.inc.php';
global $tpl;
Validate::checkSession();
Validate::checkPremission('14','警告，权限不足，您不能管理系统配置文件！');
//入口
$system=new SystemAction($tpl);
$system->action();
$tpl->display('system.tpl');