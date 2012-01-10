<?php
class TeamManagerControl extends MainControl {
    
    

    public function __construct($request) {

        parent::__construct($request);
        
        $this->TeamManagerFacade = new TeamManagerFacade($GLOBALS['conn']);
        $this->request = $request;
        $this->page = new AdminPage();
    }/* END __construct */


  /*  public function doteamManager() {
        $res = $this->TeamFacade->userLogout();
        $this->request->redirect("Admin","loggedOut");
    }/* END logout */


	 public function doteamManager() {
	     $this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
    	 $this->teamManager();
	}   
    
	public function teamManager() {	
		//$User_Level= $this->TeamFacade->loginLevel();
		//$res1 = $this->TeamFacade->FetchUserID($User_Level[1]);
		$this->page->assign("reg_url",$this->request->createURL("TeamManager", "registration"));
		$this->page->assign("logout_url",$this->request->createURL("Admin", "doLogout"));
		$res2 = $this->TeamManagerFacade->FetchUserDetails();
		$this->page->assign("values",$res2);		
		$this->page->getPage('teammanager.tpl');
	}
	
	
//******************************************************************************************************************	
	 public function registration() {
        
        $this->page->assign("action",$this->request->createURL("TeamManager", "addition"));
        $this->page->assign("back",$this->request->createURL("TeamManager", "teamManager"));
		$this->page->getPage('registeruser_teammanager.tpl');
    }
	
	
	public function addition(){
        echo 'dafdfsdfdf';
        $res = $this->TeamManagerFacade->userAdd($_POST);
        
        if($res['result']) {
           
            $this->request->redirect("TeamManager","successview");// Success
        
        }else{
            
            $this->request->setAttribute("message", $res['message']);
           // $this->userRegistration();
        }
    }
	
	/*public function userRegistration()
	{
	    $this->page->getPage();}
	*/	
	public function successview()
	{
	$this->page->assign("back",$this->request->createURL("TeamManager", "teamManager"));
	 $this->page->getPage("successview.tpl");
	} 	
//*******************************************************************************************************************
	public function search()
	{ echo "fsdfjlksdjfklsjd fjsd fjlksd jflkasj dfj asdfksad fkl";
     $result = $this->TeamManagerFacade->search($_GET);
//	 $this->page->assign("search",$this->request->createURL("TeamManager", "search"));
	 $this->page->getPage('teammanager.tpl');
	}


}
?>