<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-24 14:08:44
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-01-27 00:33:46
 */
require dirname(__FILE__).'/init.inc.php';
global $tpl;

$details=new DetailsAction($tpl);
$details->action();
$tpl->display('details.tpl');