<?php
/**
   * @title   AdminControl.class.php    
   * @desc    This is an AdminControl class. The purpose of this class is to perform the redirection actions needed for any              function/operation to AdminFacade class and also to smarty assign the URL's which were used in the templates as an              action, which redirects or calls the particular function passed in the action parameter in the AdminControl class. 
*/
class BusinessControl extends MainControl
{

	private $businessFacade;                        //A private variable that will be used as object for AdminFacade class.
	public function __construct($request)           //Start of The __contructor.purpose, to create objects for AdminFacade
	{                                               //and for AdminPage,used as main page to show all templates.
		parent::__construct($request);

		$this->businessFacade = new BusinessFacade($GLOBALS['conn']);
		$this->request = $request;
		$this->page = new MainPage();
	}                                                //End of the constructor.

	/**
	*@desc  This is the second function called for login. the purpose of this function is  to call the adminLogin                        () function of AdminFacade class and upon return from that function to this called function will check the                        access type if its Admin or Employee or Sales Manager and redirects to their dashboards.
	*/
	public function doLogin()
	{
		/*	  $do=$_GET['do'];
		$action=$_GET['action'];
		$this->page->assign("do",$do);
		$this->page->assign("action",$action); */
		$res = $this->businessFacade->businessLogin($_POST);
		if($res['result'] && getSession('client_access') == "Business" && (getSession("status")!="I"))
		{
			$this->request->redirect("Business","showhomePageBusiness");
		}else{
			$this->request->setAttribute("message", $res['message']);
			$this->login();
		}
	}

	/**
	*@desc This is the first function called on index page. The purpose of this function is to show the login form for                      Admin vis-a-vis for Employees,Sales Managers. this page has a link for registration so URL for that link is                      smarty assigned.Alongwith this, upon pressing login button form calls doLogin(), so its URL is also smarty                      assigned here.
	*/
	public function login()
	{
		$do  						= isset($_GET['do'])?$_GET['do']:"";
		global $action;
		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$this->businessFacade->popularPageCount("12");
		$this->page->pageTitle = "Business Login";
		$this->page->assign("activate",$this->request->createURL("Business","activateUser"));
		$this->page->assign("lostpass",$this->request->createURL("Business","lostPassword"));
		$this->page->assign("change_password",$this->request->createURL("Business", "changePassword"));
		$this->page->assign("action",$this->request->createURL("Business", "doLogin"));
		$this->page->assign("reg_url",$this->request->createURL("Business", "registrationAdd"));
		$this->page->assign("reg_affiliate",$this->request->createURL("Affiliate", "affiliateRegistration"));
		$this->page->assign("lostpass",$this->request->createURL("Business","lostPassword"));
		$this->page->getPage('businessLogin.tpl');
	}

	/**
	*@desc The purpose of this function is to Logout by calling userLogout function of AdminFacade class and to redirect                      to loggedOut() function wich shows the logged out message and a login again prompt link.
	*/ 
	public function doLogout()
	{
		$do							= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action						= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("action",$action);
		$res = $this->businessFacade->userLogout();
		$this->request->redirect("Business","loggedOut");
	}

	/**
	*@desc The purpose of this function is to Logout and to show the logged out message and a login again prompt link.
	*/ 
	public function loggedOut()
	{
		$do							= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action						= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("action",$action);
		$this->page->assign("login_url",$this->request->createURL("Business", "login"));
		$this->page->getPage('logged_out.tpl');
	}

	/**
	*@desc The purpose of this function is to to show the dashboard screen for admin wich contains different managers.
	
	*/         
	public function showhomePageBusiness()
	{
		$do							= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action						= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("action",$action);
		$this->businessFacade->popularPageCount("21");
		$this->page->assign("login_url",$this->request->createURL("Business", "login"));
		$this->page->assign("TeamManager_url",$this->request->createURL("Business", "adminManager"));
		$this->page->assign("change_password",$this->request->createURL("Business", "changePassword"));
		$this->page->assign("BusinessManager_url",$this->request->createURL("Business", "adminBusinessManager"));
		$this->page->getPage('business_profile_home.tpl');
	}


	/**
	*@desc this function is used for user addition, this fuction calls the userAdd() function of AdminFacade, and                      redirects to success page upon getting result 'true' else message is printed. 
	*/  
	public function busaddition()
	{
		$do							= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action						= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("action",$action);
		$resAdd = $this->businessFacade->businessAdd($_POST);
		if($resAdd['result'])
		{
			$this->request->redirect("Business","showhomePage");
		}else{
			$this->request->setAttribute("message", $resAdd['message']);
			$this->registrationAdd();
		}
	}



	/**
	*@desc this function is used for showing the form registering the team user, with various URL's created to  be used                      on that form with an action URL created to call addition() function upon submitting the completed form.  
	*/  
	public function registrationAdd()
	{
		$do							= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action						= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$clientname		= (!empty($_POST['clientname']))?$_POST['clientname']:NULL;
		$email			= (!empty($_POST['email']))?$_POST['email']:NULL;
		$postcode		= (!empty($_POST['postcode']))?$_POST['postcode']:NULL;
		$phone			= (!empty($_POST['phone']))?$_POST['phone']:NULL;

		$this->page->assign("clientname",$clientname);
		$this->page->assign("email",$email);
		$this->page->assign("postcode",$postcode);
		$this->page->assign("phone",$phone);
        $this->businessFacade->popularPageCount("13");  

		$this->page->assign("change_password",$this->request->createURL("Business", "changePassword"));
		$this->page->assign("login_url",$this->request->createURL("Business", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Business", "doLogout"));
		$this->page->assign("action",$this->request->createURL("Business", "busaddition"));
		$this->page->assign("back",$this->request->createURL("Business", "login"));
		$this->page->assign("viewlisting",$this->request->createURL("Listing", "viewList"));
		$this->page->getPage('businessRegister.tpl');
	}


	/**
	*@desc This function is the admin Team Manager function. The purpose of this function is to fetch the user details                      from the table by calling fetchUserDetails() functiopn of AdminFacade class. The resultant records will be                      used in to show in tabular form woth options to add, edit ,delete and view the records.  
	*/
	public function adminManager()
	{
		$do							= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action						= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("action",$action);
		$this->page->assign("login_url",$this->request->createURL("Business", "login"));
		$this->page->assign("reg_url",$this->request->createURL("Business", "registrationAdd"));
		$this->page->assign("edit_url",$this->request->createURL("Business", "edit","ID"));
		$this->page->assign("change_password",$this->request->createURL("Business", "changePassword"));
		$this->page->assign("logout_url",$this->request->createURL("Business", "doLogout"));
		$this->page->assign("back",$this->request->createURL("Business", "showhomePageBusiness"));
		$this->page->assign("viewlisting",$this->request->createURL("Listing", "viewList"));
		$res2 = $this->businessFacade->fetchUserDetails();
		$this->page->assign("values",$res2);
		$this->page->getPage('edituser.tpl');
	}


	/**
	*@desc This function is just a success message page with link to login again.
	
	*/
	public function showhomePage()
	{
		$do							= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action						= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("action",$action);
		$this->page->assign("login_url",$this->request->createURL("Business", "login"));
		$this->page->assign("change_password",$this->request->createURL("Business", "changePassword"));
		$this->page->assign("back",$this->request->createURL("Business", "adminManager"));
		$res=$this->businessFacade->fetchUserDetails();
		$this->page->assign("values",$res);
		$this->page->getPage("successActivation.tpl");
	}

	public function activateUser()
	{
		$do							= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action						= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("action",$action);
		$this->page->assign("login_url",$this->request->createURL("Business", "login"));
		$this->page->getPage("successfulActivation.tpl");
	}


	/**
	*@desc This function is used to edit the details of the user, this function in turns calls editUser() function of                      AdminFacade class which shows the details of the user on the form fields based on the ID, and upon editing                      the values the editAddition() function is called to update the same in the database.  
	*/		  
	public function edit()
	{
		$do							= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action						= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$this->businessFacade->popularPageCount("25");
		$this->page->assign("action",$this->request->createURL("Business", "editAddition","ID"));
		$this->page->assign("change_password",$this->request->createURL("Business", "changePassword"));
		$this->page->assign("back",$this->request->createURL("Business", "showhomePageBusiness"));
		$this->page->assign("cancel",$this->request->createURL("Business", "showhomePageBusiness"));
		$res3 = $this->businessFacade->editUser();
		$this->page->assign("values1",$res3);
		$this->page->getPage('edituser.tpl');
	}


	/**
	*@desc  The editAddition() function is called, to update the edited values reflected in the form in the database                           which  in turns calls editAdd() function of AdminFacade class.
	*/	 
	public function editAddition()
	{
		$do							= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action						= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("action",$action);
		$this->page->assign("login_url",$this->request->createURL("Business", "login"));
		$this->page->assign("logout_url",$this->request->createURL("Business", "doLogout"));
		$this->page->assign("back",$this->request->createURL("Business", "adminManager"));
		$this->page->assign("change_password",$this->request->createURL("Business", "changePassword"));
		$this->page->assign("listing",$this->request->createURL("Listing", "addListing"));
		$this->page->assign("viewlisting",$this->request->createURL("Listing", "viewList"));
		$this->page->assign("edit_url",$this->request->createURL("Business", "Edit","ID"));
		$res=$this->businessFacade->editAdd($_POST);
		if($res['result'])
		{
			$this->request->setAttribute("message-succ", $res['message']);
			$this->edit();
		}
		else
		{
			$this->request->setAttribute("message", $res['message']);
			$this->edit();
		}
		/*$res2 = $this->businessFacade->fetchUserDetails();
		$this->page->assign("values1",$res2);
		$this->page->getPage('edituserupdated.tpl');*/
	}


	/**
	*@desc  The purpose of this function is to call the page for the lost password retrival display.
	*/	 
	public function lostPassword()
	{
		$do							= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action						= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("action",$action);
		$this->businessFacade->popularPageCount("15");
		$this->page->assign("login_url",$this->request->createURL("Business", "login"));
		$this->page->assign("change_password",$this->request->createURL("Business", "changePassword"));
		$this->page->assign("action",$this->request->createURL("Business","passwordSent"));
		$this->page->getPage("lost_password.tpl");
	}


	/**
	*@desc  The purpose of this function is retreive the lost password by taking the old value.
	*/
	public function passwordSent()
	{
		$do								= $_GET['do'];
		$action							= $_GET['action'];
		$this->page->assign("do",$do);
		$this->page->assign("action",$action);
		//$this->page->assign("login_url",$this->request->createURL("Business", "login"));
		$res							= $this->businessFacade->lostpassgain($_POST);
		if($res['result'])
		{
			$this->page->assign("login_url",$this->request->createURL("Business", "login"));
			$this->request->setAttribute("message-succ", $res['message']);
			$this->page->getPage("lost_passent.tpl");
		}
		else{
			$this->request->setAttribute("message", $res['message']);
			$this->lostPassword();
		}
	}


	/**
	*@desc  The purpose of this function is to call the page for the lost password retrival display.
	*/
	public function changePassword()
	{
		$do							= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action						= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$this->page->assign("action",$this->request->createURL("Business", "changedPassword"));
		$this->page->assign("change_password",$this->request->createURL("Business", "changePassword"));
		$this->page->assign("login_url",$this->request->createURL("Business", "login"));
		$this->page->getPage('change_password.tpl');
	}


	/**
	*@desc  The purpose of this function is to call the page for the lost password retrival display.
	*/
	public function changedPassword()
	{
		$do							= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action						= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$oldPassword					= (!empty($_POST['oldPassword']))?$_POST['oldPassword']:NULL;
		$this->page->assign("oldPassword",$oldPassword);
		$this->page->assign("action",$this->request->createURL("Business", "changedPassword"));
		$this->page->assign("login_url",$this->request->createURL("Business", "login"));
		$this->page->assign("change_password",$this->request->createURL("Business", "changePassword"));
		/*$this->page->assign("home",$this->request->createURL("Affiliate", "showhomePageAffiliate"));
		$this->page->assign("edit_url",$this->request->createURL("Affiliate", "edit"));
		$this->page->assign("change_password",$this->request->createURL("Affiliate", "changePassword"));
		$this->page->assign("affiliate_rep",$this->request->createURL("Affiliate", "affilateReport"));
		$this->page->assign("view_banner",$this->request->createURL("Affiliate", "viewBanner"));	*/

		$resultArray = $this->businessFacade->changePassword($_POST);
		if($resultArray['result'])
		{
			$this->request->setAttribute("message", $resultArray['message']);
			$this->changePassword();
		}else{
			$this->request->setAttribute("message", $resultArray['message']);
			$this->changePassword();
		}

		// $this->page->getPage('change_password.tpl');
	}

}
/* END OF ADMINCONTROL */
?>