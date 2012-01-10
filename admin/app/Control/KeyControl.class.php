<?php
class KeyControl extends MainControl
{

    private $keyFacade;                           //A private variable that will be used as object for AdminFacade class.
   public function __construct($request)
    {

        $this->keyFacade = new KeyFacade($GLOBALS['conn'], $request);
        $this->page = new AdminPage();
        parent::__construct($request);

    }/* END __construct */
	
 public function addListing()
    {
     $this->page->pageTitle = "Add synonym";
	 $this->page->assign("do",$_GET['do']);
	 $this->page->assign("action1",$_GET['action']);	 
	 $classification					= (!empty($_POST['name']))?$_POST['name']:NULL;				
	 $this->page->assign("classification",$classification);
		
     $this->page->assign("login_url",$this->request->createURL("Business", "login"));
	 $this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
	 $this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
     $this->page->assign("logout_url",$this->request->createURL("Business", "doLogout"));
	 $this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
	 $this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
	 $this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
     $this->page->assign("action",$this->request->createURL("Key", "listingAddition"));
     $this->page->assign("view",$this->request->createURL("Key", "viewList"));
     $this->page->assign("key",$this->request->createURL("Key", "addListing"));
     $this->page->assign("back",$this->request->createURL("Business", "showhomePageBusiness"));
     $this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
	 $this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
     $res1=$this->keyFacade->fetchClassificationDetails();
     $this->page->assign("values1",$res1);
	 $this->page->getPage("key_add.tpl");
	}	
	
	
	
 public function listingAddition()
    {      
	  $this->page->assign("login_url",$this->request->createURL("Business", "login"));
	  $this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
	  $this->page->assign("logout_url",$this->request->createURL("Business", "doLogout"));
	  $this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
	  $this->page->assign("edit_url",$this->request->createURL("Key", "editKeys"));
	  $this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
	  $this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
	  $this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
	  $this->page->assign("delete",$this->request->createURL("Key", "delete"));
	  $this->page->assign("view",$this->request->createURL("Key", "viewList"));
	  $this->page->assign("key",$this->request->createURL("Key", "addListing"));
	  $this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
	  $this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
	  $res=$this->keyFacade->addlist($_POST);
	  if($res['result'])
	  {
	    $this->request->setAttribute("message-succ", $res['message']);
		$this->addListing();
	  }
	  else
	  {
		$this->request->setAttribute("message", $res['message']);
		$this->addListing();
	  }
	
	}/* END listingAddition */	
	
 public function viewList()
    {
	    $this->page->pageTitle = "Synonyms";
	    $this->page->assign("do",$_GET['do']);
		$this->page->assign("isAdmin", AccessDetails::isAdmin(getSession('username')));
	    $this->page->assign("action1",$_GET['action']);
        $this->page->assign("action",$this->request->createURL("AdminListing", "listingAddition"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
        $this->page->assign("back",$this->request->createURL("Business", "showhomePageBusiness"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
        $this->page->assign("login_url",$this->request->createURL("Business", "login"));
        $this->page->assign("logout_url",$this->request->createURL("Business", "doLogout"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
        $this->page->assign("edit_url",$this->request->createURL("Key", "editKeys"));
        $this->page->assign("delete",$this->request->createURL("Key", "deleteKey"));
        $this->page->assign("key",$this->request->createURL("Key", "addListing"));
		$this->page->assign("view",$this->request->createURL("Key", "viewList"));
      	$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
        //$res1=$this->keyFacade->viewfetchDetails($this->request->getAttribute("fr"),$this->request->getAttribute("pg_size"));
		//$this->page->assign("values",  $res1['blogs']);
		//$this->page->assign("paging",  $res1['paging']);
		$this->page->assign("keywords", $this->keyFacade->fetchUniqueKeywords()); 
		$this->page->assign("classifications", $this->keyFacade->fetchClassificationDetails()); 		
		if(isset($_POST['keyword']) || isset($_GET['keyword'])){
		  $keyword = ($_POST['keyword']) ? $_POST['keyword'] : $_GET['keyword'];
		  $this->page->assign("classiByKeyword", $this->keyFacade->fetchClassificationFromKeyword($keyword)); 				
		  $this->page->assign("selectedKeyword", $keyword);		  
        }		  
		if(isset($_POST['classification']) || isset($_GET['classification'])){
		  $classification = ($_POST['classification']) ? $_POST['classification'] : isset($_GET['classification']);
		  $this->page->assign("keywordByClassi", $this->keyFacade->fetchKeywordFromClassification($classification)); 				
		  $this->page->assign("selectedClassification", $classification);		  
        }		  				
        $this->page->addCssStyle("synonyms_manager.css");		
	    $this->page->removeJsFile("prototype.1.6.js");
	    $this->page->addJsFile("jquery-1.3.2.min.js");
		$this->page->addJsFile("synonymmanager.js");
		
		if(isset($_GET['classification'])){
		  echo $this->page->getPage("keys_show.tpl");
		} else {
          echo $this->page->getPage("keys_show.tpl");
		}  
    }/* END viewList*/	
	
	/**
     *  loadAjax
     *
     *  Loads classifications
     */
	public function loadAjax() {

		$this->keyFacade->loadAjax($_GET);

	}/* END loadAjax */
			
 public function editKeys()
	{  
	  $this->page->pageTitle = "Edit synonyms";
	  $this->page->assign("login_url",$this->request->createURL("Admin", "login"));
	  $this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
	  $this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
	  $this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
	  $this->page->assign("BusinessManager_url",$this->request->createURL("SalesAccountManager", "addListing"));
	  $this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
	  $this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
	  $this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
	  $this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
	  $this->page->assign("key",$this->request->createURL("Key", "addListing"));
	  $this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
	  $this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
	  $this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
	  $this->page->assign("addKeyword",$this->request->createURL("Key","keywordFormShow"));
	  $this->page->assign("edit_url",$this->request->createURL("Key","editKeys"));
	  $this->page->assign("delete",$this->request->createURL("Key","deleteKeyword","ID"));
	  $this->keyFacade->editKeyword($_GET['ID'], $_GET['keyword']);
	}
  
	public function deleteKey()
	{
	  $this->page->assign("login_url",$this->request->createURL("Admin", "login"));
	  $this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
	  $this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
	  $this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
	  $this->page->assign("BusinessManager_url",$this->request->createURL("SalesAccountManager", "addListing"));
	  $this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
	  $this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
	  $this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
	  $this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
	  $this->page->assign("add",$this->request->createURL("Key", "addListing"));
	  $this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
	  $this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
	  $this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
	  $this->page->assign("edit_url",$this->request->createURL("Key","editKeys"));
	  $this->page->assign("delete",$this->request->createURL("Key","deleteKey","ID"));
	  $this->page->assign("addKeyword",$this->request->createURL("Key","addKeyword"));  
	  $result=$this->keyFacade->deleteKey();
	  if($result['result'])
	  { 
		$this->request->setAttribute("message-succ", $result['message']);
	    $this->viewList();
	  }
	  else
	  {
		$this->request->setAttribute("message", $result['message']);
		$this->viewList();
	  }
	}	
	
}
		
?>	