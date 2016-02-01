<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->vars['webname'];?></title>
<link rel="stylesheet" type="text/css" href="../style/admin.css" />
<script type="text/javascript" src="../js/admin_content.js"></script>
<script src="../ckeditor//ckeditor.js"></script>
</head>
<body id="main">

<div class="map">
	内容管理 &gt;&gt; 查看文档列表 &gt;&gt; <strong id="title"><?php echo $this->vars['title'];?></strong>
</div>

<ol>
	<li><a href="content.php?action=show" class="selected">文档列表</a></li>
	<li><a href="content.php?action=add">新增文档</a></li>
	<?php if(@$this->vars['update']){?>
	<li><a href="content.php?action=update&id=<?php echo $this->vars['id'];?>">修改文档</a></li>
	<?php }?>
</ol>
<?php if(@$this->vars['show']){?>
<table cellspacing="0">
	<tr><th>编号</th><th>标题</th><th>属性</th><th>文档类别</th><th>浏览次数</th><th>文档发布时间</th><th>操作</th></tr>
	<?php if(@$this->vars['SearchContent']){?>
	<?php foreach($this->vars['SearchContent'] as $key=>$value){ ?>
	<tr>
		<td><script>document.write(<?php echo $key+1; ?>+<?php echo $this->vars['num'];?>);</script></td>
		<td><a href="../details.php?id=<?php echo $value->id; ?>" target="_blank" title="<?php echo $value->t; ?>"><?php echo $value->title; ?></a></td>
		<td><?php echo $value->attr; ?></td>
		<td><a href="?action=show&nav=<?php echo $value->nav; ?>" title=""><?php echo $value->nav_name; ?></a></td>
		<td><?php echo $value->count; ?></td>
		<td><?php echo $value->date; ?></td>
		<td><a href="content.php?action=update&id=<?php echo $value->id; ?>">修改</a> | <a href="content.php?action=delete&id=<?php echo $value->id; ?>" onclick="return confirm('您真的要删除？');">删除</a></td>
	</tr>
	<?php } ?>
	<?php }else{?>
		<tr><td colspan="7">对不起，没有任何数据</td></tr>
	<?php }?>
</table>
<form action="?" method="get" >

	<div id="page" style="text-align:center;margin-top:30px;">
		<?php echo $this->vars['page'];?>
		<input type="hidden" name="action" value="show">
		<select name="nav" class="select">
			<option value="0">默认全部</option>
			<?php echo $this->vars['nav'];?>
		</select>
		<input type="submit" name="" value="查询">
	</div>
</form>
<?php }?>

<?php if(@$this->vars['add']){?>
<form name="content" method="post" action="?action=add">
<table cellspacing="0" class="content">
	<tr><th><strong>发布一条新文档</strong></th></tr>
	<tr><td>文档标题：<input type="text" name="title" class="text" />[*必填](标题2到50位)</td></tr>
	<tr><td>栏　　目：<select name="nav"><option value="">请选择一个栏目类别</option><?php echo $this->vars['nav'];?></select>[*必选]</td></tr>
	<tr><td>定义属性：<input type="checkbox" name="attr[]" value="头条" />头条
								<input type="checkbox" name="attr[]" value="推荐" />推荐
								<input type="checkbox" name="attr[]" value="加粗" />加粗
								<input type="checkbox" name="attr[]" value="跳转" />跳转
	</td></tr>
	<tr><td>标　　签：<input type="text" name="tag" class="text" />(每个标签用','隔开，不得大于30位)</td></tr>
	<tr><td>关 键 字：<input type="text" name="keyword" class="text" />(每个关键字用','隔开，不得大于30位)</td></tr>
	<tr><td>缩 略 图：<input type="text" name="thumbnail" readonly="readonly" class="text" /><input type="button" name="" value="上传缩略图" onclick="centerWindow('../templates/upfile.html','upfile','400','100');">(缩略图必须是jpg,gif,png，并且不大于2000kb)
	<img name="pic" style="display:none;" src="" alt="">
	</td></tr>
	<tr><td>文章来源：<input type="text" name="source" class="text" />(内容来源不得大于20位)</td></tr>
	<tr><td>作　　者：<input type="text" name="author" class="text" value="<?php echo $this->vars['author'];?>" />(作者不得大于10位)</td></tr>
	<tr><td><span class="middle">内容摘要：</span><textarea name="info"></textarea>(内容摘要不得大于200位)</td></tr>
	<tr class="ckeditor"><td><textarea id="TextArea1" name="content" class="ckeditor"></textarea></td></tr>
	<tr><td>评论选项：<input type="radio" name="commend" value="1" checked="checked" />允许评论 
								<input type="radio" name="commend" value="0" />禁止评论 
					　　　　浏览次数：<input type="text" name="count" value="100" class="text small" />
	</td></tr>
	<tr><td>文档排序：<select name="sort">
									<option value="0">默认排序</option>
									<option value="1">置顶一天</option>
									<option value="2">置顶一周</option>
									<option value="3">置顶一月</option>
									<option value="4">置顶一年</option>
								</select>
					 　 　　消费金币：<input type="text" name="gold" value="0" class="text small" />
	</td></tr>
	<tr><td>阅读权限：<select name="readlimit">
									<option value="0">开放浏览</option>
									<option value="1">初级会员</option>
									<option value="2">中级会员</option>
									<option value="3">高级会员</option>
									<option value="4">VIP会员</option>
								</select>
				标题颜色：<select name="color">
									<option value="">默认颜色</option>
									<option value="red" style="color:red;">红色</option>
									<option value="blue" style="color:blue;">蓝色</option>
									<option value="orange" style="color:orange;">橙色</option>
								</select>
	</td></tr>
	<tr><td><input type="submit" name="send" value="发布文档" onclick="return checkAddContent();" /> <input type="reset" value="重置" /></td></tr>
	<tr><td></td></tr>
</table>
</form>
<?php }?>
<?php if(@$this->vars['update']){?>
<form name="content" method="post" action="?action=update">
<input type="hidden" name="id" value="<?php echo $this->vars['id'];?>">
<input type="hidden" name="prev_url" value="<?php echo $this->vars['prev_url'];?>">
<table cellspacing="0" class="content">
	<tr><th><strong>发布一条新文档</strong></th></tr>
	<tr><td>文档标题：<input type="text" name="title" class="text" value="<?php echo $this->vars['titlec'];?>" />[*必填](标题2到50位)</td></tr>
	<tr><td>栏　　目：<select name="nav"><option value="">请选择一个栏目类别</option><?php echo $this->vars['nav'];?></select>[*必选]</td></tr>
	<tr><td>定义属性：<?php echo $this->vars['attr'];?>
	</td></tr>
	<tr><td>标　　签：<input type="text" name="tag" class="text" value="<?php echo $this->vars['tag'];?>" />(每个标签用','隔开，不得大于30位)</td></tr>
	<tr><td>关 键 字：<input type="text" name="keyword" class="text"  value="<?php echo $this->vars['keyword'];?>" />(每个关键字用','隔开，不得大于30位)</td></tr>
	<tr><td>缩 略 图：<input type="text" name="thumbnail"  value="<?php echo $this->vars['thumbnail'];?>" readonly="readonly" class="text" /><input type="button" name="" value="上传缩略图" onclick="centerWindow('../templates/upfile.html','upfile','400','100');">(缩略图必须是jpg,gif,png，并且不大于2000kb)
	<img name="pic" style="display:block;" src="<?php echo $this->vars['thumbnail'];?>" alt="">
	</td></tr>
	<tr><td>文章来源：<input type="text" name="source" value="<?php echo $this->vars['source'];?>" class="text" />(内容来源不得大于20位)</td></tr>
	<tr><td>作　　者：<input type="text" name="author" class="text" value="<?php echo $this->vars['author'];?>" />(作者不得大于10位)</td></tr>
	<tr><td><span class="middle">内容摘要：</span><textarea name="info"><?php echo $this->vars['info'];?></textarea>(内容摘要不得大于200位)</td></tr>
	<tr class="ckeditor"><td><textarea id="TextArea1" name="content" class="ckeditor"><?php echo $this->vars['content'];?></textarea></td></tr>
	<tr><td>评论选项：<?php echo $this->vars['commend'];?>
					　　　　浏览次数：<input type="text" name="count" value="<?php echo $this->vars['count'];?>" class="text small" />
	</td></tr>
	<tr><td>文档排序：<select name="sort">
									<?php echo $this->vars['sort'];?>
								</select>
					 　 　　消费金币：<input type="text" name="gold" value="<?php echo $this->vars['gold'];?>" class="text small" />
	</td></tr>
	<tr><td>阅读权限：<select name="readlimit">
									<?php echo $this->vars['readlimit'];?>
								</select>
				标题颜色：<select name="color">
									<?php echo $this->vars['color'];?>
								</select>
	</td></tr>
	<tr><td><input type="submit" name="send" value="修改文档" onclick="return checkAddContent();" /> <input type="reset" value="重置" /></td></tr>
	<tr><td></td></tr>
</table>
</form>
<?php }?>

</body>
</html>