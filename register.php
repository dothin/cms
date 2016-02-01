<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-18 21:59:21
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-01-29 00:37:23
 */
require dirname(__FILE__).'/init.inc.php';
global $tpl;
$register=new RegisterAction($tpl);
$register->action();
$tpl->display('register.tpl');