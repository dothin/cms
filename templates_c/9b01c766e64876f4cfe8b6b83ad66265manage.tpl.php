<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>main</title>
<link rel="stylesheet" type="text/css" href="../style/admin.css" />
<script type="text/javascript" src="../js/admin_manage.js"></script>
</head>
<body id="main">

<div class="map">
	管理首页 &gt;&gt; 管理员管理 &gt;&gt; <strong id="title"><?php echo $this->vars['title'];?></strong>
</div>
<ol>
	<li><a href="manage.php?action=show" class="selected">管理员列表</a></li>
	<li><a href="manage.php?action=add">新增管理员</a></li>
	<?php if(@$this->vars['update']){?>
	<li><a href="manage.php?action=update&id=<?php echo $this->vars['id'];?>">修改管理员</a></li>
	<?php }?>
</ol>
<?php if(@$this->vars['show']){?>
<table cellspacing="0">
	<tr><th>编号</th><th>用户名</th><th>等级</th><th>登录次数</th><th>最近登录ip</th><th>最近登录时间</th><th>操作</th></tr>
	<?php if(@$this->vars['AllManage']){?>
	<?php foreach($this->vars['AllManage'] as $key=>$value){ ?>
	<tr>
		<td><script>document.write(<?php echo $key+1; ?>+<?php echo $this->vars['num'];?>);</script></td>
		<td><?php echo $value->admin_user; ?></td>
		<td><?php echo $value->level_name; ?></td>
		<td><?php echo $value->login_count; ?></td>
		<td><?php echo $value->last_ip; ?></td>
		<td><?php echo $value->last_time; ?></td>
		<td><a href="manage.php?action=update&id=<?php echo $value->id; ?>">修改</a> | <a href="manage.php?action=delete&id=<?php echo $value->id; ?>" onclick="return confirm('您真的要删除？');">删除</a></td>
	</tr>
	<?php } ?>
	<?php }else{?>
		<tr><td colspan="7">对不起，没有任何数据</td></tr>
	<?php }?>
</table>
<div id="page" style="text-align:center;margin-top:30px;">
	<?php echo $this->vars['page'];?>
</div>
<?php }?>


<?php if(@$this->vars['add']){?>
<form method="post" name="add">
	<table cellspacing="0" class="left">
		<tr><td>用户名：<input type="text" name="admin_user" class="text" />(*不得小于两位，不得大于20位)</td></tr>
		<tr><td>密　码：<input type="password" name="admin_pass" class="text" />(*不得小于6位)</td></tr>
		<tr><td>确认密码：<input type="password" name="noadmin_pass" class="text" /></td></tr>
		<tr><td>等　级：
			<select name="level">
				<?php foreach($this->vars['AllLevel'] as $key=>$value){ ?>
					<option value="<?php echo $value->id; ?>"><?php echo $value->level_name; ?></option>
				<?php } ?>
			</select>
		</td></tr>
		<tr><td><input type="submit" name="send" value="新增管理员" onclick="return checkAddForm();" class="submit" /> [ <a href="<?php echo $this->vars['prev_url'];?>">返回列表</a> ]</td></tr>
	</table>
</form>
<?php }?>

<?php if(@$this->vars['update']){?>
<form method="post" name="update">
	<input type="hidden" name="id" value="<?php echo $this->vars['id'];?>">
	<input type="hidden" id="level"  value="<?php echo $this->vars['level'];?>">
	<input type="hidden"  name="pass"  value="<?php echo $this->vars['admin_pass'];?>">
	<input type="hidden"  name="prev_url"  value="<?php echo $this->vars['prev_url'];?>">
	<table cellspacing="0" class="left">
		<tr><td>用户名：<input type="text" name="admin_user" class="text" value="<?php echo $this->vars['admin_user'];?>" disabled /></td></tr>
		<tr><td>密　码：<input type="password" name="admin_pass" class="text" />(为空则不修改)</td></tr>
		<tr><td>等　级：
				<select name="level">
					<?php foreach($this->vars['AllLevel'] as $key=>$value){ ?>
						<option value="<?php echo $value->id; ?>"><?php echo $value->level_name; ?></option>
					<?php } ?>
				</select>

		</td></tr>
		<tr><td><input type="submit" name="send" value="修改管理员" onclick="return checkUpdateForm();" class="submit" /> [ <a href="<?php echo $this->vars['prev_url'];?>">返回列表</a> ]</td></tr>
	</table>
</form>
<?php }?>


</body>
</html>