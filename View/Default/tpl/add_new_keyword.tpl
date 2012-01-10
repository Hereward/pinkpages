<div class="content0left">
<div class="content">

	<div align="center">
		<label><a href="{$edit_url}&ID={$smarty.get.ID}">Edit Details</a> | </label>
		<label><a href="{$edit_classification}&ID={$smarty.get.ID}">Edit Classification</a> | </label>
		<!--<label><a href="{$edit_rank}&ID={$smarty.get.ID}">Edit rank</a> | </label> -->
		<label><a href="{$add_keyword}&ID={$smarty.get.ID}">Edit keyword</a></label>
	</div>
	
{if $msg eq '1'}
  <div class="er-message-success">Business added successfully</div><br />
{elseif $msg eq '2'}
  <div class="er-message-success">Keyword added successfully</div><br />
 {elseif $msg eq '3'}
  <div class="er-message-success">Keyword deleted successfully</div><br />  
  {elseif $msg eq '4'}
   <div class="er-message-success">Keyword added successfully</div> <br />
{/if} 
<h4 class="h4reversed" align="Left">Keyword</h4><br />

<br />
<ul class="textfieldlist">
<form id="test" action="{$action}={$smarty.get.ID}"  name="addClassificationForm" method="POST" enctype="multipart/form-data" >

<li>
   <label>Add</label>
   <li>
		<select name="addclassification[]" id="addclassification[]" multiple="multiple" size="10">
		{foreach from=$keywordList item=key}
		<option value="{$key.keyword_name}">{$key.keyword_name}</option>
		 {/foreach}
		 </select>
	</li>
</li>

<li>    
   	<input type="submit" name="addClass" value="Add Keyword"  />
</li>
</form>

<form id="test" action="{$deleteAction}={$smarty.get.ID}"  name="delClassificationForm" method="POST" enctype="multipart/form-data" >
<li>
   <label>Delete</label>
   
  <li>
   		<table class="datatable" border="0" cellpadding="0" cellspacing="0" align="center">
			<tr>
				<td class="h4reversed">Keyword</td>
				
				<td class="h4reversed">Delete</td>
			</tr>
			
			
    {assign var="j" value=0}
    {foreach from=$keyResult item=key}
			  <tr class="{if $j % 2==0}{else}odd{/if}">
				<td>{$key.business_key_name}</td>
				
				<td><input type="checkbox" name="deleteClass[]" value="{$key.key_id}" /></td>
			</tr>
	{assign var="j" value=$j+1}
	{/foreach}
		
		</table>
  </li>
</li>


<li>    
   	<input type="submit" name="deleteClassification" value="Delete Keyword" />
</li>	

</form>


</li>


</ul>

</div>
</div>
