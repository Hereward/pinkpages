<div class="content">
<h3 align="left">Business Listings</h3><br>
<form method="GET" action="main.php" name="expForm">
<input type="hidden" name="do" value="Listing">
<input type="hidden" name="action" value="expiredBusiness">

<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr >
		<td>
			<select name="searchType">
				<option value="expired" {if $searchType eq 'expired'}selected{/if}>Expired</option>
				<option value="willExpired" {if $searchType eq 'willExpired'}selected{/if}>About to Expired</option>
			</select>
		</td>
		<td>Days: <input type="text" name="days" value="{$days}"></td>
		<td><input type="submit" class="controlgrey" name="submit" value="Submit"></td>
	</tr>
	
	<tr >
		<td colspan="3">
		{if $searchType eq 'willExpired'}
			After <b>{$days}</b> days these business will be expired</td>
		{else}
			Expired businesses
		{/if}
	</tr>
	
	<tr>
		<td class="h4reversed"><b>Business ID</b></td>
		<td class="h4reversed"><b>Name</b></td>
		<td class="h4reversed"><b>Suburb</b></td>
		{if $searchType neq 'willExpired'}
			<td class="h4reversed"><b>Action</b></td>
		{/if}
	</tr>
 	{if $count eq '0'}
	<tr >
		<td colspan="3" align="center">No records found</td>
	</tr>
	{else}

    {assign var="j" value=0}
    {foreach from=$values item=key}
	
     <tr class="{if $j % 2==0}{else}odd{/if}">
			<td>{$key.business_id}</td>
			<td>{$key.business_name}</td>
			<td>{$key.business_suburb}</td>
			{if $searchType neq 'willExpired'}
			<td><a href="{$activateBus}&ID={$key.business_id}">Activate?</a></td>
			{/if}
    </tr>
	 {assign var="j" value=$j+1}
    {/foreach}
	{/if}
</table>
</form>
<div align="center"> {include file="pagination.tpl"}</div>
</div>
{literal}
<script language="javascript">
// Delete Confirmation
function del(val)
{
	var answer = confirm  ("Are you sure,you want to delete?");
	if (answer)
	window.location.href=val;
	else
	{;}

}
</script>
{/literal}
