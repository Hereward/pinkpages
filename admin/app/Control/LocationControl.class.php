<?php
/**
   * @title   LocationControl.class.php    
   * @desc    This is an LocationControl class. The purpose of this class is to perform the redirection actions needed for any              function/operation to LOcationFacade class and also to smarty assign the URL's which were used in the templates as an              action, which redirects or calls the particular function passed in the action parameter in the LocationControl class. 
*/

class LocationControl extends MainControl
{

    private $locationFacade;                           //A private variable that will be used as object for AdminFacade class.
    public function __construct($request)           //Start of The __contructor.purpose, to create objects for AdminFacade
    {                                               //and for AdminPage,used as main page to show all templates.
        parent::__construct($request);

        $this->locationFacade = new LocationFacade($GLOBALS['conn']);
        $this->request = $request;
        $this->page = new AdminPage();
    }                                                //End of the constructor.
 
 
	/**
	*@desc  This function is used to display the form to add shirenames. And then it will insert the value into the database.
	*/ 
 	public function LocationFormShow_shirenames()
 	{
		$this->page->pageTitle = "Add shires";
		$this->page->assign("do",$_GET['do']); 
		$this->page->assign("action1",$_GET['action']);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("viewLocation",$this->request->createURL("Location","viewLocation"));
		$this->page->assign("searchLoc",$this->request->createURL("Location","searchLoc"));   
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("BusinessManager_url",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing","addListing"));
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow")); 
		$this->page->assign("action",$this->request->createURL("Location","addLocationShire"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("LocationFormShow_shirenames",$this->request->createURL("Location","LocationFormShow_shirenames"));
		$this->page->assign("LocationFormShow_townnames",$this->request->createURL("Location","LocationFormShow_townnames"));
		$res2=$this->locationFacade->selectStates();
		$this->page->assign("values2",$res2);
		$this->page->getPage("location_add_form_shirenames.tpl");
	}
	
	/**
	*@desc  This function is used to display the form to add shiretown. And then it will insert the value into the database.
	*/		
	public function LocationFormShow_townnames()
	{  
		$this->page->pageTitle = "Add towns";
		$this->page->assign("do",$_GET['do']); 
		$this->page->assign("action1",$_GET['action']);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("searchLoc",$this->request->createURL("Location","searchLoc"));   
		$this->page->assign("viewLocation",$this->request->createURL("Location","viewLocation"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("BusinessManager_url",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing","addListing"));
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow")); 
		$this->page->assign("action",$this->request->createURL("Location","addLocationTown"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("LocationFormShow_shirenames",$this->request->createURL("Location","LocationFormShow_shirenames"));
		$this->page->assign("LocationFormShow_townnames",$this->request->createURL("Location","LocationFormShow_townnames"));
		$this->page->assign("LocationFormShow",$this->request->createURL("Location","viewLocation"));		
		$res1=$this->locationFacade->selectShires();
		$this->page->assign("values1",$res1);
		$res2=$this->locationFacade->selectStates();
		$this->page->assign("values2",$res2);
		$this->page->getPage("location_add_form_townnames.tpl");
   }	
  
	/**
	*@desc  This function is the second function used fo adding shirename. And then it will return to the calling function.
	*/  
	public function addLocationShire()
	{
		$this->page->assign("searchLoc",$this->request->createURL("Location","searchLoc"));   
		$this->page->assign("viewLocation",$this->request->createURL("Location","viewLocation"));
		$result=$this->locationFacade->addLocationShires($_POST);
		if($result['result'])
		{
		  $this->request->setAttribute("message-succ", $result['message']);
		  $this->LocationFormShow_shirenames();
		}else{
		 $this->request->setAttribute("message", $result['message']);
		 $this->LocationFormShow_shirenames();
		}
  	}
   
   
	/**
	*@desc  This function is the second function used fo adding shiretown. And then it will return to the calling function.
	*/  
	public function addLocationTown()
	{
		$this->page->assign("searchLoc",$this->request->createURL("Location","searchLoc"));   
		$this->page->assign("viewLocation",$this->request->createURL("Location","viewLocation"));
		$result=$this->locationFacade->addLocationTowns($_POST);
		if($result['result'])
		{  
		  $this->request->setAttribute("message-succ", $result['message']);
		  $this->LocationFormShow_townnames();
		}else{
		 $this->request->setAttribute("message", $result['message']);
		 $this->LocationFormShow_townnames();
		}
  	}
	
	/**
	*@desc  This function is the display the location.
	*/ 	
	public function viewLocation()
	{ 
	    $this->page->pageTitle = "Locations"; 
		$msg = (!empty($_GET['msg']))?$_GET['msg']:NULL;
		$this->page->assign("msg",$msg);
		$this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("searchLoc",$this->request->createURL("Location","searchLoc"));   
		$this->page->assign("viewLocation",$this->request->createURL("Location","viewLocation","name={$this->request->getAttribute("name")}&fr={$this->request->getAttribute("fr")}&ID"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("BusinessManager_url",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing","addListing"));
	    $this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("addLocation",$this->request->createURL("Location","LocationFormShow"));
		$this->page->assign("edit_url",$this->request->createURL("Location","editLocation","ID"));
		$this->page->assign("deleteShire",$this->request->createURL("Location","deleteLocationShire","ID"));
		$this->page->assign("deleteTown",$this->request->createURL("Location","deleteLocationTown","name={$this->request->getAttribute("name")}&fr={$this->request->getAttribute("fr")}&ID"));
		$this->page->assign("action",$this->request->createURL("Location","updateEditLocation","ID"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("LocationFormShow_shirenames",$this->request->createURL("Location","LocationFormShow_shirenames"));
		$this->page->assign("LocationFormShow_townnames",$this->request->createURL("Location","LocationFormShow_townnames"));
		//$this->page->assign("deleteTown", "javascript:window.location='".$this->request->createURL("Location", "deleteLocationTown","ID"));
		$towns=$this->locationFacade->viewLocations($this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"));
		$this->page->assign("values",$towns['blogs']);
		$this->page->assign("paging",$towns['paging']);
     	$this->page->getPage("location_display.tpl");
	} 

	/**
	*@desc  This function is used for editing the location details and display the containing the old value.
	*/ 
	public function editLocation()
	{   
	    $this->page->pageTitle = "Edit Location";
	    $this->page->assign("do",$_GET['do']);
	    $this->page->assign("action1",$_GET['action']);
	   	$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("searchLoc",$this->request->createURL("Location","searchLoc"));   
		$this->page->assign("viewLocation",$this->request->createURL("Location","viewLocation"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("BusinessManager_url",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing","addListing"));
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("addLocation",$this->request->createURL("Location","LocationFormShow"));
		$this->page->assign("action",$this->request->createURL("Location","updateEditLocation","ID"));
		$this->page->assign("edit_url",$this->request->createURL("Location","editLocation","ID"));
		$this->page->assign("deleteShire",$this->request->createURL("Location","deleteLocationShire","ID"));
		$this->page->assign("deleteTown",$this->request->createURL("Location","deleteLocationTown","name={$this->request->getAttribute("name")}&fr={$this->request->getAttribute("fr")}&ID"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("LocationFormShow_shirenames",$this->request->createURL("Location","LocationFormShow_shirenames"));
		$this->page->assign("LocationFormShow_townnames",$this->request->createURL("Location","LocationFormShow_townnames"));
		//$this->page->assign("deleteTown", "javascript:window.location='".$this->request->createURL("Location", "deleteLocationTown","ID"));
		$res2=$this->locationFacade->selectStates();
	    $this->page->assign("values2",$res2);
		$res3=$this->locationFacade->editLocationDetails($_POST);
        $this->page->assign("values",$res3[0]);
		$this->page->getPage("locations_edit.tpl");
		//$this->locationFacade->editLocation($_GET['ID'], $_GET['keyword']);
	}
	
	
	/**
	*@desc  This function is the second function used for editing the location details. and return back to the calling function.
	*/ 	 
	public function updateEditLocation()
	{   
	    $this->page->assign("do",$_GET['do']); 
	    $this->page->assign("action1",$_GET['action']);
	    $this->page->assign("action",$this->request->createURL("Location","updateEditLocation","ID")); 
		$this->page->assign("viewLocation",$this->request->createURL("Location","viewLocation")); 
	    $this->page->assign("edit_url",$this->request->createURL("Location","editLocation","ID"));
		$this->page->assign("searchLoc",$this->request->createURL("Location","searchLoc"));   
		$this->page->assign("deleteShire",$this->request->createURL("Location","deleteLocationShire","ID"));
    	$this->page->assign("deleteTown",$this->request->createURL("Location","deleteLocationTown","name={$this->request->getAttribute("name")}&fr={$this->request->getAttribute("fr")}&ID"));  
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("LocationFormShow_shirenames",$this->request->createURL("Location","LocationFormShow_shirenames"));
		$this->page->assign("LocationFormShow_townnames",$this->request->createURL("Location","LocationFormShow_townnames"));
		$this->page->assign("deleteTown", "javascript:window.location='".$this->request->createURL("Location", "deleteLocationTown","ID"));
        $result=$this->locationFacade->updateEditDetails($_POST);//prexit($result);
		if($result['result'])
	    {
	     $this->request->setAttribute("message-succ", $result['message']);
		 $this->editLocation();
	    // $this->request->redirect("Location","viewLocation","msg=4");
	    }  
		else
		{
		 $this->request->setAttribute("message", $result['message']);
		  $this->editLocation();
		//  $this->request->redirect("Location","viewLocation","msg=2");
		}
	} 
  
	/**
	*@desc  This function is used to delete the shirename.
	*/ 	  
	public function deleteLocationShire()
	{
	    $this->page->assign("do",$_GET['do']);  
	    $this->page->assign("action1",$_GET['action']);
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("viewLocation",$this->request->createURL("Location","viewLocation"));
		$this->page->assign("searchLoc",$this->request->createURL("Location","searchLoc"));   
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("BusinessManager_url",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing","addListing"));
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("edit_url",$this->request->createURL("Location","editLocation","ID"));
		$this->page->assign("deleteShire",$this->request->createURL("Location","deleteLocationShire","ID"));
		$this->page->assign("deleteTown",$this->request->createURL("Location","deleteLocationTown","name={$this->request->getAttribute("name")}&fr={$this->request->getAttribute("fr")}&ID"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("LocationFormShow_shirenames",$this->request->createURL("Location","LocationFormShow_shirenames"));
		$this->page->assign("LocationFormShow_townnames",$this->request->createURL("Location","LocationFormShow_townnames"));
		$this->page->assign("addLocation",$this->request->createURL("Location","addLocation"));  
		$this->page->assign("deleteTown", "javascript:window.location='".$this->request->createURL("Location", "deleteLocationTown","ID"));
		$result=$this->locationFacade->deleteLocationShire($_POST);
		$this->request->redirect("Location","viewLocation","msg=3");
	}
	
	/**
	*@desc  This function is used to delete the shiretown.
	*/ 		
	public function deleteLocationTown()
	{
		$this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']); 
		$this->page->pageTitle = "Delete location"; 
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("viewLocation",$this->request->createURL("Location","viewLocation"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("searchLoc",$this->request->createURL("Location","searchLoc"));   
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("BusinessManager_url",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing","addListing"));
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("edit_url",$this->request->createURL("Location","editLocation","ID"));
		$this->page->assign("deleteShire",$this->request->createURL("Location","deleteLocationShire","ID"));
		$this->page->assign("deleteTown",$this->request->createURL("Location","deleteLocationTown","name={$this->request->getAttribute("name")}&fr={$this->request->getAttribute("fr")}&ID"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("LocationFormShow_shirenames",$this->request->createURL("Location","LocationFormShow_shirenames"));
		$this->page->assign("LocationFormShow_townnames",$this->request->createURL("Location","LocationFormShow_townnames"));
		$this->page->assign("addLocation",$this->request->createURL("Location","addLocation"));  
		//$this->page->assign("deleteTown", "javascript:window.location='".$this->request->createURL("Location", "deleteLocationTown","ID"));
		$result				= $this->locationFacade->deleteLocationTown($_GET);
		if($result['result'])
		{
			$this->request->setAttribute("message-succ", $result['message']);
			$towns= $this->locationFacade->searchLocations($_GET,$this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"));
			$this->page->assign("values",$towns['blogs']);
			$this->page->assign("paging",$towns['paging']);
			$this->page->getPage("location_display.tpl");
		}else{
			$this->request->setAttribute("message", $result['message']);
			$towns= $this->locationFacade->viewLocations($this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"));
			$this->page->assign("values",$towns['blogs']);
			$this->page->assign("paging",$towns['paging']);
			$this->page->getPage("location_display.tpl");
		}
	}


	/**
	*@desc  This function is used to display the search page which takes the search value.
	*/ 		
	public function searchLoc()
	{
		$this->page->pageTitle = "Search Locations";
		$this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']); 
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("searchLoc",$this->request->createURL("Location","searchLoc"));   
		$this->page->assign("viewLocation",$this->request->createURL("Location","viewLocation"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("BusinessManager_url",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing","addListing"));
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("addLocation",$this->request->createURL("Location","LocationFormShow"));
		$this->page->assign("edit_url",$this->request->createURL("Location","editLocation","ID"));
		$this->page->assign("deleteShire",$this->request->createURL("Location","deleteLocationShire","ID"));
		$this->page->assign("deleteTown",$this->request->createURL("Location","deleteLocationTown","name={$this->request->getAttribute("name")}&fr={$this->request->getAttribute("fr")}&ID"));
		$this->page->assign("action",$this->request->createURL("Location","updateEditLocation","ID"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("LocationFormShow_shirenames",$this->request->createURL("Location","LocationFormShow_shirenames"));
		$this->page->assign("LocationFormShow_townnames",$this->request->createURL("Location","LocationFormShow_townnames"));
		$this->page->assign("searchLoc",$this->request->createURL("Location","searchLoc"));   
		$this->page->assign("action",$this->request->createURL("Location","searchLocations"));
		$this->page->getPage("search_loc.tpl");
	}
	
	/**
	*@desc  This function is the second function used for searching the value on the basis of search criteria entered on the search page.
	*/ 		
	public function searchLocations()
	{
		$this->page->assign("do",$_GET['do']);
		$this->page->assign("action1",$_GET['action']); 
		$this->page->assign("login_url",$this->request->createURL("Admin", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$this->page->assign("searchLoc",$this->request->createURL("Location","searchLoc"));   
		$this->page->assign("viewLocation",$this->request->createURL("Location","viewLocation"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Admin", "adminManager"));
		$this->page->assign("reg_url",$this->request->createURL("Admin", "registrationAdd"));
		$this->page->assign("BusinessManager_url",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("addbusinessform",$this->request->createURL("SalesAccountManager", "addListing"));
		$this->page->assign("MultipleListngMgr_url",$this->request->createURL("AdminListing","addListing"));
		$this->page->assign("viewlisting",$this->request->createURL("AdminListing", "viewList"));
		$this->page->assign("search",$this->request->createURL("SalesAccountManager","searchBusiness"));
		$this->page->assign("csvfile",$this->request->createURL("AdminListing","csvFormShow"));
		$this->page->assign("addLocation",$this->request->createURL("Location","LocationFormShow"));
		$this->page->assign("edit_url",$this->request->createURL("Location","editLocation","ID"));
		$this->page->assign("deleteShire",$this->request->createURL("Location","deleteLocationShire","ID"));
		$this->page->assign("deleteTown",$this->request->createURL("Location","deleteLocationTown","name={$this->request->getAttribute("name")}&fr={$this->request->getAttribute("fr")}&ID"));
		$this->page->assign("action",$this->request->createURL("Location","updateEditLocation","ID"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("LocationFormShow_shirenames",$this->request->createURL("Location","LocationFormShow_shirenames"));
		$this->page->assign("LocationFormShow_townnames",$this->request->createURL("Location","LocationFormShow_townnames"));
		
		$this->page->assign("searchLoc",$this->request->createURL("Location","searchLoc"));   
		$retArr				= $this->locationFacade->validatesearch($_GET);
		if($retArr['result'])
		{
			$towns			= $this->locationFacade->searchLocations($_GET,$this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"));
			
			$this->page->assign("count",count($towns['blogs']));
			$this->page->assign("values",$towns['blogs']);
			$this->page->assign("paging",$towns['paging']);
			$this->page->getPage("location_display.tpl");
		}
		else
		{
			$this->request->setAttribute("message", $retArr['message']);
			$this->searchLoc();		
		}
	}
}
?>