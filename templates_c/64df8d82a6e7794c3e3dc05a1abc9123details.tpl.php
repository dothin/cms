<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CMS内容管理系统</title>
<link rel="stylesheet" type="text/css" href="style/basic.css" />
<link rel="stylesheet" type="text/css" href="style/details.css" />
<script src="config/static.php?id=<?php echo $this->vars['id'];?>&type=details"></script>
<script src="js/details.js"></script>
</head>
<body>
<script>get();</script>
<?php $tpl->create('header.tpl'); ?>
<div id="details">
	<h2>当前位置 &gt; <?php echo $this->vars['nav'];?></h2>
	<h3><?php echo $this->vars['titlec'];?></h3>
	<div class="d1">时间：<?php echo $this->vars['date'];?> 来源：<?php echo $this->vars['source'];?> 作者：<?php echo $this->vars['author'];?> 点击量：<?php echo $this->vars['count'];?></div>
	<div class="d2"><?php echo $this->vars['info'];?></div>
	<div class="d3"><?php echo $this->vars['content'];?></div>
	<div class="d4">TAB标签：<?php echo $this->vars['tag'];?></div>
	<div class="d6">
		<h2><a href="feedback.php?cid=<?php echo $this->vars['id'];?>" target="_blank" title="">已有<span><?php echo $this->vars['comment'];?></span>人评论</a>最新评论</h2>
		<?php if(@$this->vars['ThreeNewComment']){?>
		<?php foreach($this->vars['ThreeNewComment'] as $key=>$value){ ?>
		<dl>
			<dt><img src="images/<?php echo $value->face; ?>" alt="<?php echo $value->user; ?>" /></dt>
			<dd><em><?php echo $value->date; ?> 发表</em><span>[<?php echo $value->user; ?>]</span></dd>
			<dd class="info">[<?php echo $value->manner; ?>]<?php echo $value->content; ?></dd>
			<dd class="bottom"><a href="feedback.php?cid=<?php echo $value->cid; ?>&id=<?php echo $value->id; ?>&type=sustain" target="_blank">[<?php echo $value->sustain; ?>]支持</a> <a href="feedback.php?cid=<?php echo $value->cid; ?>&id=<?php echo $value->id; ?>&type=oppose" target="_blank">[<?php echo $value->oppose; ?>]反对</a></dd>
		</dl>
		<?php } ?>
		<?php }else{?>
		<p>此文档没有任何评论！</p>
		<?php }?>
	</div>
	<div class="d5">
		<form action="feedback.php?cid=<?php echo $this->vars['id'];?>" target="_blank" name="comment" method="post" >
		
			<p>您对本文的态度：
				<input type="radio" checked name="manner" value="1" />支持
				<input type="radio" name="manner" value="0" />中立
				<input type="radio" name="manner" value="-1" />反对
			</p>
			<p class="red">请不要发表关于政治，反动，色情子类的评论。</p>
			<p><textarea name="content"></textarea></p>
			<p>
				验证码：<input type="text" class="text" name="code" value="">
				<img src="config/code.php" onclick="javascript:this.src='config/code.php?tm='+Math.random();" class="code" />
				<input type="submit" onclick="return checkComment();" name="send" value="提交评论">
			</p>
		</form>
	</div>
</div>
<div id="sidebar">
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