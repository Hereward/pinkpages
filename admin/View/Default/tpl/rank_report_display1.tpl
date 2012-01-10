<div class="content">
<h3 align="left">Classification :{$classificationName}</h3>
<br />

<form id="test" action="{$action}"  name="rankReport" method="post" >
<table align="center">
	<tr>
		<td colspan="2"><label> Select ok ok Classification: <font color="#FF0000">*</font></label></td>
	</tr>
	
	<tr>
		<td><select name="classification" id="type1">
	                <option value="--Select One--">--Select One--</option>
					 {foreach from=$classifications item=key}			
			              <option id="postcode1" value="{$key.localclassification_id}" {if $classification eq $key.localclassification_name} selected="selected" {/if}>{$key.localclassification_name}
						  </option>
					  {/foreach} 
					</select></td>
					<td><input type="submit" name="submit" value="View Report" class="controlgrey" /></td>
	</tr>
</table>
</form>

{if $smarty.get.action eq 'showRankReport' && $class neq '0'}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="3%" align="left" valign="top">&nbsp;</td>
    <td width="97%" align="center" valign="top"><img src="{$IMAGES_PATH}ranking.gif" alt="" /></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><img src="{$IMAGES_PATH}regions.gif" alt="" /></td>
    <td align="left" valign="top">
<table class="datatable" width="100" border="1" cellpadding="0" cellspacing="0" align="center">
<tr class="odd">
	<td bgcolor="#FFFFFF">&nbsp;</td>
	{foreach from=$ranks item=rank}
	<td align="center" valign="middle" class="head-x-1">{$rank}</td>
	{/foreach}
</tr>
{foreach from=$classificationResult item=row key=classification_name}

<tr class="odd">
	<td align="center" valign="middle" class="head-y-1" >{$classification_name}</td>
	{foreach from=$ranks item=rank}
	<td align="center" valign="middle" class="body" id="type">{$row.$rank}</td>
	{/foreach}
</tr>
{/foreach}
</table>
</td>
  </tr>
</table>
{/if}

</div>
{literal}
<script language="javascript">
function getClientName(val,PATH,Open)
 { 
	var url = PATH+'main.php?do=Admin&action=getClientName&ID='+val;
		  
var myAjax = new Ajax.Request(
	url,
	{
		method: 'get',
		parameters: ''
	//	,onComplete: openDiv
		
    });
}
</script>
{/literal}
