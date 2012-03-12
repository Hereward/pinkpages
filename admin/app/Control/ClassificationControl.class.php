<?php

/**
   * @title   ClassificationControl.class.php    
   * @desc    This is an SalesAccountManagerControl class. The purpose of this class is to perform the redirection actions needed for any function/operation to ClassificationFacade class and also to smarty assign the URL's which were used in the templates as an action, which redirects or calls the particular function passed in the action parameter in the ClassificationControl class. 
*/

class ClassificationControl extends MainControl
{

    private $classificationFacade;                           //A private variable that will be used as object for AdminFacade class.
	private $adminFacade;
    public function __construct($request)           //Start of The __contructor.purpose, to create objects for AdminFacade
    {                                               //and for AdminPage,used as main page to show all templates.
        parent::__construct($request);

        $this->classificationFacade = new ClassificationFacade($GLOBALS['conn']);
		$this->adminFacade          = new AdminFacade($GLOBALS['conn']);		
        $this->request = $request;
        $this->page = new AdminPage();
    }                                                //End of the constructor.
 
 
	/**
	*@desc This function is used for displaying the keywords.
	*/	 
	public function keywordFormShow()
	{
		$this->page->pageTitle = "Add classification";
		$this->page->assign("action1",$_GET['action']); 
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("searchClassification",$this->request->createURL("Classification", "searchClassification"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("BusinessManager_url",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing","addListing"));
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow")); 
		$this->page->assign("action",$this->request->createURL("Classification","addKeyword"));
		$this->page->assign("keyword",$this->request->createURL("Classification","viewKeyword"));
		$this->page->assign("keywordFormShow",$this->request->createURL("Classification","keywordFormShow"));
		$this->page->assign("importClassification",$this->request->createURL("Classification", "importClassification"));
		$this->page->assign("releaseDisplay",$this->request->createURL("Classification","releaseDisplay"));
		$this->page->assign("releaseClassification",$this->request->createURL("Classification","releaseClassification","ID"));
		$this->page->assign("searchSupressedClassification",$this->request->createURL("Classification","searchSupressedClassification"));
		$this->page->getPage("keyword_add_form.tpl");
  }	
  
  
  	/**
	*@desc This function is used for adding the keywords.
	*/	
	public function addKeyword()
	{
		$result=$this->classificationFacade->addKeywords($_POST);
		if($result['result'])
			{
			$this->request->setAttribute("message-succ", $result['message']);
			$this->viewKeyword();
			//$this->request->redirect("Classification","viewKeyword","msg=1");
			}else{
		$this->request->setAttribute("message", $result['message']);
		$this->keywordFormShow();
		//$this->request->redirect("Classification","viewKeyword","msg=2");
		}
	}

	/**
	*@desc This function is used for searching the classification.
	*/	  
  	public function searchClassification()
	{
		$this->page->pageTitle = "Search Classifications";
		$msg = (!empty($_GET['msg']))?$_GET['msg']:NULL;
		$this->page->assign("msg",$msg);
		$this->page->assign("action1",$_GET['action']);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("searchClassification",$this->request->createURL("Classification", "searchClassification"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("keywordFormShow",$this->request->createURL("Classification","keywordFormShow"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("BusinessManager_url",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing","addListing"));
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("addKeyword",$this->request->createURL("Classification","keywordFormShow"));
		$this->page->assign("edit_url",$this->request->createURL("Classification","editKeyword"));
		$this->page->assign("delete",$this->request->createURL("Classification","deleteKeyword","ID"));
		$this->page->assign("importClassification",$this->request->createURL("Classification", "importClassification"));
		$this->page->assign("keyword",$this->request->createURL("Classification","viewKeyword"));
		$this->page->assign("action",$this->request->createURL("Classification","fetchClassificationDetails"));
		$this->page->assign("importClassification",$this->request->createURL("Classification", "importClassification"));
		$this->page->assign("releaseDisplay",$this->request->createURL("Classification","releaseDisplay"));
		$this->page->assign("releaseClassification",$this->request->createURL("Classification","releaseClassification","ID"));
		$this->page->assign("searchSupressedClassification",$this->request->createURL("Classification","searchSupressedClassification"));
		$this->page->getPage("search_classification.tpl");
	}
	
	
	
	/**
	*@desc This function is used for searching the supressed classification.
	*/		
	public function searchSupressedClassification()
	{
		$this->page->pageTitle = "Search Suppressed Classifications";
		$msg = (!empty($_GET['msg']))?$_GET['msg']:NULL;
		$this->page->assign("msg",$msg);
		$this->page->assign("action1",$_GET['action']);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("searchClassification",$this->request->createURL("Classification", "searchClassification"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("keywordFormShow",$this->request->createURL("Classification","keywordFormShow"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("BusinessManager_url",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing","addListing"));
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("addKeyword",$this->request->createURL("Classification","keywordFormShow"));
		$this->page->assign("edit_url",$this->request->createURL("Classification","editKeyword"));
		$this->page->assign("delete",$this->request->createURL("Classification","deleteKeyword","ID"));
		$this->page->assign("importClassification",$this->request->createURL("Classification", "importClassification"));
		$this->page->assign("keyword",$this->request->createURL("Classification","viewKeyword"));
		$this->page->assign("action",$this->request->createURL("Classification","fetchSupressClassificationDetails"));
		$this->page->assign("importClassification",$this->request->createURL("Classification", "importClassification"));
		$this->page->assign("releaseDisplay",$this->request->createURL("Classification","releaseDisplay"));
		$this->page->assign("releaseClassification",$this->request->createURL("Classification","releaseClassification","ID"));
		$this->page->assign("searchSupressedClassification",$this->request->createURL("Classification","searchSupressedClassification"));
		$this->page->getPage("search_supressed_classification.tpl");
	}
	
	
	/**
	*@desc This function is used for view the details of classification.
	*/		
	public function fetchClassificationDetails()
	{
		$this->page->pageTitle = "Search Classifications Result";
		$msg = (!empty($_GET['msg']))?$_GET['msg']:NULL;
		$this->page->assign("msg",$msg);
		$this->page->assign("action1",$_GET['action']);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("searchClassification",$this->request->createURL("Classification", "searchClassification"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("keywordFormShow",$this->request->createURL("Classification","keywordFormShow"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("BusinessManager_url",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing","addListing"));
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("addKeyword",$this->request->createURL("Classification","keywordFormShow"));
		$this->page->assign("edit_url",$this->request->createURL("Classification","editKeyword"));
		$this->page->assign("delete",$this->request->createURL("Classification","deleteKeyword","ID"));
		$this->page->assign("importClassification",$this->request->createURL("Classification", "importClassification"));
		$this->page->assign("keyword",$this->request->createURL("Classification","viewKeyword"));
		$this->page->assign("supressClassification",$this->request->createURL("Classification","supressClassification","ID"));
		$this->page->assign("importClassification",$this->request->createURL("Classification", "importClassification"));
		$this->page->assign("releaseDisplay",$this->request->createURL("Classification","releaseDisplay"));
		$this->page->assign("releaseClassification",$this->request->createURL("Classification","releaseClassification","ID"));
		$this->page->assign("searchSupressedClassification",$this->request->createURL("Classification","searchSupressedClassification"));
		$resultArray=$this->classificationFacade->__validateClassification($_GET);
		if($resultArray['result'])
		{
			$result = $this->classificationFacade->fetchClassificationDetails($_GET, $this->request->getAttribute("fr"));
			$this->page->assign("count",count($result['classification']));
			$this->page->assign("values",$result['classification']);
			$this->page->assign("paging", $result['paging']);
			$this->page->getpage('classification_search_result.tpl');
		}
		else
		{
		$this->request->setAttribute("message", $resultArray['message']);
		$this->searchClassification();
		
		}
	}
	
	


	/**
	*@desc This function is used for view the details of supressed classification.
	*/	
	public function fetchSupressClassificationDetails()
	{
		$this->page->pageTitle 		= "Search Supressed Classifications Result";
		$msg 						= (!empty($_GET['msg']))?$_GET['msg']:NULL;
		$this->page->assign("msg",$msg);
		$this->page->assign("action1",$_GET['action']);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("searchClassification",$this->request->createURL("Classification", "searchClassification"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("keywordFormShow",$this->request->createURL("Classification","keywordFormShow"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("BusinessManager_url",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing","addListing"));
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("addKeyword",$this->request->createURL("Classification","keywordFormShow"));
		$this->page->assign("edit_url",$this->request->createURL("Classification","editKeyword"));
		$this->page->assign("delete",$this->request->createURL("Classification","deleteKeyword","ID"));
		$this->page->assign("importClassification",$this->request->createURL("Classification", "importClassification"));
		$this->page->assign("keyword",$this->request->createURL("Classification","viewKeyword"));
		$this->page->assign("supressClassification",$this->request->createURL("Classification","supressClassification","ID"));
		$this->page->assign("importClassification",$this->request->createURL("Classification", "importClassification"));
		$this->page->assign("releaseDisplay",$this->request->createURL("Classification","releaseDisplay"));
		$this->page->assign("releaseClassification",$this->request->createURL("Classification","releaseClassification","ID"));
		$this->page->assign("searchSupressedClassification",$this->request->createURL("Classification","searchSupressedClassification"));
	//	$this->page->assign("searchSupressedClassification",$this->request->createURL("Classification","searchSupressedClassification"));
		$resultArray=$this->classificationFacade->__validateClassification($_GET);
		if($resultArray['result'])
		{
			$result = $this->classificationFacade->fetchSupressClassificationDetails($_GET, $this->request->getAttribute("fr"));
			$this->page->assign("count",count($result['classification']));
			$this->page->assign("values",$result['classification']);
			$this->page->assign("paging", $result['paging']);
			$this->page->getpage('supress_classification_search_result.tpl');
		}
		else
		{
		$this->request->setAttribute("message", $resultArray['message']);
		$this->searchSupressedClassification();
		}
	}
   
   
	/**
	*@desc This function is used for view the details of keyword.
	*/   
	public function viewKeyword()
	{
	   $this->page->pageTitle = "Classifications";
		$msg = (!empty($_GET['msg']))?$_GET['msg']:NULL;
		$this->page->assign("msg",$msg);
		$this->page->assign("action1",$_GET['action']);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("searchClassification",$this->request->createURL("Classification", "searchClassification"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("keywordFormShow",$this->request->createURL("Classification","keywordFormShow"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("BusinessManager_url",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing","addListing"));
		 $this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("addKeyword",$this->request->createURL("Classification","keywordFormShow"));
		$this->page->assign("edit_url",$this->request->createURL("Classification","editKeyword"));
		$this->page->assign("delete",$this->request->createURL("Classification","deleteKeyword","ID"));
		$this->page->assign("releaseClassification",$this->request->createURL("Classification","releaseClassification","ID"));
		$this->page->assign("supressClassification",$this->request->createURL("Classification","supressClassification","ID"));
		$this->page->assign("releaseDisplay",$this->request->createURL("Classification","releaseDisplay"));
		$this->page->assign("searchSupressedClassification",$this->request->createURL("Classification","searchSupressedClassification"));
		$this->page->assign("importClassification",$this->request->createURL("Classification", "importClassification"));
		$keywords=$this->classificationFacade->viewKeywords($this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"));
		$this->page->assign("values",$keywords['blogs']);
		$this->page->assign("paging",$keywords['paging']);
		$this->page->getPage("display_keywords.tpl");
	}


	/**
	*@desc This function is used for view the details of supressed classification.
	*/	
	public function releaseDisplay()
	{
		$this->page->pageTitle = "Release Classifications";
		$msg = (!empty($_GET['msg']))?$_GET['msg']:NULL;
		$this->page->assign("msg",$msg);
		$this->page->assign("action1",$_GET['action']);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("searchClassification",$this->request->createURL("Classification", "searchClassification"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("keywordFormShow",$this->request->createURL("Classification","keywordFormShow"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("BusinessManager_url",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing","addListing"));
		 $this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("addKeyword",$this->request->createURL("Classification","keywordFormShow"));
		$this->page->assign("edit_url",$this->request->createURL("Classification","editKeyword"));
		$this->page->assign("delete",$this->request->createURL("Classification","deleteKeyword","ID"));
		$this->page->assign("supressClassification",$this->request->createURL("Classification","supressClassification","ID"));
		$this->page->assign("releaseClassification",$this->request->createURL("Classification","releaseClassification","ID"));
		$this->page->assign("releaseDisplay",$this->request->createURL("Classification","releaseDisplay"));
		$this->page->assign("keyword",$this->request->createURL("Classification","viewKeyword"));
		$this->page->assign("releaseClassification",$this->request->createURL("Classification","releaseClassification","ID"));
		$this->page->assign("searchSupressedClassification",$this->request->createURL("Classification","searchSupressedClassification"));
		$this->page->assign("importClassification",$this->request->createURL("Classification", "importClassification"));
	
		$supressedClassification=$this->classificationFacade->viewSupressedClass($this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"));
		
		$this->page->assign("count",count($supressedClassification['blogs']));
		$this->page->assign("values",$supressedClassification['blogs']);
		$this->page->assign("paging",$supressedClassification['paging']);
		$this->page->getPage("release_classification_display.tpl");
	}


	/**
	*@desc This function is used for editing the details of keyword.
	*/
	public function editKeyword()
	{   
	   $this->page->pageTitle 			= "Edit classification";
	    $this->page->assign("action1",$_GET['action']);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("BusinessManager_url",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing","addListing"));
		 $this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("addKeyword",$this->request->createURL("Classification","keywordFormShow"));
		$this->page->assign("importClassification",$this->request->createURL("Classification", "importClassification"));		
		$this->page->assign("keywordFormShow",$this->request->createURL("Classification","keywordFormShow"));
		$this->page->assign("releaseClassification",$this->request->createURL("Classification","releaseClassification","ID"));
		$this->page->assign("releaseDisplay",$this->request->createURL("Classification","releaseDisplay"));
		$this->page->assign("searchSupressedClassification",$this->request->createURL("Classification","searchSupressedClassification"));
		$this->classificationFacade->editKeyword($_GET['ID'], $_GET['keyword']);
	}
 
 
	/**
	*@desc This function is used for deleting the keyword.
	*/  
	public function deleteKeyword()
	{   
	    $this->page->assign("action1",$_GET['action']);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("BusinessManager_url",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing","addListing"));
		 $this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("edit_url",$this->request->createURL("Classification","editKeyword"));
		$this->page->assign("delete",$this->request->createURL("Classification","deleteKeyword","ID"));
		$this->page->assign("addKeyword",$this->request->createURL("Classification","addKeyword")); 
		$this->page->assign("importClassification",$this->request->createURL("Classification", "importClassification"));		 
		$this->page->assign("keywordFormShow",$this->request->createURL("Classification","keywordFormShow"));
		$this->page->assign("releaseClassification",$this->request->createURL("Classification","releaseClassification","ID"));
		$this->page->assign("releaseDisplay",$this->request->createURL("Classification","releaseDisplay"));
		$this->page->assign("searchSupressedClassification",$this->request->createURL("Classification","searchSupressedClassification"));
		$result = $this->classificationFacade->deleteKeyword($_POST);
		$this->request->redirect("Classification","viewKeyword","msg={$result['message']}");
	}
	
	
	/**
	*@desc This function is used for importing the classification.
	*/	
	public function importClassification()
	{ 
		$this->page->pageTitle = "Upload classification";
		$msg = (!empty($_GET['msg']))?$_GET['msg']:NULL;
		$this->page->assign("msg",$msg);
		$this->page->assign("action1",$_GET['action']);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("searchClassification",$this->request->createURL("Classification", "searchClassification"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("keywordFormShow",$this->request->createURL("Classification","keywordFormShow"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("BusinessManager_url",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing","addListing"));
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("addKeyword",$this->request->createURL("Classification","keywordFormShow"));
		$this->page->assign("edit_url",$this->request->createURL("Classification","editKeyword"));
		$this->page->assign("delete",$this->request->createURL("Classification","deleteKeyword","ID"));
		$this->page->assign("releaseClassification",$this->request->createURL("Classification","releaseClassification","ID"));
		$this->page->assign("importClassification",$this->request->createURL("Classification", "importClassification"));
		$this->page->assign("keyword",$this->request->createURL("Classification","viewKeyword"));
		$this->page->assign("action",$this->request->createURL("Classification","fetchUploadedFile"));
		$this->page->assign("searchSupressedClassification",$this->request->createURL("Classification","searchSupressedClassification"));
		$this->page->assign("importClassification",$this->request->createURL("Classification", "importClassification"));
		$this->page->assign("releaseDisplay",$this->request->createURL("Classification","releaseDisplay"));
		$this->page->getPage("import_classification_file.tpl");
	}
	
	
	/**
	*@desc This function is used for fetching the uploaded file.
	*/	
	public function fetchUploadedFile()
	{
		$this->page->pageTitle 		= "Import classification";
		$msg 						= (!empty($_GET['msg']))?$_GET['msg']:NULL;
		$this->page->assign("msg",$msg);
		$this->page->assign("action1",$_GET['action']);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("searchClassification",$this->request->createURL("Classification", "searchClassification"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("keywordFormShow",$this->request->createURL("Classification","keywordFormShow"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("BusinessManager_url",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing","addListing"));
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("addKeyword",$this->request->createURL("Classification","keywordFormShow"));
		$this->page->assign("edit_url",$this->request->createURL("Classification","editKeyword"));
		$this->page->assign("delete",$this->request->createURL("Classification","deleteKeyword","ID"));
		$this->page->assign("releaseClassification",$this->request->createURL("Classification","releaseClassification","ID"));
		$this->page->assign("importClassification",$this->request->createURL("Classification", "importClassification"));
		$this->page->assign("keyword",$this->request->createURL("Classification","viewKeyword"));
		$this->page->assign("searchSupressedClassification",$this->request->createURL("Classification","searchSupressedClassification"));
		$this->page->assign("action",$this->request->createURL("Classification","importClassificationDetails"));
		$this->page->assign("releaseDisplay",$this->request->createURL("Classification","releaseDisplay"));
		$resultArray=$this->classificationFacade->csvFileUpload($_FILES);
		$this->page->assign("values",$resultArray);
		$this->page->getPage("classification_import_display.tpl");
	}
	
	
	/**
	*@desc This function is used for importing the classification details.
	*/	
	public function importClassificationDetails()
	{
		$this->page->pageTitle = "Import classification";
		$msg = (!empty($_GET['msg']))?$_GET['msg']:NULL;
		$this->page->assign("msg",$msg);
		$this->page->assign("action1",$_GET['action']);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("searchClassification",$this->request->createURL("Classification", "searchClassification"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("keywordFormShow",$this->request->createURL("Classification","keywordFormShow"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("BusinessManager_url",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing","addListing"));
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("addKeyword",$this->request->createURL("Classification","keywordFormShow"));
		$this->page->assign("edit_url",$this->request->createURL("Classification","editKeyword"));
		$this->page->assign("releaseClassification",$this->request->createURL("Classification","releaseClassification","ID"));
		$this->page->assign("delete",$this->request->createURL("Classification","deleteKeyword","ID"));
		$this->page->assign("importClassification",$this->request->createURL("Classification", "importClassification"));
		$this->page->assign("keyword",$this->request->createURL("Classification","viewKeyword"));
		$this->page->assign("searchSupressedClassification",$this->request->createURL("Classification","searchSupressedClassification"));
		$this->page->assign("releaseDisplay",$this->request->createURL("Classification","releaseDisplay"));
 		$val=$this->classificationFacade->importClassification(getSession("classificationFile"));
		
		if($val['result'])
		{ 
		  $this->request->setAttribute("message-succ", $val['message']);
		  $this->importClassification();
		  /*$res=$this->adminlistingFacade->viewlog(getSession("file"));
		  $this->page->assign("values",$res);
		  $this->page->getPage("csv_display.tpl");*/
		
		}
		else
		{
		  $this->request->setAttribute("message", $val['message']);
		  $res=$this->classificationFacade->viewlog(getSession("classificationFile"));
		  $this->page->assign("values",$res);
		  $this->page->getPage("classification_import_display.tpl");
		}
	}
	
	
	/**
	*@desc This function is used for displaying the supressed classifications list.
	*/	
	public function supressClassification()
	{
		$this->page->pageTitle = "Import classification";
		$msg = (!empty($_GET['msg']))?$_GET['msg']:NULL;
		$this->page->assign("msg",$msg);
		$this->page->assign("action1",$_GET['action']);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("searchClassification",$this->request->createURL("Classification", "searchClassification"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("keywordFormShow",$this->request->createURL("Classification","keywordFormShow"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("BusinessManager_url",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing","addListing"));
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("addKeyword",$this->request->createURL("Classification","keywordFormShow"));
		$this->page->assign("edit_url",$this->request->createURL("Classification","editKeyword"));
		$this->page->assign("delete",$this->request->createURL("Classification","deleteKeyword","ID"));
		$this->page->assign("importClassification",$this->request->createURL("Classification", "importClassification"));
		$this->page->assign("keyword",$this->request->createURL("Classification","viewKeyword"));
		$this->page->assign("searchSupressedClassification",$this->request->createURL("Classification","searchSupressedClassification"));
		$this->page->assign("releaseDisplay",$this->request->createURL("Classification","releaseDisplay"));
		$supressResult=$this->classificationFacade->supressClassification($_GET);
		if($supressResult['result'])
		{ 
		$this->request->setAttribute("message-succ", $supressResult['message']);
		$this->request->redirect("Classification","viewKeyword","msg=6");
	// 	$this->viewKeyword();
		}
	}
	
	
	/**
	*@desc This function is used for viewing the released classifications.
	*/	
	public function releaseClassification()
	{
		$this->page->pageTitle = "Import classification";
		$msg = (!empty($_GET['msg']))?$_GET['msg']:NULL;
		$this->page->assign("msg",$msg);
		$this->page->assign("action1",$_GET['action']);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("searchClassification",$this->request->createURL("Classification", "searchClassification"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("keywordFormShow",$this->request->createURL("Classification","keywordFormShow"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("BusinessManager_url",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing","addListing"));
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("addKeyword",$this->request->createURL("Classification","keywordFormShow"));
		$this->page->assign("edit_url",$this->request->createURL("Classification","editKeyword"));
		$this->page->assign("delete",$this->request->createURL("Classification","deleteKeyword","ID"));
		$this->page->assign("importClassification",$this->request->createURL("Classification", "importClassification"));
		$this->page->assign("releaseDisplay",$this->request->createURL("Classification","releaseDisplay"));
		$this->page->assign("searchSupressedClassification",$this->request->createURL("Classification","searchSupressedClassification"));
		$this->page->assign("keyword",$this->request->createURL("Classification","viewKeyword"));
		$supressResult=$this->classificationFacade->releaseClassification($_GET);
		if($supressResult['result'])
		{ 
		$this->request->setAttribute("message-succ", $supressResult['message']);
		$this->request->redirect("Classification","releaseDisplay","msg=7");
		}
	}
	
	public function regionReport() {
		
		$this->page->pageTitle 	= "Classification-Region Report";
		$do 					= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 				= (!empty($_GET['action']))?$_GET['action']:NULL;
		
		$this->page->assign("do",$do);
		$this->page->assign("action",$action);
		
		$this->page->assign("pagePopularityReport",$this->request->createURL("Admin","pagePopularityReport"));
		$this->page->assign("class_region_report",$this->request->createURL("Classification","regionReport"));
		$this->page->assign("class_region_monthly_total_report",$this->request->createURL("Classification","class_region_monthly_total_report"));
		$this->page->assign("ctr_report",$this->request->createURL("Classification","ctrReport"));		
		$this->page->assign("sitePerformanceReport",$this->request->createURL("Admin","sitePerformanceReport"));
		$this->page->assign("rankReport",$this->request->createURL("Admin","rankReport")); 
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
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
		$this->page->assign("class_region_report_action",$this->request->createURL("Classification","classRegionReport"));
		
		
		$this->page->assign("act",$_GET['action']);
		$this->page->addCssStyle("jquery-ui-1.7.1.custom.css");
		
		$this->page->removeJsFile("prototype.1.6.js");
		$this->page->addJsFile("jquery-1.3.2.min.js");
		$this->page->addJsFile("ui.core.js");
		$this->page->addJsFile("ui.datepicker.js");
		
		$this->page->getPage("class_region_report.tpl");
	}
	
/* Month Total Report */
public function class_region_monthly_total_report() {
		
		$this->page->pageTitle 	= "Classification-Region Monthly Total Report";
		$do 					= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 				= (!empty($_GET['action']))?$_GET['action']:NULL;
		
		$this->page->assign("do",$do);
		$this->page->assign("action",$action);
		
		$this->page->assign("pagePopularityReport",$this->request->createURL("Admin","pagePopularityReport"));
		$this->page->assign("class_region_report",$this->request->createURL("Classification","regionReport"));
		$this->page->assign("class_region_monthly_total_report",$this->request->createURL("Classification","class_region_monthly_total_report"));
		$this->page->assign("ctr_report",$this->request->createURL("Classification","ctrReport"));		
		$this->page->assign("sitePerformanceReport",$this->request->createURL("Admin","sitePerformanceReport"));
		$this->page->assign("rankReport",$this->request->createURL("Admin","rankReport")); 
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
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
		$this->page->assign("class_region_report_action",$this->request->createURL("Classification","classRegionTotalsReport"));
		
		
		$this->page->assign("act",$_GET['action']);
		$this->page->addCssStyle("jquery-ui-1.7.1.custom.css");
		
		$this->page->removeJsFile("prototype.1.6.js");
		$this->page->addJsFile("jquery-1.3.2.min.js");
		$this->page->addJsFile("ui.core.js");
		$this->page->addJsFile("ui.datepicker.js");
		
		$this->page->getPage("class_region_total_report.tpl");
	}
	
	
		public function ctrReport() {
		
		$this->page->pageTitle 	= "CTR Report";
		$do 					= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action 				= (!empty($_GET['action']))?$_GET['action']:NULL;
		
		$this->page->assign("do",$do);
		$this->page->assign("action",$action);
		
        $classifications = $this->adminFacade->fetchClassificationDetails();			
		$this->page->assign("classifications",$classifications);		
		$this->page->assign("pagePopularityReport",$this->request->createURL("Admin","pagePopularityReport"));
		$this->page->assign("class_region_report",$this->request->createURL("Classification","regionReport"));
		$this->page->assign("ctr_report",$this->request->createURL("Classification","ctrReport"));		
		$this->page->assign("sitePerformanceReport",$this->request->createURL("Admin","sitePerformanceReport"));
		$this->page->assign("rankReport",$this->request->createURL("Admin","rankReport")); 
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
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
		$this->page->assign("action",$this->request->createURL("Classification","processCTRReport"));
		$this->page->assign("action2",$this->request->createURL("Classification","processCompleteCTRReport"));		
		
		
		$this->page->assign("act",$_GET['action']);
		$this->page->addCssStyle("jquery-ui-1.7.1.custom.css");
		
		$this->page->removeJsFile("prototype.1.6.js");
		$this->page->addJsFile("jquery-1.3.2.min.js");
		$this->page->addJsFile("ui.core.js");
		$this->page->addJsFile("ui.datepicker.js");
		
		$this->page->getPage("ctr_report.tpl");
	}
	
	public function processCTRReport(){
	
	  $from_date       = $_POST['from_date'];
	  $to_date         = $_POST['to_date'];	
	  $classification  = $_POST['classification'];	
	  
	  //Generate Individual Classification Report
	  $this->classificationFacade->getCtrReport($from_date, $to_date, $classification);	  
			
	}
	
	public function processCompleteCTRReport(){
		  
	  //Generate Complete CTR Report
	  $reports = $this->classificationFacade->getCompleteCtrReport();	  		
	  $this->classificationFacade->outputCompleteCtrReport($reports);			
	}	
	
	public function classRegionReport() {
		$filter_google = FALSE;
		$from_date = $_POST['from_date'];
		$to_date = $_POST['to_date'];
	    if (array_key_exists('filter_google', $_POST)) {
			$filter_google = TRUE;
		}

		$this->classificationFacade->getClassificationRegionReport($from_date, $to_date, $filter_google);
	}
	
	public function classRegionTotalsReport() {
		$from_date = $_POST['from_date'];
		$to_date = $_POST['to_date'];
		$filter_google = FALSE;
		if (array_key_exists('filter_google', $_POST)) {
			$filter_google = TRUE;
		}
		//$filter_google = $_POST['filter_google'];

		$this->classificationFacade->getClassificationRegionTotalsReport($from_date, $to_date, $filter_google);
	}
}
?>