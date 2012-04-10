<div class="content0left">
<div class="content">

  <div align="center">
		<label><a href="{$edit_url}&ID={$smarty.get.ID}">Edit Details</a> | </label>
		<label><a href="{$edit_classification}&ID={$smarty.get.ID}">Edit Classification</a> | </label>
		<label><a href="{$edit_rank}&ID={$smarty.get.ID}">Edit rank</a>|</label>
		<label><a href="{$add_keyword}&ID={$smarty.get.ID}">Edit keyword</a></label>
	</div>
	
{if $msg eq '4'}
 <div class="er-message-success">Rank added successfully</div><br />
 {/if}
 
 
<h3 align="left">Business Ranks</h3><br />
<div>
Currently showing results for $ranked_state_name <br/>
<form name="ranked_region" method="post">

  {html_options name="ranked_region_options" options=$ranked_region_options selected=$ranked_region_selected}
  
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
							<option value="{$key}">{$item}</option>
							{/if}
					{/foreach}
					</select>
		 </td>

            {/if}
        {/if}
    {/section}
  </tr>
{/section}
</table>


	</li>
</ul>
<br />
<ul class="controlbar">
<div align="center">
<input type="reset" name="reset" value="Reset" class="controlgrey" />
<input type="submit" name="submit" value="Update Ranks" class="controlgrey" />
</div>
</ul>
</form>
</div>

