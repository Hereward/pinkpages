<?php
/**
   * @title   Affiliate Control.class.php    
   * @desc    This is an AffiliateControl class. The purpose of this class is to perform the redirection actions needed for any              function/operation to AffiliateFacade class and also to smarty assign the URL's which were used in the templates as an              action, which redirects or calls the particular function passed in the action parameter in the AffiliateControl class. 
*/
class AffiliateControl extends MainControl
{

    private $affiliatefacade;                        //A private variable that will be used as object for AffiliateFacade class.
    public function __construct($request)           //Start of The __contructor.purpose, to create objects for AffiliateFacade
    {                                               //and for Affiliate Page,used as main page to show all templates.
        parent::__construct($request);

        $this->affiliatefacade = new AffiliateFacade($GLOBALS['conn']);
        $this->request = $request;
        $this->page = new MainPage();
    }//End of the constructor.
	
	
		/**
			() function of AdminFacade class and upon return from that function to this called function will check the                        access type if its Admin or Employee or Sales Manager and redirects to their dashboards.
		*/

    public function doLogin()
    {
        $res = $this->affiliatefacade->affiliateLogin($_POST);
        if($res['result'] && getSession('access') == "Affiliate" && getSession("status")!="0")
        {
            $this->request->redirect("Affiliate","showhomePageAffiliate");
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
		$this->page->pageTitle = "Affiliate Login";
		$this->page->assign("login_url",$this->request->createURL("Affiliate", "login"));
		$this->page->assign("lostpass",$this->request->createURL("Affiliate","lostPassword"));
		$this->page->assign("reg_url",$this->request->createURL("Business", "registrationAdd"));
		$this->page->assign("reg_affiliate",$this->request->createURL("Affiliate", "affiliateRegistration"));
		$this->page->getPage('businessLogin.tpl');
    }
	
	/**
		*@desc this function is used for user addition, this fuction calls the userAdd() function of AdminFacade, and                      redirects to success page upon getting result 'true' else message is printed. 
	*/  
    public function affiliateAdd()
    {   
		$do							= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action						= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
        $resAdd = $this->affiliatefacade->affiliateAdd($_POST);
		$this->page->assign("home",$this->request->createURL("Affiliate", "showhomePageAffiliate"));
		$this->page->assign("edit_url",$this->request->createURL("Affiliate", "edit"));
		$this->page->assign("change_password",$this->request->createURL("Affiliate", "changePassword"));
		$this->page->assign("view_banner",$this->request->createURL("Affiliate", "viewBanner"));
		$this->page->assign("affiliate_rep",$this->request->createURL("Affiliate", "affilateReport"));
        
        if($resAdd['result'])
        {
				if($resAdd['message'] == 'Add')
				{
					$this->request->redirect("Affiliate","showhomePage");
				}else{
					//$this->request->redirect("Affiliate","edit","msg=1");
						if($resAdd['message'] =='edit')
						{
						$msg="Update Successfully";
						}
					 $this->request->setAttribute("message", $msg);
            		$this->affiliateRegistration();
			   }
		   
        }else{
            $this->request->setAttribute("message", $resAdd['message']);
            $this->affiliateRegistration();
        }
		
    }
	
	
	/**
		*@desc this function is used for displaying the homepage after successfull activation after the registration.
	*/ 		
	public function showhomePage()
	{   
		$do							= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action						= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$this->page->assign("login_url",$this->request->createURL("Business", "login"));
		$res=$this->affiliatefacade->fetchAffiliateDetails();
		$this->page->assign("values",$res);
		$this->page->getPage("successActivation.tpl");
	}
		
		
	/**
		*@desc this function is used for user for displaying the affiliate banner.
	*/ 		
	public function viewBanner()
    {   
		$do							= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action						= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$this->affiliatefacade->popularPageCount("18");
		$this->page->assign("home",$this->request->createURL("Affiliate", "showhomePageAffiliate"));
		$this->page->assign("edit_url",$this->request->createURL("Affiliate", "edit"));
		$this->page->assign("change_password",$this->request->createURL("Affiliate", "changePassword"));
		$this->page->assign("affiliate_rep",$this->request->createURL("Affiliate", "affilateReport"));
		$this->page->assign("view_banner",$this->request->createURL("Affiliate", "viewBanner"));
		
		$bannerArray=$this->affiliatefacade->viewBanner($this->request->getAttribute("fr"), $this->request->getAttribute(                                                               "pg_size"));

		$this->page->assign("bannerArray",$bannerArray['banner']);
		$this->page->assign("paging",$bannerArray['paging']);

		$this->page->assign("PATH",SITE_PATH);	
        $this->page->getPage('affiliate_banner_view.tpl');
    }
			
	
	/**
	*@desc this function is used for showing the form registering the team user, with various URL's created to  be used                      on that form with an action URL created to call addition() function upon submitting the completed form.  
	*/  
    public function affiliateRegistration()
	{
		$do							= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action						= (!empty($_GET['action']))?$_GET['action']:NULL;       

		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$affiliate_id = getSession("affiliate_id");;
		$email						= (!empty($_POST['email']))?$_POST['email']:NULL;
		$fname						= (!empty($_POST['fname']))?$_POST['fname']:NULL;
		$lname						= (!empty($_POST['lname']))?$_POST['lname']:NULL;
		$password					= (!empty($_POST['password']))?$_POST['password']:NULL;
		$cpassword					= (!empty($_POST['cpassword']))?$_POST['cpassword']:NULL;
		$url						= (!empty($_POST['url']))?$_POST['url']:NULL;
		$address1					= (!empty($_POST['address1']))?$_POST['address1']:NULL;
		$address2					= (!empty($_POST['address2']))?$_POST['address2']:NULL;
		$city						= (!empty($_POST['city']))?$_POST['city']:NULL;
		$zipcode					= (!empty($_POST['zipcode']))?$_POST['zipcode']:NULL;
		$state						= (!empty($_POST['state']))?$_POST['state']:NULL;
		$country					= (!empty($_POST['country']))?$_POST['country']:NULL;
		$phone						= (!empty($_POST['phone']))?$_POST['phone']:NULL;
		$fax						= (!empty($_POST['fax']))?$_POST['fax']:NULL;
		$tax_id						= (!empty($_POST['tax_id']))?$_POST['tax_id']:NULL;
		$timezone					= (!empty($_POST['timezone']))?$_POST['timezone']:NULL;
		$company					= (!empty($_POST['company']))?$_POST['company']:NULL;
		$secrettext					= (!empty($_POST['secrettext']))?$_POST['secrettext']:NULL;
		
		$this->page->assign("affiliate_id",$affiliate_id);
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
		
		$this->affiliatefacade->popularPageCount("14");
		
		$this->page->assign("action",$this->request->createURL("Affiliate", "affiliateAdd"));
		$resultArray 				= $this->affiliatefacade->editAffiliate();
		
		$this->page->assign("secret_text",$resultArray);
		$this->page->getPage('affiliate_registration.tpl');
    }
	
	
	/**
	*@desc The purpose of this function is to display the page containing the old password and give and interface to change the old 
		password.
	*/	
	 public function changePassword()
    {   
		$do							= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action						= (!empty($_GET['action']))?$_GET['action']:NULL;       
		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$this->affiliatefacade->popularPageCount("20");
		$this->page->assign("action",$this->request->createURL("Affiliate", "changedPassword"));
		$this->page->assign("home",$this->request->createURL("Affiliate", "showhomePageAffiliate"));
		$this->page->assign("edit_url",$this->request->createURL("Affiliate", "edit"));
		$this->page->assign("change_password",$this->request->createURL("Affiliate", "changePassword"));
		$this->page->assign("affiliate_rep",$this->request->createURL("Affiliate", "affilateReport"));
		$this->page->assign("view_banner",$this->request->createURL("Affiliate", "viewBanner"));
		$this->page->getPage('change_password.tpl');
	}

	/**
	*@desc The purpose of this function is to change the password of affiliate.
	*/
	 public function changedPassword()
    {
		$do							= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action						= (!empty($_GET['action']))?$_GET['action']:NULL;       
		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$oldPassword				= (!empty($_POST['oldPassword']))?$_POST['oldPassword']:NULL;
		
		
		$this->page->assign("oldPassword",$oldPassword);
		
		
		$this->page->assign("home",$this->request->createURL("Affiliate", "showhomePageAffiliate"));
		$this->page->assign("edit_url",$this->request->createURL("Affiliate", "edit"));
		$this->page->assign("change_password",$this->request->createURL("Affiliate", "changePassword"));
		$this->page->assign("affiliate_rep",$this->request->createURL("Affiliate", "affilateReport"));
		$this->page->assign("view_banner",$this->request->createURL("Affiliate", "viewBanner"));		
		
		
		$resultArray 				= $this->affiliatefacade->changePassword($_POST);
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
	
	
	/**
	*@desc The purpose of this function is to to show the dashboard screen for Employee wich contains different                       options.
	*/ 
    public function showhomePageAffiliate()
    {   
		$do							= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action						= (!empty($_GET['action']))?$_GET['action']:NULL;       
		$this->page->assign("do",$do);
		$this->page->assign("action1",$action); 
		$this->affiliatefacade->popularPageCount("16");
	  	$msg 						= (!empty($_GET['msg']))?$_GET['msg']:NULL;
		$this->page->assign("msg",$msg);
		$this->page->assign("home",$this->request->createURL("Affiliate", "showhomePageAffiliate"));
		$this->page->assign("edit_url",$this->request->createURL("Affiliate", "edit"));
		$this->page->assign("change_password",$this->request->createURL("Affiliate", "changePassword"));
		$this->page->assign("view_banner",$this->request->createURL("Affiliate", "viewBanner"));
		$this->page->assign("affiliate_rep",$this->request->createURL("Affiliate", "affilateReport"));
        $this->page->getPage('affilate_dashboard.tpl');
    }
	
	/**
	*@desc The purpose of this function is to to show the dashboard screen for Employee wich contains different                       options.
	*/ 
    public function displayHomePage()
    {
        $this->page->getPage('home.tpl');
    }	
	
	
	/**
	*@desc The purpose of this function is to Logout by calling userLogout function of AdminFacade class and to redirect                      to loggedOut() function wich shows the logged out message and a login again prompt link.
	*/ 
    public function doLogout()
    {
        $res = $this->affiliatefacade->affiliateLogout();
        $this->request->redirect("Affiliate","loggedOut");
    }

	/**
	*@desc The purpose of this function is to Logout and to show the logged out message and a login again prompt link.			    */ 
    public function loggedOut()
    {
        $this->page->assign("login_url",$this->request->createURL("Affiliate", "login"));
        $this->page->getPage('logged_out.tpl');
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
		$this->affiliatefacade->popularPageCount("17");
		$this->page->assign("action",$this->request->createURL("Affiliate", "affiliateAdd","ID"));
		$this->page->assign("home",$this->request->createURL("Affiliate", "showhomePageAffiliate"));
		$this->page->assign("edit_url",$this->request->createURL("Affiliate", "edit"));
		$this->page->assign("view_banner",$this->request->createURL("Affiliate", "viewBanner"));
		$this->page->assign("affiliate_rep",$this->request->createURL("Affiliate", "affilateReport"));
		$this->page->assign("change_password",$this->request->createURL("Affiliate", "changePassword"));

        $resultArray 				= $this->affiliatefacade->editAffiliate();
        $this->page->assign("values",$resultArray);
        $this->page->getPage('affiliate_registration.tpl');
    }	
	
	/**
	*@desc The purpose of this function is to activate the user and show the successfull activation page.
	*/	
	public function activateUser()
    {
        $this->page->assign("login_url",$this->request->createURL("Affiliate", "login"));
        $this->page->getPage("successfulActivation.tpl");
    }
	
	
	/**
	*@desc The purpose of this function is to to show the dashboard screen for Employee wich contains different                       options.
	*/ 
    public function affilateReport()
    {
		$do							= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action						= (!empty($_GET['action']))?$_GET['action']:NULL;       
		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$this->affiliatefacade->popularPageCount("19");
		$this->page->assign("home",$this->request->createURL("Affiliate", "showhomePageAffiliate"));
		$this->page->assign("edit_url",$this->request->createURL("Affiliate", "edit"));
		$this->page->assign("change_password",$this->request->createURL("Affiliate", "changePassword"));
		$this->page->assign("affiliate_rep",$this->request->createURL("Affiliate", "affilateReport"));
		$this->page->assign("view_banner",$this->request->createURL("Affiliate", "viewBanner"));
		$this->page->assign("link_date",$this->request->createURL("Affiliate", "linkDate","Date"));		
		$bannerArray				= $this->affiliatefacade->viewReport($this->request->getAttribute("fr"), $this->request->getAttribute(                                                               "pg_size"));
		
		$this->page->assign("bannerArray",$bannerArray['banner']);
		$this->page->assign("paging",$bannerArray['paging']);	
		$this->page->getPage('affilate_report.tpl');
    }


	/**
	*@desc The purpose of this function is to to show the hourley report of the banner clicks and views.
	*/	
	public function linkDate()
    {   
		$do							= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action						= (!empty($_GET['action']))?$_GET['action']:NULL;       
		$this->page->assign("do",$do);
		$this->page->assign("action1",$action);
		$this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		
		$this->page->assign("home",$this->request->createURL("Affiliate", "showhomePageAffiliate"));
		$this->page->assign("edit_url",$this->request->createURL("Affiliate", "edit"));
		$this->page->assign("change_password",$this->request->createURL("Affiliate", "changePassword"));
		$this->page->assign("affiliate_rep",$this->request->createURL("Affiliate", "affilateReport"));
		$this->page->assign("view_banner",$this->request->createURL("Affiliate", "viewBanner"));
		$this->page->assign("link_date",$this->request->createURL("Affiliate", "linkDate","Date"));
		
		$bannerArray=$this->affiliatefacade->linkDate($_GET);
		$this->page->assign("bannerArray",$bannerArray);
        $this->page->getPage('affiliate_banner_report_hourley.tpl');	
	}	
	

	/**
	*@desc The purpose of this function is to to show the dashboard screen for Employee wich contains different                       options.
	*/ 
	public function lostPassword()
	{
		$this->page->assign("login_url",$this->request->createURL("Affiliate", "login"));
		$this->page->assign("lostpass",$this->request->createURL("Affiliate","lostPassword"));
		$this->page->assign("action",$this->request->createURL("Affiliate","passwordSent"));
		$this->page->getPage("lost_password.tpl");
	}
	
	
	/**
	*@desc The purpose of this function is to to show the dashboard screen for Employee wich contains different                       options.
	*/ 	
	public function passwordSent()
	{	
		$this->page->assign("login_url",$this->request->createURL("Affiliate", "login"));
		$res					= $this->affiliatefacade->passwordSent($_POST);
		if($res['result'])
		{
			$this->page->getPage("lost_passent.tpl");
		}else{
			$this->page->getPage("lost_passent.tpl");
		}
	}

 
}
/* END OF Affiliate Control */
?>