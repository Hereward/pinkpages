<div {if ($affiliate_id neq '' OR $client_id neq '') AND ($action eq 'searchKeyword' or $smarty.get.action eq 'demoListing' or $smarty.get.action eq 'demoBoldListing')}{else}class="navigation"{/if}>
<ul class="navbar">
	{if $affiliate_id eq '' AND $action neq 'searchKeyword' and $smarty.get.action neq 'demoListing'  and $smarty.get.action neq 'demoBoldListing'}
    <li><img src="{$IMAGES_PATH}icon-add4.gif" /><a href="{$edit}"><b>Edit Profile</b></a></li>
    <li><img src="{$IMAGES_PATH}icon-add1.gif" /><a href="{$listing}"><b>Add Business Listing</b></a></li>
	<li><img src="{$IMAGES_PATH}icon-view1.gif" /><a href="{$viewlisting}"><b>View Listing</b></a></li>
	<li><img src="{$IMAGES_PATH}icon-add4.gif" /><a href="{$change_password}"><b>Change Password</b></a></li>
	<li><img src="{$IMAGES_PATH}icon-logout.gif" /><a href="{$logout_url}"><b>Logout<b></a></li>
	{elseif $client_id eq ''  AND $action neq 'searchKeyword' and $smarty.get.action neq 'demoListing' and $smarty.get.action neq 'demoBoldListing'}
	<li><img src="{$IMAGES_PATH}icon-home.gif" /><a href="{$home}"><b>Home</b></a></li>
	<li><img src="{$IMAGES_PATH}icon-add1.gif" /><a href="{$edit_url}"><b>Edit Profile</b></a></li>
	<li><img src="{$IMAGES_PATH}icon_search_16.png" /><a href="{$view_banner}"><b>View Banner</b></a></li>
	<li><img src="{$IMAGES_PATH}icon-view1.gif" /><a href="{$affiliate_rep}"><b>Report</b></a></li>
	<li><img src="{$IMAGES_PATH}icon-add4.gif" /><a href="{$change_password}"><b>Change Password</b></a></li>
	<li><img src="{$IMAGES_PATH}icon-logout.gif" /><a href="{$logout_url}"><b>Logout<b></a></li>
	{else if $client_id neq '' AND $action eq 'searchKeyword' and $smarty.get.action neq 'demoListing' and $smarty.get.action neq 'demoBoldListing'}
	
	{/if}
</ul>
</div>
