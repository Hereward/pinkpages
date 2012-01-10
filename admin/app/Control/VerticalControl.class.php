<?php
class VerticalControl extends MainControl
{

    private $verticalFacade;                           //A private variable that will be used as object for AdminFacade class.
    public function __construct($request)           //Start of The __contructor.purpose, to create objects for Facade
    {                                               //and for AdminPage,used as main page to show all templates.
        parent::__construct($request);

        $this->verticalFacade = new VerticalFacade($GLOBALS['conn']);
        $this->request = $request;
        $this->page = new AdminPage();
    }                                                //End of the constructor.


public function verticalAddFormShow()
{
    $this->page->pageTitle = "Add vertical"; 
    $this->page->assign("do3",$_GET['do']); 
    $this->page->assign("action3",$_GET['action']);
	
	$title		    = (!empty($_POST['vertical_title']))?$_POST['vertical_title']:NULL;
	$description	= (!empty($_POST['vertical_description']))?$_POST['vertical_description']:NULL;
	
	$this->page->assign("vertical_title",$title);
	$this->page->assign("vertical_description",$description);
				

	$this->page->assign("delete",$this->request->createURL("Vertical","delete","ID"));
	$this->page->assign("edit_url",$this->request->createURL("Vertical","edit","ID"));
	$this->page->assign("action",$this->request->createURL("Vertical","editAddData","ID"));	
	$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
	$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
	$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
	$this->page->assign("searchVertical",$this->request->createURL("Vertical","searchVerticals"));
	$this->page->assign("verticalAddFormShow",$this->request->createURL("Vertical","verticalAddFormShow"));
	$this->page->assign("action1",$this->request->createURL("Vertical","verticalAddData"));
	$this->page->assign("viewVertical",$this->request->createURL("Vertical","viewVertical"));
	
	$classifications=$this->verticalFacade->fetchClassifications();
	$this->page->assign("values1",$classifications);
	$this->page->getPage("vertical_add_form.tpl");
}

public function verticalAddData()
{
  $this->page->assign("do3",$_GET['do']); 
  $this->page->assign("action3",$_GET['action']);
 
 $this->page->assign("viewVertical",$this->request->createURL("Vertical","viewVertical"));
 $this->page->assign("verticalAddFormShow",$this->request->createURL("Vertical","verticalAddFormShow"));
 $this->page->assign("delete",$this->request->createURL("Vertical","delete","ID"));
 $this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
 $this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
 $this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
 $this->page->assign("searchVertical",$this->request->createURL("Vertical","searchVerticals"));
 $this->page->assign("edit_url",$this->request->createURL("Vertical","edit","ID"));
 $this->page->assign("action",$this->request->createURL("Vertical","editAddData","ID"));	
 $res= $this->verticalFacade->verticalAdd($_POST);
	 if($res['result'])
	 {
	  $this->request->setAttribute("message-succ", $res['message']);
	  $this->verticalAddFormShow();
	 }
	 else
	 {
	  $this->request->setAttribute("message", $res['message']);
	  $this->verticalAddFormShow();
	 }
}

public  function viewVertical()
{
 $this->page->pageTitle = "Verticals";
 $this->page->assign("do3",$_GET['do']); 
 $this->page->assign("action3",$_GET['action']);
 $this->page->assign("viewVertical",$this->request->createURL("Vertical","viewVertical"));
 $this->page->assign("verticalAddFormShow",$this->request->createURL("Vertical","verticalAddFormShow"));
 $this->page->assign("delete",$this->request->createURL("Vertical","delete","ID"));
 $this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
 $this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
 $this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
 $this->page->assign("searchVertical",$this->request->createURL("Vertical","searchVerticals"));
 $this->page->assign("edit_url",$this->request->createURL("Vertical","edit","ID"));
 $this->page->assign("action",$this->request->createURL("Vertical","editAddData","ID"));
 $res=$this->verticalFacade->viewVerticles($this->request->getAttribute("fr"));
 $this->page->assign("values",$res['listings']);
 $this->page->assign("paging", $res['paging']);
 $this->page->getPage("verticals_list.tpl");
 
}

public  function delete()
{
 $this->page->assign("do3",$_GET['do']); 
 $this->page->assign("action3",$_GET['action']);
 $this->page->assign("viewVertical",$this->request->createURL("Vertical","viewVertical"));
 $this->page->assign("verticalAddFormShow",$this->request->createURL("Vertical","verticalAddFormShow"));
 $this->page->assign("delete",$this->request->createURL("Vertical","delete","ID"));
 $this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
 $this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
 $this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
 $this->page->assign("searchVertical",$this->request->createURL("Vertical","searchVerticals"));
 $this->page->assign("edit_url",$this->request->createURL("Vertical","edit","ID"));
 $this->page->assign("action",$this->request->createURL("Vertical","editAddData","ID"));
 $res=$this->verticalFacade->delete($_POST);
   if($res['result'])
   {
    $this->request->setAttribute("message-succ", $res['message']);
    $this->viewVertical();
   }
   else
   {
     $this->request->setAttribute("message", $res['message']);
     $this->viewVertical();
   }
}

public function edit()
{    
   $this->page->pageTitle = "Edit vertical";
    $this->page->assign("do3",$_GET['do']); 
    $this->page->assign("action3",$_GET['action']);
	$this->page->assign("viewVertical",$this->request->createURL("Vertical","viewVertical"));
	$this->page->assign("verticalAddFormShow",$this->request->createURL("Vertical","verticalAddFormShow"));
    $this->page->assign("delete",$this->request->createURL("Vertical","delete","ID"));
	$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
	$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
	$this->page->assign("searchVertical",$this->request->createURL("Vertical","searchVerticals"));
	$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
    $this->page->assign("edit_url",$this->request->createURL("Vertical","edit","ID"));
    $this->page->assign("action",$this->request->createURL("Vertical","editAddData","ID"));
	$classifications=$this->verticalFacade->fetchClassifications();
	$res=  $this->verticalFacade->fetchEditableDetails($_POST);
	$optionInput = '';
	foreach($classifications as $val)
	{
		$optionInput .= "<option value='".$val['localclassification_id']."' ";
		if($this->checkArray($res, $val['localclassification_id'], 'localclassification_id'))
		$optionInput .= "'selected=selected'";
		$optionInput .= ">{$val['localclassification_name']}</option>";
	}
	$this->page->assign("optionInput",$optionInput);
	$this->page->assign("values1",$classifications);
	
	$this->page->assign("values",$res);
	$this->page->getPage("vertical_edit_form.tpl");
 
 
}

private function checkArray($array, $str, $key)
{

	foreach($array as $val)
	{
		if($val[$key] == $str)
		{
			return true;
		}
	}
	return false;
}
public function editAddData()
{
	$this->page->assign("do3",$_GET['do']); 
	$this->page->assign("action3",$_GET['action']);
	$this->page->assign("viewVertical",$this->request->createURL("Vertical","viewVertical"));
    $this->page->assign("verticalAddFormShow",$this->request->createURL("Vertical","verticalAddFormShow"));
	$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
	$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
	$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
	$this->page->assign("searchVertical",$this->request->createURL("Vertical","searchVerticals"));
    $this->page->assign("delete",$this->request->createURL("Vertical","delete","ID"));
    $this->page->assign("edit_url",$this->request->createURL("Vertical","edit","ID"));
    $this->page->assign("action",$this->request->createURL("Vertical","editAddData","ID"));
    $res=$this->verticalFacade->editAddData($_POST);//prexit($res);
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
}

public function searchVerticals()
{
 $this->page->pageTitle = "Search verticals";
 $this->page->assign("do3",$_GET['do']); 
 $this->page->assign("action3",$_GET['action']);
 $this->page->assign("viewVertical",$this->request->createURL("Vertical","viewVertical"));
 $this->page->assign("verticalAddFormShow",$this->request->createURL("Vertical","verticalAddFormShow"));
 $this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
 $this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
 $this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
 $this->page->assign("delete",$this->request->createURL("Vertical","delete","ID"));
 $this->page->assign("edit_url",$this->request->createURL("Vertical","edit","ID"));
 $this->page->assign("action",$this->request->createURL("Vertical","searchVertical"));
 $this->page->getPage("verticals_search_form.tpl");
}

public function searchVertical()
{
 $this->page->assign("do3",$_GET['do']); 
 $this->page->assign("action3",$_GET['action']);
 $this->page->assign("viewVertical",$this->request->createURL("Vertical","viewVertical"));
 $this->page->assign("verticalAddFormShow",$this->request->createURL("Vertical","verticalAddFormShow"));
 $this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
 $this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
 $this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
 $this->page->assign("searchVertical",$this->request->createURL("Vertical","searchVerticals"));
 $this->page->assign("delete",$this->request->createURL("Vertical","delete","ID"));
 $this->page->assign("edit_url",$this->request->createURL("Vertical","edit","ID"));
 $retArr=$this->verticalFacade->validatesearch($_GET);
 
 if($retArr['result'])
 {
	 $result=$this->verticalFacade->searchVertical($_GET, $this->request->getAttribute("fr"));//prexit($result['listings']);
	/* if(count($result['listings'])==0)
	 {
	 $retArray = array("result"=>false, "message"=>'No records found!');
	 $this->request->setAttribute("message", $retArray['message']);
	 $this->searchVerticals();
	 } */
	
	  $this->page->assign("count",count($result['listings']));
	 $this->page->assign("values",$result['listings']);
	 $this->page->assign("paging", $result['paging']);
	 $this->page->getPage("verticals_list.tpl");
 }
 else
 {
     $this->request->setAttribute("message", $retArr['message']);
	 $this->searchVerticals();
 
 }
 
}
 
}
?>