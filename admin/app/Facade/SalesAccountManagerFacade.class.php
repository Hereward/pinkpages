<?php
class SalesAccountManagerFacade extends MainFacade {

	public function __construct(MyDB $MyDB) {

		$this->MyDB = $MyDB;

		$this->MyDB->table=TBL_LOCAL_USER;
		$this->MyDB->sequenceName=TBL_LOCAL_USER;
		$this->MyDB->primaryCol="localuser_id";
	}/* END __construct */

	/**
	*@desc  This function is used for adding the user. It check all the validation and add user on true validation else retrn             error message.
	*/
	public function userAdd($post)
	{
		$res1 =$this->__userRegisterValidation($post);
		if(!$res1['result'])
		{
			return $res1;
		}
		else
		{
			$data = array('localuser_firstname'=>$post['firstname'],
			'localuser_surname'=>$post['surname'],
			'localuser_username'=>$post['username'],
			'localuser_password'=>md5($post['password']),
			'localuser_email'=>$post['email'],
			'localuser_phone'=>$post['phone'],
			'localuser_mobile'=>$post['mobile'],
			'localuser_access'=>'Employee',
			'localuser_status'=>'I');
			$this->MyDB->setWhere("localuser_username='".$post['username']."'");
			$resultArray=$this->MyDB->getAll();
			if(count($resultArray)>0)
			{
				$retArray = array("result"=>false, "message"=>'Username Already Exists!! please try some other name');
				return $retArray;
			}
			else
			{
				$this->MyDB->save($data);
				$retArray = array("result"=>true, "message"=>'Added Successfully');
			}
			return $retArray;
		}
	}

	/**
	*@desc  This function is used for counting the number of users.
	*/
	public function countUserDetails()
	{
		$ret = 0;
		$this->MyDB->setWhere("localuser_access='Employee'");
		$this->MyDB->setSelect("count(localuser_id) as cnt");
		$result = $this->MyDB->getAll();
		$ret = $result[0]['cnt'];
		return $ret;
	}


	/**
	*@desc  This function is used for fetching the details of user.
	*/
	public function fetchUserDetails($fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
	{

		$res = array();
		$sql="SELECT * FROM local_user	WHERE localuser_access='Employee' LIMIT $fr,$noOfRecords";
		$result = $this->MyDB->query($sql);
		$res['user'] = $result;
		$res['paging'] = Paging::numberPaging($this->countUserDetails(), $fr, $noOfRecords);
		return $res;
	}



	/**
	*@desc  This function is used for validating the user details entered by the user at the time of adding user.
	*/
	private function __userRegisterValidation(&$data)
	{

		$retArray = array("result"=>false, "message"=>'');
		$errors = array();
		
		if(empty($data['password']))
		{
			$errors[] = "Password is blank!!";
		}
		if(empty($data['confpassword'])||$data['password']!=$data['confpassword'])
		{
			$errors[] = "Password is blank or Password and Confirm Password didn't matched!!";
		}

		
		if(empty($data['username']))
		{
			$errors[] = "username is blank!!";
		}
		if(!preg_match("/^[0-9a-zA-Z_\.-]+\@[0-9a-zA-Z_\.-]+\.[0-9a-zA-Z_\.-]+$/",$data['email'])||empty($data['email']))
		{
			$errors[] = "email is not valid!!";
		}
		
		if(count($errors) == 0)
		{
			$retArray['result'] = true;
		}
		$retArray['message'] = $errors;
		return $retArray;
	}


	/**
	*@desc  This function is used for validating the user details entered by the user at the time of editing user.
	*/
	private function __userEditValidation(&$data)
	{

		$retArray = array("result"=>false, "message"=>'');
		$errors = array();
		if(empty($data['firstname']))
	

		if(empty($data['username']))
		{
			$errors[] = "username is blank!!";
		}
		if(!preg_match("/^[0-9a-zA-Z_\.-]+\@[0-9a-zA-Z_\.-]+\.[0-9a-zA-Z_\.-]+$/",$data['email'])||empty($data['email']))
		{
			$errors[] = "email is not valid!!";
		}
		
		if(count($errors) == 0)
		{
			$retArray['result'] = true;
		}
		$retArray['message'] = $errors;
		return $retArray;
	}

	/**
	*@desc  This function is used for fetching the details of user by passing the ID for editing.
	*/
	public function editUser()
	{

		$condition 	= (!empty($_GET['ID']))?$_GET['ID']:NULL;
		$res = $this->MyDB->get($condition);
		return $res;
	}

	/**
	*@desc  This function is used for changing the status of user.
	*/
	public function changeStatus()
	{
		$ID 	= (!empty($_GET['ID']))?$_GET['ID']:NULL;
		$condition  ="localuser_id={$ID}";
		$QUERY		="SELECT localuser_status from local_user WHERE $condition";
		$res=$this->MyDB->query($QUERY);
		if($res['0']['localuser_status'] =='0')
		{
			$data 		=array('localuser_status'=>'1');
		}else{
			$data 		=array('localuser_status'=>'0');
		}
		$this->MyDB->setWhere($condition);
		return $this->MyDB->update($data);
	}

	/**
	* @desc This function will be used for adding updated data after editing into table('local_user').
	* @param posted data from edit form after editing the existing information. 
	* @return mixed Return true if updation was successfull or false if failure.
	*/
	public function editAdd($post)
	{

		$res1 =$this->__userEditValidation($post);
		if(!$res1['result'])
		{
			return $res1;
		}

		$ID			=$_GET['ID'];
		$condition  =$ID;
		$password	=$post['password'];
		if($password == '')
		{
			$data  =  array('localuser_firstname'=>$post['firstname'],
			'localuser_surname'=>$post['surname'],
			'localuser_username'=>$post['username'],
			'localuser_email'=>$post['email'],
			'localuser_phone'=>$post['phone'],
			'localuser_mobile'=>$post['mobile']
			);
		}else
		{
			$data  =  array('localuser_firstname'=>$post['firstname'],
			'localuser_surname'=>$post['surname'],
			'localuser_username'=>$post['username'],
			'localuser_password'=>md5($post['password']),
			'localuser_email'=>$post['email'],
			'localuser_phone'=>$post['phone'],
			'localuser_mobile'=>$post['mobile']);
		}
		$this->MyDB->setWhere("localuser_id=$condition") ;
		$this->MyDB->update($data);
		$Array = array("result"=>true, "message"=>'Update Successfully');
		return $Array;
	}

	/**
	* @desc This function will be used to delete user based on ID,(puposefully converting 'Active' to 'Inactive')
	* @param NULL
	* @return mixed Return true if deletion was successfull or false if failure.
	*/
	public function delUser()
	{
		$ID			=$_GET['ID'];
		$condition  =$ID;
		$this->MyDB->remove($condition);
		$Array = array("result"=>true, "message"=>'');
		return $Array;
	}

	/**
	*@desc  This function is used for counting the number of employee according to the search criteria.
	*/
	public function countEmployee($post)
	{
		$ret = 0;
		$this->MyDB->setWhere("localuser_firstname LIKE '{$post['name']}%' AND localuser_access='Employee'");
		$this->MyDB->setSelect("count(localuser_id) as cnt");
		$result = $this->MyDB->getAll();
		$ret = $result[0]['cnt'];
		return $ret;
	}

	/**
	*@desc  This function is used for searching the employee based on search value enterd by the user.
	*/
	public function searchEmployee($fr=0, $noOfRecords=DEFAULT_PAGING_SIZE,$post)
	{
		$res 				= array();
		$condition			= "localuser_firstname LIKE '{$post['name']}%' AND localuser_access='Employee'";
		$this->MyDB->setWhere($condition);
		$result				= $this->MyDB->getAll($fr,DEFAULT_PAGING_SIZE);
		$res['user']		= $result;
		$res['paging']		= Paging::numberPaging($this->countEmployee($post), $fr, DEFAULT_PAGING_SIZE);
		return $res;
	}


	/**
	*@desc  This function is used for fetching and couting the business.
	*/
	public function viewfetchDetails($fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
	{
		$retArray = array();
		$SQL1					="SELECT *
								   FROM local_businesses
								   WHERE client_id!=0
								   AND local_businesses.expired=0 
								   ORDER BY 
										Rank ASC, business_addDate ASC LIMIT $fr,".DEFAULT_PAGING_SIZE;

		$res=$this->MyDB->query($SQL1);
		$SQL="SELECT
		          count(business_id) AS cnt 
			  FROM 
			      local_businesses
			  WHERE 
			       client_id!=0
			       AND local_businesses.expired=0
			  ORDER BY Rank,business_addDate ASC  ";

		$count_all = $this->MyDB->query($SQL);
		$retArray['listings'] = $res;
		$retArray['paging'] = Paging::numberPaging($count_all[0]['cnt'], $fr, $noOfRecords);
		return $retArray;
	}


	/**
	*@desc  This function is used for fetching the Rank.
	*/
	public function fetchRank()
	{
		$SQL="select MAX(Rank) AS Rank from local_businesses WHERE expired=0 limit 0, 1";
		$res=$this->MyDB->query($SQL);
		return $res;

	}


	/**
	*@desc  This function is used for validating the business and if the validation returns true it add the business else it 			            return error message.
	*/
	public function addlist1($post,$logo)
	{

		//$initials 		= (!empty($post['initials']))?$post['initials']:NULL;
		$url_alias		= (!empty($post['url_alias']))?$post['url_alias']:NULL;		
		$name 			= (!empty($post['name']))?$post['name']:NULL;
		$street1 		= (!empty($post['street1']))?$post['street1']:NULL;
		$street2 		= (!empty($post['street2']))?$post['street2']:NULL;
		$phonestd 		= (!empty($post['phonestd']))?$post['phonestd']:NULL;
		$phone 			= (!empty($post['phone']))?$post['phone']:NULL;
		$faxstd 		= (!empty($post['faxstd']))?$post['faxstd']:NULL;
		$fax 			= (!empty($post['fax']))?$post['fax']:NULL;
		$email 			= (!empty($post['email']))?$post['email']:NULL;
		$url 			= (!empty($post['url']))?$post['url']:NULL;
		//$origin 		= (!empty($post['origin']))?$post['origin']:NULL;
		$mobile 		= (!empty($post['mobile']))?$post['mobile']:NULL;
		$contact 		= (!empty($post['contact']))?$post['contact']:NULL;
		$postcode 		= (!empty($post['postcode']))?$post['postcode']:0;
		$description 	= (!empty($post['description']))?$post['description']:NULL;
		$classification = (!empty($post['classification']))?$post['classification']:NULL;
		$state 			= (!empty($post['state']))?$post['state']:NULL;
		$rank 			= (!empty($post['rank']))?$post['rank']:NULL;
		$archived 		= (!empty($post['archived']))?$post['archived']:NULL;
		//$OlistID 		= (!empty($post['OlistID']))?$post['OlistID']:NULL;
		$Add1 			= (!empty($post['Add1']))?$post['Add1']:0;
		$Add2 			= (!empty($post['Add2']))?$post['Add2']:0;
		$AccNo 			= (!empty($post['AccNo']))?$post['AccNo']:0;
		$Add3   		= (!empty($post['Add3']))?$post['Add3']:0;

		$logoname		=$logo['logo']['name'];
		$imagename		=$logo['image']['name'];		
		$suburb			=explode(',',$_POST['suburb']);
		$shire			=explode(';',$_POST['region']);
		if(isset($_POST['brand'])) {
			$brand			=explode('-',$_POST['brand']);
		}
		$listingValidation =$this->__userlistingValidation($post,$logo,"add");

		if(!$listingValidation['result'])
		{
			return $listingValidation;
		}

		$queryGetShire	="SELECT shiretown_id
		 					FROM shire_towns 
							WHERE shiretown_postcode='".$postcode."' 
								AND shiretown_townname='".$suburb[1]."'";
		$shireResult	=$this->MyDB->query($queryGetShire);
		if(count($shireResult) != 0 && $suburb[0] != "--Select One--")
		{

		 $addBusiness	="INSERT INTO local_businesses(
														`url_alias` ,		 
														`business_name` ,
														`business_street1` ,
														`business_street2` ,
														`street1_status` ,
														`street2_status` ,
														`business_phonestd` ,
														`business_phone` ,
														`business_faxstd` ,
														`business_fax` ,
														`business_email` ,
														`business_url` ,
														`business_mobile` ,
														`business_contact` ,
														`client_id`,
														`business_postcode` ,
														`shiretown_id` ,
														`business_suburb`,
														`business_logo`,
														`business_image`,														
														`business_description`,
														`classification`,
														`business_state`,
														`archived`,
														`account_id`,
														`shire_name`,
														`shire_town`,
														`map_status`
													) VALUES (
														'{$url_alias}',													
														'{$name}',
														'{$street1}',
														'{$street2}',
														'{$Add1}',
														'{$Add2}',
														'{$phonestd}',
														'{$phone}',
														'{$faxstd}',
														'{$fax}',
														'{$email}',
														'{$url}',
														'{$mobile}',
														'{$contact}',
														'{$AccNo}',
														'{$postcode}',
														'{$shireResult[0]['shiretown_id']}',
														'{$suburb[1]}',
														'{$logoname }',
														'{$imagename }',														
														'{$description}',
														'{$classification}',
														'{$state}',
														'{$archived}',
														'',
														'{$shire[1]}',
														'{$suburb[1]}',
														'{$Add3}'
														)";
			}else{
				 $addBusiness	="INSERT INTO local_businesses(
														`url_alias` ,		 				 
														`business_name` ,
														`business_street1` ,
														`business_street2` ,
														`street1_status` ,
														`street2_status` ,
														`business_phonestd` ,
														`business_phone` ,
														`business_faxstd` ,
														`business_fax` ,
														`business_email` ,
														`business_url` ,
														`business_mobile` ,
														`business_contact` ,
														`client_id`,
														`shiretown_id` ,
														`business_logo`,
														`business_description`,
														`classification`,
														`business_state`,
														`archived`,
														`account_id`,
														`shire_name`,
														`shire_town`,
														`map_status`
													) VALUES (
														'{$url_alias}',																										
														'{$name}',
														'{$street1}',
														'{$street2}',
														'{$Add1}',
														'{$Add2}',
														'{$phonestd}',
														'{$phone}',
														'{$faxstd}',
														'{$fax}',
														'{$email}',
														'{$url}',
														'{$mobile}',
														'{$contact}',
														".getSession("userid").",
														'{$shireResult[0]['shiretown_id']}',
														'{$logoname }',
														'{$description}',
														'{$classification}',
														'{$state}',
														'{$archived}',
														'{$AccNo}',
														'{$shire[1]}',
														'{$suburb[1]}',
														'{$Add3}'
														)";
			} 
			
		$resultAddBusiness	=$this->MyDB->query($addBusiness);

		$insertedBusinessId	=$this->MyDB->getInsertID($resultAddBusiness);

		/*if($OlistID != '')
		{
			$OlistID_sql		=" INSERT INTO `dawson_olistkey_businessid`
									(`olistkey` ,`business_id`) VALUES ('{$OlistID}', '{$insertedBusinessId}')";

			$resultOlistID		=$this->MyDB->query($OlistID_sql);
		}*/

		/*$brandAddQuery		="INSERT INTO `business_brand`
		(`brand_id`,`business_id`,`business_brand_name`)
		VALUES
		('{$brand[0]}','{$insertedBusinessId}','{$brand[1]}')";
		$this->MyDB->query($brandAddQuery);*/

		//Updating new entry in indexed lookup table
		if($insertedBusinessId) {
			$listingFacade  = new ListingFacade($this->MyDB, $this->request);
			$listingFacade->updateLocalBusinessIndex($insertedBusinessId);
		}

		$addBusiness=array("result"=>true, "message"=>'Business Added Successfully',"InsertID"=>$insertedBusinessId);

		return $addBusiness;
	}

	/**
	*@desc  This function is used for adding the details of classification.
	*/
	public function addClassificationDetail($post,$get)
	{
		$BusinessID 				= (!empty($get['ID']))?$get['ID']:NULL;
		$currentdate				= date("Y-m-d H:m:s");

		$fetchOldClassification	= "SELECT localclassification_id FROM `business_classification` WHERE `business_id`={$BusinessID}";
		$classificationResult  		= $this->MyDB->query($fetchOldClassification);
		//prexit($classificationResult);

		$oldValue					=serialize($classificationResult);

		$i=0;
		foreach($post['addclassification'] as $value)
		{
			//prexit($value);
			$finalValue[$i]['localclassification_id']	=$value;
			$i++;
		}
		$newValue					=serialize($finalValue);

		$insertEditHistory	="INSERT INTO `business_edit_history` (
																 `edit_id` ,
																`business_id` ,
																`client_id` ,
																`old_value` ,
																`new_value` ,
																`edit_type` ,
																`change_time` 
																)VALUES (
																	NULL,
															 		'{$BusinessID}',
																	'".getSession("userid")."',
																	'$oldValue',
																	'$newValue',
																	'classification',
																	'{$currentdate}')"; 
		$this->MyDB->query($insertEditHistory);


		foreach($post['addclassification'] as $value)
		{

			$add_classification 	= "INSERT INTO `business_classification` (`businessclassification_id`, `business_id`, `localclassification_id`) VALUES ('', '{$BusinessID}', '{$value}')";

			$result  				= $this->MyDB->query($add_classification);

		}
		$addClass					= array("result"=>true, "message"=>'Classification Added Successfully',"ID"=>$BusinessID);
		return $addClass;
	}


	public function add_new_keyword($post,$get)
	{
		$BusinessID 	= (!empty($get['ID']))?$get['ID']:NULL;
		$currentdate				= date("Y-m-d H:m:s");

		$fetchOldKeyword			= "SELECT key_id,business_key_name FROM `business_keyword` WHERE `business_id`={$BusinessID}";
		$keywordResult  		= $this->MyDB->query($fetchOldKeyword);
		$oldValue					=serialize($keywordResult);

		$i=0;
		foreach($post['addclassification'] as $value)
		{
			$keyword		= explode('-',$value);
			$finalValue[$i]['key_id']	=$keyword[0];
			$finalValue[$i]['business_key_name']	=$keyword[1];
			$i++;
		}
		$newValue					=serialize($finalValue);
		

		$insertEditHistory	="INSERT INTO `business_edit_history` (
																 `edit_id` ,
																`business_id` ,
																`client_id` ,
																`old_value` ,
																`new_value` ,
																`edit_type` ,
																`change_time` 
																)VALUES (
																	NULL,
															 		'{$BusinessID}',
																	'".getSession("userid")."',
																	'$oldValue',
																	'$newValue',
																	'keyword',
																	'{$currentdate}')";
		$this->MyDB->query($insertEditHistory);

		foreach($post['addclassification'] as $value)
		{
			$keyword		= explode('-',$value);

			$add_classification = "INSERT INTO `business_keyword` (`key_id`, `business_id`, `business_key_name`) VALUES ('{$keyword[0]}', '{$BusinessID}', '{$keyword[1]}')";

			$result  =$this->MyDB->query($add_classification);

		}
		$addClass=array("result"=>true, "message"=>'Keyword Added Successfully',"ID"=>$BusinessID);
		return $addClass;
	}

	public function add_new_hour($post,$get)
	{
		$BusinessID 	= (!empty($get['ID']))?$get['ID']:NULL;
		$currentdate	= date("Y-m-d H:m:s");

		$fetchOldKeyword			= "SELECT hour_id,hour_name FROM `business_hours` WHERE `business_id`={$BusinessID}";
		$keywordResult  		= $this->MyDB->query($fetchOldKeyword);
		$oldValue					=serialize($keywordResult);

		$i=0;
		foreach($post['addhour'] as $value)
		{
			$keyword		= explode('-',$value);
			$finalValue[$i]['hour_id']	=$keyword[0];
			$finalValue[$i]['hour_name']	=$keyword[1];
			$i++;
		}
		$newValue					=serialize($finalValue);

		$insertEditHistory	="INSERT INTO `business_edit_history` (
																 `edit_id` ,
																`business_id` ,
																`client_id` ,
																`old_value` ,
																`new_value` ,
																`edit_type` ,
																`change_time` 
																)VALUES (
																	NULL,
															 		'{$BusinessID}',
																	'".getSession("userid")."',
																	'$oldValue',
																	'$newValue',
																	'hour_payment',
																	'{$currentdate}')";
		$this->MyDB->query($insertEditHistory);

		foreach($post['addhour'] as $value)
		{
			$keyword		= explode('-',$value);

			$add_classification = "INSERT INTO `business_hours` (`hour_id`, `business_id`, `hour_name`) VALUES ('{$keyword[0]}', '{$BusinessID}', '{$keyword[1]}')";

			$result  =$this->MyDB->query($add_classification);

		}
		$addClass=array("result"=>true, "message"=>'Hour Added Successfully',"ID"=>$BusinessID);
		return $addClass;
	}


	public function add_new_payment($post,$get)
	{
		$BusinessID 	= (!empty($get['ID']))?$get['ID']:NULL;
		$currentdate	= date("Y-m-d H:m:s");

		$fetchOldKeyword			= "SELECT payment_id,payment_name FROM `business_payment` WHERE `business_id`={$BusinessID}";
		$keywordResult  		= $this->MyDB->query($fetchOldKeyword);
		$oldValue					=serialize($keywordResult);

		$i=0;
		foreach($post['payment'] as $value)
		{
			$keyword		= explode('-',$value);
			$finalValue[$i]['payment_id']	=$keyword[0];
			$finalValue[$i]['payment_name']	=$keyword[1];
			$i++;
		}
		$newValue					=serialize($finalValue);

		$insertEditHistory	="INSERT INTO `business_edit_history` (
																 `edit_id` ,
																`business_id` ,
																`client_id` ,
																`old_value` ,
																`new_value` ,
																`edit_type` ,
																`change_time` 
																)VALUES (
																	NULL,
															 		'{$BusinessID}',
																	'".getSession("userid")."',
																	'$oldValue',
																	'$newValue',
																	'hour_payment',
																	'{$currentdate}')";
		$this->MyDB->query($insertEditHistory);

		foreach($post['payment'] as $value)
		{
			$keyword		= explode('-',$value);

			$add_classification = "INSERT INTO `business_payment` (`payment_id`, `business_id`, `payment_name`) VALUES ('{$keyword[0]}', '{$BusinessID}', '{$keyword[1]}')";

			$result  =$this->MyDB->query($add_classification);

		}
		$addClass=array("result"=>true, "message"=>'Payment Option Added Successfully',"ID"=>$BusinessID);
		return $addClass;
	}
	public function add_new_service($post,$get)
	{

		$BusinessID 				= (!empty($get['ID']))?$get['ID']:NULL;
		$service 					= (!empty($post['service']))?$post['service']:NULL;
		$currentdate				= date("Y-m-d H:m:s");

		$fetchOldKeyword			= "SELECT business_service_name FROM `business_service` WHERE `business_id`={$BusinessID}";
		$keywordResult  		= $this->MyDB->query($fetchOldKeyword);
		$oldValue					=serialize($keywordResult);

		$newValue					=serialize($service);

		$insertEditHistory	="INSERT INTO `business_edit_history` (
																 `edit_id` ,
																`business_id` ,
																`client_id` ,
																`old_value` ,
																`new_value` ,
																`edit_type` ,
																`change_time` 
																)VALUES (
																	NULL,
															 		'{$BusinessID}',
																	'".getSession("userid")."',
																	'$oldValue',
																	'$newValue',
																	'keyword',
																	'{$currentdate}')";
		$this->MyDB->query($insertEditHistory);

		

			 $add_classification = "INSERT INTO `business_service` (`service_id`, `business_id`, `business_service_name`) VALUES ('', '{$BusinessID}', '{$service}')"; 

			$result  =$this->MyDB->query($add_classification);

		
		$addClass=array("result"=>true, "message"=>'Service Added Successfully',"ID"=>$BusinessID);
		return $addClass;
	}

	public function add_new_brand($post,$get)
	{

		$BusinessID 								= (!empty($get['ID']))?$get['ID']:NULL;
		$addbrand 									= (!empty($post['addbrand']))?$post['addbrand']:NULL;
		$currentdate								= date("Y-m-d H:m:s");

		$fetchOldKeyword							= "SELECT business_brand_name FROM `business_brand` WHERE `business_id`={$BusinessID}";
		$keywordResult  							= $this->MyDB->query($fetchOldKeyword);
		
		$oldValue									= serialize($keywordResult);
		

		
		//	$keyword['busensss_brand_name']			= $post['addbrand'];
		$finalValue[]['business_brand_name']	= $post['addbrand'];
		
		$newValue									=serialize($finalValue);
		

		$insertEditHistory	="INSERT INTO `business_edit_history` (
																 `edit_id` ,
																`business_id` ,
																`client_id` ,
																`old_value` ,
																`new_value` ,
																`edit_type` ,
																`change_time` 
																)VALUES (
																	NULL,
															 		'{$BusinessID}',
																	'".getSession("userid")."',
																	'$oldValue',
																	'$newValue',
																	'keyword',
																	'{$currentdate}')";
		$this->MyDB->query($insertEditHistory);

		
			$add_classification = "INSERT INTO `business_brand` (`brand_id`, `business_id`, `business_brand_name`) VALUES ('', '{$BusinessID}', '{$addbrand}')";

			$result  =$this->MyDB->query($add_classification);

		$addClass=array("result"=>true, "message"=>'Brand Added Successfully',"ID"=>$BusinessID);
		return $addClass;
	}



	public function fetchBusinessKeyword($get)
	{
		$BusinessID 	= (!empty($get['ID']))?$get['ID']:NULL;
		$Query			="SELECT * FROM business_keyword WHERE business_id={$BusinessID}";
		$result  =$this->MyDB->query($Query);
		return $result;
	}

	public function fetchBusinessService($get)
	{
		$BusinessID 	= (!empty($get['ID']))?$get['ID']:NULL;
		$Query			="SELECT * 
							FROM business_service 
							WHERE business_id={$BusinessID} 
							ORDER BY 	business_service_name ASC";
		$result  =$this->MyDB->query($Query);
		return $result;
	}




	/**
	*@desc  This function is used for fetching all classification.
	*/
	public function classificationList($get)
	{
		$BusinessID 	= (!empty($get['ID']))?$get['ID']:NULL;

		$list_classification	="SELECT business_classification.localclassification_id, local_classification.localclassification_name FROM business_classification,local_classification WHERE business_id='".$BusinessID."' AND business_classification.localclassification_id=local_classification.localclassification_id";
		$result					=$this->MyDB->query($list_classification);
		return $result;
	}


	/**
	*@desc  This function is used for deleting classification.
	*/
	public function deleteClassification($post,$get)
	{

		$BusinessID 	= (!empty($get['ID']))?$get['ID']:NULL;
		$deleteClass 	= (!empty($post['deleteClass']))?$post['deleteClass']:NULL;
		$currentdate	= date("Y-m-d H:m:s");

		if($deleteClass == '')
		{
			$delClass=array("result"=>false, "message"=>'Please select any classification to delete',"ID"=>$BusinessID);
			return $delClass;
		}


		$fetchOldClassification	= "SELECT localclassification_id FROM `business_classification` WHERE `business_id`={$BusinessID}";
		$classificationResult  		= $this->MyDB->query($fetchOldClassification);

		$oldValue					=serialize($classificationResult);
		


		$insertEditHistory	="INSERT INTO `business_edit_history` (
																 `edit_id` ,
																`business_id` ,
																`client_id` ,
																`old_value` ,
																`new_value` ,
																`edit_type` ,
																`change_time` 
																)VALUES (
																	NULL,
															 		'{$BusinessID}',
																	'".getSession("userid")."',
																	'$oldValue',
																	'',
																	'classification',
																	'{$currentdate}')"; 
		$this->MyDB->query($insertEditHistory);

		foreach($deleteClass as $value)
		{
		
			$del_rank = "DELETE FROM `business_ranks` WHERE `business_id` ='".$BusinessID."' AND `localclassification_id` = '".$value."'";

			$result_rank  =$this->MyDB->query($del_rank);
			

			$del_classification = "DELETE FROM `business_classification` WHERE `business_id` ='".$BusinessID."' AND `localclassification_id` = '".$value."'";

			$result  =$this->MyDB->query($del_classification);

		}
		$delClass=array("result"=>true, "message"=>'Classification Added Successfully',"ID"=>$BusinessID);
		return $delClass;
	}



	public function deleteKeyword($post,$get)
	{

		$BusinessID 	= (!empty($get['ID']))?$get['ID']:NULL;
		$deleteClass 	= (!empty($post['deleteClass']))?$post['deleteClass']:NULL;
		$currentdate	= date("Y-m-d H:m:s");

		if($deleteClass == '')
		{
			$delClass=array("result"=>false, "message"=>'Please select any keyword to delete',"ID"=>$BusinessID);
			return $delClass;
		}

		$fetchOldKeyword	= "SELECT key_id,business_key_name FROM `business_keyword` WHERE `business_id`={$BusinessID}";
		$keywordResult  	= $this->MyDB->query($fetchOldKeyword);

		$oldValue					=serialize($keywordResult);


		$insertEditHistory	="INSERT INTO `business_edit_history` (
																 `edit_id` ,
																`business_id` ,
																`client_id` ,
																`old_value` ,
																`new_value` ,
																`edit_type` ,
																`change_time` 
																)VALUES (
																	NULL,
															 		'{$BusinessID}',
																	'".getSession("userid")."',
																	'$oldValue',
																	'',
																	'keyword',
																	'{$currentdate}')"; 
		$this->MyDB->query($insertEditHistory);

		foreach($deleteClass as $value)
		{

			$del_classification = "DELETE FROM `business_keyword` WHERE `business_id` ='".$BusinessID."' AND `key_id` = '".$value."'";

			$result  =$this->MyDB->query($del_classification);

		}
		$delClass=array("result"=>true, "message"=>'Classification Added Successfully',"ID"=>$BusinessID);
		return $delClass;
	}


	public function deleteBrand($post,$get)
	{

		$BusinessID 	= (!empty($get['ID']))?$get['ID']:NULL;
		$deleteBrand 	= (!empty($post['addbrand']))?$post['addbrand']:NULL;
		$currentdate	= date("Y-m-d H:m:s");

		if($deleteBrand == '')
		{
			$delClass=array("result"=>false, "message"=>'Please select any Brand to delete',"ID"=>$BusinessID);
			return $delClass;
		}

		$fetchOldKeyword	= "SELECT business_brand_name FROM `business_brand` WHERE `business_id`={$BusinessID}";
		$keywordResult  	= $this->MyDB->query($fetchOldKeyword);

		$oldValue					=serialize($keywordResult);


		$insertEditHistory	="INSERT INTO `business_edit_history` (
																 `edit_id` ,
																`business_id` ,
																`client_id` ,
																`old_value` ,
																`new_value` ,
																`edit_type` ,
																`change_time` 
																)VALUES (
																	NULL,
															 		'{$BusinessID}',
																	'".getSession("userid")."',
																	'$oldValue',
																	'',
																	'brand',
																	'{$currentdate}')"; 
		$this->MyDB->query($insertEditHistory);
		foreach($deleteBrand as $value)
		{

			 $del_classification = "DELETE FROM `business_brand` WHERE `business_id` ='".$BusinessID."' AND `brand_id` = '".$value."'"; 

			$result  =$this->MyDB->query($del_classification);

		}
		$delClass=array("result"=>true, "message"=>'Brand Added Successfully',"ID"=>$BusinessID);
		return $delClass;
	}


	public function deleteHour($post,$get)
	{

		$BusinessID 	= (!empty($get['ID']))?$get['ID']:NULL;
		$deleteHour 	= (!empty($post['deleteHour']))?$post['deleteHour']:NULL;
		$currentdate	= date("Y-m-d H:m:s");

		if($deleteHour == '')
		{
			$delClass=array("result"=>false, "message"=>'Please select any Working Hour to delete',"ID"=>$BusinessID);
			return $delClass;
		}

		$fetchOldKeyword	= "SELECT hour_id,hour_name FROM `business_hours` WHERE `business_id`={$BusinessID}";
		$keywordResult  	= $this->MyDB->query($fetchOldKeyword);

		$oldValue			=serialize($keywordResult);


		$insertEditHistory	="INSERT INTO `business_edit_history` (
																 `edit_id` ,
																`business_id` ,
																`client_id` ,
																`old_value` ,
																`new_value` ,
																`edit_type` ,
																`change_time` 
																)VALUES (
																	NULL,
															 		'{$BusinessID}',
																	'".getSession("userid")."',
																	'$oldValue',
																	'',
																	'hour_payment',
																	'{$currentdate}')"; 
		$this->MyDB->query($insertEditHistory);

		foreach($deleteHour as $value)
		{

			$del_classification = "DELETE FROM `business_hours` WHERE `business_id` ='".$BusinessID."' AND `hour_id` = '".$value."'";

			$result  =$this->MyDB->query($del_classification);

		}
		$delClass=array("result"=>true, "message"=>'Hour Added Successfully',"ID"=>$BusinessID);
		return $delClass;
	}


	public function deletePayment($post,$get)
	{
		$BusinessID 	= (!empty($get['ID']))?$get['ID']:NULL;
		$deletePayment 	= (!empty($post['deletePayment']))?$post['deletePayment']:NULL;
		$currentdate	= date("Y-m-d H:m:s");

		if($deletePayment == '')
		{
			$delClass=array("result"=>false, "message"=>'Please select any Payment Option to delete',"ID"=>$BusinessID);
			return $delClass;
		}

		$fetchOldKeyword	= "SELECT payment_id,payment_name FROM `business_payment` WHERE `business_id`={$BusinessID}";
		$keywordResult  	= $this->MyDB->query($fetchOldKeyword);

		$oldValue					=serialize($keywordResult);


		$insertEditHistory	="INSERT INTO `business_edit_history` (
																 `edit_id` ,
																`business_id` ,
																`client_id` ,
																`old_value` ,
																`new_value` ,
																`edit_type` ,
																`change_time` 
																)VALUES (
																	NULL,
															 		'{$BusinessID}',
																	'".getSession("userid")."',
																	'$oldValue',
																	'',
																	'hour_payment',
																	'{$currentdate}')"; 
		$this->MyDB->query($insertEditHistory);

		foreach($deletePayment as $value)
		{

			$del_classification = "DELETE FROM `business_payment` WHERE `business_id` ='".$BusinessID."' AND `payment_id` = '".$value."'";

			$result  =$this->MyDB->query($del_classification);

		}
		$delClass=array("result"=>true, "message"=>'Payment Added Successfully',"ID"=>$BusinessID);
		return $delClass;
	}
	public function deleteService($post,$get)
	{
		$BusinessID 	= (!empty($get['ID']))?$get['ID']:NULL;
		$deleteService 	= (!empty($post['addService']))?$post['addService']:NULL;
		$currentdate	= date("Y-m-d H:m:s");

		if($deleteService == '')
		{
			$deleteService=array("result"=>false, "message"=>'Please select any service to delete',"ID"=>$BusinessID);
			return $deleteService;
		}

		$fetchOldKeyword	= "SELECT business_service_name FROM `business_service` WHERE `business_id`={$BusinessID}";
		$keywordResult  	= $this->MyDB->query($fetchOldKeyword);

		$oldValue					=serialize($keywordResult);


		$insertEditHistory	="INSERT INTO `business_edit_history` (
																 `edit_id` ,
																`business_id` ,
																`client_id` ,
																`old_value` ,
																`new_value` ,
																`edit_type` ,
																`change_time` 
																)VALUES (
																	NULL,
															 		'{$BusinessID}',
																	'".getSession("userid")."',
																	'$oldValue',
																	'',
																	'service',
																	'{$currentdate}')"; 
		$this->MyDB->query($insertEditHistory);

		foreach($deleteService as $value)
		{

			$del_service 	= "DELETE FROM `business_service` WHERE `business_id` ='".$BusinessID."' AND `service_id` = '".$value."'";
			$result  		= $this->MyDB->query($del_service);

		}
		$delClass=array("result"=>true, "message"=>'Service Added Successfully',"ID"=>$BusinessID);
		return $delClass;
	}


	/**
	*@desc  This function is used for adding rank of specefic classification.
	*/
	public function addRank($post,$get)
	{
		
		$BusinessID 	= (!empty($get['ID']))?$get['ID']:NULL;
		$line1 			= (!empty($post['line1']))?$post['line1']:NULL;
		$line2 			= (!empty($post['line2']))?$post['line2']:NULL; 
		$currentdate	= date("Y-m-d H:m:s");
		
		$list_classification	="SELECT
										business_classification.localclassification_id,
										local_classification.localclassification_name 
									FROM 
										business_classification,
										local_classification 
									WHERE business_id='".$BusinessID."' 
									AND
									business_classification.localclassification_id=local_classification.localclassification_id";
		$result_class			=$this->MyDB->query($list_classification);
		
		$fetch_business			="SELECT * FROM local_pages WHERE business_id={$BusinessID}"; 
		$result_business		=$this->MyDB->query($fetch_business);
		
		if(count($result_business) == 0)
		{	
		 $insert_add_word	="INSERT INTO `local_pages` (
											`localpage_id` , 
											`business_id` , 
											`adword_line1` ,
											`adword_line2` 
											)
										VALUES (
										'' ,
										'{$BusinessID}',
										'{$line2}',
										'{$line1}'
										)"; 
		$this->MyDB->query($insert_add_word);
		}else{
		  $update_add_word="UPDATE local_pages SET 
						adword_line1='{$line1}',
						adword_line2='{$line2}' 
						WHERE business_id=$BusinessID"; 
		$this->MyDB->query($update_add_word);
		}


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

					$tempArray[]		=array(
					'classification'=>$valClass['localclassification_id'],
					'rank'=>$rank,'region'=>$valRegion['shirename_id']
					);

				}
			}

		}        


        //If not values are present in the $tempArray variable then remove the remainging entries
        //from the business_ranks table		
		if(!isset($tempArray)) {
		
          $deleteQuery	= "DELETE FROM business_ranks WHERE business_id = '{$BusinessID}'";
		  $this->MyDB->query($deleteQuery);				
		  
		  $retArray = array("result"  => false,
				            "message" => 'The last ranking for this client has been deleted.'
				);
				return $retArray;
				break;		  				
		}
		 
		foreach($tempArray as $value)
		{
			$rankDetails		="SELECT * FROM `business_ranks`
					 						WHERE `businessrank_rank`='{$value['rank']}' 
					 						AND	`localclassification_id` ='{$value['classification']}' 
					 						AND `shirename_id` = '{$value['region']}' AND business_id != {$BusinessID}
					 						AND businessrank_rank <=10
					 						";
			$rankDetails_result	=$this->MyDB->query($rankDetails);

			if(count($rankDetails_result) > 0)
			{

				$retArray = array(
				"result"=>false,
				"message"=>'This Rank is not available under this classification and region.'
				);
				return $retArray;
				break;

			}
		}

		//----------------------------------------------------------------------------------------------




		$fetchOldRank				= "SELECT localclassification_id,businessrank_rank,shirename_id FROM `business_ranks` WHERE `business_id`={$BusinessID}";
		$rankResult			  		= $this->MyDB->query($fetchOldRank);


		$oldValue					=serialize($rankResult);

		$i=0;
		foreach($tempArray as $value)
		{
			$finalValue[$i]['localclassification_id']	=$value['classification'];
			$finalValue[$i]['businessrank_rank']		=$value['rank'];
			$finalValue[$i]['shirename_id']				=$value['region'];

			
			($i==0) ? $regionList = $value['region'] : '';
			$regionList .= ', '. $value['region'];			
			
			$i++;			
		}

		$newValue					=serialize($finalValue);

		$insertEditHistory	="INSERT INTO `business_edit_history` (
																 `edit_id` ,
																`business_id` ,
																`client_id` ,
																`old_value` ,
																`new_value` ,
																`edit_type` ,
																`change_time` 
																)VALUES (
																	NULL,
															 		'{$BusinessID}',
																	'".getSession("userid")."',
																	'$oldValue',
																	'$newValue',
																	'rank',
																	'{$currentdate}')"; 
		$this->MyDB->query($insertEditHistory);
		
		//$deleteQuery	="DELETE FROM business_ranks WHERE `business_id` ='{$BusinessID}'";
		//$this->MyDB->query($deleteQuery);		
		
        $deleteQuery	= "DELETE FROM business_ranks WHERE business_id = '{$BusinessID}' and shirename_id not in ({$regionList})";
		$this->MyDB->query($deleteQuery);				


		//---------------------------------------------------------------------------------------------------------

		foreach($tempArray as $value)
		{
		    $dateQuery = "select businessrank_timestamp
			                    from business_ranks
							   where business_id = {$BusinessID}
							     and localclassification_id = {$value['classification']}
								 and businessrank_rank = {$value['rank']}
								 and shirename_id = {$value['region']}";
								 
			$result_date =$this->MyDB->query($dateQuery);								 
						
		    $deleteQuery	= "DELETE FROM business_ranks WHERE `business_id` ='{$BusinessID}' and localclassification_id = {$value['classification']} and shirename_id = {$value['region']}";
		    $this->MyDB->query($deleteQuery);			
			
			if(isset($result_date[0]['businessrank_timestamp'])){
			  $timestamp = $result_date[0]['businessrank_timestamp'];
			} else 		
			  {
			    $timestamp =  $currentdate;				
			  }	
		
			$rankQuery      ="INSERT INTO `business_ranks` (
										`businessrank_id` ,
										`business_id` ,
										`localclassification_id` ,
										`businessrank_rank` ,
										`businessrank_email` ,
										`businessrank_url` ,
										`shirename_id` ,
										`businessrank_cost` ,
										`businessrank_timestamp` ,
										`businessrank_expire` ,
										`user_id` ,
										`businessrank_tempfield`
										)
										VALUES (
										'' , '{$BusinessID}', '{$value['classification']}', '{$value['rank']}', '', '', '{$value['region']}', '', '{$timestamp}' , '' , ".getSession("userid").", ''
										)";
										
			$result_rank		=$this->MyDB->query($rankQuery);

		}


		$addRank=array("result"=>true, "message"=>'rank Added Successfully',"ID"=>$BusinessID);
		return $addRank;
	}
	
	public function fetchAddWord($get)
	{
		$BusinessID 			= (!empty($get['ID']))?$get['ID']:NULL;
		$fetch_business			="SELECT adword_line1,adword_line2 FROM local_pages WHERE business_id={$BusinessID}"; 
		$result_business		=$this->MyDB->query($fetch_business);
		return $result_business;
	}


	/**
	*@desc  This function is used for fetching all the rank related to the particular business.
	*/	
	public function rankDetails($get)
	{
		$BusinessID 	= (!empty($get['ID']))?$get['ID']:NULL;
		$rank_query		="SELECT * FROM business_ranks WHERE business_id={$BusinessID}";
		$rank_list		=$this->MyDB->query($rank_query);
		return $rank_list;
	}


	public function addlist($post,$logo)
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



		$sql			="SELECT localclassification_id FROM  local_classification  WHERE localclassification_name='".$post['classification']."'";
		$clasid			=$this->MyDB->query($sql);

		$logoname=$logo['logo']['name'];
		$shire=explode(';',$_POST['region']);

		$res12 =$this->__userlistingValidation($post);

		if(!$res12['result'])
		{
			return $res12;
		}

		if($logoname=='')
		{
			$retArray = array("result"=>false, "message"=>'Please select your logo');
			return $retArray;

		}


		if($post['listing'] =='1')
		{
			$CHECK_RANK			="SELECT * FROM local_businesses
									WHERE expired=0 AND classification='{$post['classification']}' AND shire_name='{$shire['1']}' 
									AND Rank='{$post['rank']}'";

			$CHECK_RANK_RESULT	=$this->MyDB->query($CHECK_RANK);
		}


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
'{$initials}', '{$name}', '{$street1}', '{$street2}', '{$phonestd}', '{$phone}', '{$faxstd}', '{$fax}', '{$email}', '{$url}', '{$origin}', '{$mobile}', '{$contact}',".getSession("userid").", '{$postcode}', '{$rec[0]['shiretown_id']}', '{$sub[1]}','{$logoname }','{$description}','{$classification}', '{$state}','{$listing}','{$rank}','{$shire[1]}','{$sub[1]}')";


			$res=$this->MyDB->query($SQL);
			$busiId=$this->MyDB->getInsertID($res);

			$sql = "INSERT INTO `business_classification` (`businessclassification_id`, `business_id`, `localclassification_id`) VALUES ('', '{$busiId}', '{$clasid[0]['localclassification_id']}')";

			$this->MyDB->query($sql);

			$INSERT_RANK	="INSERT INTO `rank_allocation` (
										`rank_id` ,
										`classification_name` ,
										`region_name` ,
										`client_id` ,
										`rank`
										)
										VALUES (
										NULL , '{$post['classification']}', '{$shire['1']}', ".getSession("userid").", '{$post['rank']}'
										)";
			$this->MyDB->query($INSERT_RANK);


			$rec=array("result"=>true, "message"=>'Added Successfully',"InsertID"=>$busiId);
		}
		return $rec;
	}



	/*INSERT INTO business_classification('business_id','localclassification_id')
	VALUES(6270127,624)*/


	public function updateAdd($post)
	{
		$ID=$_GET['ID'];
		$SQL="UPDATE local_businesses SET Rank={$post['rank']} WHERE business_id={$ID}";
		$this->MyDB->query($SQL);
		$rec=array("result"=>true, "message"=>'Added Successfully');
		return $rec;
	}


	/**
	*@desc  This function is used for fetching all the regions.
	*/
	public function fetchRegion($business_id=0)
	{
		$business_id 		= (!empty($_GET['ID']))?$_GET['ID']:NULL;
		
		$SQL="SELECT * FROM shire_names";
		if($business_id)
		{
		$SQL.= " WHERE shirename_id NOT IN (SELECT shire_name FROM multiple_addresses WHERE business_id={$business_id})";
		}
		$rec=$this->MyDB->query($SQL);
		return $rec;
	}

	/**
	*@desc  This function is used for fetching all the suburb.
	*/
	public function getSuburb($get)
	{
		$SQL="SELECT
					*
					FROM
					shire_towns
					WHERE shirename_id='{$get['ID']}' ORDER BY shiretown_townname";
		$rec=$this->MyDB->query($SQL);
		return $rec;
	}


	/**
	*@desc  This function is used for fetching all the town.
	*/
	public function fetchTownDetails()
	{
		$SQL="SELECT
		            *
			  FROM
			        shire_towns";
		$rec=$this->MyDB->query($SQL);
		return $rec;
	}


	/**
	*@desc  This function is used for fetching all the rank rates.
	*/
	public function fetchRankRate()
	{
		$SQL="SELECT
		            *
			  FROM
			         rank_rate";
		$rec=$this->MyDB->query($SQL);
		return $rec;
	}

	/**
	*@desc  This function is used for fetching all the business listing that are associated with the client who is logged in.
	*/
	public function fetchDetails($post)
	{
		$SQL="SELECT
		            * 
			  FROM
			       local_businesses
			  WHERE
			  expired=0 AND
			       client_id=".getSession("userid")."";
		$res=$this->MyDB->query($SQL);
		return $res;
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

	/**
	*@desc  This function is used for fetching all the business according to the shiretowns.
	*/
	public function editListingFetchDetails()
	{
		$rec=$this->fetchTownDetails();
		$region=$this->fetchRegion();
		$condition = $_GET['ID'];
		$SQL="SELECT
		            * 
			  FROM 
			        local_businesses AS LB,
					shire_towns AS ST 
			  WHERE LB.expired=0 AND LB.business_id=$condition 
			        AND
					   ST.shiretown_id=".$rec[0]['shiretown_id']."
					    ";
		$res=$this->MyDB->query($SQL);
		return $res;
	}
	
	public function card_details()
	{
		$Business_id 			= $_GET['ID'];
		$SQL="SELECT * FROM  local_pages WHERE business_id=$Business_id ";
		$res=$this->MyDB->query($SQL);
		return $res;
	}
	
	

	/**
	*@desc  This function is used for fetching all the business according to the search criteria. And return business on true or 		            return no recods when there is no result corresponding to that particular search criteria.
	*/
	public function searchBusiness($post, $fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
	{
		$retArray = array();
		$this->MyDB->reset();

		$name 			= (!empty($post['name']))?$post['name']:NULL;
		$AccountNo 			= (!empty($post['AccountNo']))?$post['AccountNo']:NULL;

		if($AccountNo == '' && $name != '')
		{
			$condition	="local_businesses.business_name LIKE '%{$name}%'";
		}elseif($AccountNo != '' && $name == '')
		{
			$condition	="local_businesses.account_id = '{$AccountNo}'";
		}else
		{
			$condition	="local_businesses.business_name LIKE '%{$name}%' AND local_businesses.account_id = '{$AccountNo}'";
		}
		$condition .= " AND local_businesses.expired=0";

		$SQL			="SELECT
											local_businesses.business_id,
											local_businesses.business_name, 
											local_businesses.business_suburb, 
											local_businesses.business_phonestd, 
											local_businesses.business_phone ,
											local_businesses.business_addDate
										  FROM
											   local_businesses 
										  WHERE
												$condition
										  ORDER BY 
											  local_businesses.business_name ASC		
										  LIMIT $fr, $noOfRecords";

		$listings=$this->MyDB->query($SQL);

		$this->MyDB->reset();

		$SQL			="SELECT
											count(local_businesses.business_id) AS cnt
										  FROM
											local_businesses 
									  	WHERE
											$condition";
		$count_all = $this->MyDB->query($SQL);

		$retArray['listings'] = $listings;
		$retArray['paging'] = Paging::numberPaging($count_all[0]['cnt'], $fr, $noOfRecords);
		return $retArray;
	}//END OF SEARCH BUSINESS FUNCTION


	/**
	*@desc  This function is used for validating the search text.
	*/
	public function validatesearch1($get)
	{

		$retArray = array("result"=>false, "message"=>'');
		$errors = array();

		if($get['AccountNo'] == '' && $get['name'] == '')
		{
			$errors[] = "Enter Account Number or Business Name to search";
		}
		if(count($errors) == 0) {
			$retArray['result'] = true;
		}
		$retArray['message'] = $errors;
		return $retArray;


	}

	/**
	*@desc  This function is used for fetching all the shires.
	*/
	public function selectShires()
	{
		$SQL="SELECT
		            * 
			  FROM 
			        shire_names";
		$res=$this->MyDB->query($SQL);
		return $res;
	}


	/**
	*@desc  This function is used for fetching all the states.
	*/
	public function selectStates()
	{
		$SQL="SELECT
		            * 
			  FROM 
			        local_state";
		$res=$this->MyDB->query($SQL);
		return $res;
	}


	/**
	*@desc  This function is used for editing the business.
	*/
	public function editListing($post,$logo)
	{
		$archived 			= (!empty($post['archived']))?$post['archived']:NULL;
		$image				= $logo['logo']['name'];
		$image2				= $logo['image']['name'];		
		$shire				= explode(',',$_POST['region']);
		$sub				= explode(',',$post['suburb']);
		$Add1				= (!empty($_POST['Add1']))?$_POST['Add1']:0;
		$Add2				= (!empty($_POST['Add2']))?$_POST['Add2']:0;
		$Add3				= (!empty($_POST['Add3']))?$_POST['Add3']:0;
		$brand				= (!empty($_POST['brand']))?$_POST['brand']:0;
		$brand				= explode('-',$brand);
		$currentdate		= date("Y-m-d H:m:s");
		$business_id		= $_GET['ID'];
		$account_id        = (!empty($post['account_id']))?$post['account_id']:NULL;

		$result =$this->__userlistingValidation($post,$logo,"edit");
		if(!$result['result'])
		{
			return $result;
		}

		$final_array		=$this->changeValue($post,$logo);
		$oldValue			=serialize($final_array['oldValue']);
		$newValue			=serialize($final_array['newValue']);

		$insertEditHistory	="INSERT INTO `business_edit_history` (
																 `edit_id` ,
																`business_id` ,
																`client_id` ,
																`old_value` ,
																`new_value` ,
																`edit_type` ,
																`change_time` 
																)VALUES (
																	NULL,
															 		'{$business_id}',
																	'".getSession("userid")."',
																	'$oldValue',
																	'$newValue',
																	'general',
																	'{$currentdate}')"; 
		$this->MyDB->query($insertEditHistory);
		
		

		$image = $_FILES['logo']['name'];
		$tmp   = $_FILES['logo']['tmp_name'];
		move_uploaded_file($tmp,"View/Default/Images/client_image/$image");
		
		$image2 = $_FILES['image']['name'];
		$tmp2   = $_FILES['image']['tmp_name'];
		move_uploaded_file($tmp2,"View/Default/Images/client_image/$image2");		
		
		$ID			= $_GET['ID'];
		$condition  = $ID;
		$desc		= $post['description'];
		
		
		//logo Details
		$fetch_image_name		="SELECT business_logo FROM local_businesses WHERE business_id=$condition";
		$last_image				=$this->MyDB->query($fetch_image_name);
		
		$last_image_name		=$last_image[0]['business_logo'];
		
		if($image == ''){
			$image=$last_image_name;
		}
		
		//business details
		$fetch_image_name		="SELECT business_image FROM local_businesses WHERE business_id=$condition";
		$last_image				=$this->MyDB->query($fetch_image_name);
		
		$last_image_name		=$last_image[0]['business_image'];
		
		if($image2 == ''){
			$image2=$last_image_name;
		}		
		

		if($shire[0] != '59')
		{
		$SQL2			="SELECT shiretown_id FROM shire_towns WHERE shiretown_postcode='".$post['postcode']."' AND 	   shiretown_townname='".$sub[1]."'";
		$rec=$this->MyDB->query($SQL2);
		}
		

		$postcode				= (!empty($post['postcode']))?$post['postcode']:NULL;
		


		if($shire[0] != '59')
		{
			  $SQL="UPDATE
		              local_businesses
			    SET
						url_alias='{$post['url_alias']}',
						business_name='{$post['name']}',
						account_id='{$post['account_id']}',
						business_street1='{$post['street1']}',
						business_street2='{$post['street2']}',
						business_suburb='{$sub[1]}',
						business_postcode={$postcode},
						business_phonestd='{$post['phonestd']}',
						business_phone='{$post['phone']}',
						business_faxstd='{$post['faxstd']}',
						business_fax='{$post['fax']}',
						business_email='{$post['email']}',
						business_url='{$post['url']}',
						shiretown_id='{$rec[0]['shiretown_id']}',
						business_mobile='{$post['mobile']}',
						business_logo='{$image}',
						business_image='{$image2}',						
						shire_name='{$shire[1]}',
						business_description='{$post['description']}',
						shire_town='{$sub[1]}',					
						street1_status='{$Add1}',
						street2_status='{$Add2}',	
						map_status='{$Add3}',					
						archived='{$archived}',
						business_state='{$post['state']}' WHERE business_id=$condition";
		}else{
			 $SQL="UPDATE
		              local_businesses
			    SET
						url_alias='{$post['url_alias']}',				
						business_name='{$post['name']}',
						account_id='{$post['account_id']}',
						business_street1='{$post['street1']}',
						business_street2='{$post['street2']}',
						business_suburb=null,
						business_postcode=null,
						business_phonestd='{$post['phonestd']}',
						business_phone='{$post['phone']}',
						business_faxstd='{$post['faxstd']}',
						business_fax='{$post['fax']}',
						business_email='{$post['email']}',
						business_url='{$post['url']}',
						shiretown_id=null,
						business_mobile='{$post['mobile']}',
						business_logo='{$image}',
						business_image='{$image2}',						
						shire_name='{$shire[1]}',
						business_description='{$post['description']}',
						shire_town=null,					
						street1_status='{$Add1}',
						street2_status='{$Add2}',	
						map_status='{$Add3}',					
						archived='{$archived}',
						business_state='{$post['state']}' WHERE business_id=$condition"; 
		}
		$this->MyDB->query($SQL);

		//Updating new entry in indexed lookup table
		$listingFacade  = new ListingFacade($this->MyDB, $this->request);
		$listingFacade->updateLocalBusinessIndex($condition);

		$result = array("result"=>true, "message"=>'Update Successfully');
		return $result;
	}
	
	public function edit_card_details()
	{
		$name				= (!empty($_POST['name']))?$_POST['name']:NULL;
		
		$street1			= (!empty($_POST['street1']))?$_POST['street1']:NULL;
		$street2			= (!empty($_POST['street2']))?$_POST['street2']:NULL;
		$phonestd			= (!empty($_POST['phonestd']))?$_POST['phonestd']:NULL;
		$phone				= (!empty($_POST['phone']))?$_POST['phone']:NULL;
		$mobile				= (!empty($_POST['mobile']))?$_POST['mobile']:NULL;
		$faxstd				= (!empty($_POST['faxstd']))?$_POST['faxstd']:NULL;
		$fax				= (!empty($_POST['fax']))?$_POST['fax']:NULL;
		$email				= (!empty($_POST['email']))?$_POST['email']:NULL;
		$url				= (!empty($_POST['url']))?$_POST['url']:NULL;
		
		$text1				= (!empty($_POST['text1']))?$_POST['text1']:NULL;
		$text2				= (!empty($_POST['text2']))?$_POST['text2']:NULL;
		$text3				= (!empty($_POST['text3']))?$_POST['text3']:NULL;
		$text4				= (!empty($_POST['text4']))?$_POST['text4']:NULL;
		

		$BusinessID				=$_GET['ID']; 
		$fetch_business			="SELECT * FROM local_pages WHERE business_id={$BusinessID}"; 
		$result_business		=$this->MyDB->query($fetch_business);
		
		if(@$result_business[0]['page_image1'] == '')
		{
		$image1=$_FILES['image1']['name'];
		}else{
		$image1=$result_business[0]['page_image1'];
		}
		
		if(@$result_business[0]['page_image2'] == '')
		{
		$image2=$_FILES['image2']['name'];
		}else{
		$image2=$result_business[0]['page_image2'];
		}
		
		if(@$result_business[0]['page_image3'] == '')
		{
		$image3=$_FILES['image3']['name'];
		}else{
		$image3=$result_business[0]['page_image3'];
		}
		
		
		if(@$result_business[0]['page_image4'] == '')
		{
		$image4=$_FILES['image4']['name'];
		}else{
		$image4=$result_business[0]['page_image4'];
		}
		
		$tmp=$_FILES['image1']['tmp_name'];
		move_uploaded_file($tmp,"View/Default/Images/client_image/$image1");
		
		$tmp=$_FILES['image2']['tmp_name'];
		move_uploaded_file($tmp,"View/Default/Images/client_image/$image2");
		
		$tmp=$_FILES['image3']['tmp_name'];
		move_uploaded_file($tmp,"View/Default/Images/client_image/$image3");
		
		$tmp=$_FILES['image4']['tmp_name'];
		move_uploaded_file($tmp,"View/Default/Images/client_image/$image4");				
		
		
		if(count($result_business) == 0)
		{	
		$insert_add_word	="INSERT INTO `local_pages` (
												`localpage_id` , 
												`business_id` ,
												`business_name`,
												`page_street1`, 
												`page_street2`, 
												`page_pstd`,
												`page_phone`, 
												`page_fstd`, 
												`page_fax`, 
												`page_mobile`, 
												`page_email`,
												`page_url`,
												`page_field1`,
												`page_field2`,
												`page_field3`,
												`page_field4`,
												`page_image1`,
												`page_image2`,
												`page_image3`,
												`page_image4`
											)
										VALUES (
										'' ,
										'{$BusinessID}',
										'{$name}',
										'{$street1}',
										'{$street2}',
										'{$phonestd}',
										'{$phone}',
										'{$faxstd}',
										'{$fax}',
										'{$mobile}',
										'{$email}',
										'{$url}',
										'{$text1}',
										'{$text2}',
										'{$text3}',
										'{$text4}',
										'{$image1}',
										'{$image2}',
										'{$image3}',
										'{$image4}'
										)"; 
		$this->MyDB->query($insert_add_word);
		}else{
		$update_add_word="UPDATE local_pages SET 
												`business_name`='{$name}',
												`page_street1`='{$street1}', 
												`page_street2`='{$street2}', 
												`page_pstd`='{$phonestd}',
												`page_phone`='{$phone}', 
												`page_fstd`='{$faxstd}', 
												`page_fax`='{$fax}', 
												`page_mobile`='{$mobile}', 
												`page_email`='{$email}',
												`page_url`='{$url}',
												`page_field1`='{$text1}',
												`page_field2`='{$text2}',
												`page_field3`='{$text3}',
												`page_field4`='{$text4}',
												`page_image1`='{$image1}',
												`page_image2`='{$image2}',
												`page_image3`='{$image3}',
												`page_image4`='{$image4}'
						WHERE business_id=$BusinessID"; 
		$this->MyDB->query($update_add_word);
		}
		
		$add_card=array("result"=>true, "message"=>'Card Details Updated Successfully');
		return $add_card;
		
		
	
	}

	public function changeValue($post,$logo)
	{
		$newValue				= array();
		$oldValue				= array();
		$shire					= explode(',',$_POST['region']);
		$sub					= explode(',',$post['suburb']);
		$business_id			= $_GET['ID'];
		$image					= $_FILES['logo']['name'];
		$image2					= $_FILES['image']['name'];		
		$Add1					= (!empty($_POST['Add1']))?$_POST['Add1']:0;
		$Add2					= (!empty($_POST['Add2']))?$_POST['Add2']:0;
		
		$postcode				= (!empty($post['postcode']))?$post['postcode']:0;
			
		$oldValuefetch			= "SELECT * FROM local_businesses WHERE expired=0 AND business_id='$business_id'";
		$oldValueArray			= $this->MyDB->query($oldValuefetch);
		
		if($shire[0] != '59')
		{
		$SQL2					= "SELECT shiretown_id FROM shire_towns WHERE shiretown_postcode='".$postcode."' AND 	   shiretown_townname='".$sub[1]."'";
		$rec					= $this->MyDB->query($SQL2);
		}

		if($oldValueArray[0]['business_name'] != $post['name'])
		{
			$newValue['business_name']		=$post['name'];
			$oldValue['business_name']		=$oldValueArray[0]['business_name'];
		}
		
		if($oldValueArray[0]['url_alias'] != $post['url_alias'])
		{
			$newValue['url_alias']		    =$post['url_alias'];
			$oldValue['url_alias']		    =$oldValueArray[0]['url_alias'];
		}		

		if($oldValueArray[0]['business_street1'] != $post['street1'])
		{
			$newValue['business_street1']		=$post['street1'];
			$oldValue['business_street1']		=$oldValueArray[0]['business_street1'];
		}

		if($oldValueArray[0]['business_street2'] != $post['street2'])
		{
			$newValue['business_street2']		=$post['street2'];
			$oldValue['business_street2']		=$oldValueArray[0]['business_street2'];
		}

		if($oldValueArray[0]['street1_status'] != $Add1 && $Add1 !='0')
		{
			$newValue['Add1']		=$post['Add1'];
			$oldValue['Add1']		=$oldValueArray[0]['street1_status'];
		}

		if($oldValueArray[0]['street2_status'] != $Add2 && $Add2 !='0')
		{
			$newValue['Add2']		=$post['Add2'];
			$oldValue['Add2']		=$oldValueArray[0]['street2_status'];
		}

		if($oldValueArray[0]['business_state'] != $post['state'])
		{
			$newValue['state']		=$post['state'];
			$oldValue['state']		=$oldValueArray[0]['business_state'];
		}


		if($shire[0] != '59')
		{
		
		if($oldValueArray[0]['business_suburb'] != $sub['1'])
		{
			$newValue['business_suburb']		=$sub['1'];
			$oldValue['business_suburb']		=$oldValueArray[0]['business_suburb'];
		}
		}

		if($oldValueArray[0]['business_postcode'] != $post['postcode'])
		{
			$newValue['business_postcode']		=$post['postcode'];
			$oldValue['business_postcode']		=$oldValueArray[0]['business_postcode'];
		}

		if($oldValueArray[0]['business_phonestd'] != $post['phonestd'])
		{
			$newValue['business_phonestd']		=$post['phonestd'];
			$oldValue['business_phonestd']		=$oldValueArray[0]['business_phonestd'];
		}

		if($oldValueArray[0]['business_phone'] != $post['phone'])
		{
			$newValue['business_phone']		=$post['phone'];
			$oldValue['business_phone']		=$oldValueArray[0]['business_phone'];
		}

		if($oldValueArray[0]['business_faxstd'] != $post['faxstd'])
		{
			$newValue['business_faxstd']		=$post['faxstd'];
			$oldValue['business_faxstd']		=$oldValueArray[0]['business_faxstd'];
		}

		if($oldValueArray[0]['business_fax'] != $post['fax'])
		{
			$newValue['business_fax']		=$post['fax'];
			$oldValue['business_fax']		=$oldValueArray[0]['business_fax'];
		}

		if($oldValueArray[0]['business_email'] != $post['email'])
		{
			$newValue['business_email']		=$post['email'];
			$oldValue['business_email']		=$oldValueArray[0]['business_email'];
		}

		if($oldValueArray[0]['business_url'] != $post['url'])
		{
			$newValue['business_url']		=$post['url'];
			$oldValue['business_url']		=$oldValueArray[0]['business_url'];
		}

/*		if($oldValueArray[0]['business_origin'] != $post['origin'])
		{
			$newValue['business_origin']		=$post['origin'];
			$oldValue['business_origin']		=$oldValueArray[0]['business_origin'];
		}*/

		if($shire[0] != '59')
		{
		if($oldValueArray[0]['shiretown_id'] != $rec[0]['shiretown_id'])
		{
			$newValue['shiretown_id']		=$rec[0]['shiretown_id'];
			$oldValue['shiretown_id']		=$oldValueArray[0]['shiretown_id'];
		}
		}

		if($oldValueArray[0]['shire_name'] != $shire[1])
		{
			$newValue['shire_name']		=$shire[1];
			$oldValue['shire_name']		=$oldValueArray[0]['shire_name'];
		}

		if($shire[0] != '59')
		{
		if($oldValueArray[0]['shire_town'] != $sub[1])
		{
			$newValue['shire_town']		=$sub[1];
			$oldValue['shire_town']		=$oldValueArray[0]['shire_town'];
		}
		}

		if($oldValueArray[0]['business_mobile'] != $post['mobile'])
		{
			$newValue['business_mobile']		=$post['mobile'];
			$oldValue['business_mobile']		=$oldValueArray[0]['business_mobile'];
		}


		if($oldValueArray[0]['archived'] != $post['archived'])
		{
			$newValue['archived']		=$post['archived'];
			$oldValue['archived']		=$oldValueArray[0]['archived'];
		}

		if($oldValueArray[0]['business_logo'] != $image && $image !='')
		{
			$newValue['business_logo']		=$image;
			$oldValue['business_logo']		=$oldValueArray[0]['business_logo'];
		}
		
		if($oldValueArray[0]['business_image'] != $image2 && $image2 !='')
		{
			$newValue['business_image']		=$image2;
			$oldValue['business_image']		=$oldValueArray[0]['business_image'];
		}		

		if($oldValueArray[0]['business_description'] != $post['description'])
		{
			$newValue['business_description']		=$post['description'];
			$oldValue['business_description']		=$oldValueArray[0]['business_description'];
		}

		$finalArray					=array();
		$finalArray['oldValue']		=$oldValue;
		$finalArray['newValue']		=$newValue;

		return $finalArray;
	}


	/**
	*@desc  This function is used for deleting the business.
	*/
	public function delList($get)
	{
		$ID			=$_GET['ID'];
		$condition  =$ID;
		
		$SQL_DEL_RANK="DELETE
		      FROM 
			       business_ranks 
			  WHERE
			       business_id=".$condition.""; 

		$this->MyDB->query($SQL_DEL_RANK);
		
		$SQL_DEL_CLASS="DELETE
		      FROM 
			       business_classification 
			  WHERE
			       business_id=".$condition."";
		$this->MyDB->query($SQL_DEL_CLASS); 
				   		
		$SQL_DEL_LOCAL_PAGES="DELETE
		      FROM 
			       local_pages 
			  WHERE
			       business_id=".$condition."";
		$this->MyDB->query($SQL_DEL_LOCAL_PAGES);
				   
		$SQL_DEL_BRAND="DELETE
		      FROM 
			       business_brand 
			  WHERE
			       business_id=".$condition."";
		$this->MyDB->query($SQL_DEL_BRAND);
			   
		$SQL_DEL_HOURS="DELETE
		      FROM 
			       business_hours 
			  WHERE
			       business_id=".$condition."";	
		$this->MyDB->query($SQL_DEL_HOURS);
				   
		$SQL_DEL_PAYMENT="DELETE
		      FROM 
			       business_payment 
			  WHERE
			       business_id=".$condition."";				   		   
		$this->MyDB->query($SQL_DEL_PAYMENT);
		
		$SQL_DEL_SERVICE="DELETE
		      FROM 
			       business_service 
			  WHERE
			       business_id=".$condition."";				   		   
		$this->MyDB->query($SQL_DEL_SERVICE);		
			   
		$SQL="DELETE
		      FROM 
			       local_businesses 
			  WHERE
			       business_id=".$condition.""; 

		$this->MyDB->query($SQL);

		//Updating new entry in indexed lookup table
		$listingFacade  = new ListingFacade($this->MyDB, $this->request);
		$listingFacade->updateLocalBusinessIndex($condition);
		
		$Array = array("result"=>true, "message"=>'Deleted Successfully');
		return $Array;
	}

	/**
	*@desc  This function is used for validating the business add fields.
	*/
	private function __userlistingValidation(&$data,&$logo,$val)
	{
		$retArray = array("result"=>false, "message"=>'');
		$errors = array();

		if($val == 'add')
		{
			if(empty($data['AccNo']))
			{
				$errors[] = "Account Number is blank!!";
			}
		}


		if(empty($data['name']))
		{
			$errors[] = "name is blank!!";
		}

	

		$suburb			=explode(',',$data['suburb']);
		$shire			=explode(';',$data['region']);
		if($val=='edit')
		{
		$suburb			=explode(',',$data['suburb']);
		$shire			=explode(',',$data['region']);
		}

		if($shire[0] != '59'){
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
		}
		
		

		if(count($errors) == 0)
		{
			$retArray['result'] = true;
		}
		$retArray['message'] = $errors;
		return $retArray;
	}


	/**
	*@desc  This function is used for changing the password. It will validate the data entered by the user if returns true change            the password else return error message.
	*/
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
		$condition	="localuser_id=$localuser_id AND localuser_password='$password'";
		$this->MyDB->setWhere($condition) ;
		$resultArray=$this->MyDB->getAll();
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

	/**
	*@desc  This function is used for validating the password details.
	*/
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


	/**
	*@desc  This function is used for sending the new password to the user.
	*/
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


	/**
	*@desc  This function is used for searching the free listings.
	*/
	public function searchFreeListing($fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
	{
		$retArray = array();
		$this->MyDB->reset();
		$SQL="SELECT local_classification.localclassification_id,local_classification.localclassification_name,
				local_businesses.business_name,local_businesses.business_id,keywords.keyword,
				local_businesses.business_addDate FROM local_classification,local_businesses,business_classification,
				keywords WHERE local_businesses.expired=0 
				AND bold_listing='0' 
				AND (local_businesses.business_id=business_classification.business_id) 
				AND (local_classification.localclassification_id=business_classification.localclassification_id) 
				AND (keywords.localclassification_id=business_classification.localclassification_id) 
				LIMIT $fr,$noOfRecords";

		$listings=$this->MyDB->query($SQL);

		foreach ($listings as $k=>$category)
		{
			$keyResult		="SELECT keyword FROM keywords WHERE localclassification_id ={$category['localclassification_id']}";
			$keyResultArray	=$this->MyDB->query($keyResult);

			$arrTemp = array();
			foreach($keyResultArray as $val)
			$arrTemp[] = $val['keyword'];
			$str = implode(", ", $arrTemp);
			$listings[$k]['Key'] = $str;

		}


		$this->MyDB->reset();


		$SQL="SELECT
                    count(local_businesses.business_id) AS cnt
              FROM
			        local_classification,local_businesses,business_classification,keywords
              WHERE local_businesses.expired=0
			       AND bold_listing='0' AND (local_businesses.business_id=business_classification.business_id) AND (local_classification.localclassification_id=business_classification.localclassification_id) AND (keywords.localclassification_id=business_classification.localclassification_id)";

		$count_all = $this->MyDB->query($SQL);
		$retArray['listings'] = $listings;
		$retArray['paging'] = Paging::numberPaging($count_all[0]['cnt'], $fr, $noOfRecords);
		return $retArray;
	}


	public function searchListings($get,$fr=0,$noOfRecords=DEFAULT_PAGING_SIZE)
	{

		$retArray = array();
		$this->MyDB->reset();
		$SQL="SELECT local_classification.localclassification_id,local_classification.localclassification_name,
			local_businesses.business_name,local_businesses.business_id,keywords.keyword,local_businesses.business_addDate 
			FROM local_classification,local_businesses,business_classification,keywords 
			WHERE local_businesses.expired=0 
			AND bold_listing='0' AND (local_businesses.business_id=business_classification.business_id) 
			AND (local_classification.localclassification_id=business_classification.localclassification_id) 
			AND (keywords.localclassification_id=business_classification.localclassification_id) 
			AND (local_businesses.business_name LIKE '%{$get['businessname']}%') LIMIT $fr,10";

		$listings=$this->MyDB->query($SQL);

		foreach ($listings as $k=>$category)
		{
			$keyResult		="SELECT keyword FROM keywords WHERE localclassification_id ={$category['localclassification_id']}";
			$keyResultArray	=$this->MyDB->query($keyResult);

			$arrTemp = array();
			foreach($keyResultArray as $val)
			$arrTemp[] = $val['keyword'];
			$str = implode(", ", $arrTemp);
			$listings[$k]['Key'] = $str;

		}


		$this->MyDB->reset();


		$SQL="SELECT
                    count(local_businesses.business_id) AS cnt
              FROM
			        local_classification,local_businesses,business_classification,keywords
              WHERE local_businesses.expired=0
			       AND bold_listing='0' AND (local_businesses.business_id=business_classification.business_id) 
			       AND (local_classification.localclassification_id=business_classification.localclassification_id) 
			       AND (keywords.localclassification_id=business_classification.localclassification_id) 
			       AND( local_businesses.business_name LIKE '%{$get['businessname']}%')";

		$count_all = $this->MyDB->query($SQL);
		$retArray['listings'] = $listings;
		$retArray['paging'] = Paging::numberPaging($count_all[0]['cnt'], $fr, $noOfRecords);
		return $retArray;


	}

	public function searchList($get,$fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
	{
		$retArray = array();
		$SQL="SELECT
	                *
			FROM	
			       local_businesses
			WHERE local_businesses.expired=0
			       AND bold_listing=1 
				   AND
				   business_name LIKE '%{$get['businessname']}%'
			LIMIT 
			       $fr,$noOfRecords";
		$res=$this->MyDB->query($SQL);

		$SQL1="SELECT
		          count(business_id) AS cnt 
			  FROM 
			      local_businesses
			  WHERE local_businesses.expired=0
			      AND bold_listing=1
				  AND business_name LIKE '%{$get['businessname']}%'
			 ";

		$count_all = $this->MyDB->query($SQL1);
		$retArray['listings'] = $res;
		$retArray['paging'] = Paging::numberPaging($count_all[0]['cnt'], $fr, $noOfRecords);
		return $retArray;

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


	public function moreAddressesAdd($post)
	{
	//prexit($post);
		$id=$_GET['ID'];
		$shire		=explode(',',$post['region']);
		$sub		=explode(',',$post['suburb']);
		$Add1		= (!empty($_POST['Add1']))?$_POST['Add1']:0;
		$Add2		= (!empty($_POST['Add2']))?$_POST['Add2']:0;

		$res=$this->__addressFieldsValidation($post);
		if(!$res['result'])
		{

			return $res;
		}

		$sql="INSERT INTO `multiple_addresses`
									(
									`id`,
									`business_id`,
									`business_street1`,
									`business_street2`,
									`business_suburb`,
									`business_state`,
									`business_postcode`,
									`shire_name`,
									`shire_town`,
									`street1_status`,
									`street2_status`,
									`user_id`) 
							VALUES 			(
									'',
									'{$id}',
									'{$post['street1']}',
									'{$post['street2']}',
									'{$sub[1]}',
									'{$post['state']}',
									'{$post['postcode']}',
									'{$shire[0]}',
									'{$sub[1]}',
									'{$Add1}',
									{$Add2},
									'".getSession("userid")."'
									)";
		$this->MyDB->query($sql);
		$result = array("result"=>true, "message"=>'Added Successfully');
		return $result;


	}


	public function __addressFieldsValidation($get)
	{
		$retArray = array("result"=>false, "message"=>'');
		$errors = array();

		if(empty($get['street1'])) {
			$errors[] = "Street1 field is blank";
		}

		if(empty($get['region'])) {
			$errors[] = "Please select region";
		}

		if(empty($get['suburb'])) {
			$errors[] = "Please select suburb";
		}

		if(count($errors) == 0) {
			$retArray['result'] = true;
		}
		$retArray['message'] = $errors;
		return $retArray;


	}

	public function manageAddress($fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
	{

		$id=$_GET['ID'];
		$sql="SELECT * FROM multiple_addresses AS ma,shire_names AS sn,shire_towns AS st WHERE business_id={$id} AND ma.shire_name=sn.shirename_id AND ma.shire_town=st.shiretown_id";
		$res=$this->MyDB->query($sql);

		$sql2="SELECT count(business_id) as cnt FROM multiple_addresses WHERE business_id={$id}";
		$count_all=$this->MyDB->query($sql2);

		$retArray['listings'] = $res;
		$retArray['paging'] = Paging::numberPaging($count_all[0]['cnt'], $fr, $noOfRecords);
		return $retArray;
	}


	public function editAddressesAdd($post)
	{
		$id=$_GET['ID1'];
		$shire		=explode(',',$_POST['region']);
		$sub		=explode(',',$post['suburb']);
		$Add1		= (!empty($_POST['Add1']))?$_POST['Add1']:0;
		$Add2		= (!empty($_POST['Add2']))?$_POST['Add2']:0;
		$sql="UPDATE multiple_addresses
	      SET
		      business_street1='{$post['street1']}',
			  business_street2='{$post['street2']}',
			  business_suburb='{$sub[1]}',
			  business_state='{$post['state']}',
			  business_postcode='{$post['postcode']}',
			  shire_name='{$shire[0]}',
			  shire_town='{$sub[1]}',
			  street1_status='{$Add1}',
			  street2_status='{$Add2}' 
	      WHERE 
		      id={$id}";
		$this->MyDB->query($sql);
		$result = array("result"=>true, "message"=>'Updated Successfully');
		return $result;

	}

	public function editaddressFetchDetails()
	{
		$id=$_GET['ID1'];
		$sql="select * from multiple_addresses where id='{$id}'";
		$res=$this->MyDB->query($sql);
		return $res;
	}

	public function deleteaddress()
	{
		$id=$_GET['ID1'];
		$sql="DELETE FROM multiple_addresses where id='{$id}'";
		$this->MyDB->query($sql);
		$result = array("result"=>true, "message"=>'Deleted Successfully');
		return $result;
	}

	public function fetchKeyword()
	{
		$fetchKey				="SELECT * FROM business_keyword_name";
		$result				=$this->MyDB->query($fetchKey);
		return $result;
	}

	public function fetchBrands()
	{
		$fetchBrand				="SELECT * FROM business_brand_name";
		$result				=$this->MyDB->query($fetchBrand);
		return $result;
	}


	public function fetchService()
	{
		$fetchService			= "SELECT * 
									FROM business_service_name";
		$result				= $this->MyDB->query($fetchService);
		return $result;
	}


	public function fetchBusinessBrand()
	{
		$BusinessID					= $_GET['ID'];
		$fetchBusinessBrand			= "SELECT * 
										FROM `business_brand` 
										WHERE `business_id`='{$BusinessID}' 
										ORDER BY business_brand_name ASC";
		$result						= $this->MyDB->query($fetchBusinessBrand);
		return $result;
	}


	public function editHourDays()
	{

		$fromHour					= $_POST['fromHour'];
		$toHour						= $_POST['toHour'];
		$day						= (!empty($_POST['day']))?$_POST['day']:'';
		$businessID					= $_GET['ID'];
		$currentdate				= date("Y-m-d H:m:s");

		$fetchOldBusinessHour		= "SELECT from_hour,to_hour FROM `business_hours` WHERE `business_id`={$businessID}";
		$hourResult  				= $this->MyDB->query($fetchOldBusinessHour);
		//prexit($hourResult);
		$oldValue					= serialize($hourResult);

		$finalValue['from_hour']	= $fromHour;
		$finalValue['to_hour']		= $toHour;

		$newValue					= serialize($finalValue);

		$midArray			=array_diff($hourResult[0],$finalValue);
		//echo count($midArry); exit;

		if(count($midArray) != '0')
		{

			$insertEditHistory			="INSERT INTO `business_edit_history` (
																 `edit_id` ,
																`business_id` ,
																`client_id` ,
																`old_value` ,
																`new_value` ,
																`edit_type` ,
																`change_time` 
																)VALUES (
																	NULL,
															 		'{$businessID}',
																	'".getSession("userid")."',
																	'$oldValue',
																	'$newValue',
																	'working hour',
																	'{$currentdate}')";
			$this->MyDB->query($insertEditHistory);
		}






		$deleteHours		="DELETE FROM business_hours WHERE business_id='{$businessID}'";
		$deleteResult		=$this->MyDB->query($deleteHours);

		$insertHour			="INSERT INTO business_hours
										(`business_id`,`from_hour`,`to_hour`) 
								 VALUES 
								 		('{$businessID}','{$fromHour}','{$toHour}')";
		$this->MyDB->query($insertHour);



		$fetchOldBusinessDays		= "SELECT business_days FROM `business_days` WHERE `business_id`={$businessID}";
		$daysResult  				= $this->MyDB->query($fetchOldBusinessDays);

		$oldValue					= serialize($daysResult);

		if($day != '')
		{
			$i=0;
			foreach($day as $value)
			{
				$finalDayValue[$i]['business_days']	=$value;
				$i++;
			}

			$newValue					=serialize($finalDayValue);
		}


		$insertEditDaysHistory			="INSERT INTO `business_edit_history` (
																 `edit_id` ,
																`business_id` ,
																`client_id` ,
																`old_value` ,
																`new_value` ,
																`edit_type` ,
																`change_time` 
																)VALUES (
																	NULL,
															 		'{$businessID}',
																	'".getSession("userid")."',
																	'$oldValue',
																	'$newValue',
																	'working days',
																	'{$currentdate}')";
		$this->MyDB->query($insertEditDaysHistory);

		$deleteDays			="DELETE FROM business_days WHERE business_id='{$businessID}'";
		$deleteDaysResult	=$this->MyDB->query($deleteDays);


		if(!empty($day))
		{
			foreach($day as $value)
			{

				$insertDays			="INSERT INTO business_days
										(`business_id`,`business_days`) 
								 VALUES 
								 		('{$businessID}','{$value}')"; 
				$this->MyDB->query($insertDays);

			}
		}else{
			$result = array("result"=>false, "message"=>'Select any working day');
			return $result;
		}

	}

	public function fetchHour()
	{
		$businessID				=$_GET['ID'];
		$fetchHour				="SELECT * FROM business_hours_name";
		$fetchHourResult		=$this->MyDB->query($fetchHour);
		return $fetchHourResult;
	}

	public function fetchBusinessHour()
	{
		$businessID				=$_GET['ID'];
		$fetchHour				="SELECT * FROM business_hours WHERE business_id='{$businessID}'";
		$fetchHourResult		=$this->MyDB->query($fetchHour);
		return $fetchHourResult;
	}

	public function fetchPayment()
	{
		$businessID				=$_GET['ID'];
		$fetchDays				="SELECT * FROM business_payment_name";
		$fetchDaysResult		=$this->MyDB->query($fetchDays);
		return $fetchDaysResult;
	}


	public function fetchBusinessPayment()
	{
		$businessID				=$_GET['ID'];
		$fetchHour				="SELECT * FROM business_payment WHERE business_id='{$businessID}'";
		$fetchHourResult		=$this->MyDB->query($fetchHour);
		return $fetchHourResult;
	}
	public function searchGeneralHistory($get,$fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
	{
		$type							= $_GET['edit_type'];
		$business_id					= $_GET['ID'];
		$generalChangeQuery				= "SELECT *
														FROM business_edit_history 
														WHERE business_id='{$business_id}' 
															AND edit_type='{$type}' ORDER BY change_time DESC 
														LIMIT $fr,$noOfRecords";

		$generalChangeResult			= $this->MyDB->query($generalChangeQuery);

		$generalChangeCountQuery		= "SELECT count(edit_id) as cnt FROM business_edit_history WHERE business_id='{$business_id}' AND edit_type='{$type}'";
		$count_all						= $this->MyDB->query($generalChangeCountQuery);


		foreach ($generalChangeResult as $k=>$value)
		{
			$fetchUsername		="SELECT localuser_username FROM local_user WHERE localuser_id={$value['client_id']}";
			$result				=$this->MyDB->query($fetchUsername);
			$generalChangeResult[$k]['client_name']=$result['0']['localuser_username'];

		}


		$retArray['generalChange'] 		= $generalChangeResult;
		$retArray['paging'] 			= Paging::numberPaging($count_all[0]['cnt'], $fr, $noOfRecords);
		//var_dump($retArray['paging']);
		return $retArray;
	}

	public function selectByClassification()
	{

		/*$Query 	= 	"SELECT businessrank_rank, shirename_id
		FROM business_ranks
		WHERE businessrank_rank <= 10 AND localclassification_id ='{$id}'";*/
		$Query 	= 	"SELECT localclassification_id, businessrank_rank, shirename_id
						FROM business_ranks 
						WHERE businessrank_rank <= 10";
		$res = $this->MyDB->query($Query);
		return $res;
	}

	/*********************************************END OF BUSINESS ADD/EDIT/DELETE/SEARCH******************************/
	/* $res1 =$this->__userRegisterValidation($post);
	if(!$res1['result'])
	{
	return $res1;


	$result =$this->__userlistingValidation($post);
	if(!$result['result'])
	{
	return $result;
	}
	}*/

}
?>