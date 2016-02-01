<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-18 23:54:57
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-02-01 15:23:25
 */
require substr(dirname(__FILE__),0,-6).'/init.inc.php';
Validate::checkSession();
Validate::checkPremission('8','没有管理审核评论的权限');
global $tpl;
//入口
$comment = new CommentAction($tpl);
$comment->action();
$tpl->display('comment.tpl');