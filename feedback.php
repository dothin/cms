<?php
require dirname(__FILE__).'/init.inc.php';
global $tpl;
$feedback = new FeedBackAction($tpl); 
$feedback->action(); 
$tpl->display('feedback.tpl');
?>