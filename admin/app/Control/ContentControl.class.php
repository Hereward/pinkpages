<?php
class ContentControl extends MainControl
{

	private $contentFacade;                           //A private variable that will be used as object for AdminFacade class.
	public function __construct($request)           //Start of The __contructor.purpose, to create objects for AdminFacade
	{                                               //and for AdminPage,used as main page to show all templates.
		parent::__construct($request);

		$this->contentFacade = new ContentFacade($GLOBALS['conn']);
		$this->request = $request;
		$this->page = new AdminPage();
	}

	public function addPage()
	{
		$this->page->pageTitle = "Add page";
		$this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		$this->page->assign("addpage",$this->request->createURL("Content","addPage"));
		$this->page->assign("viewPage",$this->request->createURL("Content","viewPage"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement","ID"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement","ID"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions","ID"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs","ID"));
		$this->page->assign("edit_url",$this->request->createURL("Content","edit"));
		$this->page->assign("delete",$this->request->createURL("Content", "delete"));
		$this->page->assign("action",$this->request->createURL("Content","pageAddition"));
		$this->page->assign("SITE_PATH",SITE_PATH);
		$this->page->getPage("cms_add_page.tpl");
	}

	public function pageAddition()
	{
		$res=$this->contentFacade->pageAdd($_POST);
		if($res['result'])
		{
			$this->request->setAttribute("message-succ", $res['message']);
			$this->viewPage();
		}
		else{
			$this->request->setAttribute("message", $res['message']);
			$this->addPage();
		}
	}

	public function viewPage()
	{
		$this->page->pageTitle = "Pages";
		$this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		$this->page->assign("addpage",$this->request->createURL("Content","addPage"));
		$this->page->assign("viewPage",$this->request->createURL("Content","viewPage"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement","ID"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement","ID"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions","ID"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs","ID"));
		$this->page->assign("edit_url",$this->request->createURL("Content","edit"));
		$this->page->assign("delete",$this->request->createURL("Content", "delete"));
		$res=$this->contentFacade->fetchDetails();//prexit($res);
		$this->page->assign("values1",$res);
		$this->page->getPage("cms_page_show.tpl");

	}

	public function edit()
	{
		$this->page->pageTitle = "Edit Page";
		$this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		$this->page->assign("addpage",$this->request->createURL("Content","addPage"));
		$this->page->assign("viewPage",$this->request->createURL("Content","viewPage"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement","ID"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement","ID"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions","ID"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs","ID"));
		$this->page->assign("edit_url",$this->request->createURL("Content","edit"));
		$this->page->assign("delete",$this->request->createURL("Content", "delete"));
		$this->page->assign("action",$this->request->createURL("Content","editAdd","ID"));
		$this->page->assign("cancel",$this->request->createURL("Content", "viewPage"));
		$res=$this->contentFacade->editfetchDetails();//prexit($res);
		$this->page->assign("values2",$res);
		$this->page->getPage("cms_edit_page.tpl");
	}

	public function editAdd()
	{
		$res=$this->contentFacade->editAdd($_POST);
		if($res['result'])
		{
			$this->request->setAttribute("message-succ", $res['message']);
			$this->viewPage();
		}
		else{
			$this->request->setAttribute("message", $res['message']);
			$this->edit();
		}
		/*$this->page->assign("do2",$_GET['do']);
		$this->page->assign("action2",$_GET['action']);
		$this->page->assign("addpage",$this->request->createURL("Content","addPage"));
		$this->page->assign("viewPage",$this->request->createURL("Content","viewPage"));
		$this->page->assign("footerStatement",$this->request->createURL("Content","footerStatement","ID"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement","ID"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions","ID"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs","ID"));
		$this->page->assign("edit_url",$this->request->createURL("Content","edit"));
		$this->page->assign("delete",$this->request->createURL("Content", "delete"));


		if($res['result'])
		{
			$this->request->setAttribute("message-succ", $res['message']);
			$this->viewPage();
		}*/

	}

	public function delete()
	{
		$result=$this->contentFacade->delList();
		if($result['result'])
		{
			$this->request->setAttribute("message-succ", $result['message']);
			$this->viewPage();
		}else{
			$this->request->setAttribute("message", $result['message']);
			$this->viewPage();
		}
	}

	public function privacyStatement()
	{
		$this->page->pageTitle = "Privacy statement";
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
	public function termsAndConditions()
	{
		$this->page->pageTitle = "Terms and Conditions";
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement","ID"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions","ID"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs","ID"));
		$res=$this->contentFacade->termsAndConditionsDetails();//prexit($res);
		$this->page->assign("values2",$res);
		$this->page->getPage("terms_and_conditions.tpl");
	}

	public function contactUs()
	{
		$this->page->pageTitle = "Contact Us";
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement","ID"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions","ID"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs","ID"));

		$res=$this->contentFacade->contactUs();//prexit($res);
		$this->page->assign("values2",$res);
		$this->page->getPage("contact_us.tpl");
	}

}
?>	