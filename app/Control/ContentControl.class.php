<?php
class ContentControl extends MainControl
{

	private $contentFacade;                           //A private variable that will be used as object for AdminFacade class.
	public function __construct($request)           //Start of The __contructor.purpose, to create objects for AdminFacade
	{                                      //and for AdminPage,used as main page to show all templates.
		parent::__construct($request);

		$this->contentFacade = new ContentFacade($GLOBALS['conn']);
		$this->request = $request;
		$this->page = new MainPage();
	}

	/**
	*@desc  The addPage() function is called, to add the cms page.
	*/	
	public function addPage()
	{	
		$do							= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action						= (!empty($_GET['action']))?$_GET['action']:NULL;
		$this->page->assign("do2",$do);
		$this->page->assign("action2",$action);
		$this->page->assign("addpage",$this->request->createURL("Content","addPage"));
		$this->page->assign("viewPage",$this->request->createURL("Content","viewPage"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement","ID"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement","ID"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions","ID"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs","ID"));
		$this->page->assign("edit_url",$this->request->createURL("Content","edit"));
		$this->page->assign("delete",$this->request->createURL("Content", "delete"));
		$this->page->assign("action",$this->request->createURL("Content","pageAddition"));
		$this->page->getPage("cms_add_page.tpl");
	}

	/**
	*@desc  The function is used to display the list of item that had been added.
	*/
	public function pageAddition()
	{
		$res=$this->contentFacade->pageAdd($_POST);
		if($res['result'])
		{
			$this->viewPage();
		}
	}


	/**
	*@desc  The function is used to display the list of item that had been added.
	*/
	public function viewPage()
	{

		$res=$this->contentFacade->viewPage($_GET['page']);
		if(empty($res[0]['page_title'])){
			$this->request->redirect();
		}

		$this->page->assign("values2",$res);
		$this->page->getPage("cms_page_show.tpl");

	}
	/**
	*@desc  The function is used to display page containing FAQ's.
	*/
	public function faq()
	{
	$this->page->getPage("faq.tpl");
	}	
	
	


	/**
	*@desc  The function is used to display the page that is containing the old value of cms page.
	*/
	public function edit()
	{
		$do							= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action						= (!empty($_GET['action']))?$_GET['action']:NULL;	
		$this->page->assign("do2",$do);
		$this->page->assign("action2",$action);
		$this->page->assign("addpage",$this->request->createURL("Content","addPage"));
		$this->page->assign("viewPage",$this->request->createURL("Content","viewPage"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement","ID"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement","ID"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions","ID"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs","ID"));
		$this->page->assign("edit_url",$this->request->createURL("Content","edit"));
		$this->page->assign("delete",$this->request->createURL("Content", "delete"));
		$this->page->assign("action",$this->request->createURL("Content","editAdd","ID"));
		$res=$this->contentFacade->editfetchDetails();
		$this->page->assign("values2",$res);
		$this->page->getPage("cms_edit_page.tpl");
	}

	/**
	*@desc  The function is used to edit the details of the cms page.
	*/
	public function editAdd()
	{
		$do							= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action						= (!empty($_GET['action']))?$_GET['action']:NULL;	
		$this->page->assign("do2",$do);
		$this->page->assign("action2",$action);
		$this->page->assign("addpage",$this->request->createURL("Content","addPage"));
		$this->page->assign("viewPage",$this->request->createURL("Content","viewPage"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement","ID"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement","ID"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions","ID"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs","ID"));
		$this->page->assign("edit_url",$this->request->createURL("Content","edit"));
		$this->page->assign("delete",$this->request->createURL("Content", "delete"));

		$res=$this->contentFacade->editAdd($_POST);
		if($res['result'])
		{
			$this->request->setAttribute("message", $res['message']);
			$this->viewPage();
		}
	}

	/**
	*@desc  The function is used to delete the cms page.
	*/
	public function delete()
	{
		$result=$this->contentFacade->delList();
		if($result['result'])
		{
			$this->request->setAttribute("message", $result['message']);
			$this->viewPage();
		}else{
			$this->request->setAttribute("message", $result['message']);
			$this->viewPage();
		}
	}

	/**
	*@desc  The function is used to display the privacy statement page.
	*/
	public function privacyStatement()
	{
		$do							= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action						= (!empty($_GET['action']))?$_GET['action']:NULL;	
		$this->page->assign("do",$do);
		$this->page->assign("action",$action);
		$this->contentFacade->popularPageCount("10");
		$this->page->assign("home",$this->request->createURL("Affiliate", "showhomePageAffiliate"));
		$this->page->assign("searchStreetForm",$this->request->createURL("Listing", "searchStreetForm"));
		$this->page->assign("classifiedSearch",$this->request->createURL("Index", "home"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement","ID"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions","ID"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement","ID"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs","ID"));
		$res=$this->contentFacade->fetchPrivacyDetails();//prexit($res);
		$this->page->assign("values2",$res);
		$this->page->getPage("privacy_statement_page.tpl");
	}

	/* public function footerStatement()
	{
	$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement","ID"));
	$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement","ID"));
	$res=$this->contentFacade->fetchfooterDetails();
	//	var_dump($res);
	$this->page->assign("values",$res);
	$this->page->getPage("footer.tpl");
	}
	*/
	
	
	/**
	*@desc  The function is used to display the Terms And Conditions page.
	*/	
	public function termsAndConditions()
	{
		$do							= (!empty($_GET['do']))?$_GET['do']:NULL;
		$action						= (!empty($_GET['action']))?$_GET['action']:NULL;	
		$this->page->assign("do",$do);
		$this->page->assign("action",$action);
		$this->contentFacade->popularPageCount("11");
		$this->page->assign("home",$this->request->createURL("Affiliate", "showhomePageAffiliate"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement","ID"));
				$this->page->assign("searchStreetForm",$this->request->createURL("Listing", "searchStreetForm"));
		$this->page->assign("classifiedSearch",$this->request->createURL("Index", "home"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions","ID"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs","ID"));
		$res=$this->contentFacade->termsAndConditionsDetails();//prexit($res);
		$this->page->assign("values2",$res);
		$this->page->assign("page_title", $res[0]['page_title']);
		$this->page->assign("meta_description", $res[0]['meta_description']);
		$this->page->getPage("terms_and_conditions.tpl");
	}


	/**
	*@desc  The function is used to display the Contact us page.
	*/	
	public function contactUs()
	{
		$this->page->pageTitle 			= "Pink Pages &shy; Contact us ";
		$this->contentFacade->popularPageCount("6");
		$this->page->assign("home",$this->request->createURL("Affiliate", "showhomePageAffiliate"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement","ID"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions","ID"));
		$this->page->assign("action",$this->request->createURL("Content","sendMail"));
		$this->page->assign("searchStreetForm",$this->request->createURL("Listing", "searchStreetForm"));
		$this->page->assign("classifiedSearch",$this->request->createURL("Index", "home"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs","ID"));
		$res=$this->contentFacade->contactUs();
		$this->page->assign("values2",$res);
		$this->page->getPage("contact_us.tpl");
	}


	public function mailSentThanks()
	{
	$this->page->pageTitle 			= "Pink Pages &shy; Mail Sent";
	$this->page->assign("back_to_search",$this->request->createURL("Listing", "categorySearch","search"));
	$this->page->getPage('mail_sent_thanks.tpl');
	}
	
	/**
	*@desc  The function is used to send mail on the contact us page.
	*/	
	public function sendMail()
	{
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement","ID"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions","ID"));
		$this->page->assign("action",$this->request->createURL("Content","sendMail"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs","ID"));
		$result=$this->contentFacade->sendMail($_POST);
		if($result['result'])
		{
			//$this->request->redirect("Content","contactUs","Msg");
			//$this->request->setAttribute("message", $result['message']);
			$this->mailSentThanks();
		}else{
			$this->request->setAttribute("message", $result['message']);
			$this->contactUs();
		}


	}


	/**
	*@desc  The function is used to display the about us page.
	*/	
	public function aboutUs()
	{
		$this->contentFacade->popularPageCount("7");
		$this->page->assign("home",$this->request->createURL("Affiliate", "showhomePageAffiliate"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement","ID"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions","ID"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs","ID"));
				$this->page->assign("searchStreetForm",$this->request->createURL("Listing", "searchStreetForm"));
		$this->page->assign("classifiedSearch",$this->request->createURL("Index", "home"));
		$this->page->assign("fetchSuburb",$this->request->createURL("Content","fetchSuburb","Code"));
		$res=$this->contentFacade->aboutUs();
		$this->page->assign("values2",$res);
		$regionResult=$this->contentFacade->getRegion();
		$this->page->assign("regionResult",$regionResult);
		$this->page->getPage("about_us.tpl");
	}


	/**
	*@desc  The function is used to fetch the suburb details.
	*/	
	public function fetchSuburb()
	{
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement","ID"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions","ID"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs","ID"));
		$this->page->assign("fetchSuburb",$this->request->createURL("Content","fetchSuburb","Code"));
		$suburbResult=$this->contentFacade->fetchSuburb($_GET);
		$Region		=$_GET['region'];
		$this->page->assign("suburbResult",$suburbResult);
		$this->page->assign("Region",$Region);
		$this->page->getPage("suburb_lising.tpl");
	}


	/**
	*@desc  The function is used to display the Careers page.
	*/	
	public function careers()
	{
		$this->contentFacade->popularPageCount("8");
		$this->page->assign("home",$this->request->createURL("Affiliate", "showhomePageAffiliate"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement","ID"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions","ID"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs","ID"));
		$this->page->assign("searchStreetForm",$this->request->createURL("Listing", "searchStreetForm"));
		$this->page->assign("classifiedSearch",$this->request->createURL("Index", "home"));
		$res=$this->contentFacade->careers();//prexit($res);
		$this->page->assign("values2",$res);
		$this->page->getPage("careers.tpl");
	}

}
?>