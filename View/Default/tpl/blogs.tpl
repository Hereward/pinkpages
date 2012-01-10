<div class="adminDash">
{include file="menu.tpl"}
<div align="center" style="height:50px; padding-top:50px;"><strong>Blogs</strong></div>
<div>
	<table width="70%" border="0" align="center"  id="FormTable">
		<tr align="left">
			<th scope="col">S.N.</th>
			<th scope="col">Blog Title</th>
			<th scope="col">Description</th>
			<th scope="col">Insert Date</th>
			<th scope="col"></th>
		</tr>
		{foreach from=$blogArray item=blog}
        <tr>
    		<td></td>
    		<td>{$blog.title}</td>
    		<td>{$blog.description}</td>
    		<td>{$blog.entedate}</td>
    		<td><a href="{$blog.blog_del_url}">Delete</a></td>
    	</tr>
        {/foreach}
        <tr>
			<td colspan="2"><a href="{$blog_add_url}">Add New Blog</a></td>
			<td colspan="2">{include file="pagination.tpl"}</td>
		</tr>
	</table>
</div>

</div>
