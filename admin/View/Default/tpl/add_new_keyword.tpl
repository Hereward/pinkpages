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
		<div class="er-message-success">Business Added Successfully</div><br />
	{elseif $msg eq '2'}
		<div class="er-message-success">Keyword Added Successfully</div><br />
	{elseif $msg eq '3'}
		<div class="er-message-success">Keyword Aeleted Successfully</div><br />  
	{elseif $msg eq '4'}
		<div class="er-message-success">Keyword Added Successfully</div> <br />
	{elseif $msg eq '5'}
		<div class="er-message-success">Service Added Successfully</div> <br />
	{elseif $msg eq '6'}
		<div class="er-message-success">Service Deleted Successfully</div> <br />
	{elseif $msg eq '7'}
		<div class="er-message-success">Brand Added Successfully</div> <br /> 
	{elseif $msg eq '8'}
		<div class="er-message-success">Brand Deleted Successfully</div> <br />		  
	{/if}
	 
<h4 class="h4reversed"><div align="left">Brand and Service</div>
<div align="right">
	<font size="-1">Company Name:<strong>{$values12.business_name|upper}</strong> &nbsp;{if $values12.account_id neq 'NULL'}Account Number:<strong>{$values12.account_id}</strong>{/if}</font>
</div></h4><br />

<br />
<ul class="textfieldlist">

<table class="datatable" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td><strong>Brand</strong></td>
		<td></td>
		<td><strong>Client&rsquo;s Brands</strong></td>
	</tr>
	
	<tr>
	<form id="test" action="{$actionBrand}={$smarty.get.ID}"  name="addClassificationForm" method="POST" enctype="multipart/form-data" >
		<td valign="top"><input type="text" name="addbrand" size="30" /></td>
		<td valign="top"><input type="submit" name="addClass" value="Enter" class="controlgrey"/></td>
	</form>
	<form id="test" action="{$deleteBrandAction}={$smarty.get.ID}"  name="delBrandForm" method="POST" enctype="multipart/form-data" >
		<td>
		<select scrolling="no" name="addbrand[]" id="addbrand[]" multiple="multiple" size="10" style="width:150px;">
		  {foreach from=$businessBrandResult item=key}
			<option value="{$key.brand_id}">{$key.business_brand_name}</option>
		 {/foreach}
		 </td>
	
		 
	</tr>
		<tr>
		<td></td>
		<td></td>
		<td><input type="submit" name="deleteClassification" value="Delete"  class="controlgrey" /></td>
		</form>
	</tr>	
</table>



<li>-----------------------------------------------------------------------------------------------------</li>

<table class="datatable" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td><strong>Service</strong></td>
		<td></td>
		<td><strong>Client&rsquo;s Services</strong></td>
	</tr>
	
	<tr>
<form action="{$actionService}={$smarty.get.ID}" name="addServiceForm" method="POST" enctype="multipart/form-data" >
		<td valign="top"><input type="text" name="service" size="30" /></td>
		<td valign="top"><input type="submit" name="addClass" value="Enter" class="controlgrey"/></td>
	</form>
	<form id="test" action="{$deleteServiceAction}={$smarty.get.ID}"  name="delServiceForm" method="POST" enctype="multipart/form-data" >
		<td >
		<select name="addService[]" id="addService[]"  multiple="multiple" size="10"  style="width:150px;" >
			{foreach from=$businessServiceResult item=key }
				<option value="{$key.service_id}">{$key.business_service_name}</option>
			{/foreach }
		 </td>
	
		 
	</tr >
		<tr >
		<td></td >
		<td></td >
		<td><input type="submit"  name="delete" value="Delete"  class="controlgrey" /></td>
		</form>
	</tr>	
</table>

</li>
</li>


</ul>

</div>
</div>
