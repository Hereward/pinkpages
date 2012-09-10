<?php
/**
   * @title   AdminControl.class.php    
   * @desc    This is an AdminControl class. The purpose of this class is to perform the redirection actions needed for any              function/operation to AdminFacade class and also to smarty assign the URL's which were used in the templates as an              action, which redirects or calls the particular function passed in the action parameter in the AdminControl class. 
*/
class AdminControl extends MainControl
{

	private $adminFacade;                           //A private variable that will be used as object for AdminFacade class.
	public function __construct($request)           //Start of The __contructor.purpose, to create objects for AdminFacade
	{                                               //and for AdminPage,used as main page to show all templates.
		parent::__construct($request);

		$this->adminFacade = new AdminFacade($GLOBALS['conn']);
		$this->request = $request;

		$this->page = new AdminPage();
	}//End of the constructor.



	/**
	*@desc  This is the second function called for login. the purpose of this function is  to call the adminLogin                        () function of AdminFacade class and upon return from that function to this called function will check the                        access type if its Admin or Employee or Sales Manager and redirects to their dashboards.
	*/

	public function doLogin()
	{
		$res = $this->adminFacade->adminLogin($_POST);
		if($res['result']&& getSession("localuser_access")=="admin" && getSession("localuser_status")!="0" )
		{
			$this->request->redirect("Admin","showhomePageAdmin");
		}else if($res['result']&& getSession("localuser_access")=="Employee"&& getSession("localuser_status")!="0")
		{
			$this->request->redirect("Admin","showhomePageEmployee");
		}else if($res['result']&& getSession("localuser_access")=="SAcManager"&& getSession("localuser_status")!="0")
		{

			$this->request->redirect("Admin","showhomePageSalesManager");
		}
		else{
			$this->request->setAttribute("message", $res['message']);
			$this->login();
		}
	}

	/**
	*@desc This is the first function called on index page. The purpose of this function is to show the login form for                      Admin vis-a-vis for Employees,Sales Managers. this page has a link for registration so URL for that link is                      smarty assigned.Alongwith this, upon pressing login button form calls doLogin(), so its URL is also smarty                      assigned here.
	*/
	public function login()
	{
		session_destroy();
		$this->page->pageTitle = "Admin Login";
		$do 				= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 			= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$this->page->assign("action",$this->request->createURL("Admin", "doLogin"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registration"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("lostpass",$this->request->createURL("Admin","lostPassword"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->assign("classificationStats",$this->request->createURL("Admin","classificationStats"));
		//$resip=$this->adminFacade->addIp();
		$this->page->getPage("login.tpl");
	}

	/**
	*@desc This function is used to call the page on which user enter his details for getting the lost password..
	*/	
	public function lostPassword()
	{
		$this->page->pageTitle = "Lost Password";
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("action",$this->request->createURL("Admin","passwordSent"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->assign("classificationStats",$this->request->createURL("Admin","classificationStats"));
		$this->page->getPage("lost_password.tpl");
	}

	/**
	*@desc This function is useed for passing the value to the server and check for the validation and return the confirmation           message for the successfull validation.
	*/	
	public function passwordSent()
	{
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$res				= $this->adminFacade->lostpassgain($_POST);
		if($res['result'])
		{
			$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
			$this->request->setAttribute("message-succ", $res['message']);
			$this->page->getPage("lost_passent.tpl");
		}
		else{
			$this->request->setAttribute("message", $res['message']);
			$this->lostPassword();
		}
	}


	/**
	*@desc The purpose of this function is to Logout by calling userLogout function of AdminFacade class and to redirect                      to loggedOut() function wich shows the logged out message and a login again prompt link.
	*/ 
	public function doLogout()
	{
		$this->page->pageTitle = "Logout";
		$do 				= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 			= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$res = $this->adminFacade->userLogout();
		$this->request->redirect("Admin","loggedOut");
	}

	/**
	*@desc The purpose of this function is to Logout and to show the logged out message and a login again prompt link.			    */ 
	public function loggedOut()
	{
		$do 				= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 			= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->getPage('logged_out.tpl');
	}

	/**
	*@desc The purpose of this function is to to show the dashboard screen for admin wich contains different managers.	
	*/         
	public function showhomePageAdmin()
	{
		global $action;
		$this->page->pageTitle 	= "Admin Dashboard";
		$do 					= isset($_GET['do'])?$_GET['do']:ADMIN_DEFAULT_CONTROL_VS;
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
		$this->page->assign("clients_in_specific_locality",$this->request->createURL("Admin","search_locality_based_clients_form"));
		//$this->page->assign("clients_in_specific_locality",$this->request->createURL("Admin","clients_in_specific_locality"));
		$this->page->assign("rankReport",$this->request->createURL("Admin","rankReport"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->assign("addaffiliate",$this->request->createURL("Admin","addaffiliate"));
		$this->page->assign("fetchaffiliates",$this->request->createURL("Admin","fetchaffiliates"));
		$this->page->assign("searchClassification",$this->request->createURL("Classification","searchClassification"));
		$this->page->assign("min_visits",$this->request->createURL("Admin","min_visits"));
		$this->page->assign("site_config_manager",$this->request->createURL("Admin","site_config_manager"));

		$this->page->assign("keyword_manager",$this->request->createURL("Admin","keyword_manager"));
		$this->page->assign("brand_manager",$this->request->createURL("Admin","brand_manager"));
		$this->page->assign("service_manager",$this->request->createURL("Admin","service_manager"));

		$this->page->assign("expiredBusiness",$this->request->createURL("Listing","expiredBusiness"));
		$this->page->assign("marketManager",$this->request->createURL("Listing","marketManager"));		
		$this->page->assign("expBusinessCron",$this->request->createURL("Listing","expiredCronJob"));
		$this->page->assign("contactDetails",$this->request->createURL("Admin","contactDetails"));
		$this->page->getPage('dashboard.tpl');
	}


	/**
	*@desc  This is the function is used displaying the contact us details page.
	*/		
	public function contactDetails()
	{
		$this->page->pageTitle = "Contact us";
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("delete_contact_us_details",$this->request->createURL("Admin","delete_contact_us_details","ID"));
		$result=$this->adminFacade->viewContactDetails($this->request->getAttribute("fr"),$this->request->getAttribute("pg_size"));
		$this->page->assign("values",$result['blogs']);
		$this->page->assign("paging", $result['paging']);
		$this->page->getPage('contact_us_details.tpl');
	}


	/**
	*@desc  This is the function is used for deleting the details of contact us details.
	*/		
	public function delete_contact_us_details()
	{
		$this->page->pageTitle = "Contact us";
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$result=$this->adminFacade->deleteContactDetails();
		if($result['result'])
		{
			$this->request->setAttribute("message-succ", $result['message']);
			$this->contactDetails();
		}
		else{
			$this->request->setAttribute("message", $result['message']);
			$this->contactDetails();}

	}


	/**
	*@desc  This is the function is used for displaying the keyword details.
	*/		
	public function keyword_manager()
	{
		$this->page->pageTitle = "Keyword Manager";
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("add_business_keyword",$this->request->createURL("Admin","add_business_keyword"));
		$this->page->assign("keyword_manager",$this->request->createURL("Admin","keyword_manager"));
		$this->page->assign("delete_business_keyword",$this->request->createURL("Admin","delete_business_keyword"));
		$result=$this->adminFacade->viewfetchDetails($this->request->getAttribute("fr"),$this->request->getAttribute("pg_size"));
		$this->page->assign("values",$result['blogs']);
		$this->page->assign("paging", $result['paging']);
		$this->page->getPage("business_keys_show.tpl");
	}


	/**
	*@desc  This is the function is used for deleting the keywords.
	*/		
	public function delete_business_keyword()
	{
		$this->page->pageTitle = "Keyword Manager";
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("add_business_keyword",$this->request->createURL("Admin","add_business_keyword"));
		$this->page->assign("keyword_manager",$this->request->createURL("Admin","keyword_manager"));
		$this->page->assign("delete_business_keyword",$this->request->createURL("Admin","delete_business_keyword"));

		$result=$this->adminFacade->deleteKey();
		if($result['result'])
		{
			$this->request->setAttribute("message-succ", $result['message']);
			$this->keyword_manager();
		}
		else{
			$this->request->setAttribute("message", $result['message']);
			$this->keyword_manager();}
	}


	/**
	*@desc  This is the function is used for service pages.
	*/		
	public function service_manager()
	{

		$this->page->pageTitle = "Service Manager";
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("add_business_service",$this->request->createURL("Admin","add_business_service"));
		$this->page->assign("service_manager",$this->request->createURL("Admin","service_manager"));
		$this->page->assign("delete_business_service",$this->request->createURL("Admin","delete_business_service"));
		$result=$this->adminFacade->viewServiceDetails($this->request->getAttribute("fr"),$this->request->getAttribute("pg_size"));
		$this->page->assign("values",$result['blogs']);
		$this->page->assign("paging", $result['paging']);
		$this->page->getPage("business_service_show.tpl");

	}


	/**
	*@desc  This is the function is used for deleting the business brands.
	*/		
	public function delete_business_brand()
	{
		$this->page->pageTitle = "Brand Manager";
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("brand_manager",$this->request->createURL("Admin","brand_manager"));
		$this->page->assign("add_business_brand",$this->request->createURL("Admin","add_business_brand"));
		$result=$this->adminFacade->deleteBrand();
		if($result['result'])
		{
			$this->request->setAttribute("message-succ", $result['message']);
			$this->brand_manager();
		}
		else{
			$this->request->setAttribute("message", $result['message']);
			$this->brand_manager();
		}
	}

	/**
	*@desc  This is the function is used for deleting the business service.
	*/		
	public function delete_business_service()
	{
		$this->page->pageTitle = "Delete Service";
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("add_business_service",$this->request->createURL("Admin","add_business_service"));
		$this->page->assign("service_manager",$this->request->createURL("Admin","service_manager"));
		$this->page->assign("delete_business_service",$this->request->createURL("Admin","delete_business_service"));
		$result=$this->adminFacade->deleteService();
		if($result['result'])
		{
			$this->request->setAttribute("message-succ", $result['message']);
			$this->service_manager();
		}
		else{
			$this->request->setAttribute("message", $result['message']);
			$this->service_manager();
		}
	}


	/**
	*@desc  This is the function is used for displaying the brands of the business.
	*/		
	public function brand_manager()
	{
		$this->page->pageTitle 						= "Brand Manager";
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("delete_business_brand",$this->request->createURL("Admin", "delete_business_brand"));
		$this->page->assign("brand_manager",$this->request->createURL("Admin","brand_manager"));
		$this->page->assign("add_business_brand",$this->request->createURL("Admin","add_business_brand"));

		$result										= $this->adminFacade->fetchBrandDetails($this->request->getAttribute("fr"),$this->request->getAttribute("pg_size"));
		$this->page->assign("values",$result['blogs']);
		$this->page->assign("paging", $result['paging']);
		$this->page->getPage("brand_show.tpl");
	}



	/**
	*@desc  This is the function is used for adding new business brand.
	*/		
	public function add_business_brand()
	{
		$this->page->pageTitle = "Brand Manager";
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("brand_manager",$this->request->createURL("Admin","brand_manager"));
		$this->page->assign("add_business_brand",$this->request->createURL("Admin","add_business_brand"));
		$this->page->assign("delete_business_brand",$this->request->createURL("Admin", "delete_business_brand"));
		$this->page->assign("action",$this->request->createURL("Admin","add_business_brand_value"));
		$this->page->getPage("business_brand_add.tpl");
	}


	/**
	*@desc  This is the function is used for adding the value of the brands.
	*/		
	public function add_business_brand_value()
	{
		$this->page->pageTitle = "Brand Manager";
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("brand_manager",$this->request->createURL("Admin","brand_manager"));
		$this->page->assign("add_business_brand",$this->request->createURL("Admin","add_business_brand"));
		$this->page->assign("delete_business_brand",$this->request->createURL("Admin", "delete_business_brand"));
		$res=$this->adminFacade->addBrand($_POST);
		if($res['result'])
		{
			$this->request->setAttribute("message-succ", $res['message']);
			$this->add_business_brand();
		}
		else{
			$this->request->setAttribute("message", $res['message']);
			$this->add_business_brand();}

	}



	/**
	*@desc  This is the function is used for adding business keywords.
	*/		
	public function add_business_keyword()
	{
		$this->page->pageTitle 								= "Add business keyword";
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("keyword_manager",$this->request->createURL("Admin","keyword_manager"));
		$this->page->assign("add_business_keyword",$this->request->createURL("Admin","add_business_keyword"));
		$this->page->assign("action",$this->request->createURL("Admin","add_business_keyword_value"));
		$this->page->getPage("business_key_add.tpl");
	}


	/**
	*@desc  This is the function is used for adding business service.
	*/			
	public function add_business_service()
	{
		$this->page->pageTitle 								= "Add business service";
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("service_manager",$this->request->createURL("Admin","service_manager"));
		$this->page->assign("add_business_service",$this->request->createURL("Admin","add_business_service"));
		$this->page->assign("action",$this->request->createURL("Admin","add_business_service_value"));
		$this->page->getPage("business_service_add.tpl");
	}


	/**
	*@desc  This is the function is used for adding business keywords names.
	*/			
	public function add_business_keyword_value()
	{
		$this->page->pageTitle = "Add business keyword";
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("keyword_manager",$this->request->createURL("Admin","keyword_manager"));
		$this->page->assign("add_business_keyword",$this->request->createURL("Admin","add_business_keyword"));
		$res=$this->adminFacade->addlist($_POST);
		if($res['result'])
		{
			$this->request->setAttribute("message-succ", $res['message']);
			$this->add_business_keyword();
		}
		else{
			$this->request->setAttribute("message", $res['message']);
			$this->add_business_keyword();}
	}


	/**
	*@desc  This is the function is used for adding business service names.
	*/			
	public function add_business_service_value()
	{
		$this->page->pageTitle = "Add business Service";
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("service_manager",$this->request->createURL("Admin","service_manager"));
		$this->page->assign("add_business_service",$this->request->createURL("Admin","add_business_service"));
		$res=$this->adminFacade->addService($_POST);
		if($res['result'])
		{
			$this->request->setAttribute("message-succ", $res['message']);
			$this->add_business_service();
		}
		else{
			$this->request->setAttribute("message", $res['message']);
			$this->add_business_service();}
	}

	public function site_config_manager()
	{
		$this->page->pageTitle = "Site configuration manager";
		$do 				= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 			= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("act",$action);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("site_config_manager1",$this->request->createURL("Admin","site_config_manager"));
		$site_config_manager=$this->adminFacade->site_config_manager();
		$this->page->assign("site_config_manager",$site_config_manager);
		$this->page->getPage('configuration_manager.tpl');
	}


	/**
	*@desc  This is the function is used for editing the configuration details.
	*/			
	public function editConfigValue()
	{
		$this->page->pageTitle = "Edit configuration value";
		$this->adminFacade->editConfigValue($_GET['ID'], $_GET['keyword']);
	}


	/**
	*@desc  This is the function is used for displaying the details of the minimum visits details.
	*/			
	public function min_visits()
	{
		$this->page->pageTitle 					= "Minimum visits";
		$do 				= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 			= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("act",$action);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("min_visits1",$this->request->createURL("Admin","min_visits"));

		$min_visits=$this->adminFacade->min_visits();
		$this->page->assign("min_visits",$min_visits);
		$this->page->getPage('client_under_min_visit.tpl');

	}

	/**
	*@desc The purpose of this function is to to show get the name of the classification and pass it to report page
	*/ 
	public function rankReport()
	{
		$this->page->pageTitle = "Rank Report Selection";

		$do 				= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 			= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("act",$action);

		$this->page->assign("action",$this->request->createURL("Admin", "showRankReport"));
		$this->page->assign("rankReport",$this->request->createURL("Admin","rankReport"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("rankRate",$this->request->createURL("Admin","rankRate"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$classifications = $this->adminFacade->fetchClassificationDetails();
		$states          = $this->adminFacade->fetchStates();
		$this->page->assign("classifications",$classifications);
		$this->page->assign("states",$states);		
		$this->page->getPage('rank_report.tpl');
	}

	/**
	*@desc The purpose of this function is to to show the report on the basis of selected classification.
	*/ 
	public function showRankReport()
	{
		$this->page->pageTitle = "Rank Report Display";


		$do 				= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 			= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("act",$action);
		$this->page->assign("showClientDetails",$this->request->createURL("Admin", "showClientDetails","ID"));
		$classification_id = $_POST['classification'];
		$regionCounts  = $this->adminFacade->fetchLowerRankClassificationRegionCount($classification_id);		
		$showClientDetails	='';
		$classifications=$this->adminFacade->fetchClassificationDetails();
		$this->page->assign("classifications",$classifications);
		//$this->page->addCssStyle("tablehighlight.css");
		

        $this->page->addJsFile("jquery-1.3.2.min.js");		
	    $this->page->removeJsFile("prototype.1.6.js");				
		$this->page->addJsFile("tablehighlight.js");

		$Result=$this->adminFacade->fetchClassificationCode($_POST['state']);	

		$array1 = array(array("region_code" => "", "region_name" => ""));
		$finalResult=array_merge($array1,$Result);
		$this->page->assign("Result",$finalResult);
		$classificationName=$this->adminFacade->classificationName($_POST);
		$classificationResult=$this->adminFacade->ClassificationReport($_POST);
		if($_POST['classification'] == '--Select One--')
		{
			$class	=0;
			$this->request->setAttribute("message", "Please select any Classification");
			$this->page->assign("class", $class);
		}
		$userId				= "";
		$finalArray=array();

		foreach($Result as $region) {
		
			$row = array();
			for($rank=1;$rank<11;$rank++) {
				$found = false;
				foreach ($classificationResult as $result) {
					if(
					$region['shirename_id'] == $result['shirename_id'] &&
					$rank == $result['businessrank_rank']
					) {
						$found = true;
						$userId					= (!empty($result['user_id']))?$result['user_id']:NULL;
						break;
					}
				}
				if($found) {
					//pre($result);
					$business_name	= addslashes($result['business_name']);
					$client_id 	= (!empty($result['client_id']))?$result['client_id']:0;
					//$account_id		= $result['client_id'];
					/*					$row[$rank] = '<a id="popupspan" href="#" onmouseover="toolTip('hell', 150)" onmouseout="toolTip()"><img border=\"0\" src=\"".ADMIN_IMAGES_PATH."dot.gif\" alt=\"\"/></a>';*/
					$row[$rank] = "<a id=\"popupspan\" href=\"main.php?do=Admin&action=showClientDetails&client_id=$client_id&business_id={$result['business_id']}\" onmouseover=\"toolTip('{$business_name}', 150)\" onmouseout=\"toolTip()\"><img border=\"0\" src=\"".ADMIN_IMAGES_PATH."sold.png\" alt=\"\" /></a>";
				}
				else {
					$row[$rank] = "";
				}
			}
			foreach($regionCounts as $count){
			  if($region['shirename_id'] == $count['shirename_id']){
			    //$row[11] = $count['shirename_id'] . "   " . $count['count'];	
                $row[11] = $count['count'];					
			  } //else {$row[11] = 0;}
			}  						

            //Pads out the Region Code so region name is displayed in the report correctly
			if(strlen($region['region_code']) <= 3){
			  $region['region_code'] = str_pad($region['region_code'], 6, '123', STR_PAD_LEFT);
			}			
			
			$finalArray[$region['region_code']] = $row;			
		}
		
		var_dump($finalArray);
		die();
		
		$ranks 					= array(1,2,3,4,5,6,7,8,9,10,11);




		$this->page->assign("classificationName",@$classificationName['0']['localclassification_name']);
		$this->page->assign("ranks", $ranks);
		$this->page->assign("headerImg", $_POST['state']."region.jpg");		
		$this->page->assign("classificationResult", $finalArray);		
		$this->page->assign("action",$this->request->createURL("Admin", "showRankReport"));
		//		$this->page->assign("showClientDetails",$this->request->createURL("Admin", "showClientDetails","ID=".$userId));
		$this->page->assign("showClientDetails",$this->request->createURL("Admin", "showClientDetails","ID"));
		$this->page->assign("rankReport",$this->request->createURL("Admin","rankReport"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("rankRate",$this->request->createURL("Admin","rankRate"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->getPage('rank_report_display.tpl');
		/*}else{
		$this->request->setAttribute("message", $classificationResult['message']);
		$this->rankReport();*/
	}



	/**
	*@desc The purpose of this function is to to show the details of client for which rank is clicked.
	*/ 	
	public function showClientDetails()
	{
		$this->page->pageTitle  = "Client Details";
		$clientDetails			= $this->adminFacade->showClientDetails($_GET);
		$showClientBusinessInfo	= $this->adminFacade->showClientBusinessInfo($_GET);						
		
		//		$showClientBusinessDetails	= $this->adminFacade->showClientBusinessDetails($_GET);

		//pre($showClientBusinessInfo);
		$this->page->assign("domain", $_SERVER['SERVER_NAME']);		
		$count					= count($clientDetails);
		$this->page->assign("count", $count);
		$this->page->assign("clientDetails", $clientDetails);
		$this->page->assign("showClientBusinessInfo", $showClientBusinessInfo);
		$this->page->assign("bannerPath", BANNER_UPLOAD_PATH);
		$this->page->getPage('client_details.tpl');
	}

	/**
	*@desc The purpose of this function is to to show get the name of the classification and pass it to report page
	*/ 
	public function rankRate()
	{
		$this->page->pageTitle = "Rank Rate";

		$do 				= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 			= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("act",$action);

		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("rankReport",$this->request->createURL("Admin","rankReport"));
		$this->page->assign("rankRate",$this->request->createURL("Admin","rankRate"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$rankResult=$this->adminFacade->rankResult();
		$this->page->assign("rankResult",$rankResult);
		$this->page->getPage('rank_rate.tpl');
	}

	/**
	*@desc this function is used for the sending the value through the get method for the rate edition.
	*/		
	public function editRate()
	{
		$this->adminFacade->editRate1($_GET['ID'], $_GET['rate']);

	}


	/**
	*@desc This function is useed for getting the name of the clinet.
	*/		
	public function getClientName()
	{
		$clientName=$this->adminFacade->getClientName($_GET);
		foreach ($clientName as $value)
		{
			echo $value['localuser_username'];
		}
	}


	/**
	*@desc The purpose of this function is to to show the dashboard screen for Employee wich contains different                       options.
	*/ 
	public function showhomePageEmployee()
	{
		$this->page->pageTitle = "Employee Dashboard";
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("classificationStats",$this->request->createURL("Admin","classificationStats"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->getPage('EmployeeDashboard.tpl');
	}


	/**
	*@desc The purpose of this function is to to show the dashboard screen for Sales Manager wich contains different                       options.
	*/
	public function showhomePageSalesManager()
	{
		$this->page->pageTitle = "Salesmanager Dashboard";
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("reg_url",$this->request->createURL("SalesAccountManager", "registrationAdd"));
		$this->page->assign("searchemployee",$this->request->createURL("SalesAccountManager","searchEmployee"));
		$this->page->assign("changePassword",$this->request->createURL("SalesAccountManager","changePassword"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("classificationStats",$this->request->createURL("Admin","classificationStats"));
		$this->page->assign("addemployee",$this->request->createURL("SalesAccountManager","registrationAdd"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->getPage('SalesManagerDashboard.tpl');
	}


	/**
	*@desc this function is used for user addition, this fuction calls the userAdd() function of AdminFacade, and                      redirects to success page upon getting result 'true' else message is printed. 
	*/  
	public function addition()
	{
		$this->page->pageTitle = "Member Addition";
		$do 				= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 			= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("act",$action);

		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("keyword",$this->request->createURL("Classification","viewKeyword"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("searchUser",$this->request->createURL("Admin","searchUserForm"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("key",$this->request->createURL("Key","addListing"));
		$this->page->assign("view",$this->request->createURL("Key", "viewList"));
		$this->page->assign("classificationStats",$this->request->createURL("Admin","classificationStats"));
		$this->page->assign("LocationFormShow_shirenames",$this->request->createURL("Location","LocationFormShow_shirenames"));
		$this->page->assign("LocationFormShow_townnames",$this->request->createURL("Location","LocationFormShow_townnames"));
		$this->page->assign("viewLocation",$this->request->createURL("Location","viewLocation"));
		$this->page->assign("keywordFormShow",$this->request->createURL("Classification","keywordFormShow"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$resAdd = $this->adminFacade->userAdd($_POST);

		if($resAdd['result'])
		{
			$this->request->setAttribute("message-succ", $resAdd['message']);
			$this->registrationAdd();
		}else{
			$this->request->setAttribute("message", $resAdd['message']);
			$this->registrationAdd();
		}
	}


	/**
	*@desc This function is useed for displaying the user successfull activation page.
	*/		
	public function activateUser()
	{
		$do 				= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 			= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("act",$action);

		$this->page->pageTitle = "Activate User";
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->getPage("successfulActivation.tpl");
	}

	/**
	*@desc this function is used for Business user addition, this fuction calls the userAdd() function of AdminFacade,                      and redirects to success page upon getting result 'true' else message is printed. 
	*/  
	public function addBusiness()
	{
		$businessAddRes = $this->adminFacade->AdminbusinessAdd($_POST);
		if($businessAddRes['result'])
		{
			$this->request->redirect("Admin","showHomepageBusiness");
		}else{
			$this->request->setAttribute("message", $businessAddRes['message']);
			$this->businessAdd();
		}
	}

	/**
	*@desc this function is used for showing the form registering the team user, with various URL's created to  be used                      on that form with an action URL created to call addition() function upon submitting the completed form.  
	*/  
	public function registrationAdd()
	{
		$this->page->pageTitle	= "Registration";
		$firstname				= (!empty($_POST['firstname']))?$_POST['firstname']:NULL;
		$surname				= (!empty($_POST['surname']))?$_POST['surname']:NULL;
		$username				= (!empty($_POST['username']))?$_POST['username']:NULL;
		$email					= (!empty($_POST['email']))?$_POST['email']:NULL;
		$address				= (!empty($_POST['address']))?$_POST['address']:NULL;
		$phone					= (!empty($_POST['phone']))?$_POST['phone']:NULL;
		$phone					= (!empty($_POST['phone']))?$_POST['phone']:NULL;
		$mobile					= (!empty($_POST['mobile']))?$_POST['mobile']:NULL;

		$this->page->assign("firstname",$firstname);
		$this->page->assign("surname",$surname);
		$this->page->assign("username",$username);
		$this->page->assign("email",$email);
		$this->page->assign("address",$address);
		$this->page->assign("phone",$phone);
		$this->page->assign("mobile",$mobile);

		$do 				= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 			= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("act",$action);

		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("searchUser",$this->request->createURL("Admin","searchUserForm"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("action",$this->request->createURL("Admin", "addition"));
		$this->page->assign("back",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("classificationStats",$this->request->createURL("Admin","classificationStats"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->getPage('registeruser_teammanager.tpl');
	}

	/**
	*@desc this function is used for showing the form registering the team Business user, with various URL's created to                      be used on that form with an AddAction URL created to call addBusiness() function upon submitting the                      completed form.  
	*/ 
	public function businessAdd()
	{
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("AddAction",$this->request->createURL("Admin", "addBusiness"));
		$this->page->assign("classificationStats",$this->request->createURL("Admin","classificationStats"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->getPage('registeruser_businessmanager.tpl');
	}

	/**
	*@desc This function is the admin Team Manager function. The purpose of this function is to fetch the user details                      from the table by calling fetchUserDetails() function of AdminFacade class. The resultant records will be                      used in to show in tabular form woth options to add, edit ,delete and view the records.  
	*/
	public function adminManager()
	{
		$this->page->pageTitle = "Member Details";
		$do 				= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 			= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("act",$action);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("edit_url",$this->request->createURL("Admin", "edit","ID"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("delete",$this->request->createURL("Admin", "delete","name={$this->request->getAttribute('name')}&fr={$this->request->getAttribute("fr")}&ID"));
		$this->page->assign("classificationStats",$this->request->createURL("Admin","classificationStats"));
		$this->page->assign("searchUser",$this->request->createURL("Admin","searchUserForm"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("setPermission",$this->request->createURL("Admin","setPermission","localuser_id"));
		$this->page->assign("changeAccess",$this->request->createURL("Admin","changeAccess","localuser_id"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));

		$res2 = $this->adminFacade->fetchUserDetails($this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"));

		$this->page->assign("values",$res2['blogs']);
		$this->page->assign("paging",$res2['paging']);
		$this->page->getPage('teammanager.tpl');
	}

	/**
	*@desc This function is useed for displaying the user permission page and give the default permission of that client.
	*/		
	public function setPermission()
	{
		$this->page->pageTitle 		= "Edit Permission";
		$do 						= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 					= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("act",$action);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("edit_url",$this->request->createURL("Admin", "edit","ID"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("classificationStats",$this->request->createURL("Admin","classificationStats"));
		$this->page->assign("searchUser",$this->request->createURL("Admin","searchUserForm"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("setPermission",$this->request->createURL("Admin","setPermission","localuser_id"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->assign("action",$this->request->createURL("Admin", "updatePermission","localuser_id"));
		$this->page->assign("changeAccess",$this->request->createURL("Admin","changeAccess","localuser_id"));
		$permissionResult = $this->adminFacade->fetchAllPermission($_GET);
		$this->page->assign("permissionResult",$permissionResult);
		$this->page->getPage('edit_user_permission.tpl');

	}

	/**
	*@desc This function is useed for changing showing the default access of the clinet and give a page to change the access.
	*/		
	public function changeAccess()
	{
		$this->page->pageTitle 	= "Change Access";
		$do 					= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 				= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("act",$action);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("edit_url",$this->request->createURL("Admin", "edit","ID"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("classificationStats",$this->request->createURL("Admin","classificationStats"));
		$this->page->assign("searchUser",$this->request->createURL("Admin","searchUserForm"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("setPermission",$this->request->createURL("Admin","setPermission","localuser_id"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->assign("action",$this->request->createURL("Admin", "updatePermission","localuser_id"));
		$this->page->assign("changeAccess",$this->request->createURL("Admin","changeAccess","localuser_id"));
		$this->page->assign("action",$this->request->createURL("Admin", "updateAccess","localuser_id"));
		$detailArray 			= $this->adminFacade->userDetails($_GET);
		$this->page->assign("localuser_access",$detailArray['0']['localuser_access']);
		$this->page->getPage('user_access_change.tpl');
	}

	/**
	*@desc This function is useed for changing the access of the client and give the successfull message on completion and repot          error on any mistake.
	*/		
	public function updateAccess()
	{
		$this->page->pageTitle 	= "Change Access";
		$do 					= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 				= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("act",$action);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("edit_url",$this->request->createURL("Admin", "edit","ID"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("classificationStats",$this->request->createURL("Admin","classificationStats"));
		$this->page->assign("searchUser",$this->request->createURL("Admin","searchUserForm"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("setPermission",$this->request->createURL("Admin","setPermission","localuser_id"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->assign("action",$this->request->createURL("Admin", "updatePermission","localuser_id"));
		$this->page->assign("changeAccess",$this->request->createURL("Admin","changeAccess","localuser_id"));
		$this->page->assign("action",$this->request->createURL("Admin", "updateAccess","localuser_id"));
		$updateResult 			= $this->adminFacade->updateAccess($_GET,$_POST);
		if($updateResult['result'])
		{
			$this->request->setAttribute("message", $updateResult['message']);
			$this->changeAccess();
		}
	}


	/**
	*@desc This function is useed for change the permission of the client.
	*/		
	public function updatePermission()
	{
		$do 					= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 				= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("act",$action);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("edit_url",$this->request->createURL("Admin", "edit","ID"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("classificationStats",$this->request->createURL("Admin","classificationStats"));
		$this->page->assign("searchUser",$this->request->createURL("Admin","searchUserForm"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("setPermission",$this->request->createURL("Admin","setPermission","localuser_id"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));

		$givePermissionResult 	= $this->adminFacade->setPermission($_GET,$_POST);
		if($givePermissionResult['result'])
		{
			$this->request->setAttribute("message", $givePermissionResult['message']);
			$this->setPermission();
		}
	}

	/**
	*@desc This function is the admin Team Manager function. The purpose of this function is to fetch the user details                      from the table by calling fetchUserDetails() functiopn of AdminFacade class. The resultant records will be                      used in to show in tabular form woth options to add, edit ,delete and view the records.  
	*/
	public function adminBusinessManager()
	{
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "businessAdd"));
		$this->page->assign("edit_url",$this->request->createURL("Admin", "edit","ID"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("classificationStats",$this->request->createURL("Admin","classificationStats"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$res2 					= $this->adminFacade->fetchUserDetails();
		$this->page->assign("values",$res2);
		$this->page->getPage('businessManager.tpl');
	}

	/**
	*@desc This function is just a success message page with link to login again.
	
	*/
	public function showhomePage()
	{
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("back",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("searchUser",$this->request->createURL("Admin","searchUserForm"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("classificationStats",$this->request->createURL("Admin","classificationStats"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("edit_url",$this->request->createURL("Admin", "edit","ID"));
		$this->page->assign("delete",$this->request->createURL("Admin", "delete","ID"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$res2 = $this->adminFacade->fetchUserDetails();
		$this->page->assign("values",$res2);
		$this->page->getPage("teammanager.tpl");
	}


	/**
	*@desc This function is just a success message page with link to login again.
	*/
	public function showHomepageBusiness()
	{
		$do 				= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 			= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("act",$action);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("classificationStats",$this->request->createURL("Admin","classificationStats"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->getPage("businessManager.tpl");
	}


	/**
	*@desc This function is used to edit the details of the user, this function in turns calls editUser() function of                      AdminFacade class which shows the details of the user on the form fields based on the ID, and upon editing                      the values the editAddition() function is called to update the same in the database.  
	*/
	public function edit()
	{
		$this->page->pageTitle = "Edit Member";
		$do 				= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 			= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("act",$action);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("action",$this->request->createURL("Admin", "editAddition","ID"));
		$this->page->assign("searchUser",$this->request->createURL("Admin","searchUserForm"));
		$this->page->assign("classificationStats",$this->request->createURL("Admin","classificationStats"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("back",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("edit_url",$this->request->createURL("Admin", "edit","ID"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("delete",$this->request->createURL("Admin", "delete","ID"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$res3 = $this->adminFacade->editUser();
		$this->page->assign("values1",$res3);
		$this->page->getPage('edituser.tpl');
	}


	/**
	*@desc  The editAddition() function is called, to update the edited values reflected in the form in the database                           which  in turns calls editAdd() function of AdminFacade class.
	*/	 
	public function editAddition()
	{
		$do 				= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 			= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("act",$action);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("searchUser",$this->request->createURL("Admin","searchUserForm"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("classificationStats",$this->request->createURL("Admin","classificationStats"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("back",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("edit_url",$this->request->createURL("Admin", "edit","ID"));
		$this->page->assign("delete",$this->request->createURL("Admin", "delete","ID"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->assign("back",$this->request->createURL("Admin", "adminManager"));
		$result				= $this->adminFacade->editAdd($_POST);
		if($result['result'])
		{
			$this->request->setAttribute("message-succ", $result['message']);
			$this->edit();
		}else{
			$this->request->setAttribute("message", $result['message']);
			$this->edit();
		}
		// $this->adminManager();
		/*$res2 = $this->adminFacade->fetchUserDetails();
		$this->page->assign("values",$res2);*/
		//$this->page->getPage('teammanager.tpl');
	}

	/**
	*@desc This function is the delete function the purpose of this function is to change the status of the user from                       Active to Inactive. This function calls the changeStatus() function of AdminFacade class.
	*/
	public function delete()
	{
		$do 				= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 			= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("act",$action);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("searchUser",$this->request->createURL("Admin","searchUserForm"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("classificationStats",$this->request->createURL("Admin","classificationStats"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("back",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("edit_url",$this->request->createURL("Admin", "edit","ID"));
		$this->page->assign("delete",$this->request->createURL("Admin", "delete","name={$this->request->getAttribute("name")}&access={$this->request->getAttribute("access")}&fr={$this->request->getAttribute("fr")}&ID"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$result				= $this->adminFacade->changeStatus($_GET);
		$res				= $this->adminFacade->searchUsers($_GET,$this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"));
		$this->page->assign("values",$res['blogs']);
		$this->page->assign("paging",$res['paging']);
		$this->page->getPage('teammanager.tpl');
	}


	/**
	*@desc This function is used for getting an enter box for the user to search the client.
	*/		
	public function searchUserForm()
	{
		$this->page->pageTitle 	= "Search Members";
		$do 					= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 				= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("act",$action);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("searchUser",$this->request->createURL("Admin","searchUserForm"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("classificationStats",$this->request->createURL("Admin","classificationStats"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("back",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("edit_url",$this->request->createURL("Admin", "edit","ID"));
		$this->page->assign("delete",$this->request->createURL("Admin", "delete","name={$this->request->getAttribute("name")}&access={$this->request->getAttribute("access")}&fr={$this->request->getAttribute("fr")}&ID"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("action",$this->request->createURL("Admin","searchUsers"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->getPage("search_user_form.tpl");
	}


	/**
	*@desc This function is used for searching the user on the basis of search criteria.
	*/	
	public function searchUsers()
	{
		$do 				= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 			= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("act",$action);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("searchUser",$this->request->createURL("Admin","searchUserForm"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("classificationStats",$this->request->createURL("Admin","classificationStats"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("back",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("edit_url",$this->request->createURL("Admin", "edit","ID"));
		$this->page->assign("delete",$this->request->createURL("Admin", "delete","name={$this->request->getAttribute("name")}&access={$this->request->getAttribute("access")}&fr={$this->request->getAttribute("fr")}&ID"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->assign("setPermission",$this->request->createURL("Admin","setPermission","localuser_id"));
		$this->page->assign("changeAccess",$this->request->createURL("Admin","changeAccess","localuser_id"));

		$retArr			= $this->adminFacade->validatesearch($_GET);
		if($retArr['result'])
		{
			$res=$this->adminFacade->searchUsers($_GET,$this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"));
			$this->page->assign("count",count($res['blogs']));
			$this->page->assign("values",$res['blogs']);
			$this->page->assign("paging",$res['paging']);
			$this->page->getPage('teammanager.tpl');
		}
		else
		{
			$this->request->setAttribute("message", $retArr['message']);
			$this->searchUserForm();
		}

	}

	/**
	*@desc This function is used for fetching the details of site performance.
	*/		
	public function sitePerformanceReport()
	{
		$this->page->pageTitle 	= "Site Performance Report";
		$do 					= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 				= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("action",$action);


		$monthArray = array (1=>"January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

		$valMonth="";
		foreach ($monthArray as $key => $val)
		{
			if(isset($_POST['FMonth']) && $key==$_POST['FMonth'])
			{
				$selMonth  ='selected="selected"';
				$valMonth.='<option value="'.$key.'" '.$selMonth.'>'.$val.'</option>';
			}else
			{
				$selMonth  ='';
				$valMonth.='<option value="'.$key.'" '.$selMonth.'>'.$val.'</option>';
			}
		}
		$this->page->assign("Month",$valMonth);

		$valDate ="";
		for($i=1;$i<=31;$i++)
		{
			if(isset($_POST['FDate']) && $i==$_POST['FDate'])
			{
				$selDate ='selected="selected"';
				$valDate.='<option value="'.$i.'" '.$selDate.'>'.$i.'</option>';
			}else
			{
				$selDate ='';
				$valDate.='<option value="'.$i.'" '.$selDate.'>'.$i.'</option>';
			}
		}
		$this->page->assign("Date",$valDate);

		$valYear ="";
		for($y=2007;$y<=2020;$y++)
		{
			if(isset($_POST['FYear']) && $y==$_POST['FYear'])
			{
				$selYear ='selected="selected"';
				$valYear.='<option value="'.$y.'" '.$selYear.'>'.$y.'</option>';
			}else
			{
				$selYear ='';
				$valYear.='<option value="'.$y.'" '.$selYear.'>'.$y.'</option>';
			}
		}
		$this->page->assign("Year",$valYear);

		$valToMonth="";
		foreach ($monthArray as $key => $val)
		{
			if(isset($_POST['ToMonth']) && $key==$_POST['ToMonth'])
			{
				$selToMonth  ='selected="selected"';
				$valToMonth.='<option value="'.$key.'" '.$selToMonth.'>'.$val.'</option>';
			}else
			{
				$selToMonth  ='';
				$valToMonth.='<option value="'.$key.'" '.$selToMonth.'>'.$val.'</option>';
			}
		}
		$this->page->assign("ToMonth",$valToMonth);

		$valToDate ="";
		for($i=1;$i<=31;$i++)
		{
			if(isset($_POST['ToDate']) && $i==$_POST['ToDate'])
			{
				$selToDate ='selected="selected"';
				$valToDate.='<option value="'.$i.'" '.$selToDate.'>'.$i.'</option>';
			}else
			{
				$selToDate ='';
				$valToDate.='<option value="'.$i.'" '.$selToDate.'>'.$i.'</option>';
			}
		}
		$this->page->assign("ToDate",$valToDate);

		$valToYear ="";
		for($y=2007;$y<=2020;$y++)
		{
			if(isset($_POST['ToYear']) && $y==$_POST['ToYear'])
			{
				$selToYear ='selected="selected"';
				$valToYear.='<option value="'.$y.'" '.$selToYear.'>'.$y.'</option>';
			}else
			{
				$selToYear ='';
				$valToYear.='<option value="'.$y.'" '.$selToYear.'>'.$y.'</option>';
			}
		}
		$this->page->assign("ToYear",$valToYear);


		$this->page->assign("pagePopularityReport",$this->request->createURL("Admin","pagePopularityReport"));
		$this->page->assign("class_region_report",$this->request->createURL("Classification","regionReport"));
		$this->page->assign("class_region_total_report",$this->request->createURL("Classification","class_region_total_report"));
		$this->page->assign("ctr_report",$this->request->createURL("Classification","ctrReport"));				
		$this->page->assign("classificationBannerReport",$this->request->createURL("BannerManager", "classificationBannerReport"));						
		$this->page->assign("sitePerformanceReport",$this->request->createURL("Admin","sitePerformanceReport"));
		$this->page->assign("rankReport",$this->request->createURL("Admin","rankReport"));
		//$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("classificationStats",$this->request->createURL("Admin","classificationStats"));
		$this->page->assign("BusinessManager_url",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("viewList",$this->request->createURL("SalesAccountManager", "viewList"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("keyword",$this->request->createURL("Classification","viewKeyword"));
		$this->page->assign("view",$this->request->createURL("Key", "viewList"));
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("viewLocation",$this->request->createURL("Location","viewLocation"));
		$this->page->assign("viewPage",$this->request->createURL("Content","viewPage"));

		$this->page->assign("viewGroup",$this->request->createURL("Group","viewGroup"));
		$this->page->assign("viewGroup",$this->request->createURL("Group","viewGroup"));

		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("fetchUniqueClients",$this->request->createURL("Admin","fetchUniqueClients"));
		$this->page->assign("clients_in_specific_locality",$this->request->createURL("Admin","search_locality_based_clients_form"));
		//$this->page->assign("clients_in_specific_locality",$this->request->createURL("Admin","clients_in_specific_locality"));
		$this->page->assign("classificationStats",$this->request->createURL("Admin","classificationStats"));
		$this->page->assign("failed_searches",$this->request->createURL("Admin","failed_searches"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->assign("count_listing",$this->request->createURL("Admin","count_listing"));
		$this->page->assign("search_within_a_locality_count",$this->request->createURL("Admin","search_within_a_locality_count","FDate={$this->request->getAttribute("FDate")}&FMonth={$this->request->getAttribute("FMonth")}&FYear={$this->request->getAttribute("FYear")}&ToDate={$this->request->getAttribute("ToDate")}&ToMonth={$this->request->getAttribute("ToMonth")}&ToYear={$this->request->getAttribute("ToYear")}"));
		$this->page->assign("act",$_GET['action']);
		$resip			= $this->adminFacade->viewReport($_POST);
		$this->page->assign("values",$resip);
		$result			= $this->adminFacade->searchStats();
		$totalUsers		= count($result);
		$totalCount		= 0;
		foreach($result as $searchValue)
		{
			$totalCount	= $totalCount+$searchValue['count'];
		}
		$AvgCount		= round($totalCount/$totalUsers);
		$this->page->assign("AvgCount",$AvgCount);
		$this->page->assign("totalCount",$totalCount);

		$totalCount		= 0;
		$searchStatsDateWise			= $this->adminFacade->searchStatsDateWise($_POST);
		$searchStatsDateWise_count		= count($searchStatsDateWise);

		if(!$searchStatsDateWise_count=='')
		{
			foreach($searchStatsDateWise as $searchValueDateWise)
			{
				$totalCount	= $totalCount+$searchValueDateWise['count'];
			}
			$AvgDateWiseCount		= round($totalCount/$searchStatsDateWise_count);
			$this->page->assign("AvgDateWiseCount",$AvgDateWiseCount);
		}

		$this->page->assign("totalCount1",$totalCount);


		$this->page->getPage("site_performance_report.tpl");
	}


	/**
	*@desc This function is used for fetching the details of classification.
	*/		
	public function classificationStats()
	{
		$this->page->pageTitle = "Classification Statistics";
		$do 				= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 			= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("action",$action);


		$monthArray = array (1=>"January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

		$valMonth="";
		foreach ($monthArray as $key => $val)
		{
			if(isset($_POST['FMonth']) && $key==$_POST['FMonth'])
			{
				$selMonth  ='selected="selected"';
				$valMonth.='<option value="'.$key.'" '.$selMonth.'>'.$val.'</option>';
			}else
			{
				$selMonth  ='';
				$valMonth.='<option value="'.$key.'" '.$selMonth.'>'.$val.'</option>';
			}
		}
		$this->page->assign("Month",$valMonth);

		$valDate ="";
		for($i=1;$i<=31;$i++)
		{
			if(isset($_POST['FDate']) && $i==$_POST['FDate'])
			{
				$selDate ='selected="selected"';
				$valDate.='<option value="'.$i.'" '.$selDate.'>'.$i.'</option>';
			}else
			{
				$selDate ='';
				$valDate.='<option value="'.$i.'" '.$selDate.'>'.$i.'</option>';
			}
		}
		$this->page->assign("Date",$valDate);

		$valYear ="";
		for($y=2007;$y<=2020;$y++)
		{
			if(isset($_POST['FYear']) && $y==$_POST['FYear'])
			{
				$selYear ='selected="selected"';
				$valYear.='<option value="'.$y.'" '.$selYear.'>'.$y.'</option>';
			}else
			{
				$selYear ='';
				$valYear.='<option value="'.$y.'" '.$selYear.'>'.$y.'</option>';
			}
		}
		$this->page->assign("Year",$valYear);

		$valToMonth="";
		foreach ($monthArray as $key => $val)
		{
			if(isset($_POST['ToMonth']) && $key==$_POST['ToMonth'])
			{
				$selToMonth  ='selected="selected"';
				$valToMonth.='<option value="'.$key.'" '.$selToMonth.'>'.$val.'</option>';
			}else
			{
				$selToMonth  ='';
				$valToMonth.='<option value="'.$key.'" '.$selToMonth.'>'.$val.'</option>';
			}
		}
		$this->page->assign("ToMonth",$valToMonth);

		$valToDate ="";
		for($i=1;$i<=31;$i++)
		{
			if(isset($_POST['ToDate']) && $i==$_POST['ToDate'])
			{
				$selToDate ='selected="selected"';
				$valToDate.='<option value="'.$i.'" '.$selToDate.'>'.$i.'</option>';
			}else
			{
				$selToDate ='';
				$valToDate.='<option value="'.$i.'" '.$selToDate.'>'.$i.'</option>';
			}
		}
		$this->page->assign("ToDate",$valToDate);

		$valToYear ="";
		for($y=2007;$y<=2020;$y++)
		{
			if(isset($_POST['ToYear']) && $y==$_POST['ToYear'])
			{
				$selToYear ='selected="selected"';
				$valToYear.='<option value="'.$y.'" '.$selToYear.'>'.$y.'</option>';
			}else
			{
				$selToYear ='';
				$valToYear.='<option value="'.$y.'" '.$selToYear.'>'.$y.'</option>';
			}
		}
		$this->page->assign("ToYear",$valToYear);

		$this->page->assign("class_region_report",$this->request->createURL("Classification","regionReport"));
		$this->page->assign("pagePopularityReport",$this->request->createURL("Admin","pagePopularityReport"));
		$this->page->assign("sitePerformanceReport",$this->request->createURL("Admin","sitePerformanceReport"));
		$this->page->assign("rankReport",$this->request->createURL("Admin","rankReport"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("BusinessManager_url",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("viewList",$this->request->createURL("SalesAccountManager", "viewList"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("keyword",$this->request->createURL("Classification","viewKeyword"));
		$this->page->assign("view",$this->request->createURL("Key", "viewList"));
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("viewLocation",$this->request->createURL("Location","viewLocation"));
		$this->page->assign("viewPage",$this->request->createURL("Content","viewPage"));

		$this->page->assign("viewVertical",$this->request->createURL("Vertical","viewVertical"));
		$this->page->assign("viewGroup",$this->request->createURL("Vertical","viewGroup"));

		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("fetchUniqueClients",$this->request->createURL("Admin","fetchUniqueClients"));
		$this->page->assign("clients_in_specific_locality",$this->request->createURL("Admin","search_locality_based_clients_form"));
		//$this->page->assign("clients_in_specific_locality",$this->request->createURL("Admin","clients_in_specific_locality"));
		$this->page->assign("classificationStats",$this->request->createURL("Admin","classificationStats"));
		$this->page->assign("failed_searches",$this->request->createURL("Admin","failed_searches"));
		$this->page->assign("count_listing",$this->request->createURL("Admin","count_listing"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->assign("search_within_a_locality_count",$this->request->createURL("Admin","search_within_a_locality_count","FDate={$this->request->getAttribute("FDate")}&FMonth={$this->request->getAttribute("FMonth")}&FYear={$this->request->getAttribute("FYear")}&ToDate={$this->request->getAttribute("ToDate")}&ToMonth={$this->request->getAttribute("ToMonth")}&ToYear={$this->request->getAttribute("ToYear")}"));
		$this->page->assign("action1",$_GET['action']);

		$uniqueClass=$this->adminFacade->categorySearchCount($_POST,$this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"));

		$this->page->assign("count",count($uniqueClass['categorySearch']));
		$this->page->assign("uniqueClass",$uniqueClass['categorySearch']);
		$this->page->assign("paging",$uniqueClass['paging']);
		$this->page->getPage("classification_stats_report.tpl");

	}


	/**
	*@desc This function is used for fetching the details of page popularity.
	*/		
	public function pagePopularityReport()
	{
		$this->page->pageTitle 	= "Page Popularity Report";
		$do 				= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 			= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("action",$action);


		$monthArray = array (1=>"January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

		$valMonth="";
		foreach ($monthArray as $key => $val)
		{
			if(isset($_POST['FMonth']) && $key==$_POST['FMonth'])
			{
				$selMonth  ='selected="selected"';
				$valMonth.='<option value="'.$key.'" '.$selMonth.'>'.$val.'</option>';
			}else
			{
				$selMonth  ='';
				$valMonth.='<option value="'.$key.'" '.$selMonth.'>'.$val.'</option>';
			}
		}
		$this->page->assign("Month",$valMonth);

		$valDate ="";
		for($i=1;$i<=31;$i++)
		{
			if(isset($_POST['FDate']) && $i==$_POST['FDate'])
			{
				$selDate ='selected="selected"';
				$valDate.='<option value="'.$i.'" '.$selDate.'>'.$i.'</option>';
			}else
			{
				$selDate ='';
				$valDate.='<option value="'.$i.'" '.$selDate.'>'.$i.'</option>';
			}
		}
		$this->page->assign("Date",$valDate);

		$valYear ="";
		for($y=2007;$y<=2020;$y++)
		{
			if(isset($_POST['FYear']) && $y==$_POST['FYear'])
			{
				$selYear ='selected="selected"';
				$valYear.='<option value="'.$y.'" '.$selYear.'>'.$y.'</option>';
			}else
			{
				$selYear ='';
				$valYear.='<option value="'.$y.'" '.$selYear.'>'.$y.'</option>';
			}
		}
		$this->page->assign("Year",$valYear);

		$valToMonth="";
		foreach ($monthArray as $key => $val)
		{
			if(isset($_POST['ToMonth']) && $key==$_POST['ToMonth'])
			{
				$selToMonth  ='selected="selected"';
				$valToMonth.='<option value="'.$key.'" '.$selToMonth.'>'.$val.'</option>';
			}else
			{
				$selToMonth  ='';
				$valToMonth.='<option value="'.$key.'" '.$selToMonth.'>'.$val.'</option>';
			}
		}
		$this->page->assign("ToMonth",$valToMonth);

		$valToDate ="";
		for($i=1;$i<=31;$i++)
		{
			if(isset($_POST['ToDate']) && $i==$_POST['ToDate'])
			{
				$selToDate ='selected="selected"';
				$valToDate.='<option value="'.$i.'" '.$selToDate.'>'.$i.'</option>';
			}else
			{
				$selToDate ='';
				$valToDate.='<option value="'.$i.'" '.$selToDate.'>'.$i.'</option>';
			}
		}
		$this->page->assign("ToDate",$valToDate);

		$valToYear ="";
		for($y=2007;$y<=2020;$y++)
		{
			if(isset($_POST['ToYear']) && $y==$_POST['ToYear'])
			{
				$selToYear ='selected="selected"';
				$valToYear.='<option value="'.$y.'" '.$selToYear.'>'.$y.'</option>';
			}else
			{
				$selToYear ='';
				$valToYear.='<option value="'.$y.'" '.$selToYear.'>'.$y.'</option>';
			}
		}
		$this->page->assign("ToYear",$valToYear);



		$this->page->assign("class_region_report",$this->request->createURL("Classification","regionReport"));
		$this->page->assign("pagePopularityReport",$this->request->createURL("Admin","pagePopularityReport"));
		$this->page->assign("sitePerformanceReport",$this->request->createURL("Admin","sitePerformanceReport"));
		$this->page->assign("rankReport",$this->request->createURL("Admin","rankReport"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("BusinessManager_url",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("viewList",$this->request->createURL("SalesAccountManager", "viewList"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("classificationStats",$this->request->createURL("Admin","classificationStats"));
		$this->page->assign("keyword",$this->request->createURL("Classification","viewKeyword"));
		$this->page->assign("view",$this->request->createURL("Key", "viewList"));
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("viewLocation",$this->request->createURL("Location","viewLocation"));
		$this->page->assign("viewPage",$this->request->createURL("Content","viewPage"));

		$this->page->assign("viewVertical",$this->request->createURL("Vertical","viewVertical"));
		$this->page->assign("viewGroup",$this->request->createURL("Group","viewGroup"));

		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("fetchUniqueClients",$this->request->createURL("Admin","fetchUniqueClients"));
		$this->page->assign("clients_in_specific_locality",$this->request->createURL("Admin","search_locality_based_clients_form"));
		//$this->page->assign("clients_in_specific_locality",$this->request->createURL("Admin","clients_in_specific_locality"));
		$this->page->assign("failed_searches",$this->request->createURL("Admin","failed_searches"));
		$this->page->assign("count_listing",$this->request->createURL("Admin","count_listing"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->assign("search_within_a_locality_count",$this->request->createURL("Admin","search_within_a_locality_count","FDate={$this->request->getAttribute("FDate")}&FMonth={$this->request->getAttribute("FMonth")}&FYear={$this->request->getAttribute("FYear")}&ToDate={$this->request->getAttribute("ToDate")}&ToMonth={$this->request->getAttribute("ToMonth")}&ToYear={$this->request->getAttribute("ToYear")}"));
		$this->page->assign("action1",$_GET['action']);
		$popularityArray		= $this->adminFacade->pagePopularityReport($_POST);

		/*if(count($popularityArray[0])!='' && count($popularityArray[1])!='')
		{*/
		$this->page->assign("popularityArray0",$popularityArray[0]);
		$this->page->assign("popularityArray0Count",count($popularityArray[0]));
		$this->page->assign("popularityArray1",$popularityArray[1]);
		$this->page->assign("popularityArray1Count",count($popularityArray[1]));
		/*}else{*/
		$this->page->assign("popularityArray2",$popularityArray);
		$this->page->assign("popularityArray2Count",count($popularityArray));
		/*}*/
		$this->page->getPage("page_popularity_report.tpl");
	}


	/**
	*@desc This function is used for fetching the details of site performance.
	*/		
	public function fetchUniqueClients()
	{
		$this->page->pageTitle 	= "Unique clients list";
		$do 				= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 			= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("action",$action);
		$this->page->assign("class_region_report",$this->request->createURL("Classification","regionReport"));
		$this->page->assign("pagePopularityReport",$this->request->createURL("Admin","pagePopularityReport"));
		$this->page->assign("sitePerformanceReport",$this->request->createURL("Admin","sitePerformanceReport"));
		$this->page->assign("rankReport",$this->request->createURL("Admin","rankReport"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("BusinessManager_url",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("viewList",$this->request->createURL("SalesAccountManager", "viewList"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("classificationStats",$this->request->createURL("Admin","classificationStats"));
		$this->page->assign("keyword",$this->request->createURL("Classification","viewKeyword"));
		$this->page->assign("view",$this->request->createURL("Key", "viewList"));
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("viewLocation",$this->request->createURL("Location","viewLocation"));
		$this->page->assign("viewPage",$this->request->createURL("Content","viewPage"));

		$this->page->assign("viewVertical",$this->request->createURL("Vertical","viewVertical"));
		$this->page->assign("viewGroup",$this->request->createURL("Group","viewGroup"));

		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("fetchUniqueClients",$this->request->createURL("Admin","fetchUniqueClients"));
		$this->page->assign("clients_in_specific_locality",$this->request->createURL("Admin","search_locality_based_clients_form"));
		//$this->page->assign("clients_in_specific_locality",$this->request->createURL("Admin","clients_in_specific_locality"));
		$this->page->assign("failed_searches",$this->request->createURL("Admin","failed_searches"));
		$this->page->assign("count_listing",$this->request->createURL("Admin","count_listing"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->assign("search_within_a_locality_count",$this->request->createURL("Admin","search_within_a_locality_count","FDate={$this->request->getAttribute("FDate")}&FMonth={$this->request->getAttribute("FMonth")}&FYear={$this->request->getAttribute("FYear")}&ToDate={$this->request->getAttribute("ToDate")}&ToMonth={$this->request->getAttribute("ToMonth")}&ToYear={$this->request->getAttribute("ToYear")}"));
		$this->page->assign("action1",$_GET['action']);

		$clients				=$this->adminFacade->getClients($this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"));

		$this->page->assign("values1",$clients['blogs']);
		$this->page->assign("paging",$clients['paging']);
		$this->page->getPage("Unique_clients_lists.tpl");
	}


	/**
	*@desc This function is used for fetching the details of client in the specefic locality.
	*/		
	public function clients_in_specific_locality()
	{
		$this->page->pageTitle 	= "Clients in specific locality";
		$do 					= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 				= (!empty($_GET['action']))?$_GET['action']:NULL;

		$this->page->assign("do",$do);
		$this->page->assign("action",$action);
		$this->page->assign("pagePopularityReport",$this->request->createURL("Admin","pagePopularityReport"));
		$this->page->assign("sitePerformanceReport",$this->request->createURL("Admin","sitePerformanceReport"));

		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("rankReport",$this->request->createURL("Admin","rankReport"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("BusinessManager_url",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("viewList",$this->request->createURL("SalesAccountManager", "viewList"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("classificationStats",$this->request->createURL("Admin","classificationStats"));
		$this->page->assign("keyword",$this->request->createURL("Classification","viewKeyword"));
		$this->page->assign("view",$this->request->createURL("Key", "viewList"));
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("viewLocation",$this->request->createURL("Location","viewLocation"));
		$this->page->assign("viewPage",$this->request->createURL("Content","viewPage"));
		$this->page->assign("viewVertical",$this->request->createURL("Vertical","viewVertical"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("fetchUniqueClients",$this->request->createURL("Admin","fetchUniqueClients"));
		//$this->page->assign("clients_in_specific_locality",$this->request->createURL("Admin","clients_in_specific_locality"));
		$this->page->assign("failed_searches",$this->request->createURL("Admin","failed_searches"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->assign("count_listing",$this->request->createURL("Admin","count_listing"));
		$this->page->assign("search_within_a_locality_count",$this->request->createURL("Admin","search_within_a_locality_count","FDate={$this->request->getAttribute("FDate")}&FMonth={$this->request->getAttribute("FMonth")}&FYear={$this->request->getAttribute("FYear")}&ToDate={$this->request->getAttribute("ToDate")}&ToMonth={$this->request->getAttribute("ToMonth")}&ToYear={$this->request->getAttribute("ToYear")}"));
		$this->page->assign("action1",$_GET['action']);

		$res						= $this->adminFacade->getLocalityBasedClients($this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"));

		$this->page->assign("values2",$res['blogs']);
		$this->page->assign("paging",$res['paging']);
		$this->page->getPage("clients_in_specific_locality.tpl");
	}

	public function search_locality_based_clients_form()
	{
		$this->page->pageTitle 	= "Clients in specific locality";
		$do							= $_GET['do'];
		$action						= $_GET['action'];

		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$this->page->assign("class_region_report",$this->request->createURL("Classification","regionReport"));
		$this->page->assign("pagePopularityReport",$this->request->createURL("Admin","pagePopularityReport"));
		$this->page->assign("sitePerformanceReport",$this->request->createURL("Admin","sitePerformanceReport"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("classificationStats",$this->request->createURL("Admin","classificationStats"));
		$this->page->assign("fetchUniqueClients",$this->request->createURL("Admin","fetchUniqueClients"));
		$this->page->assign("clients_in_specific_locality",$this->request->createURL("Admin","search_locality_based_clients_form"));
		$this->page->assign("failed_searches",$this->request->createURL("Admin","failed_searches"));
		$this->page->assign("count_listing",$this->request->createURL("Admin","count_listing"));
		$this->page->assign("action",$this->request->createURL("Admin","search_locality_based_clients"));
		$result=$this->adminFacade->getSuburbs();
		$this->page->assign("values",$result);
		$this->page->getPage("locality_based_clients_search_form.tpl");
	}

	public function search_locality_based_clients()
	{
		$this->page->pageTitle 	= "Clients in specific locality";
		$do 						= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 					= (!empty($_GET['action']))?$_GET['action']:NULL;

		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$this->page->assign("pagePopularityReport",$this->request->createURL("Admin","pagePopularityReport"));
		$this->page->assign("sitePerformanceReport",$this->request->createURL("Admin","sitePerformanceReport"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("classificationStats",$this->request->createURL("Admin","classificationStats"));
		$this->page->assign("fetchUniqueClients",$this->request->createURL("Admin","fetchUniqueClients"));
		$this->page->assign("clients_in_specific_locality",$this->request->createURL("Admin","search_locality_based_clients_form"));
		$this->page->assign("failed_searches",$this->request->createURL("Admin","failed_searches"));
		$this->page->assign("count_listing",$this->request->createURL("Admin","count_listing"));
		$this->page->assign("search_within_a_locality_count",$this->request->createURL("Admin","search_within_a_locality_count","FDate={$this->request->getAttribute("FDate")}&FMonth={$this->request->getAttribute("FMonth")}&FYear={$this->request->getAttribute("FYear")}&ToDate={$this->request->getAttribute("ToDate")}&ToMonth={$this->request->getAttribute("ToMonth")}&ToYear={$this->request->getAttribute("ToYear")}"));
		$resultSuburb				= $this->adminFacade->__validateSuburb($_GET);
		if($resultSuburb['result'])
		{
			$res						= $this->adminFacade->getLocalityBasedClients($_GET,$this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"));
			$this->page->assign("count",count($res['blogs']));
			$this->page->assign("values2",$res['blogs']);
			$this->page->assign("paging",$res['paging']);
			$this->page->getPage("clients_in_specific_locality.tpl");
		}else{
			$this->request->setAttribute("message", $resultSuburb['message']);
			$this->search_locality_based_clients_form();
		}
	}


	/**
	*@desc This function is used for fetching the details of failed search.
	*/		
	public function failed_searches()
	{
		$this->page->pageTitle 		= "Failed searches";
		$do 						= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 					= (!empty($_GET['action']))?$_GET['action']:NULL;

		$this->page->assign("do",$do);
		$this->page->assign("action",$action);

		$monthArray = array (1=>"January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

		$valMonth="";
		foreach ($monthArray as $key => $val)
		{
			if(isset($_GET['FMonth']) && $key==$_GET['FMonth'])
			{
				$selMonth  ='selected="selected"';
				$valMonth.='<option value="'.$key.'" '.$selMonth.'>'.$val.'</option>';
			}else
			{
				$selMonth  ='';
				$valMonth.='<option value="'.$key.'" '.$selMonth.'>'.$val.'</option>';
			}
		}
		$this->page->assign("Month",$valMonth);

		$valDate ="";
		for($i=1;$i<=31;$i++)
		{
			if(isset($_GET['FDate']) && $i==$_GET['FDate'])
			{
				$selDate ='selected="selected"';
				$valDate.='<option value="'.$i.'" '.$selDate.'>'.$i.'</option>';
			}else
			{
				$selDate ='';
				$valDate.='<option value="'.$i.'" '.$selDate.'>'.$i.'</option>';
			}
		}
		$this->page->assign("Date",$valDate);

		$valYear ="";
		for($y=2007;$y<=2020;$y++)
		{
			if(isset($_GET['FYear']) && $y==$_GET['FYear'])
			{
				$selYear ='selected="selected"';
				$valYear.='<option value="'.$y.'" '.$selYear.'>'.$y.'</option>';
			}else
			{
				$selYear ='';
				$valYear.='<option value="'.$y.'" '.$selYear.'>'.$y.'</option>';
			}
		}
		$this->page->assign("Year",$valYear);

		$valToMonth="";
		foreach ($monthArray as $key => $val)
		{
			if(isset($_GET['ToMonth']) && $key==$_GET['ToMonth'])
			{
				$selToMonth  ='selected="selected"';
				$valToMonth.='<option value="'.$key.'" '.$selToMonth.'>'.$val.'</option>';
			}else
			{
				$selToMonth  ='';
				$valToMonth.='<option value="'.$key.'" '.$selToMonth.'>'.$val.'</option>';
			}
		}
		$this->page->assign("ToMonth",$valToMonth);

		$valToDate ="";
		for($i=1;$i<=31;$i++)
		{
			if(isset($_GET['ToDate']) && $i==$_GET['ToDate'])
			{
				$selToDate ='selected="selected"';
				$valToDate.='<option value="'.$i.'" '.$selToDate.'>'.$i.'</option>';
			}else
			{
				$selToDate ='';
				$valToDate.='<option value="'.$i.'" '.$selToDate.'>'.$i.'</option>';
			}
		}
		$this->page->assign("ToDate",$valToDate);

		$valToYear ="";
		for($y=2007;$y<=2020;$y++)
		{
			if(isset($_GET['ToYear']) && $y==$_GET['ToYear'])
			{
				$selToYear ='selected="selected"';
				$valToYear.='<option value="'.$y.'" '.$selToYear.'>'.$y.'</option>';
			}else
			{
				$selToYear ='';
				$valToYear.='<option value="'.$y.'" '.$selToYear.'>'.$y.'</option>';
			}
		}
		$this->page->assign("ToYear",$valToYear);

		$this->page->assign("class_region_report",$this->request->createURL("Classification","regionReport"));
		$this->page->assign("pagePopularityReport",$this->request->createURL("Admin","pagePopularityReport"));
		$this->page->assign("sitePerformanceReport",$this->request->createURL("Admin","sitePerformanceReport"));
		$this->page->assign("rankReport",$this->request->createURL("Admin","rankReport"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("BusinessManager_url",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("viewList",$this->request->createURL("SalesAccountManager", "viewList"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("classificationStats",$this->request->createURL("Admin","classificationStats"));
		$this->page->assign("keyword",$this->request->createURL("Classification","viewKeyword"));
		$this->page->assign("view",$this->request->createURL("Key", "viewList"));
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("viewLocation",$this->request->createURL("Location","viewLocation"));
		$this->page->assign("viewPage",$this->request->createURL("Content","viewPage"));
		$this->page->assign("viewVertical",$this->request->createURL("Vertical","viewVertical"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("fetchUniqueClients",$this->request->createURL("Admin","fetchUniqueClients"));
		$this->page->assign("clients_in_specific_locality",$this->request->createURL("Admin","search_locality_based_clients_form"));
		//$this->page->assign("clients_in_specific_locality",$this->request->createURL("Admin","clients_in_specific_locality"));
		$this->page->assign("count_listing",$this->request->createURL("Admin","count_listing"));
		$this->page->assign("failed_searches",$this->request->createURL("Admin","failed_searches","FDate={$this->request->getAttribute("FDate")}&FMonth={$this->request->getAttribute("FMonth")}&FYear={$this->request->getAttribute("FYear")}&ToDate={$this->request->getAttribute("ToDate")}&ToMonth={$this->request->getAttribute("ToMonth")}&ToYear={$this->request->getAttribute("ToYear")}"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->assign("search_within_a_locality_count",$this->request->createURL("Admin","search_within_a_locality_count","FDate={$this->request->getAttribute("FDate")}&FMonth={$this->request->getAttribute("FMonth")}&FYear={$this->request->getAttribute("FYear")}&ToDate={$this->request->getAttribute("ToDate")}&ToMonth={$this->request->getAttribute("ToMonth")}&ToYear={$this->request->getAttribute("ToYear")}"));
		$this->page->assign("action1",$_GET['action']);
		$result		= $this->adminFacade->failed_search($_GET,$this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"));

		$this->page->assign("count",count($result['search']));
		$this->page->assign("values12",$result['search']);
		$this->page->assign("paging",$result['paging']);
		$this->page->getPage("failed_searches_list.tpl");
	}


	/**
	*@desc This function is used for fetching the count of various listings.
	*/		
	public function count_listing()
	{
		$this->page->pageTitle 	= "Listing counts";
		$do 				= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 			= (!empty($_GET['action']))?$_GET['action']:NULL;

		$this->page->assign("do",$do);
		$this->page->assign("action",$action);
		$this->page->assign("count_listings_in_vertical",$this->request->createURL("Admin","count_listings_in_vertical"));
		$this->page->assign("count_listings_in_classification",$this->request->createURL("Admin","count_listings_in_classification"));
		$this->page->assign("class_region_report",$this->request->createURL("Classification","regionReport"));
		$this->page->assign("count_listings_in_locality",$this->request->createURL("Admin","count_listings_in_locality"));
		$this->page->assign("pagePopularityReport",$this->request->createURL("Admin","pagePopularityReport"));
		$this->page->assign("sitePerformanceReport",$this->request->createURL("Admin","sitePerformanceReport"));
		$this->page->assign("rankReport",$this->request->createURL("Admin","rankReport"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("BusinessManager_url",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("viewList",$this->request->createURL("SalesAccountManager", "viewList"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("classificationStats",$this->request->createURL("Admin","classificationStats"));
		$this->page->assign("keyword",$this->request->createURL("Classification","viewKeyword"));
		$this->page->assign("view",$this->request->createURL("Key", "viewList"));
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("viewLocation",$this->request->createURL("Location","viewLocation"));
		$this->page->assign("viewPage",$this->request->createURL("Content","viewPage"));
		$this->page->assign("viewVertical",$this->request->createURL("Vertical","viewVertical"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("fetchUniqueClients",$this->request->createURL("Admin","fetchUniqueClients"));
		$this->page->assign("clients_in_specific_locality",$this->request->createURL("Admin","search_locality_based_clients_form"));
		//$this->page->assign("clients_in_specific_locality",$this->request->createURL("Admin","clients_in_specific_locality"));
		$this->page->assign("count_listing",$this->request->createURL("Admin","count_listing"));
		$this->page->assign("failed_searches",$this->request->createURL("Admin","failed_searches"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->assign("search_within_a_locality_count",$this->request->createURL("Admin","search_within_a_locality_count","FDate={$this->request->getAttribute("FDate")}&FMonth={$this->request->getAttribute("FMonth")}&FYear={$this->request->getAttribute("FYear")}&ToDate={$this->request->getAttribute("ToDate")}&ToMonth={$this->request->getAttribute("ToMonth")}&ToYear={$this->request->getAttribute("ToYear")}"));
		$this->page->assign("action1",$_GET['action']);
		$this->page->getPage("count_listing.tpl");
	}


	/**
	*@desc This function is used for fetching the count the variour listings in the particular classification.
	*/		
	public function count_listings_in_classification()
	{
		$this->page->pageTitle 	= "Listing counts baseed on classification";
		$do 					= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 				= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("action",$action);

		$this->page->assign("count_listing",$this->request->createURL("Admin","count_listing"));
		$this->page->assign("pagePopularityReport",$this->request->createURL("Admin","pagePopularityReport"));
		$this->page->assign("sitePerformanceReport",$this->request->createURL("Admin","sitePerformanceReport"));
		$this->page->assign("rankReport",$this->request->createURL("Admin","rankReport"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("BusinessManager_url",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("viewList",$this->request->createURL("SalesAccountManager", "viewList"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("classificationStats",$this->request->createURL("Admin","classificationStats"));
		$this->page->assign("keyword",$this->request->createURL("Classification","viewKeyword"));
		$this->page->assign("view",$this->request->createURL("Key", "viewList"));
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("viewLocation",$this->request->createURL("Location","viewLocation"));
		$this->page->assign("viewPage",$this->request->createURL("Content","viewPage"));
		$this->page->assign("viewVertical",$this->request->createURL("Vertical","viewVertical"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("fetchUniqueClients",$this->request->createURL("Admin","fetchUniqueClients"));
		$this->page->assign("clients_in_specific_locality",$this->request->createURL("Admin","search_locality_based_clients_form"));
		//$this->page->assign("clients_in_specific_locality",$this->request->createURL("Admin","clients_in_specific_locality"));
		$this->page->assign("failed_searches",$this->request->createURL("Admin","failed_searches"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->assign("search_within_a_locality_count",$this->request->createURL("Admin","search_within_a_locality_count","FDate={$this->request->getAttribute("FDate")}&FMonth={$this->request->getAttribute("FMonth")}&FYear={$this->request->getAttribute("FYear")}&ToDate={$this->request->getAttribute("ToDate")}&ToMonth={$this->request->getAttribute("ToMonth")}&ToYear={$this->request->getAttribute("ToYear")}"));
		$this->page->assign("action1",$_GET['action']);
		$result					= $this->adminFacade->count_listings_in_classification($this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"));
		$this->page->assign("values",$result['rank']);
		$this->page->assign("paging",$result['paging']);
		$this->page->getPage("count_listings_in_classification.tpl");
	}


	/**
	*@desc This function is used for fetching the count the variour listings in the particular vertical.
	*/	 
	public function count_listings_in_vertical()
	{
		$this->page->pageTitle 		= "Listing counts based on vertical";
		$do 						= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 					= (!empty($_GET['action']))?$_GET['action']:NULL;

		$this->page->assign("do",$do);
		$this->page->assign("action",$action);
		$this->page->assign("count_listing",$this->request->createURL("Admin","count_listing"));
		$this->page->assign("pagePopularityReport",$this->request->createURL("Admin","pagePopularityReport"));
		$this->page->assign("sitePerformanceReport",$this->request->createURL("Admin","sitePerformanceReport"));
		$this->page->assign("rankReport",$this->request->createURL("Admin","rankReport"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("BusinessManager_url",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("viewList",$this->request->createURL("SalesAccountManager", "viewList"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("classificationStats",$this->request->createURL("Admin","classificationStats"));
		$this->page->assign("keyword",$this->request->createURL("Classification","viewKeyword"));
		$this->page->assign("view",$this->request->createURL("Key", "viewList"));
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("viewLocation",$this->request->createURL("Location","viewLocation"));
		$this->page->assign("viewPage",$this->request->createURL("Content","viewPage"));
		$this->page->assign("viewVertical",$this->request->createURL("Vertical","viewVertical"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("fetchUniqueClients",$this->request->createURL("Admin","fetchUniqueClients"));
		$this->page->assign("clients_in_specific_locality",$this->request->createURL("Admin","search_locality_based_clients_form"));
		//$this->page->assign("clients_in_specific_locality",$this->request->createURL("Admin","clients_in_specific_locality"));
		$this->page->assign("failed_searches",$this->request->createURL("Admin","failed_searches"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->assign("search_within_a_locality_count",$this->request->createURL("Admin","search_within_a_locality_count","FDate={$this->request->getAttribute("FDate")}&FMonth={$this->request->getAttribute("FMonth")}&FYear={$this->request->getAttribute("FYear")}&ToDate={$this->request->getAttribute("ToDate")}&ToMonth={$this->request->getAttribute("ToMonth")}&ToYear={$this->request->getAttribute("ToYear")}"));
		$this->page->assign("action1",$_GET['action']);
		$result				= $this->adminFacade->count_listings_in_vertical($this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"));

		$this->page->assign("values1",$result['search']);
		$this->page->assign("paging",$result['paging']);
		$this->page->getPage("count_listings_in_vertical.tpl");
	}


	/**
	*@desc This function is used for fetching the count the variour listings in the particular locality.
	*/	
	public function count_listings_in_locality()
	{
		$this->page->pageTitle 	= "Listing counts based on locality";
		$do 					= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 				= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("action",$action);

		$this->page->assign("count_listing",$this->request->createURL("Admin","count_listing"));
		$this->page->assign("pagePopularityReport",$this->request->createURL("Admin","pagePopularityReport"));
		$this->page->assign("sitePerformanceReport",$this->request->createURL("Admin","sitePerformanceReport"));
		$this->page->assign("rankReport",$this->request->createURL("Admin","rankReport"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("BusinessManager_url",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("viewList",$this->request->createURL("SalesAccountManager", "viewList"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("classificationStats",$this->request->createURL("Admin","classificationStats"));
		$this->page->assign("keyword",$this->request->createURL("Classification","viewKeyword"));
		$this->page->assign("view",$this->request->createURL("Key", "viewList"));
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("viewLocation",$this->request->createURL("Location","viewLocation"));
		$this->page->assign("viewPage",$this->request->createURL("Content","viewPage"));
		$this->page->assign("viewVertical",$this->request->createURL("Vertical","viewVertical"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("fetchUniqueClients",$this->request->createURL("Admin","fetchUniqueClients"));
		$this->page->assign("clients_in_specific_locality",$this->request->createURL("Admin","search_locality_based_clients_form"));
		//$this->page->assign("clients_in_specific_locality",$this->request->createURL("Admin","clients_in_specific_locality"));
		$this->page->assign("failed_searches",$this->request->createURL("Admin","failed_searches"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->assign("search_within_a_locality_count",$this->request->createURL("Admin","search_within_a_locality_count","FDate={$this->request->getAttribute("FDate")}&FMonth={$this->request->getAttribute("FMonth")}&FYear={$this->request->getAttribute("FYear")}&ToDate={$this->request->getAttribute("ToDate")}&ToMonth={$this->request->getAttribute("ToMonth")}&ToYear={$this->request->getAttribute("ToYear")}"));
		$this->page->assign("action1",$_GET['action']);
		$result						= $this->adminFacade->count_listings_in_locality($this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"));

		$this->page->assign("values2",$result['rank']);
		$this->page->assign("paging",$result['paging']);
		$this->page->getPage("count_listings_in_locality.tpl");
	}


	/**
	*@desc This function is used for editing the details of the client.
	*/		
	public function addclient()
	{
		$this->page->pageTitle 			= "Add client";
		$do 							= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 						= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);

		$clientname						= (!empty($_POST['clientname']))?$_POST['clientname']:NULL;
		$email							= (!empty($_POST['email']))?$_POST['email']:NULL;
		$postcode						= (!empty($_POST['postcode']))?$_POST['postcode']:NULL;
		$phone							= (!empty($_POST['phone']))?$_POST['phone']:NULL;

		$contactname					= (!empty($_POST['contactname']))?$_POST['contactname']:NULL;
		$address						= (!empty($_POST['address']))?$_POST['address']:NULL;
		$fax							= (!empty($_POST['fax']))?$_POST['fax']:NULL;
		$mobile							= (!empty($_POST['mobile']))?$_POST['mobile']:NULL;
		$webaddress						= (!empty($_POST['webaddress']))?$_POST['webaddress']:NULL;
		$account_id						= (!empty($_POST['account_id']))?$_POST['account_id']:NULL;

		$this->page->assign("clientname",$clientname);
		$this->page->assign("email",$email);
		$this->page->assign("postcode",$postcode);
		$this->page->assign("phone",$phone);

		$this->page->assign("contactname",$contactname);
		$this->page->assign("address",$address);
		$this->page->assign("fax",$fax);
		$this->page->assign("mobile",$mobile);
		$this->page->assign("webaddress",$webaddress);
		$this->page->assign("account_id",$account_id);

		$this->page->assign("action",$this->request->createURL("Admin","clientadd"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->assign("editclients",$this->request->createURL("Admin","editclients","ID"));
		$this->page->assign("deleteclients",$this->request->createURL("Admin","deleteclients","ID"));
		$this->page->assign("addaffiliate",$this->request->createURL("Admin","addaffiliate"));
		$this->page->assign("fetchaffiliates",$this->request->createURL("Admin","fetchaffiliates"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("searchclients",$this->request->createURL("Admin","searchclients"));
		$this->page->getPage("add_clients_form.tpl");
	}


	/**
	*@desc This function is used for adding the client.
	*/		
	public function clientadd()
	{
		$do 						= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 					= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$this->page->assign("editclients",$this->request->createURL("Admin","editclients","ID"));
		$this->page->assign("deleteclients",$this->request->createURL("Admin","deleteclients","ID"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("addaffiliate",$this->request->createURL("Admin","addaffiliate"));
		$this->page->assign("searchclients",$this->request->createURL("Admin","searchclients"));
		$this->page->assign("fetchaffiliates",$this->request->createURL("Admin","fetchaffiliates"));
		$res				=$this->adminFacade->clientadd($_POST);
		if($res['result'])
		{
			$this->request->setAttribute("message-succ", $res['message']);
			$this->addclient();
		}
		else{
			$this->request->setAttribute("message", $res['message']);
			$this->addclient();
		}
	}




	/**
	*@desc This function is used for managing the details of the client.
	*/		
	public function clientManager()
	{
		$this->page->pageTitle 		= "Clients List";
		$do 						= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action			 			= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$this->page->assign("editclients",$this->request->createURL("Admin","editclients","ID"));
		$this->page->assign("deleteclients",$this->request->createURL("Admin","deleteclients","name={$this->request->getAttribute("name")}&access={$this->request->getAttribute("access")}&fr={$this->request->getAttribute("fr")}&ID"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("addaffiliate",$this->request->createURL("Admin","addaffiliate"));
		$this->page->assign("fetchaffiliates",$this->request->createURL("Admin","fetchaffiliates"));
		$this->page->assign("changePassword",$this->request->createURL("SalesAccountManager","changePassword"));
		$this->page->assign("searchclients",$this->request->createURL("Admin","searchclients"));
		$result							=$this->adminFacade->clientManager($this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"));

		//	pre($result);

		$this->page->assign("values",$result['search']);
		$this->page->assign("paging",$result['paging']);
		$this->page->getPage("admin_client_manager.tpl");
	}


	/**
	*@desc This function is used for fetching the details of the affiliates.
	*/	
	public function fetchaffiliates()
	{
		$this->page->pageTitle 		= "Affiliates List";
		$do 						= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 					= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$this->page->assign("editaffiliate",$this->request->createURL("Admin","editaffiliate","ID"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->assign("deleteaffiliate",$this->request->createURL("Admin","deleteaffiliate","name={$this->request->getAttribute("name")}&access={$this->request->getAttribute("access")}&fr={$this->request->getAttribute("fr")}&ID"));
		$this->page->assign("addaffiliate",$this->request->createURL("Admin","addaffiliate"));
		$this->page->assign("fetchaffiliates",$this->request->createURL("Admin","fetchaffiliates"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("searchclients",$this->request->createURL("Admin","searchclients"));
		$result						= $this->adminFacade->fetchaffiliates($this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"));

		$this->page->assign("values",$result['search']);
		$this->page->assign("paging",$result['paging']);
		$this->page->getPage("admin_affiliate_list.tpl");
	}

	/**
	*@desc This function is used for adding the affiliate.
	*/		
	public function addaffiliate()
	{
		$this->page->pageTitle 			= "Add client";
		$do 							= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 						= (!empty($_GET['action']))?$_GET['action']:NULL;

		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$email							= (!empty($_POST['email']))?$_POST['email']:NULL;
		$fname							= (!empty($_POST['fname']))?$_POST['fname']:NULL;
		$lname							= (!empty($_POST['lname']))?$_POST['lname']:NULL;
		$password						= (!empty($_POST['password']))?$_POST['password']:NULL;
		$cpassword						= (!empty($_POST['cpassword']))?$_POST['cpassword']:NULL;
		$url							= (!empty($_POST['url']))?$_POST['url']:NULL;
		$address1						= (!empty($_POST['address1']))?$_POST['address1']:NULL;
		$address2						= (!empty($_POST['address2']))?$_POST['address2']:NULL;
		$city							= (!empty($_POST['city']))?$_POST['city']:NULL;
		$zipcode						= (!empty($_POST['zipcode']))?$_POST['zipcode']:NULL;
		$state							= (!empty($_POST['state']))?$_POST['state']:NULL;
		$country						= (!empty($_POST['country']))?$_POST['country']:NULL;
		$phone							= (!empty($_POST['phone']))?$_POST['phone']:NULL;
		$fax							= (!empty($_POST['fax']))?$_POST['fax']:NULL;
		$tax_id							= (!empty($_POST['tax_id']))?$_POST['tax_id']:NULL;
		$timezone						= (!empty($_POST['timezone']))?$_POST['timezone']:NULL;
		$company						= (!empty($_POST['company']))?$_POST['company']:NULL;
		$secrettext						= (!empty($_POST['secrettext']))?$_POST['secrettext']:NULL;

		$this->page->assign("company",$company);
		$this->page->assign("email",$email);
		$this->page->assign("fname",$fname);
		$this->page->assign("lname",$lname);
		$this->page->assign("url",$url);
		$this->page->assign("address1",$address1);
		$this->page->assign("address2",$address2);
		$this->page->assign("city",$city);
		$this->page->assign("zipcode",$zipcode);
		$this->page->assign("state",$state);
		$this->page->assign("country",$country);
		$this->page->assign("phone",$phone);
		$this->page->assign("fax",$fax);
		$this->page->assign("tax_id",$tax_id);
		$this->page->assign("timezone",$timezone);
		$this->page->assign("action",$this->request->createURL("Admin","affiliateadd"));
		$this->page->assign("editaffiliate",$this->request->createURL("Admin","editaffiliate","ID"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->assign("deleteaffiliate",$this->request->createURL("Admin","deleteaffiliate","name={$this->request->getAttribute("name")}&access={$this->request->getAttribute("access")}&fr={$this->request->getAttribute("fr")}&ID"));
		$this->page->assign("addaffiliate",$this->request->createURL("Admin","addaffiliate"));
		$this->page->assign("fetchaffiliates",$this->request->createURL("Admin","fetchaffiliates"));
		$this->page->assign("searchclients",$this->request->createURL("Admin","searchclients"));
		$this->page->getPage("add_affiliate_form.tpl");
	}


	/**
	*@desc This function is used for adding the details of the affiliate.
	*/		
	public function affiliateadd()
	{
		$do 				= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 			= (!empty($_GET['action']))?$_GET['action']:NULL;

		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$this->page->assign("editaffiliate",$this->request->createURL("Admin","editaffiliate","ID"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->assign("deleteaffiliate",$this->request->createURL("Admin","deleteaffiliate","name={$this->request->getAttribute("name")}&access={$this->request->getAttribute("access")}&fr={$this->request->getAttribute("fr")}&ID"));
		$this->page->assign("addaffiliate",$this->request->createURL("Admin","addaffiliate"));
		$this->page->assign("fetchaffiliates",$this->request->createURL("Admin","fetchaffiliates"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("searchclients",$this->request->createURL("Admin","searchclients"));
		$res					= $this->adminFacade->affiliateadd($_POST);
		if($res['result'])
		{
			$this->request->setAttribute("message-succ", $res['message']);
			$this->addaffiliate();
		}
		else{
			$this->request->setAttribute("message", $res['message']);
			$this->addaffiliate();
		}
	}


	/**
	*@desc This function is used for displaying the details of the affilite.
	*/			
	public function editaffiliate()
	{
		$this->page->pageTitle 		= "Edit affiliate profile";
		$do 						= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 					= (!empty($_GET['action']))?$_GET['action']:NULL;

		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);

		$res						= $this->adminFacade->fetch_affiliateeditdetails($_GET);
		$this->page->assign("values1",$res);
		$this->page->assign("action",$this->request->createURL("Admin","editaffiliate_edit","ID"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->assign("editaffiliate",$this->request->createURL("Admin","editaffiliate","ID"));
		$this->page->assign("deleteaffiliate",$this->request->createURL("Admin","deleteaffiliate","name={$this->request->getAttribute("name")}&access={$this->request->getAttribute("access")}&fr={$this->request->getAttribute("fr")}&ID"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("addaffiliate",$this->request->createURL("Admin","addaffiliate"));
		$this->page->assign("fetchaffiliates",$this->request->createURL("Admin","fetchaffiliates"));
		$this->page->assign("searchclients",$this->request->createURL("Admin","searchclients"));
		$this->page->getPage("editaffiliates.tpl");
	}


	/**
	*@desc This function is used for editing the details of afiliates.
	*/		
	public function editaffiliate_edit()
	{
		$do 					= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 				= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$this->page->assign("editaffiliate",$this->request->createURL("Admin","editaffiliate","ID"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->assign("deleteaffiliate",$this->request->createURL("Admin","deleteaffiliate","name={$this->request->getAttribute("name")}&access={$this->request->getAttribute("access")}&fr={$this->request->getAttribute("fr")}&ID"));
		$this->page->assign("addaffiliate",$this->request->createURL("Admin","addaffiliate"));
		$this->page->assign("fetchaffiliates",$this->request->createURL("Admin","fetchaffiliates"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("searchclients",$this->request->createURL("Admin","searchclients"));
		$res=$this->adminFacade->editaffiliates($_POST);
		if($res['result'])
		{
			$this->request->setAttribute("message-succ", $res['message']);
			$this->editaffiliate();
		}
		else
		{
			$this->request->setAttribute("message", $res['message']);
			$this->editaffiliate();
		}
	}

	/**
	*@desc This function is used for deleting the affiliates.
	*/		
	public function deleteaffiliate()
	{
		$do 					= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 				= (!empty($_GET['action']))?$_GET['action']:NULL;

		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$this->page->assign("editaffiliate",$this->request->createURL("Admin","editaffiliate","ID"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->assign("deleteaffiliate",$this->request->createURL("Admin","deleteaffiliate","fr={$this->request->getAttribute("fr")}&name={$this->request->getAttribute("name")}&user={$this->request->getAttribute("user")}&ID"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("addaffiliate",$this->request->createURL("Admin","addaffiliate"));
		$this->page->assign("fetchaffiliates",$this->request->createURL("Admin","fetchaffiliates"));
		$this->page->assign("searchclients",$this->request->createURL("Admin","searchclients"));
		$res=$this->adminFacade->deleteaffiliate($_GET);
		if($res['result'])
		{
			$this->request->setAttribute("message-succ", $res['message']);
			if($this->request->getAttribute("name")!='' || $this->request->getAttribute("user")!='')
			{
				$res			= $this->adminFacade->searchclients_affiliates($_GET,$this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"));
				$this->page->assign("values",$res['search']);
				$this->page->assign("paging",$res['paging']);
				$this->page->getPage("admin_affiliate_list.tpl");
			}
			else{
				$result			=$this->adminFacade->fetchaffiliates($this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"));
				$this->page->assign("values",$result['search']);
				$this->page->assign("paging",$result['paging']);
				$this->page->getPage("admin_affiliate_list.tpl");
			}

		}
		else{
			$this->request->setAttribute("message", $res['message']);
			$this->fetchaffiliates();
		}
	}


	/**
	*@desc This function is used for displaying the details page for entering the clients search value.
	*/		
	public function searchclients()
	{
		$this->page->pageTitle 	= "Search Clients or Affiliates";
		$do 					= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 				= (!empty($_GET['action']))?$_GET['action']:NULL;

		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$this->page->assign("action",$this->request->createURL("Admin","searchclients_affiliates"));
		$this->page->assign("addaffiliate",$this->request->createURL("Admin","addaffiliate"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->assign("searchclients",$this->request->createURL("Admin","searchclients"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("fetchaffiliates",$this->request->createURL("Admin","fetchaffiliates"));
		$this->page->getPage("searchclients_affiliates.tpl");
	}

	/**
	*@desc This function is used for searching the affiliates.
	*/	
	public function searchclients_affiliates()
	{
		$this->page->pageTitle 	= "Search Clients or Affiliates";
		$do 				= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 			= (!empty($_GET['action']))?$_GET['action']:NULL;

		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$this->page->assign("searchclients",$this->request->createURL("Admin","searchclients"));
		$this->page->assign("addaffiliate",$this->request->createURL("Admin","addaffiliate"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->assign("editclients",$this->request->createURL("Admin","editclients","ID"));
		$this->page->assign("deleteclients",$this->request->createURL("Admin","deleteclients","fr={$this->request->getAttribute("fr")}&name={$this->request->getAttribute("name")}&user={$this->request->getAttribute("user")}&ID"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("addaffiliate",$this->request->createURL("Admin","addaffiliate"));
		$this->page->assign("fetchaffiliates",$this->request->createURL("Admin","fetchaffiliates"));
		$this->page->assign("searchclients",$this->request->createURL("Admin","searchclients"));
		$this->page->assign("editaffiliate",$this->request->createURL("Admin","editaffiliate","ID"));
		$this->page->assign("deleteaffiliate",$this->request->createURL("Admin","deleteaffiliate","fr={$this->request->getAttribute("fr")}&name={$this->request->getAttribute("name")}&user={$this->request->getAttribute("user")}&ID"));
		$this->page->assign("addaffiliate",$this->request->createURL("Admin","addaffiliate"));
		$this->page->assign("fetchaffiliates",$this->request->createURL("Admin","fetchaffiliates"));

		$res					= $this->adminFacade->searchclients_affiliates($_GET,$this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"));

		if(count($res['search'])==0)
		{
			$retArray = array("result"=>false, "message"=>'No records found!');
			$this->request->setAttribute("message", $retArray['message']);
			$this->searchclients();
		}else{
			$this->page->assign("values",$res['search']);
			$this->page->assign("paging",$res['paging']);
			$this->page->getPage("admin_client_manager.tpl");
			/*if($_GET['user']=='clients')
			{
			$this->page->getPage("admin_client_manager.tpl");
			}
			elseif($_GET['user']=='affiliates')
			{
			$this->page->getPage("admin_affiliate_list.tpl");
			}*/
		}

	}


	/**
	*@desc This function is used for deleting the client.
	*/	
	public function deleteclients()
	{
		$do 				= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 			= (!empty($_GET['action']))?$_GET['action']:NULL;

		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$this->page->assign("editclients",$this->request->createURL("Admin","editclients","ID"));
		$this->page->assign("searchclients",$this->request->createURL("Admin","searchclients"));
		$this->page->assign("deleteclients",$this->request->createURL("Admin","deleteclients","fr={$this->request->getAttribute("fr")}&name={$this->request->getAttribute("name")}&user={$this->request->getAttribute("user")}&ID"));
		$this->page->assign("fetchaffiliates",$this->request->createURL("Admin","fetchaffiliates"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$res					= $this->adminFacade->deleteclients($_GET);
		if($res['result'])
		{
			$this->request->setAttribute("message-succ", $res['message']);
			if($this->request->getAttribute("name")!='' || $this->request->getAttribute("user")!='')
			{
				$res			= $this->adminFacade->searchclients_affiliates($_GET,$this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"));
				$this->page->assign("values",$res['search']);
				$this->page->assign("paging",$res['paging']);
				$this->page->getPage("admin_client_manager.tpl");
			}
			else{
				$result					= $this->adminFacade->clientManager($this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"));
				$this->page->assign("values",$result['search']);
				$this->page->assign("paging",$result['paging']);
				$this->page->getPage("admin_client_manager.tpl");
			}
		}
		else{
			$this->request->setAttribute("message", $res['message']);
			$this->clientManager();
		}
	}


	/**
	*@desc This function is used for displaying the detail page for the clients data.
	*/	
	public function editclients()
	{
		$this->page->pageTitle 		= "Edit client profile";
		$do 						= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 					= (!empty($_GET['action']))?$_GET['action']:NULL;

		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$res=$this->adminFacade->fetcheditdetails();
		$this->page->assign("values1",$res);
		$this->page->assign("action",$this->request->createURL("Admin","editclients_edit","ID"));
		$this->page->assign("editclients",$this->request->createURL("Admin","editclients","ID"));
		$this->page->assign("searchclients",$this->request->createURL("Admin","searchclients"));
		$this->page->assign("deleteclients",$this->request->createURL("Admin","deleteclients","fr={$this->request->getAttribute("fr")}&name={$this->request->getAttribute("name")}&user={$this->request->getAttribute("user")}&ID"));
		$this->page->assign("fetchaffiliates",$this->request->createURL("Admin","fetchaffiliates"));
		$this->page->assign("addaffiliate",$this->request->createURL("Admin","addaffiliate"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->assign("back",$this->request->createURL("Admin", "clientManager"));
		$this->page->getPage("editclients.tpl");
	}

	/**
	*@desc This function is used for editing the clients details.
	*/	
	public function editclients_edit()
	{
		$do 				= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 			= (!empty($_GET['action']))?$_GET['action']:NULL;

		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$this->page->assign("editclients",$this->request->createURL("Admin","editclients","ID"));
		$this->page->assign("addaffiliate",$this->request->createURL("Admin","addaffiliate"));
		$this->page->assign("searchclients",$this->request->createURL("Admin","searchclients"));
		$this->page->assign("deleteclients",$this->request->createURL("Admin","deleteclients","fr={$this->request->getAttribute("fr")}&name={$this->request->getAttribute("name")}&user={$this->request->getAttribute("user")}&ID"));
		$this->page->assign("fetchaffiliates",$this->request->createURL("Admin","fetchaffiliates"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("back",$this->request->createURL("Admin", "clientManager"));
		$res					= $this->adminFacade->editclients($_POST);
		if($res['result'])
		{
			$this->request->setAttribute("message-succ", $res['message']);
			$this->editclients();
		}
		else
		{
			$this->request->setAttribute("message", $res['message']);
			$this->editclients();
		}
	}

	public function search_within_a_locality_count()
	{
		$this->page->pageTitle 	= "Searches within a specific locality";
		$do 					= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 				= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("action",$action);

		$monthArray = array (1=>"January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

		$valMonth="";
		foreach ($monthArray as $key => $val)
		{
			if(isset($_GET['FMonth']) && $key==$_GET['FMonth'])
			{
				$selMonth  ='selected="selected"';
				$valMonth.='<option value="'.$key.'" '.$selMonth.'>'.$val.'</option>';
			}else
			{
				$selMonth  ='';
				$valMonth.='<option value="'.$key.'" '.$selMonth.'>'.$val.'</option>';
			}
		}
		$this->page->assign("Month",$valMonth);


		$valDate ="";
		for($i=1;$i<=31;$i++)
		{
			if(isset($_GET['FDate']) && $i==$_GET['FDate'])
			{
				$selDate ='selected="selected"';
				$valDate.='<option value="'.$i.'" '.$selDate.'>'.$i.'</option>';
			}else
			{
				$selDate ='';
				$valDate.='<option value="'.$i.'" '.$selDate.'>'.$i.'</option>';
			}
		}
		$this->page->assign("Date",$valDate);

		$valYear ="";
		for($y=2007;$y<=2020;$y++)
		{
			if(isset($_GET['FYear']) && $y==$_GET['FYear'])
			{
				$selYear ='selected="selected"';
				$valYear.='<option value="'.$y.'" '.$selYear.'>'.$y.'</option>';
			}else
			{
				$selYear ='';
				$valYear.='<option value="'.$y.'" '.$selYear.'>'.$y.'</option>';
			}
		}
		$this->page->assign("Year",$valYear);

		$valToMonth="";
		foreach ($monthArray as $key => $val)
		{
			if(isset($_GET['ToMonth']) && $key==$_GET['ToMonth'])
			{
				$selToMonth  ='selected="selected"';
				$valToMonth.='<option value="'.$key.'" '.$selToMonth.'>'.$val.'</option>';
			}else
			{
				$selToMonth  ='';
				$valToMonth.='<option value="'.$key.'" '.$selToMonth.'>'.$val.'</option>';
			}
		}
		$this->page->assign("ToMonth",$valToMonth);

		$valToDate ="";
		for($i=1;$i<=31;$i++)
		{
			if(isset($_GET['ToDate']) && $i==$_GET['ToDate'])
			{
				$selToDate ='selected="selected"';
				$valToDate.='<option value="'.$i.'" '.$selToDate.'>'.$i.'</option>';
			}else
			{
				$selToDate ='';
				$valToDate.='<option value="'.$i.'" '.$selToDate.'>'.$i.'</option>';
			}
		}
		$this->page->assign("ToDate",$valToDate);

		$valToYear ="";
		for($y=2007;$y<=2020;$y++)
		{
			if(isset($_GET['ToYear']) && $y==$_GET['ToYear'])
			{
				$selToYear ='selected="selected"';
				$valToYear.='<option value="'.$y.'" '.$selToYear.'>'.$y.'</option>';
			}else
			{
				$selToYear ='';
				$valToYear.='<option value="'.$y.'" '.$selToYear.'>'.$y.'</option>';
			}
		}
		$this->page->assign("ToYear",$valToYear);
		$this->page->assign("class_region_report",$this->request->createURL("Classification","regionReport"));
		$this->page->assign("count_listing",$this->request->createURL("Admin","count_listing"));
		$this->page->assign("pagePopularityReport",$this->request->createURL("Admin","pagePopularityReport"));
		$this->page->assign("sitePerformanceReport",$this->request->createURL("Admin","sitePerformanceReport"));
		$this->page->assign("rankReport",$this->request->createURL("Admin","rankReport"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("BusinessManager_url",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("viewList",$this->request->createURL("SalesAccountManager", "viewList"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("classificationStats",$this->request->createURL("Admin","classificationStats"));
		$this->page->assign("keyword",$this->request->createURL("Classification","viewKeyword"));
		$this->page->assign("view",$this->request->createURL("Key", "viewList"));
		$this->page->assign("bannerManager",$this->request->createURL("BannerManager","viewListing"));
		$this->page->assign("viewLocation",$this->request->createURL("Location","viewLocation"));
		$this->page->assign("viewPage",$this->request->createURL("Content","viewPage"));
		$this->page->assign("viewVertical",$this->request->createURL("Vertical","viewVertical"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement"));
		$this->page->assign("fetchUniqueClients",$this->request->createURL("Admin","fetchUniqueClients"));
		$this->page->assign("clients_in_specific_locality",$this->request->createURL("Admin","search_locality_based_clients_form"));
		//$this->page->assign("clients_in_specific_locality",$this->request->createURL("Admin","clients_in_specific_locality"));
		$this->page->assign("failed_searches",$this->request->createURL("Admin","failed_searches"));
		$this->page->assign("clientManager",$this->request->createURL("Admin","clientManager"));
		$this->page->assign("addclient",$this->request->createURL("Admin","addclient"));
		$this->page->assign("search_within_a_locality_count",$this->request->createURL("Admin","search_within_a_locality_count"));
		$this->page->assign("action1",$_GET['action']);
		$result	= $this->adminFacade->search_within_a_locality_count($_GET,$this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"));

		$this->page->assign("count",count($result['search']));
		$this->page->assign("values2",$result['search']);
		$this->page->assign("paging",$result['paging']);
		$this->page->getPage("search_within_a_locality_count.tpl");
	}
}
/* END OF ADMINCONTROL */
?>