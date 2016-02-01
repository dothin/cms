<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>main</title>
<link rel="stylesheet" type="text/css" href="../style/admin.css" />
</head>
<body id="main">

<div class="map">
	管理首页 &gt;&gt; 系统配置 &gt;&gt; <strong class="title">系统配置文件</strong>
</div>



<form method="post">
<table cellspacing="0">
	<tr><th style="text-align:center;"><strong>系统配置信息</strong></th></tr>
	<tr><td>网站　　名称：<input type="text" class="text" name="webname" value="<?php echo $this->vars['webname'];?>" /></td></tr>
	<tr><td>常规　　分页：<input type="text" class="text" name="page_size" value="<?php echo $this->vars['page_size'];?>" /></td></tr>
	<tr><td>文档　　分页：<input type="text" class="text" name="article_size" value="<?php echo $this->vars['article_size'];?>" /></td></tr>
	<tr><td>导航　　个数：<input type="text" class="text" name="nav_size" value="<?php echo $this->vars['nav_size'];?>" /></td></tr>
	<tr><td>图片上传目录：<input type="text" class="text" name="updir" value="<?php echo $this->vars['updir'];?>" /></td></tr>
	<tr><td>轮播播放速度：<input type="text" class="text" name="ro_time" value="<?php echo $this->vars['ro_time'];?>" /></td></tr>
	<tr><td>轮播播放个数：<input type="text" class="text" name="ro_num" value="<?php echo $this->vars['ro_num'];?>" /></td></tr>
	<tr><td>文字广告个数：<input type="text" class="text" name="adver_text_num" value="<?php echo $this->vars['adver_text_num'];?>" /></td></tr>
	<tr><td>图片广告个数：<input type="text" class="text" name="adver_pic_num" value="<?php echo $this->vars['adver_pic_num'];?>" /></td></tr>
</table>
<p style="margin:20px;text-align:center;"><input name="send" type="submit" value="修改配置文件" /></p>
</form>







</body>
</html>