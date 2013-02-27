<div class="navigation">
			<form id="test" action="/main.php" name="Homepage" method="get" onsubmit="return check_inner();">
	<input type="hidden" id="testid" value="" disabled="disabled" />

		<input type="hidden" id="do" name="do" value="Listing" />
		<input type="hidden" id="action" name="action" value="search" />
	<ul class="search">
		<li>
				<input type="hidden" name="SearchOption" id="SearchOption" checked="checked" type="radio" value="1" onchange="classChange(this.value);" /><h2>Business Name</h2> 
	
		</li>
		<li><p class="sideinput"><input type="text" name="Search1" id="Search1" value="{$keyword|stripslashes}" size="15" class="largeinputbox"/></p><li>
	<li><h2>Location</h2></li>
		<li >
			<p class="sideinput"><input type="text" name="Search2" id="Search2" value="{$location|stripslashes}"  size="17" class="largeinputbox" /></p>
		</li>
		
	</ul>
    <br />
    <input src="{$IMAGES_PATH}sidesearch.gif" type="image" hspace="10" name="Submit" id="Submit" value="Search" />
    
</form>

</div>

<script language="javascript" src="{$JS_PATH}search.js"></script>

<script>window.onload = setOption("b");</script>
