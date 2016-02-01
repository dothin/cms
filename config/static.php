<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-27 00:44:34
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-01-30 12:43:44
 */
require substr(dirname(__FILE__),0,-7).'/init.inc.php';
global $cache;
if (IS_CACHE) {
    $cache->action();
}
