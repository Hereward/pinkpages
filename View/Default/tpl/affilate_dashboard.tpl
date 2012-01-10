<div class="contentmain">
  
  	{if $msg eq '1'}
		<div class="er-message">
			<div class="er-image"><img src="{$IMAGES_PATH}alert.png" alt="" /></div>
			<div class="er-content">
				<ul>
					<li>Profile Edit Successfully</li>
				</ul>
			</div>
		</div>
	{/if}
	
	<h1 title="Business Dashboard"><span><img src="{$IMAGES_PATH}arrow1.gif" alt="" />Affiliate Dashboard</span></h1>
    <div class="items" >

	   <a href="{$edit_url}">

			<p>
				<img src="{$IMAGES_PATH}ad1.gif" />
				<span>Edit Profile</span>
			</p>
		</a>
		
			   <a href="{$affiliate_rep}">

			<p>
				<img src="{$IMAGES_PATH}ad12.gif" />
				<span>Reports</span>
			</p>
		</a>
		
			   <a href="{$view_banner}">

			<p>
				<img src="{$IMAGES_PATH}ad10.gif" />
				<span>View Banner</span>
			</p>
		</a>
		
		</div>
		
		

		<!--<table class="datatable" width="100%" cellpadding="10">
			<tr class="odd" align="center">
				<td align="center"><a href="{$edit_url}"><img src="{$IMAGES_PATH}u7.jpg" alt="" width="140" height="118" border="0" /></a>
				</td>
			<tr>
				<td align="center">Edit Profile </td> 
			</tr>
			</tr>
		
			<tr class="odd">
				<td align="center"><a href="{$affiliate_rep}"><img src="{$IMAGES_PATH}u8.jpg" alt="" width="145" height="118" border="0" /></a></td>
			<tr>
				<td align="center">Reports</td> 
			</tr>
			</tr>
		</table>
		</ul>-->
</div>

