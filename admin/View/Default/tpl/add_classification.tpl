<div class="content0left">
<div class="content">

	<div align="center">
		<label><a href="{$edit_url}&ID={$smarty.get.ID}">Edit Details</a> | </label>
		<label><a href="{$edit_classification}&ID={$smarty.get.ID}">Edit Classification</a> | </label>
		<label><a href="{$edit_rank}&ID={$smarty.get.ID}">Edit rank</a> | </label>
		<label><a href="{$add_keyword}&ID={$smarty.get.ID}">Edit Brands & Services</a> | </label>
		<label><a href="{$manageHoursDays}&ID={$smarty.get.ID}">Edit Hours and Payment</a></label>
	</div>
	
{if $msg eq '1'}
  <div class="er-message-success">Business added successfully</div><br />
{elseif $msg eq '2'}
  <div class="er-message-success">Classification added successfully</div><br />
 {elseif $msg eq '3'}
  <div class="er-message-success">Classification deleted successfully</div><br />  
  {elseif $msg eq '4'}
   <div class="er-message-success">Classification added successfully</div> <br />
{/if} 
<h4 class="h4reversed">
<div align="left">Classifications</div>
<div align="right">
	<font size="-1">Company Name:<strong>{$values12.business_name|upper}</strong> &nbsp;{if $values12.account_id neq 'NULL'}Account Number:<strong>{$values12.account_id}</strong>{/if}</font>
</div></h4><br />

<br />
<ul class="textfieldlist">
<form id="test" action="{$action}={$smarty.get.ID}"  name="addClassificationForm" method="POST" enctype="multipart/form-data" >

<li>
   <label>Add</label>
   <li>
		<select name="addclassification[]" id="addclassification[]" multiple="multiple" size="10">
		{foreach from=$classificationList item=key}
		<option value="{$key.localclassification_id}">{$key.localclassification_name}</option>
		 {/foreach}
		 </select>
	</li>
</li>

<li>    
   	<input type="submit" name="addClass" value="Add Classifications"  />
</li>
</form>

<form id="test" action="{$deleteAction}={$smarty.get.ID}"  name="delClassificationForm" method="POST" enctype="multipart/form-data" >
<li>
   <label>Delete</label>
   
  <li>
   		<table class="datatable" border="0" cellpadding="0" cellspacing="0" align="center">
			<tr>
				<td class="h4reversed">Classification</td>
				
				<td class="h4reversed">Delete</td>
			</tr>
			
			
    {assign var="j" value=0}
    {foreach from=$classificationListResult item=key}
			  <tr class="{if $j % 2==0}{else}odd{/if}">
				<td>{$key.localclassification_name}</td>
				
				<td><input type="checkbox" name="deleteClass[]" value="{$key.localclassification_id}" /></td>
			</tr>
	{assign var="j" value=$j+1}
	{/foreach}
		
		</table>
  </li>
</li>


<li>    
   	<input type="submit" name="deleteClassification" value="Delete Classifications" />
</li>	

</form>

<li>
	   <label>Options</label>
	   
	   <li>
	   
	   <label><strong><a href="{$businessRank}={$smarty.get.ID}">Rank this Business</a></strong></label>
	   </li>

</li>


</ul>

</div>
</div>
