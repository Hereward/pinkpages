<!--Footer Start-->

</div>
		<div class="footer">
		<ul>
				<li id="browse_by_city" style="float:center;">
					Browse by City: &nbsp;&nbsp; <a href="{$SITE_PATH}main.php?do=Index&action=home&p=s">Sydney</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="{$SITE_PATH}main.php?do=Index&action=home&p=n">Newcastle</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="{$SITE_PATH}main.php?do=Index&action=home&p=c">Canberra</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="{$SITE_PATH}main.php?do=Index&action=home&p=m">Melbourne</a>
				</li>
				<li style="float:center;">
					&nbsp;&nbsp;
				</li>
				{if ($google_ads)}
				  {include ad_container_id='adcontainer1' gab=1 file='google_ad.tpl' ads_per_block=2}
				{/if}
				<li style="float:center;">
					Copyright &copy 2012 Dawson Media Pty Ltd. &nbsp;&nbsp; <a href="{$SITE_PATH}terms_conditions">Terms and Conditions</a>&nbsp;&nbsp; <a href="{$SITE_PATH}privacy">Privacy Policy</a>&nbsp;&nbsp; <a href="{$SITE_PATH}disclaimer">Disclaimer</a>
				</li>
					
		</ul>
	
		

<!--Footer End-->



<!--<div class="footer">
	<ul class="privacylinks" >
	<li><a href="{$SITE_PATH}">Home</a></li>
	<li><a href="{$classifiedSearch}">Classified Search</a></li>
	<li><a href="{$searchStreetForm}">Street Search</a></li>
	<li ><a href="{$browse_by_category}&search=a">Browse by Category</a></li>
	<li class="noborder"><a href="{$SITE_PATH}main.php?do=Content&action=contactUs">Contact Us</a></li>
	<li><a href="{$SITE_PATH}main.php?do=Content&action=privacyStatement">Privacy Statement</a></li>
    <li><a href="{$SITE_PATH}main.php?do=Content&action=termsAndConditions">Terms and Conditions</a></li>
	<li><a href="{$SITE_PATH}main.php?do=Content&action=aboutUs">About Us</a></li>
	<li class="noborder"><a href="{$SITE_PATH}main.php?do=Content&action=careers">Careers at pink Pages</a></li>
	-->
	<!--</ul>-->


	</div>
	

</body>
</html>