<script src="config/static.php?type=header"></script>
<div id="top">
	<?php echo $this->vars['header'];?>
	<a href="###" class="adv">这里可以放置文字广告1</a>
	<a href="###" class="adv">这里可以放置文字广告2</a>
</div>
<div id="header">
	<h1><a href="###"><?php echo $this->vars['webname'];?></a></h1>
	<div class="adver"><a href="###"><img src="images/adver.png" alt="广告图" /></a></div>
</div>
<div id="nav">
	<ul>
		<li><a href="./">首页</a></li>
		<?php if(@$this->vars['FrontNav']){?>
		<?php foreach($this->vars['FrontNav'] as $key=>$value){ ?>
		<li><a href="list.php?id=<?php echo $value->id; ?>" title=""><?php echo $value->nav_name; ?></a></li>
		<?php } ?>
		<?php }?>
	</ul>
</div>
<div id="search">
	<form method="get" action="search.php">
		<select name="type">
			<option selected="selected" value="1">按标题</option>
			<option value="2">按关键字</option>
		</select>
		<input type="text" name="inputkeyword" class="text" />
		<input type="submit"  class="submit" value="搜索" />
	</form>
	<strong>TAG标签：</strong>
	<ul>
		<?php if(@$this->vars['FiveTag']){?>
		<?php foreach($this->vars['FiveTag'] as $key=>$value){ ?>
		<li><a href="search.php?type=3&inputkeyword=<?php echo $value->tagname; ?>"><?php echo $value->tagname; ?>(<?php echo $value->count; ?>)</a></li>
		<?php } ?>
		<?php }?>
	</ul>
</div>