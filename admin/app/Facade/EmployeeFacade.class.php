<?php
class EmployeeFacade extends MainFacade {

    public function __construct(MyDB $MyDB) {
		
        $this->MyDB = $MyDB;

        $this->MyDB->table=TBL_LOCAL_USER;
        $this->MyDB->sequenceName=TBL_LOCAL_USER;
        $this->MyDB->primaryCol="localuser_id";
    }/* END __construct */

    
	public function viewfetchDetails()
	{   
	 $sql="SELECT
				 * 
		   FROM
				local_businesses
		   WHERE expired=0
				AND client_id='".getSession("userid")."'";
	 $res=$this->MyDB->query($sql);
	 return $res;
	
	} 
	
	public function fetchRank()
	{
	 $SQL="select MAX(Rank) AS Rank from  local_businesses
	 		WHERE expired=0 limit 0, 1";
	 $res=$this->MyDB->query($SQL);
        return $res;
	
	}
	public function fetchRankRate()
	{
		$SQL="SELECT
		            *
			  FROM
			         rank_rate";
		$rec=$this->MyDB->query($SQL);
		return $rec;
	}

	public function addlist1($post,$logo)
	{
        
		$initials 		= (!empty($post['initials']))?$post['initials']:NULL;
		$name 			= (!empty($post['name']))?$post['name']:NULL;
		$street1 		= (!empty($post['street1']))?$post['street1']:NULL;
		$street2 		= (!empty($post['street2']))?$post['street2']:NULL;
		$phonestd 		= (!empty($post['phonestd']))?$post['phonestd']:NULL;
		$phone 			= (!empty($post['phone']))?$post['phone']:NULL;
		$faxstd 		= (!empty($post['faxstd']))?$post['faxstd']:NULL;
		$fax 			= (!empty($post['fax']))?$post['fax']:NULL;
		$email 			= (!empty($post['email']))?$post['email']:NULL;
		$url 			= (!empty($post['url']))?$post['url']:NULL;
		$origin 		= (!empty($post['origin']))?$post['origin']:NULL;
		$mobile 		= (!empty($post['mobile']))?$post['mobile']:NULL;
		$contact 		= (!empty($post['contact']))?$post['contact']:NULL;
		$postcode 		= (!empty($post['postcode']))?$post['postcode']:NULL;
		$description 	= (!empty($post['description']))?$post['description']:NULL;
		$classification = (!empty($post['classification']))?$post['classification']:NULL;
		$state 			= (!empty($post['state']))?$post['state']:NULL;
		$listing 		= (!empty($post['listing']))?$post['listing']:NULL;
		$rank 			= (!empty($post['rank']))?$post['rank']:NULL;
		$archived 		= (!empty($post['archived']))?$post['archived']:NULL;
		$sub 			= (!empty($post['suburb']))?$post['suburb']:NULL;
		
		$logoname		= $logo['logo']['name'];
		$suburb			= explode(',',$sub);
		$shire			= explode(';',$_POST['region']);

		$listingValidation =$this->__userlistingValidation($post,$logo);

		if(!$listingValidation['result'])
		{
			return $listingValidation;
		}

		$queryGetShire	="SELECT shiretown_id
		 					FROM shire_towns 
							WHERE shiretown_postcode='".$postcode."' 
								AND shiretown_townname='".$suburb[1]."'";
		$shireResult	=$this->MyDB->query($queryGetShire);


		$addBusiness	="INSERT INTO
		                   local_businesses(`business_initials` , `business_name` , `business_street1` , `business_street2` , `business_phonestd` , `business_phone` , `business_faxstd` , `business_fax` , `business_email` , `business_url` , `business_origin` , `business_mobile` , `business_contact` ,`client_id`, `business_postcode` , `shiretown_id` , `business_suburb`,`business_logo`,`business_description`,`classification`,`business_state`,`bold_listing`,`archived`,`Rank`,`shire_name`,`shire_town`)
                     VALUES (
'{$initials}', '{$name}', '{$street1}', '{$street2}', '{$phonestd}', '{$phone}', '{$faxstd}', '{$fax}', '{$email}', '{$url}', '{$origin}', '{$mobile}', '{$contact}',".getSession("userid").", '{$postcode}', '{$shireResult[0]['shiretown_id']}', '{$suburb[1]}','{$logoname }','{$description}','{$classification}', '{$state}','{$listing}','{$archived}','{$rank}','{$shire[1]}','{$suburb[1]}')";

		$resultAddBusiness	=$this->MyDB->query($addBusiness);

		$insertedBusinessId	=$this->MyDB->getInsertID($resultAddBusiness);

		$addBusiness=array("result"=>true, "message"=>'Business Added Successfully',"InsertID"=>$insertedBusinessId);

		return $addBusiness;
	}
	
	

	public function addClassificationDetail($post,$get)
	{
		$BusinessID 	= (!empty($get['ID']))?$get['ID']:NULL;

		foreach($post['addclassification'] as $value)
		{

			$add_classification = "INSERT INTO `business_classification` (`businessclassification_id`, `business_id`, `localclassification_id`) VALUES ('', '{$BusinessID}', '{$value}')";

			$result  =$this->MyDB->query($add_classification);

		}
		$addClass=array("result"=>true, "message"=>'Classification Added Successfully',"ID"=>$BusinessID);
		return $addClass;
	}


	public function classificationList($get)
	{
		$BusinessID 	= (!empty($get['ID']))?$get['ID']:NULL;

		$list_classification	="SELECT business_classification.localclassification_id, local_classification.localclassification_name FROM business_classification,local_classification WHERE business_id='".$BusinessID."' AND business_classification.localclassification_id=local_classification.localclassification_id";
		$result					=$this->MyDB->query($list_classification);
		return $result;
	}

	public function deleteClassification($post,$get)
	{
		$BusinessID 	= (!empty($get['ID']))?$get['ID']:NULL;

		foreach($post['deleteClass'] as $value)
		{

			$del_classification = "DELETE FROM `business_classification` WHERE `business_id` ='".$BusinessID."' AND `localclassification_id` = '".$value."'";

			$result  =$this->MyDB->query($del_classification);

		}
		$delClass=array("result"=>true, "message"=>'Classification deleted successfully',"ID"=>$BusinessID);
		return $delClass;
	}

	public function addRank($post,$get)
	{
		$BusinessID 	= (!empty($get['ID']))?$get['ID']:NULL;
		$email 			= (!empty($post['email']))?$post['email']:NULL;
		$web 			= (!empty($post['web']))?$post['web']:NULL;
		$list_classification	="SELECT business_classification.localclassification_id, local_classification.localclassification_name FROM business_classification,local_classification WHERE business_id='".$BusinessID."' AND business_classification.localclassification_id=local_classification.localclassification_id";
		$result_class					=$this->MyDB->query($list_classification);

		$list_region="SELECT * FROM shire_names";
		$result_region=$this->MyDB->query($list_region);

		foreach($result_region as $valRegion)
		{
			foreach($result_class as $valClass)
			{

				$key = $valRegion['shirename_id']."_".$valClass['localclassification_id'];
					
					
			
					
				if(isset($post[$key]) && !empty($post[$key]))
				{
					$rank = $post[$key];
					
					  $deleteQuery	="DELETE FROM business_ranks WHERE `business_id` ='{$BusinessID}' AND `localclassification_id`='{$valClass['localclassification_id']}' AND `shirename_id`='{$valRegion['shirename_id']}'";
					$this->MyDB->query($deleteQuery);

					  $rankQuery      ="INSERT INTO `business_ranks` (
										`businessrank_id` ,
										`business_id` ,
										`localclassification_id` ,
										`businessrank_rank` ,
										`shirename_id` ,
										`businessrank_cost` ,
										`businessrank_timestamp` ,
										`businessrank_expire` ,
										`user_id` ,
										`businessrank_tempfield`
										)
										VALUES (
										'' , '{$BusinessID}', '{$valClass['localclassification_id']}', '{$rank}', '{$valRegion['shirename_id']}', '', '' , '' , ".getSession("userid").", ''
										)";
					$result_rank		=$this->MyDB->query($rankQuery);
				}
			}

		}
		
		$addRank=array("result"=>true, "message"=>'Rank added successfully',"ID"=>$BusinessID);
		return $addRank;
	}
	
	public function rankDetails($get)
	{
		$BusinessID 	= (!empty($get['ID']))?$get['ID']:NULL;	
		$rank_query		="SELECT * FROM business_ranks WHERE business_id={$BusinessID}";
		$rank_list		=$this->MyDB->query($rank_query);
		return $rank_list;
	}

	
	private function __userlistingValidation(&$data,&$logo)
	{
		$retArray = array("result"=>false, "message"=>'');
		$errors = array();


		if(empty($data['initials']))
		{
			$errors[] = "initials is blank!!";
		}

		if(empty($data['name']))
		{
			$errors[] = "name is blank!!";
		}

		if(empty($data['street1']))
		{
			$errors[] = "street1 is blank!!";
		}

		if(empty($data['street2']))
		{
			$errors[] = "street2 is blank!!";
		}

		if($data['region']=='--Select One--')
		{
			$errors[] = "Please Select any Region!!";
		}

		if(@$data['suburb']=='--Select One--')
		{
			$errors[] = "Please Select any Suburb!!";
		}

		if(empty($data['postcode']))
		{
			$errors[] = "postcode is blank!!";
		}

		if(empty($data['description']))
		{
			$errors[] = "description is blank!!";
		}

		if(empty($logo['logo']['name']))
		{
			$errors[] = "Please Select any Logo!!";
		}

		if(count($errors) == 0)
		{
			$retArray['result'] = true;
		}
		$retArray['message'] = $errors;
		return $retArray;
	}

	
	
	
	
	
	
	
	
	
	
	
	public function addlist($post,$logo)
	{ 
	    $sql="SELECT localclassification_id FROM  local_classification  WHERE localclassification_name='".$post['classification']."'";  
		$clasid=$this->MyDB->query($sql);
	 
		$logoname=$logo['logo']['name'];
		$shire=explode(';',$_POST['region']);//prexit($shire);
		
        $res12 =$this->__userRegisterValidation($post);
		
        if(!$res12['result'])
        {
          return $res12;
        }
		
		
        /*$SQL2="SELECT * FROM local_businesses WHERE business_email='".$post['email']."'";
        $result=$this->MyDB->query($SQL2);*/
		
		if($post['listing'] =='1')
		{
			echo $CHECK_RANK	="SELECT * FROM local_businesses 
								WHERE expired=0 
								AND classification='{$post['classification']}' AND shire_name='{$shire['1']}' AND Rank='{$post['rank']}'";
			
			$CHECK_RANK_RESULT	=$this->MyDB->query($CHECK_RANK);
		}
		
        /*if(count($result)>0)
        {
            $retArray = array("result"=>false, "message"=>'Email Already Exists!! please try some other name');
            return $retArray;
        }*/
		 if(count(@$CHECK_RANK_RESULT) > '0')
		{
			$retArray = array("result"=>false, "message"=>'This Rank is not available under this classification and region.');
            return $retArray;
		}
		else
		{
            $sub=explode(',',$_POST['suburb']);
			
            $SQL2="SELECT 
			             shiretown_id 
			       FROM 
				         shire_towns 
				   WHERE
				         shiretown_postcode='".$post['postcode']."' 
						 AND
						    shiretown_townname='".$sub[1]."'";
            $rec=$this->MyDB->query($SQL2);
			
			$shire=explode(';',$_POST['region']);
           	$SQL="INSERT INTO 
		                   local_businesses( `business_initials` , `business_name` , `business_street1` , `business_street2` , `business_phonestd` , `business_phone` , `business_faxstd` , `business_fax` , `business_email` , `business_url` , `business_origin` , `business_mobile` , `business_contact` ,`client_id`, `business_postcode` , `shiretown_id` , `business_suburb`,`business_logo`,`business_description`,`classification`,`business_state`,`bold_listing`,`Rank`,`shire_name`,`shire_town`)
                 VALUES (
'{$post['initials']}', '{$post['name']}', '{$post['street1']}', '{$post['street2']}', {$post['phonestd']}, {$post['phone']}, {$post['faxstd']}, {$post['fax']}, '{$post['email']}', '{$post['url']}', '{$post['origin']}', {$post['mobile']}, {$post['contact']},".getSession("userid").", '{$post['postcode']}', '{$rec[0]['shiretown_id']}', '{$sub[1]}','{$logoname }','{$post['description']}','{$post['classification']}', '{$post['state']}','{$post['listing']}','{$post['rank']}','{$shire[1]}','{$sub[1]}')";


            $res=$this->MyDB->query($SQL);
		    $busiId=$this->MyDB->getInsertID($res);
				   
			$sql = "INSERT INTO `business_classification` (`businessclassification_id`, `business_id`, `localclassification_id`) VALUES ('', '{$busiId}', '{$clasid[0]['localclassification_id']}')";	   
				
			$this->MyDB->query($sql) ;
		 $rec=array("result"=>true, "message"=>'Added Successfully',"InsertID"=>$busiId);
		 return $rec;
        }
	}	
	 
	 public function updateAdd($post)
 {
    $ID=$_GET['ID'];//prexit($ID);
    $SQL="UPDATE local_businesses SET Rank={$post['rank']} WHERE business_id={$ID}";
	$this->MyDB->query($SQL);
	$rec=array("result"=>true, "message"=>'Added Successfully');
    return $rec;
 }	
		
	public function fetchRegion()
    {
        $SQL="SELECT 
		            *
			  FROM
			        shire_names";
        $rec=$this->MyDB->query($SQL);
        return $rec;
    }
	
	public function getSuburb($get)
	{
		$SQL="SELECT 
		*
		FROM
		shire_towns
		WHERE shirename_id='{$get['ID']}'";
		$rec=$this->MyDB->query($SQL);
		return $rec;
	} 	
		
	
        
	private function __userRegisterValidation(&$data)
	   {
			$retArray = array("result"=>false, "message"=>'');
        $errors = array();
		if($data['classification']=='--Select One--') 
		{
            $errors[] = "Please Select any Classification!!";
        }
        if(empty($data['initials'])) 
		{
            $errors[] = "initials is blank!!";
        }
        if(empty($data['name'])) 
		{
            $errors[] = "name is blank!!";
        }
        if(empty($data['street1'])) 
		{
            $errors[] = "street1 is blank!!";
        }
        if(empty($data['street2'])) 
		{
            $errors[] = "street2 is blank!!";
        }
		
		if($data['suburb']=='--Select One--') 
		{
            $errors[] = "Please Select any Suburb!!";
        }
		
        if(empty($data['postcode']))
	    {
            $errors[] = "postcode is blank!!";
        }
        if(!preg_match("/^[0-9a-zA-Z_\.-]+\@[0-9a-zA-Z_\.-]+\.[0-9a-zA-Z_\.-]+$/",$data['email'])||empty($data['email']))
        {
            $errors[] = "email is not valid!!";
        }
        if(empty($data['description'])) 
		{
            $errors[] = "description is blank!!";
        }
        
        if(empty($data['contact']))
	    {
            $errors[] = "contact is blank!!";
        }
        if(count($errors) == 0) 
		{
            $retArray['result'] = true;
        }
        $retArray['message'] = $errors;
        return $retArray;
		  }

		
    public function fetchTownDetails()
    {  
	    $SQL="SELECT
		             *
			  FROM
			        shire_towns";
        $rec=$this->MyDB->query($SQL);
        return $rec;
    }
	
	 public function fetchDetails($post)
    {    
	    $SQL="SELECT
		            * 
		      FROM
			       local_businesses 
			  WHERE expired=0
			       AND client_id=".getSession("userid")."";
		$res=$this->MyDB->query($SQL);
        return $res;
   }
	
	 
	public function fetchClassificationDetails()
	{
	   $SQL="SELECT 
	               *
			 FROM 
			       local_classification";
	   $rec=$this->MyDB->query($SQL);
	   return $rec;
	 }
	
	
	public function editListingFetchDetails()
	{
		$condition = $_GET['ID'];
		$SQL="SELECT 
		            * 
			  FROM 
			       local_businesses
			  WHERE expired=0
			       AND business_id=$condition";
		$res=$this->MyDB->query($SQL);
		return $res;
	
    }
	
	
	public function searchBusiness($post)
	{  
	   $SQL="SELECT 
	               *
			 FROM 
			       local_businesses 
		     WHERE expired=0
			       AND business_name
				   LIKE '{$post['name']}%'
				   AND business_state='{$post['state']}'";     
	   $res=$this->MyDB->query($SQL);
	   return $res;
	}
	
	public function validatesearch($get)
	{
	 
	  $retArray = array("result"=>false, "message"=>'');
		$errors = array();
		
		if(empty($get['name'])) {
		$errors[] = "Field is blank";
		}
		
		if(count($errors) == 0) {
		$retArray['result'] = true;
		}
		$retArray['message'] = $errors;
		return $retArray;
   
	
	
	}
	
	
	public function selectStates()
	{
	  $SQL="SELECT
	                * 
			FROM
			       local_state";
	  $res=$this->MyDB->query($SQL);
	  return $res;
	}
	
	
	public function editListing($post,$file)
		{prexit($post);
		   $sub=explode(';',$_POST['suburb']);
		  // $image=explode('\ ',$_POST['logo']);
		    $image=$file['logo']['name'];
		   $SQL2="SELECT
		               shiretown_id 
				  FROM
				       shire_towns 
				  WHERE
				       shiretown_postcode='".$post['postcode']."' 
				  AND
				       shiretown_townname='".$sub[1]."'";
		  $rec=$this->MyDB->query($SQL2);
			if(@$post['listing']==1)
			{
			$a=1;
			}
			else
			{
			$a=0;
			}
		
			 $ID			=$_GET['ID'];
			 $condition     =$ID;  	    
			 $img=$_POST['logo']; $desc=$post['description'];
	if($image==''&& $desc=='')
        {
          $SQL="UPDATE 
		              local_businesses
			    SET
						business_initials='{$post['initials']}',
						business_name='{$post['name']}',
						business_street1='{$post['street1']}',
						business_street2='{$post['street2']}',
						business_suburb='{$sub[1]}',
						business_postcode='{$post['postcode']}',
						business_phonestd='{$post['phonestd']}',
						business_phone='{$post['phone']}',
						business_faxstd='{$post['faxstd']}',
						business_fax='{$post['fax']}',
						business_email='{$post['email']}',
						business_url='{$post['url']}',
						business_origin='{$post['origin']}',
						shiretown_id='{$rec[0]['shiretown_id']}',
						business_mobile='{$post['mobile']}',
						business_contact='{$post['contact']}',
						
						classification='{$post['classification']}',
						business_state='{$post['state']}' WHERE business_id=$condition";
						
				}elseif($image!=''&& $desc!=''){
                $SQL="UPDATE 
				            local_businesses 
					 SET
					    business_initials='{$post['initials']}',
						business_name='{$post['name']}',
						business_street1='{$post['street1']}',
						business_street2='{$post['street2']}',
						business_suburb='{$sub[1]}',
						business_postcode='{$post['postcode']}',
						business_phonestd='{$post['phonestd']}',
						business_phone='{$post['phone']}',
						business_faxstd='{$post['faxstd']}',
						business_fax='{$post['fax']}',
						business_email='{$post['email']}',
						business_url='{$post['url']}',
						business_origin='{$post['origin']}',
						shiretown_id='{$rec[0]['shiretown_id']}',
						business_mobile='{$post['mobile']}',
						business_contact='{$post['contact']}',
						business_logo='{$image}',
						business_description='{$post['description']}',
						
						classification='{$post['classification']}',
						business_state='{$post['state']}' WHERE business_id=$condition";
						     
					}
					elseif($image==''&& $desc!=''){
                $SQL="UPDATE 
				            local_businesses 
					 SET
					    business_initials='{$post['initials']}',
						business_name='{$post['name']}',
						business_street1='{$post['street1']}',
						business_street2='{$post['street2']}',
						business_suburb='{$sub[1]}',
						business_postcode='{$post['postcode']}',
						business_phonestd='{$post['phonestd']}',
						business_phone='{$post['phone']}',
						business_faxstd='{$post['faxstd']}',
						business_fax='{$post['fax']}',
						business_email='{$post['email']}',
						business_url='{$post['url']}',
						business_origin='{$post['origin']}',
						shiretown_id='{$rec[0]['shiretown_id']}',
						business_mobile='{$post['mobile']}',
						business_contact='{$post['contact']}',
						business_description='{$post['description']}',
						
						classification='{$post['classification']}',
						business_state='{$post['state']}' WHERE business_id=$condition";
						     
					}
					elseif($image!=''&& $desc==''){
                $SQL="UPDATE 
				            local_businesses 
					 SET
					    business_initials='{$post['initials']}',
						business_name='{$post['name']}',
						business_street1='{$post['street1']}',
						business_street2='{$post['street2']}',
						business_suburb='{$sub[1]}',
						business_postcode='{$post['postcode']}',
						business_phonestd='{$post['phonestd']}',
						business_phone='{$post['phone']}',
						business_faxstd='{$post['faxstd']}',
						business_fax='{$post['fax']}',
						business_email='{$post['email']}',
						business_url='{$post['url']}',
						business_origin='{$post['origin']}',
						shiretown_id='{$rec[0]['shiretown_id']}',
						business_mobile='{$post['mobile']}',
						business_contact='{$post['contact']}',
						business_logo='{$image}',
						
						classification='{$post['classification']}',
						business_state='{$post['state']}' WHERE business_id=$condition";
						     
					}
					//prexit($SQL);
			$this->MyDB->query($SQL);                 
			$result = array("result"=>true, "message"=>'Update Successfully');	
            return $result;
	 
	}
		
	public function delList()
    {
	    $ID			=$_GET['ID'];
        $condition  =$ID;
		$SQL="DELETE 
		      FROM
			      local_businesses 
			  WHERE expired=0
			      AND business_id=".$condition."";
		$this->MyDB->query($SQL);
        $Array = array("result"=>true, "message"=>'');
        return $Array;
    }
	
	
	
	public function changePassword($post)
    {

		$res =$this->__changePasswordValidation($post);
		if(!$res['result'])
		{
		return $res;
		}
		
		$localuser_id = getSession("userid");
		$password		=md5($post['oldPassword']);
		$newPassword	=$post['newPassword'];
		$confirmPassword=$post['confirmPassword'];
		$newmd5Password	=md5($post['newPassword']);
		echo $condition	="localuser_id=$localuser_id AND localuser_password='$password'";
		$this->MyDB->setWhere($condition) ;
		$resultArray=$this->MyDB->getAll();
		echo count($resultArray);
		if(count($resultArray)>0)
		{
		$data = array(
		'localuser_password'=>$newmd5Password
		);
		$this->MyDB->setWhere("localuser_id=$localuser_id") ;
		$this->MyDB->update($data);
		$retArray = array("result"=>true, "message"=>'Password change Successfully');
		}else{
		$retArray = array("result"=>true, "message"=>'Wrong Old Password');
		
		}
		return $retArray;

    }
	
	private function __changePasswordValidation(&$data)
    {
		
		$retArray = array("result"=>false, "message"=>'');
		$errors = array();
		
		if(empty($data['oldPassword'])) {
		$errors[] = "Enter Old Password";
		}
		
		if(empty($data['newPassword'])) {
		$errors[] = "Enter New Password";
		}
		
		
		
		if(empty($data['confirmPassword'])|| $data['newPassword']!=$data['confirmPassword']) {
		$errors[] = "Password is blank or password, Confirm Password didn't matched!!";
		}
		
		
		
		
		if(count($errors) == 0) {
		$retArray['result'] = true;
		}
		$retArray['message'] = $errors;
		return $retArray;
    }
	
	
	
	
    public function passwordSent($post)
    {
	
        $res1 =$this->__Validation($post);
        if(!$res1['result']){
            return $res1;
        }else
        {
		
	
            $email=$post['email'];
			$secrettext=$post['secrettext'];
            $this->MyDB->setWhere("email='{$post['email']}' AND secret_text='{$secrettext}'");
            $rows=$this->MyDB->getAll();
			
			
			//==============================================================
			if(count($rows)>0)
			{
			$FirstName	=$rows['0']['fname'];
			$LastName	=$rows['0']['lname'];
			$email	=$rows['0']['email'];
			$newPassword	=$this->createRandomPassword();
			$data = array('password'=>md5($newPassword));
            $this->MyDB->setWhere("email='{$email}'") ;
            $this->MyDB->update($data);
			$mailBody	="Hi ".$FirstName." ".$LastName.",\nThis is your new password please login using this new password. \n\nYour Email ID is '".$email."' \nYour Password is '".$newPassword."'\nThanks.";
			}else{
			$mailBody	="Your EMail ID '".$email."' does not exists in our system.\nSorry for inconvinience.";
			}
			
			//==============================================================
            $mailer = new Mailer();
            $mailer->AddAddress($post['email']);
            // $mailer->IsHTML();
            $mailer->Body = $mailBody;
            $mailer->Subject = "Lost Password Recovery";
            if(!$mailer->Send()) {
                echo $mailer->ErrorInfo;
            }
            $mailer->ClearAddresses();
            $retArray = array("result"=>true, "message"=>'');
            return $retArray;
        }
    }
		
}
?>