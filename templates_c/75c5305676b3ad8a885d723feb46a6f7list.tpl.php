<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->vars['webname'];?> - CMS内容管理系统</title>
<link rel="stylesheet" type="text/css" href="style/basic.css" />
<link rel="stylesheet" type="text/css" href="style/list.css" />
</head>
<body>
<?php $tpl->create('header.tpl'); ?>
<div id="list">
	<h2>当前位置 &gt; <?php echo $this->vars['nav'];?></h2>
	<?php if(@$this->vars['AllListContent']){?>
	<?php foreach($this->vars['AllListContent'] as $key=>$value){ ?>
	<dl>
		<dt><a href="details.php?id=<?php echo $value->id; ?>" target="_blank"><img src="<?php echo $value->thumbnail; ?>" alt="<?php echo $value->title; ?>" /></a></dt>
		<dd>[<strong><?php echo $value->nav_name; ?></strong>] <a href="details.php?id=<?php echo $value->id; ?>" target="_blank"><?php echo $value->title; ?></a></dd>
		<dd>日期：<?php echo $value->date; ?> 点击率：<?php echo $value->count; ?> 关键字：[<?php echo $value->keyword; ?>]</dd>
		<dd>核心提示：<?php echo $value->info; ?></dd>
	</dl>
	<?php } ?>
	<?php }else{?>
	<p class="none">没有任何数据</p>
	<?php }?>
	<div id="page"><?php echo $this->vars['page'];?></div>
</div>
<div id="sidebar">
	<div class="nav">
		<h2>子栏目列表</h2>
		<?php if(@$this->vars['childNav']){?>
		<?php foreach($this->vars['childNav'] as $key=>$value){ ?>
		<strong><a href="list.php?id=<?php echo $value->id; ?>"><?php echo $value->nav_name; ?></a></strong>
		<?php } ?>
		<?php }else{?>
		<span>该栏目没有子类</span>
		<?php }?>
	</div>
	<div class="right">
		<h2>本月本类推荐</h2>
		<ul>
			<?php if(@$this->vars['MonthNavRec']){?>
			<?php foreach($this->vars['MonthNavRec'] as $key=>$value){ ?>
			<li><em><?php echo $value->date; ?></em><a href="details.php?id=<?php echo $value->id; ?>" target="_blank"><?php echo $value->title; ?></a></li>
			<?php } ?>
			<?php }?>
		</ul>
	</div>
	<div class="right">
		<h2>本月本类热点</h2>
		<ul>
			<?php if(@$this->vars['MonthNavHot']){?>
			<?php foreach($this->vars['MonthNavHot'] as $key=>$value){ ?>
			<li><em><?php echo $value->date; ?></em><a href="details.php?id=<?php echo $value->id; ?>" target="_blank"><?php echo $value->title; ?></a></li>
			<?php } ?>
			<?php }?>
		</ul>
	</div>
	<div class="right">
		<h2>本月本类图文</h2>
		<ul>
			<?php if(@$this->vars['MonthNavPic']){?>
			<?php foreach($this->vars['MonthNavPic'] as $key=>$value){ ?>
			<li><em><?php echo $value->date; ?></em><a href="details.php?id=<?php echo $value->id; ?>" target="_blank"><?php echo $value->title; ?></a></li>
			<?php } ?>
			<?php }?>
		</ul>
	</div>
</div>
<?php $tpl->create('footer.tpl'); ?>
</body>
</html>