<!--Body Start-->
<div class="middle-content">
	<div class="searchbox-index">
    <div class="searchbox-front-left" >
    </div>
    <div class="searchbox-front-middle">
    <br />
    <P >Search for businesses on your street</P>
		<div class="searchbox-index-left-key">
            
			<form action="main.php" name="Homepage" method="get" onsubmit="return checkStreet();">
			<input type="hidden" id="testid" value="" disabled="disabled" />
			<input type="hidden" id="do" name="do" value="Listing" />
			<input type="hidden" id="action" name="action" value="searchStreet" />
		   <table class="searchbox-index-left" >
           <tr>
           <td class="title">Street
           </td>
           <td class="title">Suburb
           </td>
           <td>
           </td>
           </tr>
           
             <tr>
           <td ><p class="inputbox"><input type="text" name="Search1" id="Search1" value="" /></p>
           </td>
           <td><p class="inputbox"><input type="text" name="Search2" id="Search2" value="" /></p>
           </td>
         
           <td ><input class="btn" src="{$IMAGES_PATH}btn-search.gif" type="image" name="Submit" id="Submit" value="Search" />
           </td>
           </tr>
           <tr>
           <td></td>
           <td><img src="{$IMAGES_PATH}location.gif" alt="Search Sydney Pink Pages for Products or Services in a certain location, to search a location you nede to type it in for exmaple all sydney will search all sydney location and penrith will search penrith suburb" /></td>
           <td></td>
           </tr>
           
           </table>
           </form>
		
	  </div>
    <span><a href="/main.php?do=Content&action=contactUs">Advertise with us</a></span>
   </div>
      <div class="searchbox-front-right">
      </div>
          

	
  </div>

</div>
<!--Body End--> {include file="news.tpl"}

	
	
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
var suburb_json = new bsn.AutoSuggest('Search2', suburb_location);
</script>

{/literal}