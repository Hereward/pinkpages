<div class="navigation">
<ul class="navbar">

  {if ($do eq 'Admin' AND $act eq 'showhomePageAdmin')
  	|| ($do eq 'Listing' AND $act eq 'expiredBusiness')
  	|| ($do eq 'Listing' AND $act eq 'activateBus')
  }
  

		<li><img src="{$IMAGES_PATH}icon-home.gif" /><a href="{$home_url}">Home</a></li>
		{foreach from=$user_permission item=key}
		{if $key.1 eq '1'} 
		<li><img src="{$IMAGES_PATH}icon-manage2.gif" /><a href="{$search}">Business Manager</a></li><!--BusinessManager_url -->
		{/if}
		{if $key.1 eq '2'} 
		<li><img src="{$IMAGES_PATH}icon-manage1.gif" /><a href="{$clientManager}">Client Manager</a></li>
		{/if}
		{if $key.1 eq '3'} 
		<li><img src="{$IMAGES_PATH}icon-manage.gif" /><a href="{$TeamManager_url}">Team Manager</a></li>
		{/if}
		{if $key.1 eq '4'} 
		<li><img src="{$IMAGES_PATH}icon-manage3.gif" /><a href="{$csvfile}">Listing Manager</a></li>
		{/if}
		{if $key.1 eq '5'} 		
		<li><img src="{$IMAGES_PATH}icon-manage5.gif" /><a href="{$searchClassification}">Classification Manager</a></li>
		{/if}
		{if $key.1 eq '6'} 
		<!--<li><img src="{$IMAGES_PATH}icon-manage11.gif" /><a href="{$viewVertical}">Vertical Manager</a></li>-->
		<li><img src="{$IMAGES_PATH}icon-manage11.gif" /><a href="{$viewGroup}">Vertical Manager</a></li>
		<!--<li><img src="{$IMAGES_PATH}icon-manage11.gif" /><a href="{$viewGroup}">Group Manager</a></li>-->
		{/if}
		{if $key.1 eq '7'} 
		<li><img src="{$IMAGES_PATH}icon-manage7.gif" /><a href="{$view}">Synonyms Manager</a></li>
		{/if}
		{if $key.1 eq '8'} 
		<li><img src="{$IMAGES_PATH}icon-manage6.gif" /><a href="{$viewLocation}">Location Manager</a></li>
		{/if}
		{if $key.1 eq '9'} 
		<li><img src="{$IMAGES_PATH}icon-manage10.gif" /><a href="{$bannerManager}">Banner Manager</a></li>
		{/if}
		{if $key.1 eq '10'} 
		<li><img src="{$IMAGES_PATH}icon-manage9.gif" /><a href="{$viewPage}">Content Manager</a></li>
		{/if}
		{if $key.1 eq '11'} 
		<li><img src="{$IMAGES_PATH}icon-manage13.gif" /><a href="{$sitePerformanceReport}">Site Statistics</a></li>
		{/if}
		{if $key.1 eq '12'} 
		<li><img src="{$IMAGES_PATH}icon-manage12.gif" /><a href="{$rankReport}">Rank Manager</a></li>
		{/if}
		{if $key.1 eq '13'} 
		<li><img src="{$IMAGES_PATH}icon-manage.gif" /><a href="{$site_config_manager}">Site Configuration Manager</a></li>
		{/if}
		{if $key.1 eq '14'} 
		<li><img src="{$IMAGES_PATH}icon-manage1.gif" /><a href="{$min_visits}">Listings Under Minimum Visits</a></li>
		{/if}
		<!--{if $key.1 eq '15'} 
		<li><img src="{$IMAGES_PATH}icon-manage9.gif" /><a href="{$keyword_manager}">Keyword Manager</a></li>
		{/if}-->
		{if $key.1 eq '16'} 
		<li><img src="{$IMAGES_PATH}icon-manage10.gif" /><a href="{$brand_manager}">Brand Manager</a></li>
		{/if}
		{if $key.1 eq '17'}
		<li><img src="{$IMAGES_PATH}icon-manage9.gif" /><a href="{$contactDetails}">Mailing Data</a></li>
		{/if}
		{if $key.1 eq '18'}
		<li><img src="{$IMAGES_PATH}icon-manage.gif" /><a href="{$expiredBusiness}">Expired Business</a></li> 
		{/if}
		{if $key.1 eq '19'}
		<li><img src="{$IMAGES_PATH}icon-manage.gif" /><a href="{$marketManager}">Market Manager</a></li> 
		{/if}		
		{/foreach} 
		<!--<li><img src="{$IMAGES_PATH}icon-manage1.gif" /><a href="{$service_manager}">Service Manager</a></li>-->
		<!--<li><img src="{$IMAGES_PATH}icon-logout.gif" /><a href="{$expBusinessCron}">Expired Business Cron Job</a></li>    -->
		<li><img src="{$IMAGES_PATH}icon-logout.gif" /><a href="{$logout_url}">Logout</a></li>    
	
	
  {elseif 	($do eq 'Admin' AND $action1 eq 'clientManager')||($do eq 'Admin' AND $action1 eq 'deleteclients')||($do eq 'Admin' AND $action1 eq 'editclients')||($do eq 'Admin' AND $action1 eq 'editclients_edit')||($do eq 'Admin' AND $action1 eq 'addclient')||($do eq 'Admin' AND $action1 eq 'clientadd')||($do eq 'Admin' AND $action1 eq 'addaffiliate')||($do eq 'Admin' AND $action1 eq 'fetchaffiliates')||($do eq 'Admin' AND $action1 eq 'affiliateadd')||($do eq 'Admin' AND $action1 eq 'deleteaffiliate')||($do eq 'Admin' AND $action1 eq 'editaffiliate_edit')||($do eq 'Admin' AND $action1 eq 'editaffiliate')||($do eq 'Admin' AND $action1 eq 'searchclients')||($do eq 'Admin' AND $action1 eq 'searchclients_affiliates')}
     
		<li><img src="{$IMAGES_PATH}icon-home.gif" /><a href="{$home_url}">Home</a></li> 
		<li><img src="{$IMAGES_PATH}icon-add2.gif" /><a href="{$addclient}">Add Client</a></li> 
		<li><img src="{$IMAGES_PATH}icon-view1.gif" /><a href="{$clientManager}">View Clients</a></li> 
		<!--<li><img src="{$IMAGES_PATH}icon-view1.gif" /><a href="{$fetchaffiliates}">View Affiliates</a></li> -->
	<!--	<li><img src="{$IMAGES_PATH}icon-add1.gif" /><a href="{$addaffiliate}">Add Affiliate</a></li>  -->
		<li><img src="{$IMAGES_PATH}icon-search1.gif" /><a href="{$searchclients}">Search</a></li> 
		<li><img src="{$IMAGES_PATH}icon-logout.gif" /><a href="{$logout_url}">Logout</a></li>       



{elseif  ($do eq 'Admin' AND $action eq 'sitePerformanceReport')||($do eq 'Admin' AND $action eq 'pagePopularityReport')||($do eq 'Admin' AND $action eq 'fetchUniqueClients')||($do eq 'Admin' AND $action eq 'classificationStats')||($do eq 'Admin' AND $action1 eq 'clients_in_specific_locality')||($do eq 'Admin' AND $action eq 'failed_searches')||($do eq 'Admin' AND $action eq 'count_listing')||($do eq 'Admin' AND $action eq 'count_listings_in_vertical')||($do eq 'Admin' AND $action eq 'count_listings_in_classification')||($do eq 'Admin' AND $action eq 'count_listings_in_locality')||($do eq 'Admin' AND $action1 eq 'search_locality_based_clients_form')||($do eq 'Admin' AND $action1 eq 'search_locality_based_clients')||($do eq 'Admin' AND $action1 eq 'search_within_a_locality_count')||($do eq 'Classification' AND $action eq 'regionReport')||($do eq 'Classification' AND $action eq 'ctrReport')||($do eq 'Classification' AND $action eq 'class_region_total_report') || ($do eq 'Classification' AND $action eq 'failed_searches_report')}

		<li><img src="{$IMAGES_PATH}icon-home.gif" /><a href="{$home_url}">Home</a></li>  
		<li><img src="{$IMAGES_PATH}icon-manage11.gif" /><a href="{$class_region_report}">Classification-Region Report</a></li>  
		<li><img src="{$IMAGES_PATH}icon-manage11.gif" /><a href="{$class_region_total_report}">Classification-Region Totals</a></li>  {* report for monthly totals *}
		<li><img src="{$IMAGES_PATH}icon-manage11.gif" /><a href="{$ctr_report}">CTR Report</a></li>  		
		<li><img src="{$IMAGES_PATH}icon-manage11.gif" /><a href="{$classificationBannerReport}">Classification-Banner Report</a></li>  	
		<li><img src="{$IMAGES_PATH}icon-manage11.gif" /><a href="{$failed_searches_report}">Failed Searches Report</a></li> 	
	<!--	<li><img src="{$IMAGES_PATH}icon-manage11.gif" /><a href="{$sitePerformanceReport}">Site Performance Report</a></li>  
		<li><img src="{$IMAGES_PATH}icon-manage7.gif" /><a href="{$pagePopularityReport}">Page Popularity Report</a></li>  
		<li><img src="{$IMAGES_PATH}icon-manage1.gif" /><a href="{$fetchUniqueClients}">Unique Clients</a></li>  
		<li><img src="{$IMAGES_PATH}icon-manage5.gif" /><a href="{$classificationStats}">Classification Statistics</a></li>  
		<li><img src="{$IMAGES_PATH}icon-manage1.gif" /><a href="{$clients_in_specific_locality}">Clients in locality</a></li>  
		<li><img src="{$IMAGES_PATH}iconDelete.png" /><a href="{$failed_searches}">Failed Searches</a></li>  
		<li><img src="{$IMAGES_PATH}icon-manage4.gif" /><a href="{$count_listing}">Count Listing</a></li>  
		<li><img src="{$IMAGES_PATH}icon-manage4.gif" /><a href="{$search_within_a_locality_count}">Search within a locality</a></li>  -->
		<li><img src="{$IMAGES_PATH}icon-logout.gif" /><a href="{$logout_url}">Logout</a></li>    

		
	{elseif ($do eq 'SalesAccountManager' AND $action1 eq 'addListing')|| ($do eq 'SalesAccountManager' AND $action1 eq 'searchBusiness')|| ($do eq 'SalesAccountManager' AND $action1 eq 'searchBusinesses')|| ($do eq 'SalesAccountManager' AND $action1 eq 'listingAddition')|| ($do eq 'SalesAccountManager' AND $action1 eq 'Edit')|| ($do eq 'SalesAccountManager' AND $action1 eq 'editAddition')|| ($do eq 'SalesAccountManager' AND $action1 eq 'delete')|| ($do eq 'SalesAccountManager' AND $action1 eq 'searchFreeListing') ||  ($do eq 'SalesAccountManager' AND $action1 eq 'showMidPage')|| ($do eq 'SalesAccountManager' AND $action1 eq 'updateAdd')|| ($do eq 'SalesAccountManager' AND $action1 eq 'addClassification') || ($do eq 'SalesAccountManager' AND $action1 eq 'rankBusiness') || ($do eq 'SalesAccountManager' AND $action1 eq 'addRank')||($do eq 'SalesAccountManager' AND $action1 eq 'addRank')||($do eq 'SalesAccountManager' AND $action1 eq 'addMoreAddresses')||($do eq 'SalesAccountManager' AND $action1 eq 'moreAddressesAdd')||($do eq 'SalesAccountManager' AND $action1 eq 'manageAddress')||($do eq 'SalesAccountManager' AND $action1 eq 'editAddress')||($do eq 'SalesAccountManager' AND $action1 eq 'editAddressesAdd')||($do eq 'SalesAccountManager' AND $action1 eq 'deleteaddress') || ($smarty.get.do eq 'SalesAccountManager' AND $smarty.get.action eq 'deleteKeyword') || ($smarty.get.do eq 'SalesAccountManager' AND $smarty.get.action eq 'add_keyword') || ($smarty.get.do eq 'SalesAccountManager' AND $smarty.get.action eq 'add_new_keyword')|| ($smarty.get.do eq 'SalesAccountManager' AND $smarty.get.action eq 'manageHoursDays')|| ($smarty.get.do eq 'SalesAccountManager' AND $smarty.get.action eq 'editHourDays') || ($smarty.get.do eq 'SalesAccountManager' AND $smarty.get.action eq 'add_card_details')|| ($smarty.get.do eq 'SalesAccountManager' AND $smarty.get.action eq 'add_card')}
	
		<li><img src="{$IMAGES_PATH}icon-home.gif" /><a href="{$home_url}">Home</a></li>
		<li><img src="{$IMAGES_PATH}icon-add1.gif" /><a href="{$addbusinessform}">Add Business Listing</a></li>
		<li><img src="{$IMAGES_PATH}icon-search1.gif" /><a href="{$search}">Search Business Listings</a></li>
		<li><img src="{$IMAGES_PATH}icon-logout.gif" /><a href="{$logout_url}">Logout</a></li>
		
		
	{elseif $act eq 'adminManager'|| ( $act eq 'registrationAdd')|| ( $act eq 'addition')|| ( $act eq 'edit')|| ( $act eq 'editAddition')|| ( $act eq 'delete')|| ( $act eq 'searchUserForm')|| ( $act eq 'searchUsers') || ( $act eq 'setPermission')|| ( $act eq 'updatePermission') || ( $act eq 'updateAccess')|| ( $act eq 'changeAccess')}
	
		<li><img src="{$IMAGES_PATH}icon-home.gif" /><a href="{$home_url}">Home</a></li>
		<li><img src="{$IMAGES_PATH}icon-add2.gif" /><a href="{$reg_url}"/>Add User</a></li>
		<li><img src="{$IMAGES_PATH}icon-view1.gif" /><a href="{$TeamManager_url}">View Users</a></li>
		<li><img src="{$IMAGES_PATH}icon-search1.gif" /><a href="{$searchUser}">Search Users</a></li>
		<li><img src="{$IMAGES_PATH}icon-logout.gif" /><a href="{$logout_url}">Logout</a></li>

	
		
		
	{elseif $action1 eq 'viewKeyword' || ( $action1 eq 'keywordFormShow')|| ( $action1 eq 'addKeyword') ||($action1 eq 'searchClassification')||($action1 eq 'fetchClassificationDetails')||($action1 eq 'importClassification')||($action1 eq 'importClassificationDetails')||($action1 eq 'fetchUploadedFile')||($action1 eq 'supressClassification')||($action1 eq 'releaseDisplay')||($action1 eq 'releaseClassification')||($action1 eq 'searchSupressedClassification') ||($action1 eq 'fetchSupressClassificationDetails')}
	
		<li><img src="{$IMAGES_PATH}icon-home.gif" /><a href="{$home_url}">Home</a></li>
		<li><img src="{$IMAGES_PATH}icon-add3.gif" /><a href="{$keywordFormShow}"/>Add Classification</a></li>
		<li><img src="{$IMAGES_PATH}icon-add1.gif" /><a href="{$importClassification}"/>Import Classification</a></li>
		<li><img src="{$IMAGES_PATH}icon-view1.gif" /><a href="{$keyword}">View Classification</a></li>
		<li><img src="{$IMAGES_PATH}icon-search1.gif" /><a href="{$searchClassification}">Search Classification</a></li>
		<li><img src="{$IMAGES_PATH}icon-view1.gif" /><a href="{$releaseDisplay}">View Suppressed Classification</a></li>		
		<li><img src="{$IMAGES_PATH}icon-search1.gif" /><a href="{$searchSupressedClassification}">Search Suppressed Classification</a></li>
		<li><img src="{$IMAGES_PATH}icon-logout.gif" /><a href="{$logout_url}">Logout</a></li>
		
	{elseif ($do eq 'Key' AND $action1 eq 'addListing') || ($do eq 'Key' AND $action1 eq 'viewList')|| ($do eq 'Key' AND $action1 eq 'listingAddition')|| ($do eq 'Key' AND $action1 eq 'deleteKey')}
	
		<li><img src="{$IMAGES_PATH}icon-home.gif" /><a href="{$home_url}">Home</a></li>
		{if $isAdmin}<li><img src="{$IMAGES_PATH}icon-add1.gif" /><a href="{$key}"/>Add Synonyms</a></li>{/if}	
		<li><img src="{$IMAGES_PATH}icon-view1.gif" /><a href="{$view}">View Synonyms</a></li>
		<li><img src="{$IMAGES_PATH}icon-logout.gif" /><a href="{$logout_url}">Logout</a></li>
		
	{elseif ($do eq 'Location' AND $action1 eq 'LocationFormShow_shirenames') || ($do eq 'Location' AND $action1 eq 'viewLocation')|| ($do eq 'Location' AND $action1 eq 'LocationFormShow_townnames')|| ($do eq 'Location' AND $action1 eq 'editLocation')|| ($do eq 'Location' AND $action1 eq 'updateEditLocation')|| ($do eq 'Location' AND $action1 eq 'addLocationShire')|| ($do eq 'Location' AND $action1 eq 'addLocationTown')|| ($do eq 'Location' AND $action1 eq 'searchLoc')|| ($do eq 'Location' AND $action1 eq 'searchLocations')|| ($do eq 'Location' AND $action1 eq 'deleteLocationTown')}
	
		<li><img src="{$IMAGES_PATH}icon-home.gif" /><a href="{$home_url}">Home</a></li>
		<li><img src="{$IMAGES_PATH}icon-add4.gif" /><a href="{$LocationFormShow_shirenames}"/>Add Shires</a></li>
		<li><img src="{$IMAGES_PATH}icon-add4.gif" /><a href="{$LocationFormShow_townnames}"/>Add Towns</a></li>
		<li><img src="{$IMAGES_PATH}icon-view1.gif" /><a href="{$viewLocation}">View Locations</a></li>
		<li><img src="{$IMAGES_PATH}icon-search1.gif" /><a href="{$searchLoc}">Search Locations</a></li>
		<li><img src="{$IMAGES_PATH}icon-logout.gif" /><a href="{$logout_url}">Logout</a></li>
		
	{elseif ($do eq 'AdminListing' AND $action1 eq 'csvFormShow') || 
	($do eq 'AdminListing' AND $action1 eq 'csvFileUpload') ||  
	($do eq 'AdminListing' AND $action1 eq 'import') || 
	($do eq 'AdminListing' AND $action1 eq 'Edit') ||  
	($do eq 'AdminListing' AND $action1 eq 'delete') || 
	($do eq 'AdminListing' AND $action1 eq 'editAdd') || 
	($do eq 'AdminListing' AND $action1 eq 'search') || 
	($do eq 'AdminListing' AND $action1 eq 'searchList') || 
	($do eq 'AdminListing' AND $action1 eq 'addClassification') || 
	($do eq 'AdminListing' AND $action1 eq 'rankBusiness') || 
	($do eq 'AdminListing' AND $action1 eq 'addRank') || 
	($do eq 'AdminListing' AND $action1 eq 'class_relationships') || 
	($do eq 'AdminListing' AND $action1 eq 'export_class_relationships') || 
	($do eq 'AdminListing' AND $action1 eq 'import_class_relationships') || 
	($do eq 'AdminListing' AND $action1 eq 'class_relationships_import_page') ||
	($do eq 'AdminListing' AND $action1 eq 'url_alias_import_page')
	}
	
		<li><img src="{$IMAGES_PATH}icon-home.gif" /><a href="{$home_url}">Home</a></li>
		<li><img src="{$IMAGES_PATH}icon-add1.gif" /><a href="{$csvfile}"/>Import Listing</a></li>
		<li><img src="{$IMAGES_PATH}icon-add1.gif" /><a href="{$import_class_relationships}"/>Import Relationships</a></li>
		<li><img src="{$IMAGES_PATH}icon-add1.gif" /><a href="{$class_relationships}"/>Export Relationships</a></li>
		<li><img src="{$IMAGES_PATH}icon-add1.gif" /><a href="{$import_url_alias}"/>Import URL Aliases</a></li>
		
		<!--<li><img src="{$IMAGES_PATH}icon-view1.gif" /><a href="{$searchFreeListing}"/>View Free Listing</a></li>
		<li><img src="{$IMAGES_PATH}icon-view1.gif" /><a href="{$viewlisting}"/>View Multiple Listing</a></li>
		<li><img src="{$IMAGES_PATH}icon-search1.gif" /><a href="{$searchfreeLists}"/>Search Listing</a></li>-->
		<li><img src="{$IMAGES_PATH}icon-logout.gif" /><a href="{$logout_url}">Logout</a></li>
		
	{elseif ($do2 eq 'Content' AND $action2 eq 'addPage') || ($do2 eq 'Content' AND $action2 eq 'viewPage')|| ($do2 eq 'Content' AND $action2 eq 'edit')|| ($do2 eq 'Content' AND $action2 eq 'editAdd')|| ($do2 eq 'Content' AND $action2 eq 'pageAddition')|| ($do2 eq 'Content' AND $action2 eq 'delete')}
	
		<li><img src="{$IMAGES_PATH}icon-home.gif" /><a href="{$home_url}">Home</a></li>
		<li><img src="{$IMAGES_PATH}icon-add5.gif" /><a href="{$addpage}"/>Add Page</a></li>
		<li><img src="{$IMAGES_PATH}icon-view1.gif" /><a href="{$viewPage}"/>View Page</a></li>
		<li><img src="{$IMAGES_PATH}icon-logout.gif" /><a href="{$logout_url}">Logout</a></li>	

		<!--<li><a href="{$bannerManager}"/>View Free Listing</a></li>
		<li><img src="{$IMAGES_PATH}icon-logout.gif" /><a href="{$logout_url}">Logout</a></li> -->
		
	{elseif ($do2 eq 'BannerManager' AND $action2 eq 'viewListing') || ($do2 eq 'BannerManager' AND $action2 eq 'addBanner') || ($do2 eq 'BannerManager' AND $action2 eq 'addBannerDetails') || ($do2 eq 'BannerManager' AND $action2 eq 'editBanner') || ($do2 eq 'BannerManager' AND $action2 eq 'editBannerDetails') || ($do2 eq 'BannerManager' AND $action2 eq 'deleteBanner')|| ($do2 eq 'BannerManager' AND $action2 eq 'changeStatus')|| ($do2 eq 'BannerManager' AND $action2 eq 'addAffiliateBanner')|| ($do2 eq 'BannerManager' AND $action2 eq 'addAffiliateBannerDetails')|| ($do2 eq 'BannerManager' AND $action2 eq 'viewAffilateListing')|| ($do2 eq 'BannerManager' AND $action2 eq 'editAffiliateBanner')|| ($do2 eq 'BannerManager' AND $action2 eq 'editAffiliateBannerDetails')|| ($do2 eq 'BannerManager' AND $action2 eq 'deleteAffiliateBanner')|| ($do2 eq 'BannerManager' AND $action2 eq 'viewReport')|| ($do2 eq 'BannerManager' AND $action2 eq 'linkDate') || ($do2 eq 'BannerManager' AND $action2 eq 'removeBanner')|| ($do2 eq 'BannerManager' AND $action2 eq 'addClassificationBanner')|| ($do2 eq 'BannerManager' AND $action2 eq 'addClassificationBannerDetails')|| ($do2 eq 'BannerManager' AND $action2 eq 'ClassificationBannerManager')|| ($do2 eq 'BannerManager' AND $action2 eq 'editClassificationBanner')|| ($do2 eq 'BannerManager' AND $action2 eq 'editClassificationBannerDetails')|| ($do2 eq 'BannerManager' AND $action2 eq 'deleteClassificationBanner')|| ($do2 eq 'BannerManager' AND $action2 eq 'removeClassificationBanner')|| ($do2 eq 'BannerManager' AND $action2 eq 'searchClassificationBanner')|| ($do2 eq 'BannerManager' AND $action2 eq 'searchClassificationBannerDetail')|| ($do2 eq 'BannerManager' AND $action2 eq 'deleteSearchClassificationBanner')|| ($do2 eq 'BannerManager' AND $action2 eq 'change_search_classification_status') || ($do2 eq 'BannerManager' AND $action2 eq 'classificationBannerReport')}
	
		<li><img src="{$IMAGES_PATH}icon-home.gif" /><a href="{$home_url}">Home</a></li>
		<li><img src="{$IMAGES_PATH}icon-add5.gif" /><a href="{$addBanner}"/>Add Site Banner</a></li>
		<li><img src="{$IMAGES_PATH}icon-add4.gif" /><a href="{$addClassificationBanner}"/>Add Classification Banner</a></li>
		<li><img src="{$IMAGES_PATH}icon-view1.gif" /><a href="{$bannerManager}"/>View Site Banner</a></li>
		<li><img src="{$IMAGES_PATH}icon-view1.gif" /><a href="{$ClassificationBannerManager}"/>View Classification Banner</a></li>
		<li><img src="{$IMAGES_PATH}icon-search1.gif" /><a href="{$searchClassificationBanner}"/>Search Classification Banner</a></li>		
		<li><img src="{$IMAGES_PATH}icon-search1.gif" /><a href="{$classificationBannerReport}"/>Classification Banner Report</a></li>				
		<li><img src="{$IMAGES_PATH}icon-logout.gif" /><a href="{$logout_url}">Logout</a></li>
  
   {elseif ($do3 eq 'Vertical' AND $action3 eq 'viewVertical')||($do3 eq 'Vertical' AND $action3 eq 'verticalAddFormShow')||($do3 eq 'Vertical' AND $action3 eq 'edit')||($do3 eq 'Vertical' AND $action3 eq 'editAddData')||($do3 eq 'Vertical' AND $action3 eq 'verticalAddData')||($do3 eq 'Vertical' AND $action3 eq 'delete')||($do3 eq 'Vertical' AND $action3 eq 'searchVertical')||($do3 eq 'Vertical' AND $action3 eq 'searchVerticals')}
   
      <li><img src="{$IMAGES_PATH}icon-home.gif" /><a href="{$home_url}">Home</a></li>
	  <li><img src="{$IMAGES_PATH}icon-add4.gif" /><a href="{$verticalAddFormShow}">Add Vertical</a></li>
      <li><img src="{$IMAGES_PATH}icon-view1.gif" /><a href="{$viewVertical}">View Vertical </a></li>
	  <li><img src="{$IMAGES_PATH}icon-search1.gif" /><a href="{$searchVertical}">Search Vertical </a></li>
	  <li><img src="{$IMAGES_PATH}icon-logout.gif" /><a href="{$logout_url}">Logout</a></li>
	 
	 {elseif ($do3 eq 'Group' AND $action3 eq 'viewGroup')||($do3 eq 'Group' AND $action3 eq 'groupAddFormShow')||($do3 eq 'Group' AND $action3 eq 'edit')||($do3 eq 'Group' AND $action3 eq 'editAddData')||($do3 eq 'Group' AND $action3 eq 'groupAddData')||($do3 eq 'Group' AND $action3 eq 'delete')||($do3 eq 'Group' AND $action3 eq 'searchGroup')||($do3 eq 'Group' AND $action3 eq 'searchGroups') ||($do3 eq 'Group' AND $action3 eq 'editAddClassificationData') ||($do3 eq 'Group' AND $action3 eq 'edit_classification')}
   
      <li><img src="{$IMAGES_PATH}icon-home.gif" /><a href="{$home_url}">Home</a></li>
	  <li><img src="{$IMAGES_PATH}icon-add4.gif" /><a href="{$groupAddFormShow}">Add Vertical</a></li>
      <li><img src="{$IMAGES_PATH}icon-view1.gif" /><a href="{$viewGroup}">View Verticals </a></li>
	  <li><img src="{$IMAGES_PATH}icon-search1.gif" /><a href="{$searchGroup}">Search Verticals </a></li>
	  <li><img src="{$IMAGES_PATH}icon-logout.gif" /><a href="{$logout_url}">Logout</a></li>  		
  
   {elseif ($do eq 'Admin' AND $act eq 'rankReport') || ($do eq 'Admin' AND $act eq 'rankRate')}
   
      <li><img src="{$IMAGES_PATH}icon-home.gif" /><a href="{$home_url}">Home</a></li>
	  <li><img src="{$IMAGES_PATH}icon-view1.gif" /><a href="{$rankReport}">View Report</a></li>
      <li><img src="{$IMAGES_PATH}icon-view1.gif" /><a href="{$rankRate}">View Rate</a></li>
	  <li><img src="{$IMAGES_PATH}icon-logout.gif" /><a href="{$logout_url}">Logout</a></li> 		
 
  
  {elseif ($do eq 'Admin' AND $act eq 'min_visits')}
   
      <li><img src="{$IMAGES_PATH}icon-home.gif" /><a href="{$home_url}">Home</a></li>
	   <li><img src="{$IMAGES_PATH}icon-manage1.gif" /><a href="{$min_visits1}">Listings Under Minimum Visits</a></li>
	  <li><img src="{$IMAGES_PATH}icon-logout.gif" /><a href="{$logout_url}">Logout</a></li>
	  
   {elseif ($do eq 'Admin' AND $act eq 'site_config_manager')}
   
      <li><img src="{$IMAGES_PATH}icon-home.gif" /><a href="{$home_url}">Home</a></li>
	   <li><img src="{$IMAGES_PATH}icon-manage13.gif" /><a href="{$site_config_manager1}">Site Configuration Manager</a></li>
	  <li><img src="{$IMAGES_PATH}icon-logout.gif" /><a href="{$logout_url}">Logout</a></li>
	  
	    {elseif ($smarty.get.do eq 'Admin' AND $smarty.get.action eq 'keyword_manager') || ($smarty.get.do eq 'Admin' AND $smarty.get.action eq 'add_business_keyword')|| ($smarty.get.do eq 'Admin' AND $smarty.get.action eq 'add_business_keyword_value')|| ($smarty.get.do eq 'Admin' AND $smarty.get.action eq 'delete_business_keyword')}
   
      <li><img src="{$IMAGES_PATH}icon-home.gif" /><a href="{$home_url}">Home</a></li>
	   <li><img src="{$IMAGES_PATH}icon-manage13.gif" /><a href="{$add_business_keyword}">Add Keyword</a></li>
	   <li><img src="{$IMAGES_PATH}icon-manage7.gif" /><a href="{$keyword_manager}">View Keyword</a></li>
	  <li><img src="{$IMAGES_PATH}icon-logout.gif" /><a href="{$logout_url}">Logout</a></li>
	  {elseif ($smarty.get.do eq 'Listing' AND ($smarty.get.action eq 'report' || $smarty.get.action eq 'reportMail')) }
   
      <li><img src="{$IMAGES_PATH}icon-home.gif" /><a href="{$home_url}">Home</a></li>
	   <li><img src="{$IMAGES_PATH}icon-manage13.gif" /><a href="{$add_business_keyword}">Add Keyword</a></li>
	   <li><img src="{$IMAGES_PATH}icon-manage7.gif" /><a href="{$keyword_manager}">View Keyword</a></li>
	  <li><img src="{$IMAGES_PATH}icon-logout.gif" /><a href="{$logout_url}">Logout</a></li>
	  
	  	    {elseif ($smarty.get.do eq 'Admin' AND $smarty.get.action eq 'brand_manager') || ($smarty.get.do eq 'Admin' AND $smarty.get.action eq 'delete_business_brand')|| ($smarty.get.do eq 'Admin' AND $smarty.get.action eq 'add_business_brand')|| ($smarty.get.do eq 'Admin' AND $smarty.get.action eq 'add_business_brand_value')}
   
      <li><img src="{$IMAGES_PATH}icon-home.gif" /><a href="{$home_url}">Home</a></li>
	   <li><img src="{$IMAGES_PATH}icon-manage13.gif" /><a href="{$add_business_brand}">Add Brand</a></li>
	   <li><img src="{$IMAGES_PATH}icon-manage7.gif" /><a href="{$brand_manager}">View Brand</a></li>
	  <li><img src="{$IMAGES_PATH}icon-logout.gif" /><a href="{$logout_url}">Logout</a></li>
	  
	  
	  {elseif ($smarty.get.do eq 'Admin' AND $smarty.get.action eq 'service_manager') || ($smarty.get.do eq 'Admin' AND $smarty.get.action eq 'add_business_service') ||($smarty.get.do eq 'Admin' AND $smarty.get.action eq 'add_business_service_value')||($smarty.get.do eq 'Admin' AND $smarty.get.action eq 'delete_business_service')}
   
		<li><img src="{$IMAGES_PATH}icon-home.gif" /><a href="{$home_url}">Home</a></li>
		<li><img src="{$IMAGES_PATH}icon-manage13.gif" /><a href="{$add_business_service}">Add Service</a></li>
		<li><img src="{$IMAGES_PATH}icon-manage7.gif" /><a href="{$service_manager}">View Service</a></li>
		<li><img src="{$IMAGES_PATH}icon-logout.gif" /><a href="{$logout_url}">Logout</a></li>
	  
	  
	  	  	    {elseif ($smarty.get.do eq 'Admin' AND $smarty.get.action eq 'contactDetails') || ($smarty.get.do eq 'Admin' AND $smarty.get.action eq 'delete_contact_us_details')}
   
      <li><img src="{$IMAGES_PATH}icon-home.gif" /><a href="{$home_url}">Home</a></li>
	   <li><img src="{$IMAGES_PATH}icon-manage13.gif" /><a href="{$contactDetails}">Mailing Data</a></li>
	  <li><img src="{$IMAGES_PATH}icon-logout.gif" /><a href="{$logout_url}">Logout</a></li>	  		
  {/if}   
		
</ul>
</div>


