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
	内容管理 &gt;&gt; 设置网站导航 &gt;&gt; <strong id="title">{$title}</strong>
</div>

<ol>
	<li><a href="nav.php?action=show" class="selected">导航列表</a></li>
	<li><a href="nav.php?action=add">新增导航</a></li>
	{if $update}
	<li><a href="nav.php?action=update&id={$id}">修改导航</a></li>
	{/if}
    {if $addchild}
    <li><a href="nav.php?action=addchild&id={$pid}">新增子导航</a></li>
    {/if}
    {if $showchild}
    <li><a href="nav.php?action=showchild&id={$pid}">子导航列表</a></li>
    {/if}
</ol>

{if $show}
<form action="nav.php?action=sort" method="post" >
    <table cellspacing="0">
    <tr><th>编号</th><th>导航名称</th><th>描述</th><th>子类</th><th>操作</th><th>排序</th></tr>
    {if $AllNav}
    {foreach $AllNav(key,value)}
    <tr>
        <td><script type="text/javascript">document.write({@key+1}+{$num});</script></td>
        <td>{@value->nav_name}</td>
        <td>{@value->nav_info}</td>
        <td><a href="nav.php?action=showchild&id={@value->id}" title="">查看</a>|<a href="nav.php?action=addchild&id={@value->id}" title="">增加子类</a></td>
        <td><a href="nav.php?action=update&id={@value->id}">修改</a> | <a href="nav.php?action=delete&id={@value->id}" onclick="return confirm('你真的要删除这个导航吗？') ? true : false">删除</a></td>
        <td><input type="text" name="sort[{@value->id}]" value="{@value->sort}" class="text sort"></td>
    </tr>
    {/foreach}
    {else}
    <tr><td colspan="6">对不起，没有任何数据</td></tr>
    {/if}
    <tr><td colspan="6"><input type="submit" name="send" value="排序"></td></tr>
</table>
</form>
<div id="page">{$page}</div>

{/if}
{if $add}
<form method="post" name="add">
    <input type="hidden" name="pid" value="0">
    <table cellspacing="0" class="left">
        <tr><td>导航名称：<input type="text" name="nav_name" class="text" />(*导航名称为2到20位)</td></tr>
        <tr><td>导航描述：<textarea name="nav_info" id="" cols="30" rows="10"></textarea>(*导航描述不得大于200位)</td></tr>
        <tr><td><input type="submit" name="send" value="新增导航" onclick="return checkForm();"  class="submit" /> [ <a href="{$prev_url}">返回列表</a> ]</td></tr>
    </table>
</form>
{/if}
{if $update}
<form method="post" name="update">
    <input type="hidden" name="prev_url" value="{$prev_url}">
    <input type="hidden" name="id" value="{$id}">
    <table cellspacing="0" class="left">
        <tr><td>导航名称：<input type="text" name="nav_name" value="{$nav_name}" class="text" />(*导航名称为2到20位)</td></tr>
        <tr><td>导航描述：<textarea name="nav_info" id="" cols="30" rows="10">{$nav_info}</textarea>(*导航描述不得大于200位)</td></tr>
        <tr><td><input type="submit" name="send" value="修改导航" onclick="return checkForm();"  class="submit" /> [ <a href="{$prev_url}">返回列表</a> ]</td></tr>
    </table>
</form>
{/if}
{if $showchild}
<form action="nav.php?action=sort" method="post" >
<table cellspacing="0">
    <tr><th>编号</th><th>导航名称</th><th>描述</th><th>操作</th><th>排序</th></tr>
    {if $AllChildNav}
    {foreach $AllChildNav(key,value)}
    <tr>
        <td><script type="text/javascript">document.write({@key+1}+{$num});</script></td>
        <td>{@value->nav_name}</td>
        <td>{@value->nav_info}</td>
        <td><a href="nav.php?action=update&id={@value->id}">修改</a> | <a href="nav.php?action=delete&id={@value->id}" onclick="return confirm('你真的要删除这个导航吗？') ? true : false">删除</a></td>
        <td><input type="text" name="sort[{@value->id}]" value="{@value->sort}" class="text sort"></td>
    </tr>
    {/foreach}
    {else}
    <tr><td colspan="5">对不起，没有任何数据</td></tr>
    {/if}
    <tr><td colspan="6"><input type="submit" name="send" value="排序"></td></tr>
    <tr><td colspan="5">本子类隶属于：<strong>{$prev_name}</strong>[<a href="nav.php?action=addchild&id={$pid}">继续增加本类</a>][ <a href="{$prev_url}">返回列表</a> ]</td></tr>
</table>
</form>
<div id="page">{$page}</div>

{/if}
{if $addchild}
<form method="post" name="add">
    <input type="hidden" name="pid" value="{$pid}">
    <table cellspacing="0" class="left">
        <tr><td>上级导航：<strong>{$prev_name}</strong></td></tr>
        <tr><td>子导航名称：<input type="text" name="nav_name" class="text" />(*子导航名称为2到20位)</td></tr>
        <tr><td>子导航描述：<textarea name="nav_info" id="" cols="30" rows="10"></textarea>(*子导航描述不得大于200位)</td></tr>
        <tr><td><input type="submit" name="send" value="新增子导航" onclick="return checkForm();"  class="submit" /> [ <a href="{$prev_url}">返回列表</a> ]</td></tr>
    </table>
</form>
{/if}


</body>
</html>