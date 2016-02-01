<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-24 14:08:44
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-01-30 22:24:10
 */
require dirname(__FILE__).'/init.inc.php';
global $tpl;
$list=new ListAction($tpl);
$list->action();
$tpl->display('list.tpl');