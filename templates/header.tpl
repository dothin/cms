<script src="config/static.php?type=header"></script>
<div id="top">
	{$header}
	<a href="###" class="adv">这里可以放置文字广告1</a>
	<a href="###" class="adv">这里可以放置文字广告2</a>
</div>
<div id="header">
	<h1><a href="###">{$webname}</a></h1>
	<div class="adver"><a href="###"><img src="images/adver.png" alt="广告图" /></a></div>
</div>
<div id="nav">
	<ul>
		<li><a href="./">首页</a></li>
		{if $FrontNav}
		{foreach $FrontNav(key,value)}
		<li><a href="list.php?id={@value->id}" title="">{@value->nav_name}</a></li>
		{/foreach}
		{/if}
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
		{if $FiveTag}
		{foreach $FiveTag(key,value)}
		<li><a href="search.php?type=3&inputkeyword={@value->tagname}">{@value->tagname}({@value->count})</a></li>
		{/foreach}
		{/if}
	</ul>
</div>