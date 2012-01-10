<div class="navigation">
						<form action="main.php" name="Homepage" method="get" onsubmit="return checkStreet();">
			<input type="hidden" id="testid" value="" disabled="disabled" />
			<input type="hidden" id="do" name="do" value="Listing" />
			<input type="hidden" id="action" name="action" value="searchStreet" />

	<ul class="search">
		<li>
			<h2>Street</h2> 
	
		</li>
		<li><p class="sideinput"><input type="text" name="Search1" id="Search1" value="{$smarty.get.Search1|stripslashes}" size="15" class="largeinputbox" /></p><br /><li>
	
		<li><h2>Suburb</h2></li>
		<li >
			<p class="sideinput"><input type="text" name="Search2" id="Search2" value="{$smarty.get.Search2|stripslashes}" size="15" class="largeinputbox" /></p>
		</li>
		
		
			
	
	</ul>
	<br />
	<input src="{$IMAGES_PATH}sidesearch.gif" type="image" hspace="10" name="Submit" id="Submit" value="Search" />
</form>

</div>

	
	{literal}
<script language="javascript">
var suburb_location = {
	script:"main.php?do=Search&action=loadAjax&json=true&type=1&limit=10&",
	varname:"kw",
	json:true,
	shownoresults:false,
	maxresults:6,
	callback: function (obj) { document.getElementById('testid').value = obj.id; }
};

</script>

{/literal}