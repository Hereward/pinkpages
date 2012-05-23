<?php
class AdminListingControl extends MainControl {

    private $adminlistingFacade;

    public function __construct($request)
    {

        $this->adminlistingFacade = new AdminListingFacade($GLOBALS['conn'], $request);
        $this->page = new AdminPage();
        parent::__construct($request);

    }/* END __construct */
	
	/**
     *  viewList
     *
     *  Get the Listings from table local_businesses
     */
    /*public function viewList()
    {
	  $this->page->pageTitle = "Listings";
	     $this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
        $this->page->assign("action",$this->request->createURL("AdminListing", "listingAddition"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists"));  
		$this->page->assign("edit_classification",$this->request->createURL("AdminListing", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("AdminListing", "rankBusiness"));		
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		 $this->page->assign("searchlists",$this->request->createURL("AdminListing","search"));    
        $this->page->assign("back",$this->request->createURL("Business", "showhomePageBusiness"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
        $this->page->assign("login_url",$this->request->createURL("Business", "login"));
        $this->page->assign("logout_url",$this->request->createURL("Business", "doLogout"));
        $this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit"));
        $this->page->assign("delete",$this->request->createURL("AdminListing", "delete","businessname={$this->request->getAttribute('businessname')}&fr={$this->request->getAttribute("fr")}&ID"));
        $this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing", "addListing"));
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
     //   $this->page->assign("edit",$this->request->createURL("Business", "Edit","ID"));
	    $this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
        $res1=$this->adminlistingFacade->viewfetchDetails($this->request->getAttribute("fr"));//prexit($res1['listings']);
		$this->page->assign("values",$res1['listings']);
		$this->page->assign("paging", $res1['paging']);
        $this->page->getPage("listshow.tpl");
    }/* END viewList*/
    
	/**
     *  addListing
     *
     *  This function displays the template form for addition of listing.
     */
	public function addListing()
    {   
	   $this->page->pageTitle = "Add listing";
	     $this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
        $this->page->assign("login_url",$this->request->createURL("Business", "login"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists"));  
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));		
        $this->page->assign("logout_url",$this->request->createURL("Business", "doLogout"));
		 $this->page->assign("searchlists",$this->request->createURL("AdminListing","search"));    
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
        $this->page->assign("action",$this->request->createURL("AdminListing", "listingAddition"));
        $this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
        $this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing", "addListing"));
        $this->page->assign("back",$this->request->createURL("Business", "showhomePageBusiness"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
       // $this->page->assign("edit",$this->request->createURL("Business", "Edit","ID"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
        $res1=$this->adminlistingFacade->fetchClassificationDetails();
        $this->page->assign("values1",$res1);
        $res=$this->adminlistingFacade->fetchTownDetails();
        $this->page->assign("values",$res);
        $res2=$this->adminlistingFacade->selectStates();
        $this->page->assign("values2",$res2);
        $this->page->getPage('listingadd.tpl');
    }/* END addListing */
	 
	/**
     *  listingAddition
     *
     *  The actual function performing the addition functionality by calling addList() in facade
     */ 
    public function listingAddition()
    {      
	     $this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
		$this->page->assign("login_url",$this->request->createURL("Business", "login"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists"));  
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));		
		$this->page->assign("logout_url",$this->request->createURL("Business", "doLogout"));
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		 $this->page->assign("searchlists",$this->request->createURL("AdminListing","search"));    
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("edit_url",$this->request->createURL("AdminListing", "Edit"));
		$this->page->assign("delete",$this->request->createURL("AdminListing", "delete","ID"));
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing", "addListing"));
	//	$this->page->assign("edit",$this->request->createURL("Business", "Edit","ID"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$image=$_FILES['logo']['name'];
		$tmp=$_FILES['logo']['tmp_name'];
	
		move_uploaded_file($tmp,"View/Default/Images/$image");
		$res=$this->adminlistingFacade->addlist($_POST,$_FILES);
		
		if($res['result'])
		{
			$res1=$this->adminlistingFacade->fetchDetails($_POST);
			$this->page->assign("values",$res1);
			$this->page->getPage("listshow.tpl");
		}
		else{
			$this->request->setAttribute("message", $res['message']);
			$this->addListing();}
	
	}/* END listingAddition */
    
	
	public function addClassification()
		{
		$this->page->pageTitle = "Add Classification";
		$this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
		$this->page->assign("msg",@$_GET['msg']);
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists"));
		$classificationList=$this->adminlistingFacade->fetchClassificationDetails();
		//pre($classificationList);
		
		$classificationListResult=$this->adminlistingFacade->classificationList($_GET);
		//pre($classificationListResult);
		$result = array_diff_assoc($classificationList, $classificationListResult);
		//var_dump($result);
		$this->page->assign("classificationList",$result);
		$this->page->assign("classificationListResult",$classificationListResult);
		$this->page->assign("action",$this->request->createURL("AdminListing", "addClassificationDetail","ID"));
		$this->page->assign("deleteAction",$this->request->createURL("AdminListing", "deleteClassification","ID"));
		$this->page->assign("businessRank",$this->request->createURL("AdminListing", "rankBusiness","ID"));
		$this->page->getPage('add_classification.tpl');
		}
		
		public function addClassificationDetail()
		{
		$this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
		$this->page->assign("msg",@$_GET['msg']);
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists"));
		$classificationList=$this->adminlistingFacade->fetchClassificationDetails();
		$this->page->assign("classificationList",$classificationList);
		
		$classificationAddResult	=$this->adminlistingFacade->addClassificationDetail($_POST,$_GET);
		
			if($classificationAddResult['result'])
			{	
				$this->request->redirect("AdminListing","addClassification","ID={$classificationAddResult['ID']}&msg=2");
			}
		
		$this->page->getPage('add_classification.tpl');		
		}
		
		public function deleteClassification()
		{
		$this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
		$this->page->assign("msg",@$_GET['msg']);
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists"));
			$classificationDelResult	=$this->adminlistingFacade->deleteClassification($_POST,$_GET);
		
			if($classificationDelResult['result'])
			{	
				$this->request->redirect("AdminListing","addClassification","ID={$classificationDelResult['ID']}&msg=3");
			}
		
		}
		
		public function rankBusiness()
		{
		$this->page->pageTitle = "Rank Business";
		$this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
		$this->page->assign("msg",@$_GET['msg']);
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists"));
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
		
		$rankResult=$this->adminlistingFacade->rankDetails($_GET);
		$this->page->assign("rankResult",$rankResult);
		
		
		$classificationListResult=$this->adminlistingFacade->classificationList($_GET);
		$array1 = array(array("localclassification_id" => "", "localclassification_name" => ""));
		$finalResult1=array_merge($array1,$classificationListResult);		
		$this->page->assign("classificationListResult",$finalResult1);

		$regionValue=$this->adminlistingFacade->fetchRegion();
		$array2 = array(array("shirename_id" => "", "shirename_shirename" => "", "shirename_state" => ""));
		$finalResult2=array_merge($array2,$regionValue);		
		$this->page->assign("regionValue",$finalResult2);
		$this->page->assign("action",$this->request->createURL("AdminListing", "addRank","ID"));
		$this->page->getPage('add_business_rank.tpl');
		}
		
		public function addRank()
		{
		$this->page->pageTitle = "Rank Business";
		$this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
		$this->page->assign("msg",@$_GET['msg']);
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("edit_url",$this->request->createURL("SalesAccountManager", "Edit"));
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists"));
		$addRankResult	=$this->adminlistingFacade->addRank($_POST,$_GET);
		

			if($addRankResult['result'])
			{	
				$this->request->redirect("AdminListing","rankBusiness","ID={$addRankResult['ID']}&msg=4");
			}else{
				$this->request->setAttribute("message", $addRankResult['message']);
				$this->rankBusiness();		
			}

		}
	
	
	
	
	/**
     *  Edit
     *
     *  This function displays the template form with previous values for editing
     */ 
    public function Edit()
    {
	    $this->page->pageTitle = "Edit listing";
	     $this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
        $this->page->assign("login_url",$this->request->createURL("Business", "login"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists"));  
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));		
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
        $this->page->assign("action",$this->request->createURL("AdminListing", "editAdd","ID"));
		 $this->page->assign("searchlists",$this->request->createURL("AdminListing","search"));    
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
        $this->page->assign("logout_url",$this->request->createURL("Business", "doLogout"));
        $this->page->assign("back",$this->request->createURL("Business", "showhomePageBusiness"));
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing", "addListing"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		//$this->page->assign("edit",$this->request->createURL("Business", "Edit","ID"));
		$this->page->assign("edit_url",$this->request->createURL("AdminListing", "Edit"));
    	$this->page->assign("delete",$this->request->createURL("AdminListing", "delete","businessname={$this->request->getAttribute('businessname')}&fr={$this->request->getAttribute("fr")}&ID")); 
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness")); 
		$res3 = $this->adminlistingFacade->editListingFetchDetails();
        $this->page->assign("values12",$res3);
		$res1=$this->adminlistingFacade->fetchClassificationDetails();
		$this->page->assign("values2",$res1);
		$regionValue=$this->adminlistingFacade->fetchRegion();
		$this->page->assign("regionValue",$regionValue);
		$res=$this->adminlistingFacade->fetchTownDetails();
		$this->page->assign("values",$res);
        $res2=$this->adminlistingFacade->selectStates();
        $this->page->assign("values21",$res2);
        $this->page->getPage('editlisting.tpl');
    }/* END Edit */
	 
	/**
     *  editAddition
     *
     *  This function performs the actual editing operation
     */  
    public function editAdd()
    {
	     $this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
        $this->page->assign("login_url",$this->request->createURL("Business", "login"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists")); 
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));		 
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		 $this->page->assign("searchlists",$this->request->createURL("AdminListing","search"));    
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
        $this->page->assign("logout_url",$this->request->createURL("Business", "doLogout"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
        $this->page->assign("back",$this->request->createURL("Business", "showhomePageBusiness"));
       	$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
        $this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing", "addListing"));
        $this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
        $this->page->assign("edit_url",$this->request->createURL("AdminListing", "Edit"));
        $this->page->assign("delete",$this->request->createURL("AdminListing", "delete","businessname={$this->request->getAttribute('businessname')}&fr={$this->request->getAttribute("fr")}&ID"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		
		$image=$_FILES['logo']['name'];
        $tmp=$_FILES['logo']['tmp_name'];
				

		move_uploaded_file($tmp,"View/Default/Images/client_image/$image");
        $result=$this->adminlistingFacade->editListing($_POST,$_FILES);
		if($result['result'])
		{
        $this->request->setAttribute("message-succ", $result['message']);
		$this->Edit();
		}else{
		$this->request->setAttribute("message", $result['message']);
		$this->Edit();
		}
      }/* END editAddition */
	
	/**
     *  delete
     *
     *  This function performs the actual deleting operation
     */   
    public function delete()
    {
	     $this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
        $this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		 $this->page->assign("searchlists",$this->request->createURL("AdminListing","search"));  
		 $this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists"));  
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));		  
        $this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
        $this->page->assign("back",$this->request->createURL("Admin", "showhomePageAdmin"));
        $this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing", "addListing"));
        $this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
        //$this->page->assign("edit",$this->request->createURL("Business", "Edit","ID"));
		$this->page->assign("edit_url",$this->request->createURL("AdminListing", "Edit"));
        $this->page->assign("delete",$this->request->createURL("AdminListing", "delete","businessname={$this->request->getAttribute('businessname')}&fr={$this->request->getAttribute("fr")}&ID"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
        $result=$this->adminlistingFacade->delList($_GET);
		if($result['result'])
		{
        $this->request->setAttribute("message-succ", $result['message']);
		$result=$this->adminlistingFacade->searchList($_GET,$this->request->getAttribute("fr"));
		$this->page->assign("values",$result['listings']);
		$this->page->assign("paging", $result['paging']);
		$this->page->getpage('listshow.tpl');
		}else{
		$this->request->setAttribute("message", $result['message']);
		$this->viewList();
		}
			
        /*$res4 = $this->adminlistingFacade->fetchDetails($_POST);
        $this->page->assign("values",$res4);
        $this->page->getPage('listshow.tpl');*/
    }
    
    
public function import_class_relationships()
	{   
	    $this->page->pageTitle = "Import Listings";
	    $this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
	    $this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("action",$this->request->createURL("AdminListing","csvFileUpload"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists")); 
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));		 
		 $this->page->assign("searchlists",$this->request->createURL("AdminListing","search"));    
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
        $this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
        $this->page->assign("back",$this->request->createURL("Admin", "showhomePageAdmin"));
        $this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing", "addListing"));
        $this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
       // $this->page->assign("edit",$this->request->createURL("Business", "Edit","ID"));
		$this->page->assign("edit_url",$this->request->createURL("AdminListing", "Edit"));
        $this->page->assign("delete",$this->request->createURL("AdminListing", "delete","businessname={$this->request->getAttribute('businessname')}&fr={$this->request->getAttribute("fr")}&ID"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
	    $this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
	    $this->page->assign("class_relationships",$this->request->createURL("AdminListing","class_relationships"));
	    $this->page->assign("import_class_relationships",$this->request->createURL("AdminListing","class_relationships_import_page"));
	    $this->page->assign("import_class_relationships_action",$this->request->createURL("AdminListing","import_class_relationships"));
		$res=$this->adminlistingFacade->class_relationships_upload($_FILES['csvfile']['name']);
	    $this->page->getPage("import_class_relationships.tpl");
	}
	
   public function class_relationships_import_page()
	{   
	    $this->page->pageTitle = "Import Listings";
	    $this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
	    $this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("action",$this->request->createURL("AdminListing","csvFileUpload"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists")); 
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));		 
		 $this->page->assign("searchlists",$this->request->createURL("AdminListing","search"));    
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
        $this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
        $this->page->assign("back",$this->request->createURL("Admin", "showhomePageAdmin"));
        $this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing", "addListing"));
        $this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
       // $this->page->assign("edit",$this->request->createURL("Business", "Edit","ID"));
		$this->page->assign("edit_url",$this->request->createURL("AdminListing", "Edit"));
        $this->page->assign("delete",$this->request->createURL("AdminListing", "delete","businessname={$this->request->getAttribute('businessname')}&fr={$this->request->getAttribute("fr")}&ID"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
	    $this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
	    $this->page->assign("class_relationships",$this->request->createURL("AdminListing","class_relationships"));
	    $this->page->assign("import_class_relationships",$this->request->createURL("AdminListing","class_relationships_import_page"));
	    $this->page->assign("import_class_relationships_action",$this->request->createURL("AdminListing","import_class_relationships"));
	    $this->page->assign("export_class_relationships_action",$this->request->createURL("AdminListing","export_class_relationships"));
		$this->page->getPage("import_class_relationships.tpl");
	}
	
public function import_url_alias()
	{   
	    $this->page->pageTitle = "Import Listings";
	    $this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
	    $this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("action",$this->request->createURL("AdminListing","csvFileUpload"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists")); 
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));		 
		 $this->page->assign("searchlists",$this->request->createURL("AdminListing","search"));    
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
        $this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
        $this->page->assign("back",$this->request->createURL("Admin", "showhomePageAdmin"));
        $this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing", "addListing"));
        $this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
       // $this->page->assign("edit",$this->request->createURL("Business", "Edit","ID"));
		$this->page->assign("edit_url",$this->request->createURL("AdminListing", "Edit"));
        $this->page->assign("delete",$this->request->createURL("AdminListing", "delete","businessname={$this->request->getAttribute('businessname')}&fr={$this->request->getAttribute("fr")}&ID"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
	    $this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
	    $this->page->assign("url_alias",$this->request->createURL("AdminListing","url_alias"));
	    $this->page->assign("import_url_alias",$this->request->createURL("AdminListing","url_alias_import_page"));
	    $this->page->assign("import_url_alias_action",$this->request->createURL("AdminListing","import_url_alias"));
		$res=$this->adminlistingFacade->url_alias_upload($_FILES['csvfile']['name']);
	    $this->page->getPage("import_url_alias.tpl");
	}
	
public function url_alias_import_page()
	{   
	    $this->page->pageTitle = "Import Listings";
	    $this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
	    $this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("action",$this->request->createURL("AdminListing","csvFileUpload"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists")); 
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));		 
		 $this->page->assign("searchlists",$this->request->createURL("AdminListing","search"));    
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
        $this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
        $this->page->assign("back",$this->request->createURL("Admin", "showhomePageAdmin"));
        $this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing", "addListing"));
        $this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
       // $this->page->assign("edit",$this->request->createURL("Business", "Edit","ID"));
		$this->page->assign("edit_url",$this->request->createURL("AdminListing", "Edit"));
        $this->page->assign("delete",$this->request->createURL("AdminListing", "delete","businessname={$this->request->getAttribute('businessname')}&fr={$this->request->getAttribute("fr")}&ID"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
	    $this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
	    $this->page->assign("url_alias",$this->request->createURL("AdminListing","url_alias"));
	    $this->page->assign("import_url_alias",$this->request->createURL("AdminListing","url_alias_import_page"));
	    $this->page->assign("import_url_alias_action",$this->request->createURL("AdminListing","import_url_alias"));
	    $this->page->assign("export_url_alias_action",$this->request->createURL("AdminListing","export_url_alias"));
		$this->page->getPage("import_url_alias.tpl");
	}
    
    
 public function export_class_relationships()
	{   
	    $this->page->pageTitle = "Import Listings";
	    $this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
	    $this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("action",$this->request->createURL("AdminListing","csvFileUpload"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists")); 
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));		 
		 $this->page->assign("searchlists",$this->request->createURL("AdminListing","search"));    
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
        $this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
        $this->page->assign("back",$this->request->createURL("Admin", "showhomePageAdmin"));
        $this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing", "addListing"));
        $this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
       // $this->page->assign("edit",$this->request->createURL("Business", "Edit","ID"));
		$this->page->assign("edit_url",$this->request->createURL("AdminListing", "Edit"));
        $this->page->assign("delete",$this->request->createURL("AdminListing", "delete","businessname={$this->request->getAttribute('businessname')}&fr={$this->request->getAttribute("fr")}&ID"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
	    $this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
	    $this->page->assign("class_relationships",$this->request->createURL("AdminListing","class_relationships"));
	    $this->page->assign("export_class_relationships_action",$this->request->createURL("AdminListing","export_class_relationships"));
	    $this->page->assign("import_class_relationships",$this->request->createURL("AdminListing","class_relationships_import_page"));
		$res=$this->adminlistingFacade->export_class_relationships();
	    $this->page->getPage("class_relationships.tpl");
	}
	
   public function class_relationships()
	{   
	    $this->page->pageTitle = "Import Listings";
	    $this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
	    $this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("action",$this->request->createURL("AdminListing","csvFileUpload"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists")); 
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));		 
		 $this->page->assign("searchlists",$this->request->createURL("AdminListing","search"));    
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
        $this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
        $this->page->assign("back",$this->request->createURL("Admin", "showhomePageAdmin"));
        $this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing", "addListing"));
        $this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
       // $this->page->assign("edit",$this->request->createURL("Business", "Edit","ID"));
		$this->page->assign("edit_url",$this->request->createURL("AdminListing", "Edit"));
        $this->page->assign("delete",$this->request->createURL("AdminListing", "delete","businessname={$this->request->getAttribute('businessname')}&fr={$this->request->getAttribute("fr")}&ID"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
	    $this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
	    $this->page->assign("class_relationships",$this->request->createURL("AdminListing","class_relationships"));
	    $this->page->assign("export_class_relationships_action",$this->request->createURL("AdminListing","export_class_relationships"));
	    $this->page->assign("import_class_relationships",$this->request->createURL("AdminListing","class_relationships_import_page"));
		$this->page->getPage("class_relationships.tpl");
	}
	
	public function csvFormShow()
	{   
	    $this->page->pageTitle = "Import Listings";
	    $this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
	    $this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("action",$this->request->createURL("AdminListing","csvFileUpload"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists")); 
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));		 
		 $this->page->assign("searchlists",$this->request->createURL("AdminListing","search"));    
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
        $this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
        $this->page->assign("back",$this->request->createURL("Admin", "showhomePageAdmin"));
        $this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing", "addListing"));
        $this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
       // $this->page->assign("edit",$this->request->createURL("Business", "Edit","ID"));
		$this->page->assign("edit_url",$this->request->createURL("AdminListing", "Edit"));
        $this->page->assign("delete",$this->request->createURL("AdminListing", "delete","businessname={$this->request->getAttribute('businessname')}&fr={$this->request->getAttribute("fr")}&ID"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
	    $this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
	    $this->page->assign("class_relationships",$this->request->createURL("AdminListing","class_relationships"));
	    $this->page->assign("import_class_relationships",$this->request->createURL("AdminListing","class_relationships_import_page"));
	    $this->page->assign("import_url_alias",$this->request->createURL("AdminListing","url_alias_import_page"));
		$this->page->getPage("csv_upload_form.tpl");
	}
	
	public function csvFileUpload()
	{
	    $arr = array();
		$this->page->pageTitle = "Free Listing Upload";
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
		$this->page->assign("action",$this->request->createURL("AdminListing","import"));
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
	    $this->page->assign("import_class_relationships",$this->request->createURL("AdminListing","class_relationships_import_page"));
	   
	    $res=$this->adminlistingFacade->csvFileUpload($_FILES['csvfile']['name']);
	    
	   // $viewlog = $this->adminlistingFacade->viewlog('/home/sydneypink/bkup/NSW_20120411.csv');
		//$report[] = count($viewlog);
	    //$res = $this->adminlistingFacade->insertCSV($viewlog);
		
		
	    $this->page->assign("values",$res);
	    $this->page->getPage("csv_report.tpl");
	}

	public function import()
	 {  
	    $this->page->pageTitle = "Listings";
	    $this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
	    $this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("searchlists",$this->request->createURL("AdminListing","search"));    	
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists")); 
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));		 
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));	  
	    $this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
	
	    $val=$this->adminlistingFacade->importCSV(getSession("file"));					
		
		if($val['result'])
		{ 
		  $this->request->setAttribute("message-succ", $val['message']);
		  $this->csvFormShow();
		  /*$res=$this->adminlistingFacade->viewlog(getSession("file"));
		  $this->page->assign("values",$res);
		  $this->page->getPage("csv_display.tpl");*/
		
		}
		else
		{
		  $this->request->setAttribute("message", $val['message']);
		  $res=$this->adminlistingFacade->viewlog(getSession("file"));
		  $this->page->assign("values",$res);
		  $this->page->getPage("csv_display.tpl");
		}
	 }
	 
	 public function search()
	 {
	 $this->page->pageTitle = "Search listing";
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
	    $this->page->assign("action",$this->request->createURL("AdminListing","searchList"));
	  $this->page->getPage("listings_search_form.tpl");
	  
	 }
	 
	 public function searchList()
	 {
	  $this->page->assign("do",$_GET['do']);
	  $this->page->assign("action1",$_GET['action']); 
	  $this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("searchFreeListing",$this->request->createURL("SalesAccountManager", "searchFreeListing"));
		$this->page->assign("searchfreeLists",$this->request->createURL("SalesAccountManager","searchfreeLists")); 
		$this->page->assign("edit_classification",$this->request->createURL("SalesAccountManager", "addClassification"));
		$this->page->assign("edit_rank",$this->request->createURL("SalesAccountManager", "rankBusiness"));		 
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		 $this->page->assign("searchlists",$this->request->createURL("AdminListing","search"));    
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
		$retArr=$this->adminlistingFacade->validatesearch($_GET);
		if($retArr['result'])
		{
		  $result=$this->adminlistingFacade->searchList($_GET,$this->request->getAttribute("fr"));
		  $this->page->assign("values",$result['listings']);
		  $this->page->assign("paging", $result['paging']);
		  $this->page->getpage('listshow.tpl');
        }
	   else
		{
		 $this->request->setAttribute("message", $retArr['message']);
		 $this->search();
		}
	 }
	 
	 
	 public function getSuburb()
	{ 
		$result= $this->adminlistingFacade->getSuburb($_GET);
		echo "<option value='--Select One--'>"."--Select One--"."</option>";
		foreach ($result as $value)
		{
		
		echo "<option value='".$value['shiretown_postcode'].",".$value['shiretown_townname']."'>".$value['shiretown_townname']."</option>";
		}
	
	}
	
}
?>