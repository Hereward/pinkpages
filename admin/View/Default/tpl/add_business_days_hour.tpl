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
		<div class="er-message-success">Hour Added Successfully</div><br />
	{elseif $msg eq '2'}
		<div class="er-message-success">Payment Added Successfully</div><br />
	{elseif $msg eq '3'}
		<div class="er-message-success">Hour Deleted Successfully</div><br />  
	{elseif $msg eq '4'}
		<div class="er-message-success">Payment Deleted Successfully</div> <br />	
	{/if}
	
<h4 class="h4reversed"><div align="left">Hour and Payment</div>
<div align="right">
	<font size="-1">Company Name:<strong>{$values12.business_name|upper}</strong> &nbsp;{if $values12.account_id neq 'NULL'}Account Number:<strong>{$values12.account_id}</strong>{/if}</font>
</div>
</h4><br />

<ul class="textfieldlist">
<form id="test" action="{$action}={$smarty.get.ID}"  name="addClassificationForm" method="POST" enctype="multipart/form-data" >

<li>
   <label>Add Hour</label>
   <li>
		<select name="addhour[]" id="addhour[]" multiple="multiple" size="5">
		{foreach from=$businessHour item=key}
		<option value="{$key.hour_id}-{$key.hour_name}">{$key.hour_name}</option>
		 {/foreach}
		 </select>
	</li>
</li>

<li>    
   	<input type="submit" name="addClass" value="Add Hour"  />
</li>
</form>

<form id="test" action="{$deleteHour}={$smarty.get.ID}"  name="delClassificationForm" method="POST" enctype="multipart/form-data" >
<li>
   <label>Delete Hour</label>
   
  <li>
   		<table class="datatable" border="0" cellpadding="0" cellspacing="0" align="center">
			<tr>
				<td class="h4reversed">Hours</td>
				
				<td class="h4reversed">Delete</td>
			</tr>
			
			
    {assign var="j" value=0}
    {foreach from=$businessHourResult item=key}
			  <tr class="{if $j % 2==0}{else}odd{/if}">
				<td>{$key.hour_name}</td>
				
				<td><input type="checkbox" name="deleteHour[]" value="{$key.hour_id}" /></td>
			</tr>
	{assign var="j" value=$j+1}
	{/foreach}
		
		</table>
</li>

<li>    
   	<input type="submit" name="deleteClassification" value="Delete Hour" />
</li>
</form>


<li>-----------------------------------------------------------------------------------------------------</li>

<form action="{$actionPayment}={$smarty.get.ID}" name="addServiceForm" method="POST" enctype="multipart/form-data" >

<li>
	<label>Add Payment</label>
</li>
   <li>
		<select name="payment[]" id="payment[]" multiple="multiple" size="5">
		{foreach from=$businessDays item=key}
		<option value="{$key.payment_id}-{$key.payment_name}">{$key.payment_name}</option>
		 {/foreach}
		 </select>
	</li>
	
	<li>    
   		<input type="submit" name="addClass" value="Add Payment"  />
	</li>
</form>

<form id="test" action="{$deletePayment}={$smarty.get.ID}"  name="delServiceForm" method="POST" enctype="multipart/form-data" >
<li>
   <label>Delete Payment</label>
   
  <li>
   		<table class="datatable" border="0" cellpadding="0" cellspacing="0" align="center">
			<tr>
				<td class="h4reversed">Payment</td>
				
				<td class="h4reversed">Delete</td>
			</tr>
			
			
    {assign var="j" value=0}
    {foreach from=$businessPaymentResult item=key}
			  <tr class="{if $j % 2==0}{else}odd{/if}">
				<td>{$key.payment_name}</td>
				
				<td><input type="checkbox" name="deletePayment[]" value="{$key.payment_id}" /></td>
			</tr>
	{assign var="j" value=$j+1}
	{/foreach}
		
		</table>
</li>

<li>    
   	<input type="submit" name="delete" value="Delete Payment" />
</li>
</form>



</li>
</li>


</ul>
</div>
</div>

{literal}
<script language="javascript">
function CheckAll(chk)
    {
    for (var i=0;i < document.addWorkHourForm.elements.length;i++)
        {
            var e = document.addWorkHourForm.elements[i];
            if (e.type == "checkbox")
            {
                e.checked = chk.checked;
            }
        }
    }
</script>
{/literal}
