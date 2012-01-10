<?php
class EmployeeControl extends MainControl {

    private $employeeFacade;

    public function __construct($request)
	 {

		parent::__construct($request);

		$this->employeeFacade = new EmployeeFacade($GLOBALS['conn']);
		$this->request = $request;
		$this->page = new AdminPage();
    }
	/* END __construct */

 public function viewList()
	 {           
		$this->page->assign("action",$this->request->createURL("Employee", "listingAddition"));
		$this->page->assign("back",$this->request->createURL("Employee", "showhomePageEmployee"));            
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));  
		$this->page->assign("edit_url",$this->request->createURL("Employee", "Edit","ID"));
		$this->page->assign("delete",$this->request->createURL("Employee", "delete","ID"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("listing",$this->request->createURL("Employee", "addListing")); 
		$this->page->assign("edit",$this->request->createURL("Employee", "Edit","ID"));  
		$res1=$this->employeeFacade->viewfetchDetails();//prexit($res);
		$this->page->assign("values",$res1);
		$this->page->getPage("listshow.tpl");
     }
 
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
		$listings		= (!empty($_POST['listing']))?$_POST['listing']:NULL;
		$classification		= (!empty($_POST['classification']))?$_POST['classification']:NULL;		
		
		$this->page->assign("classification",$classification);
		$this->page->assign("initials",$initials);
		$this->page->assign("listings",$listings);
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
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("cancel",$this->request->createURL("Admin", "showhomePageEmployee"));
		$this->page->assign("addbusinessform",$this->request->createURL("Employee", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("action",$this->request->createURL("Employee", "listingAddition"));
		$this->page->assign("viewlisting",$this->request->createURL("Employee", "viewList"));
		$this->page->assign("back",$this->request->createURL("Admin", "showhomePageEmployee"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("edit_url",$this->request->createURL("Employee", "Edit","ID")); 
		$this->page->assign("edit",$this->request->createURL("Employee", "Edit","ID"));
		
		$res1=$this->employeeFacade->fetchClassificationDetails();
		$this->page->assign("values1",$res1);
		
		$regionValue=$this->employeeFacade->fetchRegion();
		$this->page->assign("regionValue",$regionValue);
		
		$res=$this->employeeFacade->fetchTownDetails();
		$this->page->assign("values",$res);
		
		$res2=$this->employeeFacade->selectStates();
		$this->page->assign("values2",$res2);
		
		$res3=$this->employeeFacade->fetchRank();
		$this->page->assign("rank",$res3[0]['rank']);
		
		$rankList=$this->employeeFacade->fetchRankRate();
		$this->page->assign("rankList",$rankList);
		$this->page->getPage('listingadd.tpl');
	}
	
	
  public function listingAddition()
   {
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));  
		$this->page->assign("edit_url",$this->request->createURL("Employee", "Edit","ID")); 
		$this->page->assign("delete",$this->request->createURL("Employee", "delete","ID"));
		$this->page->assign("viewlisting",$this->request->createURL("Employee", "viewList"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("edit",$this->request->createURL("Employee", "Edit","ID"));
		
		$image=$_FILES['logo']['name'];
		$tmp=$_FILES['logo']['tmp_name'];
		move_uploaded_file($tmp,"View/Default/Images/client_image/$image");
	
		$res=$this->employeeFacade->addlist1($_POST,$_FILES);//prexit($res);
		if(!$res['result'])
		{
			$this->request->setAttribute("message", $res['message']);
			$this->addListing();		
		}else{
		//	$this->request->setAttribute("message-succ", $res['message']);//$this->addListing();
			$this->request->redirect("Employee","addClassification","ID={$res['InsertID']}&msg=1");
		}	
  	}
	
	
	
	public function addClassification()
		{
		$this->page->pageTitle = "Add Classification";
		$this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
		$this->page->assign("msg",$_GET['msg']);
		$this->page->assign("addbusinessform",$this->request->createURL("Employee", "addListing"));
		$this->page->assign("search",$this->request->createURL("Employee","searchBusiness"));
		$this->page->assign("viewList",$this->request->createURL("Employee","viewList"));
		$classificationList=$this->employeeFacade->fetchClassificationDetails();
		$this->page->assign("classificationList",$classificationList);
		$classificationListResult=$this->employeeFacade->classificationList($_GET);
		$this->page->assign("classificationListResult",$classificationListResult);
		$this->page->assign("action",$this->request->createURL("Employee", "addClassificationDetail","ID"));
		$this->page->assign("deleteAction",$this->request->createURL("Employee", "deleteClassification","ID"));
		$this->page->assign("businessRank",$this->request->createURL("Employee", "rankBusiness","ID"));
		$this->page->getPage('add_classification.tpl');
		}
		
		public function addClassificationDetail()
		{
		$this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
		$this->page->assign("msg",$_GET['msg']);
		$this->page->assign("addbusinessform",$this->request->createURL("Employee", "addListing"));
		$this->page->assign("search",$this->request->createURL("Employee","searchBusiness"));
		$this->page->assign("viewList",$this->request->createURL("Employee","viewList"));
		$classificationList=$this->employeeFacade->fetchClassificationDetails();
		$this->page->assign("classificationList",$classificationList);
		
		$classificationAddResult	=$this->employeeFacade->addClassificationDetail($_POST,$_GET);
		
			if($classificationAddResult['result'])
			{	
			  //  $this->request->setAttribute("message-succ", $classificationAddResult['message']);//$this->addClassification();
				$this->request->redirect("Employee","addClassification","ID={$classificationAddResult['ID']}&msg=2");
			}
		
		$this->page->getPage('add_classification.tpl');		
		}
		
		public function deleteClassification()
		{
		$this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
		$this->page->assign("msg",$_GET['msg']);
		$this->page->assign("addbusinessform",$this->request->createURL("Employee", "addListing"));
		$this->page->assign("search",$this->request->createURL("Employee","searchBusiness"));
		$this->page->assign("viewList",$this->request->createURL("Employee","viewList"));
			$classificationDelResult	=$this->employeeFacade->deleteClassification($_POST,$_GET);
		
			if($classificationDelResult['result'])
			{	
			    //$this->request->setAttribute("message-succ", $classificationDelResult['message']);
				$this->request->redirect("Employee","addClassification","ID={$classificationDelResult['ID']}&msg=3");
			}
		
		}
		
		public function rankBusiness()
		{
		$this->page->pageTitle = "Rank Business";
		$this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
		$this->page->assign("msg",$_GET['msg']);
		$this->page->assign("addbusinessform",$this->request->createURL("Employee", "addListing"));
		$this->page->assign("search",$this->request->createURL("Employee","searchBusiness"));
		$this->page->assign("viewList",$this->request->createURL("Employee","viewList"));
		$ranks = array('1'=>'1',
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
		
		$rankResult=$this->employeeFacade->rankDetails($_GET);
		//pre($rankResult);
		$this->page->assign("rankResult",$rankResult);
		
		
		$classificationListResult=$this->employeeFacade->classificationList($_GET);
		$array1 = array(array("localclassification_id" => "", "localclassification_name" => ""));
		$finalResult1=array_merge($array1,$classificationListResult);		
		$this->page->assign("classificationListResult",$finalResult1);

		$regionValue=$this->employeeFacade->fetchRegion();
		$array2 = array(array("shirename_id" => "", "shirename_shirename" => "", "shirename_state" => ""));
		$finalResult2=array_merge($array2,$regionValue);		
		$this->page->assign("regionValue",$finalResult2);
		$this->page->assign("action",$this->request->createURL("Employee", "addRank","ID"));
		$this->page->getPage('add_business_rank.tpl');
		}
		
		public function addRank()
		{
		$this->page->pageTitle = "Rank Business";
		$this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
		$this->page->assign("addbusinessform",$this->request->createURL("Employee", "addListing"));
		$this->page->assign("search",$this->request->createURL("Employee","searchBusiness"));
		$this->page->assign("viewList",$this->request->createURL("Employee","viewList"));
		$addRankResult	=$this->employeeFacade->addRank($_POST,$_GET);//prexit($addRankResult);

			if($addRankResult['result'])
			{	
			//$this->request->setAttribute("message-succ", $addRankResult['message']);
			//$this->rankBusiness();
				$this->request->redirect("Employee","rankBusiness","ID={$addRankResult['ID']}&msg=4");
			}
		}
	
	
	
	
	
	
	
	
	public function showMidPage($ID)
	{ 
	  $this->page->assign("delete",$this->request->createURL("Employee", "delete","ID"));
	  $this->page->assign("updateAction",$this->request->createURL("Employee", "updateAdd","ID={$ID}"));
	  $this->page->getPage("listing_intermediate_page.tpl");
	}
	
	public function updateAdd()
	{
	  $this->page->assign("delete",$this->request->createURL("SalesAccountManager", "delete","ID"));
	  $res=$this->employeeFacade->updateAdd($_POST);
	  if($res['result'])
		{
		   $this->request->setAttribute("message-succ", $res['message']);
		   $this->viewList();
		}
		else{
			$this->request->setAttribute("message", $res['message']);
			$this->addListing();}
	}
	
	
	
	
	
  
   public function searchBusiness()
   {
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));  
		$this->page->assign("addbusinessform",$this->request->createURL("Employee", "addListing"));
		$this->page->assign("search",$this->request->createURL("Employee","searchBusiness"));
		$this->page->assign("edit_url",$this->request->createURL("Employee", "Edit","ID")); 
		$this->page->assign("delete",$this->request->createURL("Employee", "delete","ID"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("viewlisting",$this->request->createURL("Employee", "viewList"));
		$this->page->assign("action",$this->request->createURL("Employee","searchBusinesses"));
		$rec=$this->employeeFacade->selectStates();
		$this->page->assign("values1",$rec);
		$this->page->getPage("searchbusiness.tpl");
   }
   
   public function searchBusinesses()
   {             
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));  
		$this->page->assign("addbusinessform",$this->request->createURL("Employee", "addListing"));
		$this->page->assign("search",$this->request->createURL("Employee","searchBusiness"));
		$this->page->assign("edit_url",$this->request->createURL("Employee", "Edit","ID")); 
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("delete",$this->request->createURL("Employee", "delete","ID"));
		$this->page->assign("viewlisting",$this->request->createURL("Employee", "viewList"));
		$retArr=$this->employeeFacade->validatesearch($_GET);
		if($retArr['result'])
		{
	    $rec=$this->employeeFacade->searchBusiness($_POST);
		$this->page->assign("values",$rec);
		$this->page->getpage('listshow.tpl');
		}
		else
		{
		  $this->request->setAttribute("message", $retArr['message']);
		  $this->searchBusiness();
		}
		
   }


   public function Edit()
    {
        $this->page->assign("login_url",$this->request->createURL("Admin", "login"));
        $this->page->assign("action",$this->request->createURL("Employee", "editAddition","ID"));
        $this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
        $this->page->assign("back",$this->request->createURL("Admin", "showhomePageEmployee"));
		$this->page->assign("viewlisting",$this->request->createURL("Listing", "viewList"));
		$this->page->assign("listing",$this->request->createURL("Listing", "addListing"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("edit",$this->request->createURL("Employee", "Edit","ID"));
		$this->page->assign("edit_url",$this->request->createURL("Employee", "Edit","ID"));
    	$this->page->assign("delete",$this->request->createURL("Employee", "delete","ID"));  
		$res1=$this->employeeFacade->fetchClassificationDetails();
		$this->page->assign("values2",$res1);
		$res=$this->employeeFacade->fetchTownDetails();
		$this->page->assign("values",$res);
		$regionValue=$this->SalesAccountManagerFacade->fetchRegion();
		$this->page->assign("regionValue",$regionValue);
        $res3=$this->employeeFacade->editListingFetchDetails();
        $this->page->assign("values12",$res3[0]);
		$this->page->getPage('editlisting.tpl');
    }	  
	
	 public function editAddition()
    {
        $this->page->assign("login_url",$this->request->createURL("Admin", "login"));
        $this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
        $this->page->assign("back",$this->request->createURL("Admin", "showhomePageEmployee"));
		$this->page->assign("delete",$this->request->createURL("Listing", "delete","ID"));
		$this->page->assign("listing",$this->request->createURL("Listing", "addListing")); 
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("viewlisting",$this->request->createURL("Listing", "viewList"));
		$this->page->assign("edit",$this->request->createURL("Employee", "Edit","ID")); 
		$this->page->assign("edit_url",$this->request->createURL("Employee", "Edit","ID"));
		$this->page->assign("delete",$this->request->createURL("Employee", "delete","ID"));
		$image=$_FILES['logo']['name'];
		$tmp=$_FILES['logo']['tmp_name'];
				

		move_uploaded_file($tmp,"View/Default/Images/client_image/$image");
        $this->employeeFacade->editListing($_POST,$_FILES);
		if($res['result'])
		{
        $this->request->setAttribute("message-succ", $res['message']);
		$this->Edit();
		}else{
		$this->request->setAttribute("message", $res['message']);
		$this->Edit();
		}
        /*$res1=$this->employeeFacade->fetchDetails($_POST);
        $this->page->assign("values",$res1);
        $this->page->getPage('listshow.tpl');*/
     }
	 
	 
	 public function delete()
    {
        $this->page->assign("login_url",$this->request->createURL("Admin", "login"));
        $this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
        $this->page->assign("back",$this->request->createURL("Admin", "showhomePageEmployee"));
		$this->page->assign("listing",$this->request->createURL("Listing", "addListing"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs")); 
		$this->page->assign("viewlisting",$this->request->createURL("Listing", "viewList"));
		$this->page->assign("edit",$this->request->createURL("Employee", "Edit","ID")); 
	//	$this->page->assign("edit_url",$this->request->createURL("Employee", "Edit","ID"));
	//	$this->page->assign("delete",$this->request->createURL("Employee", "delete","ID"));
	    $this->page->assign("edit_url", "javascript:window.location='".$this->request->createURL("Employee", "Edit", "name={$this->request->getAttribute('name')}&state={$this->request->getAttribute('state')}"));
		$this->page->assign("delete","javascript:window.location='".$this->request->createURL("Employee", "delete", "name={$this->request->getAttribute('name')}&state={$this->request->getAttribute('state')}&ID")); 
	 
		$this->employeeFacade->delList($_GET);
		$result = $this->employeeFacade->searchBusiness($_GET, $this->request->getAttribute("fr"));
		$this->page->assign("values",$result['listings']);
		$this->page->assign("paging", $result['paging']);
       // $res4 = $this->employeeFacade->fetchDetails($_POST);
		//$this->page->assign("values",$res4);
        $this->page->getPage('listshow.tpl'); 
    }
	
	
	
	
	
	
	
	
	
	
	public function edituser()
    {
        $this->page->assign("login_url",$this->request->createURL("Admin", "login"));
        $this->page->assign("action",$this->request->createURL("SalesAccountManager", "editAdditionuser","ID"));
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "edituser","ID")); 
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
		
		$this->page->assign("edit_url", "javascript:window.location='".$this->request->createURL("SalesAccountManager", "edituser", "name={$this->request->getAttribute('name')}&state={$this->request->getAttribute('state')}"));
		
		
		$this->page->assign("delete","javascript:window.location='".$this->request->createURL("SalesAccountManager", "deleteuser", "name={$this->request->getAttribute('name')}&state={$this->request->getAttribute('state')}&ID"));
		
		
        $res3 = $this->SalesAccountManagerFacade->editUser();
        $this->page->assign("values1",$res3);
        $this->page->getPage('edituser.tpl');
    }

 public function editAdditionuser()
    {
        $this->page->assign("login_url",$this->request->createURL("Admin", "login"));
        $this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "edituser","ID")); 
		$this->page->assign("delete",$this->request->createURL("SalesAccountManager", "deleteuser","ID"));
        $this->page->assign("back",$this->request->createURL("SalesAccountManager", "adminManager"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("searchemployee",$this->request->createURL("SalesAccountManager","searchEmployee"));
		$this->page->assign("addemployee",$this->request->createURL("SalesAccountManager","registrationAdd"));
		$this->page->assign("changePassword",$this->request->createURL("SalesAccountManager","changePassword"));
		$this->page->assign("edit_url", "javascript:window.location='".$this->request->createURL("SalesAccountManager", "edituser", "name={$this->request->getAttribute('name')}&state={$this->request->getAttribute('state')}"));
		$this->page->assign("delete","javascript:window.location='".$this->request->createURL("SalesAccountManager", "deleteuser", "name={$this->request->getAttribute('name')}&state={$this->request->getAttribute('state')}&ID"));
		$result		=$this->SalesAccountManagerFacade->editAdd($_POST);
		if($result['result'])
		{
        //$res1=$this->SalesAccountManagerFacade->fetchDetails($_GET,$_POST);
        //$this->page->assign("values",$res1);
        //$this->page->getPage('listshow.tpl');
		//}
		//else{
		//$this->request->redirect("SalesAccountManager","Edit","msg=1");
		$this->request->setAttribute("message-succ", $result['message']);
		$this->edituser();
		}else{
		$this->request->setAttribute("message", $result['message']);
		$this->edituser();
		}
       // $this->edituser();
		
        /*$res2 = $this->adminFacade->fetchUserDetails();
        $this->page->assign("values",$res2);*/
        //$this->page->getPage('teammanager.tpl');
    }

	
	
	
	
	
	
	
	 public function changePassword()
    {
		$this->page->assign("action",$this->request->createURL("SalesAccountManager", "changedPassword"));
		$this->page->assign("home",$this->request->createURL("SalesAccountManager", "showhomePageAffiliate"));
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "edit"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("change_password",$this->request->createURL("SalesAccountManager", "changePassword"));
		
		$this->page->getPage('change_password.tpl');
	}

	 public function changedPassword()
    {
	
		$oldPassword		= (!empty($_POST['oldPassword']))?$_POST['oldPassword']:NULL;
		
		
		$this->page->assign("oldPassword",$oldPassword);
		
		
		$this->page->assign("home",$this->request->createURL("Affiliate", "showhomePageAffiliate"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
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
			
      // $this->page->getPage('change_password.tpl');
    }
	
		public function getSuburb()
	{ 
		$result= $this->SalesAccountManagerFacade->getSuburb($_GET);
		echo "<option value='--Select One--'>"."--Select One--"."</option>";
		foreach ($result as $value)
		{
		
		echo "<option value='".$value['shiretown_postcode'].",".$value['shiretown_townname']."'>".$value['shiretown_townname']."</option>";
		}
	
	}
}
?>