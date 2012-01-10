<div class="content-big">

<h3 align="left">Business Details</h3>
<br />
{if $showClientBusinessInfo }
{foreach from=$showClientBusinessInfo item=business}
<table class="datatable">
	 
	<tr>
		<td><label>Business Name</label></td>
		<td>: <a href="http://{$domain}/{$business.url_alias}/{$business.business_id}/listing" target="_blank">{$business.business_name}</a></td> 
	</tr>
			
	<tr>
		<td><label>Account Number</label></td>
		<td>: {$business.account_id}</td>
	</tr>
	
	<tr>
	  <td><label>Phone Number</label></td>
	  <td>: {$business.business_phone}</td>
	</tr>

	<tr>
		<td><label>Street1 Address</label></td>
		<td>: {$business.business_street1}</td>
	</tr>
	<tr>
		<td><label>Street2 Address</label></td>
		<td>: {$business.business_street2}</td>
	</tr>
	<tr>
		<td><label>Suburb</label></td>
		<td>: {$business.business_suburb}</td>
	</tr>
	<tr>
		<td><label>State</label></td>
		<td>: {$business.business_state}</td>
	</tr>
	<tr>
		<td><label>Postcode</label></td>
		<td>: {$business.business_postcode}</td>
	</tr>					
	<tr>
		<td colspan="2">
			<table class="datatable">
				<tr>
					<td class="h4reversed" width="35%">Classification</td>
					<td class="h4reversed" width="30%">Region</td>
					<td class="h4reversed">Rank</td>
					<td class="h4reversed">Banner Details</td>					
				</tr>
				{foreach from=$business.classifications item=keyClass}
				<tr class="{cycle values='odd,'}">
				<td>
					<table>
						<tr>
							<td><font size="1">{$keyClass.localclassification_name}[{$keyClass.view_count}]</font></td>
						</tr>
					</table>
				</td>

				<td>
					<table>
					{if $keyClass.rank}
						{foreach from=$keyClass.rank item=keyRank}
						
						<tr>					
							<td><font size="1">{$keyRank.shirename_shirename}</font></td>
						</tr>
						{/foreach}
					{else}
					<tr>					
						<td>--</td>
					</tr>
					{/if}
					</table>
					
				</td>

				<td>
					<table>
					{if $keyClass.rank}
						{foreach from=$keyClass.rank item=keyRank}
						<tr>					
							<td><font size="1">{if $keyRank.businessrank_rank eq 9999}11+{else}{$keyRank.businessrank_rank}{/if}</font></td>
						</tr>
						{/foreach}
					{else}
					<tr>					
						<td>--</td>
					</tr>
					{/if}
					</table>
				</td>						
				
				<td>
					<table>
					{if $keyClass.market_name}						
						<tr>					
							<td align="center" colspan="2"><font size="1"><strong>Market Name -</strong>{$keyClass.market_name}</font></td>
						</tr>
						<tr>
 							<td><font size="1"><strong>From Date</strong> {$keyClass.add_date}</font></td>							
							<td><font size="1"><strong>Expiry Date</strong> {$keyClass.expiry_date}</font></td>							
						</tr>
						<tr>
						  <td align="center" colspan="2">
						    <img src="{$BANNER_PATH}{$keyClass.banner_name}" />
						  </td>
						</tr>
					{else}
					<tr>					
						<td>--</td>
					</tr>
					{/if}
					</table>
				</td>										
					
				</tr>
				{/foreach}			
			</table>
		</td>
	</tr>	
</table>
{/foreach}
{else}
<table class="datatable">
	<tr>
		<td>No business added</td>
	</tr>
</table>
{/if}
</div>