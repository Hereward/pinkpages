<div class="adminDash">
{include file="menu.tpl"}
<div align="center" style="height:50px; padding-top:50px;"><strong>Blogs</strong></div>
<div>
	<table width="100%" align="center" border="0">
		  <tr>
			<td height="300">
				<form id="test" action="{$action}" method="POST">
					<table width="50%" border="0" align="center" id="FormTable">
					  <tr>
						<th colspan="2">Add New Blog</th>
					  </tr>
					  <tr>
						<td align="right">Title</td>
						<td><input class="required" id="field4" type="text" name="Title" value="" /></td>
					  </tr>
					  <tr>
						<td align="right">Description</td>
						<td><textarea name="Description" rows="5" cols="50"></textarea></td>
					  </tr>
					  <tr>
						<td></td>
						<td align="left">
						<input type="submit" name="submit" value="Add" />
						</td>
					  </tr>
					</table>
				</form>
			</td>
		</tr>
	</table>
</div>

</div>
