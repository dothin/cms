<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-20 10:20:11
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-02-01 15:18:56
 */
require substr(dirname(__FILE__),0,-6).'/init.inc.php';
global $tpl;
Validate::checkSession();
Validate::checkPremission('4','没有管理等级的权限');
//入口
$level=new LevelAction($tpl);
$level->action();
$tpl->display('level.tpl');