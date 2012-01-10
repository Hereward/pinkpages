<div class="navigation">

	<form id="test" action="main.php" name="Homepage" method="get" onsubmit="return check_inner();">
	<input type="hidden" id="testid" value="" disabled="disabled" />

	{if $smarty.get.action == search}
		<input type="hidden" id="do" name="do" value="Listing" />
		<input type="hidden" id="action" name="action" value="search" />
	{else}
		<input type="hidden" id="do" name="do" value="Listing" />
		<input type="hidden" id="action" name="action" value="searchKeyword" />
	{/if}

	<ul class="search">
		<li>
			<input type="hidden" name="SearchOption" id="SearchOption" type="radio" value="0" {if $smarty.get.SearchOption != '1'}checked="checked"{/if} onclick="javascript:setOption('c')" onchange="classChange(this.value);"  /><span>Keyword</span> 
	<input type="hidden" name="SearchOption" id="SearchOption" {if $smarty.get.SearchOption == '1'}checked="checked"{/if} type="radio" value="1" onclick="javascript:setOption('b')" onchange="classChange(this.value);" /><span>Business Name </span>
		</li>
		<li><input type="text" name="Search1" id="Search1" value="{$keyword|stripslashes}" size="15" class="largeinputbox"/><li>
	
		<li><h2>Location</h2></li>
		<li >
			<input type="text" name="Search2" id="Search2" value="{$location|stripslashes}"  size="15" class="largeinputbox" />
		</li>
		
		<li  class="aligh-R">
			<input src="{$IMAGES_PATH}btn-search-refine.gif" type="image" name="Submit" id="Submit" value="Search" />
		</li>
	</ul>
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

	<ul class="navbar">
		 <li><h2>Refine Your Search</h2></li>
		  <li>
		<span>Services</span>  
		 <ul class="submenu">
		<li>
			<select name="services" onchange="{$service_change}" >
				<option value="" selected>--Select Service--</option>
				{foreach from=$fetch_service item=j }
				<option value="{$j.service_id}" {if $selectArray.service eq $j.service_id}selected{/if}>{$j.business_service_name}</option>
				{/foreach}
			</select>
		</li>
		</ul> 
		</li>
		<li>
	 	<span>Hours</span>
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
   <!--<span>Working Days</span>
   <ul class="submenu">
		<li>
			<select name="days">
				<option value="" selected>--Select Day--</option>
				<option value="1" {if $selectArray.days eq 1}selected{/if}>Monday</option>
				<option value="2" {if $selectArray.days eq 2}selected{/if}>Tuesday</option>
				<option value="3" {if $selectArray.days eq 3}selected{/if}>Wednesday</option>
				<option value="4" {if $selectArray.days eq 4}selected{/if}>Thursday</option>
				<option value="5" {if $selectArray.days eq 5}selected{/if}>Friday</option>
				<option value="6" {if $selectArray.days eq 6}selected{/if}>Saturday</option>
				<option value="7" {if $selectArray.days eq 7}selected{/if}>Sunday</option>
			</select>
		</li>
		</ul> 
		  <span>Working Hours</span>
		
		<li>
			<select name="fromHrs" >
				<option value="" selected>-From-</option>
			{foreach item=i from=$hrs}
				<option value="{$i}" {if $selectArray.fromHrs eq $i}selected{/if}>{$i}</option>
			{/foreach}
			</select>&nbsp;<label><font size="-6"><strong>Hours</strong></font></label>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<select name="toHrs">
				<option value="" selected>-To-</option>
				{foreach item=i from=$hrs}
				<option value="{$i}" {if $selectArray.toHrs eq $i}selected{/if}>{$i}</option>
			{/foreach}
			</select>&nbsp;<label><font size="-6"><strong>Hours</strong></font></label>
		</li>-->
		
		<!--<li>
		 <span>Keyword </span>
		  	<ul class="submenu">
				<li>
					<select name="keyword" onchange="{$keyword_change}">
						<option value="" selected>--Select Keyword--</option>
					{foreach item=i  from=$keywordArray}
						<option value="{$i}" {if $selectArray.keyword eq $i}selected{/if}>{$i}</option>
					{/foreach }
					</select>
				</li>
		 	</ul>
		</li>-->
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

	</ul>
	{/if}

	
</div>

<script language="javascript" src="{$JS_PATH}search.js"></script>
<script>
{if $smarty.get.SearchOption == '0'}
window.onload = setOption("c");
{elseif $smarty.get.SearchOption == '1'}
window.onload = setOption("b");
{/if}
</script>