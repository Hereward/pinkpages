<div class="">
<h3 align="left">Classification :{$classificationName}</h3>
<br />

{if $smarty.get.action eq 'showRankReport' && $class neq '0'}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="3%" align="left" valign="top">&nbsp;</td>
    <td width="97%" align="center" valign="top"><img src="{$IMAGES_PATH}{$headerImg}" alt="" /></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><img src="{$IMAGES_PATH}rankings.jpg" alt="" /></td>
    <td align="left" valign="top">
<table class="datatable" id="xytble" onmouseover="mouse_event_handler;" width="100" border="1" cellpadding="0" cellspacing="0" align="center">

	<tr class="odd">
		<td bgcolor="#FFFFFF">&nbsp;</td>
		{foreach from=$classificationResult item=row key=classification_name}	
		<td align="center" valign="middle" class="regions" >{$classification_name|substr:3:4}</td>
	{/foreach}
	
	</tr>
	{foreach from=$ranks item=rank}
	<tr>
		{if $rank}
		  {if $rank == 11}
		    <td align="center" valign="middle" class="rankings"><strong>11+ #</strong></td>
		  {else} <td align="center" valign="middle" class="rankings">{$rank}</td>
		  {/if}
		{else}
		<td align="center" valign="middle" class="rankings">&nbsp;</td>
		{/if}
		{foreach from=$classificationResult item=row key=classification_name}
		{if $row.$rank}
		<td align="center" valign="middle">{$row.$rank}</td>	
		{else}
		<td align="center" valign="middle">&nbsp;</td>	
		{/if}
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

	  <style type="text/css">
	  	table {border-spacing:0;font-size: 95%;}
	  	.hlt-col {
	  		background-color: none;
	  		color: black;
	  	}
	  	.hlt .hlt-col {
	  		border: 1px ridge red;
	  		background-color: red;
	  		color: #fff;
	  	}
	  	.hlt td {
	  		background-color: white;
	  		color: #000;
	  		font-weight: bold;
	  	}
	  	.hlt {
	  		background-color: black;
	  		color: #ff0;
	  	}
				
        .regions {            
            color:#999999;
            font-size:12px;
            font-weight:bold;
        }		
		
</style>	  
{/literal}
