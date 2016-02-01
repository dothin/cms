<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->vars['webname'];?>-CMS内容管理系统</title>
<link rel="stylesheet" type="text/css" href="style/basic.css" />
<link rel="stylesheet" type="text/css" href="style/index.css" />
<script type="text/javascript" src="js/reg.js"></script>
<script type="text/javascript" src="config/static.php?type=index"></script>
</head>
<body>
<?php $tpl->create('header.tpl'); ?>
<div id="user">
	<?php if(@$this->vars['cache']){?>
		<?php echo $this->vars['member'];?>
	<?php }else{?>
		<?php if(@$this->vars['login']){?>
		<h2>会员登录</h2>
		<form method="post" name="login" action="register.php?action=login">
			<label>用户名：<input type="text" name="user" class="text" /></label>
			<label>密　码：<input type="password" name="pass" class="text" /></label>
			<label class="yzm">验证码：<input type="text" name="code" class="text code" /> <img src="config/code.php" onclick="javascript:this.src='config/code.php?tm='+Math.random();" class="code" /></label>
			<p><input type="submit" name="send" value="登录" onclick="return checkLogin();" class="submit" /> <a href="register.php?action=reg">注册会员</a> <a href="###">忘记密码?</a></p>
		</form>
		<?php }else{?>
		<h2>会员信息</h2>
		<div class="a">您好，<strong><?php echo $this->vars['user'];?></strong> 欢迎光临</div>
		<div class="b">
			<img src="images/<?php echo $this->vars['face'];?>" alt="<?php echo $this->vars['user'];?>" />
			<a href="###">个人中心</a>
			<a href="###">我的评论</a>
			<a href="register.php?action=logout">退出登录</a>
		</div>
		<?php }?>
	<?php }?>
	
	<h3>最近登录会员 <span>────────────</span></h3>
	<?php if(@$this->vars['AllLaterUser']){?>
	<?php foreach($this->vars['AllLaterUser'] as $key=>$value){ ?>
	<dl>
		<dt><img src="images/<?php echo $value->face; ?>" alt="<?php echo $value->user; ?>" /></dt>
		<dd><?php echo $value->user; ?></dd>
	</dl>
	<?php } ?>
	<?php }?>
</div>
<div id="news">
	<h3><a href="details.php?id=<?php echo $this->vars['TopId'];?>" target="_blank"><?php echo $this->vars['TopTitle'];?></a></h3>
	<p>核心提示：<?php echo $this->vars['TopInfo'];?><a href="details.php?id=<?php echo $this->vars['TopId'];?>" target="_blank">[查看全文]</a></p>
	<p class="link">
		<?php if(@$this->vars['NewTopList']){?>
		<?php foreach($this->vars['NewTopList'] as $key=>$value){ ?>
		<a href="details.php?id=<?php echo $value->id; ?>" target="_blank"><?php echo $value->title; ?></a> <?php echo $value->line; ?>
		<?php } ?>
		<?php }?>
	</p>
	<ul>
		<?php if(@$this->vars['NewList']){?>
		<?php foreach($this->vars['NewList'] as $key=>$value){ ?>
		<li><em><?php echo $value->date; ?></em><a href="details.php?id=<?php echo $value->id; ?>" target="_blank"><?php echo $value->title; ?></a></li>
		<?php } ?>
		<?php }?>
	</ul>
</div>
<div id="pic">
	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" id="scriptmain" name="scriptmain" codebase="http://download.macromedia.com/pub/shockwave/cabs/
	flash/swflash.cab#version=6,0,29,0" width="268" height="193">
	      <param name="movie" value="images/lbxml.swf">
	      <param name="quality" value="high">
	      <param name="scale" value="noscale">
	      <param name="LOOP" value="false">
	      <param name="menu" value="false">
	      <param name="wmode" value="transparent">
	      <embed src="images/lbxml.swf" width="268" height="193" loop="false" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" salign="T" name="scriptmain" menu="false" wmode="transparent">
	</object>
</div>
<div id="rec">
	<h2>特别推荐</h2>
	<ul>
		<?php if(@$this->vars['NewRecList']){?>
		<?php foreach($this->vars['NewRecList'] as $key=>$value){ ?>
		<li><em><?php echo $value->date; ?></em><a href="details.php?id=<?php echo $value->id; ?>" target="_blank"><?php echo $value->title; ?></a></li>
		<?php } ?>
		<?php }?>
	</ul>
</div>
<div id="sidebar-right">
	<div class="adver"><script type="text/javascript" src="js/sidebar_adver.js"></script></div>
	<div class="hot">
		<h2>本月热点</h2>
		<ul>
			<?php if(@$this->vars['MonthHotList']){?>
			<?php foreach($this->vars['MonthHotList'] as $key=>$value){ ?>
			<li><em><?php echo $value->date; ?></em><a href="details.php?id=<?php echo $value->id; ?>" target="_blank"><?php echo $value->title; ?></a></li>
			<?php } ?>
			<?php }?>
		</ul>
	</div>
	<div class="comm">
		<h2>本月评论</h2>
		<ul>
			<?php if(@$this->vars['MonthCommentList']){?>
			<?php foreach($this->vars['MonthCommentList'] as $key=>$value){ ?>
			<li><em><?php echo $value->date; ?></em><a href="details.php?id=<?php echo $value->id; ?>" target="_blank"><?php echo $value->title; ?></a></li>
			<?php } ?>
			<?php }?>
		</ul>
	</div>
	<div class="vote">
		<h2>调查投票</h2>
		<!-- <h3><?php echo $this->vars['vote_title'];?></h3>
		<form method="post" action="cast.php" target="_blank">
			<?php if(@$this->vars['vote_item']){?>
			<?php foreach($this->vars['vote_item'] as $key=>$value){ ?>
			<label><input type="radio" name="vote" value="<?php echo $value->id; ?>" /> <?php echo $value->title; ?></label>
			<?php } ?>
			<?php }?>
			<p><input type="submit" value="投票" name="send" /> <input type="button" onclick="javascript:window.open('cast.php')" value="查看" /></p>
		</form> -->
	</div>
</div>
<div id="picnews">
	<h2>图文资讯</h2>
	<?php if(@$this->vars['PicList']){?>
	<?php foreach($this->vars['PicList'] as $key=>$value){ ?>
	<dl>
		<dt><a href="details.php?id=<?php echo $value->id; ?>" target="_blank"><img src="<?php echo $value->thumbnail; ?>" alt="<?php echo $value->title; ?>" /></a></dt>
		<dd><a href="details.php?id=<?php echo $value->id; ?>" target="_blank"><?php echo $value->title; ?></a></dd>
	</dl>
	<?php } ?>
	<?php }?>
</div>
<div id="newslist">
	<?php if(@$this->vars['FourNav']){?>
	<?php foreach($this->vars['FourNav'] as $key=>$value){ ?>
	<div class="<?php echo $value->class; ?>">
		<h2><a href="list.php?id=<?php echo $value->id; ?>" target="_blank">更多</a><?php echo $value->nav_name; ?></h2>
		<ul>
			<?php if(@$value->list){?>
			<?php foreach($value->list as $key=>$value){ ?>
			<li><em><?php echo $value->date; ?></em><a href="details.php?id=<?php echo $value->id; ?>" target="_blank"><?php echo $value->title; ?></a></li>
			<?php } ?>
			<?php }else{?>
			暂无数据
			<?php }?>
		</ul>
	</div>
	<?php } ?>
	<?php }?>
</div>
<?php $tpl->create('footer.tpl'); ?>
</body>
</html>