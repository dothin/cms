<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>main</title>
<link rel="stylesheet" type="text/css" href="../style/admin.css" />
<script type="text/javascript" src="../js/admin_nav.js"></script>
</head>
<body id="main">

<div class="map">
	内容管理 &gt;&gt; 设置网站导航 &gt;&gt; <strong id="title"><?php echo $this->vars['title'];?></strong>
</div>

<ol>
	<li><a href="nav.php?action=show" class="selected">导航列表</a></li>
	<li><a href="nav.php?action=add">新增导航</a></li>
	<?php if(@$this->vars['update']){?>
	<li><a href="nav.php?action=update&id=<?php echo $this->vars['id'];?>">修改导航</a></li>
	<?php }?>
    <?php if(@$this->vars['addchild']){?>
    <li><a href="nav.php?action=addchild&id=<?php echo $this->vars['pid'];?>">新增子导航</a></li>
    <?php }?>
    <?php if(@$this->vars['showchild']){?>
    <li><a href="nav.php?action=showchild&id=<?php echo $this->vars['pid'];?>">子导航列表</a></li>
    <?php }?>
</ol>

<?php if(@$this->vars['show']){?>
<form action="nav.php?action=sort" method="post" >
    <table cellspacing="0">
    <tr><th>编号</th><th>导航名称</th><th>描述</th><th>子类</th><th>操作</th><th>排序</th></tr>
    <?php if(@$this->vars['AllNav']){?>
    <?php foreach($this->vars['AllNav'] as $key=>$value){ ?>
    <tr>
        <td><script type="text/javascript">document.write(<?php echo $key+1; ?>+<?php echo $this->vars['num'];?>);</script></td>
        <td><?php echo $value->nav_name; ?></td>
        <td><?php echo $value->nav_info; ?></td>
        <td><a href="nav.php?action=showchild&id=<?php echo $value->id; ?>" title="">查看</a>|<a href="nav.php?action=addchild&id=<?php echo $value->id; ?>" title="">增加子类</a></td>
        <td><a href="nav.php?action=update&id=<?php echo $value->id; ?>">修改</a> | <a href="nav.php?action=delete&id=<?php echo $value->id; ?>" onclick="return confirm('你真的要删除这个导航吗？') ? true : false">删除</a></td>
        <td><input type="text" name="sort[<?php echo $value->id; ?>]" value="<?php echo $value->sort; ?>" class="text sort"></td>
    </tr>
    <?php } ?>
    <?php }else{?>
    <tr><td colspan="6">对不起，没有任何数据</td></tr>
    <?php }?>
    <tr><td colspan="6"><input type="submit" name="send" value="排序"></td></tr>
</table>
</form>
<div id="page"><?php echo $this->vars['page'];?></div>

<?php }?>
<?php if(@$this->vars['add']){?>
<form method="post" name="add">
    <input type="hidden" name="pid" value="0">
    <table cellspacing="0" class="left">
        <tr><td>导航名称：<input type="text" name="nav_name" class="text" />(*导航名称为2到20位)</td></tr>
        <tr><td>导航描述：<textarea name="nav_info" id="" cols="30" rows="10"></textarea>(*导航描述不得大于200位)</td></tr>
        <tr><td><input type="submit" name="send" value="新增导航" onclick="return checkForm();"  class="submit" /> [ <a href="<?php echo $this->vars['prev_url'];?>">返回列表</a> ]</td></tr>
    </table>
</form>
<?php }?>
<?php if(@$this->vars['update']){?>
<form method="post" name="update">
    <input type="hidden" name="prev_url" value="<?php echo $this->vars['prev_url'];?>">
    <input type="hidden" name="id" value="<?php echo $this->vars['id'];?>">
    <table cellspacing="0" class="left">
        <tr><td>导航名称：<input type="text" name="nav_name" value="<?php echo $this->vars['nav_name'];?>" class="text" />(*导航名称为2到20位)</td></tr>
        <tr><td>导航描述：<textarea name="nav_info" id="" cols="30" rows="10"><?php echo $this->vars['nav_info'];?></textarea>(*导航描述不得大于200位)</td></tr>
        <tr><td><input type="submit" name="send" value="修改导航" onclick="return checkForm();"  class="submit" /> [ <a href="<?php echo $this->vars['prev_url'];?>">返回列表</a> ]</td></tr>
    </table>
</form>
<?php }?>
<?php if(@$this->vars['showchild']){?>
<form action="nav.php?action=sort" method="post" >
<table cellspacing="0">
    <tr><th>编号</th><th>导航名称</th><th>描述</th><th>操作</th><th>排序</th></tr>
    <?php if(@$this->vars['AllChildNav']){?>
    <?php foreach($this->vars['AllChildNav'] as $key=>$value){ ?>
    <tr>
        <td><script type="text/javascript">document.write(<?php echo $key+1; ?>+<?php echo $this->vars['num'];?>);</script></td>
        <td><?php echo $value->nav_name; ?></td>
        <td><?php echo $value->nav_info; ?></td>
        <td><a href="nav.php?action=update&id=<?php echo $value->id; ?>">修改</a> | <a href="nav.php?action=delete&id=<?php echo $value->id; ?>" onclick="return confirm('你真的要删除这个导航吗？') ? true : false">删除</a></td>
        <td><input type="text" name="sort[<?php echo $value->id; ?>]" value="<?php echo $value->sort; ?>" class="text sort"></td>
    </tr>
    <?php } ?>
    <?php }else{?>
    <tr><td colspan="5">对不起，没有任何数据</td></tr>
    <?php }?>
    <tr><td colspan="6"><input type="submit" name="send" value="排序"></td></tr>
    <tr><td colspan="5">本子类隶属于：<strong><?php echo $this->vars['prev_name'];?></strong>[<a href="nav.php?action=addchild&id=<?php echo $this->vars['pid'];?>">继续增加本类</a>][ <a href="<?php echo $this->vars['prev_url'];?>">返回列表</a> ]</td></tr>
</table>
</form>
<div id="page"><?php echo $this->vars['page'];?></div>

<?php }?>
<?php if(@$this->vars['addchild']){?>
<form method="post" name="add">
    <input type="hidden" name="pid" value="<?php echo $this->vars['pid'];?>">
    <table cellspacing="0" class="left">
        <tr><td>上级导航：<strong><?php echo $this->vars['prev_name'];?></strong></td></tr>
        <tr><td>子导航名称：<input type="text" name="nav_name" class="text" />(*子导航名称为2到20位)</td></tr>
        <tr><td>子导航描述：<textarea name="nav_info" id="" cols="30" rows="10"></textarea>(*子导航描述不得大于200位)</td></tr>
        <tr><td><input type="submit" name="send" value="新增子导航" onclick="return checkForm();"  class="submit" /> [ <a href="<?php echo $this->vars['prev_url'];?>">返回列表</a> ]</td></tr>
    </table>
</form>
<?php }?>


</body>
</html>