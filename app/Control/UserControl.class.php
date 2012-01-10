<?php
/**
 *  UserControl Class
 *  @author     Vinod Kumar
 *  @version    $Revision: 1.0$
 *  @package    Project Name
 *
 */
class UserControl extends MainControl {

	private $userFacade;
	
	/**
     *  __construct
     *
     *  Set up request object & MainPage object
     *
     *  @param  object  request Request object
     */
	public function __construct($request) {
	    
		$this->userFacade = new UserFacade($GLOBALS['conn']);
		$this->page = new MainPage();
		parent::__construct($request);
	}/* END __construct */

	/**
     *  doLogin
     *
     *  Attempts user login
     */
	public function doLogin() {
	    
		$res = $this->userFacade->userLogin($_POST);
		if($res['result']) {
			$this->request->redirect();// Success
		}else{
		    $this->request->setAttribute("message", $res['message']);
		    $this->login();
		}
	}/* END doLogin */
	
	/**
     *  login
     *
     *  Opens up login page
     */	
	public function login() {

//		$this->page->addCssStyle('style.css');
//		$this->page->addJsFile('prototype.js');
//		$this->page->addJsFile('validation.js');
//		$this->page->addJsFile('effects.js');
		$this->page->pageTitle = "User Login";
        $this->page->assign("action",$this->request->createURL("User", "doLogin"));
        $this->page->assign("reg_url",$this->request->createURL("User", "registration"));
		$this->page->getPage('login.tpl');
		
	}/* END login */
	
	/**
     *  logout
     *
     *  Perform user logout
     */
	public function doLogout() {

		$res = $this->userFacade->userLogout();
		$this->request->redirect("User","loggedOut");
	}/* END logout */
	
	/**
     *  registration
     *
     *  Opens up user registration form
     */    
    public function registration() {
        
        $this->page->assign("action", $this->request->createURL("User", "add"));
        $this->page->assign("login_url",$this->request->createURL("User", "login"));
		$this->page->getPage('register.tpl');
    }/* END registration */
    
    
    /**
     *  userRegistration
     *
     *  Add/register a new user
     */
    public function add(){
        
        $res = $this->userFacade->userAdd($_POST);
        
        if($res['result']) {
           
            $this->request->redirect();// Success
        
        }else{
            
            $this->request->setAttribute("message", $res['message']);
            $this->userRegistration();
        }
    }/* END userRegistration */
    
    /**
     *  edit
     *
     *  Open user edit form
     */    
    public function edit() {
        
        $userArray = $this->userFacade->userFetch();
        $this->request->setAttributeArray($userArray);
        
        $this->page->getPage('userEdit.php', $this->request);
    }/* END edit */
    
    /**
     *  update
     *
     *  Update user
     */
    public function update() {
        
        $res = $this->userFacade->userUpdate($_POST);

        $this->request->setAttribute("message", $res['message']);
        $this->edit();
    }/* END update */
    
    /**
     *  password
     *
     *  Open change password form
     */
    public function password(){
        
        $this->page->getPage('userPassword.php', $this->request);
    }/* END password */
    
    /**
     *  changePassword
     *
     *  Change user password
     */
    public function changePassword(){
        
        $res = $this->userFacade->changePassword($_POST);

        $this->request->setAttribute("message", $res['message']);
        $this->password();
    }/* END changePassword */
    
    /**
     *  loggedOut
     *
     *  Open logged out page
     */
    public function loggedOut() {
        $this->page->assign("login_url",$this->request->createURL("User", "login"));
        $this->page->getPage('logged_out.tpl');
    }/* END loggedOut */
}
?>