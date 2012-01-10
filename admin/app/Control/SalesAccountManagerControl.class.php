<?php

/**
   * @title   SalesAccountManagerControl.class.php    
   * @desc    This is an SalesAccountManagerControl class. The purpose of this class is to perform the redirection actions needed for any function/operation to AdminFacade class and also to smarty assign the URL's which were used in the templates as an action, which redirects or calls the particular function passed in the action parameter in the SalesAccountManagerControl class. 
*/

class SalesAccountManagerControl extends MainControl {
    
    private $userFacade;

    public function __construct($request) {
	
        parent::__construct($request);
        
        $this->SalesAccountManagerFacade = new SalesAccountManagerFacade($GLOBALS['conn']);
        $this->request = $request;
        $this->page = new AdminPage();
    }/* END __construct */


	/**
	*@desc  This is the function which is used for the addition of sales account manager.It will redirect to the same function with success message when addition was complete else it will retun error message.
	*/
	public function addition()
    {
        $resAdd = $this->SalesAccountManagerFacade->userAdd($_POST);
        if($resAdd['result'])
        {   $this->request->setAttribute("message-succ", $resAdd['message']);
		      $this->registrationAdd();
        }else{
            $this->request->setAttribute("message", $resAdd['message']);
            $this->registrationAdd();
        }
    }


	/**
	*@desc  This is the function which is used for the addition of sales account manager.It will pass the value to the finction in faceade and do the required validation process and return success on addition.
	*/	
	public function registrationAdd()
    {
		$this->page->pageTitle = "Employee Registration";
		$firstname		= (!empty($_POST['firstname']))?$_POST['firstname']:NULL;
		$surname		= (!empty($_POST['surname']))?$_POST['surname']:NULL;
		$username		= (!empty($_POST['username']))?$_POST['username']:NULL;
		$email			= (!empty($_POST['email']))?$_POST['email']:NULL;
		$address		= (!empty($_POST['address']))?$_POST['address']:NULL;
		$phone			= (!empty($_POST['phone']))?$_POST['phone']:NULL;
		$mobile			= (!empty($_POST['mobile']))?$_POST['mobile']:NULL;
		
		
		$this->page->assign("firstname",$firstname);
		$this->page->assign("surname",$surname);
		$this->page->assign("username",$username);
		$this->page->assign("email",$email);
		$this->page->assign("address",$address);
		$this->page->assign("phone",$phone);
		$this->page->assign("mobile",$mobile);
			
        $this->page->assign("login_url",$this->request->createURL("Admin", "login"));
        $this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
        $this->page->assign("action",$this->request->createURL("SalesAccountManager", "addition"));
        $this->page->assign("back",$this->request->createURL("SalesAccountManager", "adminManager"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists"));   
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("searchemployee",$this->request->createURL("SalesAccountManager","searchEmployee"));
		$this->page->assign("addemployee",$this->request->createURL("SalesAccountManager","registrationAdd"));
		$this->page->assign("cancel",$this->request->createURL("Admin", "showhomePageSalesManager"));
		$this->page->assign("changePassword",$this->request->createURL("SalesAccountManager","changePassword"));
        $this->page->getPage('registeremployee.tpl');
    }
	
	/**
	*@desc  This is the function which is used for diaplay of the details of sales account manager.
	*/	
	public function adminManager()
    {
        $this->page->assign("login_url",$this->request->createURL("Admin", "login"));
        $this->page->assign("reg_url",$this->request->createURL("SalesAccountManager", "registrationAdd"));
        $this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "edituser","ID"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists"));   
        $this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("delete",$this->request->createURL("SalesAccountManager", "deleteuser","ID"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("searchemployee",$this->request->createURL("SalesAccountManager","searchEmployee"));
		$this->page->assign("addemployee",$this->request->createURL("SalesAccountManager","registrationAdd"));
		$this->page->assign("changePassword",$this->request->createURL("SalesAccountManager","changePassword"));
        $res2 = $this->SalesAccountManagerFacade->fetchUserDetails();
        $this->page->assign("values",$res2);
        $this->page->getPage('teammanager.tpl');
    }
	
	/**
	*@desc  This is the function which is used for diaplay of the details of sales account manager.
	*/		
	public function showhomePage()
    {
        $this->page->assign("login_url",$this->request->createURL("Admin", "login"));
        $this->page->assign("back",$this->request->createURL("SalesAccountManager", "adminManager"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists"));   
		$this->page->assign("reg_url",$this->request->createURL("SalesAccountManager", "registrationAdd"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "edituser","ID"));
		$this->page->assign("delete",$this->request->createURL("SalesAccountManager", "deleteuser","ID"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("searchemployee",$this->request->createURL("SalesAccountManager","searchEmployee"));
		$this->page->assign("addemployee",$this->request->createURL("SalesAccountManager","registrationAdd"));
		$this->page->assign("changePassword",$this->request->createURL("SalesAccountManager","changePassword"));
		$res2 = $this->SalesAccountManagerFacade->fetchUserDetails();
        $this->page->assign("values",$res2);
        $this->page->getPage("teammanager.tpl");
    }


	/**
	*@desc  This is the function is used for editing the details of user.
	*/	
	public function edituser()
    {
        $this->page->assign("login_url",$this->request->createURL("Admin", "login"));
        $this->page->assign("action",$this->request->createURL("SalesAccountManager", "editAdditionuser","ID"));
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "edituser","ID")); 
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists"));   
		$this->page->assign("delete",$this->request->createURL("SalesAccountManager", "deleteuser","ID"));
        $this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
        $this->page->assign("back",$this->request->createURL("SalesAccountManager", "adminManager"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("searchemployee",$this->request->createURL("SalesAccountManager","searchEmployee"));
		$this->page->assign("addemployee",$this->request->createURL("SalesAccountManager","registrationAdd"));
		$this->page->assign("changePassword",$this->request->createURL("SalesAccountManager","changePassword"));
		$this->page->assign("cancel",$this->request->createURL("Admin", "showhomePageSalesManager"));
		
		$this->page->assign("edit_url", "javascript:window.location='".$this->request->createURL("SalesAccountManager", "edituser",                            "name={$this->request->getAttribute('name')}&state={$this->request->getAttribute('state')}"));
		
		
		$this->page->assign("delete","javascript:window.location='".$this->request->createURL("SalesAccountManager", "deleteuser",                            "name={$this->request->getAttribute('name')}&state={$this->request->getAttribute('state')}&ID"));

        $res3 = $this->SalesAccountManagerFacade->editUser();
        $this->page->assign("values1",$res3);
        $this->page->getPage('edituser.tpl');
    }


	/**
	*@desc  This is the function is used for adding the details of user and it will return success message when all the records after validation is correct and return error message when validation fails.
	*/	
	public function editAdditionuser()
    {
        $this->page->assign("login_url",$this->request->createURL("Admin", "login"));
        $this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "edituser","ID")); 
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists"));   
		$this->page->assign("delete",$this->request->createURL("SalesAccountManager", "deleteuser","ID"));
        $this->page->assign("back",$this->request->createURL("SalesAccountManager", "adminManager"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("searchemployee",$this->request->createURL("SalesAccountManager","searchEmployee"));
		$this->page->assign("addemployee",$this->request->createURL("SalesAccountManager","registrationAdd"));
		$this->page->assign("changePassword",$this->request->createURL("SalesAccountManager","changePassword"));
		$this->page->assign("edit_url", "javascript:window.location='".$this->request->createURL("SalesAccountManager", "edituser",                            "name={$this->request->getAttribute('name')}&state={$this->request->getAttribute('state')}"));
		$this->page->assign("delete","javascript:window.location='".$this->request->createURL("SalesAccountManager", "deleteuser",                            "name={$this->request->getAttribute('name')}&state={$this->request->getAttribute('state')}&ID"));
		$result		=$this->SalesAccountManagerFacade->editAdd($_POST);
		if($result['result'])
		{
        
		$this->request->setAttribute("message-succ", $result['message']);
		$this->edituser();
		}else{
		$this->request->setAttribute("message", $result['message']);
		$this->edituser();
		}
       
    }


	/**
	*@desc  This is the function is used for changing the passoword of the user.And return success message on successfull passord change and return error when old password is not correct.
	*/	
    public function changePassword()
    {
	    $this->page->pageTitle = "Password change";
		$this->page->assign("action",$this->request->createURL("SalesAccountManager", "changedPassword"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists"));   
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("home",$this->request->createURL("SalesAccountManager", "showhomePageAffiliate"));
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "edit"));
		$this->page->assign("change_password",$this->request->createURL("SalesAccountManager", "changePassword"));		
		$this->page->getPage('change_password.tpl');
	}


	/**
	*@desc  This is the function is used for changing the passoword of the user.And return success message on successfull passord change and return error when old password is not correct.
	*/	
	 public function changedPassword()
    {
	
		$oldPassword		= (!empty($_POST['oldPassword']))?$_POST['oldPassword']:NULL;
		$this->page->assign("oldPassword",$oldPassword);
		$this->page->assign("home",$this->request->createURL("Affiliate", "showhomePageAffiliate"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists"));   
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "edit"));
		$this->page->assign("change_password",$this->request->createURL("SalesAccountManager", "changePassword"));
		$resultArray = $this->SalesAccountManagerFacade->changePassword($_POST);
		if($resultArray['result'])
		{		
			$this->request->setAttribute("message-succ", $resultArray['message']);
			$this->changePassword();
		}else{
			$this->request->setAttribute("message", $resultArray['message']);
			$this->changePassword();			
		}
    }
	
	
	/** deleteuser()	
	*@desc This function is the delete function the purpose of this function is to change the status of the user from           Active to Inactive. This function calls the changeStatus() function of AdminFacade class.
	*/
    public function deleteuser()
    {
        $this->page->assign("login_url",$this->request->createURL("Admin", "login"));
        $this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("delete",$this->request->createURL("SalesAccountManager", "deleteuser","ID"));
        $this->page->assign("back",$this->request->createURL("SalesAccountManager", "adminManager"));
		$this->page->assign("searchemployee",$this->request->createURL("SalesAccountManager","searchEmployee"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists"));   
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("addemployee",$this->request->createURL("SalesAccountManager","registrationAdd"));
		$this->page->assign("changePassword",$this->request->createURL("SalesAccountManager","changePassword"));
		$this->page->assign("edit_url", "javascript:window.location='".$this->request->createURL("SalesAccountManager", "edituser",                            "name={$this->request->getAttribute('name')}&state={$this->request->getAttribute('state')}&ID"));
					
		$this->page->assign("delete",$this->request->createURL("SalesAccountManager", "deleteuser","name={$this->request->                             getAttribute('name')}&ID"));
        $val=$this->SalesAccountManagerFacade->changeStatus();
		$res4=$this->SalesAccountManagerFacade->searchEmployee($this->request->getAttribute("fr"), $this->request->getAttribute(                                                               "pg_size"),$_GET);
     	
        $this->page->assign("values",$res4['user']);
		$this->page->assign("paging",$res4['paging']);
        $this->page->getPage('teammanager.tpl');
    }
					

	/**
	*@desc  This is the function is used for searching the employee and return the result or retrn no recods if no rocords found in the data base.
	*/	
	public function searchEmployee()
   	{
    $this->page->pageTitle = "Search Employee";
	$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
	$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));  
	$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "edituser","ID")); 
	$this->page->assign("delete",$this->request->createURL("SalesAccountManager", "deleteuser","ID"));
	$this->page->assign("viewlisting",$this->request->createURL("SalesAccountManager", "viewList"));
	$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists"));   
	$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
	$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
	$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
	$this->page->assign("action",$this->request->createURL("SalesAccountManager","searchEmployees"));
	$this->page->assign("addemployee",$this->request->createURL("SalesAccountManager","registrationAdd"));
	$this->page->assign("searchemployee",$this->request->createURL("SalesAccountManager","searchEmployee"));
	$this->page->assign("changePassword",$this->request->createURL("SalesAccountManager","changePassword"));
	$this->page->assign("edit_url", "javascript:window.location='".$this->request->createURL("SalesAccountManager", "edituser",                            "name={$this->request->getAttribute('name')}&state={$this->request->getAttribute('state')}"));
	$this->page->assign("delete","javascript:window.location='".$this->request->createURL("SalesAccountManager", "deleteuser",                            "name={$this->request->getAttribute('name')}&state={$this->request->getAttribute('state')}&ID"));
	$this->page->getPage("searchemployee.tpl");
   }
   
   
	/**
	*@desc  This is the function is used for searching the employee and return the result or retrn no recods if no rocords found in the data base.
	*/   
   public function searchEmployees()
   {
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));  
		$this->page->assign("delete",$this->request->createURL("SalesAccountManager", "deleteuser","name={$this->request->                             getAttribute('name')}&ID"));
		$this->page->assign("viewlisting",$this->request->createURL("SalesAccountManager", "viewList"));
		$this->page->assign("addemployee",$this->request->createURL("SalesAccountManager","registrationAdd"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists"));   
		$this->page->assign("searchemployee",$this->request->createURL("SalesAccountManager","searchEmployee"));
		$this->page->assign("changePassword",$this->request->createURL("SalesAccountManager","changePassword"));
		$this->page->assign("edit_url", "javascript:window.location='".$this->request->createURL("SalesAccountManager", "edituser","name={$this->request->getAttribute('name')}&ID"));
		$retArr=$this->SalesAccountManagerFacade->validatesearch($_GET);

		if($retArr['result'])
		{
		$rec=$this->SalesAccountManagerFacade->searchEmployee($this->request->getAttribute("fr"), $this->request->getAttribute(                                                              "pg_size"),$_GET);
		$this->page->assign("values",$rec['user']);
		$this->page->assign("paging",$rec['paging']);		
		$this->page->getpage('teammanager.tpl');
		}
		else
		{
		    $this->request->setAttribute("message", $retArr['message']);
		 $this->searchEmployee();		
		}		
   }

/***********************************************END OF EMPLOYEE ADD/EDIT/DELETE/SEARCH************************************/




/**********************************************BUSINESS ADD/EDIT/DELETE/SEARCH*******************************************/


	/**
	*@desc  This is the function is used for adding the business listing. It will display the listing addition page, and takes the listing details.
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

		$this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("viewList",$this->request->createURL("SalesAccountManager","viewList"));           
		 $this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("action",$this->request->createURL("SalesAccountManager", "listingAddition"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("back",$this->request->createURL("Admin", "showhomePageEmployee"));
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit","ID"));
		$this->page->assign("delete",$this->request->createURL("SalesAccountManager", "delete","ID")); 
		$this->page->assign("edit",$this->request->createURL("SalesAccountManager", "editUser","ID"));
		$this->page->assign("searchemployee",$this->request->createURL("SalesAccountManager","searchEmployee"));
		$this->page->assign("addemployee",$this->request->createURL("SalesAccountManager","registrationAdd"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing", "addListing"));
        $this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists"));   
		$this->page->assign("changePassword",$this->request->createURL("SalesAccountManager","changePassword"));
		
		$brandResult=$this->SalesAccountManagerFacade->fetchBrands();
		$this->page->assign("brandResult",$brandResult);

		$res1=$this->SalesAccountManagerFacade->fetchClassificationDetails();
		$this->page->assign("values1",$res1);
		
		$regionValue=$this->SalesAccountManagerFacade->fetchRegion();
		$this->page->assign("regionValue",$regionValue);
		
		$res=$this->SalesAccountManagerFacade->fetchTownDetails();
		$this->page->assign("values",$res);
		
		$res2=$this->SalesAccountManagerFacade->selectStates();
		$this->page->assign("values2",$res2);
		
		$res3=$this->SalesAccountManagerFacade->fetchRank();
		$this->page->assign("rank",$res3[0]['rank']);
		
		$rankList=$this->SalesAccountManagerFacade->fetchRankRate();
		$this->page->assign("rankList",$rankList);
		
		$this->page->getPage('listingadd.tpl');
	}
	
	
	/**
	*@desc  This is the function is used for adding the details of business listing.
	*/	
	public function listingAddition()
   	{
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));  
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("viewList",$this->request->createURL("SalesAccountManager","viewList"));           
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists"));   
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit","ID")); 
		$this->page->assign("delete",$this->request->createURL("SalesAccountManager", "delete","ID"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("edit",$this->request->createURL("SalesAccountManager", "editUser","ID"));
		$this->page->assign("changePassword",$this->request->createURL("SalesAccountManager","changePassword"));
		$this->page->assign("searchemployee",$this->request->createURL("SalesAccountManager","searchEmployee"));
		$this->page->assign("addemployee",$this->request->createURL("SalesAccountManager","registrationAdd"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing", "addListing"));
        $this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
				
		//Add Business Logo		
	    $image=$_FILES['logo']['name'];
		$tmp=$_FILES['logo']['tmp_name'];
				
		move_uploaded_file($tmp,"View/Default/Images/client_image/$image");
		
		//Add Business Image
		$image2=$_FILES['image']['name'];
		$tmp=$_FILES['image']['tmp_name'];
				
		move_uploaded_file($tmp,"View/Default/Images/client_image/$image2");		
		$res=$this->SalesAccountManagerFacade->addlist1($_POST,$_FILES);
		
		if($res['result']==0)
		{
			$this->request->setAttribute("message", $res['message']);
			$this->addListing();		
		}else{
			$this->request->setAttribute("message-succ", $res['message']);
			$this->request->redirect("SalesAccountManager","addClassification","ID={$res['InsertID']}&msg=1");			
		}						
	}
	
	
	/**
	*@desc  This is the function is used for displaying the form for adding the classification.
	*/	
	public function addClassification()
	{
		$this->page->pageTitle 		= "Add Classification";
		$this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
		$msg 						= (!empty($_GET['msg']))?$_GET['msg']:NULL;
		$this->page->assign("msg",$msg);
		$res3		=array();		
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("viewList",$this->request->createURL("SalesAccountManager","viewList"));
		$this->page->assign("add_keyword",$this->request->createURL("SalesAccountManager", "add_keyword"));	
		$this->page->assign("manageHoursDays",$this->request->createURL("SalesAccountManager", "manageHoursDays"));
		
		$res3=$this->SalesAccountManagerFacade->editListingFetchDetails();
        $this->page->assign("values12",@$res3[0]);
		
		$classificationListResult	=$this->SalesAccountManagerFacade->classificationList($_GET);
		$classificationList			=$this->SalesAccountManagerFacade->fetchClassificationDetails();
		$result 					= array_diff_assoc($classificationList, $classificationListResult);
		$this->page->assign("classificationList",$result);
		$this->page->assign("classificationListResult",$classificationListResult);
		$this->page->assign("action",$this->request->createURL("SalesAccountManager", "addClassificationDetail","ID"));
		$this->page->assign("deleteAction",$this->request->createURL("SalesAccountManager", "deleteClassification","ID"));
		$this->page->assign("businessRank",$this->request->createURL("SalesAccountManager", "rankBusiness","ID"));		
		//$hiddenClassList		=serialize($classificationListResult);
		//		$this->page->assign("hiddenClassList",$hiddenClassList);		
		$this->page->getPage('add_classification.tpl');
	}
		
		
	/**
	*@desc  This is the function is used for displaying the form for adding the keyword.
	*/		
	public function add_keyword()
	{
		$this->page->pageTitle 			= "Add Brand and Services";
		$msg 							= (!empty($_GET['msg']))?$_GET['msg']:NULL;
		$this->page->assign("msg",$msg);
		$this->page->assign("action",$this->request->createURL("SalesAccountManager", "add_new_keyword","ID"));
		$this->page->assign("deleteAction",$this->request->createURL("SalesAccountManager", "deleteKeyword","ID"));
		$this->page->assign("add_keyword",$this->request->createURL("SalesAccountManager", "add_keyword"));	
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("viewList",$this->request->createURL("SalesAccountManager","viewList"));
		$this->page->assign("add_keyword",$this->request->createURL("SalesAccountManager", "add_keyword"));	
		$this->page->assign("manageHoursDays",$this->request->createURL("SalesAccountManager", "manageHoursDays"));
		$this->page->assign("actionService",$this->request->createURL("SalesAccountManager", "add_new_service","ID"));
		$this->page->assign("actionBrand",$this->request->createURL("SalesAccountManager", "add_new_brand","ID"));
		$this->page->assign("deleteServiceAction",$this->request->createURL("SalesAccountManager", "deleteService","ID"));
		$this->page->assign("deleteBrandAction",$this->request->createURL("SalesAccountManager", "deleteBrand","ID"));
		
		$keywordList=$this->SalesAccountManagerFacade->fetchKeyword();
		$this->page->assign("keywordList",$keywordList);
		
		$brandResult=$this->SalesAccountManagerFacade->fetchBrands();
		$this->page->assign("brandResult",$brandResult);
		
		$serviceResult=$this->SalesAccountManagerFacade->fetchService();
		$this->page->assign("serviceResult",$serviceResult);
		
		$keyResult=$this->SalesAccountManagerFacade->fetchBusinessKeyword($_GET);
		$this->page->assign("keyResult",$keyResult);
		
		$businessBrandResult=$this->SalesAccountManagerFacade->fetchBusinessBrand($_GET);
		$this->page->assign("businessBrandResult",$businessBrandResult);
		
		$businessServiceResult=$this->SalesAccountManagerFacade->fetchBusinessService($_GET);
		$this->page->assign("businessServiceResult",$businessServiceResult);
		
		$res3=$this->SalesAccountManagerFacade->editListingFetchDetails();
        $this->page->assign("values12",$res3[0]);			
		
		$this->page->getPage('add_new_keyword.tpl');
	}
		
		
	/**
	*@desc  This is the function is used for adding keyword to the data base and return true if validation is true and return error message on failure.
	*/		
	public function add_new_keyword()
	{		
		$msg 							= (!empty($_GET['msg']))?$_GET['msg']:NULL;
		$this->page->assign("msg",$msg);
		$this->page->assign("deleteAction",$this->request->createURL("SalesAccountManager", "deleteKeyword","ID"));
		$this->page->assign("add_keyword",$this->request->createURL("SalesAccountManager", "add_keyword"));	
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("viewList",$this->request->createURL("SalesAccountManager","viewList"));
		$this->page->assign("add_keyword",$this->request->createURL("SalesAccountManager", "add_keyword"));	
		$classificationAddResult	=$this->SalesAccountManagerFacade->add_new_keyword($_POST,$_GET);
		
			if($classificationAddResult['result'])
			{	
				$this->request->redirect("SalesAccountManager","add_keyword","ID={$classificationAddResult['ID']}&msg=2");
			}
		
		$this->page->getPage('add_new_keyword.tpl');	
		
		}
		
		
	/**
	*@desc  This is the function is used for adding new service.
	*/		
	public function add_new_service()
	{
		$msg 						= (!empty($_GET['msg']))?$_GET['msg']:NULL;
		$this->page->assign("msg",$msg);
		$this->page->assign("deleteAction",$this->request->createURL("SalesAccountManager", "deleteKeyword","ID"));
		$this->page->assign("add_keyword",$this->request->createURL("SalesAccountManager", "add_keyword"));	
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("viewList",$this->request->createURL("SalesAccountManager","viewList"));
		$this->page->assign("add_keyword",$this->request->createURL("SalesAccountManager", "add_keyword"));	
		
		$classificationAddResult	=$this->SalesAccountManagerFacade->add_new_service($_POST,$_GET);		
			if($classificationAddResult['result'])
			{	
				$this->request->redirect("SalesAccountManager","add_keyword","ID={$classificationAddResult['ID']}&msg=5");
			}
	
		$this->page->getPage('add_new_keyword.tpl');	
	}
		
		
	/**
	*@desc  This is the function is used for adding new brand.
	*/		
	public function add_new_brand()
	{
		$msg 							= (!empty($_GET['msg']))?$_GET['msg']:NULL;
		$this->page->assign("msg",$msg);
		$this->page->assign("deleteAction",$this->request->createURL("SalesAccountManager", "deleteKeyword","ID"));
		$this->page->assign("add_keyword",$this->request->createURL("SalesAccountManager", "add_keyword"));	
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("viewList",$this->request->createURL("SalesAccountManager","viewList"));
		$this->page->assign("add_keyword",$this->request->createURL("SalesAccountManager", "add_keyword"));	
		
		$classificationAddResult	= $this->SalesAccountManagerFacade->add_new_brand($_POST,$_GET);
		
			if($classificationAddResult['result'])
			{	
				$this->request->redirect("SalesAccountManager","add_keyword","ID={$classificationAddResult['ID']}&msg=7");
			}
		
		$this->page->getPage('add_new_keyword.tpl');
	}
		
		
	/**
	*@desc  This is the function is used for displaying the page for the details of classification.
	*/		
	public function addClassificationDetail()
	{
		$this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
		$msg 						= (!empty($_GET['msg']))?$_GET['msg']:NULL;
		$this->page->assign("msg",$msg);
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("viewList",$this->request->createURL("SalesAccountManager","viewList"));
		$this->page->assign("add_keyword",$this->request->createURL("SalesAccountManager", "add_keyword"));	
		$classificationList			= $this->SalesAccountManagerFacade->fetchClassificationDetails();
		$classificationListResult	= $this->SalesAccountManagerFacade->classificationList($_GET);
	
		$result 					= array_diff_assoc($classificationList, $classificationListResult);
		
		$this->page->assign("classificationList",$result);
		
		$classificationAddResult	= $this->SalesAccountManagerFacade->addClassificationDetail($_POST,$_GET);
		
			if($classificationAddResult['result'])
			{	
				$this->request->redirect("SalesAccountManager","addClassification","ID={$classificationAddResult['ID']}&msg=2");
			}
		
		$this->page->getPage('add_classification.tpl');		
		}
		
		
	/**
	*@desc  This is the function is used for deleting the classification.
	*/		
	public function deleteClassification()
	{
		$this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
		$msg 							= (!empty($_GET['msg']))?$_GET['msg']:NULL;
		$this->page->assign("msg",$msg);
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("viewList",$this->request->createURL("SalesAccountManager","viewList"));
		$this->page->assign("add_keyword",$this->request->createURL("SalesAccountManager", "add_keyword"));	
		$classificationDelResult		= $this->SalesAccountManagerFacade->deleteClassification($_POST,$_GET);
		
			if($classificationDelResult['result'])
			{	
				$this->request->redirect("SalesAccountManager","addClassification","ID={$classificationDelResult['ID']}&msg=3");
			}
			else
			{
				$this->request->setAttribute("message", $classificationDelResult['message']);
				$this->addClassification();		
			}
		
		}
		
		
	/**
	*@desc  This is the function is used for deleting the keyword.
	*/		
	public function deleteKeyword()
	{	
		$msg 						= (!empty($_GET['msg']))?$_GET['msg']:NULL;
		$this->page->assign("msg",$msg);
		$this->page->assign("add_keyword",$this->request->createURL("SalesAccountManager", "add_keyword"));	
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("viewList",$this->request->createURL("SalesAccountManager","viewList"));
		$this->page->assign("add_keyword",$this->request->createURL("SalesAccountManager", "add_keyword"));	
	
		$classificationDelResult	=$this->SalesAccountManagerFacade->deleteKeyword($_POST,$_GET);
			
		if($classificationDelResult['result'])
		{	
			$this->request->redirect("SalesAccountManager","add_keyword","ID={$classificationDelResult['ID']}&msg=3");
		}else{
			$this->request->setAttribute("message", $classificationDelResult['message']);
			$this->add_keyword();		
		}
	}
		
		
	/**
	*@desc  This is the function is used for deleting the brand.
	*/		
	public function deleteBrand()
	{	
		$msg 							= (!empty($_GET['msg']))?$_GET['msg']:NULL;
		$this->page->assign("msg",$msg);
		$this->page->assign("add_keyword",$this->request->createURL("SalesAccountManager", "add_keyword"));	
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("viewList",$this->request->createURL("SalesAccountManager","viewList"));
		$this->page->assign("add_keyword",$this->request->createURL("SalesAccountManager", "add_keyword"));	
	
		$classificationDelResult		= $this->SalesAccountManagerFacade->deleteBrand($_POST,$_GET);
		
	
		if($classificationDelResult['result'])
		{	
			$this->request->redirect("SalesAccountManager","add_keyword","ID={$classificationDelResult['ID']}&msg=8");
		}else{
			$this->request->setAttribute("message", $classificationDelResult['message']);
			$this->add_keyword();		
		}
	}
	
	/**
	*@desc  This is the function is used for deleting the hour.
	*/	
	public function deleteHour()
	{	
		$msg 							= (!empty($_GET['msg']))?$_GET['msg']:NULL;
		$this->page->assign("msg",$msg);
		$this->page->assign("add_keyword",$this->request->createURL("SalesAccountManager", "add_keyword"));	
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("viewList",$this->request->createURL("SalesAccountManager","viewList"));
		$this->page->assign("add_keyword",$this->request->createURL("SalesAccountManager", "add_keyword"));	
	
		$classificationDelResult		= $this->SalesAccountManagerFacade->deleteHour($_POST,$_GET);	
		if($classificationDelResult['result'])
		{	
			$this->request->redirect("SalesAccountManager","manageHoursDays","ID={$classificationDelResult['ID']}&msg=3");
		}else{
			$this->request->setAttribute("message", $classificationDelResult['message']);
			$this->manageHoursDays();		
		}
	}
		
		
		
	/**
	*@desc  This is the function is used for deleting the payment.
	*/		
	public function deletePayment()
	{
		$msg 						= (!empty($_GET['msg']))?$_GET['msg']:NULL;
		$this->page->assign("msg",$msg);
		$this->page->assign("add_keyword",$this->request->createURL("SalesAccountManager", "add_keyword"));	
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("viewList",$this->request->createURL("SalesAccountManager","viewList"));
		$this->page->assign("add_keyword",$this->request->createURL("SalesAccountManager", "add_keyword"));	
	
		$classificationDelResult	= $this->SalesAccountManagerFacade->deletePayment($_POST,$_GET);	
		if($classificationDelResult['result'])
		{	
			$this->request->redirect("SalesAccountManager","manageHoursDays","ID={$classificationDelResult['ID']}&msg=4");
		}else{
			$this->request->setAttribute("message", $classificationDelResult['message']);
			$this->manageHoursDays();		
		}
	}
		
	/**
	*@desc  This is the function is used for deleting the service.
	*/		
		public function deleteService()
		{
			$msg 					= (!empty($_GET['msg']))?$_GET['msg']:NULL;
			$this->page->assign("msg",$msg);
			$this->page->assign("add_keyword",$this->request->createURL("SalesAccountManager", "add_keyword"));	
			$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
			$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit"));
			$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
			$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));
			$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
			$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
			$this->page->assign("viewList",$this->request->createURL("SalesAccountManager","viewList"));
			$this->page->assign("add_keyword",$this->request->createURL("SalesAccountManager", "add_keyword"));	
		
			$classificationDelResult	= $this->SalesAccountManagerFacade->deleteService($_POST,$_GET);
			
			if($classificationDelResult['result'])
			{	
				$this->request->redirect("SalesAccountManager","add_keyword","ID={$classificationDelResult['ID']}&msg=6");
			}else{
				$this->request->setAttribute("message", $classificationDelResult['message']);
				$this->add_keyword();		
			}
		}
		

	/**
	*@desc  This is the function is used displaying the rank of business.
	*/		
	public function rankBusiness()
	{
		$this->page->pageTitle 				= "Rank Business";
		$this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
		$msg 								= (!empty($_GET['msg']))?$_GET['msg']:NULL;
		$this->page->assign("msg",$msg);
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("viewList",$this->request->createURL("SalesAccountManager","viewList"));
		$this->page->assign("add_keyword",$this->request->createURL("SalesAccountManager", "add_keyword"));	
		$this->page->assign("manageHoursDays",$this->request->createURL("SalesAccountManager", "manageHoursDays"));
		$this->page->assign("add_card",$this->request->createURL("SalesAccountManager", "add_card","ID"));	
		$ranks = array(	'1'=>'1',
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
		
		$rankResult=$this->SalesAccountManagerFacade->rankDetails($_GET);
		$this->page->assign("rankResult",$rankResult);
		
		$res3=$this->SalesAccountManagerFacade->editListingFetchDetails();
        $this->page->assign("values12",$res3[0]);		
		
		$classificationListResult=$this->SalesAccountManagerFacade->classificationList($_GET);
		$array1 = array(
						array(
							"localclassification_id" => "", 
							"localclassification_name" => ""
							));
		$finalResult1=array_merge($array1,$classificationListResult);		
		
		$this->page->assign("countclassification",count($classificationListResult));

		$regionValue=$this->SalesAccountManagerFacade->fetchRegion();
		$array2 = array(array("shirename_id" => "", "shirename_shirename" => "", "shirename_state" => ""));
		$finalResult2=array_merge($array2,$regionValue);		
		$this->page->assign("regionValue",$finalResult2);
		$this->page->assign("action",$this->request->createURL("SalesAccountManager", "addRank","ID"));
		
/*			foreach ($finalResult1 as $key=>$val){
				
				if($val['localclassification_id']!=''){
					$bRankArr = $this->SalesAccountManagerFacade->selectByClassification($val['localclassification_id']);
					$finalResult1[$key]['oldRank'] = $bRankArr;
				}
			}*/
		$bRankArr = $this->SalesAccountManagerFacade->selectByClassification();	
		$this->page->assign("bRankArr",$bRankArr);
		$this->page->assign("classificationListResult",$finalResult1);
		
		$addword = $this->SalesAccountManagerFacade->fetchAddWord($_GET);
		
		$this->page->assign("addword1",@$addword[0]['adword_line1']);
		$this->page->assign("addword2",@$addword[0]['adword_line2']);		
		

		$this->page->getPage('add_business_rank.tpl');
	}
	
	
	/**
	*@desc  This is the function is used for adding the rank for the specefic business.
	*/		
	public function addRank()
	{
		$this->page->pageTitle 					= "Rank Business";
		$this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
		$msg 									= (!empty($_GET['msg']))?$_GET['msg']:NULL;
		$this->page->assign("msg",$msg);
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("viewList",$this->request->createURL("SalesAccountManager","viewList"));
		$this->page->assign("add_keyword",$this->request->createURL("SalesAccountManager", "add_keyword"));	
		$addRankResult	=$this->SalesAccountManagerFacade->addRank($_POST,$_GET);
		

			if($addRankResult['result'])
			{	
				$this->request->redirect("SalesAccountManager","rankBusiness","ID={$addRankResult['ID']}&msg=4");
			}else{
				$this->request->setAttribute("message", $addRankResult['message']);
				$this->rankBusiness();		
			}
	}
		
	
	
	public function showMidPage($ID)
	{ 
		$this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
		$this->page->assign("delete",$this->request->createURL("SalesAccountManager", "delete","ID"));
		$this->page->assign("updateAction",$this->request->createURL("SalesAccountManager", "updateAdd","ID={$ID}"));
		$this->page->getPage("listing_intermediate_page.tpl");	
	}
	
	public function updateAdd()
	{
	  $this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
	  $this->page->assign("delete",$this->request->createURL("SalesAccountManager", "delete","ID"));
	  $res=$this->SalesAccountManagerFacade->updateAdd($_POST);
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
	*@desc  This is the function is used for the view of business details.
	*/	
	public function viewList()
    {
		$this->page->pageTitle 					= "Listings";
		$this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("action",$this->request->createURL("SalesAccountManager", "listingAddition"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("back",$this->request->createURL("Admin", "showhomePageEmployee"));
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));
		$this->page->assign("delete",$this->request->createURL("SalesAccountManager", "delete","name={$this->request->getAttribute('name')}&state={$this->request->getAttribute('state')}&fr={$this->request->getAttribute("fr")}&ID"));
		$this->page->assign("edit",$this->request->createURL("SalesAccountManager", "editUser","ID"));
		$this->page->assign("searchemployee",$this->request->createURL("SalesAccountManager","searchEmployee"));
		$this->page->assign("addemployee",$this->request->createURL("SalesAccountManager","registrationAdd"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing", "addListing"));
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists"));   
		$this->page->assign("changePassword",$this->request->createURL("SalesAccountManager","changePassword"));
		$res1									= $this->SalesAccountManagerFacade->viewfetchDetails($this->request->getAttribute("fr"));
		$this->page->assign("values",$res1['listings']);
		$this->page->assign("paging", $res1['paging']);
		$this->page->getPage("listshow.tpl");
    }/* END viewList*/
	
		
	/**
	*@desc  This is the function is used for serching the details of business based on the search criteria.
	*/  
   public function searchBusiness()
   { 
        $this->page->pageTitle = "Search Business Listings";
        $this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
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
		$this->page->assign("action",$this->request->createURL("SalesAccountManager","searchBusinesses"));
		$this->page->assign("searchemployee",$this->request->createURL("SalesAccountManager","searchEmployee"));
		$this->page->assign("addemployee",$this->request->createURL("SalesAccountManager","registrationAdd"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing", "addListing"));
		$this->page->assign("changePassword",$this->request->createURL("SalesAccountManager","changePassword"));
        $this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->getPage("searchbusiness.tpl");
   }
  
  
	/**
	*@desc  This is the function is used for serching the details of business based on the search criteria.
	*/     
	public function searchBusinesses()
   	{    
        $this->page->pageTitle 					= "Search Business Listings";
        $this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));  
		$this->page->assign("viewList",$this->request->createURL("SalesAccountManager","viewList"));           
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists"));   
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));	
		$this->page->assign("view_history",$this->request->createURL("SalesAccountManager", "view_history","ID"));
		$this->page->assign("add_card",$this->request->createURL("SalesAccountManager", "add_card","ID"));	
		//$this->page->assign("edit_url", "javascript:window.location='".$this->request->createURL("SalesAccountManager", "Edit", "name={$this->request->getAttribute('name')}&state={$this->request->getAttribute('state')}"));
		//$this->page->assign("delete","javascript:window.location='".$this->request->createURL("SalesAccountManager", "delete", "name={$this->request->getAttribute('name')}&state={$this->request->getAttribute('state')}&ID"));
		$this->page->assign("delete",$this->request->createURL("SalesAccountManager", "delete","name={$this->request->getAttribute('name')}&state={$this->request->getAttribute('state')}&fr={$this->request->getAttribute("fr")}&ID"));
		$this->page->assign("searchemployee",$this->request->createURL("SalesAccountManager","searchEmployee"));
		$this->page->assign("addemployee",$this->request->createURL("SalesAccountManager","registrationAdd"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing", "addListing"));
        $this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("changePassword",$this->request->createURL("SalesAccountManager","changePassword"));
		$retArr=$this->SalesAccountManagerFacade->validatesearch1($_GET);
		if($retArr['result'])
		{
			$result = $this->SalesAccountManagerFacade->searchBusiness($_GET, $this->request->getAttribute("fr"));
			$this->page->assign("count",count($result['listings']));
			$this->page->assign("values",$result['listings']);
			$this->page->assign("paging", $result['paging']);
			$this->page->getpage('listshow.tpl');
		}
		else
		{
			$this->request->setAttribute("message", $retArr['message']);
			$this->searchBusiness();
		}
   }
   
   public function add_card()
   {
   		$name			= (!empty($_POST['name']))?$_POST['name']:NULL;
		$street1		= (!empty($_POST['street1']))?$_POST['street1']:NULL;
		$street2		= (!empty($_POST['street2']))?$_POST['street2']:NULL;
		$phonestd		= (!empty($_POST['phonestd']))?$_POST['phonestd']:NULL;
		$phone			= (!empty($_POST['phone']))?$_POST['phone']:NULL;
		$mobile			= (!empty($_POST['mobile']))?$_POST['mobile']:NULL;
		$faxstd			= (!empty($_POST['faxstd']))?$_POST['faxstd']:NULL;
		$fax			= (!empty($_POST['fax']))?$_POST['fax']:NULL;
		$email			= (!empty($_POST['email']))?$_POST['email']:NULL;
		$url			= (!empty($_POST['url']))?$_POST['url']:NULL;
		$text1			= (!empty($_POST['text1']))?$_POST['text1']:NULL;
		$text2			= (!empty($_POST['text2']))?$_POST['text2']:NULL;
		$text3			= (!empty($_POST['text3']))?$_POST['text3']:NULL;
		$text4			= (!empty($_POST['text4']))?$_POST['text4']:NULL;
		
		
		$this->page->assign("name",$name);
		$this->page->assign("street1",$street1);
		$this->page->assign("street2",$street2);
		$this->page->assign("phonestd",$phonestd);
		$this->page->assign("phone",$phone);
		$this->page->assign("mobile",$mobile);
		$this->page->assign("faxstd",$faxstd);
		$this->page->assign("fax",$fax);
		$this->page->assign("email",$email);
		$this->page->assign("url",$url);
		$this->page->assign("text1",$text1);
		$this->page->assign("text2",$text2);
		$this->page->assign("text3",$text3);
		$this->page->assign("text4",$text4);
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));  
		$this->page->assign("viewList",$this->request->createURL("SalesAccountManager","viewList"));           
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));	
		$this->page->assign("view_history",$this->request->createURL("SalesAccountManager", "view_history","ID"));
		$this->page->assign("add_card",$this->request->createURL("SalesAccountManager", "add_card","ID"));
		$this->page->assign("add_keyword",$this->request->createURL("SalesAccountManager", "add_keyword"));
		$this->page->assign("manageHoursDays",$this->request->createURL("SalesAccountManager", "manageHoursDays"));
		
		$this->page->assign("action",$this->request->createURL("SalesAccountManager", "add_card_details","ID"));
		$res3=$this->SalesAccountManagerFacade->editListingFetchDetails();
		$this->page->assign("values12",$res3[0]);
		
		
		$cardResult=$this->SalesAccountManagerFacade->card_details();
		if(count($cardResult) != '0')
		{
			$this->page->assign("cardResult",$cardResult[0]);
		}
		
		$this->page->getpage('add_card.tpl');
   }
   
   public function add_card_details()
   {
   		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));	
		$this->page->assign("view_history",$this->request->createURL("SalesAccountManager", "view_history","ID"));
		$this->page->assign("add_card",$this->request->createURL("SalesAccountManager", "add_card","ID"));
		$this->page->assign("add_keyword",$this->request->createURL("SalesAccountManager", "add_keyword"));	
		$this->page->assign("manageHoursDays",$this->request->createURL("SalesAccountManager", "manageHoursDays"));	
		$res						= $this->SalesAccountManagerFacade->edit_card_details($_POST,$_FILES);
		if($res['result'])
		{
			$this->request->setAttribute("message-succ", $res['message']);
			$this->add_card();
		}else{
			$this->request->setAttribute("message", $res['message']);
			$this->add_card();
		}
   }
   
   public function view_history()
   {
   		$this->page->pageTitle 					= "General Listing History";
   		$this->page->assign("view_history",$this->request->createURL("SalesAccountManager", "view_history"));
		$this->page->assign("view_classification_history",$this->request->createURL("SalesAccountManager", "view_classification_history"));
		$this->page->assign("view_rank_history",$this->request->createURL("SalesAccountManager", "view_rank_history"));
		$this->page->assign("view_key_history",$this->request->createURL("SalesAccountManager", "view_key_history"));
		$this->page->assign("view_operation_day_history",$this->request->createURL("SalesAccountManager", "view_operation_day_history"));
		$this->page->assign("view_operation_hour_history",$this->request->createURL("SalesAccountManager", "view_operation_hour_history"));
		$result 					= $this->SalesAccountManagerFacade->searchGeneralHistory($_GET, $this->request->getAttribute("fr"));
		$changeValueArray			= array();
	
		$i=0;
		foreach($result['generalChange'] as $val)
		{
				
				$changeValueArray[$i]['time']		=$val['change_time'];
				$changeValueArray[$i]['clientName']	=$val['client_name'];
				$changeValueArray[$i]['oldValue']	=unserialize($val['old_value']);
				$changeValueArray[$i]['newValue']	=unserialize($val['new_value']);			
				$i++;	
		}
		//pre($changeValueArray);
		$this->page->assign("count",count($changeValueArray));
		$this->page->assign("values",$changeValueArray);
		$this->page->assign("paging", $result['paging']);
		$this->page->getPage('history_general.tpl');
   }
   
   
   public function view_classification_history()
   {
   		$this->page->pageTitle 					= "Classification Listing History";
		$this->page->assign("view_history",$this->request->createURL("SalesAccountManager", "view_history"));
		$this->page->assign("view_classification_history",$this->request->createURL("SalesAccountManager", "view_classification_history"));
		$this->page->assign("view_rank_history",$this->request->createURL("SalesAccountManager", "view_rank_history"));
		$this->page->assign("view_key_history",$this->request->createURL("SalesAccountManager", "view_key_history"));
		$this->page->assign("view_operation_day_history",$this->request->createURL("SalesAccountManager", "view_operation_day_history"));
		$this->page->assign("view_operation_hour_history",$this->request->createURL("SalesAccountManager", "view_operation_hour_history"));
		$result 					= $this->SalesAccountManagerFacade->searchGeneralHistory($_GET, $this->request->getAttribute("fr"));
		$changeValueArray			=array();
		$i=0;
		foreach($result['generalChange'] as $val)
		{
			$changeValueArray[$i]['time']		=$val['change_time'];
			$changeValueArray[$i]['clientName']	=$val['client_name'];
			$changeValueArray[$i]['oldValue']	=unserialize($val['old_value']);
			$changeValueArray[$i]['newValue']	=unserialize($val['new_value']);			
			$i++;		
		}
		
		$this->page->assign("count",count($changeValueArray));
		$this->page->assign("values",$changeValueArray);
		$this->page->assign("paging", $result['paging']);
		$this->page->getPage('history_classification.tpl');
		
		}
   
   public function view_rank_history()
   {
   		$this->page->pageTitle 					= "Rank Listing History";
  		$this->page->assign("view_history",$this->request->createURL("SalesAccountManager", "view_history"));
		$this->page->assign("view_classification_history",$this->request->createURL("SalesAccountManager", "view_classification_history"));
		$this->page->assign("view_rank_history",$this->request->createURL("SalesAccountManager", "view_rank_history"));
		$this->page->assign("view_key_history",$this->request->createURL("SalesAccountManager", "view_key_history"));
		$this->page->assign("view_operation_day_history",$this->request->createURL("SalesAccountManager", "view_operation_day_history"));
		$this->page->assign("view_operation_hour_history",$this->request->createURL("SalesAccountManager", "view_operation_hour_history"));
		$result 					= $this->SalesAccountManagerFacade->searchGeneralHistory($_GET, $this->request->getAttribute("fr"));
		$changeValueArray			=array();
		$i=0;
		foreach($result['generalChange'] as $val)
		{
				
				$changeValueArray[$i]['time']		=$val['change_time'];
				$changeValueArray[$i]['clientName']	=$val['client_name'];
				$changeValueArray[$i]['oldValue']	=unserialize($val['old_value']);
				$changeValueArray[$i]['newValue']	=unserialize($val['new_value']);			
				$i++;
			
		}

		$this->page->assign("count",count($changeValueArray));
		$this->page->assign("values",$changeValueArray);
		$this->page->assign("paging", $result['paging']);
		$this->page->getPage('history_rank.tpl');
   }
   
	public function view_key_history()
   	{
		$this->page->pageTitle 					= "Brand and Services Listing History";
  		$this->page->assign("view_history",$this->request->createURL("SalesAccountManager", "view_history"));
		$this->page->assign("view_classification_history",$this->request->createURL("SalesAccountManager", "view_classification_history"));
		$this->page->assign("view_rank_history",$this->request->createURL("SalesAccountManager", "view_rank_history"));
		$this->page->assign("view_key_history",$this->request->createURL("SalesAccountManager", "view_key_history"));
		$this->page->assign("view_operation_day_history",$this->request->createURL("SalesAccountManager", "view_operation_day_history"));
		$this->page->assign("view_operation_hour_history",$this->request->createURL("SalesAccountManager", "view_operation_hour_history"));
		$result 					= $this->SalesAccountManagerFacade->searchGeneralHistory($_GET, $this->request->getAttribute("fr"));
		
		$changeValueArray			=array();
		$i=0;
		foreach($result['generalChange'] as $val)
		{			
				$changeValueArray[$i]['time']		=$val['change_time'];
				$changeValueArray[$i]['clientName']	=$val['client_name'];
				$changeValueArray[$i]['oldValue']	=unserialize($val['old_value']);
				$changeValueArray[$i]['newValue']	=unserialize($val['new_value']);			
				$i++;			
		}

		$this->page->assign("count",count($changeValueArray));
		$this->page->assign("values",$changeValueArray);
		$this->page->assign("paging", $result['paging']);
		$this->page->getPage('history_key.tpl');
   }
   
   
   public function view_operation_day_history()
   {
  		$this->page->pageTitle 					= "Hours and Payment Listing History";
  		$this->page->assign("view_history",$this->request->createURL("SalesAccountManager", "view_history"));
		$this->page->assign("view_classification_history",$this->request->createURL("SalesAccountManager", "view_classification_history"));
		$this->page->assign("view_rank_history",$this->request->createURL("SalesAccountManager", "view_rank_history"));
		$this->page->assign("view_key_history",$this->request->createURL("SalesAccountManager", "view_key_history"));
		$this->page->assign("view_operation_day_history",$this->request->createURL("SalesAccountManager", "view_operation_day_history"));
		$this->page->assign("view_operation_hour_history",$this->request->createURL("SalesAccountManager", "view_operation_hour_history"));
		$result 					= $this->SalesAccountManagerFacade->searchGeneralHistory($_GET, $this->request->getAttribute("fr"));
		$changeValueArray			=array();
		$i=0;
		foreach($result['generalChange'] as $val)
		{
				
				$changeValueArray[$i]['time']		=$val['change_time'];
				$changeValueArray[$i]['clientName']	=$val['client_name'];
				$changeValueArray[$i]['oldValue']	=unserialize($val['old_value']);
				$changeValueArray[$i]['newValue']	=unserialize($val['new_value']);			
				$i++;
			
		}

		$this->page->assign("count",count($changeValueArray));
		$this->page->assign("values",$changeValueArray);
		$this->page->assign("paging", $result['paging']);
		$this->page->getPage('history_day.tpl');
   }
   
   
	/**
	*@desc  This is the function is used for serching the details of operation hor of the particular business.
	*/     
   public function view_operation_hour_history()
   {
  		$this->page->assign("view_history",$this->request->createURL("SalesAccountManager", "view_history"));
		$this->page->assign("view_classification_history",$this->request->createURL("SalesAccountManager", "view_classification_history"));
		$this->page->assign("view_rank_history",$this->request->createURL("SalesAccountManager", "view_rank_history"));
		$this->page->assign("view_key_history",$this->request->createURL("SalesAccountManager", "view_key_history"));
		$this->page->assign("view_operation_day_history",$this->request->createURL("SalesAccountManager", "view_operation_day_history"));
		$this->page->assign("view_operation_hour_history",$this->request->createURL("SalesAccountManager", "view_operation_hour_history"));
		
		$result 					= $this->SalesAccountManagerFacade->searchGeneralHistory($_GET,$this->request->getAttribute("fr"));

		$changeValueArray			= array();
		$i							= 0;
		foreach($result['generalChange'] as $val)
		{
				
				$changeValueArray[$i]['time']		=$val['change_time'];
				$changeValueArray[$i]['clientName']	=$val['client_name'];
				$changeValueArray[$i]['oldValue']	=unserialize($val['old_value']);
				$changeValueArray[$i]['newValue']	=unserialize($val['new_value']);			
				$i++;	
		}
		$this->page->assign("count",count($changeValueArray));
		$this->page->assign("values",$changeValueArray);
		$this->page->assign("paging", $result['paging']);
		$this->page->getPage('history_hour.tpl');
   }   


	/**
	*@desc  This is the function is used for editing the details of business.
	*/  
	public function Edit()
    {
	    $this->page->pageTitle 	= "Edit Listing";
		$classification			= (!empty($_POST['classification']))?$_POST['classification']:NULL;
		$Add1					= (!empty($_POST['Add1']))?$_POST['Add1']:NULL;
		$Add2					= (!empty($_POST['Add2']))?$_POST['Add2']:NULL;
		$Add3					= (!empty($_POST['Add3']))?$_POST['Add3']:NULL;
		$name					= (!empty($_POST['name']))?$_POST['name']:NULL;
		$street1				= (!empty($_POST['street1']))?$_POST['street1']:NULL;
		$street2				= (!empty($_POST['street2']))?$_POST['street2']:NULL;
		$postcode				= (!empty($_POST['postcode']))?$_POST['postcode']:NULL;
		$phonestd				= (!empty($_POST['phonestd']))?$_POST['phonestd']:NULL;
		$phone					= (!empty($_POST['phone']))?$_POST['phone']:NULL;
		$faxstd					= (!empty($_POST['faxstd']))?$_POST['faxstd']:NULL;
		$fax					= (!empty($_POST['fax']))?$_POST['fax']:NULL;
		$email					= (!empty($_POST['email']))?$_POST['email']:NULL;
		$url					= (!empty($_POST['url']))?$_POST['url']:NULL;
		$description			= (!empty($_POST['description']))?$_POST['description']:NULL;
		$origin					= (!empty($_POST['origin']))?$_POST['origin']:NULL;
		$mobile					= (!empty($_POST['mobile']))?$_POST['mobile']:NULL;
		$contact				= (!empty($_POST['contact']))?$_POST['contact']:NULL;
		
		$this->page->assign("classification",$classification);
		$this->page->assign("Add1",$Add1);
		$this->page->assign("Add2",$Add2);
		$this->page->assign("Add3",$Add3);
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

        $this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		
		$this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
		
        $this->page->assign("action",$this->request->createURL("SalesAccountManager", "editAddition","ID"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
        $this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("viewList",$this->request->createURL("SalesAccountManager","viewList"));           
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("add_keyword",$this->request->createURL("SalesAccountManager", "add_keyword"));	
        $this->page->assign("back",$this->request->createURL("Admin", "showhomePageEmployee"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing", "addListing"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
        $this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("edit",$this->request->createURL("SalesAccountManager", "Edit","ID"));
        $this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit","ID"));
    	$this->page->assign("delete",$this->request->createURL("SalesAccountManager", "delete","ID"));  
		$this->page->assign("searchemployee",$this->request->createURL("SalesAccountManager","searchEmployee"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists"));   
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("addemployee",$this->request->createURL("SalesAccountManager","registrationAdd"));
		$this->page->assign("changePassword",$this->request->createURL("SalesAccountManager","changePassword"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));
		$this->page->assign("addMoreAddresses",$this->request->createURL("SalesAccountManager", "addMoreAddresses","ID"));
		$this->page->assign("manageAddress",$this->request->createURL("SalesAccountManager", "manageAddress","ID"));
		$this->page->assign("manageHoursDays",$this->request->createURL("SalesAccountManager", "manageHoursDays"));

		$res3=$this->SalesAccountManagerFacade->editListingFetchDetails();

        $this->page->assign("values12",$res3[0]);

		$res2=$this->SalesAccountManagerFacade->selectStates();
		$this->page->assign("values21",$res2);

		$regionValue=$this->SalesAccountManagerFacade->fetchRegion();
		$this->page->assign("regionValue",$regionValue);

		$res1=$this->SalesAccountManagerFacade->fetchClassificationDetails();
		$this->page->assign("values2",$res1);

		$res=$this->SalesAccountManagerFacade->fetchTownDetails();
		$this->page->assign("values",$res);

		//$brandResult=$this->SalesAccountManagerFacade->fetchBrands();
		//$this->page->assign("brandResult",$brandResult);
		
		$rankList=$this->SalesAccountManagerFacade->fetchRankRate();
		$this->page->assign("rankList",$rankList);
		
		$businessBrand=$this->SalesAccountManagerFacade->fetchBusinessBrand();
		$this->page->assign("businessBrand",$businessBrand);
		
        $this->page->getPage('editlisting.tpl');
    }
	
	
	/**
	*@desc  This is the function is used for viewing the details of business hour and days and the edit the details.
	*/  	
	public function manageHoursDays()
	{
		$this->page->pageTitle 			= "Add Hours and Payment";
		$msg 								= (!empty($_GET['msg']))?$_GET['msg']:NULL;
		$this->page->assign("msg",$msg);
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));
		$this->page->assign("manageHoursDays",$this->request->createURL("SalesAccountManager", "manageHoursDays"));
		$this->page->assign("add_keyword",$this->request->createURL("SalesAccountManager", "add_keyword"));
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit"));
		$this->page->assign("actionPayment",$this->request->createURL("SalesAccountManager", "add_new_payment","ID"));
		$this->page->assign("deleteHour",$this->request->createURL("SalesAccountManager", "deleteHour","ID"));
		$this->page->assign("deletePayment",$this->request->createURL("SalesAccountManager", "deletePayment","ID"));

		$res3=$this->SalesAccountManagerFacade->editListingFetchDetails();
        $this->page->assign("values12",$res3[0]);			
		
		$businessHour=$this->SalesAccountManagerFacade->fetchHour();
		$this->page->assign("businessHour",$businessHour);
		
		$businessHourResult					= $this->SalesAccountManagerFacade->fetchBusinessHour();
		$this->page->assign("businessHourResult",$businessHourResult);
		
		$businessDays						= $this->SalesAccountManagerFacade->fetchPayment();
		$this->page->assign("businessDays",$businessDays);
		
		$businessPaymentResult				= $this->SalesAccountManagerFacade->fetchBusinessPayment();
		$this->page->assign("businessPaymentResult",$businessPaymentResult);
	
		$this->page->assign("action",$this->request->createURL("SalesAccountManager", "add_new_hour","ID"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("manageHoursDays",$this->request->createURL("SalesAccountManager", "manageHoursDays"));
		$this->page->assign("add_keyword",$this->request->createURL("SalesAccountManager", "add_keyword"));	
	    $this->page->getPage('add_business_days_hour.tpl');
	}
	
	
	/**
	*@desc  This is the function is used for getting the old working hour and edit the hour details of the business.
	*/  
	public function add_new_hour()
	{
		$msg 								= (!empty($_GET['msg']))?$_GET['msg']:NULL;
		$this->page->assign("msg",$msg);
		$this->page->assign("deleteAction",$this->request->createURL("SalesAccountManager", "deleteKeyword","ID"));
		$this->page->assign("add_keyword",$this->request->createURL("SalesAccountManager", "add_keyword"));	
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("viewList",$this->request->createURL("SalesAccountManager","viewList"));
		$this->page->assign("add_keyword",$this->request->createURL("SalesAccountManager", "add_keyword"));	
		
		$classificationAddResult			= $this->SalesAccountManagerFacade->add_new_hour($_POST,$_GET);
		
			if($classificationAddResult['result'])
			{	
				$this->request->redirect("SalesAccountManager","manageHoursDays","ID={$classificationAddResult['ID']}&msg=1");
			}		
		 $this->page->getPage('add_business_days_hour.tpl');
	}
	
	
	/**
	*@desc  This is the function is used for adding new payment details.
	*/  	
	public function add_new_payment()
	{
		$msg 							= (!empty($_GET['msg']))?$_GET['msg']:NULL;
		$this->page->assign("msg",$msg);
		$this->page->assign("deleteAction",$this->request->createURL("SalesAccountManager", "deleteKeyword","ID"));
		$this->page->assign("add_keyword",$this->request->createURL("SalesAccountManager", "add_keyword"));	
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("viewList",$this->request->createURL("SalesAccountManager","viewList"));
		$this->page->assign("add_keyword",$this->request->createURL("SalesAccountManager", "add_keyword"));	
		
		$classificationAddResult		= $this->SalesAccountManagerFacade->add_new_payment($_POST,$_GET);
		
			if($classificationAddResult['result'])
			{	
				$this->request->redirect("SalesAccountManager","manageHoursDays","ID={$classificationAddResult['ID']}&msg=2");
			}
		 $this->page->getPage('add_business_days_hour.tpl');
	}
	
	
	/**
	*@desc  This is the function is used for editing the hour and days of the business.
	*/  	
	public function editHourDays()
	{
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));
		$this->page->assign("manageHoursDays",$this->request->createURL("SalesAccountManager", "manageHoursDays"));
	  	$res						= $this->SalesAccountManagerFacade->editHourDays($_POST);
		if($res['result'])
		{
			$this->request->setAttribute("message-succ", $res['message']);
			$this->manageHoursDays();
		}else{
			$this->request->setAttribute("message", $res['message']);
			$this->manageHoursDays();
		}	
	}	 
	
	
	/**
	*@desc  This is the function is used for adding the aditional address of the particular business.
	*/  	
	public function addMoreAddresses()
	{
		 $this->page->pageTitle 		= "Add Addresses";
		 $Add1							= (!empty($_POST['Add1']))?$_POST['Add1']:NULL;
		 $Add2							= (!empty($_POST['Add2']))?$_POST['Add2']:NULL;
		 $street1						= (!empty($_POST['street1']))?$_POST['street1']:NULL;
		 $street2						= (!empty($_POST['street2']))?$_POST['street2']:NULL;
		 $suburb						= (!empty($_POST['suburb']))?$_POST['suburb']:NULL;
		 $region						= (!empty($_POST['region']))?$_POST['region']:NULL;
		 $postcode						= (!empty($_POST['postcode']))?$_POST['postcode']:NULL;
		 
		 $this->page->assign("do",$_GET['do']);
		 $this->page->assign("action1",$_GET['action']);
		 $this->page->assign("street1",$street1);
		 $this->page->assign("street2",$street2);
		 $this->page->assign("suburb",$suburb);
		 $this->page->assign("region",$region);
		 $this->page->assign("postcode",$postcode);
		 
		 $this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit"));
		 $this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		 $this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness")); 
		 $this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		 $this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness")); 
		 $this->page->assign("add_keyword",$this->request->createURL("SalesAccountManager", "add_keyword"));
		 $this->page->assign("manageHoursDays",$this->request->createURL("SalesAccountManager", "manageHoursDays"));
		 $this->page->assign("actionBrand",$this->request->createURL("SalesAccountManager", "add_new_brand","ID"));
		 $this->page->assign("manageAddress",$this->request->createURL("SalesAccountManager", "manageAddress","ID"));		
	
		 $res3							= $this->SalesAccountManagerFacade->editListingFetchDetails();		
		 $this->page->assign("values12",$res3[0]);
		 
		 $res2							= $this->SalesAccountManagerFacade->selectStates();
		 $this->page->assign("values21",$res2);
		 
		 $regionValue					= $this->SalesAccountManagerFacade->fetchRegion($_GET['ID']);
		// pre($regionValue);
		 $this->page->assign("regionValue",$regionValue);
		 
		 $res							= $this->SalesAccountManagerFacade->fetchTownDetails();
		 $this->page->assign("values",$res);
		 
		 $this->page->assign("action",$this->request->createURL("SalesAccountManager","moreAddressesAdd","ID"));	
		 $this->page->getPage('multiple_address_add_form.tpl');
	}
	
	
	/**
	*@desc  This is the function is used for adding the aditional address of the particular business.
	*/  	
	public function moreAddressesAdd()
	{
		$this->page->pageTitle 				= "Add Addresses";
		$this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));
		$this->page->assign("add_keyword",$this->request->createURL("SalesAccountManager", "add_keyword"));
		$this->page->assign("actionBrand",$this->request->createURL("SalesAccountManager", "add_new_brand","ID"));
		
		$result								= $this->SalesAccountManagerFacade->moreAddressesAdd($_POST);
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
	*@desc  This is the function is used for managing the address details of the business.
	*/  	 
	 public function manageAddress()
	 {
		$this->page->pageTitle 		= "Addresses";
		$this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));
        $this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
        $this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness")); 	
	    $this->page->assign("editurl",$this->request->createURL("SalesAccountManager","editAddress"));
	    $this->page->assign("add_keyword",$this->request->createURL("SalesAccountManager", "add_keyword"));	
	    $this->page->assign("delete",$this->request->createURL("SalesAccountManager","deleteaddress"));
		 $this->page->assign("manageHoursDays",$this->request->createURL("SalesAccountManager", "manageHoursDays"));
		 $this->page->assign("actionBrand",$this->request->createURL("SalesAccountManager", "add_new_brand","ID"));
		 $this->page->assign("addMoreAddresses",$this->request->createURL("SalesAccountManager", "addMoreAddresses","ID"));			
		
	    $result						= $this->SalesAccountManagerFacade->manageAddress($this->request->getAttribute("fr"));
		$this->page->assign("count",count($result['listings']));
	    $this->page->assign("values",$result['listings']);
		$this->page->assign("paging", $result['paging']);
		$this->page->getPage("addresses_list.tpl");
	 }
	 
	 
	/**
	*@desc  This is the function is used for editing the details of address for the business.
	*/  	 
	 public function editAddress()
	 {
		$this->page->pageTitle 					= "Edit address";
		$this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));
        $this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
        $this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness")); 	
	    $this->page->assign("add_keyword",$this->request->createURL("SalesAccountManager", "add_keyword"));
				 $this->page->assign("manageHoursDays",$this->request->createURL("SalesAccountManager", "manageHoursDays"));
		 $this->page->assign("actionBrand",$this->request->createURL("SalesAccountManager", "add_new_brand","ID"));
		  $this->page->assign("manageAddress",$this->request->createURL("SalesAccountManager", "manageAddress","ID"));		
		
	    $res3									= $this->SalesAccountManagerFacade->editaddressFetchDetails();
		//pre($res3);		
        $this->page->assign("values12",@$res3[0]);
		
	    $res2									= $this->SalesAccountManagerFacade->selectStates();
	    $this->page->assign("values21",$res2);
		
	    $regionValue							= $this->SalesAccountManagerFacade->fetchRegion();
		//pre($regionValue);
	    $this->page->assign("regionValue",$regionValue);
		
	    $res									= $this->SalesAccountManagerFacade->fetchTownDetails();
	    $this->page->assign("values",$res);
		
	    $this->page->assign("action",$this->request->createURL("SalesAccountManager","editAddressesAdd","ID1"));
	    $this->page->getPage("edit_addresses.tpl");
	 }
	 
	 
	/**
	*@desc  This is the function is used for editing the details of address for the business.
	*/	 
	 public function editAddressesAdd()
	 {
		$this->page->pageTitle 					= "Edit address";
		$this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));
        $this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
        $this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
	    $this->page->assign("add_keyword",$this->request->createURL("SalesAccountManager", "add_keyword"));	 	
		
	    $res									= $this->SalesAccountManagerFacade->editAddressesAdd($_POST);
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
	*@desc  This is the function is used for deleting the address.
	*/	 
	 public function deleteaddress()
	 {
		$this->page->pageTitle 			= "Delete address";
		$this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness")); 
		
		$res							= $this->SalesAccountManagerFacade->deleteaddress();
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
	*@desc  This is the function is used for editing the details of affiliate.
	*/	
	public function editAddition()
    {
	    $this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
        $this->page->assign("login_url",$this->request->createURL("Admin", "login"));
        $this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
        $this->page->assign("back",$this->request->createURL("Admin", "showhomePageEmployee"));
		$this->page->assign("viewList",$this->request->createURL("SalesAccountManager","viewList"));           
        $this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("delete",$this->request->createURL("Listing", "delete","ID"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing", "addListing"));
        $this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists"));   
		$this->page->assign("changePassword",$this->request->createURL("SalesAccountManager","changePassword"));
		$this->page->assign("edit",$this->request->createURL("SalesAccountManager", "Edit","ID")); 
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));
		$this->page->assign("delete",$this->request->createURL("SalesAccountManager", "delete","ID"));
		$this->page->assign("searchemployee",$this->request->createURL("SalesAccountManager","searchEmployee"));
		$this->page->assign("addemployee",$this->request->createURL("SalesAccountManager","registrationAdd"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		
		
		
//Maintain the change in the value after the updation in the business listing details.
		
		$this->SalesAccountManagerFacade->changeValue($_POST,$_FILES);
		  
        $res						= $this->SalesAccountManagerFacade->editListing($_POST,$_FILES);
		if($res['result'])
		{
			$this->request->setAttribute("message-succ", $res['message']);
			$this->Edit();
		}else{
			$this->request->setAttribute("message", $res['message']);
			$this->Edit();
		}
	}
	 


	/**
	*@desc  This is the function is used for deteling the details of business.
	*/	 
	public function delete()
    { 
	    $this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
    	$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
        $this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
        $this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("viewList",$this->request->createURL("SalesAccountManager","viewList"));           
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
        $this->page->assign("back",$this->request->createURL("Admin", "showhomePageEmployee"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing", "addListing"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
        $this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("edit",$this->request->createURL("SalesAccountManager", "Edit1","ID"));
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));		
		$this->page->assign("edit_url", "javascript:window.location='".$this->request->createURL("SalesAccountManager", "Edit1", "name={$this->request->getAttribute('name')}&state={$this->request->getAttribute('state')}"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		//$this->page->assign("delete","javascript:window.location='".$this->request->createURL("SalesAccountManager", "delete", "name={$this->request->getAttribute('name')}&state={$this->request->getAttribute('state')}&ID"));
		//$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit","ID"));
		//$this->page->assign("delete",$this->request->createURL("SalesAccountManager", "delete","ID"));
		$this->page->assign("delete",$this->request->createURL("SalesAccountManager", "delete","name={$this->request->getAttribute('name')}&state={$this->request->getAttribute('state')}&fr={$this->request->getAttribute("fr")}&ID"));
		$this->page->assign("searchemployee",$this->request->createURL("SalesAccountManager","searchEmployee"));
		$this->page->assign("addemployee",$this->request->createURL("SalesAccountManager","registrationAdd"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists"));   
		$this->page->assign("changePassword",$this->request->createURL("SalesAccountManager","changePassword"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$result=$this->SalesAccountManagerFacade->delList($_GET);
		if($result['result'])
		{
		    $this->request->setAttribute("message-succ", $result['message']);
			 	if($this->request->getAttribute("name")!='' || $this->request->getAttribute("user")!='')
	        	{
					  $result 		= $this->SalesAccountManagerFacade->searchBusiness($_GET, $this->request->getAttribute("fr"));
					  $this->page->assign("values",$result['listings']);
					  $this->page->assign("paging", $result['paging']);
					  $this->page->getPage('listshow.tpl'); 
				}else{
					  $res1			= $this->SalesAccountManagerFacade->viewfetchDetails($this->request->getAttribute("fr"));
					  $this->page->assign("values",$res1['listings']);
					  $this->page->assign("paging", $res1['paging']);
					  $this->page->getPage("listshow.tpl");
		    	}
		 }else{
		   $this->request->setAttribute("message", $result['message']); 
		   $this->viewList();
		 }
    }
	
	
	
	public function Edit1()
    {
	    $this->page->pageTitle = "Edit Listing";
		$classification	= (!empty($_POST['classification']))?$_POST['classification']:NULL;
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
		
		$this->page->assign("classification",$classification);
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

        $this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		
		$this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		
        $this->page->assign("action",$this->request->createURL("SalesAccountManager", "editAddition1","ID"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
        $this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
        $this->page->assign("back",$this->request->createURL("Admin", "showhomePageEmployee"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing", "addListing"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
        $this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("edit",$this->request->createURL("SalesAccountManager", "Edit1","ID"));
        $this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit1"));
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));
    	$this->page->assign("delete",$this->request->createURL("SalesAccountManager", "delete","ID"));  
		$this->page->assign("searchemployee",$this->request->createURL("SalesAccountManager","searchEmployee"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists"));   
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("addemployee",$this->request->createURL("SalesAccountManager","registrationAdd"));
		$this->page->assign("changePassword",$this->request->createURL("SalesAccountManager","changePassword"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("addMoreAddresses",$this->request->createURL("SalesAccountManager", "addMoreAddresses","ID"));
		$this->page->assign("manageAddress",$this->request->createURL("SalesAccountManager", "manageAddress","ID"));
		$res3=$this->SalesAccountManagerFacade->editListingFetchDetails();
        $this->page->assign("values12",$res3[0]);
		$res2=$this->SalesAccountManagerFacade->selectStates();
		$this->page->assign("values21",$res2);
		$regionValue=$this->SalesAccountManagerFacade->fetchRegion();
		$this->page->assign("regionValue",$regionValue);
		$res1=$this->SalesAccountManagerFacade->fetchClassificationDetails();
		$this->page->assign("values2",$res1);
		$res=$this->SalesAccountManagerFacade->fetchTownDetails();
		$this->page->assign("values",$res);
        $this->page->getPage('editlisting.tpl');
    }	
	
	
	
	public function editAddition1()
    {
	    $this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
        $this->page->assign("login_url",$this->request->createURL("Admin", "login"));
        $this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
        $this->page->assign("back",$this->request->createURL("Admin", "showhomePageEmployee"));
        $this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("delete",$this->request->createURL("Listing", "delete","ID"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing", "addListing"));
        $this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists"));   
		$this->page->assign("changePassword",$this->request->createURL("SalesAccountManager","changePassword"));
		$this->page->assign("edit",$this->request->createURL("SalesAccountManager", "Edit1","ID")); 
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit1"));
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));
		$this->page->assign("delete",$this->request->createURL("SalesAccountManager", "delete","ID"));
		$this->page->assign("searchemployee",$this->request->createURL("SalesAccountManager","searchEmployee"));
		$this->page->assign("addemployee",$this->request->createURL("SalesAccountManager","registrationAdd"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("addMoreAddresses",$this->request->createURL("SalesAccountManager", "addMoreAddresses","ID"));
		$this->page->assign("manageAddress",$this->request->createURL("SalesAccountManager", "manageAddress","ID"));
			   
				$image=$_FILES['logo']['name'];
				$tmp=$_FILES['logo']['tmp_name'];
				

		move_uploaded_file($tmp,"View/Default/Images/client_image/$image");
        $res	=$this->SalesAccountManagerFacade->editListing($_POST,$_FILES);
		if($res['result'])
		{
        $this->request->setAttribute("message-succ", $res['message']);
		$this->Edit1();
		}else{
		$this->request->setAttribute("message", $res['message']);
		$this->Edit1();
		}
	}
	
	
	/**
	*@desc  This is the function is used for deleting the business listings.
	*/		   
    public function deleteFreeListing()
    { 
	    $this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
    	$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
        $this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
        $this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists")); 
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));		
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
        $this->page->assign("back",$this->request->createURL("Admin", "showhomePageEmployee"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing", "addListing"));
        $this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("edit",$this->request->createURL("SalesAccountManager", "Edit","ID")); 
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("edit_url", "javascript:window.location='".$this->request->createURL("SalesAccountManager", "Edit1"));
	    $this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("delete",$this->request->createURL("SalesAccountManager", "deleteFreeListing","fr={$this->request->getAttribute("fr")}&ID"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists"));   
		$this->page->assign("searchemployee",$this->request->createURL("SalesAccountManager","searchEmployee"));
		$this->page->assign("addemployee",$this->request->createURL("SalesAccountManager","registrationAdd"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("changePassword",$this->request->createURL("SalesAccountManager","changePassword"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$res=$this->SalesAccountManagerFacade->delList($_GET);
		
		if($res['result'])
		{
		$this->request->setAttribute("message-succ", $res['message']);
		if($this->request->getAttribute("name")!='' || $this->request->getAttribute("type")=='1')
	    {
		 $result= $this->SalesAccountManagerFacade->searchList($_GET,$this->request->getAttribute("fr"));
	    $this->page->assign("values",$result['listings']);
		$this->page->assign("paging", $result['paging']);
		$this->page->getpage('listshow.tpl');
		}
		elseif($this->request->getAttribute("name")!='' || $this->request->getAttribute("type")=='0')
		{
		$result = $this->SalesAccountManagerFacade->searchFreeListing($this->request->getAttribute("fr"));
     	$this->page->assign("values",$result['listings']);
		$this->page->assign("paging", $result['paging']);
		$this->page->getPage('free_listing.tpl'); 
		}
		else
		{
		$result = $this->SalesAccountManagerFacade->searchFreeListing($this->request->getAttribute("fr"));
     	$this->page->assign("values",$result['listings']);
		$this->page->assign("paging", $result['paging']);
		$this->page->getPage('free_listing.tpl'); 
		
		}
		
       }
	}
    
	
	/**
	*@desc  This is the function is used for searching the free business listing details according to the search condition.
	*/		
	public function searchfreeLists()
	{
	    $this->page->pageTitle = "Search free lists";
		$this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists")); 
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));		
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("back",$this->request->createURL("Admin", "showhomePageEmployee"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing", "addListing"));
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("edit",$this->request->createURL("SalesAccountManager", "Edit1","ID")); 
		$this->page->assign("edit_url", "javascript:window.location='".$this->request->createURL("SalesAccountManager", "Edit1"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("delete",$this->request->createURL("SalesAccountManager", "deleteFreeListing","ID"));
		$this->page->assign("searchemployee",$this->request->createURL("SalesAccountManager","searchEmployee"));
		$this->page->assign("addemployee",$this->request->createURL("SalesAccountManager","registrationAdd"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists"));   
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("changePassword",$this->request->createURL("SalesAccountManager","changePassword"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("action",$this->request->createURL("SalesAccountManager","searchListings"));
		$this->page->getPage("search_free_listing_form.tpl");
	}
	
	/**
	*@desc  This is the function is used for searching the business listing details according to the search condition.
	*/	
	public function searchListings()
	{   
	    $this->page->pageTitle = "Search listings";
	    $this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
        $this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
        $this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists")); 
		
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
        $this->page->assign("back",$this->request->createURL("Admin", "showhomePageEmployee"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing", "addListing"));
        $this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("edit",$this->request->createURL("SalesAccountManager", "Edit1","ID")); 
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit1"));
	    $this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("delete",$this->request->createURL("SalesAccountManager", "deleteFreeListing","fr={$this->request->getAttribute("fr")}&businessname={$this->request->getAttribute("businessname")}&type={$this->request->getAttribute("type")}&ID"));
		$this->page->assign("searchemployee",$this->request->createURL("SalesAccountManager","searchEmployee"));
		$this->page->assign("addemployee",$this->request->createURL("SalesAccountManager","registrationAdd"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("changePassword",$this->request->createURL("SalesAccountManager","changePassword"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));   
		$retArr=$this->SalesAccountManagerFacade->validatesearch($_GET);
		if($retArr['result'])
		{
		  if($_GET['type']=='0')
		  {
			$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
			$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));		
			$result= $this->SalesAccountManagerFacade->searchListings($_GET,$this->request->getAttribute("fr"));
			$this->page->assign("count",count($result['listings']));
			$this->page->assign("values",$result['listings']);
			$this->page->assign("paging", $result['paging']);
			$this->page->getPage('free_listing.tpl'); 
		  }	
	     else
		 {
			$this->page->assign("edit_classification",$this->request->createURL("AdminListing", "addClassification"));
			$this->page->assign("edit_rank",$this->request->createURL("AdminListing", "rankBusiness"));		
			$result= $this->SalesAccountManagerFacade->searchList($_GET,$this->request->getAttribute("fr"));
			$this->page->assign("count",count($result['listings']));
			$this->page->assign("values",$result['listings']);
			$this->page->assign("paging", $result['paging']);
			$this->page->getpage('listshow.tpl');
		 }
	    }
		else
		{
		 $this->request->setAttribute("message", $retArr['message']);
		 $this->searchfreeLists();
		}
	}
	


	/**
	*@desc  This is the function is used for fetching the suburbs.
	*/	
	public function getSuburb()
	{ 
		$result					= $this->SalesAccountManagerFacade->getSuburb($_GET);
		echo "<option value='--Select One--'>"."--Select One--"."</option>";
		foreach ($result as $value)
		{
		
		echo "<option value='".$value['shiretown_postcode'].",".$value['shiretown_id']."'>".$value['shiretown_townname']."</option>";
		}
	
	}
	public function getSuburblisting()
	{ 
		$result					= $this->SalesAccountManagerFacade->getSuburb($_GET);
		echo "<option value='--Select One--'>"."--Select One--"."</option>";
		foreach ($result as $value)
		{
		
		echo "<option value='".$value['shiretown_postcode'].",".$value['shiretown_townname']."'>".$value['shiretown_townname']."</option>";
		}
	
	}
	
/**********************************************BUSINESS ADD/EDIT/DELETE/SEARCH*******************************************/
}   
?>