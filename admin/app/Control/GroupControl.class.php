<?php
class GroupControl extends MainControl
{

    private $groupFacade;                           //A private variable that will be used as object for AdminFacade class.
    public function __construct($request)           //Start of The __contructor.purpose, to create objects for Facade
    {                                               //and for AdminPage,used as main page to show all templates.
        parent::__construct($request);

        $this->groupFacade = new GroupFacade($GLOBALS['conn']);
        $this->request = $request;
        $this->page = new AdminPage();
    }                                                //End of the constructor.


public function groupAddFormShow()
{
    $this->page->pageTitle = "Add vertical"; 
    $this->page->assign("do3",$_GET['do']); 
    $this->page->assign("action3",$_GET['action']);
	
	$title		    = (!empty($_POST['group_title']))?$_POST['group_title']:NULL;
	$description	= (!empty($_POST['group_description']))?$_POST['group_description']:NULL;
	
	$this->page->assign("group_title",$title);
	$this->page->assign("group_description",$description);
				

	$this->page->assign("delete",$this->request->createURL("Group","delete","ID"));
	$this->page->assign("edit_url",$this->request->createURL("Group","edit","ID"));
	$this->page->assign("action",$this->request->createURL("Group","editAddData","ID"));	
	$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
	$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
	$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
	$this->page->assign("searchGroup",$this->request->createURL("Group","searchGroups"));
	$this->page->assign("groupAddFormShow",$this->request->createURL("Group","groupAddFormShow"));
	$this->page->assign("action1",$this->request->createURL("Group","groupAddData"));
	$this->page->assign("viewGroup",$this->request->createURL("Group","viewGroup"));
	
     $viewGroupsForOption = '';
    $this->groupFacade->viewGroupsForOption($viewGroupsForOption, 0);
    $this->page->assign("viewGroupsForOption",$viewGroupsForOption);
    
	$classifications=$this->groupFacade->fetchClassifications();
  
	$this->page->assign("values1",$classifications);
	$this->page->getPage("group_add_form.tpl");
}

public function groupAddData()
{
  $this->page->assign("do3",$_GET['do']); 
  $this->page->assign("action3",$_GET['action']);
 
 $this->page->assign("viewGroup",$this->request->createURL("Group","viewGroup"));
 $this->page->assign("groupAddFormShow",$this->request->createURL("Group","groupAddFormShow"));
 $this->page->assign("delete",$this->request->createURL("Group","delete","ID"));
 $this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
 $this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
 $this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
 $this->page->assign("searchGroup",$this->request->createURL("Group","searchGroups"));
 $this->page->assign("edit_url",$this->request->createURL("Group","edit","ID"));
 $this->page->assign("action",$this->request->createURL("Group","editAddData","ID"));	
 $res= $this->groupFacade->groupAdd($_POST);
	 if($res['result'])
	 {
	  $this->request->setAttribute("message-succ", $res['message']);
	  $this->request->redirect("Group", "viewGroup");
	 }
	 else
	 {
	  $this->request->setAttribute("message", $res['message']);
	  $this->groupAddFormShow();
	 }
}
	
public  function viewGroup()
{
 $this->page->pageTitle = "Verticals";
 $this->page->assign("do3",$_GET['do']); 
 $this->page->assign("action3",$_GET['action']);
 $this->page->assign("viewGroup",$this->request->createURL("Group","viewGroup"));
 $this->page->assign("groupAddFormShow",$this->request->createURL("Group","groupAddFormShow"));
 $this->page->assign("delete",$this->request->createURL("Group","delete","ID"));
 $this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
 $this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
 $this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
 $this->page->assign("searchGroup",$this->request->createURL("Group","searchGroups"));
 $this->page->assign("edit_url",$this->request->createURL("Group","edit","ID"));
 $this->page->assign("action",$this->request->createURL("Group","editAddData","ID"));
 $res=$this->groupFacade->viewGroups($this->request->getAttribute("fr"));
 $this->page->assign("values",$res['listings']);
 $this->page->assign("paging", $res['paging']);
 $this->page->getPage("groups_list.tpl");
 
}

public  function delete()
{
 $this->page->assign("do3",$_GET['do']); 
 $this->page->assign("action3",$_GET['action']);
 $this->page->assign("viewGroup",$this->request->createURL("Group","viewGroup"));
 $this->page->assign("groupAddFormShow",$this->request->createURL("Group","groupAddFormShow"));
 $this->page->assign("delete",$this->request->createURL("Group","delete","ID"));
 $this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
 $this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
 $this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
 $this->page->assign("searchGroup",$this->request->createURL("Group","searchGroups"));
 $this->page->assign("edit_url",$this->request->createURL("Group","edit","ID"));
 $this->page->assign("edit_classifications",$this->request->createURL("Group","addVerticalClassification_form"));
 $this->page->assign("action",$this->request->createURL("Group","editAddData","ID"));
 $res=$this->groupFacade->delete($_POST);
   if($res['result'])
   {
    $this->request->setAttribute("message-succ", $res['message']);
    $this->viewGroup();
   }
   else
   {
     $this->request->setAttribute("message", $res['message']);
     $this->viewGroup();
   }
}

public function edit()
{    
   $this->page->pageTitle = "Edit vertical";
    $this->page->assign("do3",$_GET['do']); 
    $this->page->assign("action3",$_GET['action']);
	$this->page->assign("viewGroup",$this->request->createURL("Group","viewGroup"));
	$this->page->assign("edit_genaral",$this->request->createURL("Group","edit"));
	$this->page->assign("edit_classification",$this->request->createURL("Group","edit_classification"));
	$this->page->assign("groupAddFormShow",$this->request->createURL("Group","groupAddFormShow"));
    $this->page->assign("delete",$this->request->createURL("Group","delete","ID"));
	$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
	$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
	$this->page->assign("searchGroup",$this->request->createURL("Group","searchGroups"));
	$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
    $this->page->assign("edit_url",$this->request->createURL("Group","edit","ID"));
	$this->page->assign("edit_classifications",$this->request->createURL("Group","addVerticalClassification_form"));
    $this->page->assign("action",$this->request->createURL("Group","editAddData","ID"));
	
	$classifications=$this->groupFacade->fetchClassifications();
	$res=  $this->groupFacade->fetchGroupDetails($_GET['ID']);
	$group_classifications =  $this->groupFacade->fetchGroupClassifications($_GET['ID']);
    $parent_id=$res[0]['parent_id'];
    $group_id=$res[0]['group_id'];
	$optionInput = '';
   
	foreach($classifications as $val)
	{
		$optionInput .= "<option value='".$val['localclassification_id']."' ";
		if(in_array($val['localclassification_id'], $group_classifications))
		$optionInput .= "'selected=selected'";
		$optionInput .= ">{$val['localclassification_name']}</option>";
	}
	$this->page->assign("optionInput",$optionInput);
	$this->page->assign("values1",$classifications);
	  //    prexit($classifications);
    $viewGroupsForOption = '';
    $this->groupFacade->viewGroupsForOption($viewGroupsForOption, 0,$group_id,$parent_id);
    $this->page->assign("viewGroupsForOption",$viewGroupsForOption);
	$this->page->assign("values",$res);
	$this->page->getPage("group_edit_form.tpl");
}

public function edit_classification()
{    
   $this->page->pageTitle = "Edit vertical";
    $this->page->assign("do3",$_GET['do']); 
    $this->page->assign("action3",$_GET['action']);
	$this->page->assign("viewGroup",$this->request->createURL("Group","viewGroup"));
	$this->page->assign("edit_genaral",$this->request->createURL("Group","edit"));
	$this->page->assign("edit_classification",$this->request->createURL("Group","edit_classification"));
	$this->page->assign("groupAddFormShow",$this->request->createURL("Group","groupAddFormShow"));
    $this->page->assign("delete",$this->request->createURL("Group","delete","ID"));
	$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
	$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
	$this->page->assign("searchGroup",$this->request->createURL("Group","searchGroups"));
	$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
    $this->page->assign("edit_url",$this->request->createURL("Group","edit","ID"));
    $this->page->assign("action",$this->request->createURL("Group","editAddClassificationData","ID"));
	$this->page->assign("deleteAction",$this->request->createURL("Group","deleteClassification","ID"));
	/*$classifications=$this->groupFacade->fetchClassifications();
	$res=  $this->groupFacade->fetchGroupDetails($_GET['ID']);
	$group_classifications =  $this->groupFacade->fetchGroupClassifications($_GET['ID']);
    $parent_id=$res[0]['parent_id'];
    $group_id=$res[0]['group_id'];
	$optionInput = '';
   
	foreach($classifications as $val)
	{
		$optionInput .= "<option value='".$val['localclassification_id']."' ";
		if(in_array($val['localclassification_id'], $group_classifications))
		$optionInput .= "'selected=selected'";
		$optionInput .= ">{$val['localclassification_name']}</option>";
	}
	$this->page->assign("optionInput",$optionInput);
	$this->page->assign("values1",$classifications);
	  //    prexit($classifications);
    $viewGroupsForOption = '';
    $this->groupFacade->viewGroupsForOption($viewGroupsForOption, 0,$group_id,$parent_id);
    $this->page->assign("viewGroupsForOption",$viewGroupsForOption);
	$this->page->assign("values",$res);*/
	$res=  $this->groupFacade->fetchGroupDetails($_GET['ID']);
	$this->page->assign("values",$res);
	
	$classificationListResult	=$this->groupFacade->classificationList($_GET['ID']);
	$classificationList			=$this->groupFacade->fetchClassificationDetails();
	$result 					= array_diff_assoc($classificationList, $classificationListResult);
	$this->page->assign("classificationList",$result);
	$this->page->assign("classificationListResult",$classificationListResult);
		
	$this->page->getPage("group_edit_classification_form.tpl");
}

	public function deleteClassification()
	{
		$this->page->pageTitle = "Edit vertical";
		$this->page->assign("do3",$_GET['do']); 
		$this->page->assign("action3",$_GET['action']);
		$this->page->assign("viewGroup",$this->request->createURL("Group","viewGroup"));
		$this->page->assign("edit_genaral",$this->request->createURL("Group","edit"));
		$this->page->assign("edit_classification",$this->request->createURL("Group","edit_classification"));
		$this->page->assign("groupAddFormShow",$this->request->createURL("Group","groupAddFormShow"));
		$this->page->assign("delete",$this->request->createURL("Group","delete","ID"));
		$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
		$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
		$this->page->assign("searchGroup",$this->request->createURL("Group","searchGroups"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		$this->page->assign("edit_url",$this->request->createURL("Group","edit","ID"));
		$this->page->assign("action",$this->request->createURL("Group","editAddClassificationData","ID"));
		$this->page->assign("deleteAction",$this->request->createURL("Group","deleteClassification","ID"));
		
		$classificationDelResult	=$this->groupFacade->deleteClassification($_POST,$_GET);
		
		if($classificationDelResult['result'])
		{	
		$this->request->redirect("Group","edit_classification","ID={$classificationDelResult['ID']}&msg=3");
		}
		else
		{
		$this->request->setAttribute("message", $classificationDelResult['message']);
		$this->edit_classification();		
		}				
	}


public function editAddData()
{
	$this->page->assign("do3",$_GET['do']); 
	$this->page->assign("action3",$_GET['action']);
	$this->page->assign("viewGroup",$this->request->createURL("Group","viewGroup"));
    $this->page->assign("groupAddFormShow",$this->request->createURL("Group","groupAddFormShow"));
	$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
	$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
	$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
	$this->page->assign("searchGroup",$this->request->createURL("Group","searchGroups"));
    $this->page->assign("delete",$this->request->createURL("Group","delete","ID"));
    $this->page->assign("edit_url",$this->request->createURL("Group","edit","ID"));
    $this->page->assign("action",$this->request->createURL("Group","editAddData","ID"));
    $res=$this->groupFacade->editAddData($_POST);//prexit($res);
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

public function editAddClassificationData()
{
	$this->page->assign("do3",$_GET['do']); 
	$this->page->assign("action3",$_GET['action']);
	$this->page->assign("viewGroup",$this->request->createURL("Group","viewGroup"));
    $this->page->assign("groupAddFormShow",$this->request->createURL("Group","groupAddFormShow"));
	$this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
	$this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
	$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
	$this->page->assign("searchGroup",$this->request->createURL("Group","searchGroups"));
    $this->page->assign("delete",$this->request->createURL("Group","delete","ID"));
    $this->page->assign("edit_url",$this->request->createURL("Group","edit","ID"));
    $this->page->assign("action",$this->request->createURL("Group","editAddData","ID"));
    $res=$this->groupFacade->editAddClassificationData($_POST,$_GET);
	if($res['result'])
	{
		$this->request->redirect("Group","edit_classification","ID={$res['ID']}&msg=2");
	}
}

public function searchGroups()
{
 $this->page->pageTitle = "Search verticals";
 $this->page->assign("do3",$_GET['do']); 
 $this->page->assign("action3",$_GET['action']);
 $this->page->assign("viewGroup",$this->request->createURL("Group","viewGroup"));
 $this->page->assign("groupAddFormShow",$this->request->createURL("Group","groupAddFormShow"));
 $this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
 $this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
 $this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
 $this->page->assign("delete",$this->request->createURL("Group","delete","ID"));
 $this->page->assign("edit_url",$this->request->createURL("Group","edit","ID"));
 $this->page->assign("action",$this->request->createURL("Group","searchGroup"));
 $this->page->getPage("groups_search_form.tpl");
}

public function searchGroup()
{
 $this->page->assign("do3",$_GET['do']); 
 $this->page->assign("action3",$_GET['action']);
 $this->page->assign("viewGroup",$this->request->createURL("Group","viewGroup"));
 $this->page->assign("groupAddFormShow",$this->request->createURL("Group","groupAddFormShow"));
 $this->page->assign("privacyStatement",$this->request->createURL("Content","privacyStatement"));
 $this->page->assign("termsAndConditions",$this->request->createURL("Content","termsAndConditions"));
 $this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
 $this->page->assign("searchGroup",$this->request->createURL("Group","searchGroups"));
 $this->page->assign("delete",$this->request->createURL("Group","delete","ID"));
 $this->page->assign("edit_url",$this->request->createURL("Group","edit","ID"));
 $retArr=$this->groupFacade->validatesearch($_GET);
 
 if($retArr['result'])
 {
	 $result=$this->groupFacade->searchGroup($_GET, $this->request->getAttribute("fr"));//prexit($result['listings']);
	/* if(count($result['listings'])==0)
	 {
	 $retArray = array("result"=>false, "message"=>'No records found!');
	 $this->request->setAttribute("message", $retArray['message']);
	 $this->searchGroups();
	 } */
	
	  $this->page->assign("count",count($result['listings']));
	 $this->page->assign("values",$result['listings']);
	 $this->page->assign("paging", $result['paging']);
	 $this->page->getPage("groups_list.tpl");
 }
 else
 {
     $this->request->setAttribute("message", $retArr['message']);
	 $this->searchGroups();
 
 }
 
}
 
}
?>