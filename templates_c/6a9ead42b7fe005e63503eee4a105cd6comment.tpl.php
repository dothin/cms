<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->vars['webname'];?></title>
<link rel="stylesheet" type="text/css" href="../style/admin.css" />
<script type="text/javascript" src="../js/admin_manage.js"></script>
</head>
<body id="main">

<div class="map">
	管理首页 &gt;&gt; 内容管理 &gt;&gt; <strong id="title"><?php echo $this->vars['title'];?></strong>
</div>

<ol>
	<li><a href="comment.php?action=show" class="selected">评论列表</a></li>
</ol>

<?php if(@$this->vars['show']){?>
<form method="post" action="?action=states">
<table cellspacing="0">
	<tr><th>编号</th><th>评论内容</th><th>评论者</th><th>所属文档</th><th>状态</th><th>批审</th><th>操作</th></tr>
	<?php if(@$this->vars['CommentList']){?>
	<?php foreach($this->vars['CommentList'] as $key=>$value){ ?>
	<tr>
		<td><script type="text/javascript">document.write(<?php echo $key+1; ?>+<?php echo $this->vars['num'];?>);</script></td>
		<td title="<?php echo $value->full; ?>"><?php echo $value->content; ?></td>
		<td><?php echo $value->user; ?></td>
		<td><a href="../details.php?id=<?php echo $value->cid; ?>" target="_blank" title="<?php echo $value->title; ?>">查看</a></td>
		<td><?php echo $value->state; ?></td>
		<td><input type="text" name="states[<?php echo $value->id; ?>]" value="<?php echo $value->num; ?>" class="text sort" /></td>
		<td><a href="comment.php?action=delete&id=<?php echo $value->id; ?>" onclick="return confirm('你真的要删除这条评论吗？') ? true : false">删除</a></td>
	</tr>
	<?php } ?>
	<tr><td></td><td></td><td></td><td></td><td></td><td><input type="submit" name="send" value="批审" style="cursor:pointer;" /></td><td></td></tr>
	<?php }else{?>
	<tr><td colspan="7">对不起，没有任何数据</td></tr>
	<?php }?>
</table>
</form>
<div id="page"><?php echo $this->vars['page'];?></div>
<?php }?>






</body>
</html>