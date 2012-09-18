<?php
class ListingControl extends MainControl {

	private $listingFacade;
	private $searchRefineFacade;
	private $defaultLocation = 'All States';

	public function __construct($request)
	{
		//$_GET['Search2'] = (!empty($_GET['Search2']))? $this->splitState($_GET['Search2']) : NULL;
		$this->listingFacade       = new ListingFacade($GLOBALS['conn'], $request);
		$this->url                 = new UrlFacade($GLOBALS['conn'], $request);
		$this->cf                  = new ClassificationFacade($GLOBALS['conn'], $request);
		$this->searchRefineFacade  = new SearchRefineFacade($GLOBALS['conn'], $request);
		$this->page = new MainPage();
		parent::__construct($request);


	}/* END __construct */


	/**
	 *  googleMapView
	 *
	 *  Get the map result from Google Map
	 */
	public function googleMapView()
	{
		$do         			= $_GET['do'];
		$action					= $_GET['action'];
		$this->page->assign("do",$do);
		$this->page->assign("action",$action);
		$this->listingFacade->popularPageCount("4");
		$rank 		= (!empty($_GET['rank']))?$_GET['rank']:NULL;
		$map = $this->listingFacade->googleMapViewResult($_GET);

		$details = $this->listingFacade->getBusinessDetails($_GET);
		$this->page->pageTitle 			= "Pink Pages &shy; ".$details[0]['business_name']." ";
		$this->page->assign("business_details",$details[0]);
		$this->page->assign("rank",$rank);
		$this->page->assign("name",$_GET['name']);
		$this->page->assign("Street",$_GET['Street']);
		$this->page->assign("Suburb",$_GET['Suburb']);
		$this->page->assign("Postcode",$_GET['Postcode']);
		$this->page->assign("State",$_GET['State']);
		$this->page->assign("map_header_js", $map->getHeaderJS());
		$this->page->assign("map_js", $map->getMapJS());
		$this->page->assign("onload_js", $map->getOnLoad());
		$this->page->assign("map_view_js", $map->getMap());
		$this->page->getPage('google_map_view.tpl');
	}/* END googleMapView */


	/**
	 *  mapSearch
	 *
	 *  Show map result
	 */
	public function mapSearch()
	{
		$do            					= $_GET['do'];
		$action							= $_GET['action'];
		$this->listingFacade->popularPageCount("3");

		$bannerArray=$this->listingFacade->getBanner("6");
		$this->page->assign("bannerArray",$bannerArray);

		$this->page->addJsFile("bsn.AutoSuggest_2.1.3.js");
		$this->page->addCssStyle("autosuggest_inquisitor.css");
		$this->page->assign("home",$this->request->createURL("Affiliate", "showhomePageAffiliate"));
		$this->page->assign("mapSearch",$this->request->createURL("Listing", "mapSearch"));
		$this->page->assign("searchStreetForm",$this->request->createURL("Listing", "searchStreetForm"));
		$this->page->assign("classifiedSearch",$this->request->createURL("Index", "home"));
		$this->page->assign("viewdemo",$this->request->createURL("Listing", "demoAddListing"));
		$this->page->assign("action",$action);
		$this->page->getPage('map_search.tpl');
	}/* END mapSearch */


	/**
	 *  browseCategory
	 *
	 *  Get the List details according to the search condition
	 */
	public function browseCategory()
	{
		$do         				= $_GET['do'];
		$action						= $_GET['action'];
		$this->page->assign("do",$do);
		$this->page->assign("action",$action);
		$this->page->assign("home",$this->request->createURL("Affiliate", "showhomePageAffiliate"));
		$this->listingFacade->popularPageCount("9");
		$bannerArray=$this->listingFacade->getBanner("7");
		$this->page->assign("bannerArray",$bannerArray);

		$bannerArray1=$this->listingFacade->getBanner("8");
		$this->page->assign("bannerArray1",$bannerArray1);
		$res = $this->listingFacade->browseCategoryResult($_GET);

		$this->page->assign("values", $res);
		/*$this->page->assign("values", $res['blogs']);
		 $this->page->assign("paging", $res['paging']);*/
		$searchLetter = (!empty($_GET['search']))?$_GET['search']:NULL;
		if($searchLetter == '')
		{
			$searchLetter = 'a';
		}
		$alphabets = array('a'=>'A',
		'b'=>'B',
		'c'=>'C',
		'd'=>'D',
		'e'=>'E',
		'f'=>'F',
		'g'=>'G',
		'h'=>'H',
		'i'=>'I',
		'j'=>'J',
		'k'=>'K',
		'l'=>'L',
		'm'=>'M',
		'n'=>'N',
		'o'=>'O',
		'p'=>'P',
		'q'=>'Q',
		'r'=>'R',
		's'=>'S',
		't'=>'T',
		'u'=>'U',
		'v'=>'V',
		'w'=>'W',
		'x'=>'X',
		'y'=>'Y',
		'z'=>'Z');
		$alpha_links = array();
		$i=0;
		foreach ($alphabets as $k=>$v) {
			$alpha_links[$i]["link"] = $this->request->createURL("Listing", "browseCategory", "search=$k");
			$alpha_links[$i]["text"] = $v;
			$i++;
		}

		$this->page->assign("alpha_links",$alpha_links);
		$this->page->assign("searchLetter",strtoupper($searchLetter));
		$this->page->getPage('browse_category_search.tpl');
	}/* END browseCategory */



	/**
	 *  mapSearchResult
	 *
	 *  Get the map result from Google Map
	 */
	public function mapSearchResult()
	{
		$do            					= $_GET['do'];
		$action							= $_GET['action'];
		$this->page->assign("do",$do);
		$this->page->assign("action",$action);
		$this->listingFacade->searchConut();
		$this->listingFacade->popularPageCount("4");
		$this->page->assign("home",$this->request->createURL("Affiliate", "showhomePageAffiliate"));
		$action		= $_GET['action'];
		$result = $this->listingFacade->mapSearchResult($this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"),$_GET);
		$Count	=count($result['map']->_markers);
		$map = $result['map'];

		$this->page->addJsFile("bsn.AutoSuggest_2.1.3.js");
		$this->page->addCssStyle("autosuggest_inquisitor.css");

		$this->page->assign("keyword",$_GET['Search1']);
		$this->page->assign("location",$_GET['Search2']);

		$this->page->assign("Count",$Count);
		$this->page->assign("Count",$Count);
		$this->page->assign("value",$map->_markers);
		$this->page->assign("action",$action);
		$this->page->assign("map_header_js", $map->getHeaderJS());
		$this->page->assign("map_js", $map->getMapJS());
		$this->page->assign("onload_js", $map->getOnLoad());
		$this->page->assign("map_view_js", $map->getMap());
		$this->page->assign("map_sidebar", $map->getSideBar());
		$this->page->assign("paging", $result['paging']);
		$this->page->getPage('map_search_result.tpl');
	}/* END mapSearchResult */



	/**
	 *  viewList
	 *
	 *  Get the map result from Google Map
	 */
	public function viewList()
	{
		$do									= $_GET['do'];
		$action								= $_GET['action'];
		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$this->listingFacade->popularPageCount("22");
		$this->page->assign("action",$this->request->createURL("Listing", "listingAddition"));
		$this->page->assign("back",$this->request->createURL("Business", "showhomePageBusiness"));
		$this->page->assign("login_url",$this->request->createURL("Business", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Business", "doLogout"));
		$this->page->assign("edit_url",$this->request->createURL("Listing", "Edit"));
		$this->page->assign("change_password",$this->request->createURL("Business", "changePassword"));
		$this->page->assign("delete",$this->request->createURL("Listing", "delete","ID"));
		$this->page->assign("listing",$this->request->createURL("Listing", "addListing"));
		$this->page->assign("edit_classification",$this->request->createURL("Listing", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("Listing", "rankBusiness"));
		$this->page->assign("edit",$this->request->createURL("Business", "Edit","ID"));
		$res1=$this->listingFacade->viewfetchDetails($this->request->getAttribute("fr"));
		$Count=count($res1['listings']);
		$this->page->assign("Count",$Count);
		$this->page->assign("values",$res1['listings']);
		$this->page->assign("paging", $res1['paging']);

		$this->page->getPage("listshow.tpl");
	}/* END viewList */



	/**
	 *  search
	 *
	 *  List the details of the search according to what we search for
	 */
	public function search()
	{

		$this->page->pageTitle 			= "Pink Pages &shy; Search results for [".$_GET['Search1']."] ";
		$do         				= $_GET['do'];
		$action						= $_GET['action'];
		$this->page->assign("do",$do);
		$this->page->assign("action",$action);

		$bannerArray2=$this->listingFacade->getBanner("1");
		$this->page->assign("bannerArray2",$bannerArray2);
			
		$bannerArray3=$this->listingFacade->getBanner("9");
		$this->page->assign("bannerArray3",$bannerArray3);
		$location =$search2 = (isset($_GET['Search2']) && !empty($_GET['Search2']))?$_GET['Search2']:"";
		$this->page->assign("location",$location);

		//$keywordArray=$this->listingFacade->fetchKeyword();
		//$this->page->assign("keywordArray",$keywordArray);


		//$brandArray=$this->listingFacade->fetchBrands();
		//$this->page->assign("brandArray",$brandArray);


		$this->page->assign("SearchAction",$this->request->createURL("Listing", "search"));
		$this->listingFacade->searchConut();
		$this->listingFacade->popularPageCount("2");
			
		$this->page->addJsFile("bsn.AutoSuggest_2.1.3.js");
		$this->page->addCssStyle("autosuggest_inquisitor.css");
		$this->page->assign("keyword",$_GET['Search1']);
			
		$hrs = array();
		for($i=1;$i<=24;$i++){

			$hrs[] = $i;

		}
		$this->page->assign("hrs",$hrs);
			
		$this->page->assign("home",$this->request->createURL("Affiliate", "showhomePageAffiliate"));
			
		$res 			=$this->listingFacade->SearchResult($this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"),$_GET);
			
		//pre($res);
		$selectArray = array('days'=>'',
						'fromHrs'=>'',
						'toHrs'=>'',
						'keyword'=>'',
						'brand'=>''
						);
						if(isset($_GET['days']))$selectArray['days'] 		= $_GET['days'];
						if(isset($_GET['fromHrs']))$selectArray['fromHrs'] 	= $_GET['fromHrs'];
						if(isset($_GET['toHrs']))$selectArray['toHrs'] 		= $_GET['toHrs'];
						if(isset($_GET['keyword']))$selectArray['keyword'] 	= $_GET['keyword'];
						if(isset($_GET['brand']))$selectArray['brand'] 		= $_GET['brand'];
						$this->page->assign("selectArray",$selectArray);
							
							
						$state 			=(!empty($_GET['state']))?$_GET['state']:NULL;
						$state			=explode("__",$state);

						$shirename 		=(!empty($_GET['shirename']))?$_GET['shirename']:NULL;
						$shiretown 		=(!empty($_GET['shiretown']))?$_GET['shiretown']:NULL;
						$shirename		=explode("__",$shirename);
						$shiretownval	=explode("__",$shiretown);
							
							
							
						$SearchOption = (!empty($_GET['SearchOption']))?$_GET['SearchOption']:NULL;
						$this->page->assign("SearchOption",$SearchOption);

						$normalcount		= count($res['blogs']);
							
						$this->page->assign("normalcount",$normalcount);
						$this->page->assign("CountResult",$res['paging']['totalRecords']);
						$this->page->assign("values", $res['blogs']);
						$this->page->assign("paging", $res['paging']);
						$this->page->assign("state", $state[0]);
						$this->page->assign("shirename", $shirename[0]);
						$this->page->assign("shiretownval", $shiretownval[0]);
						$this->page->assign("searchValue1",$_GET['Search1']);
						$this->page->assign("searchValue2",$search2);
						$sortby			= (!empty($_GET['sortby']))?$_GET['sortby']:NULL;
						$this->page->assign("sortby",$sortby);

						$this->page->assign("state_change", "javascript:window.location='".$this->request->createURL("Listing", "search", "SearchOption={$this->request->getAttribute('SearchOption')}&Search1={$this->request->getAttribute('Search1')}&Search2={$this->request->getAttribute('Search2')}&sortby={$sortby}&state='")."+this.value");

						$this->page->assign("region_change", "javascript:window.location='".$this->request->createURL("Listing", "search", "SearchOption={$this->request->getAttribute('SearchOption')}&Search1={$this->request->getAttribute('Search1')}&Search2={$this->request->getAttribute('Search2')}&state={$this->request->getAttribute('state')}&sortby={$sortby}&shirename='")."+this.value");

						$this->page->assign("suburb_change", "javascript:window.location='".$this->request->createURL("Listing", "search", "SearchOption={$this->request->getAttribute('SearchOption')}&Search1={$this->request->getAttribute('Search1')}&Search2={$this->request->getAttribute('Search2')}&state={$this->request->getAttribute('state')}&shirename={$this->request->getAttribute('shirename')}&sortby={$sortby}&shiretown='")."+this.value");

						$this->page->assign("detail_search", "javascript:window.location='".$this->request->createURL("Listing", "search", "SearchOption={$this->request->getAttribute('SearchOption')}&Search1={$this->request->getAttribute('Search1')}&Search2={$this->request->getAttribute('Search2')}&state={$this->request->getAttribute('state')}&shirename={$this->request->getAttribute('shirename')}&shiretown={$this->request->getAttribute('shiretown')}&sortby='")."+this.value");
							
						$this->page->assign("contactUs",$this->request->createURL("Listing", "contactUs","ID"));
						$this->page->getPage('inner_search.tpl');

	}

	/**
	 *
	 * Remove the - StateName portion of the Search Query, eg ' - NSW'
	 *
	 */
	private function removeState($search2) {
		$params = explode(' - ', $search2);
		return $params[0];
	}

	private function splitState($search2) {
		$params = explode(' - ', $search2);
		if(count($params) > 1) {
			$_GET['State'] = $params[1];
		}
		return $params[0];
	}


	/**
	 *  searchKeyword
	 *
	 *  Search for the keyword
	 */
	function searchKeyword()
	{
        //dev_log::cur_url();
		$defaultLocation = $this->defaultLocation;
         
		$Search2							= (!empty($_GET['Search2'])) ? $_GET['Search2'] : $defaultLocation;
			
		if($Search2 != '')
		{
			$this->page->pageTitle 			= "Pink Pages &shy; Search results for ".ucwords(strtolower($_GET['Search1']))." in ".ucwords(strtolower($_GET['Search2']));
		}else{
			$this->page->pageTitle 			= "Pink Pages &shy; Search results for ".ucwords(strtolower($_GET['Search1']));
		}


		$do         						= $_GET['do'];
		$action								= $_GET['action'];
		$this->page->assign("do",$do);
		$this->page->assign("action",$action);
		$this->page->assign("home",$this->request->createURL("Affiliate", "showhomePageAffiliate"));
		$this->page->assign("searchStreetForm",$this->request->createURL("Listing", "searchStreetForm"));
		if(REWRITE_URL){
			$this->page->assign("business_name_search",$this->request->createURL("Listing", "search","t=tab&SearchOption=1&Search1=".$_GET['Search1']));
		} else {
			$this->page->assign("business_name_search",$this->request->createURL("Listing", "search").'&t=tab&SearchOption=1&Search1='.$_GET['Search1']);
		}
		$total_recs = 0;

		$this->page->addJsFile("bsn.AutoSuggest_2.1.3.js");
		$this->page->addCssStyle("autosuggest_inquisitor.css");

		$location = GeneralUtils::handle_input($_GET['Search2']);
		$location = ($location=="") ? $defaultLocation : $location;
		$location_tpl = (empty($location))? $defaultLocation : $location;
		$this->page->assign("location",$location_tpl);

		$exact = (isset($_GET['exact']) && !empty($_GET['exact']))?$_GET['exact']:0;
		if(isset($_GET['Search1']) && !empty($_GET['Search1'])) {

			$keyword = GeneralUtils::handle_input($_GET['Search1']);
			$this->page->assign("keyword",$keyword);
				
			//resolve classification
			$classification_ids = $this->listingFacade->resolveClassification($keyword);
			
			if($classification_ids) {
				
				//print_r($classification_ids);
				//die();
				//Create a database entry of the search parameters. This may be a temporary fixture;
				$this->listingFacade->successfulSearch($_GET,"keyword");
				//Gather all the individual listings based on the information gathered
				if($location != $defaultLocation){
					dev_log::write("Getting classies for [$location] [".var_export($classification_ids,true). "]");
					$classifications = $this->listingFacade->getClassificationCountByLocation($location, $classification_ids, $this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"));
				} else {
					//dev_log::write("Getting classies for [$location]");
					$classifications = $this->listingFacade->getClassificationCountByAlpha($location, $classification_ids, $this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"));
				}

				//Perform an All Sydney Region search if an exact region match cannot be found
				if(!$classifications && !$exact) {
					$regions = $this->listingFacade->suburbAndRegionList($keyword, $location);
					if($regions) {
						$this->page->assign('all_regions', $regions);
						$this->page->getPage('keyword_intermediate_search.tpl');
						exit();
					}
				}
				
				dev_log::write("Classifications = " . var_export($classifications,true));
				
				if($classifications) {
					//dev_log::write("Listing::searchKeyword classifications = ".var_export($classifications, true));
					$total_recs = $classifications['total_recs'];
					$this->page->assign("values",$classifications['classifications']);
					if(isset($classifications['ambiguous']) && $classifications['ambiguous']) {
						$this->page->assign("ambiguous",1);
						$this->page->assign("ambg_region_name",$classifications['ambg_region_name']);
						$this->page->assign("ambg_suburb_name",$classifications['ambg_suburb_name']);
						$this->page->assign("suburb_link",$this->request->createNaturalURL("Listing", "searchKeyword", "Search1=$keyword&Search2=".urlencode($classifications['ambg_suburb_name'])."&c=s"));
						$region_link = $this->request->createNaturalURL("Listing", "searchKeyword", "Search1=$keyword&Search2=".urlencode($classifications['ambg_region_name'])."&ambg_suburb=".urlencode($classifications['ambg_suburb_name'])."&c=r");
						$this->page->assign("region_link",$region_link);
					
					    if (!isset($_GET['c'])) { // 20120427 HACK FIX FOR REGION/SUBURB SWAP ON RESULTS PAGE - HEREWARD
					    	header("Location: $region_link");
					    }
					}
				}
			}else{
				$this->listingFacade->failedSearch($_GET,"keyword");
			}
			$alphabets = array('a'=>'A',
		'b'=>'B',
		'c'=>'C',
		'd'=>'D',
		'e'=>'E',
		'f'=>'F',
		'g'=>'G',
		'h'=>'H',
		'i'=>'I',
		'j'=>'J',
		'k'=>'K',
		'l'=>'L',
		'm'=>'M',
		'n'=>'N',
		'o'=>'O',
		'p'=>'P',
		'q'=>'Q',
		'r'=>'R',
		's'=>'S',
		't'=>'T',
		'u'=>'U',
		'v'=>'V',
		'w'=>'W',
		'x'=>'X',
		'y'=>'Y',
		'z'=>'Z');
			$alpha_links = array();
			$i=0;
			foreach ($alphabets as $k=>$v) {
				$alpha_links[$i]["link"] = $this->request->createURL("Listing", "browseCategory", "search=$k");
				$alpha_links[$i]["text"] = $v;
				$i++;
			}

			$this->page->assign("alpha_links",$alpha_links);
			$this->page->assign('total_recs', $total_recs);
			$this->page->getPage('key_search.tpl');
		}
		else {
			prexit("No keyword selected");
		}
	}


	/**
	 *  searchStreet
	 *
	 *  Search for the Street.
	 */
	public function searchStreet()
	{
		$this->page->pageTitle 			= "Pink Pages &shy; Search results for businesses in [".$_GET['Search1']."] , [".$_GET['Search2']."]";
		$do         						= $_GET['do'];
		$action								= $_GET['action'];

		$this->page->assign("do",$do);
		$this->page->assign("action",$action);

		$location 				= isset($_GET['Search2']) && !empty($_GET['Search2']);
		$location 				= $this->removeState(GeneralUtils::handle_input($_GET['Search2']));
		$this->page->assign("location",$location);

		$exact 					= (isset($_GET['exact']) && !empty($_GET['exact']))?$_GET['exact']:0;
		if(isset($_GET['Search1']) && !empty($_GET['Search1'])) {
			$keyword 				= GeneralUtils::handle_input($_GET['Search1']);
			$regions 				= $this->listingFacade->streetSearchList($keyword, $location);
			if($regions){
				$this->page->assign('all_regions', $regions);
				//Create a database entry of the search parameters. This may be a temporary fixture;
				$this->listingFacade->successfulSearch($_GET,"Street Search");
			} else {
				$this->listingFacade->failedSearch($_GET,"Street Search");
			}
		}
		$this->page->getPage('street_intermediate_search.tpl');
	}
	/**
	 *  searchStreet
	 *
	 *  Search for the Street.
	 */
	public function searchStreetForm()
	{
		$do         						= $_GET['do'];
		$action								= $_GET['action'];

		$this->page->assign("do",$do);
		$this->page->assign("action",$action);
		$bannerArray=$this->listingFacade->getBanner("10");
		$this->page->assign("bannerArray",$bannerArray);
		$this->page->addJsFile("bsn.AutoSuggest_2.1.3.js");
		$this->page->addCssStyle("autosuggest_inquisitor.css");
		$this->page->assign("classifiedSearch",$this->request->createURL("Index", "home"));
		$this->page->assign("viewdemo",$this->request->createURL("Listing", "demoAddListing"));
		$this->page->getPage('street_search_form.tpl');
	}

	/**
	 *  searchStreet
	 *
	 *  Search for the Street.
	 */
	public function businessNameSearch()
	{
		$do         						= $_GET['do'];
		$action								= $_GET['action'];

		$this->page->assign("do",$do);
		$this->page->assign("action",$action);
		$this->page->addJsFile("bsn.AutoSuggest_2.1.3.js");
		$this->page->addCssStyle("autosuggest_inquisitor.css");

		$bannerArray=$this->listingFacade->getBanner("11");
		$this->page->assign("bannerArray",$bannerArray);
		$this->page->assign("searchStreetForm",$this->request->createURL("Listing", "searchStreetForm"));
		$this->page->assign("classifiedSearch",$this->request->createURL("Index", "home"));
		$this->page->assign("viewdemo",$this->request->createURL("Listing", "demoAddListing"));
		$this->page->getPage('business_name_search.tpl');
	}




	/**
	 *  searchStreetBusiness
	 *
	 *  Search for the Street Business.
	 */
	public function searchStreetBusiness()
	{

		$this->page->pageTitle 			= "Pink Pages &shy; Search results for businesses in [".$_GET['Search1']."] , [".$_GET['Search2']."]";
		$this->page->addJsFile("bsn.AutoSuggest_2.1.3.js");
		$this->page->addCssStyle("autosuggest_inquisitor.css");


		$this->page->assign("contactUs",$this->request->createURL("Listing", "contactUs","ID"));
		$location 				= isset($_GET['Search2']) && !empty($_GET['Search2']);
		$location 				= GeneralUtils::handle_input($_GET['Search2']);
		$this->page->assign("location",$location);
		$exact 					= (isset($_GET['exact']) && !empty($_GET['exact']))?$_GET['exact']:0;

		$businessArray 			= $this->listingFacade->streetBusinessSearch($_GET,$this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"));

		$count		= count($businessArray['listings']);

		$this->page->assign("businessArray",$businessArray['listings']);
		$this->page->assign("paging",$businessArray['paging']);
		$this->page->assign("countlow",$count);
		$this->page->assign("count",$businessArray['paging']['totalRecords']);
		$this->page->getPage('street_search.tpl');
	}

	function searchKeyword_gaushul()
	{
		$do         			= $_GET['do'];
		$action					= $_GET['action'];
		$this->page->assign("do",$do);
		$this->page->assign("action",$action);

		$bannerArray			= $this->listingFacade->getBanner("2");
		$this->page->assign("bannerArray",$bannerArray);

		$bannerArray1			= $this->listingFacade->getBanner("3");
		$this->page->assign("bannerArray1",$bannerArray1);

		$this->listingFacade->searchConut();
		$this->listingFacade->popularPageCount("2");
			
		$tempSearchResult 		= $this->listingFacade->tempSearchKeyword($_GET);

		$tempmsg 				= (!empty($tempSearchResult['message']))?$tempSearchResult['message']:0;
		if($tempmsg != '0')
		{
			$msg	='0';
			$this->page->assign("msg","$msg");
			$this->page->getPage('keyword_intermediate_search.tpl');
		}else{
			$tempResult 	= (!empty($tempSearchResult['0']['count_localclassification_name']))?$tempSearchResult['0']['count_localclassification_name']:NULL;
			if($tempResult == '' && count($tempSearchResult) > '0')
			{

				$finalArray 	= array();

				foreach($tempSearchResult as $key1=>$val1){
						
					$j = 0;
					foreach($finalArray as $key2=>$val2){
							
						if($key2==$val1['shirename_id']){
								
							if(!empty($finalArray[$val1['shirename_id']]['suburb'])){
								$array 				= array_merge($finalArray[$val1['shirename_id']]['suburb'], array($val1['shiretown_id']=>$val1['shiretown_townname']));

							}else{
								$array 				= array($val1['shiretown_id']=>$val1['shiretown_townname']);
							}
							$finalArray[$val1['shirename_id']]['suburb'] = $array;
							$j=1;
						}
					}
					if($j==0){
							
						$finalArray[$val1['shirename_id']]['region'] = $val1['shirename_shirename'];
						$array = array($val1['shiretown_id']=>$val1['shiretown_townname']);
						$finalArray[$val1['shirename_id']]['suburb'] = $array;
							
					}
				}

				$this->page->assign("finalArray",$finalArray);
				//$searchKeywordResult = $this->listingFacade->searchKeyword($this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"),$_GET);
					
				$this->page->assign("Region", "javascript:window.location='".$this->request->createURL("Listing", "getRegion", "SearchOption={$this->request->getAttribute('SearchOption')}&Search1={$this->request->getAttribute('Search1')}&Search2={$this->request->getAttribute('Search2')}&Region"));

				//Remove &Suburb from the end of the URL string
				//$this->page->assign("Suburb", "javascript:window.location='".$this->request->createURL("Listing", "getSuburbResult", "SearchOption={$this->request->getAttribute('SearchOption')}&Search1={$this->request->getAttribute('Search1')}&Search2={$this->request->getAttribute('Search2')}&Suburb"));
				$this->page->assign("Suburb", "javascript:window.location='".$this->request->createURL("Listing", "getSuburbResult", "SearchOption={$this->request->getAttribute('SearchOption')}&Search1={$this->request->getAttribute('Search1')}&Search2={$this->request->getAttribute('Search2')}"));
					
				$this->page->getPage('keyword_intermediate_search.tpl');
			}else if(count($tempSearchResult) == 0){
				$msg1				= '2';
				$this->page->assign("msg1","$msg1");
				$this->page->getPage('keyword_intermediate_search.tpl');
			}else{
				$msg				= '1';
				$this->page->assign("msg","$msg");
					
				$this->page->assign("values",$tempSearchResult);
				$this->page->getPage('key_search.tpl');

			}
		}
	}


	/**
	 *  getRegion
	 *
	 *  fetch the region details.
	 */
	function getRegion()
	{
		$do         			= $_GET['do'];
		$action					= $_GET['action'];
		$this->page->assign("do",$do);
		$this->page->assign("action",$action);
		$this->page->assign("home",$this->request->createURL("Affiliate", "showhomePageAffiliate"));

		$getRegionResult 		= $this->listingFacade->getRegion($this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"),$_GET);

		if(count($getRegionResult) == '0')
		{
			$msg					= '3';
			$this->page->assign("msg","$msg");
		}else{
			$msg5					= '5';
			$this->page->assign("msg5","$msg5");
		}
		$this->page->assign("values",$getRegionResult);
		$this->page->getPage('key_search.tpl');
	}


	/**
	 *  getSuburbResult
	 *
	 *  fetch the suburb details.
	 */
	function getSuburbResult()
	{
		$do         			= $_GET['do'];
		$action					= $_GET['action'];
		$this->page->assign("do",$do);
		$this->page->assign("action",$action);

		$bannerArray			= $this->listingFacade->getBanner("4");
		$this->page->assign("bannerArray",$bannerArray);

		$bannerArray1			= $this->listingFacade->getBanner("5");
		$this->page->assign("bannerArray1",$bannerArray1);

		$getSuburbResult 		= $this->listingFacade->getSuburbResult($this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"),$_GET);


		if(count($getSuburbResult) == '0')
		{
			$msg					= '3';
			$this->page->assign("msg","$msg");
		}else{
			$msg5					= '5';
			$this->page->assign("msg5","$msg5");
		}

		$this->page->assign("values",$getSuburbResult);
		$this->page->getPage('key_search.tpl');
	}/* END search */


	function pull_keyword_from_referer_pp() {
		$referer = (isset($_SERVER['HTTP_REFERER']))?$_SERVER['HTTP_REFERER']:'';
        dev_log::cur_url("pull_keyword_from_referer_pp | referer = $referer");
        $parsed = parse_url($referer);
        $segments = explode('/', $parsed['path']);
        $seg_count = count($segments);
        $keyword = '';

       // dev_log::cur_url("path = {$parsed['path']} | count = $seg_count");
        
        if ($seg_count == 4) {
        	$keyword = $segments[2];
        } elseif ($seg_count == 7) {
        	$keyword = $segments[7];
        }

        return $keyword;
	}
	
	
	
   public function redirect_free_listing() {
		$new_url = '';
		$host = $_SERVER['HTTP_HOST'];
		//$cur_url = dev_log::get_cur_url();
		//dev_log::write("---------------------------------");
		//dev_log::cur_url("Listing::redirect_free_listing");
		if (isset($_GET['url_alias'])) {
			$url_alias = $_GET['url_alias'];
			$id = $_GET['ID'];
			if (is_numeric($url_alias)) {
				dev_log::write("url_alias = $url_alias | I AM NUMERIC - REDIRECT ME!");				
				$new_url_alias = $this->listingFacade->get_url_alias($id);
				//dev_log::write("new_url_alias = $new_url_alias"); 
				
				$new_url = "http://$host/$new_url_alias/$id/listing";
				dev_log::write("REDIRECT URL = $new_url");
				
				if ($new_url_alias == $url_alias) {
					dev_log::write("OOOPS - looks like the URL ALIAS has not been updated. DO NOT RE-DIRECT!");
				} else {
					dev_log::write("Redirecting NOW!");
					header("Location: $new_url",TRUE,301);
				}
				
				
			}		
		}
	}

	/**
	 *  boldListing
	 *
	 *  Go to the page which is listed as paid
	 */
	public function boldListing()
	{
		//$referer_keyword =  $this->pull_keyword_from_referer_pp();
		
		dev_log::cur_url("Listing::boldListing");
		
		$this->redirect_free_listing();
		
		$do            	= $_GET['do'];
		$action			= $_GET['action'];
		$this->listingFacade->addDetails($_GET);
		
		$rank_count = $this->listingFacade->BusinessRankedCount();
		
        dev_log::write("rank count = $rank_count");
		
		
		
		$this->listingFacade->popularPageCount("5");
		$this->listingFacade->businessStats($_GET);
		$this->page->assign("contactUs",$this->request->createURL("Listing", "contactUs","ID=".$_GET['ID']."&act=".$_GET['action']));
		$map = $this->listingFacade->googleMapBusinessResult($_GET);

		$res = $this->listingFacade->boldListingResult($_GET);

		$classifications = explode(',', $this->listingFacade->getClassificationsByBusiness($_GET['ID']));
		$classifications_array = $this->listingFacade->getClassificationsByBusinessComplete($_GET['ID']); //getClassificationsByBusinessComplete
		$adult = 0;
		for ($i = 0; $i < count($classifications_array); $i++) {
			$raw = $classifications_array[$i]['localclassification_name'];
			if ($raw == 'ADULT ENTERTAINMENT' || $raw == 'ESCORTS') { $adult = 1; }
			$conv = trim($raw);
			$conv = urlencode($conv);
            $classifications_array[$i]['localclassification_url_encode'] = $conv;
		}
		
		
		
		//var_dump($classifications_array);

		//Added for drop downs
		$this->page->addJsFile("bsn.AutoSuggest_2.1.3.js");
		$this->page->addCssStyle("autosuggest_inquisitor.css");
		$this->page->addJsFile("search.js");

		$description=str_split($res[0][0]['business_description'],450);
		$this->page->assign("description",$description);
		$this->page->assign("values",$res[0]);
		$this->page->assign("values2",$res[1]);
		$this->page->assign("values3",$res[2]);
		$this->page->assign("values4",$res[3]);
		$this->page->assign("values5",$res[4]);
		$this->page->assign("values6",$res[5]);
		$this->page->assign("values7",$res[6]);
		$this->page->assign("values8",$res[7]);
		$this->page->assign("values9",$res[8]);
		$this->page->assign("values10",$res[9]);
		$this->page->assign("adult",$adult); 


		$classi   = ucwords(strtolower($res[5][0]['localclassification_name']));
		$location = ucwords(strtolower($res[0][0]['business_suburb']));
		
		$keyword = $this->resolve_keyword($classi,false,$location);
        $this->page->assign('keyword',$keyword);
        $this->page->assign('ads_per_block',2);
        $this->page->assign('ad_lines',3);
        $this->page->assign('rank_count',$rank_count);
        
        
		$this->page->assign("classi", $classi);
		$class_count= count($classifications_array);
		$this->page->assign("classifications", $classifications_array);
		$this->page->assign("class_count", $class_count);

		$this->page->assign("location", $location);

		//Adding Meta Tags
		$syns = $this->getSynonyms($res[8]);
		$metaSyns     = (isset($syns)) ? ", " . implode(", ", $syns) : "";
		$metaLocation = (!empty($location)) ? ", " . $location : "";
		$this->page->addMetaDescription($res[0][0]['business_name'] . $metaLocation . ", " .implode(", ", $classifications));
		//$this->page->addMetaKeywords($res[0][0]['business_name'] . $metaSyns);

		//Add Page Title
		
		/*
		if(getSession('suburb'))
		$this->page->pageTitle = $res[0][0]['business_name'] . "&#58; ".getSession('category')." in " . getSession('suburb') . ", " . getSession('region') . ", " . getSession('state') . "&#58; Pink Pages Australia";
		else if(getSession('region'))
		$this->page->pageTitle = $res[0][0]['business_name'] . "&#58; ".getSession('category')." in " . getSession('region') . ", " . getSession('state') . "&#58; Pink Pages Australia";
		else if($location)
		$this->page->pageTitle = $res[0][0]['business_name'] . "&#58; ". $classi . " in " . $location . "&#58; Pink Pages Australia";
		else
		$this->page->pageTitle = $res[0][0]['business_name'] . "&#58; Pink Pages Australia";
        */
		
		if($location) {
		    $this->page->pageTitle = $res[0][0]['business_name'] . "&#58; ". $classi . " in " . $location . "&#58; Pink Pages Australia";
		} else {
		    $this->page->pageTitle = $res[0][0]['business_name'] . "&#58; Pink Pages Australia";
		}
		
		$canonicalType = 'listing';
		$canonicalUrl  = $this->url->getCanonical($canonicalType, $_GET);
		if($canonicalUrl){
			$this->page->addCanonical(SITE_PATH . $canonicalUrl);
		}

		$this->page->addMetaTags("robots", "noodp,noydir");
			
		$this->page->assign("map_header_js", $map->getHeaderJS());
		$this->page->assign("map_js", $map->getMapJS());
		$this->page->assign("onload_js", $map->getOnLoad());
		$this->page->assign("map_view_js", $map->getMap());
		$this->page->getPage('bold_listing_search.tpl');
	}/* END boldListing */

	private function getSynonyms($synonyms){
		$syns = array();
		foreach($synonyms as $i => $syn){
			$syns[$i] = $syn['business_service_name'];
		}
		return $syns;
	}



	/**
	 *  keyCategorySearch
	 *
	 *  Get the result according to the Key Category Search
	 */
	public function keyCategorySearch()
	{
		$do            	= $_GET['do'];
		$action			= $_GET['action'];
		$this->page->assign("home",$this->request->createURL("Affiliate", "showhomePageAffiliate"));
		$res			= $this->listingFacade->keyCategorySearch($this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"),$_GET);
		$state			= (!empty($_GET['state']))?$_GET['state']:NULL;
		$state			= explode("__",$state);

		$shirename		= (!empty($_GET['shirename']))?$_GET['shirename']:NULL;
		$shiretown		= (!empty($_GET['shiretown']))?$_GET['shiretown']:NULL;
		$shirename  	= explode("__",$shirename);
		$shiretownval	= explode("__",$shiretown);
		$locationRes 	= $this->listingFacade->locationDisplay();

		$refineDisplay 	= $this->listingFacade->refineDisplay($_GET);

		$this->page->assign("refineDisplay",$refineDisplay);

		if(count($state)>0)
		{
			$shirenameRes 	= $this->listingFacade->regionDisplay($state);
			$this->page->assign("shirenameRes",$shirenameRes);
		}
		if(count($shirename)>0)
		{
			$shiretown 		= $this->listingFacade->shireTownDisplay($shirename);
			$this->page->assign("shiretown",$shiretown);
		}
		$this->page->assign("locationRes",$locationRes);

		$normalcount		= count($res['blogs']);


		$this->page->assign("normalcount",$normalcount);
		$this->page->assign("CountResult",$res['paging']['totalRecords']);
		$this->page->assign("values", $res['blogs']);
		$this->page->assign("paging", $res['paging']);
		$this->page->assign("searchValue1",$_GET['Search1']);
		$this->page->assign("searchValue2",$_GET['Search2']);
		$this->page->assign("SearchOption",$_GET['SearchOption']);
		$this->page->assign("state", $state[0]);
		$this->page->assign("shirename", $shirename[0]);
		$this->page->assign("shiretownval", $shiretownval[0]);
		$this->page->assign("sortby",$this->request->getAttribute('sortby'));

		$this->page->assign("state_change", "javascript:window.location='".$this->request->createURL("Listing", "keyCategorySearch", "SearchOption={$this->request->getAttribute('SearchOption')}&Search1={$this->request->getAttribute('Search1')}&Search2={$this->request->getAttribute('Search2')}&clasId={$this->request->getAttribute('clasId')}&state='")."+this.value");

		$this->page->assign("region_change", "javascript:window.location='".$this->request->createURL("Listing", "keyCategorySearch", "SearchOption={$this->request->getAttribute('SearchOption')}&Search1={$this->request->getAttribute('Search1')}&Search2={$this->request->getAttribute('Search2')}&clasId={$this->request->getAttribute('clasId')}&state={$this->request->getAttribute('state')}&shirename='")."+this.value");

		$this->page->assign("suburb_change", "javascript:window.location='".$this->request->createURL("Listing", "keyCategorySearch", "SearchOption={$this->request->getAttribute('SearchOption')}&Search1={$this->request->getAttribute('Search1')}&Search2={$this->request->getAttribute('Search2')}&clasId={$this->request->getAttribute('clasId')}&state={$this->request->getAttribute('state')}&shirename={$this->request->getAttribute('shirename')}&shiretown='")."+this.value");

		$this->page->assign("detail_search", "javascript:window.location='".$this->request->createURL("Listing", "keyCategorySearch", "SearchOption={$this->request->getAttribute('SearchOption')}&Search1={$this->request->getAttribute('Search1')}&Search2={$this->request->getAttribute('Search2')}&clasId={$this->request->getAttribute('clasId')}&state={$this->request->getAttribute('state')}&shirename={$this->request->getAttribute('shirename')}&shiretown={$this->request->getAttribute('shiretown')}&sortby='")."+this.value");

		$this->page->getPage('inner_search.tpl');
	}/* END keyCategorySearch */



	public function relatedClassLinks($class_id='',$shire_name='', $shire_town='', $state='', $passed_location='') {
		$defaultLocation = $this->defaultLocation;
		//$location = GeneralUtils::handle_input($_GET['Search2']);
		$location = '';
		
		if (isset($_GET['shire_town'])) {
			$location = $_GET['shire_town'];
		} elseif (isset($_GET['shire_name'])) {
			$location = $_GET['shire_name'];
		} elseif ($passed_location) {
			$location = $passed_location;
		}
		
		//$location = (isset($_GET['shire_town']))?$_GET['shire_town']:'';
		//$location = GeneralUtils::handle_input($_GET['shire_town']);
		$location = ($location=="") ? $defaultLocation : $location;
		//$location_tpl = (empty($location))? $defaultLocation : $location;
		//$this->page->assign("location",$location_tpl);
		
		$classifications = '';
		$classification_ids = array();
		//dev_log::write("relatedClassLinks class_id = ".$class_id);
		$classification_ids = $this->listingFacade->relatedClassLinks($class_id);
		
        $str = ($classification_ids)?implode(',', $classification_ids):'';
        
       // return $str;

		if($location != $defaultLocation){
		
			$classifications = $this->listingFacade->getClassificationCountByLocation($location, $classification_ids, $this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"));
		} else {
		
			$classifications = $this->listingFacade->getClassificationCountByAlpha($location, $classification_ids, $this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"));
		}
		
		//var_dump($classifications);
		
		//die($str);
		
		return $classifications;

	}
	

	
	public function resolve_keyword($location='', $return_default='', $class='') { 

		$classification_name = '';
		if (!$class) {
			if (isset($_GET['search'])) {
				$class_id = $_GET['search'];
				$classification_array = $this->listingFacade->getOneClassification($class_id);
			    $classification_name = $classification_array[0]['localclassification_name'];
			    $classification_name = trim($classification_name);
	            $classification_name = ucwords(strtolower($classification_name));
			}
		} else {
			$classification_name = $class;
		}
        
        $default_keyword = $classification_name;
		$referer = (isset($_SERVER['HTTP_REFERER']))?$_SERVER['HTTP_REFERER']:'';
		$parsed_referer = parse_url($referer);
		$cur_url = dev_log::get_cur_url();
		$parsed_cur_url = parse_url($cur_url);
		
		$referer_has_query = (isset($parsed_referer['query']))?1:0;
		$google_query_param = '[empty]';
		$dummy_ref = 'http://www.google.com.au/url?sa=t&rct=j&q=pinkpages%20hairdresser&source=web&cd=1&ved=0CFgQFjAA&url=http%3A%2F%2Fwww.pinkpages.com.au%2FHAIRDRESSERS%2FNSW%2F1898&ei=XNKpT9bJFaq1iQeBlvmsAw&usg=AFQjCNGpBctJPJ_VVChdPfO5WfwlopFmxQ&cad=rja';
		
		$keyword = '';
		$search_type = '';

		if ($return_default) {
			$keyword = $default_keyword;
		} elseif (!$referer) {
			$keyword = trim($classification_name. ' ' .$location);
			$search_type = 'direct';
		} elseif ($parsed_referer['host'] == 'dev.sydneypinkpagesonline.com.au' || $parsed_referer['host'] == 'www.pinkpages.com.au') {
			$keyword = trim($classification_name. ' ' .$location);
			$search_type = 'internal';
		} elseif (strpos($referer,"google")) {
			if ($referer_has_query) {
			$gpp_match = preg_match('/.*q=([^&]+).*/', $referer, $matches);
			if ($gpp_match) {
				$google_query_param = $matches[1];
			}
				//parse_str($parsed_q, $referer_search_query);
				//$google_parsed_keyword = $parsed_q['q'];
				if ($google_query_param) {
					$keyword = urldecode($google_query_param);
				} else {
					$keyword = trim($classification_name. ' ' .$location);
				}
			} else {
				$keyword = trim($classification_name. ' ' .$location);
			}
			$search_type = 'google';
		} else {
			$keyword = trim($classification_name. ' ' .$location);
			$search_type = 'other';
		}
		//print "HOST = {$parsed_referer['host']} <br/>";
		//print "keyword = [$keyword]";
		//die();
        
		
		//dev_log::write("cur url = $cur_url");
		//dev_log::write("parsed cur url = ".var_export($parsed_cur_url,true));
		if ($referer) {
			//dev_log::write("referer = $referer");
			//dev_log::write("referer has query = $referer_has_query");
			//dev_log::write("parsed referer = ".var_export($parsed_referer,true)); 
			//dev_log::write("parsed referer host = {$parsed_referer['host']}");
			//dev_log::write("google query param = $google_query_param");
		} else {
			//dev_log::write("No referer");
		}
		//dev_log::write("referer search query = ".var_export($referer_search_query,true));
		
		//dev_log::write("search_type = $search_type");
		//dev_log::write("keyword passed to Google = $keyword");
		//dev_log::write("default_keyword = $default_keyword");
		//dev_log::write("--------------------------------");
		return $keyword;

	}
	
	

	/**
	 *  categorySearch
	 *
	 *  Get the result according to the Category Search
	 */
	public function categorySearch()
	{
		die("HELLLLLLO");
		dev_log::cur_url();
		if(isset($_GET['shire_name'])  &&  !empty($_GET['shire_name'])){
			$regionAlias        = $_GET['shire_name'];
			$_GET['shire_name'] = $this->listingFacade->getShireNameFromAlias($_GET['shire_name']);
		}
		

		$shire_name							= (!empty($_GET['shire_name']))?$_GET['shire_name']:NULL;
		$shire_town							= (!empty($_GET['shire_town']))?$_GET['shire_town']:NULL;
		$state                              = (!empty($_GET['state']))?$_GET['state']:NULL;
		$location = '';

		if($state == ''){
			$state = ($this->listingFacade->isStateExistsBySuburb($shire_town)) ? $this->listingFacade->isStateExistsBySuburb($shire_town) : $this->listingFacade->isStateExistsByRegion($shire_name);
		}

		$selectArray 						= array();

		$do         						= $_GET['do'];
		$action								= $_GET['action'];
		$this->page->assign("do",$do);
		$this->page->assign("action",$action);

		if(isset($_GET['shire_name']) && $_GET['shire_name'] !='') {
			$location = $_GET['shire_name'];
			dev_log::write("categorySearch: LOCATION = $location");
			$searchSuburbs    = $this->searchRefineFacade->getSuburbsByRegion($location);
			$suburbURLs       = array();
			foreach($searchSuburbs as $searchSuburb){
				$suburb = urlencode($searchSuburb['shiretown_townname']);
				$suburbURLs[] = array($searchSuburb['shiretown_townname']=>$this->request->createURL("Listing", "categorySearch", "category=".urlencode($this->request->getAttribute('category'))."&state={$state}&shire_town={$suburb}&search={$this->request->getAttribute('search')}"));
			}
			$searchArea     = (count($searchSuburbs)>0) ? 'region' : '';
			$suburbCount = count($searchSuburbs);
			$this->page->assign("suburbCount", $suburbCount);
			$this->page->assign("suburbURLs", $suburbURLs);
			//$this->page->assign("suburb_change", "javascript:window.location='".$this->request->createURL("Listing","categorySearch", "search='")."+this.value");
			$this->page->assign("suburb_change", "javascript:window.location=this.value");
		}
		elseif(isset($_GET['postcode'])) {
			$location = $_GET['postcode'];
		}
		elseif(isset($_GET['shire_town']) && $_GET['shire_town'] !='') {
			$location = $_GET['shire_town'];
			$state    = $_GET['state'];
			$searchArea       = 'suburb';
			$searchRegions    = $this->searchRefineFacade->getRegionBySuburb($location, $state);
			$regionURLs       = array();
			foreach($searchRegions as $searchRegion){
				$regionURLs[]   =  array($searchRegion['shirename_shirename']=>$this->request->createURL("Listing", "categorySearch", "category=" . urlencode($this->request->getAttribute('category')) ."&state={$state}"."&shire_name=" . urlencode($searchRegion['url_alias']) . "&search={$this->request->getAttribute('search')}"));
			}
			$this->page->assign("regionCount", count($regionURLs));
			$this->page->assign("regionURLs", $regionURLs);
		}
		else {
		
			if ($state) {
				if ($state == 'NSW') {
					$location = 'All Sydney';
				} elseif ($state == 'VIC') {
					$location = 'All Melbourne';
				} elseif ($state == 'QLD') {
					$location = 'All Brisbane';
				} elseif ($state == 'ACT') {
					$location = 'Canberra Region';
				} elseif ($state == 'NT') {
					$location = 'All Darwin';
				} elseif ($state == 'WA') {
					$location = 'All Perth';
				} elseif ($state == 'SA') {
					$location = 'All Adelaide';
				} elseif ($state == 'TAS') {
					$location = 'All Hobart';
				} else {
					$location = 'All States';
				}
				
			} else {
				$location = 'All Sydney';
				
			}
			
		}

		//Assign suburb/region search area
		if(isset($searchArea)){
			$this->page->assign("searchArea", $searchArea);
		}

		//Get the Classificiation Description
		$classificationID = $this->request->getAttribute('search');
		$page     = ($this->request->getAttribute('pnum')) ? $this->request->getAttribute('pnum') : 1;
		$description =  $this->cf->getClassificationDescription($classificationID);
		$this->page->assign("description", $description);

		//Get the Classification Snippets
		$snippets = $this->cf->getClassificationSnippet($classificationID, $page);
		$this->page->assign("snippets", $snippets);

		$bannerArray=$this->listingFacade->getBanner("4");
		$this->page->assign("bannerArray",$bannerArray);

		/*$keywordArray=$this->listingFacade->fetchKeyword($_GET);
		 $this->page->assign("keywordArray",$keywordArray);

		 $brandArray=$this->listingFacade->fetchBrands($_GET);
		 $this->page->assign("brandArray",$brandArray);*/

		$bannerArrayA=$this->listingFacade->getBannerA("5");
		$this->page->assign("bannerArrayA",$bannerArrayA);

		$bannerArrayB=$this->listingFacade->getBannerB("5");
		$this->page->assign("bannerArrayB",$bannerArrayB);

		$bannerArrayC=$this->listingFacade->getBannerC("5");
		$this->page->assign("bannerArrayC",$bannerArrayC);

		$bannerArrayD=$this->listingFacade->getBannerD("5");
		$this->page->assign("bannerArrayD",$bannerArrayD);

		$bannerArrayE=$this->listingFacade->getBannerE("5");
		$this->page->assign("bannerArrayE",$bannerArrayE);

		$this->page->assign("home",$this->request->createURL("Affiliate", "showhomePageAffiliate"));
		$this->listingFacade->categorySearchCount($_GET);
		$res = $this->listingFacade->categorySearchResult($this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"), $_GET);

		if($res['is_exclude']) {
			$this->page->assign("is_exclude",1);
			$this->page->assign("exclude_count",$res['exclude_count']);
			$this->page->assign("exclude_url",SITE_PATH."main.php?".$this->request->replaceQS($_SERVER['QUERY_STRING'], array("exclude"=>1, "fr"=>0, "pnum"=>1)));
			$this->page->assign("include_url",SITE_PATH."main.php?".$this->request->replaceQS($_SERVER['QUERY_STRING'], array("exclude"=>0, "fr"=>0, "pnum"=>1)));
		}
		$this->page->assign("brandArray",$res['brands']);
		$this->page->assign("fetch_service",$res['services']);
		$this->page->assign("fetch_payment",$res['payments']);
		$this->page->assign("fetch_hours",$res['hours']);
			
		if(isset($_GET['service']))$selectArray['service'] 		= $_GET['service'];
		if(isset($_GET['hours']))$selectArray['hours'] 		= $_GET['hours'];
		if(isset($_GET['payment']))$selectArray['payment'] 		= $_GET['payment'];
		if(isset($_GET['keyword']))$selectArray['keyword'] 	= $_GET['keyword'];
		if(isset($_GET['brand']))$selectArray['brand'] 		= $_GET['brand'];
		$this->page->assign("selectArray",$selectArray);

		$this->page->addJsFile("bsn.AutoSuggest_2.1.3.js");
		$this->page->addCssStyle("autosuggest_inquisitor.css");

		$category = urldecode(ucwords(strtolower($_GET['category'])));
		//$default_keyword  = urldecode(ucwords(strtolower($_GET['category'])));
		$default_keyword  = $this->resolve_keyword($location,true);
		$adult = 0;
		if ($category == 'ADULT ENTERTAINMENT' || $category == 'ESCORTS') {
			$adult = 1;
			die("ADULT!!!! [$category]");
		} else {
			die("OOPS!!!! [$category]");
		}
		
		
		$location = ucwords(strtolower($location));
		$keyword = $this->resolve_keyword($location,false);

		$this->page->assign("category", $category);
		$this->page->assign("keyword" , $keyword);
		$this->page->assign("default_keyword" , $default_keyword);
		
		
		$this->page->assign("location", $location);

		$sortby			= (!empty($_GET['sortby']))?$_GET['sortby']:NULL;
		$this->page->assign("sortby",$sortby);

		$state			= (!empty($_GET['state']))?$_GET['state']:NULL;
		$state			= explode("__",$state);

		$shirename		= (!empty($_GET['shirename']))?$_GET['shirename']:NULL;
		$shirename		= explode("__",$shirename);

		$shiretown		= (!empty($_GET['shiretown']))?$_GET['shiretown']:NULL;
		$shiretownval	= explode("__",$shiretown);

		$locationRes	= $this->listingFacade->locationDisplay();
		$refineDisplay	= $this->listingFacade->refineDisplay($_GET);

		$this->page->assign("refineDisplay",$refineDisplay);
		if(count($state)>0)
		{
			$shirenameRes = $this->listingFacade->regionDisplay($state);
			$this->page->assign("shirenameRes",$shirenameRes);
		}
		if(count($shirename)>0)
		{
			$shiretown = $this->listingFacade->shireTownDisplay($shirename);
			$this->page->assign("shiretown",$shiretown);
		}
		$this->page->assign("locationRes",$locationRes);
		$this->page->assign("state", $state[0]);
		$this->page->assign("shirename", $shirename[0]);
		$this->page->assign("shiretownval", $shiretownval[0]);

		$CountResult		=count($res);
		$this->page->assign("CountResult",$CountResult);
		$normalcount		= count($res['blogs']);
		$this->page->assign("normalcount",$normalcount);

		$this->page->assign("values", $res['blogs']);
		$this->page->assign("paging", $res['paging']);

		$this->page->assign("CountResult",$res['paging']['totalRecords']);

		$hrs = array();
		for($i=1;$i<=24;$i++){
				
			$hrs[] = $i;
				
		}
		$this->page->assign("hrs",$hrs);

		//Assign Metatags and Page Title
		$cnt           = (empty($res['paging']['totalRecords'])) ? $normalcount : $res['paging']['totalRecords'];
		if($shire_name != '')
		{
			$canonicalType = 'region';
			$canonicalUrl  = $this->url->getCanonical($canonicalType, $_GET);
			$this->page->pageTitle 			= $category . " Listing in " . $location . ", " . $state[0] . "&#58; Pink Pages Australia";
			$this->page->addMetaDescription("Looking for $category located in the $location? Pink Pages Australia has " . $cnt . " " . $category . " listing in " . $location . ".");
			if($canonicalUrl){
				$this->page->addCanonical(SITE_PATH . $canonicalUrl);
			}
				
			if($location && $state[0] && $category){
				$region  = $location;
				$state   = $state[0];
				$details = array("region" => $region, "state" => $state, "category" => $category);

				$this->url->setListingDetails($details);
			}
				
		}elseif($shire_town != '')
		{
			$canonicalType = 'suburb';
			$canonicalUrl  = $this->url->getCanonical($canonicalType, $_GET);
			$region        = $this->url->getRegionFromSuburb($location);
			$this->page->pageTitle 			= $category . " Listing in " . $location . "," . $region . ", " . $state[0] . "&#58; Pink Pages Australia";
			$this->page->addMetaDescription("Looking for $category located in $location of $region, $state[0]? Pink Pages Australia has " . $cnt . " " . $category . " listings in " . $location . ", as well as many in the surrounding " . $region);
			if($canonicalUrl){
				$this->page->addCanonical(SITE_PATH . $canonicalUrl);
			}
				
			if($location && $region && $state[0] && $category){
				$suburb  = $location;
				$state   = $state[0];
				$details = array("suburb" => $suburb, "region" => $region, "state" => $state, "category" => $category);
					
				$this->url->setListingDetails($details);
			}
				
		}else{
			$this->page->pageTitle 			= $category . " Business Listings&#58; Pink Pages Australia";
			$canonicalType = 'state';
			$canonicalUrl  = $this->url->getCanonical($canonicalType, $_GET);
			$this->page->addMetaDescription("Looking for ".$category."? Pink Pages Australia has an extensive directory of ".$category." listings in all major capitals and throughout regional Australia.");
			if($canonicalUrl){
				$this->page->addCanonical(SITE_PATH . $canonicalUrl);
			}

			//Reset Search Session Variables
			$this->url->setListingDetails();
		}

		$this->page->addMetaTags("robots", "noodp,noydir");

		$category_search = $this->request->createURL("Listing", "categorySearch", "category");
		$this->page->assign("category_search",$category_search);
		$this->page->assign("service_change", "javascript:window.location='".$this->request->createNaturalURL("Listing","categorySearch", 		 "search={$this->request->getAttribute('search')}&category={$this->request->getAttribute('category')}&shire_town={$this->request->getAttribute('shire_town')}&shire_name={$this->request->getAttribute('shire_name')}&hours={$this->request->getAttribute('hours')}&payment={$this->request->getAttribute('payment')}&brand={$this->request->getAttribute('brand')}&val={$this->request->getAttribute('val')}&service='")."+this.value");
		$this->page->assign("hour_change", "javascript:window.location='".$this->request->createNaturalURL("Listing", "categorySearch", 	 "search={$this->request->getAttribute('search')}&category={$this->request->getAttribute('category')}&shire_town={$this->request->getAttribute('shire_town')}&shire_name={$this->request->getAttribute('shire_name')}&val={$this->request->getAttribute('val')}& payment={$this->request->getAttribute('payment')}&brand={$this->request->getAttribute('brand')}&service={$this->request->getAttribute('service')}&hours='")."+this.value");
		$this->page->assign("payment_change", "javascript:window.location='".$this->request->createNaturalURL("Listing", "categorySearch", 	"search={$this->request->getAttribute('search')}&category={$this->request->getAttribute('category')}&shire_town={$this->request->getAttribute('shire_town')}&shire_name={$this->request->getAttribute('shire_name')}&val={$this->request->getAttribute('val')}&	service={$this->request->getAttribute('service')}&hours={$this->request->getAttribute('hours')}&brand={$this->request->getAttribute('brand')}&payment='")."+this.value");
		$this->page->assign("keyword_change", "javascript:window.location='".$this->request->createNaturalURL("Listing", "categorySearch", "search={$this->request->getAttribute('search')}&category={$this->request->getAttribute('category')}&val={$this->request->getAttribute('val')}&service={$this->request->getAttribute('service')}&hours={$this->request->getAttribute('hours')}&payment={$this->request->getAttribute('payment')}&keyword='")."+this.value");
		$this->page->assign("brand_change", "javascript:window.location='".$this->request->createNaturalURL("Listing", "categorySearch", "search={$this->request->getAttribute('search')}&category={$this->request->getAttribute('category')}&shire_town={$this->request->getAttribute('shire_town')}&shire_name={$this->request->getAttribute('shire_name')}&val={$this->request->getAttribute('val')}& service={$this->request->getAttribute('service')}&hours={$this->request->getAttribute('hours')}&payment={$this->request->getAttribute('payment')}&keyword={$this->request->getAttribute('keyword')}&brand='")."+this.value");

		$this->page->assign("contactUs",$this->request->createURL("Listing", "contactUs","ID"));
		$_GET['pnum'] = (isset($_GET['pnum']) && $_GET['pnum'])?$_GET['pnum']:1;
		$relatedClassLinks = $this->relatedClassLinks($classificationID,'','','',$location);
		$related_class_count = 0;
		$related_classifications = '';
		if ($relatedClassLinks) {
			$related_class_count = count($relatedClassLinks['classifications']);
			$related_classifications = $relatedClassLinks['classifications'];
		}
        
        $this->page->assign("related_class_count", $related_class_count);
		//$this->page->assign("relatedClassLinks", $relatedClassLinks);
		$this->page->assign("relatedClassLinks", $related_classifications);
		
		//dev_log::cur_url("Listing::categorySearch");
		$this->page->getPage('category_result.tpl');
	}/* END categorySearch */


	/**
	 *  categorySearch
	 *
	 *  Get the result according to the Category Search
	 */
	public function categorySearchAlpha()
	{
		$this->page->pageTitle = $_GET['category'] . " Business Listings&#58; Pink Pages Australia";
		$this->page->addMetaTags("robots", "noodp,noydir");
		//Reset Search Session Variables
		$this->url->setListingDetails();


		$selectArray 						= array();

		$do         						= $_GET['do'];
		$action								= $_GET['action'];
		$this->page->assign("do",$do);
		$this->page->assign("action",$action);

		$classificationID = $this->request->getAttribute('search');

		$location = $this->defaultLocation;

		$bannerArray=$this->listingFacade->getBanner("4");
		$this->page->assign("bannerArray",$bannerArray);

		$bannerArrayA=$this->listingFacade->getBannerA("5");
		$this->page->assign("bannerArrayA",$bannerArrayA);

		$bannerArrayB=$this->listingFacade->getBannerB("5");
		$this->page->assign("bannerArrayB",$bannerArrayB);

		$bannerArrayC=$this->listingFacade->getBannerC("5");
		$this->page->assign("bannerArrayC",$bannerArrayC);

		$bannerArrayD=$this->listingFacade->getBannerD("5");
		$this->page->assign("bannerArrayD",$bannerArrayD);

		$bannerArrayE=$this->listingFacade->getBannerE("5");
		$this->page->assign("bannerArrayE",$bannerArrayE);

		$this->page->assign("home",$this->request->createURL("Affiliate", "showhomePageAffiliate"));
		$this->listingFacade->categorySearchCount($_GET);
		$res = $this->listingFacade->categorySearchResultAlpha($this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"), $_GET);
		if($res['is_exclude']) {
			$this->page->assign("is_exclude",1);
			$this->page->assign("exclude_count",$res['exclude_count']);
			$this->page->assign("exclude_url",SITE_PATH."main.php?".$this->request->replaceQS($_SERVER['QUERY_STRING'], array("exclude"=>1, "fr"=>0, "pnum"=>1)));
			$this->page->assign("include_url",SITE_PATH."main.php?".$this->request->replaceQS($_SERVER['QUERY_STRING'], array("exclude"=>0, "fr"=>0, "pnum"=>1)));
		}
		$this->page->assign("brandArray",$res['brands']);
		$this->page->assign("fetch_service",$res['services']);
		$this->page->assign("fetch_payment",$res['payments']);
		$this->page->assign("fetch_hours",$res['hours']);
			
		if(isset($_GET['service']))$selectArray['service']  = $_GET['service'];
		if(isset($_GET['hours']))$selectArray['hours'] 		= $_GET['hours'];
		if(isset($_GET['payment']))$selectArray['payment'] 	= $_GET['payment'];
		if(isset($_GET['keyword']))$selectArray['keyword'] 	= $_GET['keyword'];
		if(isset($_GET['brand']))$selectArray['brand'] 		= $_GET['brand'];
		$this->page->assign("selectArray",$selectArray);

		$this->page->addJsFile("bsn.AutoSuggest_2.1.3.js");
		$this->page->addCssStyle("autosuggest_inquisitor.css");

		$category = urldecode(ucwords(strtolower($_GET['category'])));
		//$default_keyword  = urldecode(ucwords(strtolower($_GET['category'])));
		$default_keyword  = $this->resolve_keyword($location,true);
		
		

	    //$classification_name = urlencode($classification_name);
		
		$location = ucwords(strtolower($location));
        $keyword = $this->resolve_keyword($location,false);
		$this->page->assign("category", $category);
		$this->page->assign("keyword" , $keyword);
		$this->page->assign("default_keyword" , $default_keyword);
		$this->page->assign("location", $location);

		$sortby			= (!empty($_GET['sortby']))?$_GET['sortby']:NULL;
		$this->page->assign("sortby",$sortby);

		$state			= (!empty($_GET['state']))?$_GET['state']:NULL;
		$state			= explode("__",$state);

		$shirename		= (!empty($_GET['shirename']))?$_GET['shirename']:NULL;
		$shirename		= explode("__",$shirename);

		$shiretown		= (!empty($_GET['shiretown']))?$_GET['shiretown']:NULL;
		$shiretownval	= explode("__",$shiretown);

		$locationRes	= $this->listingFacade->locationDisplay();

		$refineDisplay	= $this->listingFacade->refineDisplay($_GET);

		$this->page->assign("refineDisplay",$refineDisplay);
		if(count($state)>0)
		{
			$shirenameRes = $this->listingFacade->regionDisplay($state);
			$this->page->assign("shirenameRes",$shirenameRes);
		}
		if(count($shirename)>0)
		{
			$shiretown = $this->listingFacade->shireTownDisplay($shirename);
			$this->page->assign("shiretown",$shiretown);
		}
		$this->page->assign("locationRes",$locationRes);
		$this->page->assign("state", $state[0]);
		$this->page->assign("shirename", $shirename[0]);
		$this->page->assign("shiretownval", $shiretownval[0]);

		$CountResult		=count($res);
		$this->page->assign("CountResult",$CountResult);
		$normalcount		= count($res['blogs']);
		$this->page->assign("normalcount",$normalcount);
		$this->page->assign("values", $res['blogs']);
		$this->page->assign("paging", $res['paging']);
		$this->page->assign("CountResult",$res['paging']['totalRecords']);

		$hrs = array();
		for($i=1;$i<=24;$i++){
				
			$hrs[] = $i;
				
		}
		$this->page->assign("hrs",$hrs);

		$category_search = $this->request->createURL("Listing", "categorySearch", "category");
		$this->page->assign("category_search",$category_search);

		//Adding Meta Tags
		$this->page->addMetaDescription("Looking for $category? Pink Pages Australia has an extensive directory of $category listings in all major capitals and throughout regional Australia.");
		//$this->page->addMetaKeywords("$category, $location");
		$this->page->addCanonical(SITE_PATH . "listing/categorysearchalpha/search/".$_GET['search']."/category/".urlencode($category));

		$this->page->assign("service_change", "javascript:window.location='".$this->request->createNaturalURL("Listing","categorySearch", 		 "search={$this->request->getAttribute('search')}&category={$this->request->getAttribute('category')}&shire_town={$this->request->getAttribute('shire_town')}&shire_name={$this->request->getAttribute('shire_name')}&hours={$this->request->getAttribute('hours')}&payment={$this->request->getAttribute('payment')}&brand={$this->request->getAttribute('brand')}&val={$this->request->getAttribute('val')}&service='")."+this.value");
		$this->page->assign("hour_change", "javascript:window.location='".$this->request->createNaturalURL("Listing", "categorySearch", 	 "search={$this->request->getAttribute('search')}&category={$this->request->getAttribute('category')}&shire_town={$this->request->getAttribute('shire_town')}&shire_name={$this->request->getAttribute('shire_name')}&val={$this->request->getAttribute('val')}& payment={$this->request->getAttribute('payment')}&brand={$this->request->getAttribute('brand')}&service={$this->request->getAttribute('service')}&hours='")."+this.value");
		$this->page->assign("payment_change", "javascript:window.location='".$this->request->createNaturalURL("Listing", "categorySearch", 	"search={$this->request->getAttribute('search')}&category={$this->request->getAttribute('category')}&shire_town={$this->request->getAttribute('shire_town')}&shire_name={$this->request->getAttribute('shire_name')}&val={$this->request->getAttribute('val')}&	service={$this->request->getAttribute('service')}&hours={$this->request->getAttribute('hours')}&brand={$this->request->getAttribute('brand')}&payment='")."+this.value");
		$this->page->assign("keyword_change", "javascript:window.location='".$this->request->createNaturalURL("Listing", "categorySearch", "search={$this->request->getAttribute('search')}&category={$this->request->getAttribute('category')}&val={$this->request->getAttribute('val')}&service={$this->request->getAttribute('service')}&hours={$this->request->getAttribute('hours')}&payment={$this->request->getAttribute('payment')}&keyword='")."+this.value");
		$this->page->assign("brand_change", "javascript:window.location='".$this->request->createNaturalURL("Listing", "categorySearch", "search={$this->request->getAttribute('search')}&category={$this->request->getAttribute('category')}&shire_town={$this->request->getAttribute('shire_town')}&shire_name={$this->request->getAttribute('shire_name')}&val={$this->request->getAttribute('val')}& service={$this->request->getAttribute('service')}&hours={$this->request->getAttribute('hours')}&payment={$this->request->getAttribute('payment')}&keyword={$this->request->getAttribute('keyword')}&brand='")."+this.value");

		$this->page->assign("contactUs",$this->request->createURL("Listing", "contactUs","ID"));
		$_GET['pnum'] = (isset($_GET['pnum']) && $_GET['pnum'])?$_GET['pnum']:1;
		$relatedClassLinks = $this->relatedClassLinks($classificationID);
		$related_class_count = count($relatedClassLinks['classifications']);
        $this->page->assign("related_class_count", $related_class_count);
		$this->page->assign("relatedClassLinks", $relatedClassLinks['classifications']);
		
		$this->page->assign("classificationID", $classificationID);
		//dev_log::cur_url("Listing::categorySearch");
		$this->page->getPage('category_result.tpl');
	}/* END categorySearchAlpha */


	/**
	 *  contactUs
	 *
	 *  display the contact us details.
	 */
	public function contactUs()
	{
		$this->page->pageTitle = "Pink Pages &shy; Contact us ";
		$this->page->assign("action",$this->request->createURL("Listing", "contactUsDetails","ID=".$_GET['ID']));
		$this->page->assign("backToSearch",$this->request->createURL("Listing", "categorySearch","search"));
		$this->page->assign("backToNormalSearch",$this->request->createURL("Listing", "search"));
		$this->page->assign("backToDetail",$this->request->createURL("Listing", "boldListing","ID"));

		//$this->page->assign("values",$res[0]);
		//$this->page->assign("names",$business_name);
		$this->page->getPage('contactUs_form.tpl');
	}


	public function mailSentThanks()
	{
		$this->page->pageTitle 			= "Pink Pages &shy; Mail Sent";
		$this->page->assign("back_to_search",$this->request->createURL("Listing", "categorySearch","search"));
		$this->page->getPage('mail_sent_thanks.tpl');
	}


	/**
	 *  contactUsDetails
	 *
	 *  search the contact us details.
	 */
	public function contactUsDetails()
	{

		$name 				= (!empty($_POST['name']))?$_POST['name']:NULL;
		$companyname 		= (!empty($_POST['companyname']))?$_POST['companyname']:NULL;
		$emailFrom 			= (!empty($_POST['email']))?$_POST['email']:NULL;
		$phone 				= (!empty($_POST['phone']))?$_POST['phone']:NULL;
		$comment 			= (!empty($_POST['comment']))?$_POST['comment']:NULL;

		$this->page->assign("name",$name);
		$this->page->assign("companyname",$companyname);
		$this->page->assign("emailFrom",$emailFrom);
		$this->page->assign("phone",$phone);
		$this->page->assign("comment",$comment);

		$this->page->assign("backToSearch",$this->request->createURL("Listing", "categorySearch","search"));
		$result = $this->listingFacade->contactUsDetails($_GET,$_POST);

		if($result['result'])
		{
			//$this->request->setAttribute("message", $result['message']);
			$this->mailSentThanks();
		}else{
			$this->request->setAttribute("message", $result['message']);
			$this->contactUs();
		}
	}



	/**
	 *  stateSearch
	 *
	 *  search State on list selection
	 */
	public function stateSearch()
	{
		$res = $this->listingFacade->SearchResult($_GET);

	}/* END stateSearch */


	/**
	 *  addListing
	 *
	 * display the form to add the listing.
	 */
	public function addListing()
	{
		$this->page->pageTitle = "Add Listing";
		$initials		= (!empty($_POST['initials']))?$_POST['initials']:NULL;
		$name			= (!empty($_POST['name']))?$_POST['name']:NULL;
		$street1		= (!empty($_POST['street1']))?$_POST['street1']:NULL;
		$street2		= (!empty($_POST['street2']))?$_POST['street2']:NULL;
		$postcode		= (!empty($_POST['postcode']))?$_POST['postcode']:NULL;
		$phonestd		= (!empty($_POST['phonestd']))?$_POST['phonestd']:NULL;
		$phone			= (!empty($_POST['phone']))?$_POST['phone']:NULL;
		$faxstd			= (!empty($_POST['faxstd']))?$_POST['faxstd']:NULL;
		$fax			= (!empty($_POST['fax']))?$_POST['fax']:NULL;
		$email			= (!empty($_POST['email']))?$_POST['email']:NULL;
		$url			= (!empty($_POST['url']))?$_POST['url']:NULL;
		$description	= (!empty($_POST['description']))?$_POST['description']:NULL;
		$origin			= (!empty($_POST['origin']))?$_POST['origin']:NULL;
		$mobile			= (!empty($_POST['mobile']))?$_POST['mobile']:NULL;
		$contact		= (!empty($_POST['contact']))?$_POST['contact']:NULL;
		$region			= (!empty($_POST['region']))?$_POST['region']:NULL;
		$OlistID		= (!empty($_POST['OlistID']))?$_POST['OlistID']:NULL;
		$AccNo			= (!empty($_POST['AccNo']))?$_POST['AccNo']:NULL;
		$brand			= (!empty($_POST['brand']))?$_POST['brand']:NULL;

		$this->page->assign("AccNo",$AccNo);
		$this->page->assign("initials",$initials);
		$this->page->assign("name",$name);
		$this->page->assign("street1",$street1);
		$this->page->assign("street2",$street2);
		$this->page->assign("postcode",$postcode);
		$this->page->assign("phonestd",$phonestd);
		$this->page->assign("phone",$phone);
		$this->page->assign("fax",$fax);
		$this->page->assign("faxstd",$faxstd);
		$this->page->assign("email",$email);
		$this->page->assign("url",$url);
		$this->page->assign("description",$description);
		$this->page->assign("origin",$origin);
		$this->page->assign("mobile",$mobile);
		$this->page->assign("contact",$contact);
		$this->page->assign("region",$region);
		$this->page->assign("OlistID",$OlistID);
		$this->page->assign("brand",$brand);


		$do								= $_GET['do'];
		$action							= $_GET['action'];
		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$this->listingFacade->popularPageCount("24");
		$this->page->assign("add_keyword",$this->request->createURL("Listing", "add_keyword"));
		$this->page->assign("edit_url",$this->request->createURL("Listing", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("Listing", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("Listing", "rankBusiness"));
		$this->page->assign("login_url",$this->request->createURL("Business", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Business", "doLogout"));
		$this->page->assign("action",$this->request->createURL("Listing", "listingAddition"));
		$this->page->assign("change_password",$this->request->createURL("Business", "changePassword"));
		$this->page->assign("viewlisting",$this->request->createURL("Listing", "viewList"));
		$this->page->assign("listing",$this->request->createURL("Listing", "addListing"));
		$this->page->assign("back",$this->request->createURL("Business", "showhomePageBusiness"));
		$this->page->assign("edit",$this->request->createURL("Business", "Edit","ID"));

		$brandResult					= $this->listingFacade->fetchBrands();
		$this->page->assign("brandResult",$brandResult);

		$res1							= $this->listingFacade->fetchClassificationDetails();
		$this->page->assign("values1",$res1);

		$regionValue					= $this->listingFacade->fetchRegion();
		$this->page->assign("regionValue",$regionValue);

		$res							= $this->listingFacade->fetchTownDetails();
		$this->page->assign("values",$res);

		$res2							= $this->listingFacade->selectStates();
		$this->page->assign("values2",$res2);

		$res3							= $this->listingFacade->fetchRank();
		$this->page->assign("rank",$res3[0]['rank']);

		$rankList						= $this->listingFacade->fetchRankRate();
		$this->page->assign("rankList",$rankList);
		$this->page->getPage('listingadd.tpl');
	}/* END addListing */



	/**
	 *  listingAddition
	 *
	 *  add the business to the database after validation and return success message after success or return error message.
	 */
	public function listingAddition()
	{
		$do								= $_GET['do'];
		$action							= $_GET['action'];
		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$this->page->assign("add_keyword",$this->request->createURL("Listing", "add_keyword"));
		$this->page->assign("edit_url",$this->request->createURL("Listing", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("Listing", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("Listing", "rankBusiness"));
		$this->page->assign("login_url",$this->request->createURL("Business", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Business", "doLogout"));
		$this->page->assign("edit_url",$this->request->createURL("Listing", "Edit","ID"));
		$this->page->assign("change_password",$this->request->createURL("Business", "changePassword"));
		$this->page->assign("delete",$this->request->createURL("Listing", "delete","ID"));
		$this->page->assign("viewlisting",$this->request->createURL("Listing", "viewList"));
		$this->page->assign("listing",$this->request->createURL("Listing", "addListing"));
		$this->page->assign("edit",$this->request->createURL("Business", "Edit","ID"));

		//Add Business Logo
		$image=$_FILES['logo']['name'];
		$tmp=$_FILES['logo']['tmp_name'];

		move_uploaded_file($tmp,"admin/View/Default/Images/client_image/$image");

		//Add Business Image
		$image2=$_FILES['image']['name'];
		$tmp=$_FILES['image']['tmp_name'];

		move_uploaded_file($tmp,"admin/View/Default/Images/client_image/$image2");

		$res=$this->listingFacade->addlist1($_POST,$_FILES);

		if($res['result']==0)
		{
			$this->request->setAttribute("message", $res['message']);
			$this->addListing();
		}else{
				
			$this->request->redirect("Listing","addClassification","ID={$res['InsertID']}&msg=1");
		}

	}/* END googleMapView */


	/**
	 *  addClassification
	 *
	 * display the form to add the classification.
	 */
	public function addClassification()
	{
		$this->page->pageTitle 	= "Add Classification";
		$do						= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action					= (!empty($_GET['action']))?$_GET['action']:NULL;
		$msg					= (!empty($_GET['msg']))?$_GET['msg']:NULL;

		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$this->page->assign("msg",$msg);
		$this->page->assign("add_keyword",$this->request->createURL("Listing", "add_keyword"));
		$this->page->assign("edit_url",$this->request->createURL("Listing", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("Listing", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("Listing", "rankBusiness"));
		$this->page->assign("addbusinessform",$this->request->createURL("Listing", "addListing"));
		$this->page->assign("change_password",$this->request->createURL("Business", "changePassword"));
		$this->page->assign("search",$this->request->createURL("Listing","searchBusiness"));
		$this->page->assign("viewList",$this->request->createURL("Listing","viewList"));
		$classificationList=$this->listingFacade->fetchClassificationDetails();
		$this->page->assign("classificationList",$classificationList);
		$classificationListResult=$this->listingFacade->classificationList($_GET);
		$this->page->assign("classificationListResult",$classificationListResult);
		$this->page->assign("action",$this->request->createURL("Listing", "addClassificationDetail","ID"));
		$this->page->assign("deleteAction",$this->request->createURL("Listing", "deleteClassification","ID"));
		$this->page->assign("businessRank",$this->request->createURL("Listing", "rankBusiness","ID"));
		$this->page->getPage('add_classification.tpl');
	}

	/**
	 *  addClassificationDetail
	 *
	 * used to add the classification details.
	 */
	public function addClassificationDetail()
	{
		$do						= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action					= (!empty($_GET['action']))?$_GET['action']:NULL;
		$msg					= (!empty($_GET['msg']))?$_GET['msg']:NULL;

		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$this->page->assign("msg",$msg);

		$this->page->assign("add_keyword",$this->request->createURL("Listing", "add_keyword"));
		$this->page->assign("edit_url",$this->request->createURL("Listing", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("Listing", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("Listing", "rankBusiness"));
		$this->page->assign("addbusinessform",$this->request->createURL("Listing", "addListing"));
		$this->page->assign("change_password",$this->request->createURL("Business", "changePassword"));
		$this->page->assign("search",$this->request->createURL("Listing","searchBusiness"));
		$this->page->assign("viewList",$this->request->createURL("Listing","viewList"));
		$classificationList=$this->listingFacade->fetchClassificationDetails();
		$this->page->assign("classificationList",$classificationList);

		$classificationAddResult	=$this->listingFacade->addClassificationDetail($_POST,$_GET);

		if($classificationAddResult['result'])
		{
			//  $this->request->setAttribute("message-succ", $classificationAddResult['message']);//$this->addClassification();
			$this->request->redirect("Listing","addClassification","ID={$classificationAddResult['ID']}&msg=2");
		}

		$this->page->getPage('add_classification.tpl');
	}


	/**
	 *  deleteClassification
	 *
	 * used to delete the classification details.
	 */
	public function deleteClassification()
	{
		$do						= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action					= (!empty($_GET['action']))?$_GET['action']:NULL;
		$msg					= (!empty($_GET['msg']))?$_GET['msg']:NULL;

		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$this->page->assign("msg",$msg);

		$this->page->assign("add_keyword",$this->request->createURL("Listing", "add_keyword"));
		$this->page->assign("edit_url",$this->request->createURL("Listing", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("Listing", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("Listing", "rankBusiness"));
		$this->page->assign("addbusinessform",$this->request->createURL("Listing", "addListing"));
		$this->page->assign("change_password",$this->request->createURL("Business", "changePassword"));
		$this->page->assign("search",$this->request->createURL("Listing","searchBusiness"));
		$this->page->assign("viewList",$this->request->createURL("Listing","viewList"));
		$classificationDelResult	=$this->listingFacade->deleteClassification($_POST,$_GET);

		if($classificationDelResult['result'])
		{
			$this->request->redirect("Listing","addClassification","ID={$classificationDelResult['ID']}&msg=3");
		}

	}

	/**
	 *  rankBusiness
	 *
	 * used to display rank of the particular classification.
	 */
	public function rankBusiness()
	{
		$this->page->pageTitle = "Rank Business";
		$do						= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action					= (!empty($_GET['action']))?$_GET['action']:NULL;
		$msg					= (!empty($_GET['msg']))?$_GET['msg']:NULL;

		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$this->page->assign("msg",$msg);

		$this->page->assign("add_keyword",$this->request->createURL("Listing", "add_keyword"));
		$this->page->assign("edit_url",$this->request->createURL("Listing", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("Listing", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("Listing", "rankBusiness"));
		$this->page->assign("addbusinessform",$this->request->createURL("Listing", "addListing"));
		$this->page->assign("change_password",$this->request->createURL("Business", "changePassword"));
		$this->page->assign("search",$this->request->createURL("Listing","searchBusiness"));
		$this->page->assign("viewList",$this->request->createURL("Listing","viewList"));
		$ranks 						= array('1'=>'1',
										'2'=>'2',
										'3'=>'3',
										'4'=>'4',
										'5'=>'5',
										'6'=>'6',
										'7'=>'7',
										'8'=>'8',
										'9'=>'9',
										'10'=>'10',
										'9999'=>'11+');
		$this->page->assign("ranks",$ranks);

		$rankResult					= $this->listingFacade->rankDetails($_GET);
		$this->page->assign("rankResult",$rankResult);

		$classificationListResult	= $this->listingFacade->classificationList($_GET);
		$array1 					= array(array("localclassification_id" => "", "localclassification_name" => ""));
		$finalResult1				= array_merge($array1,$classificationListResult);
		$this->page->assign("classificationListResult",$finalResult1);

		$regionValue				= $this->listingFacade->fetchRegion();
		$array2 					= array(array("shirename_id" => "", "shirename_shirename" => "", "shirename_state" => ""));
		$finalResult2				= array_merge($array2,$regionValue);

		$this->page->assign("regionValue",$finalResult2);
		$this->page->assign("action",$this->request->createURL("Listing", "addRank","ID"));
		$this->page->getPage('add_business_rank.tpl');
	}

	/**
	 *  addRank
	 *
	 * used to add rank to the particular business.
	 */
	public function addRank()
	{
		$this->page->pageTitle = "Rank Business";
		$do						= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action					= (!empty($_GET['action']))?$_GET['action']:NULL;

		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);


		$this->page->assign("add_keyword",$this->request->createURL("Listing", "add_keyword"));
		$this->page->assign("edit_url",$this->request->createURL("Listing", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("Listing", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("Listing", "rankBusiness"));
		$this->page->assign("addbusinessform",$this->request->createURL("Listing", "addListing"));
		$this->page->assign("change_password",$this->request->createURL("Business", "changePassword"));
		$this->page->assign("search",$this->request->createURL("Listing","searchBusiness"));
		$this->page->assign("viewList",$this->request->createURL("Listing","viewList"));
		$addRankResult	=$this->listingFacade->addRank($_POST,$_GET);

		if($addRankResult['result'])
		{
			$this->request->redirect("Listing","rankBusiness","ID={$addRankResult['ID']}&msg=4");
		}
		else{
			$this->request->setAttribute("message", $addRankResult['message']);
			$this->rankBusiness();
		}
	}
	 
	 
	/**
	 *  showMidPage
	 *
	 * used to display the intermediate page for the result containing region and its suburb.
	 */
	public function showMidPage($ID)
	{
		/*  $this->page->assign("do",$_GET['do']);
		 $this->page->assign("action1",$_GET['action']);*/
		$this->page->assign("delete",$this->request->createURL("Listing", "delete","ID"));
		$this->page->assign("updateAction",$this->request->createURL("Listing", "updateAdd","ID={$ID}"));
		$this->page->getPage("listing_intermediate_page.tpl");

	}

	/**
	 *  updateAdd
	 *
	 * used to update the details of the business listings.
	 */
	public function updateAdd()
	{
		/*$this->page->assign("do",$_GET['do']);
		 $this->page->assign("action1",$_GET['action']);*/
		$this->page->assign("delete",$this->request->createURL("Listing", "delete","ID"));
		$res=$this->listingFacade->updateAdd($_POST);
		if($res['result'])
		{
			$this->request->setAttribute("message-succ", $res['message']);
			$this->viewList();
		}
		else{
			$this->request->setAttribute("message", $res['message']);
			$this->addListing();}
	}

	/**
	 *  Edit
	 *
	 * used to edit the details of the business listings.
	 */
	public function Edit()
	{
		$this->page->pageTitle = "Edit Listing";
		$classification	= (!empty($_POST['classification']))?$_POST['classification']:NULL;
		$initials		= (!empty($_POST['initials']))?$_POST['initials']:NULL;
		$name			= (!empty($_POST['name']))?$_POST['name']:NULL;
		$Add1			= (!empty($_POST['Add1']))?$_POST['Add1']:NULL;
		$Add2			= (!empty($_POST['Add2']))?$_POST['Add2']:NULL;
		$Add3			= (!empty($_POST['Add3']))?$_POST['Add3']:NULL;
		$street1		= (!empty($_POST['street1']))?$_POST['street1']:NULL;
		$street2		= (!empty($_POST['street2']))?$_POST['street2']:NULL;
		$postcode		= (!empty($_POST['postcode']))?$_POST['postcode']:NULL;
		$phonestd		= (!empty($_POST['phonestd']))?$_POST['phonestd']:NULL;
		$phone			= (!empty($_POST['phone']))?$_POST['phone']:NULL;
		$faxstd			= (!empty($_POST['faxstd']))?$_POST['faxstd']:NULL;
		$fax			= (!empty($_POST['fax']))?$_POST['fax']:NULL;
		$email			= (!empty($_POST['email']))?$_POST['email']:NULL;
		$url			= (!empty($_POST['url']))?$_POST['url']:NULL;
		$description	= (!empty($_POST['description']))?$_POST['description']:NULL;
		$origin			= (!empty($_POST['origin']))?$_POST['origin']:NULL;
		$mobile			= (!empty($_POST['mobile']))?$_POST['mobile']:NULL;
		$contact		= (!empty($_POST['contact']))?$_POST['contact']:NULL;

		$this->page->assign("classification",$classification);
		$this->page->assign("initials",$initials);
		$this->page->assign("name",$name);
		$this->page->assign("Add1",$Add1);
		$this->page->assign("Add2",$Add2);
		$this->page->assign("Add3",$Add3);
		$this->page->assign("street1",$street1);
		$this->page->assign("street2",$street2);
		$this->page->assign("postcode",$postcode);
		$this->page->assign("phonestd",$phonestd);
		$this->page->assign("phone",$phone);
		$this->page->assign("fax",$fax);
		$this->page->assign("faxstd",$faxstd);
		$this->page->assign("email",$email);
		$this->page->assign("url",$url);
		$this->page->assign("description",$description);
		$this->page->assign("origin",$origin);
		$this->page->assign("mobile",$mobile);
		$this->page->assign("contact",$contact);

		$do						= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action					= (!empty($_GET['action']))?$_GET['action']:NULL;

		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);

		$this->listingFacade->popularPageCount("23");
		$this->page->assign("login_url",$this->request->createURL("Business", "login"));
		$this->page->assign("action",$this->request->createURL("Listing", "editAddition","ID"));
		$this->page->assign("logout_url",$this->request->createURL("Business", "doLogout"));
		$this->page->assign("back",$this->request->createURL("Business", "showhomePageBusiness"));
		$this->page->assign("change_password",$this->request->createURL("Business", "changePassword"));
		$this->page->assign("viewlisting",$this->request->createURL("Listing", "viewList"));
		$this->page->assign("listing",$this->request->createURL("Listing", "addListing"));
		$this->page->assign("edit",$this->request->createURL("Business", "Edit","ID"));
		$this->page->assign("delete",$this->request->createURL("Listing", "delete","ID"));
		$this->page->assign("edit_url",$this->request->createURL("Listing", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("Listing", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("Listing", "rankBusiness"));
		$this->page->assign("addMoreAddresses",$this->request->createURL("Listing", "addMoreAddresses","ID"));
		$this->page->assign("manageAddress",$this->request->createURL("Listing", "manageAddress","ID"));
		$this->page->assign("add_keyword",$this->request->createURL("Listing", "add_keyword"));

		$res3 = $this->listingFacade->editListingFetchDetails();
		$this->page->assign("values1",$res3);

		$res1=$this->listingFacade->fetchClassificationDetails();
		$this->page->assign("values2",$res1);

		$regionValue=$this->listingFacade->fetchRegion();
		$this->page->assign("regionValue",$regionValue);

		$res=$this->listingFacade->fetchTownDetails();
		$this->page->assign("values",$res);

		$res2=$this->listingFacade->selectStates();
		$this->page->assign("values21",$res2);

		$rankList=$this->listingFacade->fetchRankRate();
		$this->page->assign("rankList",$rankList);

		$brandResult=$this->listingFacade->fetchBrands();
		$this->page->assign("brandResult",$brandResult);

		$businessBrand=$this->listingFacade->fetchBusinessBrand();
		$this->page->assign("businessBrand",$businessBrand);

		$this->page->getPage('editlisting.tpl');
	}


	/**
	 *  addMoreAddresses
	 *
	 * used to display page to add more address of the particular business.
	 */
	public function addMoreAddresses()
	{
		$this->page->pageTitle = "Add Addresses";
		$Add1			= (!empty($_POST['Add1']))?$_POST['Add1']:NULL;
		$Add2			= (!empty($_POST['Add2']))?$_POST['Add2']:NULL;
		$street1		= (!empty($_POST['street1']))?$_POST['street1']:NULL;
		$street2		= (!empty($_POST['street2']))?$_POST['street2']:NULL;
		$postcode		= (!empty($_POST['postcode']))?$_POST['postcode']:NULL;

		$do						= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action					= (!empty($_GET['action']))?$_GET['action']:NULL;

		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);

		$this->page->assign("edit_url",$this->request->createURL("Listing", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("Listing", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("Listing", "rankBusiness"));
		$this->page->assign("add_keyword",$this->request->createURL("Listing", "add_keyword"));

		$this->page->assign("change_password",$this->request->createURL("Business", "changePassword"));
		$this->page->assign("viewlisting",$this->request->createURL("Listing", "viewList"));
		$this->page->assign("listing",$this->request->createURL("Listing", "addListing"));
		$this->page->assign("edit",$this->request->createURL("Business", "Edit","ID"));

		$res3=$this->listingFacade->editListingFetchDetails();
		$this->page->assign("values12",@$res3);
		$res2=$this->listingFacade->selectStates();
		$this->page->assign("values21",$res2);
		$regionValue=$this->listingFacade->fetchRegion();
		$this->page->assign("regionValue",$regionValue);
		$res=$this->listingFacade->fetchTownDetails();
		$this->page->assign("values",$res);
		$this->page->assign("action",$this->request->createURL("Listing","moreAddressesAdd","ID"));
		$this->page->getPage('multiple_address_add_form.tpl');
	}

	/**
	 *  moreAddressesAdd
	 *
	 * used to add more address of the particular business.
	 */
	public function moreAddressesAdd()
	{
		$this->page->pageTitle = "Add Addresses";
		$do						= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action					= (!empty($_GET['action']))?$_GET['action']:NULL;


		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);

		$this->page->assign("edit_url",$this->request->createURL("Listing", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("Listing", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("Listing", "rankBusiness"));
		$this->page->assign("add_keyword",$this->request->createURL("Listing", "add_keyword"));

		$this->page->assign("change_password",$this->request->createURL("Business", "changePassword"));
		$this->page->assign("viewlisting",$this->request->createURL("Listing", "viewList"));
		$this->page->assign("listing",$this->request->createURL("Listing", "addListing"));
		$this->page->assign("edit",$this->request->createURL("Business", "Edit","ID"));
		$result					= $this->listingFacade->moreAddressesAdd($_POST);
		if($result['result'])
		{
			$this->request->setAttribute("message-succ", $result['message']);
			$this->addMoreAddresses();
		}
		else
		{
			$this->request->setAttribute("message", $result['message']);
			$this->addMoreAddresses();
		}
	}

	/**
	 *  manageAddress
	 *
	 * used to manage address which has been added before.
	 */
	public function manageAddress()
	{
		$this->page->pageTitle = "Addresses";
		$do						= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action					= (!empty($_GET['action']))?$_GET['action']:NULL;

		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);

		$this->page->assign("edit_url",$this->request->createURL("Listing", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("Listing", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("Listing", "rankBusiness"));
		$this->page->assign("add_keyword",$this->request->createURL("Listing", "add_keyword"));

		$this->page->assign("change_password",$this->request->createURL("Business", "changePassword"));
		$this->page->assign("viewlisting",$this->request->createURL("Listing", "viewList"));
		$this->page->assign("listing",$this->request->createURL("Listing", "addListing"));
		$this->page->assign("edit",$this->request->createURL("Business", "Edit","ID"));
		$this->page->assign("editurl",$this->request->createURL("Listing","editAddress"));
		$this->page->assign("delete",$this->request->createURL("Listing","deleteaddress"));
		$result=$this->listingFacade->manageAddress($this->request->getAttribute("fr"));

		$this->page->assign("values",$result['listings']);
		$this->page->assign("paging", $result['paging']);
		$this->page->getPage("addresses_list.tpl");
	}


	/**
	 *  editAddress
	 *
	 * used to edit the address of the business.
	 */
	public function editAddress()
	{
		$this->page->pageTitle = "Edit Addresses";
		$do						= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action					= (!empty($_GET['action']))?$_GET['action']:NULL;

		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);

		$this->page->assign("edit_url",$this->request->createURL("Listing", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("Listing", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("Listing", "rankBusiness"));
		$this->page->assign("add_keyword",$this->request->createURL("Listing", "add_keyword"));

		$this->page->assign("change_password",$this->request->createURL("Business", "changePassword"));
		$this->page->assign("viewlisting",$this->request->createURL("Listing", "viewList"));
		$this->page->assign("listing",$this->request->createURL("Listing", "addListing"));
		$this->page->assign("edit",$this->request->createURL("Business", "Edit","ID"));
			
		$res3					= $this->listingFacade->editaddressFetchDetails();
		$this->page->assign("values12",@$res3[0]);

		$res2					= $this->listingFacade->selectStates();
		$this->page->assign("values21",$res2);

		$regionValue			= $this->listingFacade->fetchRegion();
		$this->page->assign("regionValue",$regionValue);

		$res					= $this->listingFacade->fetchTownDetails();
		$this->page->assign("values",$res);

		$this->page->assign("action",$this->request->createURL("Listing","editAddressesAdd","ID1"));
		$this->page->getPage("edit_addresses.tpl");
	}

	/**
	 *  editAddressesAdd
	 *
	 * used to edit the address of the business.
	 */
	public function editAddressesAdd()
	{
		$this->page->pageTitle 	= "Edit Addresses";
		$do						= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action					= (!empty($_GET['action']))?$_GET['action']:NULL;

		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);

		$this->page->assign("edit_url",$this->request->createURL("Listing", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("Listing", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("Listing", "rankBusiness"));
		$this->page->assign("add_keyword",$this->request->createURL("Listing", "add_keyword"));

		$this->page->assign("change_password",$this->request->createURL("Business", "changePassword"));
		$this->page->assign("viewlisting",$this->request->createURL("Listing", "viewList"));
		$this->page->assign("listing",$this->request->createURL("Listing", "addListing"));
		$this->page->assign("edit",$this->request->createURL("Business", "Edit","ID"));
		$res				    = $this->listingFacade->editAddressesAdd($_POST);
		if($res['result'])
		{
			$this->request->setAttribute("message-succ", $res['message']);
			$this->editAddress();
		}else{
			$this->request->setAttribute("message", $res['message']);
			$this->editAddress();
		}
	}

	/**
	 *  deleteaddress
	 *
	 * used to delete the address of the business.
	 */
	public function deleteaddress()
	{
		$this->page->pageTitle = "Delete Addresses";
		$do						= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action					= (!empty($_GET['action']))?$_GET['action']:NULL;

		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);

		$this->page->assign("edit_url",$this->request->createURL("Listing", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("Listing", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("Listing", "rankBusiness"));
		$this->page->assign("add_keyword",$this->request->createURL("Listing", "add_keyword"));

		$this->page->assign("change_password",$this->request->createURL("Business", "changePassword"));
		$this->page->assign("viewlisting",$this->request->createURL("Listing", "viewList"));
		$this->page->assign("listing",$this->request->createURL("Listing", "addListing"));
		$this->page->assign("edit",$this->request->createURL("Business", "Edit","ID"));
		$res					= $this->listingFacade->deleteaddress();
		if($res['result'])
		{
			$this->request->setAttribute("message-succ", $res['message']);
			$this->manageAddress();
		}else{
			$this->request->setAttribute("message", $res['message']);
			$this->manageAddress();
		}
	}

	/**
	 *  add_keyword
	 *
	 * used to add the keyword of the business.
	 */
	public function add_keyword()
	{
		$this->page->pageTitle = "Add Keyword(s)";
		$do						= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action					= (!empty($_GET['action']))?$_GET['action']:NULL;
		$msg					= (!empty($_GET['msg']))?$_GET['msg']:NULL;

		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$this->page->assign("msg",$msg);

		$this->page->assign("action",$this->request->createURL("Listing", "add_new_keyword","ID"));
		$this->page->assign("deleteAction",$this->request->createURL("Listing", "deleteKeyword","ID"));
		$this->page->assign("add_keyword",$this->request->createURL("Listing", "add_keyword"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("edit_url",$this->request->createURL("Listing", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("Listing", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("Listing", "rankBusiness"));
		$this->page->assign("addbusinessform",$this->request->createURL("Listing", "addListing"));
		$this->page->assign("change_password",$this->request->createURL("Business", "changePassword"));
		$this->page->assign("search",$this->request->createURL("Listing","searchBusiness"));
		$this->page->assign("viewList",$this->request->createURL("Listing","viewList"));
		$this->page->assign("add_keyword",$this->request->createURL("Listing", "add_keyword"));
		$keywordList=$this->listingFacade->fetchKeyword();
		$this->page->assign("keywordList",$keywordList);

		$keyResult=$this->listingFacade->fetchBusinessKeyword($_GET);
		$this->page->assign("keyResult",$keyResult);

		$this->page->getPage('add_new_keyword.tpl');
	}

	/**
	 *  add_new_keyword
	 *
	 * used to add the keyword of the business.
	 */
	public function add_new_keyword()
	{
		$this->page->pageTitle = "Add Keyword";
		$do						= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action					= (!empty($_GET['action']))?$_GET['action']:NULL;
		$msg					= (!empty($_GET['msg']))?$_GET['msg']:NULL;

		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$this->page->assign("msg",$msg);

		$this->page->assign("deleteAction",$this->request->createURL("Listing", "deleteKeyword","ID"));
		$this->page->assign("add_keyword",$this->request->createURL("Listing", "add_keyword"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("change_password",$this->request->createURL("Business", "changePassword"));
		$this->page->assign("edit_url",$this->request->createURL("Listing", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("Listing", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("Listing", "rankBusiness"));
		$this->page->assign("addbusinessform",$this->request->createURL("Listing", "addListing"));
		$this->page->assign("search",$this->request->createURL("Listing","searchBusiness"));
		$this->page->assign("viewList",$this->request->createURL("Listing","viewList"));
		$this->page->assign("add_keyword",$this->request->createURL("Listing", "add_keyword"));
		$classificationAddResult				= $this->listingFacade->add_new_keyword($_POST,$_GET);
		if($classificationAddResult['result'])
		{
			$this->request->redirect("Listing","add_keyword","ID={$classificationAddResult['ID']}&msg=2");
		}
		$this->page->getPage('add_new_keyword.tpl');
	}

	/**
	 *  deleteKeyword
	 *
	 * used to delete the keyword of the business.
	 */
	public function deleteKeyword()
	{
		$this->page->pageTitle = "Delete Keyword";
		$do						= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action					= (!empty($_GET['action']))?$_GET['action']:NULL;
		$msg					= (!empty($_GET['msg']))?$_GET['msg']:NULL;

		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$this->page->assign("msg",$msg);
		$this->page->assign("add_keyword",$this->request->createURL("Listing", "add_keyword"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("edit_url",$this->request->createURL("Listing", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("Listing", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("Listing", "rankBusiness"));
		$this->page->assign("addbusinessform",$this->request->createURL("Listing", "addListing"));
		$this->page->assign("change_password",$this->request->createURL("Business", "changePassword"));
		$this->page->assign("search",$this->request->createURL("Listing","searchBusiness"));
		$this->page->assign("viewList",$this->request->createURL("Listing","viewList"));
		$this->page->assign("add_keyword",$this->request->createURL("Listing", "add_keyword"));

		$classificationDelResult	= $this->listingFacade->deleteKeyword($_POST,$_GET);
		if($classificationDelResult['result'])
		{
			$this->request->redirect("Listing","add_keyword","ID={$classificationDelResult['ID']}&msg=3");
		}else{
			$this->request->setAttribute("message", $classificationDelResult['message']);
			$this->add_keyword();
		}
	}

	/**
	 *  editAddition
	 *
	 * used to edit the details of the business.
	 */
	public function editAddition()
	{
		$do						= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action					= (!empty($_GET['action']))?$_GET['action']:NULL;

		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);

		$this->page->assign("login_url",$this->request->createURL("Business", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Business", "doLogout"));
		$this->page->assign("back",$this->request->createURL("Business", "showhomePageBusiness"));
		$this->page->assign("change_password",$this->request->createURL("Business", "changePassword"));
		$this->page->assign("delete",$this->request->createURL("Listing", "delete","ID"));
		$this->page->assign("listing",$this->request->createURL("Listing", "addListing"));
		$this->page->assign("viewlisting",$this->request->createURL("Listing", "viewList"));
		$this->page->assign("edit",$this->request->createURL("Business", "Edit","ID"));
		$this->page->assign("edit_url",$this->request->createURL("Listing", "Edit"));
		$this->page->assign("delete",$this->request->createURL("Listing", "delete","ID"));

		$image					= $_FILES['logo']['name'];
		$tmp					= $_FILES['logo']['tmp_name'];

		move_uploaded_file($tmp,"admin/View/Default/Images/client_image/$image");
		$res=$this->listingFacade->editListing($_POST,$_FILES);
		if($res['result'])
		{
			$this->request->setAttribute("message-succ", $res['message']);
			$this->Edit();
		}
		else
		{
			$this->request->setAttribute("message", $res['message']);
			$this->Edit();
		}
	}

	/**
	 *  delete
	 *
	 * used to delete the details of the business.
	 */
	public function delete()
	{
		$do						= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action					= (!empty($_GET['action']))?$_GET['action']:NULL;

		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);

		$this->page->assign("login_url",$this->request->createURL("Business", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Business", "doLogout"));
		$this->page->assign("back",$this->request->createURL("Business", "showhomePageBusiness"));
		$this->page->assign("change_password",$this->request->createURL("Business", "changePassword"));
		$this->page->assign("listing",$this->request->createURL("Listing", "addListing"));
		$this->page->assign("viewlisting",$this->request->createURL("Listing", "viewList"));
		$this->page->assign("edit",$this->request->createURL("Business", "Edit","ID"));
		$this->page->assign("edit_url",$this->request->createURL("Listing", "Edit"));
		$this->page->assign("delete",$this->request->createURL("Listing", "delete","ID"));
		$res=$this->listingFacade->delList();
		if($res['result'])
		{
			$this->request->setAttribute("message-succ", $res['message']);
			$res1=$this->listingFacade->viewfetchDetails($this->request->getAttribute("fr"));
			$this->page->assign("values",$res1['listings']);
			$this->page->assign("paging", $res1['paging']);
			$this->page->getPage("listshow.tpl");
		}
		else
		{
		 $this->request->setAttribute("message", $res['message']);
		 $this->viewList();
		}
	}


	/**
	 *  getSuburb
	 *
	 * used to get the details of the suburb.
	 */
	public function getSuburb()
	{
		$result= $this->listingFacade->getSuburb($_GET);
		echo "<option value='--Select One--'>"."--Select One--"."</option>";
		foreach ($result as $value)
		{
			echo "<option value='".$value['shiretown_postcode'].",".$value['shiretown_townname']."'>".$value['shiretown_townname']."</option>";
		}
	}

	/**
	 *  loadAjax
	 *
	 *  Loads classifications
	 */
	public function loadAjax() {

		$this->listingFacade->loadAjax($_GET);

	}/* END loadAjax */

	/**
	 *  demoAddListing
	 *
	 * used to add the demo business details.
	 */
	public function demoAddListing()
	{

		$this->page->pageTitle = "Add Listing";
		$initials		= (!empty($_POST['initials']))?$_POST['initials']:NULL;
		$name			= (!empty($_POST['name']))?$_POST['name']:NULL;
		$street1		= (!empty($_POST['street1']))?$_POST['street1']:NULL;
		$street2		= (!empty($_POST['street2']))?$_POST['street2']:NULL;
		$postcode		= (!empty($_POST['postcode']))?$_POST['postcode']:NULL;
		$phonestd		= (!empty($_POST['phonestd']))?$_POST['phonestd']:NULL;
		$phone			= (!empty($_POST['phone']))?$_POST['phone']:NULL;
		$faxstd			= (!empty($_POST['faxstd']))?$_POST['faxstd']:NULL;
		$fax			= (!empty($_POST['fax']))?$_POST['fax']:NULL;
		$email			= (!empty($_POST['email']))?$_POST['email']:NULL;
		$url			= (!empty($_POST['url']))?$_POST['url']:NULL;
		$description	= (!empty($_POST['description']))?$_POST['description']:NULL;
		$origin			= (!empty($_POST['origin']))?$_POST['origin']:NULL;
		$mobile			= (!empty($_POST['mobile']))?$_POST['mobile']:NULL;
		$contact		= (!empty($_POST['contact']))?$_POST['contact']:NULL;
		$region			= (!empty($_POST['region']))?$_POST['region']:NULL;
		$OlistID		= (!empty($_POST['OlistID']))?$_POST['OlistID']:NULL;

		$this->page->assign("initials",$initials);
		$this->page->assign("name",$name);
		$this->page->assign("street1",$street1);
		$this->page->assign("street2",$street2);
		$this->page->assign("postcode",$postcode);
		$this->page->assign("phonestd",$phonestd);
		$this->page->assign("phone",$phone);
		$this->page->assign("fax",$fax);
		$this->page->assign("faxstd",$faxstd);
		$this->page->assign("email",$email);
		$this->page->assign("url",$url);
		$this->page->assign("description",$description);
		$this->page->assign("origin",$origin);
		$this->page->assign("mobile",$mobile);
		$this->page->assign("contact",$contact);
		$this->page->assign("region",$region);
		$this->page->assign("OlistID",$OlistID);


		$do						= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action					= (!empty($_GET['action']))?$_GET['action']:NULL;

		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);

		$this->listingFacade->popularPageCount("24");
		$this->page->assign("login_url",$this->request->createURL("Business", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Business", "doLogout"));
		$this->page->assign("action",$this->request->createURL("Listing", "demoListingAddition"));
		$this->page->assign("change_password",$this->request->createURL("Business", "changePassword"));
		$this->page->assign("viewlisting",$this->request->createURL("Listing", "viewList"));
		$this->page->assign("listing",$this->request->createURL("Listing", "addListing"));
		$this->page->assign("back",$this->request->createURL("Business", "showhomePageBusiness"));
		$this->page->assign("edit",$this->request->createURL("Business", "Edit","ID"));

		$res1					= $this->listingFacade->fetchClassificationDetails();
		$this->page->assign("values1",$res1);

		$regionValue			= $this->listingFacade->fetchRegion();
		$this->page->assign("regionValue",$regionValue);

		$res					= $this->listingFacade->fetchTownDetails();
		$this->page->assign("values",$res);

		$res2					= $this->listingFacade->selectStates();
		$this->page->assign("values2",$res2);

		$res3					= $this->listingFacade->fetchRank();
		$this->page->assign("rank",$res3[0]['rank']);

		$rankList				= $this->listingFacade->fetchRankRate();
		$this->page->assign("rankList",$rankList);

		$this->page->getPage('demolistingadd.tpl');
	}


	/**
	 *  demoListingAddition
	 *
	 * used to add the demo business details.
	 */
	public function demoListingAddition()
	{
		$do						= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action					= (!empty($_GET['action']))?$_GET['action']:NULL;

		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);

		$this->page->assign("login_url",$this->request->createURL("Business", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Business", "doLogout"));
		$this->page->assign("edit_url",$this->request->createURL("Listing", "Edit","ID"));
		$this->page->assign("change_password",$this->request->createURL("Business", "changePassword"));
		$this->page->assign("delete",$this->request->createURL("Listing", "delete","ID"));
		$this->page->assign("viewlisting",$this->request->createURL("Listing", "viewList"));
		$this->page->assign("listing",$this->request->createURL("Listing", "addListing"));
		$this->page->assign("edit",$this->request->createURL("Business", "Edit","ID"));
		$image=$_FILES['logo']['name'];
		$tmp=$_FILES['logo']['tmp_name'];

		move_uploaded_file($tmp,"View/Default/Images/DemoListing/$image");
		$res=$this->listingFacade->demoAddList($_POST,$_FILES);

		if($res['result']==0)
		{
			$this->request->setAttribute("message", $res['message']);
			$this->demoAddListing();
		}else{
				
			$this->request->redirect("Listing","demoListing","ID={$res['InsertID']}&msg=1");
				
		}
	}

	/**
	 *  demoListing
	 *
	 * used to display the demo listing add format.
	 */
	public function demoListing()
	{
		$do						= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action					= (!empty($_GET['action']))?$_GET['action']:NULL;

		$this->page->assign("do",$do);
		$this->page->assign("action",$action);

		$res=$this->listingFacade->demoListing();
		$this->page->assign("values", $res['blogs']);
		$this->page->getPage('demolisting.tpl');
	}

	/**
	 *  demoBoldListing
	 *
	 * used to display the demo bold listing page.
	 */
	public function demoBoldListing()
	{
		$do            	= $_GET['do'];
		$action			= $_GET['action'];
		$this->page->assign("contactUs",$this->request->createURL("Listing", "contactUs","ID"));
		$res = $this->listingFacade->demoBoldListingResult($_GET);
		$this->page->assign("values",$res);
		$this->page->getPage('demo_bold_listing_search.tpl');
	}/* END boldListing */
}
?>