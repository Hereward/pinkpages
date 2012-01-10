<div class="content">
<h3 align="left">Business Listings</h3>
<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">

		<td class="h4reversed"><b>Business ID</b></td>
		<td class="h4reversed"><b>Name</b></td>
		<td class="h4reversed"><b>Suburb</b></td>
		<td class="h4reversed"><b>Details</b></td>
		<td class="h4reversed"><b>Classifications</b></td>
		<!--<td class="h4reversed"><b>Rank</b></td> -->
		<td class="h4reversed"><b>Action</b></td>
      
 

    {assign var="j" value=0}
    {foreach from=$values item=key}
	{if $key.rank neq 0 &&  $key.rank lte 5 }
     <tr class="{if $j % 2==0}{else}odd{/if}">
			<td>{$key.business_id}</b></td>
			<td>{$key.business_name}</b></td>
			<td>{$key.business_suburb}</b></td>
			<td><a href="{$edit_url}&ID={$key.business_id}" ><b>edit</b></a></td>
			<td><a href="{$edit_classification}&ID={$key.business_id}" ><b>edit</b></a></td>
			<!--<td><a href="{$edit_rank}&ID={$key.business_id}" ><b>Rank</b></a></td> -->
			<td><a href="{$delete}={$key.business_id}"><b>delete</b></a></td>     
	{elseif $key.rank eq 1000}
	  <tr class="{if $j % 2==0}{else}odd{/if}">		
			 <td>{$key.business_id}</td>
			<td>{$key.business_name}</b></td>
			<td>{$key.business_suburb}</b></td>
			<td><a href="{$edit_url}&ID={$key.business_id}" ><b>edit</a></b></td>
			<td><a href="{$edit_classification}&ID={$key.business_id}" ><b>edit</a></b></td>
			<!--<td><a href="{$edit_rank}&ID={$key.business_id}" ><b>Rank</a></b></td> -->
			<td><a href="{$delete}={$key.business_id}"><b>delete</a></b></td> 
	{else}
	    <tr class="{if $j % 2==0}{else}odd{/if}">		
			 <td>{$key.business_id}</td>
			<td>{$key.business_name}</td>
			<td>{$key.business_suburb}</td>
			<td><a href="{$edit_url}&ID={$key.business_id}" ><b>edit</b></a></td>
			<td><a href="{$edit_classification}&ID={$key.business_id}" ><b>edit</b></a></td>
			<!--<td><a href="{$edit_rank}&ID={$key.business_id}" ><b>Rank</b></a></td> -->
			<td><a href="{$delete}={$key.business_id}"><b>delete</b></a></td> 		
			
    </tr>{/if}
	 {assign var="j" value=$j+1}
    {/foreach}
</table>
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









<!--<div class="content">
<h3 align="left">Business Listings</h3>
<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">

      
        <td class="h4reversed"><b>Name</b></td>
        <td class="h4reversed"><b>Suburb</b></td>
      
        <td class="h4reversed"><b>Phone Std</b></td>
        <td class="h4reversed"><b>Phone</b></td>
		<td class="h4reversed"><b>Rank</b></td>
        <td class="h4reversed"><b>Action</b></td>
      
 

    {assign var="j" value=0}	
    {foreach from=$values item=key}
	
	
	{if $key.rank neq 0 &&  $key.rank lte 5 }
     <tr class="{if $j % 2==0}{else}odd{/if}">
       <td><font color="#006600"><b>{$key.business_name}</b></font></td>
       <td><font color="#006600"><b>{$key.business_suburb}</b></font></td>
       <td><font color="#006600"><b>{$key.business_phonestd}</b></font></td>
       <td><font color="#006600"><b>{$key.business_phone}</b></font></td>
       <td><font color="#006600"><b>{$key.rank}</b></font></td>
	{elseif $key.rank eq 1000}
	  <tr class="{if $j % 2==0}{else}odd{/if}">
       <td>{$key.business_name}</td>
       <td>{$key.business_suburb}</td>
       <td>{$key.business_phonestd}</td>
       <td>{$key.business_phone}</b></td>
	   <td></td>
	{else}	 
	  <tr class="{if $j % 2==0}{else}odd{/if}">
       <td>{$key.business_name}</td>
       <td>{$key.business_suburb}</td>
       <td>{$key.business_phonestd}</td>
       <td>{$key.business_phone}</b></td>
	   <td>{$key.rank}</td>
		 
     {/if}
	 
        <td><a href="{$edit_url}&ID={$key.business_id}" ><font color="#CC3399"><b>Edit</b></a>/<a href="#" onmousedown="del('{$delete}={$key.business_id}')"><font color="#CC3399"><b>Delete</b></font></a></td>

      

      
   
	 {assign var="j" value=$j+1}
    {/foreach}
	 </tr>
	
	{if $Count eq 0}
	<tr><td colspan="5" align="center"><strong>No Records found</strong></td></tr>
	{/if}
	
</table>
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
{/literal} -->
