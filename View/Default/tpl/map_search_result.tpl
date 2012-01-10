<div class="navigation">
<ul class="navbar">
   
<form id="test" action="main.php" name="Homepage" method="get" onsubmit="return check();">
	<input type="hidden" id="testid" value="" disabled="disabled" />
	<input type="hidden" id="do" name="do" value="Listing" />
	<input type="hidden" id="action" name="action" value="mapSearchResult" />

	<ul class="search">
		<li>
			<span>Business Name</span>
		</li>
		<li><input type="text" name="Search1" id="Search1" value="{$keyword}" class="largeinputbox"/><li>
		<li><h2>Location</h2></li>
		<li><span>Suburb, Postcode , Region</span></li>
		<li>
			<input type="text" name="Search2" value="{$location}" class="largeinputbox" />
		</li>
		<li>
			<input class="btn" type="submit" name="Submit" id="Submit" value="Search" />
		</li>
	</ul>
	</form>
    <li><span><b>Go to Desired Location</b></span>
	</li>
    
	<li>
    	
        <ul class="submenu">
		{assign var="j" value=0}
		  <li class="{if $j % 2==0}{else}odd{/if}">{$map_sidebar}</li>
		  {assign var="j" value=$j+1}
		</ul>
	</li>  
</ul></div>
{if $Count eq 0}
<div align="center"><strong>No Results found</strong></div>
{/if}
        
{$map_header_js}
{$map_js}
<div align="center">{include file="pagination.tpl"}</div>
<table border=1 align="center">
<tr><td>
{$map_view_js}
</td><td>
</table>

{$onload_js}