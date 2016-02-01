<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-24 14:08:44
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-01-31 16:51:43
 */
require dirname(__FILE__).'/init.inc.php';
global $tpl;
$search=new SearchAction($tpl);
$search->action();
$tpl->display('search.tpl');