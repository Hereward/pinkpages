{include file="header_inner_map.tpl"}
<div class="map-sperater">
  <table align="center" width="98%">
    <tr>
      <td class="googlemapword" width="50%" align="left">
        <b> <a href="javascript:window.print()">Print this page</a></b>
	  </td>

<form id="test" action="/main.php" name="Homepage" method="get" onsubmit="return check_inner();">
	<input type="hidden" id="testid" value="" disabled="disabled" />
	<input type="hidden" id="do" name="do" value="Listing" />
	<input type="hidden" id="action" name="action" value="searchKeyword" />
	<input type="hidden" name="SearchOption" id="SearchOption" type="radio" value="0" checked="checked" /> 		
	
    <td class="search-header" width="50%" align="right">
	  <input type="text" name="Search1" id="Search1" value="{$classi|stripslashes}" class="smallinputbox"/>
      in
      <input type="text" name="Search2" id="Search2" value="{$location|stripslashes}" class="smallinputbox" />		  	 
    </td>	
	<td class="search-header">
      <input hspace="10" type="image" value="Search" id="Submit" name="Submit" src="{$IMAGES_PATH}button.png">	  	
	</td>
	
</form>
	 	  	  	 
    </tr>

  </table>
</div>

{section name=i loop=$values}

	
   <div class="map-detail-left">

  		  <p class="pink"> 
		    {foreach from=$values7 item=key} 
			  {$key.adword_line1} {$key.adword_line2}
		    {/foreach}
          </p>

	 <h1 class="map-detail-left">{$values[i].business_name}</h1>	
	 
          {if $values[i].business_logo neq ''}
		    <img src="{$CLIENT_IMAGES_PATH}{$values[i].business_logo}" width="90px" height="60px" align="right"  />
		  {/if}     					 	 

		 {if  $classi neq '' && $location neq ''}
           <p class="pink">{$classi} in {$location}</p>
         {/if}
		 
		  <ul class="map-detail-left-rank">
					 
			<li>			
    		  {if $description[0] neq ''}
			  <h2>Description</h2>
			<ul>
				<li>{foreach from=$description item=key}
					   {$key}
			    {/foreach}</li>				
			</ul>
			{/if}
			</li>					 
			
			<li>			
			  <h2>Contact</h2>
			<ul>
			  {if $values[i].business_phone neq ''}<li><span>Phone:</span> {$values[i].business_phone}</li>{/if}
			  {if $values[i].business_mobile neq ''}<li><span>Mobile:</span> {$values[i].business_mobile}</li>{/if}
			  {if $values[i].business_fax neq ''}<li><span>Fax:</span> {$values[i].business_fax}</li>{/if}
								
			  {if $values[i].business_url neq '' && substr(strtolower($values[i].business_url),0,7) == 'http://'}	
				<li><span>Website:</span> <a href="{$values[i].business_url}" target="_blank">{$values[i].business_url}</a></li>
			  {else}
				<li><span>Website:</span> <a href="http://{$values[i].business_url}" target="_blank">{$values[i].business_url}</a></li>
    		  {/if}	

			  {if $values[i].business_email neq ''}
				<li><span>Email:</span>
				 <!-- <a href="{$contactUs}={$smarty.get.ID}&act={$smarty.get.action}" >{$values[i].business_email}</a> !-->
                  <a href="{$contactUs}" >{$values[i].business_email}</a>				 
				</li>
			  {/if}	 			
			</ul>
			</li>					 
					
							
			<li>			
	        <h2>Address</h2>
			<ul>
				<li>
					{if  $values[i].street1_status eq '1'}
					{else}
					{$values[i].business_street1}
					{/if}		
					{if  $values[i].street2_status eq '1'}
					{else}
					{$values[i].business_street2}
					{/if}
				</li>
				<li>
					{if $values[i].business_suburb eq ''}{else}{$values[i].business_suburb}{if $values[i].business_state neq ''}, {/if}{/if}
					
					{if $values[i].business_state eq ''}{else}{$values[i].business_state}{if $values[i].business_postcode neq ''},{/if}{/if}
					
					{if $values[i].business_postcode eq ''}{else}{$values[i].business_postcode}{/if}
				</li>
			</ul>
			</li>
                          			  			
		<li>	
		{if $values5[0].hour_name neq ''}
			<h2>Operating Hours</h2>
			<ul>
			{foreach from=$values5 item=key}
			<li> {$key.hour_name}</li>
			{/foreach}				
			</ul>	
		{/if}
		</li>
		
		
		
		<li>
			  
		{if $values4[0].business_brand_name neq ''}
			<h2>Brands</h2>
			<ul>{foreach from=$values4 item=key}
			<li>
					   {$key.business_brand_name}
			   </li>			 {/foreach}
			</ul>	
		{/if}
			</li>
			

					<li>	
  
		{if $values9[0].business_service_name neq ''}
			<h2>Services</h2>
			<ul>
			{foreach from=$values9 item=key}
			<li> {$key.business_service_name}</li>
			{/foreach}				
			</ul>	
		{/if}
		</li>
		
        <li>		
        {*
		{if $classifications[0] neq ''}
			<h2>Classifications</h2>
			<ul>
			{foreach from=$classifications item=key}
			
			<li> <a href="{$SITE_PATH}main.php?do=Listing&action=searchKeyword&Search1={$key|escape:'url'}&Search2=All+States">{$key}</a></li>
			{/foreach}				
			</ul>	
		{/if}
		*}
		
		{if $class_count > 0}
		    <h2>Classifications</h2>
			<ul>
			  {section name=class loop=$classifications}
			     <li> <a href="{$SITE_PATH}Listing/categorySearchAlpha/search/{$classifications[class].localclassification_id}/category/{$classifications[class].localclassification_url_encode}">{$classifications[class].localclassification_name}</a></li>
               {/section}	
			</ul>	
		{/if}	
		
		</li>	
		
		
		
			
		<li>
			{if $values3[0].business_key_name neq ''}
			<h2>Keywords</h2>
			<ul>
			{assign var="k" value=1}
			{section name=k loop=$values3[0]}
			<li>{$values3[k].business_key_name}</li>
			{assign var="k" value=$k+1}
			{/section}				
			</ul>
		{/if}
		</li>
		
		<li>
		{if $values8[0].payment_name neq ''}
			<h2>Accepted Payment Types</h2>
			<ul>
			{foreach from=$values8 item=key}
			<li> {$key.payment_name}</li>
			{/foreach}				
			</ul>	
	    {/if}
				
		</li>
						
					</ul>
				<br /><br />
					</div>
					
					{if $values[0].map_status eq '0' && $rank_count>0}
					   {include file='google_map.tpl'}
					   
					{else}
					   {include file='free_listing_ads.tpl'}
                    {/if}
                  

  {if $values[i].business_image neq ''}
    <ul class="image-detail-right">
      <li>
        <img src="{$CLIENT_IMAGES_PATH}{$values[i].business_image}" width="405px" align="right"  /> 
      </li>	  
    </ul>
  {/if}         
  


 {/section} 
 <div class="breaker"></div>
{include file="social_networking_footer.tpl" }
{*
{if ($rank_count<1)}
	{include file='google_ads_bl_footer.tpl'}
{/if}
*}

     <div class="mapbottom">
   <table align="center" width="98%">
   <tr><td height="6px" colspan="2"></td></tr>
        <tr>
            <td class="googlemapword" width="50%" align="left">
                <b> <a href="javascript: history.back()">Back to Search</a></b>
					</td>
					 <td class="googlemapword" width="50%" align="right">
					 <b> <a href="javascript:window.print()">Print this page</a></b>
					</td>
					 </tr>
					 </table>
</div>



{include file="footer.tpl" google_ads='0'}

<script type="text/javascript" language="javascript">
  /*window.onload = setOption("c");*/
</script>

 {* include file="google_custom_search.tpl" *}
 
{if ($rank_count<1)}
	{include file='google_free_listing_ad.tpl'}
{/if}
