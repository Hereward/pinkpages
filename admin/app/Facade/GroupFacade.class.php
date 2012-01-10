<?php
class GroupFacade extends MainFacade {

	public function __construct(MyDB $MyDB){           //Start of The __contructor.purpose is to assign database parmeters to                                                       //a variable acting as an object and using that object to declare
		$this->MyDB = $MyDB;                           //the table name,sequence name and primary column.
		$this->MyDB->table="groups";
		$this->MyDB->sequenceName="groups";
		$this->MyDB->primaryCol="group_id";
	}

	public function fetchClassifications()
	{
		$SQL="SELECT
		            *
			  FROM
			        local_classification";
		$rec=$this->MyDB->query($SQL);
		return $rec;
	}

	public function groupAdd($post)
	{
		$res1 =$this->__groupValidate($post);
		if(!$res1['result'])
		{
			return $res1;
		}

		$sqlGet="select level from groups where group_id={$post['parent_group']}";
		$resGet=$this->MyDB->query($sqlGet);

		$sql = "INSERT
	          INTO 
			        `groups` (`group_id`, `group_title`, `group_description`,parent_id,level, `insert_time`)
		      VALUES 
			        (NULL, '{$post['group_title']}', '{$post['group_description']}',{$post['parent_group']},{$resGet[0]['level']}+1, NOW())";
		$this->MyDB->query($sql);
		$sql="SELECT
	             group_id
		   FROM
		         groups";
		$a=$this->MyDB->getInsertId($sql);
		if(isset($post['classification'])) 
		{
			for($i=0;$i<count($post['classification']);$i++)
			{
				if($post['classification'][$i])
				 {
					  $sql = "INSERT
			            INTO 
						      `group_classification` (`id`, `group_id`, `classification_id`) 
					 	VALUES
						       ('','{$a}','{$post['classification'][$i]}')";
					$this->MyDB->query($sql);
				}
			}
		}
		$retArray = array("result"=>true, "message"=>'Added');
		return $retArray;
	}

   	private function __groupValidate(&$data)
	{

		$retArray = array("result"=>false, "message"=>'');
		$errors = array();
		if(empty($data['group_title']))
		{
			$errors[] = "Group Title is blank!!";
		}
		/*if($data['classification'][0]=='select')
		{
			$errors[] = "Please Select any Classification!!";
		}*/
		if(count($errors) == 0)
		{
			$retArray['result'] = true;
		}
		$retArray['message'] = $errors;
		return $retArray;
	}
	public function   viewGroupsForOption(&$OptStr,$id,$group_id=0,$parent_id=0){

		$sql2="SELECT *  FROM `groups` WHERE parent_id={$id} AND group_id <>$group_id"   ;
		$listings2=$this->MyDB->query($sql2);

		foreach ($listings2 as $k=>$category2) {
			
			$selected = ($parent_id==$category2['group_id'])?"selected":"";
			$OptStr.="<option value='{$category2['group_id']}' $selected >".str_repeat("--",$category2['level']-1)."{$category2['group_title']}</option>" ;
			$this->viewGroupsForOption($OptStr, $category2['group_id'],$group_id,$parent_id);

		}

	}

	public function viewGroups($fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
	{
		$FinalArr = array();
		$sql="SELECT
	             *
	        FROM
			      `groups` 
			ORDER BY group_title ";

		$listings=$this->MyDB->query($sql);
		//        echo "<pre>";print_r($listings);
		$i=0;
		foreach ($listings as $k=>$category)
		{
			$ln = array();
			$FinalArr[$i]['group_id']=$category['group_id'];
			$FinalArr[$i]['group_title']=$category['group_title'];
			$FinalArr[$i]['group_description']=$category['group_description'];

			$sql="SELECT
	             *
	        FROM
			      group_classification as vc,local_classification as lc
	        WHERE
			      vc.group_id={$category['group_id']} AND vc.classification_id=lc.localclassification_id";
			$temp=$this->MyDB->query($sql);

			foreach ($temp as $k=>$lname)
			{
				$ln[]=$lname['localclassification_name'];
			}
			$FinalArr[$i]['Name']= implode(",<br/>", $ln);
			$i++;
		}
		//pre($FinalArr);
		$SQL="SELECT
                    count(group_id) AS cnt
			  FROM  
			        `groups`"; 		
		$count_all = $this->MyDB->query($SQL);

		$retArray['listings'] = $FinalArr;
		$retArray['paging'] = Paging::numberPaging($count_all[0]['cnt'], $fr, $noOfRecords);
		return $retArray;
	}

	public function delete()
	{
		$retArray = array("result"=>true, "message"=>'deleted');
		$id=$_GET['ID'];
		$sql = "SELECT * FROM groups WHERE parent_id=$id";
		$rs = $this->MyDB->query($sql);
		if($rs) {
			$retArray['result']= false;
			$retArray['message']= "Please delete all of its sub categories";
		}
		else {
			$sql="DELETE
					FROM
				    group_classification
			    WHERE
				      group_id=$id";
			$a=$this->MyDB->query($sql);

			$sql="DELETE
				    FROM
				groups
			    	WHERE
					group_id=$id";
			$this->MyDB->query($sql);
		}
		return $retArray;
	}

	public function fetchGroupDetails($id)
	{
		$sql="SELECT
	               *
		    FROM
			      groups 
			WHERE
			      group_id=".$this->MyDB->quote($id);
		$a=$this->MyDB->query($sql);
		return $a;
	}
	
	/**
	*@desc  This function is used for fetching all classification.
	*/
	public function classificationList($id)
	{
		 $list_classification	="SELECT group_classification.classification_id,
		 								 local_classification.localclassification_name 
										 FROM group_classification,local_classification 
										 WHERE group_classification.classification_id=local_classification.localclassification_id 
										 	AND group_classification.group_id=".$this->MyDB->quote($id); 
		$result					=$this->MyDB->query($list_classification);
		return $result;
	}
	
		/**
	*@desc  This function is used for fetching the classification details.
	*/
	public function fetchClassificationDetails()
	{
		$SQL="SELECT
		            localclassification_id,localclassification_name
			  FROM
			        local_classification";
		$rec=$this->MyDB->query($SQL);
		return $rec;
	}

	
	
	public function fetchGroupClassifications($id)
	{
		$sql="SELECT
	               classification_id
		    FROM
			      group_classification
			WHERE
			     group_id=".$this->MyDB->quote($id);
		$rs = $this->MyDB->query($sql);	
		
		$classifications = array();
		if($rs) {
			foreach ($rs as $classification) {
				$classifications[] = $classification['classification_id'];
			}
		}
		return $classifications;
	}

	public function editAddData($post)
	{
		$retArray = array("result"=>true, "message"=>'General details Updated');
		$id=$_GET['ID'];
		$result =$this->__groupValidate($post);
		if(!$result['result'])
		{
			return $result;
		}
		if($post['parent_group']) {
			echo $sql = "SELECT level FROM groups WHERE group_id={$post['parent_group']}";
			$rs = $this->MyDB->query($sql);
			$parent_level = $rs[0]['level'];
		}
		else {
			$parent_level = 0;
		}
		
		 $sql="UPDATE
		              groups
			    SET
				     group_title='{$post['group_title']}',
				     group_description='{$post['group_description']}',
				     parent_id='{$post['parent_group']}',
				     level={$parent_level}+1
				WHERE
				     group_id=$id ";
		$this->MyDB->query($sql);
		
		/*$sql="DELETE
				FROM group_classification 
				WHERE
				group_id=$id";
		$this->MyDB->query($sql);
		if(isset($post['classification'])) {
			for($i=0;$i<count($post['classification']);$i++)
			{
				if($post['classification'][$i]) {
					$sql = "INSERT
			            INTO 
						      `group_classification` (`id`, `group_id`, `classification_id`) 
					 	VALUES
						       ('','{$id}','{$post['classification'][$i]}')";
					$this->MyDB->query($sql);
				}
			}
		}*/
		return $retArray;
	}
	
	public function editAddClassificationData($post,$get)
	{
		$id					=$get['ID'];

		/*$sql="DELETE
				FROM group_classification 
				WHERE
				group_id=$id";
		$this->MyDB->query($sql);*/
		/*if(isset($post['classification'])) {
			for($i=0;$i<count($post['classification']);$i++)
			{
				if($post['classification'][$i]) {
					echo $sql = "INSERT
			            INTO 
						      `group_classification` (`id`, `group_id`, `classification_id`) 
					 	VALUES
						       ('','{$id}','{$post['classification'][$i]}')";
					$this->MyDB->query($sql);
				}
			}
		}
		return $retArray;*/
		
		foreach($post['classification'] as $value)
		{
		
		$add_classification 	= "INSERT
		INTO 
		`group_classification` (`id`, `group_id`, `classification_id`) 
		VALUES
		('','{$id}','{$value}')";
		
		$result  				= $this->MyDB->query($add_classification);
		
		}
		$addClass					= array("result"=>true, "message"=>'Classification Added Successfully',"ID"=>$id);
		return $addClass;
	}
	
	public function deleteClassification($post,$get)
	{
		$id=$get['ID'];
		
		$deleteClass 	= (!empty($post['deleteClass']))?$post['deleteClass']:NULL;
		foreach($deleteClass as $value)
		{		
		$del_classification = "DELETE FROM group_classification WHERE group_id=$id AND classification_id='".$value."'"; 
		$result  =$this->MyDB->query($del_classification);
		}
		$delClass=array("result"=>true, "message"=>'Classification Added Successfully',"ID"=>$id);
		return $delClass;
	}

	private function __userlistingValidation(&$data)
	{
		$retArray = array("result"=>false, "message"=>'');
		$errors = array();
		/*if($data['classification'][0]=='select')
		{
			$errors[] = "Please Select any Classification!!";
		}*/
		if(count($errors) == 0)
		{
			$retArray['result'] = true;
		}
		$retArray['message'] = $errors;
		return $retArray;
	}

	public function searchGroup($get, $fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
	{

		$FinalArr = array();
		$sql="SELECT
	                 *
	          FROM
			         groups
			  WHERE 
			         group_title LIKE '%{$get['name']}%'";

		$listings=$this->MyDB->query($sql);
		$i=0;
		foreach ($listings as $k=>$category)
		{
			$ln = array();
			$FinalArr[$i]['group_id']=$category['group_id'];
			$FinalArr[$i]['group_title']=$category['group_title'];
			$FinalArr[$i]['group_description']=$category['group_description'];

			$sql="SELECT
	             *
	        FROM
			      group_classification as vc,local_classification as lc
	        WHERE
			      vc.group_id={$category['group_id']} AND vc.classification_id=lc.localclassification_id";
			$temp=$this->MyDB->query($sql);

			foreach ($temp as $k=>$lname)
			{
				$ln[]=$lname['localclassification_name'];
			}
			$FinalArr[$i]['Name']= implode(",<br/>", $ln);
			$i++;
		}

		$SQL="SELECT
                    count(group_id) AS cnt
		  FROM  
			        groups
		  WHERE  
		            group_title='{$get['name']}'			
		 "; 		
		$count_all = $this->MyDB->query($SQL);

		$retArray['listings'] = $FinalArr;
		$retArray['paging'] = Paging::numberPaging($count_all[0]['cnt'], $fr, $noOfRecords);
		return $retArray;


	}

	public function validatesearch($get)
	{
		$retArray = array("result"=>false, "message"=>'');
		$errors = array();
		if(empty($get['name']))
		{
			$errors[] = "Please enter name to search!!";
		}
		if(count($errors) == 0)
		{
			$retArray['result'] = true;
		}
		$retArray['message'] = $errors;
		return $retArray;
	}

}
?>	