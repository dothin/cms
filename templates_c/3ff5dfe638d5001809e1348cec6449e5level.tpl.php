<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>main</title>
<link rel="stylesheet" type="text/css" href="../style/admin.css" />
<script type="text/javascript" src="../js/admin_level.js"></script>
</head>
<body id="main">

<div class="map">
	管理首页 &gt;&gt; 等级管理 &gt;&gt; <strong id="title"><?php echo $this->vars['title'];?></strong>
</div>

<ol>
	<li><a href="level.php?action=show" class="selected">等级列表</a></li>
	<li><a href="level.php?action=add">新增等级</a></li>
	<?php if(@$this->vars['update']){?>
	<li><a href="level.php?action=update&id=<?php echo $this->vars['id'];?>">修改等级</a></li>
	<?php }?>
</ol>

<?php if(@$this->vars['show']){?>
<table cellspacing="0">
	<tr><th>编号</th><th>等级名称</th><th>描述</th><th>权限标识</th><th>操作</th></tr>
	<?php if(@$this->vars['AllLevel']){?>
	<?php foreach($this->vars['AllLevel'] as $key=>$value){ ?>
	<tr>
		<td><script type="text/javascript">document.write(<?php echo $key+1; ?>+<?php echo $this->vars['num'];?>);</script></td>
		<td><?php echo $value->level_name; ?></td>
		<td><?php echo $value->level_info; ?></td>
		<td><?php echo $value->premission; ?></td>
		<td><a href="level.php?action=update&id=<?php echo $value->id; ?>">修改</a> | <a href="level.php?action=delete&id=<?php echo $value->id; ?>" onclick="return confirm('你真的要删除这个等级吗？') ? true : false">删除</a></td>
	</tr>
	<?php } ?>
	<?php }else{?>
	<tr><td colspan="5">对不起，没有任何数据</td></tr>
	<?php }?>
</table>
<div id="page"><?php echo $this->vars['page'];?></div>
<?php }?>


<?php if(@$this->vars['add']){?>
<form method="post" name="add">
	<table cellspacing="0" class="left">
		<tr><td>等级名称：<input type="text" name="level_name" class="text" /> (* 等级名称不得小于两位，不得大于20位！)</td></tr>
		<tr><td><textarea name="level_info"></textarea> (* 描述不得大于200位！)</td></tr>
		<tr><td style="padding-left:60px;padding-right:40%;">
			<?php if(@$this->vars['AllPremission']){?>
			<?php foreach($this->vars['AllPremission'] as $key=>$value){ ?>		
				<input type="checkbox" value="<?php echo $value->id; ?>" name="premission[]" /> <?php echo $value->name; ?>
			<?php } ?>
			<?php }?>
		</td></tr>
		<tr><td><input type="submit" name="send" value="新增等级" onclick="return checkForm();" class="submit level" /> [ <a href="<?php echo $this->vars['prev_url'];?>">返回列表</a> ]</td></tr>
	</table>
</form>
<?php }?>

<?php if(@$this->vars['update']){?>
<form method="post" name="add">
	<input type="hidden" value="<?php echo $this->vars['id'];?>" name="id" />
	<input type="hidden" value="<?php echo $this->vars['prev_url'];?>" name="prev_url" />
	<table cellspacing="0" class="left">
		<tr><td>等级名称：<input type="text" name="level_name" value="<?php echo $this->vars['level_name'];?>" class="text" /></td></tr>
		<tr><td><textarea name="level_info"><?php echo $this->vars['level_info'];?></textarea></td></tr>
		<tr><td style="padding-left:60px;padding-right:40%;">
			<?php echo $this->vars['premission'];?>
		</td></tr>
		<tr><td><input type="submit" name="send" value="修改等级" onclick="return checkForm();" class="submit level" /> [ <a href="<?php echo $this->vars['prev_url'];?>">返回列表</a> ]</td></tr>
	</table>
</form>
<?php }?>



</body>
</html>