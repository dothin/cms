<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-18 21:59:21
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-01-29 11:09:31
 */
require dirname(__FILE__).'/init.inc.php';
global $tpl;
$index=new IndexAction($tpl);
$index->action();
$tpl->display('index.tpl');