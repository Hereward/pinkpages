{debug}
<div class="content0left">
<div class="content">

	<div align="center">
		<label><a href="{$edit_url}&ID={$smarty.get.ID}">Edit Details</a> | </label>
		<label><a href="{$edit_classification}&ID={$smarty.get.ID}">Edit Classification</a> | </label>
		<label><a href="{$edit_rank}&ID={$smarty.get.ID}">Edit rank</a> | </label>
		<label><a href="{$add_keyword}&ID={$smarty.get.ID}">Edit Brands & Services</a> | </label>
		<label><a href="{$manageHoursDays}&ID={$smarty.get.ID}">Edit Hours and Payment</a></label>
	</div>
	
{if $msg eq '4'}
 <div class="er-message-success">Rank added successfully</div><br />
 {/if}
 
 
<h4  class="h4reversed"><div align="left">Business Ranks</div>
<div align="right">
	<font size="-1">Company Name:<strong>{$values12.business_name|upper}</strong> &nbsp;{if $values12.account_id neq 'NULL'}Account Number:<strong>{$values12.account_id}</strong>{/if}</font>
</div>
</h4><br />

<div style="margin-left:20px;">
<strong>Currently showing results for {$ranked_state_name}</strong><br/><br/>
<form name="ranked_region" method="post">
  <label>Change State:</label> {html_options onchange="this.form.submit()" name="ranked_region_option" options=$ranked_region_options selected=$ranked_region_selected}
</form>
</div>

<form id="test" action="{$action}={$smarty.get.ID}" name="businessRanks" method="post" >
<ul class="textfieldlist">

	<li>
	<div align="center">{if $countclassification eq 0}<strong>You can not add rank because you do not have any classification</strong>{/if}</div>
<table class="datatable" width="100" border="1" cellpadding="0" cellspacing="0" align="center">

	{section name=i loop=$regionValue}

   <tr class="odd">
		
   
    {section name=j loop=$classificationListResult}
    {assign var="rankArr" value=$classificationListResult[j].localclassification_name}
    
    
        {if $smarty.section.i.index eq 0}
			{if $smarty.section.j.index eq 0}
				<td bgcolor="#FFFFFF"></td>
			{else}
	            <td align="center" valign="center" class="">{$classificationListResult[j].localclassification_name}</td>
			{/if}
        {else}
            {if $smarty.section.j.index eq 0}
                <td align="left" valign="left" class="" >{$regionValue[i].shirename_shirename}</td>
        	{else}
		 <td align="center" valign="middle" class="body" id="type">
		 			<select name="{$regionValue[i].shirename_id}_{$classificationListResult[j].localclassification_id}">
					<option value="">--</option>
					 {foreach key=key item=item from=$ranks}
						{assign var="js" value=0}
						 {foreach item=item1 from=$rankResult}
						 	
						 	{if $regionValue[i].shirename_id eq $item1.shirename_id AND $classificationListResult[j].localclassification_id eq $item1.localclassification_id AND $item1.businessrank_rank eq $key}
								<option value="{$key}" selected="selected">{$item}</option>
								{assign var="js" value=1}
							
							{/if}
						{/foreach}
							{if $js eq 0}
								{foreach from=$bRankArr item=or}
									{assign var="sj" value=0}
									{if $or.localclassification_id eq $classificationListResult[j].localclassification_id && $or.businessrank_rank eq $key && $or.shirename_id eq $regionValue[i].shirename_id}
										<option value="{$key}">*</option>
									{assign var="sj" value=1}
									{php}break;{/php}
									{/if}
								{/foreach}
								{if $sj eq 0}
									<option value="{$key}">{$item}</option>
								{/if}
							
							{/if}
					{/foreach}
					</select>
		 </td>

            {/if}
        {/if}
    {/section}
  </tr>
  
  
{/section}
	<table class="datatable" width="100" border="1" cellpadding="0" cellspacing="0" align="center">
	<h4  class="h4reversed"><div align="left">Add Words</div>
		<tr>
			<td>Line 1</td>
			<td><input type="text" name="line1" size="50" value="{$addword1}" /></td>
		</tr>
		<tr>
			<td>Line 2</td>
			<td><input type="text" name="line2" size="50" value="{$addword2}" /></td>			
		</tr>
	</table>
</table>
	</li>
	
	<!--<li>
	   <label>Options</label>
	   
	   <li>
	   
	   <label><strong><a href="{$add_card}={$smarty.get.ID}">Add Card Details</a></strong></label>
	   </li>

</li>-->

</ul>
<br />
<ul class="controlbar">
<div align="center">
<input type="submit" name="submit" value="Update Ranks" class="controlgrey" />
</div>
</ul>
</form>


</div>
</div>

