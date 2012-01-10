<?php
class ListingControl extends MainControl {

	private $listingFacade;
	//private $marketFacade;

	public function __construct($request)
	{

		$this->listingFacade = new ListingFacade($GLOBALS['conn'], $request);
		//$this->marketFacade = new MarketManagerFacade($GLOBALS['conn'], $request);		
		$this->page = new AdminPage();
		parent::__construct($request);


	}/* END __construct */


	/**
     *  expiredCronJob
     *
     *  This function execute the expiredCronJob function.
     */
	public function expiredCronJob(){

		$res = $this->listingFacade->expiredCronJob();
		echo "Affected Rows: ".$res;
		echo "<br><a href='#' onclick='history.back();'>Back</a>";
	}
	
	/**
     *  marketManager
     *
     *  This function is used to display the Market Manager.
     */		
	 
   public function marketManager()
   { 
        $this->page->pageTitle = "Market Manager";
        $do = isset($_GET['do'])?$_GET['do']:ADMIN_DEFAULT_CONTROL_VS;		
        $this->page->assign("do",$do);
		$this->page->assign("action1",$do['action']);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));  
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("viewList",$this->request->createURL("SalesAccountManager","viewList"));           
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
        $this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit","ID")); 
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists"));   
		$this->page->assign("delete",$this->request->createURL("SalesAccountManager", "delete","ID"));
        $this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("action",$this->request->createURL("Listing","marketsUpload"));
		$this->page->assign("action1",$this->request->createURL("Listing","marketsToShireUpload"));		
		$this->page->assign("searchemployee",$this->request->createURL("SalesAccountManager","searchEmployee"));
		$this->page->assign("addemployee",$this->request->createURL("SalesAccountManager","registrationAdd"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing", "addListing"));
		$this->page->assign("changePassword",$this->request->createURL("SalesAccountManager","changePassword"));
        $this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->getPage("marketmanager.tpl");
   }	 	
   
	public function marketsUpload()
	{
	    $arr = array();
		$this->page->pageTitle = "Markets Upload";

		$this->page->assign("do",$_GET['do']);
		//$this->page->assign("action1",$do['action']);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists"));  
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));		
		 $this->page->assign("searchlists",$this->request->createURL("AdminListing","search"));    
		$this->page->assign("action",$this->request->createURL("Listing","marketsUpload"));
		$this->page->assign("action1",$this->request->createURL("Listing","marketsToShireUpload"));		
        $this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
        $this->page->assign("back",$this->request->createURL("Admin", "showhomePageAdmin"));
        $this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing", "addListing"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
        $this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
       	$this->page->assign("edit_url",$this->request->createURL("AdminListing", "Edit"));		
        $this->page->assign("delete",$this->request->createURL("AdminListing", "delete","businessname={$this->request->getAttribute('businessname')}&fr={$this->request->getAttribute("fr")}&ID"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
	    $this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));

		$res=$this->listingFacade->marketsUpload($_FILES['csvfile']['name']);
	    $this->page->assign("values",$res);
	    $this->page->getPage("marketmanager.tpl");
	}   
	
	
	public function marketsToShireUpload()
	{
	    $arr = array();
		$this->page->pageTitle = "Markets To Shire Upload";
		$this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists"));  
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));		
		 $this->page->assign("searchlists",$this->request->createURL("AdminListing","search"));    
		$this->page->assign("action",$this->request->createURL("Listing","marketsUpload"));
		$this->page->assign("action1",$this->request->createURL("Listing","marketsToShireUpload"));		
        $this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
        $this->page->assign("back",$this->request->createURL("Admin", "showhomePageAdmin"));
        $this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing", "addListing"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
        $this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
       	$this->page->assign("edit_url",$this->request->createURL("AdminListing", "Edit"));
        $this->page->assign("delete",$this->request->createURL("AdminListing", "delete","businessname={$this->request->getAttribute('businessname')}&fr={$this->request->getAttribute("fr")}&ID"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
	    $this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$res=$this->listingFacade->marketsToShiresUpload($_FILES['csvfile']['name']);
	    $this->page->assign("values",$res);
	    $this->page->getPage("marketmanager.tpl");
	}   	
	
	
	/**
     *  expiredBusiness
     *
     *  This function is used to display the expired business.
     */	
	public function expiredBusiness(){
		
		$result = $this->listingFacade->expiredBusiness($_GET, $this->request->getAttribute("fr"));
		
		if(isset($_GET['days']) && is_numeric($_GET['days']) && $_GET['days']>0){
			$this->page->assign("days", $_GET['days']);
		}else {
			
			$this->page->assign("days", 15);
		}
		
		if(isset($_GET['searchType'])){
			$this->page->assign("searchType", $_GET['searchType']);
		}else {
			
			$this->page->assign("searchType", 'expired');
		}
		$this->page->assign("count",count($result['listings']));
		$this->page->assign("values",$result['listings']);
		$this->page->assign("paging", $result['paging']);
		
		
//		dashboard links
		global $action;
	    $this->page->pageTitle = "Admin Dashboard";
        $do = isset($_GET['do'])?$_GET['do']:ADMIN_DEFAULT_CONTROL_VS;
        $this->page->assign("do",$do);
		$this->page->assign("act",$action);
		$this->page->assign("user_permission",getSession("user_permission"));
        $this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
        $this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
        $this->page->assign("BusinessManager_url",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing","addListing"));
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("keyword",$this->request->createURL("Classification","viewKeyword"));
		$this->page->assign("key",$this->request->createURL("Key","addListing"));
		$this->page->assign("view",$this->request->createURL("Key", "viewList"));
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("LocationFormShow_shirenames",$this->request->createURL("Location","LocationFormShow_shirenames"));
		$this->page->assign("LocationFormShow_townnames",$this->request->createURL("Location","LocationFormShow_townnames"));
		$this->page->assign("viewLocation",$this->request->createURL("Location","viewLocation"));
		$this->page->assign("keywordFormShow",$this->request->createURL("Classification","keywordFormShow"));
		$this->page->assign("addpage",$this->request->createURL("Content","addPage"));
		$this->page->assign("classificationStats",$this->request->createURL("Admin","classificationStats"));
		$this->page->assign("viewPage",$this->request->createURL("Content","viewPage"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		// to delete
        $this->page->assign("verticalAddFormShow",$this->request->createURL("Vertical","verticalAddFormShow"));
        $this->page->assign("viewVertical",$this->request->createURL("Vertical","viewVertical"));     
        $this->page->assign("searchVertical",$this->request->createURL("Vertical","searchVerticals"));    
        
        $this->page->assign("groupAddFormShow",$this->request->createURL("Group","groupAddFormShow"));
		$this->page->assign("viewGroup",$this->request->createURL("Group","viewGroup"));     
        $this->page->assign("searchGroup",$this->request->createURL("Group","searchGroups"));    
		
        
        $this->page->assign("searchUser",$this->request->createURL("Admin","searchUserForm")); 
		$this->page->assign("searchLoc",$this->request->createURL("Location","searchLoc"));     
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager")); 
		$this->page->assign("searchlists",$this->request->createURL("AdminListing","search")); 
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists")); 
		$this->page->assign("viewList",$this->request->createURL("SalesAccountManager","viewList"));        
		$this->page->assign("sitePerformanceReport",$this->request->createURL("Admin","sitePerformanceReport"));  
		$this->page->assign("clients_in_specific_locality",$this->request->createURL("Admin","clients_in_specific_locality"));
		$this->page->assign("rankReport",$this->request->createURL("Admin","rankReport")); 
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->assign("addaffiliate",$this->request->createURL("Admin","addaffiliate"));
		$this->page->assign("fetchaffiliates",$this->request->createURL("Admin","fetchaffiliates"));
		$this->page->assign("searchClassification",$this->request->createURL("Classification","searchClassification"));
		$this->page->assign("min_visits",$this->request->createURL("Admin","min_visits"));
		$this->page->assign("site_config_manager",$this->request->createURL("Admin","site_config_manager"));
		
		$this->page->assign("keyword_manager",$this->request->createURL("Admin","keyword_manager"));
		$this->page->assign("brand_manager",$this->request->createURL("Admin","brand_manager"));
		
		$this->page->assign("expiredBusiness",$this->request->createURL("Listing","expiredBusiness"));
		$this->page->assign("expBusinessCron",$this->request->createURL("Listing","expiredCronJob"));
		$this->page->assign("activateBus",$this->request->createURL("Listing","activateBus"));
		$this->page->getpage('expiredBusiness.tpl');
	}
	
	
	/**
     *  report
     *
     *  This function is used to display the report of the business.
     */		
	function report()
	{
		$this->page->pageTitle 					= "Listing Report";	
		$this->page->assign("reportMail",$this->request->createURL("Listing","reportMail"));
		
		if(isset($_GET['business_id']) && $_GET['business_id'])
		{
			$san_data 							= array();
			$san_data['business_id'] 			= $_GET['business_id'];
			$san_data['page_size'] 				= (isset($_GET['page_size']) && !empty($_GET['page_size']))?$_GET['page_size']:DEFAULT_PAGING_SIZE;
			$san_data['period'] 				= (isset($_GET['period']) && !empty($_GET['period']))?$_GET['period']:"Daily";
			$san_data['fr'] 					= (isset($_GET['fr']))?$_GET['fr']:0;
			$san_data['to_date'] 				= $_GET['to_date'];
			$res 								= $this->listingFacade->getReport($san_data);
		
			$this->page->assign('to_date', $_GET['to_date']);
			$this->page->assign('business_id', $_GET['business_id']);
			$this->page->assign('do', $_GET['do']);
			$this->page->assign('action', $_GET['action']);
			$this->page->assign('paging', $res['paging']);
			$this->page->assign('all_data_arr', $res['all_data_arr']);
			$this->page->assign('page_size', $san_data['page_size']);
			$this->page->assign('period', $san_data['period']);
			$this->page->assign('business_name', $res['business_name']);
		}
		else{
			//invalid business
		}
			$this->page->getpage('business_report.tpl');
	}
	
	/**
     *  activateBus
     *
     *  This function is used to activete the business.
     */		
	public function activateBus(){
		
		$res = $this->listingFacade->activateBus($_GET['ID']);
		if($res['result']){
			$this->request->setAttribute("message-succ", $res['message']);
			$this->expiredBusiness();
		}else {
			$this->request->setAttribute("message", $res['message']);
			$this->expiredBusiness();
		}
	}
	
	function reportMail() {
		
		if(isset($_GET['business_id']) && $_GET['business_id']) {
			
			$san_data = array();
			$san_data['business_id'] = $_GET['business_id'];

			$san_data['page_size'] = (isset($_GET['page_size']))?$_GET['page_size']:DEFAULT_PAGING_SIZE;
			$san_data['period'] = (isset($_GET['period']))?$_GET['period']:"Daily";

			$san_data['page_size'] = (isset($_GET['page_size']) && !empty($_GET['page_size']))?$_GET['page_size']:DEFAULT_PAGING_SIZE;
			$san_data['period'] = (isset($_GET['period']) && !empty($_GET['period']))?$_GET['period']:"Daily";

			$san_data['fr'] = (isset($_GET['fr']))?$_GET['fr']:0;
			$san_data['to_date'] = $_GET['to_date'];
			$res = $this->listingFacade->reportMail($san_data);
			
			
			/*$Body = '
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="datatable">
					
							<tr><td height="4"></td></tr>
							<tr>
								<td width="100%" align="center">
									<div align="center"></div>
								</td>
							</tr>
							<tr><td height="4"></td></tr>
							<tr>
								<td width="100%" align="center">
									<table id="inbox_table" width="90%" style="" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td class="h4reversed">Date</th>';
											
											if($san_data['period'] == 'Daily'){
												$Body .= '<td class="h4reversed">Day</th>';
											}
											$Body .= '<td class="h4reversed">View Count</th>
										</tr>';
										foreach($res['all_data_arr'] as $key=>$val){
										$Body .= '<tr>
											<td align="left" nowrap>'.$key.'</td>';
											
											if($san_data['period'] == 'Daily'){
											$Body .= '<td align="left">'.$val['day'].'</td>';
											}
											$Body .= '<td align="left">'.$val['views'].'</td>
										</tr>';
										}
									$Body .='</table>
								</td>
							</tr>
							<tr><td height="4"></td></tr>
						</table>';
			
			$Body;
			exit();*/
				
			if($res['result']){
				$this->request->setAttribute("message", $res['message']);
				$this->report();
			}else {
				$this->request->setAttribute("message", $res['message']);
				$this->report();
			}
		}

	}
}	
	
?>