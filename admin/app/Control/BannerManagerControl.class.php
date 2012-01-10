<?php

/**
   * @title   BannerManagerControl.class.php    
   * @desc    This is an SalesAccountManagerControl class. The purpose of this class is to perform the redirection actions needed for any function/operation to BannerManagerFacade class and also to smarty assign the URL's which were used in the templates as an action, which redirects or calls the particular function passed in the action parameter in the BannerManagerControl class. 
*/
class BannerManagerControl extends MainControl {
    
    private $bannerFacade;

    public function __construct($request) {
	
        parent::__construct($request);
        
        $this->BannerManagerFacade 	= new BannerManagerFacade($GLOBALS['conn']);
        $this->request = $request;
        $this->page = new AdminPage();
    }/* END __construct */



	/**
	*@desc This function is used for view the list of banner that had been added.
	*/	
	public function viewListing()
	{
	    $this->page->pageTitle = "Banners";
		$this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("ClassificationBannerManager",$this->request->createURL("BannerManager","ClassificationBannerManager"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("addClassificationBanner",$this->request->createURL("BannerManager","addClassificationBanner"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("affiliateBannerManager",$this->request->createURL("BannerManager","viewAffilateListing"));
		$this->page->assign("addBanner",$this->request->createURL("BannerManager","addBanner"));
		$this->page->assign("addClassificationBanner",$this->request->createURL("BannerManager","addClassificationBanner"));
		$this->page->assign("link_date",$this->request->createURL("BannerManager", "linkDate","Date"));		
		$this->page->assign("viewReport",$this->request->createURL("BannerManager","viewReport","ID"));
		$this->page->assign("searchClassificationBanner",$this->request->createURL("BannerManager", "searchClassificationBanner"));
		$this->page->assign("classificationBannerReport",$this->request->createURL("BannerManager", "classificationBannerReport"));				
		$this->page->assign("addAffiliateBanner",$this->request->createURL("BannerManager","addAffiliateBanner"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("change_classification_status",$this->request->createURL("BannerManager", "change_classification_status","ID"));
		$this->page->assign("edit_url", "javascript:window.location='".$this->request->createURL("BannerManager", "editBanner","ID"));
		$this->page->assign("edit_classification_url",$this->request->createURL("BannerManager","editClassificationBanner","ID"));
		$this->page->assign("edit_aff_url", "javascript:window.location='".$this->request->createURL("BannerManager", "editAffiliateBanner","ID"));
		$this->page->assign("delete",$this->request->createURL("BannerManager", "deleteBanner","ID"));
		$this->page->assign("delete_aff",$this->request->createURL("BannerManager", "deleteAffiliateBanner","ID"));
		$this->page->assign("change_status",$this->request->createURL("BannerManager", "changeStatus","ID"));
		$bannerArray=$this->BannerManagerFacade->viewListing($this->request->getAttribute("fr"), $this->request->getAttribute(                                                               "pg_size"));
		$this->page->assign("bannerArray",$bannerArray['banner']);
		$this->page->assign("paging",$bannerArray['paging']);		
        $this->page->getPage('banner_listing.tpl');
    }
	
	/**
	*@desc This function is used for view the list of banner that had been added.
	*/	
	public function ClassificationBannerManager()
	{
	    $this->page->pageTitle = "Banners";
		$this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("ClassificationBannerManager",$this->request->createURL("BannerManager","ClassificationBannerManager"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("affiliateBannerManager",$this->request->createURL("BannerManager","viewAffilateListing"));
		$this->page->assign("addBanner",$this->request->createURL("BannerManager","addBanner"));
		$this->page->assign("addClassificationBanner",$this->request->createURL("BannerManager","addClassificationBanner"));
		$this->page->assign("link_date",$this->request->createURL("BannerManager", "linkDate","Date"));		
		$this->page->assign("viewReport",$this->request->createURL("BannerManager","viewReport","ID"));
		$this->page->assign("addAffiliateBanner",$this->request->createURL("BannerManager","addAffiliateBanner"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		
		$this->page->assign("change_classification_status",$this->request->createURL("BannerManager", "change_classification_status","ID"));		
		$this->page->assign("edit_url", "javascript:window.location='".$this->request->createURL("BannerManager", "editBanner","ID"));
		$this->page->assign("edit_classification_url",$this->request->createURL("BannerManager","editClassificationBanner","ID"));
		$this->page->assign("edit_aff_url", "javascript:window.location='".$this->request->createURL("BannerManager", "editAffiliateBanner","ID"));
		$this->page->assign("delete_classification",$this->request->createURL("BannerManager", "deleteClassificationBanner","ID"));
		$this->page->assign("delete_aff",$this->request->createURL("BannerManager", "deleteAffiliateBanner","ID"));
		$this->page->assign("change_status",$this->request->createURL("BannerManager", "changeStatus","ID"));
		$this->page->assign("searchClassificationBanner",$this->request->createURL("BannerManager", "searchClassificationBanner"));
		$this->page->assign("classificationBannerReport",$this->request->createURL("BannerManager", "classificationBannerReport"));		
		$bannerArray=$this->BannerManagerFacade->ClassificationBannerManager($this->request->getAttribute("fr"), $this->request->getAttribute(                                                               "pg_size"));
		$this->page->assign("bannerArray",$bannerArray['banner']);
		$this->page->assign("paging",$bannerArray['paging']);		
        $this->page->getPage('classification_banner_listing.tpl');
    }
	
	public function searchClassificationBanner()
	{
  		$this->page->pageTitle = "Search Classification Banners";
		$this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("ClassificationBannerManager",$this->request->createURL("BannerManager","ClassificationBannerManager"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("affiliateBannerManager",$this->request->createURL("BannerManager","viewAffilateListing"));
		$this->page->assign("addBanner",$this->request->createURL("BannerManager","addBanner"));
		$this->page->assign("addClassificationBanner",$this->request->createURL("BannerManager","addClassificationBanner"));
		$this->page->assign("change_classification_status",$this->request->createURL("BannerManager", "change_classification_status","ID"));		
		$this->page->assign("link_date",$this->request->createURL("BannerManager", "linkDate","Date"));		
		$this->page->assign("addAffiliateBanner",$this->request->createURL("BannerManager","addAffiliateBanner"));
		$this->page->assign("viewReport",$this->request->createURL("BannerManager","viewReport","ID"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("edit_url", "javascript:window.location='".$this->request->createURL("BannerManager", "editBanner","ID"));
		$this->page->assign("delete_search_classification",$this->request->createURL("BannerManager", "deleteSearchClassificationBanner","ID"));			
		$this->page->assign("edit_classification_url",$this->request->createURL("BannerManager","editClassificationBanner","ID"));
		$this->page->assign("edit_aff_url", "javascript:window.location='".$this->request->createURL("BannerManager", "editAffiliateBanner","ID"));
		$this->page->assign("searchClassificationBanner",$this->request->createURL("BannerManager", "searchClassificationBanner"));
		$this->page->assign("classificationBannerReport",$this->request->createURL("BannerManager", "classificationBannerReport"));				
		$this->page->assign("delete",$this->request->createURL("BannerManager", "deleteBanner","ID"));
		$this->page->assign("delete_search_classification",$this->request->createURL("BannerManager", "deleteSearchClassificationBanner","ID"));		
		$this->page->assign("delete_aff",$this->request->createURL("BannerManager", "deleteAffiliateBanner","ID"));		
		$this->page->assign("change_status",$this->request->createURL("BannerManager", "changeStatus","ID"));
		$this->page->assign("change_aff_status",$this->request->createURL("BannerManager", "changeAffStatus","ID"));
		$this->page->assign("action",$this->request->createURL("BannerManager", "searchClassificationBannerDetail"));

		$result=$this->BannerManagerFacade->fetchClassification();
		$this->page->assign("result",$result);			
		
		
        $this->page->getPage('search_classification_banner.tpl');	
	}
	
	public function classificationBannerReport()
	{
  		$this->page->pageTitle = "Classification Banner Report";
		$this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("ClassificationBannerManager",$this->request->createURL("BannerManager","ClassificationBannerManager"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("affiliateBannerManager",$this->request->createURL("BannerManager","viewAffilateListing"));
		$this->page->assign("addBanner",$this->request->createURL("BannerManager","addBanner"));
		$this->page->assign("addClassificationBanner",$this->request->createURL("BannerManager","addClassificationBanner"));
		$this->page->assign("change_classification_status",$this->request->createURL("BannerManager", "change_classification_status","ID"));		
		$this->page->assign("link_date",$this->request->createURL("BannerManager", "linkDate","Date"));		
		$this->page->assign("addAffiliateBanner",$this->request->createURL("BannerManager","addAffiliateBanner"));
		$this->page->assign("viewReport",$this->request->createURL("BannerManager","viewReport","ID"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("edit_url", "javascript:window.location='".$this->request->createURL("BannerManager", "editBanner","ID"));
		$this->page->assign("delete_search_classification",$this->request->createURL("BannerManager", "deleteSearchClassificationBanner","ID"));			
		$this->page->assign("edit_classification_url",$this->request->createURL("BannerManager","editClassificationBanner","ID"));
		$this->page->assign("edit_aff_url", "javascript:window.location='".$this->request->createURL("BannerManager", "editAffiliateBanner","ID"));
		$this->page->assign("searchClassificationBanner",$this->request->createURL("BannerManager", "searchClassificationBanner"));
		$this->page->assign("classificationBannerReport",$this->request->createURL("BannerManager", "classificationBannerReport"));				
		$this->page->assign("delete",$this->request->createURL("BannerManager", "deleteBanner","ID"));
		$this->page->assign("delete_search_classification",$this->request->createURL("BannerManager", "deleteSearchClassificationBanner","ID"));		
		$this->page->assign("delete_aff",$this->request->createURL("BannerManager", "deleteAffiliateBanner","ID"));		
		$this->page->assign("change_status",$this->request->createURL("BannerManager", "changeStatus","ID"));
		$this->page->assign("change_aff_status",$this->request->createURL("BannerManager", "changeAffStatus","ID"));
		$this->page->assign("action",$this->request->createURL("BannerManager", "searchClassificationBannerDetail"));

/*		
	    $this->page->assign("Date", $this->BannerManagerFacade->getDates());			
	    $this->page->assign("ToDate",$this->BannerManagerFacade->getDates());					
		
	    $this->page->assign("Month",$this->BannerManagerFacade->getMonths());			
	    $this->page->assign("ToMonth",$this->BannerManagerFacade->getMonths());					
		
	    $this->page->assign("Year",$this->BannerManagerFacade->getYears());			
	    $this->page->assign("ToYear",$this->BannerManagerFacade->getYears());							
*/		


        //Form Validation for online report
        if(isset($_POST['from_date']) && isset($_POST['to_date']) && isset($_POST['markets']) && isset($_POST['classifications'])){
		
				  
		  $this->page->assign("from_date", $_POST['from_date']);		  
		  $this->page->assign("to_date",   $_POST['to_date']);				  		  
		  
		  $marketName         = $this->BannerManagerFacade->getMarketFromID($_POST['markets']);
		  $classificationName = $this->BannerManagerFacade->getClassificationFromID($_POST['classifications']);		  
		  
		  $this->page->assign("selectedMarkets", $marketName[0]['market_name']);
		  $this->page->assign("selectedClassifications", ucwords(strtolower($classificationName[0]['localclassification_name'])));		  
		  
		  $results = $this->BannerManagerFacade->getOnlineBannerReport($_POST['from_date'], $_POST['to_date'], $_POST['markets'], $_POST['classifications']);		 
/*		  
		  foreach($results as $result){
		    foreach($result as $values){
		      foreach($values as $value){
			    print_r($value['position']);
			  }
			}
		  }
*/		  
		  $this->page->assign("onlineReport", $results);
		  		  
		}
		
		//Form Validation for download report
		if(isset($_POST['dlfrom_date']) && isset($_POST['dlto_date'])){
		  
		  $downloadReport = $this->BannerManagerFacade->getDownloadBannerReport($_POST['dlfrom_date'], $_POST['dlto_date']);		  		 
		
		  header("Content-type: application/octet-stream");
		  header("Content-Disposition: attachment; filename=\"ClassificationBannerReport.csv\"");
		  echo "Account ID, Business Name, Banner Title, Market,Classification Code, Classification Name, Position, Start Date, End Date" . "\n";		  
		  
		  foreach($downloadReport as $reportEntries){
		    foreach(array_values($reportEntries) as $values){
			  echo "$values" ."," ;
			}
			echo "\n";
		  }		  
		  
		  echo "\n";
		  exit;

		}
      
				
		$classifications = $this->BannerManagerFacade->fetchClassification();
		
		$this->page->assign("classifications", $classifications);
		
		$markets = $this->BannerManagerFacade->fetchMarkets();
		
		$this->page->assign("markets", $markets);
		
		$this->page->addCssStyle("jquery-ui-1.7.1.custom.css");
		
		$this->page->removeJsFile("prototype.1.6.js");
		$this->page->addJsFile("jquery-1.3.2.min.js");
		$this->page->addJsFile("ui.core.js");
		$this->page->addJsFile("ui.datepicker.js");
		
		$this->page->getPage('classification_banner_report.tpl');
	}	
	
	public function searchClassificationBannerDetail()
	{
		$this->page->pageTitle = "Classification Banners Listing";
		$this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("ClassificationBannerManager",$this->request->createURL("BannerManager","ClassificationBannerManager"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("affiliateBannerManager",$this->request->createURL("BannerManager","viewAffilateListing"));
		$this->page->assign("addBanner",$this->request->createURL("BannerManager","addBanner"));
		$this->page->assign("addClassificationBanner",$this->request->createURL("BannerManager","addClassificationBanner"));
		$this->page->assign("change_search_classification_status",$this->request->createURL("BannerManager", "change_search_classification_status","ID"));			
		$this->page->assign("link_date",$this->request->createURL("BannerManager", "linkDate","Date"));		
		$this->page->assign("addAffiliateBanner",$this->request->createURL("BannerManager","addAffiliateBanner"));
		$this->page->assign("viewReport",$this->request->createURL("BannerManager","viewReport","ID"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("edit_url", "javascript:window.location='".$this->request->createURL("BannerManager", "editBanner","ID"));
		$this->page->assign("delete_search_classification",$this->request->createURL("BannerManager", "deleteSearchClassificationBanner","ID"));	
		
		$this->page->assign("edit_classification_url",$this->request->createURL("BannerManager","editClassificationBanner","ID"));
		$this->page->assign("edit_aff_url", "javascript:window.location='".$this->request->createURL("BannerManager", "editAffiliateBanner","ID"));
		$this->page->assign("searchClassificationBanner",$this->request->createURL("BannerManager", "searchClassificationBanner"));
		$this->page->assign("classificationBannerReport",$this->request->createURL("BannerManager", "classificationBannerReport"));				
		$this->page->assign("delete",$this->request->createURL("BannerManager", "deleteBanner","ID"));
		$this->page->assign("delete_aff",$this->request->createURL("BannerManager", "deleteAffiliateBanner","ID"));		
		$this->page->assign("change_status",$this->request->createURL("BannerManager", "changeStatus","ID"));
		$this->page->assign("change_aff_status",$this->request->createURL("BannerManager", "changeAffStatus","ID"));
			
		$result = $this->BannerManagerFacade->searchClassificationBannerDetail($_GET);
			
		$this->page->assign("count",count($result));
		$this->page->assign("values",$result);
		$this->page->getpage('search_classification_banner_listing.tpl');
	
	}	
	
	


	/**
	*@desc This function is used for list the details of banner which are related to affiliates.
	*/		
	public function viewAffilateListing()
	{
	    $this->page->pageTitle = "Affiliate Banners";
		$this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("ClassificationBannerManager",$this->request->createURL("BannerManager","ClassificationBannerManager"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("affiliateBannerManager",$this->request->createURL("BannerManager","viewAffilateListing"));
		$this->page->assign("addBanner",$this->request->createURL("BannerManager","addBanner"));
		$this->page->assign("addClassificationBanner",$this->request->createURL("BannerManager","addClassificationBanner"));
		$this->page->assign("change_classification_status",$this->request->createURL("BannerManager", "change_classification_status","ID"));		
		$this->page->assign("link_date",$this->request->createURL("BannerManager", "linkDate","Date"));		
		$this->page->assign("addAffiliateBanner",$this->request->createURL("BannerManager","addAffiliateBanner"));
		$this->page->assign("viewReport",$this->request->createURL("BannerManager","viewReport","ID"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("edit_url", "javascript:window.location='".$this->request->createURL("BannerManager", "editBanner","ID"));
		$this->page->assign("edit_classification_url",$this->request->createURL("BannerManager","editClassificationBanner","ID"));
		$this->page->assign("edit_aff_url", "javascript:window.location='".$this->request->createURL("BannerManager", "editAffiliateBanner","ID"));
		$this->page->assign("searchClassificationBanner",$this->request->createURL("BannerManager", "searchClassificationBanner"));
		$this->page->assign("classificationBannerReport",$this->request->createURL("BannerManager", "classificationBannerReport"));				
		$this->page->assign("delete",$this->request->createURL("BannerManager", "deleteBanner","ID"));
		$this->page->assign("delete_aff",$this->request->createURL("BannerManager", "deleteAffiliateBanner","ID"));		
		$this->page->assign("change_status",$this->request->createURL("BannerManager", "changeStatus","ID"));
		$this->page->assign("change_aff_status",$this->request->createURL("BannerManager", "changeAffStatus","ID"));
		$bannerArray=$this->BannerManagerFacade->viewAffilateListing($this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"));
		$this->page->assign("bannerArray",$bannerArray['banner']);
		$this->page->assign("paging",$bannerArray['paging']);		
        $this->page->getPage('affiliate_banner_listing.tpl');
    }
	
		
	
	
	/**
	*@desc This function is used for changing the status of the banner.
	*/		
 public function changeStatus()
    {
		$this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("ClassificationBannerManager",$this->request->createURL("BannerManager","ClassificationBannerManager"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("affiliateBannerManager",$this->request->createURL("BannerManager","viewAffilateListing"));
		$this->page->assign("addBanner",$this->request->createURL("BannerManager","addBanner"));
		$this->page->assign("addClassificationBanner",$this->request->createURL("BannerManager","addClassificationBanner"));
		$this->page->assign("link_date",$this->request->createURL("BannerManager", "linkDate","Date"));		
		$this->page->assign("viewReport",$this->request->createURL("BannerManager","viewReport","ID"));
		$this->page->assign("addAffiliateBanner",$this->request->createURL("BannerManager","addAffiliateBanner"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("change_classification_status",$this->request->createURL("BannerManager", "change_classification_status","ID"));	
		$this->page->assign("searchClassificationBanner",$this->request->createURL("BannerManager", "searchClassificationBanner"));	
		$this->page->assign("classificationBannerReport",$this->request->createURL("BannerManager", "classificationBannerReport"));				
		$this->page->assign("edit_url", "javascript:window.location='".$this->request->createURL("BannerManager", "editBanner","ID"));
		$this->page->assign("edit_classification_url",$this->request->createURL("BannerManager","editClassificationBanner","ID"));
		$this->page->assign("edit_aff_url", "javascript:window.location='".$this->request->createURL("BannerManager", "editAffiliateBanner","ID"));		
		$this->page->assign("delete",$this->request->createURL("BannerManager", "deleteBanner","ID"));
		$this->page->assign("delete_aff",$this->request->createURL("BannerManager", "deleteAffiliateBanner","ID"));		
		$this->page->assign("change_status",$this->request->createURL("BannerManager", "changeStatus","ID"));
		$bannerArray=$this->BannerManagerFacade->changeStatus($_GET);
		
				if($bannerArray['result'])
		{
		   $this->request->setAttribute("message-succ", $bannerArray['message']);
		   $this->request->redirect("BannerManager","viewListing");
		   //$this->viewListing();
		}
		
		//$bannerArray=$this->BannerManagerFacade->viewListing($this->request->getAttribute("fr"), $this->request->getAttribute(                                                               "pg_size"));
		//var_dump($bannerArray['paging']);
		//$this->page->assign("bannerArray",$bannerArray['banner']);
		//$this->page->assign("paging",$bannerArray['paging']);		
        //$this->page->getPage('banner_listing.tpl');
    }
	
	
	/**
	*@desc This function is used for changing the status of the banner.
	*/		
 public function change_classification_status()
    {
		
		$this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("ClassificationBannerManager",$this->request->createURL("BannerManager","ClassificationBannerManager"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("addClassificationBanner",$this->request->createURL("BannerManager","addClassificationBanner"));
		$this->page->assign("affiliateBannerManager",$this->request->createURL("BannerManager","viewAffilateListing"));
		$this->page->assign("addBanner",$this->request->createURL("BannerManager","addBanner"));
		$this->page->assign("link_date",$this->request->createURL("BannerManager", "linkDate","Date"));		
		$this->page->assign("viewReport",$this->request->createURL("BannerManager","viewReport","ID"));
		$this->page->assign("addAffiliateBanner",$this->request->createURL("BannerManager","addAffiliateBanner"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("searchClassificationBanner",$this->request->createURL("BannerManager", "searchClassificationBanner"));
		$this->page->assign("change_classification_status",$this->request->createURL("BannerManager", "change_classification_status","ID"));		
		$this->page->assign("edit_url", "javascript:window.location='".$this->request->createURL("BannerManager", "editBanner","ID"));
		$this->page->assign("edit_classification_url",$this->request->createURL("BannerManager","editClassificationBanner","ID"));
		$this->page->assign("edit_aff_url", "javascript:window.location='".$this->request->createURL("BannerManager", "editAffiliateBanner","ID"));		
		$this->page->assign("delete",$this->request->createURL("BannerManager", "deleteBanner","ID"));
		$this->page->assign("delete_aff",$this->request->createURL("BannerManager", "deleteAffiliateBanner","ID"));		
		$this->page->assign("change_status",$this->request->createURL("BannerManager", "changeStatus","ID"));
		$bannerArray=$this->BannerManagerFacade->change_classification_status($_GET);
		
				if($bannerArray['result'])
		{
		   $this->request->setAttribute("message-succ", $bannerArray['message']);
		   $this->request->redirect("BannerManager","ClassificationBannerManager");
		   //$this->viewListing();
		}
		
		//$bannerArray=$this->BannerManagerFacade->viewListing($this->request->getAttribute("fr"), $this->request->getAttribute(                                                               "pg_size"));
		//var_dump($bannerArray['paging']);
		//$this->page->assign("bannerArray",$bannerArray['banner']);
		//$this->page->assign("paging",$bannerArray['paging']);		
        //$this->page->getPage('banner_listing.tpl');
    }
	
	/**
	*@desc This function is used for changing the status of the banner.
	*/		
 public function change_search_classification_status()
    {
		$this->page->pageTitle = "Classification Banner Listing";
		$this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("ClassificationBannerManager",$this->request->createURL("BannerManager","ClassificationBannerManager"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("addClassificationBanner",$this->request->createURL("BannerManager","addClassificationBanner"));
		$this->page->assign("affiliateBannerManager",$this->request->createURL("BannerManager","viewAffilateListing"));
		$this->page->assign("addBanner",$this->request->createURL("BannerManager","addBanner"));
		$this->page->assign("link_date",$this->request->createURL("BannerManager", "linkDate","Date"));		
		$this->page->assign("viewReport",$this->request->createURL("BannerManager","viewReport","ID"));
		$this->page->assign("addAffiliateBanner",$this->request->createURL("BannerManager","addAffiliateBanner"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("searchClassificationBanner",$this->request->createURL("BannerManager", "searchClassificationBanner"));
		$this->page->assign("change_search_classification_status",$this->request->createURL("BannerManager", "change_search_classification_status","ID"));		
		$this->page->assign("edit_url", "javascript:window.location='".$this->request->createURL("BannerManager", "editBanner","ID"));
		$this->page->assign("edit_classification_url",$this->request->createURL("BannerManager","editClassificationBanner","ID"));
		$this->page->assign("edit_aff_url", "javascript:window.location='".$this->request->createURL("BannerManager", "editAffiliateBanner","ID"));		
		$this->page->assign("delete",$this->request->createURL("BannerManager", "deleteBanner","ID"));
		$this->page->assign("delete_aff",$this->request->createURL("BannerManager", "deleteAffiliateBanner","ID"));		
		$this->page->assign("change_status",$this->request->createURL("BannerManager", "changeStatus","ID"));
		$this->page->assign("delete_search_classification",$this->request->createURL("BannerManager", "deleteSearchClassificationBanner","ID"));			
		$result=$this->BannerManagerFacade->change_classification_status($_GET);
		
		if($result['result'])
		{
		$this->request->setAttribute("message-succ", $result['message']);
		$bannerArray		= $this->BannerManagerFacade->searchClassificationBannerDetail($_GET);
		$count				= count($bannerArray);
		$this->page->assign("count",$count);
		$this->page->assign("values",$bannerArray);
		}
        $this->page->getPage('search_classification_banner_listing.tpl'); 
    }	
	
	/**
	*@desc This function is used for changing the status of the banner which are associated to the affiliates.
	*/		
	public function changeAffStatus()
	{
		$this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("change_classification_status",$this->request->createURL("BannerManager", "change_classification_status","ID"));
		$this->page->assign("searchClassificationBanner",$this->request->createURL("BannerManager", "searchClassificationBanner"));		
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("affiliateBannerManager",$this->request->createURL("BannerManager","viewAffilateListing"));
		$this->page->assign("addBanner",$this->request->createURL("BannerManager","addBanner"));
		$this->page->assign("link_date",$this->request->createURL("BannerManager", "linkDate","Date"));		
		$this->page->assign("viewReport",$this->request->createURL("BannerManager","viewReport","ID"));
		$this->page->assign("ClassificationBannerManager",$this->request->createURL("BannerManager","ClassificationBannerManager"));
		$this->page->assign("addAffiliateBanner",$this->request->createURL("BannerManager","addAffiliateBanner"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("addClassificationBanner",$this->request->createURL("BannerManager","addClassificationBanner"));
		$this->page->assign("edit_url", "javascript:window.location='".$this->request->createURL("BannerManager", "editBanner","ID"));
		$this->page->assign("edit_classification_url",$this->request->createURL("BannerManager","editClassificationBanner","ID"));
		$this->page->assign("edit_aff_url", "javascript:window.location='".$this->request->createURL("BannerManager", "editAffiliateBanner","ID"));		
		$this->page->assign("delete",$this->request->createURL("BannerManager", "deleteBanner","ID"));
		$this->page->assign("delete_aff",$this->request->createURL("BannerManager", "deleteAffiliateBanner","ID"));		
		$this->page->assign("change_status",$this->request->createURL("BannerManager", "changeStatus","ID"));
		$this->page->assign("change_aff_status",$this->request->createURL("BannerManager", "changeAffStatus","ID"));
		$bannerArray=$this->BannerManagerFacade->changeAffStatus($_GET);
		
				if($bannerArray['result'])
		{
		   $this->request->setAttribute("message-succ", $bannerArray['message']);
		   $this->request->redirect("BannerManager","viewAffilateListing"); 
		}		
    }		
	
	
	/**
	*@desc This function is used for adding the banner details.
	*/		
	public function addBanner()
	{
	    $this->page->pageTitle = "Add Site Banner";
		$title			= (!empty($_POST['title']))?$_POST['title']:NULL;
		$description	= (!empty($_POST['description']))?$_POST['description']:NULL;
		$width			= (!empty($_POST['width']))?$_POST['width']:NULL;
		$height			= (!empty($_POST['height']))?$_POST['height']:NULL;
		$alttext		= (!empty($_POST['alttext']))?$_POST['alttext']:NULL;
		$link			= (!empty($_POST['link']))?$_POST['link']:NULL;
		$page			= (!empty($_POST['page']))?$_POST['page']:NULL;
		$position		= (!empty($_POST['position']))?$_POST['position']:NULL;
		
		$this->page->assign("title",$title);
		$this->page->assign("description",$description);
		$this->page->assign("width",$width);
		$this->page->assign("height",$height);
		$this->page->assign("alttext",$alttext);
		$this->page->assign("link",$link);
		$this->page->assign("page",$page);
		$this->page->assign("position",$position);
		
		$this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("change_classification_status",$this->request->createURL("BannerManager", "change_classification_status","ID"));
		$this->page->assign("searchClassificationBanner",$this->request->createURL("BannerManager", "searchClassificationBanner"));	
		$this->page->assign("ClassificationBannerManager",$this->request->createURL("BannerManager","ClassificationBannerManager"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("affiliateBannerManager",$this->request->createURL("BannerManager","viewAffilateListing"));
		$this->page->assign("addBanner",$this->request->createURL("BannerManager","addBanner"));
		$this->page->assign("edit_classification_url",$this->request->createURL("BannerManager","editClassificationBanner","ID"));
		$this->page->assign("link_date",$this->request->createURL("BannerManager", "linkDate","Date"));		
		$this->page->assign("viewReport",$this->request->createURL("BannerManager","viewReport","ID"));
		$this->page->assign("addClassificationBanner",$this->request->createURL("BannerManager","addClassificationBanner"));
		$this->page->assign("addAffiliateBanner",$this->request->createURL("BannerManager","addAffiliateBanner"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("action",$this->request->createURL("BannerManager", "addBannerDetails"));
		
		$result=$this->BannerManagerFacade->fetchClassification();
		$this->page->assign("result",$result);
		
		$resultGroup=$this->BannerManagerFacade->fetchGroup();
		$this->page->assign("resultGroup",$resultGroup);
		
		$resultRegion=$this->BannerManagerFacade->fetchRegion();
		$this->page->assign("resultRegion",$resultRegion);		
				
        $this->page->getPage('add_banner.tpl');
    }
	
	public function addClassificationBanner()
	{
		$this->page->pageTitle = "Add Classification Banner";
		$title			= (!empty($_POST['title']))?$_POST['title']:NULL;
		$description	= (!empty($_POST['description']))?$_POST['description']:NULL;
		$width			= (!empty($_POST['width']))?$_POST['width']:NULL;
		$height			= (!empty($_POST['height']))?$_POST['height']:NULL;
		$alttext		= (!empty($_POST['alttext']))?$_POST['alttext']:NULL;
		$link			= (!empty($_POST['link']))?$_POST['link']:NULL;
		$page			= (!empty($_POST['page']))?$_POST['page']:NULL;
		$position		= (!empty($_POST['position']))?$_POST['position']:NULL;
		
		$this->page->assign("title",$title);
		$this->page->assign("description",$description);
		$this->page->assign("width",$width);
		$this->page->assign("height",$height);
		$this->page->assign("alttext",$alttext);
		$this->page->assign("link",$link);
		$this->page->assign("page",$page);
		$this->page->assign("position",$position);
		
		$this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("change_classification_status",$this->request->createURL("BannerManager", "change_classification_status","ID"));
		$this->page->assign("searchClassificationBanner",$this->request->createURL("BannerManager", "searchClassificationBanner"));
		$this->page->assign("edit_classification_url",$this->request->createURL("BannerManager","editClassificationBanner","ID"));
		$this->page->assign("ClassificationBannerManager",$this->request->createURL("BannerManager","ClassificationBannerManager"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("affiliateBannerManager",$this->request->createURL("BannerManager","viewAffilateListing"));
		$this->page->assign("addBanner",$this->request->createURL("BannerManager","addBanner"));
		$this->page->assign("addClassificationBanner",$this->request->createURL("BannerManager","addClassificationBanner"));
		$this->page->assign("classificationBannerReport",$this->request->createURL("BannerManager", "classificationBannerReport"));						
		$this->page->assign("link_date",$this->request->createURL("BannerManager", "linkDate","Date"));		
		$this->page->assign("viewReport",$this->request->createURL("BannerManager","viewReport","ID"));
		$this->page->assign("addAffiliateBanner",$this->request->createURL("BannerManager","addAffiliateBanner"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("action",$this->request->createURL("BannerManager", "addClassificationBannerDetails"));
		
		$this->page->assign("accountIDs", $this->BannerManagerFacade->getAccountIDs());
		
		$result=$this->BannerManagerFacade->fetchClassification();
		$this->page->assign("result",$result);	
		
		$markets=$this->BannerManagerFacade->fetchMarkets();
		$this->page->assign("markets", $markets);		
				
        $this->page->getPage('add_classification_banner.tpl');	
	}
	
	public function getPosition()
	{
		$position				=array('A'=>'A','B'=>'B','C'=>'C','D'=>'D','E'=>'E');
		$result					= $this->BannerManagerFacade->getPosition($_GET);
				
		foreach($result	as $res){
			unset($position[$res["position"]]);
		}
		
		echo "<option value='0'>"."--Select One--"."</option>";
		foreach ($position as $key=>$value)
		{
		
		echo "<option value='".$key."'>".$value."</option>";
		}	
	}
	
	public function getRegionsFromMarkets($market_id){	  
	  $regions = $this->fetchRegionsFromMarket($market_id);
	  
	  foreach($regions as $region){
	    echo '<option value="{$region}" {if $smarty.get.markets eq $markets[row].market_id} selected="selected" {/if} >{$markets[row].market_name}</option>';              		    
	  }
	  
	}
	
	
	/**
	*@desc This function is used for adding the details of the banner.
	*/		
	public function addBannerDetails()
	{   
		$this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("change_classification_status",$this->request->createURL("BannerManager", "change_classification_status","ID"));		
		$this->page->assign("ClassificationBannerManager",$this->request->createURL("BannerManager","ClassificationBannerManager"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("affiliateBannerManager",$this->request->createURL("BannerManager","viewAffilateListing"));
		$this->page->assign("addBanner",$this->request->createURL("BannerManager","addBanner"));
		$this->page->assign("edit_classification_url",$this->request->createURL("BannerManager","editClassificationBanner","ID"));
		$this->page->assign("link_date",$this->request->createURL("BannerManager", "linkDate","Date"));
		$this->page->assign("addClassificationBanner",$this->request->createURL("BannerManager","addClassificationBanner"));		
		$this->page->assign("viewReport",$this->request->createURL("BannerManager","viewReport","ID"));
		$this->page->assign("addAffiliateBanner",$this->request->createURL("BannerManager","addAffiliateBanner"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("searchClassificationBanner",$this->request->createURL("BannerManager", "searchClassificationBanner"));
		$this->page->assign("action",$this->request->createURL("BannerManager", "addBannerDetails"));
		$res=$this->BannerManagerFacade->addBannerDetails($_POST,$_FILES);
		
		if($res['result'])
		{
		   $this->request->setAttribute("message-succ", $res['message']);
		   $this->addBanner();
		}
		else{
			$this->request->setAttribute("message", $res['message']);
			$this->addBanner();}			
	}
	
	public function addClassificationBannerDetails()
	{
		$this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("affiliateBannerManager",$this->request->createURL("BannerManager","viewAffilateListing"));
		$this->page->assign("addBanner",$this->request->createURL("BannerManager","addBanner"));
		$this->page->assign("addClassificationBanner",$this->request->createURL("BannerManager","addClassificationBanner"));
		$this->page->assign("ClassificationBannerManager",$this->request->createURL("BannerManager","ClassificationBannerManager"));
		$this->page->assign("searchClassificationBanner",$this->request->createURL("BannerManager", "searchClassificationBanner"));
		$this->page->assign("link_date",$this->request->createURL("BannerManager", "linkDate","Date"));		
		$this->page->assign("viewReport",$this->request->createURL("BannerManager","viewReport","ID"));
		$this->page->assign("edit_classification_url",$this->request->createURL("BannerManager","editClassificationBanner","ID"));
		$this->page->assign("addAffiliateBanner",$this->request->createURL("BannerManager","addAffiliateBanner"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("action",$this->request->createURL("BannerManager", "addBannerDetails"));
		$res=$this->BannerManagerFacade->addClassificationBannerDetails($_POST,$_FILES);
		
		if($res['result']){
		   $this->request->setAttribute("message-succ", $res['message']);
		   $this->addClassificationBanner();
		}else{
			$this->request->setAttribute("message", $res['message']);
			$this->addClassificationBanner();
			}	
	}
	
	
	/**
	*@desc This function is used for adding affiliate banner.
	*/		
	public function addAffiliateBanner()
	{	    
		$this->page->pageTitle 	= "Add affiliate banner";
		$title					= (!empty($_POST['title']))?$_POST['title']:NULL;		
		$width					= (!empty($_POST['width']))?$_POST['width']:NULL;
		$height					= (!empty($_POST['height']))?$_POST['height']:NULL;
		$alttext				= (!empty($_POST['alttext']))?$_POST['alttext']:NULL;

		$this->page->assign("title",$title);		
		$this->page->assign("width",$width);
		$this->page->assign("height",$height);
		$this->page->assign("alttext",$alttext);

		$this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("affiliateBannerManager",$this->request->createURL("BannerManager","viewAffilateListing"));
		$this->page->assign("addBanner",$this->request->createURL("BannerManager","addBanner"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("change_classification_status",$this->request->createURL("BannerManager", "change_classification_status","ID"));
		$this->page->assign("searchClassificationBanner",$this->request->createURL("BannerManager", "searchClassificationBanner"));	
		$this->page->assign("edit_classification_url",$this->request->createURL("BannerManager","editClassificationBanner","ID"));
		$this->page->assign("ClassificationBannerManager",$this->request->createURL("BannerManager","ClassificationBannerManager"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("addClassificationBanner",$this->request->createURL("BannerManager","addClassificationBanner"));
		$this->page->assign("link_date",$this->request->createURL("BannerManager", "linkDate","Date"));		
		$this->page->assign("viewReport",$this->request->createURL("BannerManager","viewReport","ID"));
		$this->page->assign("addAffiliateBanner",$this->request->createURL("BannerManager","addAffiliateBanner"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("action",$this->request->createURL("BannerManager", "addAffiliateBannerDetails"));
        $this->page->getPage('add_affiliate_banner.tpl');
    }


	/**
	*@desc This function is used for adding the details of the affiliate banner.
	*/		
	public function addAffiliateBannerDetails()
	{   
		$this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("affiliateBannerManager",$this->request->createURL("BannerManager","viewAffilateListing"));
		$this->page->assign("addBanner",$this->request->createURL("BannerManager","addBanner"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("addClassificationBanner",$this->request->createURL("BannerManager","addClassificationBanner"));
		$this->page->assign("edit_classification_url",$this->request->createURL("BannerManager","editClassificationBanner","ID"));
		$this->page->assign("ClassificationBannerManager",$this->request->createURL("BannerManager","ClassificationBannerManager"));
		$this->page->assign("searchClassificationBanner",$this->request->createURL("BannerManager", "searchClassificationBanner"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("link_date",$this->request->createURL("BannerManager", "linkDate","Date"));		
		$this->page->assign("viewReport",$this->request->createURL("BannerManager","viewReport","ID"));
		$this->page->assign("addAffiliateBanner",$this->request->createURL("BannerManager","addAffiliateBanner"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("action",$this->request->createURL("BannerManager", "addBannerDetails"));
		$res=$this->BannerManagerFacade->addAffiliateBannerDetails($_POST,$_FILES);
		
		if($res['result'])
		{
		   $this->request->setAttribute("message-succ", $res['message']);
		   $this->addAffiliateBanner();
		}
		else{
			$this->request->setAttribute("message", $res['message']);
			$this->addAffiliateBanner();}
				
	}	
	


	/**
	*@desc This function is used for editing the details of the banner.
	*/		
	public function editBanner()
	{
	    $this->page->pageTitle = "Edit banner";
		$this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("link_date",$this->request->createURL("BannerManager", "linkDate","Date"));		
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("edit_classification_url",$this->request->createURL("BannerManager","editClassificationBanner","ID"));
		$this->page->assign("ClassificationBannerManager",$this->request->createURL("BannerManager","ClassificationBannerManager"));
		$this->page->assign("searchClassificationBanner",$this->request->createURL("BannerManager", "searchClassificationBanner"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("addClassificationBanner",$this->request->createURL("BannerManager","addClassificationBanner"));
		$this->page->assign("affiliateBannerManager",$this->request->createURL("BannerManager","viewAffilateListing"));
		$this->page->assign("addBanner",$this->request->createURL("BannerManager","addBanner"));
		$this->page->assign("viewReport",$this->request->createURL("BannerManager","viewReport","ID"));
		$this->page->assign("addAffiliateBanner",$this->request->createURL("BannerManager","addAffiliateBanner"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("action",$this->request->createURL("BannerManager", "editBannerDetails","ID"));
		$this->page->assign("removeBanner",$this->request->createURL("BannerManager", "removeBanner","ID"));
		
		$result=$this->BannerManagerFacade->fetchClassification();
		$this->page->assign("result",$result);
		
		$resultGroup=$this->BannerManagerFacade->fetchGroup();
		$this->page->assign("resultGroup",$resultGroup);
		
		$resultRegion=$this->BannerManagerFacade->fetchRegion();
		//pre($resultRegion);
		$this->page->assign("resultRegion",$resultRegion);		
		
		
		$selectedListing=$this->BannerManagerFacade->selectedListing($_GET);
		$this->page->assign("selectedListing",$selectedListing);
        $this->page->getPage('edit_banner.tpl');
    }

	/**
	*@desc This function is used for editing the details of the banner.
	*/		
	public function editClassificationBanner()
	{
	    $this->page->pageTitle = "Edit Classification banner";
		$this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("link_date",$this->request->createURL("BannerManager", "linkDate","Date"));		
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("edit_classification_url",$this->request->createURL("BannerManager","editClassificationBanner","ID"));
		$this->page->assign("ClassificationBannerManager",$this->request->createURL("BannerManager","ClassificationBannerManager"));
		$this->page->assign("searchClassificationBanner",$this->request->createURL("BannerManager", "searchClassificationBanner"));
		$this->page->assign("removeClassificationBanner",$this->request->createURL("BannerManager","removeClassificationBanner","ID"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("addClassificationBanner",$this->request->createURL("BannerManager","addClassificationBanner"));
		$this->page->assign("affiliateBannerManager",$this->request->createURL("BannerManager","viewAffilateListing"));
		$this->page->assign("addBanner",$this->request->createURL("BannerManager","addBanner"));
		$this->page->assign("viewReport",$this->request->createURL("BannerManager","viewReport","ID"));
		$this->page->assign("addAffiliateBanner",$this->request->createURL("BannerManager","addAffiliateBanner"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("action",$this->request->createURL("BannerManager", "editClassificationBannerDetails","ID"));
		$this->page->assign("removeBanner",$this->request->createURL("BannerManager", "removeBanner","ID"));
		
		$result=$this->BannerManagerFacade->fetchClassification();
		$this->page->assign("result",$result);

		$selectedListing=$this->BannerManagerFacade->selectedListing($_GET);
		//pre($selectedListing);
		$this->page->assign("selectedListing",$selectedListing);
        $this->page->getPage('edit_classification_banner.tpl');
    }
	/**
	*@desc This function is used for deleting the details og the banner.
	*/		
	public function removeBanner()
	{
		$this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("edit_classification_url",$this->request->createURL("BannerManager","editClassificationBanner","ID"));
		$this->page->assign("ClassificationBannerManager",$this->request->createURL("BannerManager","ClassificationBannerManager"));
		$this->page->assign("searchClassificationBanner",$this->request->createURL("BannerManager", "searchClassificationBanner"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("link_date",$this->request->createURL("BannerManager", "linkDate","Date"));		
		$this->page->assign("affiliateBannerManager",$this->request->createURL("BannerManager","viewAffilateListing"));
		$this->page->assign("addBanner",$this->request->createURL("BannerManager","addBanner"));
		$this->page->assign("addClassificationBanner",$this->request->createURL("BannerManager","addClassificationBanner"));
		$this->page->assign("viewReport",$this->request->createURL("BannerManager","viewReport","ID"));
		$this->page->assign("addAffiliateBanner",$this->request->createURL("BannerManager","addAffiliateBanner"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("action",$this->request->createURL("BannerManager", "addBannerDetails"));
		$res=$this->BannerManagerFacade->removeBanner($_GET);
		
		if($res['result'])
		{
		   $this->request->setAttribute("message-succ", $res['message']);
		   $this->editBanner();
		}
		else{
			$this->editBanner();
			}

	}	
	
	/**
	*@desc This function is used for deleting the details og the banner.
	*/		
	public function removeClassificationBanner()
	{
		$this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("edit_classification_url",$this->request->createURL("BannerManager","editClassificationBanner","ID"));
		$this->page->assign("ClassificationBannerManager",$this->request->createURL("BannerManager","ClassificationBannerManager"));
		$this->page->assign("searchClassificationBanner",$this->request->createURL("BannerManager", "searchClassificationBanner"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("link_date",$this->request->createURL("BannerManager", "linkDate","Date"));		
		$this->page->assign("affiliateBannerManager",$this->request->createURL("BannerManager","viewAffilateListing"));
		$this->page->assign("addBanner",$this->request->createURL("BannerManager","addBanner"));
		$this->page->assign("addClassificationBanner",$this->request->createURL("BannerManager","addClassificationBanner"));
		$this->page->assign("viewReport",$this->request->createURL("BannerManager","viewReport","ID"));
		$this->page->assign("addAffiliateBanner",$this->request->createURL("BannerManager","addAffiliateBanner"));
		$this->page->assign("removeClassificationBanner",$this->request->createURL("BannerManager","removeClassificationBanner","ID"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("action",$this->request->createURL("BannerManager", "addBannerDetails"));
		$res=$this->BannerManagerFacade->removeBanner($_GET);
		
		if($res['result'])
		{
		   $this->request->setAttribute("message-succ", $res['message']);
		   $this->editClassificationBanner();
		}
		else{
			$this->editClassificationBanner();
			}

	}		
	

	/**
	*@desc This function is used for editing the details of affiliate banner.
	*/		
	public function editBannerDetails()
	{
		$this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("edit_classification_url",$this->request->createURL("BannerManager","editClassificationBanner","ID"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("link_date",$this->request->createURL("BannerManager", "linkDate","Date"));	
		$this->page->assign("ClassificationBannerManager",$this->request->createURL("BannerManager","ClassificationBannerManager"));
		$this->page->assign("searchClassificationBanner",$this->request->createURL("BannerManager", "searchClassificationBanner"));
		$this->page->assign("affiliateBannerManager",$this->request->createURL("BannerManager","viewAffilateListing"));
		$this->page->assign("addBanner",$this->request->createURL("BannerManager","addBanner"));
		$this->page->assign("addClassificationBanner",$this->request->createURL("BannerManager","addClassificationBanner"));
		$this->page->assign("viewReport",$this->request->createURL("BannerManager","viewReport","ID"));
		$this->page->assign("addAffiliateBanner",$this->request->createURL("BannerManager","addAffiliateBanner"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("action",$this->request->createURL("BannerManager", "addBannerDetails"));
		$res=$this->BannerManagerFacade->editBannerDetails($_GET,$_POST,$_FILES);
		
		if($res['result'])
		{
		   $this->request->setAttribute("message-succ", $res['message']);
		   $this->editBanner();
		}
		else{
			$this->request->setAttribute("message", $res['message']);
			$this->editBanner();
			}			
	}
	
	
	/**
			*@desc This function is used for editing the details of affiliate banner.
	*/		
	public function editClassificationBannerDetails()
	{
		$this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("edit_classification_url",$this->request->createURL("BannerManager","editClassificationBanner","ID"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("link_date",$this->request->createURL("BannerManager", "linkDate","Date"));	
		$this->page->assign("ClassificationBannerManager",$this->request->createURL("BannerManager","ClassificationBannerManager"));
		$this->page->assign("searchClassificationBanner",$this->request->createURL("BannerManager", "searchClassificationBanner"));
		$this->page->assign("affiliateBannerManager",$this->request->createURL("BannerManager","viewAffilateListing"));
		$this->page->assign("addBanner",$this->request->createURL("BannerManager","addBanner"));
		$this->page->assign("addClassificationBanner",$this->request->createURL("BannerManager","addClassificationBanner"));
		$this->page->assign("viewReport",$this->request->createURL("BannerManager","viewReport","ID"));
		$this->page->assign("addAffiliateBanner",$this->request->createURL("BannerManager","addAffiliateBanner"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("action",$this->request->createURL("BannerManager", "addBannerDetails"));
		$res=$this->BannerManagerFacade->editClassificationBannerDetails($_GET,$_POST,$_FILES);
		
		if($res['result'])
		{
		   $this->request->setAttribute("message-succ", $res['message']);
		   $this->editClassificationBanner();
		}
		else{
			$this->request->setAttribute("message", $res['message']);
			$this->editClassificationBanner();
			}			
	}
	
	/**
	*@desc This function is used for editing the details of affiliate banner.
	*/			
	public function editAffiliateBanner()
	{
	    $this->page->pageTitle = "Edit affiliate banner";
		$this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("edit_classification_url",$this->request->createURL("BannerManager","editClassificationBanner","ID"));
		$this->page->assign("ClassificationBannerManager",$this->request->createURL("BannerManager","ClassificationBannerManager"));
		$this->page->assign("searchClassificationBanner",$this->request->createURL("BannerManager", "searchClassificationBanner"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("affiliateBannerManager",$this->request->createURL("BannerManager","viewAffilateListing"));
		$this->page->assign("addBanner",$this->request->createURL("BannerManager","addBanner"));
		$this->page->assign("link_date",$this->request->createURL("BannerManager", "linkDate","Date"));		
		$this->page->assign("viewReport",$this->request->createURL("BannerManager","viewReport","ID"));
		$this->page->assign("addClassificationBanner",$this->request->createURL("BannerManager","addClassificationBanner"));
		$this->page->assign("addAffiliateBanner",$this->request->createURL("BannerManager","addAffiliateBanner"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("action",$this->request->createURL("BannerManager", "editAffiliateBannerDetails","ID"));
		$selectedListing=$this->BannerManagerFacade->selectedAffiliateListing($_GET);
		$this->page->assign("selectedListing",$selectedListing);
        $this->page->getPage('edit_affiliate_banner.tpl');
    }	
	
	
	
	/**
	*@desc This function is used for editing the details of affiliate banner.
	*/			
	public function editAffiliateBannerDetails()
	{
		$this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("edit_classification_url",$this->request->createURL("BannerManager","editClassificationBanner","ID"));
		$this->page->assign("ClassificationBannerManager",$this->request->createURL("BannerManager","ClassificationBannerManager"));
		$this->page->assign("searchClassificationBanner",$this->request->createURL("BannerManager", "searchClassificationBanner"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("addClassificationBanner",$this->request->createURL("BannerManager","addClassificationBanner"));
		$this->page->assign("affiliateBannerManager",$this->request->createURL("BannerManager","viewAffilateListing"));
		$this->page->assign("addBanner",$this->request->createURL("BannerManager","addBanner"));
		$this->page->assign("link_date",$this->request->createURL("BannerManager", "linkDate","Date"));
		$this->page->assign("viewReport",$this->request->createURL("BannerManager","viewReport","ID"));
		$this->page->assign("addAffiliateBanner",$this->request->createURL("BannerManager","addAffiliateBanner"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("action",$this->request->createURL("BannerManager", "addBannerDetails"));
		$res=$this->BannerManagerFacade->editAffiliateBannerDetails($_GET,$_POST,$_FILES);
		
		if($res['result'])
		{
		   $this->request->setAttribute("message-succ", $res['message']);
		   $this->editAffiliateBanner();
		}
		else{
			$this->request->setAttribute("message", $res['message']);
			$this->editAffiliateBanner();}
				
	}
	

	/**
	*@desc This function is used for deleting the details of banner.
	*/			
	public function deleteBanner()
	{ 
	    $this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("edit_classification_url",$this->request->createURL("BannerManager","editClassificationBanner","ID"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("affiliateBannerManager",$this->request->createURL("BannerManager","viewAffilateListing"));
		$this->page->assign("addBanner",$this->request->createURL("BannerManager","addBanner"));
		$this->page->assign("addClassificationBanner",$this->request->createURL("BannerManager","addClassificationBanner"));
		$this->page->assign("ClassificationBannerManager",$this->request->createURL("BannerManager","ClassificationBannerManager"));
		$this->page->assign("searchClassificationBanner",$this->request->createURL("BannerManager", "searchClassificationBanner"));
		$this->page->assign("viewReport",$this->request->createURL("BannerManager","viewReport","ID"));
		$this->page->assign("addAffiliateBanner",$this->request->createURL("BannerManager","addAffiliateBanner"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("link_date",$this->request->createURL("BannerManager", "linkDate","Date"));		
		$this->page->assign("edit_url", "javascript:window.location='".$this->request->createURL("BannerManager", "editBanner","ID"));
		$this->page->assign("edit_aff_url", "javascript:window.location='".$this->request->createURL("BannerManager", "editAffiliateBanner","ID"));
		$this->page->assign("delete",$this->request->createURL("BannerManager", "deleteBanner","ID"));
		$this->page->assign("delete_aff",$this->request->createURL("BannerManager", "deleteAffiliateBanner","ID"));		
		$res=$this->BannerManagerFacade->deleteBanner($_GET);
		
		if($res['result'])
		{
		$this->request->setAttribute("message-succ", $res['message']);
		$bannerArray=$this->BannerManagerFacade->viewListing();
		$this->page->assign("bannerArray",$bannerArray['banner']);
		}
        $this->page->getPage('banner_listing.tpl'); 
    }	

	/**
	*@desc This function is used for deleting the details of banner.
	*/			
	public function deleteClassificationBanner()
	{ 
	    $this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("edit_classification_url",$this->request->createURL("BannerManager","editClassificationBanner","ID"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("affiliateBannerManager",$this->request->createURL("BannerManager","viewAffilateListing"));
		$this->page->assign("addBanner",$this->request->createURL("BannerManager","addBanner"));
		$this->page->assign("addClassificationBanner",$this->request->createURL("BannerManager","addClassificationBanner"));
		$this->page->assign("ClassificationBannerManager",$this->request->createURL("BannerManager","ClassificationBannerManager"));
		$this->page->assign("searchClassificationBanner",$this->request->createURL("BannerManager", "searchClassificationBanner"));
		$this->page->assign("viewReport",$this->request->createURL("BannerManager","viewReport","ID"));
		$this->page->assign("addClassificationBanner",$this->request->createURL("BannerManager","addClassificationBanner"));
		$this->page->assign("addAffiliateBanner",$this->request->createURL("BannerManager","addAffiliateBanner"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("link_date",$this->request->createURL("BannerManager", "linkDate","Date"));		
		$this->page->assign("edit_url", "javascript:window.location='".$this->request->createURL("BannerManager", "editBanner","ID"));
		$this->page->assign("edit_aff_url", "javascript:window.location='".$this->request->createURL("BannerManager", "editAffiliateBanner","ID"));
		$this->page->assign("delete_classification",$this->request->createURL("BannerManager", "deleteClassificationBanner","ID"));
		$this->page->assign("change_classification_status",$this->request->createURL("BannerManager", "change_classification_status","ID"));	
		$this->page->assign("delete",$this->request->createURL("BannerManager", "deleteBanner","ID"));
		$this->page->assign("delete_aff",$this->request->createURL("BannerManager", "deleteAffiliateBanner","ID"));		
		$res=$this->BannerManagerFacade->deleteBanner($_GET);
		
		if($res['result'])
		{
		$this->request->setAttribute("message-succ", $res['message']);
		$bannerArray=$this->BannerManagerFacade->ClassificationBannerManager();
		$this->page->assign("bannerArray",$bannerArray['banner']);
		}
        $this->page->getPage('classification_banner_listing.tpl'); 
    }
	
	
	/**
	*@desc This function is used for deleting the details of banner.
	*/			
	public function deleteSearchClassificationBanner()
	{ 
	    $this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("edit_classification_url",$this->request->createURL("BannerManager","editClassificationBanner","ID"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("affiliateBannerManager",$this->request->createURL("BannerManager","viewAffilateListing"));
		$this->page->assign("addBanner",$this->request->createURL("BannerManager","addBanner"));
		$this->page->assign("addClassificationBanner",$this->request->createURL("BannerManager","addClassificationBanner"));
		$this->page->assign("ClassificationBannerManager",$this->request->createURL("BannerManager","ClassificationBannerManager"));
		$this->page->assign("searchClassificationBanner",$this->request->createURL("BannerManager", "searchClassificationBanner"));
		$this->page->assign("viewReport",$this->request->createURL("BannerManager","viewReport","ID"));
		$this->page->assign("addClassificationBanner",$this->request->createURL("BannerManager","addClassificationBanner"));
		$this->page->assign("addAffiliateBanner",$this->request->createURL("BannerManager","addAffiliateBanner"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("link_date",$this->request->createURL("BannerManager", "linkDate","Date"));		
		$this->page->assign("edit_url", "javascript:window.location='".$this->request->createURL("BannerManager", "editBanner","ID"));
		$this->page->assign("edit_aff_url", "javascript:window.location='".$this->request->createURL("BannerManager", "editAffiliateBanner","ID"));
		$this->page->assign("delete",$this->request->createURL("BannerManager", "deleteBanner","ID"));
		$this->page->assign("delete_aff",$this->request->createURL("BannerManager", "deleteAffiliateBanner","ID"));
		$this->page->assign("change_classification_status",$this->request->createURL("BannerManager", "change_classification_status","ID"));
		$this->page->assign("change_search_classification_status",$this->request->createURL("BannerManager", "change_search_classification_status","ID"));				
		$res=$this->BannerManagerFacade->deleteBanner($_GET);
		
		if($res['result'])
		{
		$this->request->setAttribute("message-succ", $res['message']);
		$bannerArray=$this->BannerManagerFacade->searchClassificationBannerDetail($_GET);
		$count			=count($bannerArray);
		$this->page->assign("count",$count);
		$this->page->assign("values",$bannerArray);
		}
        $this->page->getPage('search_classification_banner_listing.tpl'); 
    }
	/**
	*@desc This function is used for deleting the affiliate banner details.
	*/			
	public function deleteAffiliateBanner()
	{ 
	    $this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("affiliateBannerManager",$this->request->createURL("BannerManager","viewAffilateListing"));
		$this->page->assign("addBanner",$this->request->createURL("BannerManager","addBanner"));
		$this->page->assign("edit_classification_url", "javascript:window.location='".$this->request->createURL("BannerManager", "editClassificationBanner","ID"));
		$this->page->assign("addClassificationBanner",$this->request->createURL("BannerManager","addClassificationBanner"));
		$this->page->assign("viewReport",$this->request->createURL("BannerManager","viewReport","ID"));
		$this->page->assign("addAffiliateBanner",$this->request->createURL("BannerManager","addAffiliateBanner"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("ClassificationBannerManager",$this->request->createURL("BannerManager","ClassificationBannerManager"));
		$this->page->assign("searchClassificationBanner",$this->request->createURL("BannerManager", "searchClassificationBanner"));
		$this->page->assign("edit_url", "javascript:window.location='".$this->request->createURL("BannerManager", "editBanner","ID"));
		$this->page->assign("edit_classification_url",$this->request->createURL("BannerManager","editClassificationBanner","ID"));
		$this->page->assign("delete",$this->request->createURL("BannerManager", "deleteBanner","ID"));
		$this->page->assign("link_date",$this->request->createURL("BannerManager", "linkDate","Date"));
		$this->page->assign("delete_aff",$this->request->createURL("BannerManager", "deleteAffiliateBanner","ID"));		
		$res=$this->BannerManagerFacade->deleteAffiliateBanner($_GET);
		
		if($res['result'])
		{
		$this->request->setAttribute("message-succ", $res['message']);
		$bannerArray=$this->BannerManagerFacade->viewAffilateListing();
		$this->page->assign("bannerArray",$bannerArray['banner']);
		}
        $this->page->getPage('affiliate_banner_listing.tpl'); 
    }


	/**
	*@desc This function is used for fetching the report of a particular banner that how many times the banner gets clicked and viewed.
	*/			
	public function viewReport()
	{
		$this->page->pageTitle = "Report";
		$this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("affiliateBannerManager",$this->request->createURL("BannerManager","viewAffilateListing"));
		$this->page->assign("addBanner",$this->request->createURL("BannerManager","addBanner"));
		$this->page->assign("change_classification_status",$this->request->createURL("BannerManager", "change_classification_status","ID"));
		$this->page->assign("edit_classification_url",$this->request->createURL("BannerManager","editClassificationBanner","ID"));
		$this->page->assign("ClassificationBannerManager",$this->request->createURL("BannerManager","ClassificationBannerManager"));
		$this->page->assign("searchClassificationBanner",$this->request->createURL("BannerManager", "searchClassificationBanner"));
		$this->page->assign("viewReport",$this->request->createURL("BannerManager","viewReport","ID"));
		$this->page->assign("addAffiliateBanner",$this->request->createURL("BannerManager","addAffiliateBanner"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("edit_url", "javascript:window.location='".$this->request->createURL("BannerManager", "editBanner","ID"));
		$this->page->assign("edit_aff_url", "javascript:window.location='".$this->request->createURL("BannerManager", "editAffiliateBanner","ID"));
		$this->page->assign("addClassificationBanner",$this->request->createURL("BannerManager","addClassificationBanner"));
		$this->page->assign("delete",$this->request->createURL("BannerManager", "deleteBanner","ID"));
		$this->page->assign("delete_aff",$this->request->createURL("BannerManager", "deleteAffiliateBanner","ID"));
		$this->page->assign("change_status",$this->request->createURL("BannerManager", "changeStatus","ID"));

		$this->page->assign("link_date",$this->request->createURL("BannerManager", "linkDate","Date"));
		$bannerArray=$this->BannerManagerFacade->viewReport($_GET,$this->request->getAttribute("fr"), $this->request->getAttribute(                                                               "pg_size"));
		$count		=(count($bannerArray['banner']));
		$this->page->assign("count",$count);
		
		//$totalArray=$bannerArray=$this->BannerManagerFacade->totalDates($_GET);
		//pre($totalArray);
		/*$this->page->assign("totalArray",$totalArray);
		
		$finalArray = array();
		
		$i=0;
		
		foreach($totalArray as $val){
		$j=$i;	
			foreach($bannerArray['banner'] as $banner){
			
				if($val==$banner['day']){
					unset($banner['day']);
					$banner['day'] = $val;
					$finalArray[$i][] = $banner;
					$i++;
					break;
				}
			
			}
			if($j==$i){
				$finalArray[$j]['day'] = $val;
					$i++;
			}
		}
	
			
		foreach($finalArray as $val){
		
			$finarBannerArray[]=$val;
		}*/
	//pre($finarBannerArray);
		$this->page->assign("bannerArray",$bannerArray['banner']);
		$this->page->assign("paging",$bannerArray['paging']);		
        $this->page->getPage('banner_report.tpl');
    }


	/**
	*@desc This function is used for fetching the hourley details of the banner.
	*/			
	public function linkDate()
	{
	    $this->page->pageTitle = "Banner report hourley";
		$this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("affiliateBannerManager",$this->request->createURL("BannerManager","viewAffilateListing"));
		$this->page->assign("addBanner",$this->request->createURL("BannerManager","addBanner"));
		$this->page->assign("addClassificationBanner",$this->request->createURL("BannerManager","addClassificationBanner"));
		$this->page->assign("edit_classification_url",$this->request->createURL("BannerManager","editClassificationBanner","ID"));
		$this->page->assign("viewReport",$this->request->createURL("BannerManager","viewReport","ID"));
		$this->page->assign("addAffiliateBanner",$this->request->createURL("BannerManager","addAffiliateBanner"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("ClassificationBannerManager",$this->request->createURL("BannerManager","ClassificationBannerManager"));
		$this->page->assign("searchClassificationBanner",$this->request->createURL("BannerManager", "searchClassificationBanner"));
		$this->page->assign("edit_url", "javascript:window.location='".$this->request->createURL("BannerManager", "editBanner","ID"));
		$this->page->assign("edit_classification_url",$this->request->createURL("BannerManager","editClassificationBanner","ID"));
		$this->page->assign("delete",$this->request->createURL("BannerManager", "deleteBanner","ID"));
		$this->page->assign("delete_aff",$this->request->createURL("BannerManager", "deleteAffiliateBanner","ID"));
		$this->page->assign("change_status",$this->request->createURL("BannerManager", "changeStatus","ID"));
		$this->page->assign("link_date",$this->request->createURL("BannerManager", "linkDate","Date","ID"));
		$bannerArray=$this->BannerManagerFacade->linkDate($_GET);
		$count	= count(($bannerArray));
		$this->page->assign("count",$count);
		$this->page->assign("bannerArray",$bannerArray);
        $this->page->getPage('banner_report_hourley.tpl');	
	}


	
	
}   
?>