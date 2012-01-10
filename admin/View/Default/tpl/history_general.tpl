<div class="content-big">

	<div align="center">
		<label><a href="{$view_history}&ID={$smarty.get.ID}&edit_type=general">General History</a> | </label>
		<label><a href="{$view_classification_history}&ID={$smarty.get.ID}&edit_type=classification">Classification History</a> | </label>
		<label><a href="{$view_rank_history}&ID={$smarty.get.ID}&edit_type=rank">Rank History</a> | </label>
		<label><a href="{$view_key_history}&ID={$smarty.get.ID}&edit_type=keyword">Brands & Services History</a> | </label>
		<label><a href="{$view_operation_day_history}&ID={$smarty.get.ID}&edit_type=hour_payment">Hours & Payment History</a></label>
	
	</div>
	

<h3 align="left">General History</h3>
<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">

		<td class="h4reversed"><b>Change Date and Time</b></td>
		<td class="h4reversed"><b>User Name</b></td>
		<td class="h4reversed"><b>Old Value</b></td>
		<td class="h4reversed"><b>New Value</b></td>
		
      
 		{if $count eq '0'}
	<tr ><td></td><td></td><td>No records found</td></tr>
	{else}


	{assign var="js" value=1}
    {foreach from=$values item=key}
	
     <tr class="odd">
			<td>{$key.time|date_format:"%b %e, %Y %H:%M:%S"}</td>
			<td>{$key.clientName}</td>
			<td class="open" rel="{$js}" name="show"><a id="popupspan" href="#" onmouseover="toolTip('Click to view and close', 150)" onmouseout="toolTip()"><img border="0" src="{$ADMIN_IMAGES_PATH}dot.gif" alt="" />view</a>
				<div id="open{$js}" style="display:none;">				    
					<table class="datatable">
					<tr>
					<td class="h4reversed">Field Name</td>
					<td class="h4reversed">Old Value</td>
					</tr>
					{foreach key=i from=$key.oldValue item=keyOld}
					<tr>
						<td>{$i}</td>
						<td>{$keyOld}</td>
					</tr>
					{/foreach}
					</table>
				
				</div>
			</td>
			
			<td class="openNew" rel="{$js}" name="showNew"><a id="popupspan" href="#" onmouseover="toolTip('Click to view and close', 150)" onmouseout="toolTip()"><img border="0" src="{$ADMIN_IMAGES_PATH}dot.gif" alt="" />view</a>
				<div id="openNew{$js}" style="display:none;">				    
					<table class="datatable">
					<tr>
					<td class="h4reversed">Field Name</td>
					<td class="h4reversed">New Value</td>
					</tr>
					{foreach key=j from=$key.newValue item=keyNew}
					<tr>
						<td>{$j}</td>
						<td>{$keyNew}</td>
					</tr>
					{/foreach}
					</table>
				
				</div>
			</td>
    </tr>

	 {assign var="js" value=$js+1}
    {/foreach}
	{/if}
</table>
<div align="center"> {include file="pagination.tpl"}</div>
</div>


{literal}
<script type="text/javascript">
$j('td.open').click(function() {

	var u = $j(this).attr("name");
	var i = $j(this).attr("rel");

	if(u=="show"){
		$j('div#open'+i).slideDown(500);
		$j(this).attr("name","close");
	}else{
		$j('div#open'+i).slideUp(500);
		$j(this).attr("name","show");
	}
	
});

$j('td.openNew').click(function() {

	var u = $j(this).attr("name");
	var i = $j(this).attr("rel");

	if(u=="showNew"){
		$j('div#openNew'+i).slideDown(500);
		$j(this).attr("name","close");
	}else{
		$j('div#openNew'+i).slideUp(500);
		$j(this).attr("name","showNew");
	}
	
});


</script>
{/literal}
