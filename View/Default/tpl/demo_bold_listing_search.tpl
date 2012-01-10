<div class="content-big">
<div class="maptop">
<img src="{$IMAGES_PATH}smalllogo.gif" alt="Pink Pages Logo" />
</div>
	<table class="datatable">
   <tfoot class="quotetfoot">
	 <tr>
		<td colspan="3" class="shadowrule"></td>
	 </tr>
   </tfoot>
   <tbody>
	<tr class="">
	   <td class="task">		
          <table width="95%" border="0" cellpadding="0" cellspacing="0">
		  {section name=i loop=$values}
		   <tr >
			{if $values[i].bold_listing eq 1}
			<td><strong><u>{$values[i].business_name}</u></strong></td>
			{else}
			<td><strong>{$values[i].business_name}</strong></td>
			{/if}

		 </tr>
		</table><br />
	<table border="0" cellpadding="0" cellspacing="0">
	 <tr><td><strong>Address</strong></td></tr>
	 <tr>
	  <td>
		<label>&nbsp;&nbsp;
		{if  $values[i].street1_status eq '1'}
		{else}<b>Street 1:</b>
		 {$values[i].business_street1}
	 	{/if}
		</label>
	  </td>		
	  <td>
		<label>&nbsp;&nbsp;
		{if  $values[i].street2_status eq '1'}
	  	{else}<b>Street 2:</b>
		{$values[i].business_street2}
		{/if}
		</label>
	  </td>
	
	</tr>
	<tr>
	 <td>
	   <label>&nbsp;&nbsp;&nbsp;<b>Suburb:</b>{if $values[i].business_suburb eq ''}{else}{$values[i].business_suburb}{/if}</label>
	 </td>
	  <td>
	   <label>&nbsp;&nbsp;&nbsp;<b>State:</b>{if $values[i].business_state eq ''}{else}{$values[i].business_state}{/if}</label>
	 </td>
	 <td>
	  <label>&nbsp;&nbsp;&nbsp;<b>Postcode:</b>{if $values[i].business_postcode eq ''}{else}{$values[i].business_postcode}{/if}</label>
	 </td>
	</tr>
	</table>	<br />
	<table border="0" cellpadding="0" cellspacing="0">
	  <tr><td><strong>Contact</strong></td></tr>
	  
	  {if $values[i].business_mobile neq ''}
			<tr>
			<td><label>Mobile</label></td>
			<td>{$values[i].business_mobile}</label></td>
			</tr>			
			{/if}
			
			{if $values[i].business_phone neq ''}
			<tr>
			<td><label>Phone</label></td>
			<td>{$values[i].business_phone}</label></td>
			</tr>
			{/if}
	  <tr>
			{if $values[i].business_fax eq ''}
			{else}
			<td><label>Fax</label></td>
			<td><label>{$values[i].business_fax}</label></td>
			{/if}
			</tr>
	</table><br />
	<table border="0" cellpadding="0" cellspacing="0">
	 {if $values[i].business_description neq ''}
	 <tr>
	  <td><strong>Business Description</strong></td>
	 </tr>
	 <tr>
	  <td colspan="180">
		{$values[i].business_description}
	  </td>
 	</tr>
	{/if}
	</table><br />
	<table border="0" cellpadding="0" cellspacing="0">
	 {if $values[i].business_email neq ''}
		<tr>
		 <td><a href="{$contactUs}={$values[i].business_email}&act={$smarty.get.action}&businessID={$smarty.get.ID}">Contact Us</a></td><br />
		</tr>
	{/if}
	</table><br />
	<table border="0" cellpadding="0" cellspacing="0">
	 <tr>
			{if $values[i].business_url eq '' OR 'http://'}
			{else}
			<td><label>Web</label></td>
			<td><label><a href="{$values[i].business_url}">{$values[i].business_url}</a></label></td>
			{/if}
	</tr>
	</table><br />
	<table border="0" cellpadding="0" cellspacing="0">
	  {if $values[i].business_logo eq ''}
			{else}
		    <tr><td><strong>Logo</strong></td></tr>
			<tr>
			
			<td><label>
			    <img src="{$IMAGES_PATH}DemoListing/{$values[i].business_logo}" width="100" height="100" /></label></td>
			</tr>
			{/if}
	</table>	
	{/section}
	</td>
	</tr>
	</tbody>
  </table>	
  
  
   <div class="mapbottom">
   <table align="center" width="90%">
        <tr>
            <td class="googlemapword" width="50%" align="left">
                <b> <a href="javascript:window.close()">Close Window</a></b>
					</td>
					 <td class="googlemapword" width="50%" align="right">
					 <b> <a href="javascript:window.print()">Print this page</a></b>
					</td>
					 </tr>
					 </table>
</div>
			
  </div>