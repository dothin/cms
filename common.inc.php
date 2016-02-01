<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-18 22:54:30
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-02-01 00:12:19
 */
//后台缓存开关
define('IS_CACHE', true);
//判断句柄
global $tpl,$cache;
if (IS_CACHE&&!$cache->noCache()) {
    ob_start();
    $tpl->cache(Tool::tplName().'.tpl');
}

$nav=new NavAction($tpl);
//显示主导航
$nav->showFront();

$cookie=new Cookie('user');
if (IS_CACHE) {
    $tpl->assign('header','<script>getHeader();</script>');
}else{
    if ($cookie->getCookie()) {
        $tpl->assign('header',$cookie->getCookie().'您好！<a href="register.php?action=logout">退出</a>');
    }else{
        $tpl->assign('header','<a href="register.php?action=login" class="user">登录</a>
        <a href="register.php?action=reg" class="user">注册</a>');
    }
}

$tag=new TagAction($tpl);
$tag->action();

$tpl->assign('webname',WEBNAME);
