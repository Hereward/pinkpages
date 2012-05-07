<div class="navigation">
							<form id="test" action="/main.php" name="Homepage" method="get" onsubmit="return check_inner();">
	<input type="hidden" id="testid" value="" disabled="disabled" />

		<input type="hidden" id="do" name="do" value="Listing" />
		<input type="hidden" id="action" name="action" value="searchKeyword" />


	<ul class="search">
		<li>
			<input type="hidden" name="SearchOption" id="SearchOption" type="radio" value="0" checked="checked" /> <h2>Keyword</h2> 
	
		</li>
		<li><p class="sideinput"><input type="text" name="Search1" id="Search1" value="{$keyword|stripslashes}" size="20" class="largeinputbox"/></p><br /><li>
	
		<li><h2>Location</h2></li>
		<li>
			<p class="sideinput"><input type="text" name="Search2" id="Search2" value="{$location|stripslashes}"  size="17" class="largeinputbox" /></p>
			{if $searchArea eq 'suburb' && $regionCount}
			  {foreach from=$regionURLs key=i item=regionURL}
			    {foreach from=$regionURL key=region item=url}
			      <a href="{$url}"><p class="search-refine">Search whole {$region}</p></a>
                {/foreach} 				  
			  {/foreach}
            {/if}									  
			{if $searchArea eq 'region' && $suburbCount}
			  <select class="suburbs" name="suburbs" onchange="{$suburb_change}">
    		    <option value="" selected>Refine Search by Suburb</option>
			    {foreach from=$suburbURLs key=i item=suburbURL}
    			  {foreach from=$suburbURL key=suburb item=url}
    		        <option value="{$url}" {if $smarty.get.suburbs eq $suburb} selected="selected" {/if} >{$suburb}</option>
                  {/foreach} 				  
			    {/foreach}	
			  </select>			
            {/if}						
		</li>
		
	</ul>
    <br />
    <input src="{$IMAGES_PATH}sidesearch.gif" type="image" hspace="10" name="Submit" id="Submit" value="Search" />
</form>


{if $smarty.get.action eq 'categorySearch'}

						<!--Refine Search-->

	{if $smarty.get.action eq 'categorySearch'}
	<input type="hidden" name="search" id="search" value="{$smarty.get.search}" />
	<input type="hidden" name="category" id="category" value="{$smarty.get.category}" />
	{/if}
	{if $smarty.get.action eq 'search'}
	<input type="hidden" name="Search1" id="Search1" value="{$smarty.get.Search1}" />
	<input type="hidden" name="Search2" id="Search2" value="{$smarty.get.Search2}" />
	{/if}
	<input type="hidden" id="do" name="do" value="Listing" />
	<input type="hidden" id="action" name="action" value="{$smarty.get.action}" />
	
	    {foreach from=$fetch_service item=j } 
		{if $j.business_service_name neq ''}
		{capture name=service assign=show}
		show
		{/capture}
		{/if}
		{/foreach}
		
		{foreach item=i from=$fetch_hours}
		{if $i.hour_name neq ''}
		{capture name=hours assign=show2}
		show
		{/capture}
		{/if}
		{/foreach}
		
		{foreach item=i from=$fetch_payment}
		{if $i.payment_name neq ''}
		{capture name=payment assign=show3}
		show
		{/capture}
		{/if}
		{/foreach}
		
	    {foreach item=i from=$brandArray}
		{if $i.business_brand_name neq ''}
		{capture name=brand assign=show4}
		show
		{/capture}
		{/if}
		{/foreach}
 	

	{if $smarty.capture.service neq '' ||  $smarty.capture.hours neq '' || $smarty.capture.payment neq '' || $smarty.capture.brand neq ''}
    
    
    <br />
 <table style="padding-left:4px;"><tr><td>   <h2>Refine Your Search</h2>
	<ul class="navbar">
		

		
		 {if $smarty.capture.service neq ''}
		  <li>
		<span>Services</span>  
		 <ul class="submenu">
		
		<li>
			<select name="services" onchange="{$service_change}" >
				<option value="" selected>--Select Service--</option>
				{foreach from=$fetch_service item=j }
				 {if $j.business_service_name neq ''}
				<option value="{$j.service_id}" {if $selectArray.service eq $j.service_id}selected{/if}>{$j.business_service_name}</option>
				{/if}
				{/foreach}
			</select>
			
		</li>
		

		</ul> 
		</li>
	{/if}
	
		
		{if $smarty.capture.hours neq ''}
		<li>
	 	<span>Hours </span>
		<ul class="submenu">
	
		<li>
			<select name="hours" onchange="{$hour_change}">
			    <option value="" selected>--Select Hour--</option>
				{foreach item=i from=$fetch_hours}
				  <option value="{$i.hour_id}" {if $smarty.get.hours eq $i.hour_id} selected="selected" {/if} >{$i.hour_name}</option>
				{/foreach}
			</select>
		</li>
	
		</ul> 
		</li>
		{/if}
		
	  
		{if $smarty.capture.payment neq ''}
		
		<li>
		
	<span>Payments</span>	
	 <ul class="submenu">
		<li>
			<select name="payment" onchange="{$payment_change}">
				<option value="" selected>--Select Payment Mode--</option>
				{foreach item=i from=$fetch_payment}
				 <option value="{$i.payment_id}" {if $smarty.get.payment eq $i.payment_id} selected="selected" {/if} >{$i.payment_name}</option>
				{/foreach}
			</select>
		</li>
	</ul> 
	</li>
	{/if}
	
	

		
		{if $smarty.capture.brand neq ''}

		<li>
		 <span>Brand</span>
		  	<ul class="submenu">
				<li>
					<select name="brand" onchange="{$brand_change}">
						<option value="" selected>--Select Brand--</option>
					{foreach item=i from=$brandArray}
						<option value="{$i.brand_id}" {if $selectArray.brand eq $i.brand_id}selected{/if}>{$i.business_brand_name}</option>
					{/foreach}
					</select>
				</li>
			</ul>
		</li>
		{/if}
		
	</ul>
	{/if}
    
	{/if}
		</td></tr></table>

    {if $snippets}		
      <div class="snippets">
        {foreach item=snippet from=$snippets}
		  <p>{$snippet.content_snippet}</p><br />
		{/foreach}
      </div>	
    {/if}	  
    
    {include gab=4 file="google_ad.tpl"}

</div>




	

<script language="javascript" src="{$JS_PATH}search.js"></script>

<script>
window.onload = setOption("c");
</script>



