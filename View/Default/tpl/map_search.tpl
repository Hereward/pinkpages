<form id="test" action="{$mapSearchResult}" name="MapSearch" method="get" onsubmit="return check();">
<input type="hidden" name="do" value="Listing" />
<input type="hidden" name="action" value="mapSearchResult" />
<input type="hidden" id="s_type" value="0" />
<input type="hidden" id="testid" value="" disabled="disabled" />
	   
	<div class="middle-content">
 		
		<div class="searchbox-index">
				 
		 <div class="left" >
			<ul>
					<li> 
						<h2>Map Search</h2>
						<p><input type="text" name="Search1" id="Search1" value="" /></p>
						<span>Business Name</span>
					</li>
					<li> 
						
						<h2>&nbsp;</h2>
						<p><input type="text" name="Search2" value="" /></p>
						<span>Postcode, Suburb</span>
					</li>
								<p>
			 <input class="btn" type="submit" name="Submit" id="Submit" value="Search" />
			 </p>
			</ul>

	  </div>
	  
			<!--<div class="left">
				<ul>
					<li> <h2>Search for... </h2> </li>
					
					
					<li> <span>(Business Name)</span> </li>
					<li> <input type="text" name="Search1" id="Search1" value="" class="largeinputbox"/> </li>
                </ul>
			</div>
						
            <div class="middle">
               <ul>
                 <li> <h2>In... </h2> </li>
                 <li> <span>(Postcode, Suburb)</span> </li>
                 <li><input type="text" name="Search2" value="" class="largeinputbox" />
				 	<label>
					 <input class="btn" type="image" src="{$IMAGES_PATH}/btn-search.gif" name="Submit" id="Submit" value="Search" />
					</label>
				</li>
               </ul>
            </div>
            <div class="right">
                <a href="{$add_listing}"><img src="{$IMAGES_PATH}free.jpg" alt="Build Listing" border="0" /></a>
            </div>-->
			   	 <div class="right"><img src="{$IMAGES_PATH}Truly-Local-man.gif" alt="" /></div>
				 
        </div>
<!--<div class="images-footer">
		 	<ul>
				<li><a href="{$viewdemo}"><img src="{$IMAGES_PATH}demo.gif" alt="" /></a></li>
				<li><a href="#"><img src="{$IMAGES_PATH}find.gif" alt="" /></a></li>
				<li><a href="#"><img src="{$IMAGES_PATH}why.gif" alt="" /></a></li>
				<li><a href="#"><img src="{$IMAGES_PATH}need.gif" alt="" /></a></li>
				<li><a href="{$SITE_PATH}main.php?do=Content&action=contactUs"><img src="{$IMAGES_PATH}contact.gif" alt="" /></a></li>
				<li><a href="{$searchStreetForm}" rel="tcontent1"><img src="{$IMAGES_PATH}find1.gif" alt="" /></a></li>
			</ul>
				 
		</div>-->
{if $bannerArray[0].banner_name neq ''}	
        <div class="sitebanner"><a href="http://{$bannerArray[0].banner_link}"><img border="0" src="{$BANNER_PATH}{$bannerArray[0].banner_name}" alt="{$bannerArray[0].alt_text}" width="{$bannerArray[0].banner_width}" /></a> </div>
		{elseif $bannerArray[0].html_code neq ''}
	<div class="sitebanner">{$bannerArray[0].html_code}</div>
		{else}
			 <div class="sitebanner"><img border="0" src="{$IMAGES_PATH}bannerinner.jpg" alt="" width="200" /> </div>
		{/if}
    </div>
</form>
<script language="javascript" src="{$JS_PATH}map_search.js"></script>