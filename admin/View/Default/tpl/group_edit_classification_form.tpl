<div class="content">
	<div align="center">
		<label><a href="{$edit_genaral}&ID={$smarty.get.ID}">Edit General Details</a> | </label>
		<label><a href="{$edit_classification}&ID={$smarty.get.ID}">Edit Classification</a></label>
	</div>
	
<ul class="textfieldlist"> 
  <li>
     <label>
	<h3 class="h4reversed" align="center">Edit Classification</h3>
     </label>
  </li>
<form name="form1" action="{$action}={$values[0].group_id}" method="post">

<li>
   <label>Select classifications</label>
   <li>
		<select name="classification[]" id="classification[]" multiple="multiple" size="10">
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

<form id="test" action="{$deleteAction}={$values[0].group_id}"  name="delClassificationForm" method="POST" enctype="multipart/form-data" >
<li>
   <label></label>
   
  <li>
   		<table class="datatable" border="0" cellpadding="0" cellspacing="0" align="center">
			<tr>
				<td class="h4reversed">Selected Classifications</td>
				
				<td class="h4reversed">Delete</td>
			</tr>
			
			
    {assign var="j" value=0}
    {foreach from=$classificationListResult item=key}
			  <tr class="{if $j % 2==0}{else}odd{/if}">
				<td>{$key.localclassification_name}</td>
				
				<td><input type="checkbox" name="deleteClass[]" value="{$key.classification_id}" /></td>
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
</ul>

</div>

