<?php
/**
   * @title   AdminFacade.class.php
    
   * @desc    This is an AdminFacade class. The purpose of this class is to perform the actual actions needed for a function which              was called from AdminControl class. 
*/
class AdminFacade extends MainFacade {

	public function __construct(MyDB $MyDB){           //Start of The __contructor.purpose is to assign database parmeters to                                                           //a variable acting as an object and using that object to declare
		$this->MyDB = $MyDB;                             //the table name,sequence name and primary column.
		$this->MyDB->table=TBL_LOCAL_USER;
		$this->MyDB->sequenceName=TBL_LOCAL_USER;
		$this->MyDB->primaryCol="localuser_id";
	}

	/**
	* @desc This function will be used for admin login with its validation check.
	* @param post values from Admin login form as arguments recieved here.
	* @return mixed Return true if login was successfull or false if failure.
	*/
	public function adminLogin($post)
	{
		$retArray 			= array("result"=>false, "message"=>'');
		$res 				= $this->__validateUser($post);

		if($res['result'])
		{
			$this->MyDB->addWhere("localuser_username='{$post['username']}' AND localuser_password='".md5($post['password'])."' AND localuser_access='{$post['type']}'");
			$result 	= $this->MyDB->getAll();
			if($result && count($result) == 1 && $result[0]['localuser_status']=='0')
			{
				$retArray['message'] = "Your are an inactive user!!";
			}
			elseif($result && count($result) == 1 && (($result[0]['localuser_status']!='0')||($result[0]['localuser_status']!='I')))
			{
				$fetchPermission		= "SELECT permissions.permission_short_name,user_permissions.permission_id
													FROM permissions,user_permissions 
													WHERE user_permissions.localuser_id={$result[0]['localuser_id']} 
													AND permissions.permission_id=user_permissions.permission_id 
													ORDER BY user_permissions.permission_id ASC";
				$permissionResult 		= $this->MyDB->query($fetchPermission);

				$permArray				=array();
				$i=0;
				foreach($permissionResult as $value)
				{
					$permArray[$i][0]		=$value['permission_short_name'];
					$permArray[$i][1]		=$value['permission_id'];
					$i++;
				}

				setSession("user_permission", $permArray);
				setSession("localuser_access", $result[0]['localuser_access']);
				setSession("localuser_status", $result[0]['localuser_status']);
				setSession("userid", $result[0]['localuser_id']);
				setSession("username", $result[0]['localuser_username']);
				$retArray['result'] = true;
			}
			else{
				$retArray['message'] = "Wrong username OR password!!";
			}
		}
		else{
			$retArray['message'] = $res['message'];
		}

		return $retArray;
	}

	/**
	* @desc This function will be used for validation check of admin login form.
	* @param recieves posted data from user login form as a reference to adminLogin()
	* @return mixed Return true if validation was successfull or false if failure to adminLogin().
	*/
	private function __validateUser(&$data)
	{
		$retArray 				= array("result"=>false, "message"=>'');
		$errors 				= array();
		if(empty($data['username'])) {
			$errors[] 			= "Username is blank!!";
		}
		if(empty($data['password'])) {
			$errors[] 			= "Password is blank!!";
		}
		if(count($errors) == 0) {
			$retArray['result'] = true;
		}
		$retArray['message'] 	= $errors;
		return $retArray;
	}


	/**
	* @desc This function will be used for user logout by destroying session.
	* @param NULL
	* @return mixed Return true if logout was successful with a message 
	*/
	public function userLogout()
	{
		unset_session();
		$res 					= array("result"=>true, "message"=>'You have been successfully logged out!!');
		return $res;
	}

	/**
	* @desc This function will be used for adding user related informations.
	* @param posted values from user form, where he fills the data.(Admin in this case.)
	* @return mixed Return true if addition was successfull or false if failure.
	*/
	public function userAdd($post)
	{
		$res1 =$this->__userRegisterValidation($post);
		if(!$res1['result']){
			return $res1;
		}
		else
		{
			$data 						= array('localuser_firstname'=>$post['firstname'],
			'localuser_surname'=>$post['surname'],
			'localuser_username'=>$post['username'],
			'localuser_password'=>md5($post['password']),
			'localuser_email'=>$post['email'],
			'localuser_phone'=>$post['phone'],
			'localuser_mobile'=>$post['mobile'],
			'localuser_access'=>$post['access'],
			'localuser_status'=>'0');
			$this->MyDB->setWhere("localuser_username='".$post['username']."'");
			$resultArray				= $this->MyDB->getAll();

			if(count($resultArray)>0)
			{
				$retArray 				= array("result"=>false, "message"=>'Username Already Exists!! please try some other name');
				return $retArray;
			}
			else{
				$this->MyDB->save($data);
				$UserID					=$this->MyDB->getInsertId();

				if($post['access'] == 'admin'){
					$condition	="role_id='1'";
				}elseif($post['access'] == 'SAcManager'){
					$condition	="role_id='2'";
				}elseif($post['access'] == 'Employee'){
					$condition	="role_id='3'";
				}

				$insertDefaultPermissions		= "SELECT * FROM default_permission WHERE $condition";
				$defaultPermissionsArray 		= $this->MyDB->query($insertDefaultPermissions);

				foreach($defaultPermissionsArray as $defVal)
				{
					$insertNewPermission	="INSERT INTO user_permissions (
											localuser_id,
											permission_id)
											VALUES (
											'{$UserID}',
											{$defVal['permission_id']})";
					$permissionArray		=$this->MyDB->query($insertNewPermission);
				}

				$rand_code = md5(uniqid(rand(), true));
				$sql = "INSERT INTO
							 client_verification 
							 (`client_id`, `var_code`)
							VALUES 
							 (
							 '".$this->MyDB->getInsertId()."',
							 '".$rand_code."')";
				$this->MyDB->execute($sql);
				//sending verification email
				$mailer = new Mailer();
				$mailer->AddAddress($post['email']);
				// $mailer->IsHTML();
				$mailer->Body = "Hi,\nTo activate your account click on the link below\n\n".ADMIN_SITE_PATH.                                     "activate.php?code=$rand_code\n.Your username is={$post['username']}\nyour password is={$post['password']}";
				$mailer->Subject = "Activation Link";
				if(!$mailer->Send())
				{
					$retArray 			= array("result"=>false, "message"=>'Invalid e-mail address');
					return $retArray;
					// echo $mailer->ErrorInfo;
				}
				$mailer->ClearAddresses();
				$retArray 			= array("result"=>true, "message"=>'Successfully Registered');
				return $retArray;
			}
		}
	}


	/**
	*@desc This function is used for editing the clients details.
	*/	
	public function activate()
	{
		$code = isset($_GET['code'])?$_GET['code']:'';
		if($code == '') {
			echo "errr";
		}
		else {
			$sql="SELECT
			           client_id 
				  FROM 
				       client_verification 
				  WHERE
				       var_code='$code'";
			$this->MyDB->reset();
			$res = $this->MyDB->query($sql);
			$client_id = $res[0]['client_id'];
			$this->MyDB->setWhere("localuser_id='$client_id'");
			$this->MyDB->update(array("localuser_status"=>"A"));
		}
		return $res;
	}


	/**
	* @desc This function will be used for adding user related informations.
	* @param posted values from user form, where he fills the data.(Admin in this case.)
	* @return mixed Return true if addition was successfull or false if failure.
	*/
	public function AdminbusinessAdd($post)
	{
		$res1 =$this->__businessAdditionValidation($post);
		if(!$res1['result'])
		{
			return $res1;
		}
		else
		{
			$data = array(
			'business_id'=>'',
			'business_initials'=>'',
			'business_name'=>$post['FName'],
			'business_street1'=>$post['Address1'],
			'business_street2'=>$post['Address2'],
			'business_suburb'=>$post['City'],
			'business_state'=>$post['State'],
			'business_postcode'=>$post['Zipcode'],
			'business_phonestd'=>'',
			'business_phone'=>$post['Phone'],
			'business_faxstd'=>'',
			'business_fax'=>$post['Fax'],
			'business_email'=>$post['Email'],
			'business_url'=>$post['URL'],
			'business_origin'=>'',
			'shiretown_id'=>'',
			'business_mobile'=>'',
			'business_contact'=>'',
			'bold_listing'=>'',
			'archived'=>'',
			'account_id'=>''
			);
			$this->MyDB->save($data);
			$retArray = array("result"=>true, "message"=>'');
			return $retArray;
		}
	}


	/**
	*@desc This function is used for counting the details of the user.
	*/	
	public function countUserDetails()
	{
		$ret = 0;
		$this->MyDB->setSelect("count(localuser_id) as cnt");
		$result 		= $this->MyDB->getAll();
		$ret 			= @$result[0]['cnt'];
		return $ret;
	}

	/**
	* @desc This function will be used for fetching user related informations.
	* @param NULL. 
	* @return records.
	*/
	public function fetchUserDetails($fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
	{
		$res 				= array();
		$sql				= "SELECT *
		   					FROM local_user 
							LIMIT $fr,".DEFAULT_PAGING_SIZE;
		$result 			= $this->MyDB->query($sql);
		$res['blogs'] 		= $result;
		$res['paging'] 	= Paging::numberPaging($this->countUserDetails(), $fr, DEFAULT_PAGING_SIZE);
		return $res;
	}

	/**
	* @desc This function will be used for validation check of user data entry form.
	* @param posted values from form as reference.
	* @return mixed Return true if validation was successfull or false if failure with error message.
	*/
	private function __userRegisterValidation(&$data)
	{
		$retArray = array("result"=>false, "message"=>'');
		$errors = array();
		
		if(empty($data['password'])) {
			$errors[] = "Password is blank!!";
		}

		if(empty($data['username'])) {
			$errors[] = "username is blank!!";
		}
		if(!preg_match("/^[0-9a-zA-Z_\.-]+\@[0-9a-zA-Z_\.-]+\.[0-9a-zA-Z_\.-]+$/",$data['email']) || empty($data['email']))
		{
			$errors[] = "email is not valid!!";
		}
		
		if(count($errors) == 0) {
			$retArray['result'] = true;
		}
		$retArray['message'] = $errors;
		return $retArray;
	}

	/**
	* @desc This function will be used for validation check of user data entry form.
	* @param posted values from form as reference.
	* @return mixed Return true if validation was successfull or false if failure with error message.
	*/
	private function __businessAdditionValidation(&$data)
	{
		$retArray = array("result"=>false, "message"=>'');
		$errors = array();
		if(empty($data['FName'])) {
			$errors[] = "First Name is blank!!";
		}
		if(!preg_match("/^[0-9a-zA-Z_\.-]+\@[0-9a-zA-Z_\.-]+\.[0-9a-zA-Z_\.-]+$/",$data['email'])||empty($data['email']))
		{
			$errors[] = "email is not valid!!";
		}

		if(count($errors) == 0) {
			$retArray['result'] = true;
		}
		$retArray['message'] = $errors;
		return $retArray;
	}

	/**
	* @desc This function will be used for getting user related informations and to show on the form fields using ID.
	* @param NULL.
	* @return records.
	*/
	public function editUser()
	{
		$condition 				= $_GET['ID'];
		$res 					= $this->MyDB->get($condition);
		return $res;
	}

	/**
	* @desc This function will be used for changing status of user as Active(1) or Inactive(0).
	* @param NULL
	* @return value after updation of status in table(local_user)'s ("localuser_status") field.
	*/
	public function changeStatus($get)
	{
		$ID 					= (!empty($_GET['ID']))?$_GET['ID']:NULL;
		$condition  			= "localuser_id={$ID}";
		$QUERY					="SELECT localuser_status
									FROM local_user 
									WHERE $condition";
		$res					=$this->MyDB->query($QUERY);
		if($res['0']['localuser_status'] =='0')
		{
			$data 				=array('localuser_status'=>'1');
		}else{
			$data 				=array('localuser_status'=>'0');
		}
		$this->MyDB->setWhere($condition);/*$this->MyDB->update($data);
		$retArray = array("result"=>true, "message"=>'');
		return $retArray;*/
		return $this->MyDB->update($data);
	}


	/**
	* @desc This function will be used for adding updated data after editing into table('local_user').
	* @param posted data from edit form after editing the existing information. 
	* @return mixed Return true if updation was successfull or false if failure.
	*/
	public function editAdd($post)
	{
		$ID						= $_GET['ID'];
		$condition  			= $ID;
		$password				= $post['password'];

		$res1 =$this->__UserValidation($post);
		if(!$res1['result'])
		{
			return $res1;
		}

		if($password == '')
		{
			$data =  array('localuser_firstname'=>$post['firstname'],
			'localuser_surname'=>$post['surname'],
			'localuser_username'=>$post['username'],
			'localuser_email'=>$post['email'],
			'localuser_phone'=>$post['phone'],
			'localuser_mobile'=>$post['mobile']);
		}else{
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
		$Array 					= array("result"=>true, "message"=>'Updated Successfully');
		return $Array;
	}

	/**
	* @desc This function will be used for validation the user details.
	* @param NULL
	*/
	private function __UserValidation(&$data)
	{
		$retArray = array("result"=>false, "message"=>'');
		$errors = array();

/*		if(empty($data['password'])) {
			$errors[] = "Password is empty!!";
		}

		if(empty($data['confpassword'])) {
			$errors[] = "Confirm Password is empty!!";
		}*/
		if($data['password'] != '')
		{
			if($data['confpassword'] != $data['password']) {
				$errors[] = "Password and Confirm password do not match!!";
			}
		}

		if(!preg_match("/^[0-9a-zA-Z_\.-]+\@[0-9a-zA-Z_\.-]+\.[0-9a-zA-Z_\.-]+$/",$data['email'])||empty($data['email']))
		{
			$errors[] = "Email is blank or Invalid!!";
		}

		if(count($errors) == 0) {
			$retArray['result'] = true;
		}
		$retArray['message'] = $errors;
		return $retArray;
	}

	/**
	* @desc This function will be used to delete user based on ID,(puposefully converting 'Active' to 'Inactive')
	* @param NULL
	* @return mixed Return true if deletion was successfull or false if failure.
	*/
	public function delUser($get)
	{
		$ID						= $_GET['ID'];
		$condition  			= $ID;
		$this->MyDB->remove($condition);
		$Array 					= array("result"=>true, "message"=>'');
		return $Array;
	}

	/**
	* @desc This function will be used creating the random password.
	* @param NULL
	* @return mixed Return true if password generation was successfull or false if failure.
	*/	
	public function createRandomPassword()
	{
		$chars 			= "abcdefghijkmnopqrstuvwxyz023456789";
		srand((double)microtime()*1000000);
		$i 				= 0;
		$pass 			= '' ;
		while ($i <= 7) {
			$num = rand() % 33;
			$tmp = substr($chars, $num, 1);
			$pass = $pass . $tmp;
			$i++;
		}
		return $pass;
	}


	/**
	* @desc This function will be used for getting the lost password after entering the login details and validate the details 		            too.
	* @param NULL
	*/	
	public function lostpassgain($post)
	{
		$res1 			=$this->__Validation($post);
		if(!$res1['result']){
			return $res1;
		}else{
			$username	=$post['username'];
			$type		=$post['type'];
			$this->MyDB->setWhere("	localuser_username='{$post['username']}' AND localuser_access='{$type}'");
			$rows		=$this->MyDB->getAll();
			//prexit($rows);

			if(count($rows)>0)
			{
				$localuser_username		=$rows['0']['localuser_username'];
				$localuser_email		=$rows['0']['localuser_email'];
				$localuser_firstname	=$rows['0']['localuser_firstname'];
				$localuser_surname		=$rows['0']['localuser_surname'];
				$newPassword			=$this->createRandomPassword();
				$data 					=array('localuser_password'=>md5($newPassword));
				$this->MyDB->setWhere("localuser_username='{$username}'") ;
				$this->MyDB->update($data);
				$mailBody	="Hi ".$localuser_firstname." ".$localuser_surname.",\nThis is your new password please login using this new password. \n\nYour User Name is '".$username."' \nYour Password is '".$newPassword."'\nThanks.";
			}else{//echo "nay";exit;
				$retArray 				= array("result"=>false, "message"=>'Username does not exists in our system.\nSorry for inconvinience. ');
				return $retArray;
			}

			$mailer = new Mailer();
			$mailer->AddAddress($localuser_email);
			$mailer->Subject 	= "Lost Password Recovery";
			//$mailer->From=$Email;
			//$mailer->FromName=$Name;
			$mailer->Body 		= $mailBody;
			$mailer->IsHTML(true);
			if(!$mailer->Send())
			{
				echo $mailer->ErrorInfo;
			}
			$mailer->ClearAddresses();


			$retArray = array("result"=>true, "message"=>'');
			return $retArray;
		}
	}

	/**
	* @desc This function will be used for validation the user details.
	* @param NULL
	*/
	private function __Validation(&$data)
	{
		$retArray = array("result"=>false, "message"=>'');
		$errors = array();
		if(empty($data['username'])) {
			$errors[] = "User Name is blank!!";
		}
		if(count($errors) == 0) {
			$retArray['result'] = true;
		}
		$retArray['message'] = $errors;
		return $retArray;
	}


	/**
	* @desc This function will be used to search the details of user according to the given search criteria.
	* @param NULL
	* @return mixed Return true if deletion was successfull or false if failure.
	*/	
	public function searchUsers($post,$fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
	{
		$access 					= (!empty($post['access']))?$post['access']:NULL;

		if(($access == 'admin')||($access == 'Employee')||($access == 'SAcManager'))
		{
			$condition	="localuser_username LIKE '%{$post['name']}%' AND localuser_access='".$post['access']."'";
		}
		else
		{
			$condition	="localuser_username LIKE '%{$post['name']}%'";
		}

		$query			="SELECT * FROM local_user WHERE $condition LIMIT $fr,".DEFAULT_PAGING_SIZE;
		$rows 			= $this->MyDB->query($query);
		$ret 			= 0;
		$sql			="select count(localuser_id) as cnt from local_user where $condition";
		$result 		= $this->MyDB->query($sql);
		$ret 			= @$result[0]['cnt'];
		$res['blogs'] 	= $rows;
		$res['paging'] 	= Paging::numberPaging($ret, $fr, DEFAULT_PAGING_SIZE);
		return $res;
	}

	/**
	* @desc This function will be used to validate the search field,
	* @param NULL
	* @return mixed Return true if validation is true.
	*/	
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


	public function addIp()
	{
		$results				= array();
		$ip						= $_SERVER['REMOTE_ADDR'];
		$sql					= "select * from site_visitors where IP='{$ip}'";
		$results				=$this->MyDB->query($sql);
		if(($ip == @$results[0]['ip']))
		{

		}else{
			$sql = "INSERT INTO site_visitors (`id`, `IP`) VALUES (NULL, '$ip')";
			//$this->MyDB->query($sql);
			$ipResult=array();
			$select_query="select * from site_stats where datereport=''";
			$ipResult=$this->MyDB->query($select_query);
			if(count($ipResult)==0)
			{
				$SQL="INSERT INTO `site_stats` (
				`id` ,
				`unique_visitors` ,
				`total_visits` ,
				`total_visit_home_page` ,
				`unique_visit_home_page`
				)
				VALUES (
				NULL , '0', '0', '0', '0'
				)";
				//$this->MyDB->query($SQL);
			}
			$unique_visitors		= @$ipResult['0']['unique_visitors']+1;
			$update_query			= "UPDATE site_stats SET `unique_visitors` = '$unique_visitors'
									  WHERE datereport='0000-00-00'";
			//$this->MyDB->query($update_query);

		}

		$total_visits					= 0;
		$select_query					= "select * from site_stats";
		$ipResult						= $this->MyDB->query($select_query);
		$total_visits					= @$ipResult['0']['total_visits']+1;
		$update_query					= "UPDATE site_stats SET
									 `total_visits` = '$total_visits'
									   WHERE datereport='0000-00-00'";
		//$this->MyDB->query($update_query);
	}


	public function viewReport($post)
	{
		if((@$post['FMonth']!='' && @$post['FYear']!='') || @$post['FYear']!='')
		{
			if(isset($post['FDate']) && isset($post['FMonth']) && isset($post['FYear']))
			{
				if(@$post['FDate']!='')
				{
					$FDate	= $post['FDate'];
				}
				else
				{
					$FDate	= '1';
				}
				if(@$post['FMonth']!='')
				{
					$FMonth	= $post['FMonth'];
				}
				else
				{
					$FMonth	= '1';
				}
				$FYear	= $post['FYear'];
				//$FromDate= $FDate."-".$FMonth."-".$FYear;
				$FromDate= $FYear."-".$FMonth."-".$FDate;
			}else{
				$FDate	= '';
				$FMonth	= '';
				$FYear	= '';
				$FromDate= '';
			}

			if(isset($post['ToDate']) && isset($post['ToMonth']) && isset($post['ToYear']))
			{
				if(@$post['ToDate']!='')
				{
					$ToDate	= $post['ToDate'];
				}
				else
				{
					$ToDate	= '31';
				}
				if(@$post['ToMonth']!='')
				{
					$ToMonth	= $post['ToMonth'];
				}
				else
				{
					$ToMonth	= '12';
				}
				$ToYear	= $post['ToYear'];
				//$ToDate  = $ToDate."-".$ToMonth."-".$ToYear;
				$ToDate  = $ToYear."-".$ToMonth."-".$ToDate;
			}else{
				//$ToDate	= date('d-m-y');
				$ToMonth	= '';
				$ToYear	= '';
				$ToDate  = '';
			}
			$a1=array();$a2=array();$a3=array();$a4=array();$a5=array();$a6=array();
			$sql="SELECT * FROM  site_stats WHERE site_stats.datereport BETWEEN '{$FromDate}' AND '{$ToDate}'";
			$rec=$this->MyDB->query($sql);
			for($i=0;$i<count($rec);$i++)
			{
				$a1[]  =$rec[$i]['unique_visitors'];
				$a2[]  =$rec[$i]['total_visits'];
				$a3[]  =$rec[$i]['total_visit_home_page'];
				$a4[]  =$rec[$i]['unique_visit_home_page'];
				$a5[]  =$rec[$i]['count_business_views'];
				$a6[]  =$rec[$i]['failed_searches'];
			}
			$record = array(array_sum(@$a1),array_sum(@$a2),array_sum(@$a3),array_sum(@$a4),array_sum(@$a5),array_sum(@$a6));
			// prexit($record);
		}
		else
		{
			$sql="SELECT * FROM  site_stats WHERE datereport='0000-00-00'";
			$record=$this->MyDB->query($sql);

		}
		return $record;
	}




	public function pagePopularityReport($post)
	{

		if((@$post['FMonth']!='' && @$post['FYear']!='') || @$post['FYear']!='')
		{
			if(isset($post['FDate']) && isset($post['FMonth']) && isset($post['FYear']))
			{
				if(@$post['FDate']!='')
				{
					$FDate	= $post['FDate'];
				}
				else
				{
					$FDate	= '1';
				}
				if(@$post['FMonth']!='')
				{
					$FMonth	= $post['FMonth'];
				}
				else
				{
					$FMonth	= '1';
				}
				$FYear	= $post['FYear'];
				//$FromDate= $FDate."-".$FMonth."-".$FYear;
				$FromDate= $FYear."-".$FMonth."-".$FDate;
			}
			else{
				$FDate	= '';
				$FMonth	= '';
				$FYear	= '';
				$FromDate= '';
			}

			if(isset($post['ToDate']) && isset($post['ToMonth']) && isset($post['ToYear']))
			{
				if(@$post['ToDate']!='')
				{
					$ToDate	= $post['ToDate'];
				}
				else
				{
					$ToDate	= '31';
				}
				if(@$post['ToMonth']!='')
				{
					$ToMonth	= $post['ToMonth'];
				}
				else
				{
					$ToMonth	= '12';
				}
				$ToYear	= $post['ToYear'];
				//$ToDate  = $ToDate."-".$ToMonth."-".$ToYear;
				$ToDate  = $ToYear."-".$ToMonth."-".$ToDate;
			}
			else{
				//$ToDate	= date('d-m-y');
				$ToMonth	= '';
				$ToYear	= '';
				$ToDate  = '';
			}
			$p1=$p2=$p3=$p4=$p5=$p6=$p7=$p8=$p9=$p10=$p11=$p12=$p13=$p14=$p15=$p16=$p17=$p18=$p19=$p20=$p21=$p22=$p23=$p24=$p25='';
			$a1=array();
			$a2=array();
			$a3=array();
			$a4=array();
			$a5=array();
			$a6=array();
			$a7=array();
			$a8=array();
			$a9=array();
			$a10=array();
			$a11=array();
			$a12=array();
			$a13=array();
			$a14=array();
			$a15=array();
			$a16=array();
			$a17=array();
			$a18=array();
			$a19=array();
			$a20=array();
			$a21=array();
			$a22=array();
			$a23=array();
			$a24=array();
			$a25=array();

			$page_stats_query="SELECT page_stats.page_id,page_stats.views,page_stats.datereport,page_details.page_name,page_details.count FROM page_stats,page_details WHERE page_stats.datereport BETWEEN '{$FromDate}' AND '{$ToDate}' AND page_stats.page_id=page_details.page_id";
			$rec=$this->MyDB->query($page_stats_query);//prexit($rec);
			for($i=0;$i<count($rec);$i++)
			{
				if($rec[$i]['page_id']=='1')
				{
					$a1[]=$rec[$i]['views'];
					$p1=$rec[$i]['page_name'];}
					else if($rec[$i]['page_id']=='2')
					{		  $a2[]=$rec[$i]['views'];$p2=$rec[$i]['page_name'];}
					else if($rec[$i]['page_id']=='3')
					{		  $a3[]=$rec[$i]['views'];$p3=$rec[$i]['page_name'];}
					else if($rec[$i]['page_id']=='4')
					{		  $a4[]=$rec[$i]['views'];$p4=$rec[$i]['page_name'];}
					else if($rec[$i]['page_id']=='5')
					{		  $a5[]=$rec[$i]['views'];$p5=$rec[$i]['page_name'];}
					else if($rec[$i]['page_id']=='6')
					{		  $a6[]=$rec[$i]['views'];$p6=$rec[$i]['page_name'];}
					else if($rec[$i]['page_id']=='7')
					{		  $a7[]=$rec[$i]['views'];$p7=$rec[$i]['page_name'];}
					else if($rec[$i]['page_id']=='8')
					{		  $a8[]=$rec[$i]['views'];$p8=$rec[$i]['page_name'];}
					else if($rec[$i]['page_id']=='9')
					{		  $a9[]=$rec[$i]['views'];$p9=$rec[$i]['page_name'];}
					else if($rec[$i]['page_id']=='10')
					{		  $a10[]=$rec[$i]['views'];$p10=$rec[$i]['page_name'];}
					else if($rec[$i]['page_id']=='11')
					{		  $a11[]=$rec[$i]['views'];$p11=$rec[$i]['page_name'];}
					else if($rec[$i]['page_id']=='12')
					{		  $a12[]=$rec[$i]['views'];$p12=$rec[$i]['page_name'];}
					else if($rec[$i]['page_id']=='13')
					{		  $a13[]=$rec[$i]['views'];$p13=$rec[$i]['page_name'];}
					else if($rec[$i]['page_id']=='14')
					{		  $a14[]=$rec[$i]['views'];$p14=$rec[$i]['page_name'];}
					else if($rec[$i]['page_id']=='15')
					{		  $a15[]=$rec[$i]['views'];$p15=$rec[$i]['page_name'];}
					else if($rec[$i]['page_id']=='16')
					{		  $a16[]=$rec[$i]['views'];$p16=$rec[$i]['page_name'];}
					else if($rec[$i]['page_id']=='17')
					{		  $a17[]=$rec[$i]['views'];$p17=$rec[$i]['page_name'];}
					else if($rec[$i]['page_id']=='18')
					{		  $a18[]=$rec[$i]['views'];$p18=$rec[$i]['page_name'];}
					else if($rec[$i]['page_id']=='19')
					{		  $a19[]=$rec[$i]['views'];$p19=$rec[$i]['page_name'];}
					else if($rec[$i]['page_id']=='20')
					{		  $a20[]=$rec[$i]['views']; $p20=$rec[$i]['page_name'];}
					else if($rec[$i]['page_id']=='21')
					{    	  $a21[]=$rec[$i]['views']; $p21=$rec[$i]['page_name'];}
					else if($rec[$i]['page_id']=='22')
					{		  $a22[]=$rec[$i]['views']; $p22=$rec[$i]['page_name'];}
					else if($rec[$i]['page_id']=='23')
					{		  $a23[]=$rec[$i]['views']; $p23=$rec[$i]['page_name'];}
					else if($rec[$i]['page_id']=='24')
					{		  $a24[]=$rec[$i]['views']; $p24=$rec[$i]['page_name'];}
					else if($rec[$i]['page_id']=='25')
					{		  $a25[]=$rec[$i]['views']; $p25=$rec[$i]['page_name'];}
			}
			$record[0]=array(array_sum($a1),array_sum($a2),array_sum($a3),array_sum($a4),array_sum($a5),array_sum($a6),array_sum($a7),array_sum($a8),array_sum($a9),array_sum($a10),array_sum($a11),array_sum($a12),array_sum($a13),array_sum($a14),array_sum($a15),array_sum($a16),array_sum($a17),array_sum($a18),array_sum($a19),array_sum($a20),array_sum($a21),array_sum($a22),array_sum($a23),array_sum($a24),array_sum($a25));
			$record[1]=array($p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8,$p9,$p10,$p11,$p12,$p13,$p14,$p15,$p16,$p17,$p18,$p19,$p20,$p21,$p22,$p23,$p24,$p25);




			//$record= array_merge($record[0],$record[1]);



		}
		else
		{
			$sql="select * from page_details";
			$record=$this->MyDB->query($sql);
		}
		return $record;
	}

	public function searchStats()
	{

		$sql			="select count from search_stats";
		$result		=$this->MyDB->query($sql);
		/*$totalUsers	=count($result);

		$totalCount=0;
		foreach($result as $searchValue)
		{
		$totalCount= $totalCount+$searchValue['count'];
		}
		$AvgCount	=$totalCount/$totalUsers;*/

		return $result;
	}

	public function searchStatsDateWise($post)
	{
		if(isset($post['FDate']) && isset($post['FMonth']) && isset($post['FYear']))
		{
			$FDate	= $post['FDate'];
			$FMonth	= $post['FMonth'];
			$FYear	= $post['FYear'];
			//$FromDate= $FDate."-".$FMonth."-".$FYear;
			$FromDate= $FYear."-".$FMonth."-".$FDate;
		}else{
			$FDate	= '';
			$FMonth	= '';
			$FYear	= '';
			$FromDate= '';
		}

		if(isset($post['ToDate']) && isset($post['ToMonth']) && isset($post['ToYear']))
		{
			$ToDate	= $post['ToDate'];
			$ToMonth	= $post['ToMonth'];
			$ToYear	= $post['ToYear'];
			//$ToDate  = $ToDate."-".$ToMonth."-".$ToYear;
			$ToDate  = $ToYear."-".$ToMonth."-".$ToDate;
		}else{
			//$ToDate	= date('d-m-y');
			$ToMonth	= '';
			$ToYear	= '';
			$ToDate  = '';
		}

		$sql			="SELECT * FROM  search_stats WHERE datereport BETWEEN '{$FromDate}' AND '{$ToDate}'";
		$result		=$this->MyDB->query($sql);
		return $result;
	}


	public function countclients()
	{
		$sql				= "select count(client_id) as cnt from client";
		$result			= $this->MyDB->query($sql);
		$res				= $result[0]['cnt'];
		return $res;
	}

	public function getClients($fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
	{
		$SQL			= "SELECT DISTINCT client_name,email,postcode,phone FROM client LIMIT $fr,".DEFAULT_PAGING_SIZE;
		$rows			= $this->MyDB->query($SQL);
		$res['blogs'] 	= $rows;
		$res['paging'] 	= Paging::numberPaging($this->countclients(), $fr, DEFAULT_PAGING_SIZE);
		return $res;
	}

	public function countLocalityBasedClients()
	{
		$sql			= "select count(c.client_id) as cnt from client as c,local_businesses as lb,shire_towns as st
						where lb.expired=0 AND c.client_id=lb.client_id AND lb.business_suburb=st.shiretown_townname  
						limit 0,".DEFAULT_PAGING_SIZE;
		$rows			= $this->MyDB->query($sql);
		$res1			= $rows[0]['cnt'];
		return $res1;

	}

	public function getSuburbs()
	{
		$sql="select shiretown_townname from shire_towns";
		$towns=$this->MyDB->query($sql);
		return $towns;

	}

	public function __validateSuburb($get)
	{
		if($get['suburb']=='--Select One--')
		{
			$selectValue=array("result"=>false, "message"=>'Please Select any Suburb');
			return $selectValue;
		}else{
			$selectValue=array("result"=>true);
			return $selectValue;
		}
	}
	public function getLocalityBasedClients($get,$fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
	{
		$sql			= "SELECT DISTINCT c.client_name,
											c.email,
											c.postcode,
											c.phone,
											lb.business_suburb 
								 FROM client as c,
									  local_businesses as lb,
									  shire_towns as st 
								 WHERE lb.expired=0
								 AND c.client_id=lb.client_id 
									AND lb.business_suburb=st.shiretown_townname 
									AND lb.business_suburb LIKE '%{$get['suburb']}%'
								LIMIT $fr,".DEFAULT_PAGING_SIZE;
		$rows			= $this->MyDB->query($sql);
		$res['blogs'] 	= $rows;
		$res['paging'] 	= Paging::numberPaging(count($rows), $fr, DEFAULT_PAGING_SIZE);
		return $res;
	}


	public function sumCategorySearchCount($post)
	{

		if((@$post['FMonth']!='' && @$post['FYear']!='') || @$post['FYear']!='')
		{
			if(isset($post['FDate']) && isset($post['FMonth']) && isset($post['FYear']))
			{
				if(@$post['FDate']!='')
				{
					$FDate	= $post['FDate'];
				}
				else
				{
					$FDate	= '1';
				}
				if(@$post['FMonth']!='')
				{
					$FMonth	= $post['FMonth'];
				}
				else
				{
					$FMonth	= '1';
				}
				$FYear	= $post['FYear'];
				//$FromDate= $FDate."-".$FMonth."-".$FYear;
				$FromDate= $FYear."-".$FMonth."-".$FDate;
			}
			else{
				$FDate	= '';
				$FMonth	= '';
				$FYear	= '';
				$FromDate= '';
			}

			if(isset($post['ToDate']) && isset($post['ToMonth']) && isset($post['ToYear']))
			{
				if(@$post['ToDate']!='')
				{
					$ToDate	= $post['ToDate'];
				}
				else
				{
					$ToDate	= '31';
				}
				if(@$post['ToMonth']!='')
				{
					$ToMonth	= $post['ToMonth'];
				}
				else
				{
					$ToMonth	= '12';
				}
				$ToYear	= $post['ToYear'];
				//$ToDate  = $ToDate."-".$ToMonth."-".$ToYear;
				$ToDate  = $ToYear."-".$ToMonth."-".$ToDate;
			}
			else{
				//$ToDate	= date('d-m-y');
				$ToMonth	= '';
				$ToYear	= '';
				$ToDate  = '';
			}
			$sql	="select count(id) as cnt from classification_stats_datewise where datereport between '{$FromDate}' and '{$ToDate}' ";
			$result	=$this->MyDB->query($sql);
			$ret 		= $result[0]['cnt'];
		}
		else
		{
			$ret 		= 0;
			$sql		= "select count(stat_id) as cnt from classification_stats";
			$result		= $this->MyDB->query($sql);
			$ret 		= $result[0]['cnt'];
		}
		return $ret;
	}

	public function categorySearchCount($post,$fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
	{
		if((@$post['FMonth']!='' && @$post['FYear']!='') || @$post['FYear']!='')
		{
			if(isset($post['FDate']) && isset($post['FMonth']) && isset($post['FYear']))
			{
				if(@$post['FDate']!='')
				{
					$FDate	= $post['FDate'];
				}
				else
				{
					$FDate	= '1';
				}
				if(@$post['FMonth']!='')
				{
					$FMonth	= $post['FMonth'];
				}
				else
				{
					$FMonth	= '1';
				}
				$FYear	= $post['FYear'];
				//$FromDate= $FDate."-".$FMonth."-".$FYear;
				$FromDate= $FYear."-".$FMonth."-".$FDate;
			}
			else{
				$FDate	= '';
				$FMonth	= '';
				$FYear	= '';
				$FromDate= '';
			}

			if(isset($post['ToDate']) && isset($post['ToMonth']) && isset($post['ToYear']))
			{
				if(@$post['ToDate']!='')
				{
					$ToDate	= $post['ToDate'];
				}
				else
				{
					$ToDate	= '31';
				}
				if(@$post['ToMonth']!='')
				{
					$ToMonth	= $post['ToMonth'];
				}
				else
				{
					$ToMonth	= '12';
				}
				$ToYear	= $post['ToYear'];
				//$ToDate  = $ToDate."-".$ToMonth."-".$ToYear;
				$ToDate  = $ToYear."-".$ToMonth."-".$ToDate;
			}
			else{
				//$ToDate	= date('d-m-y');
				$ToMonth	= '';
				$ToYear	= '';
				$ToDate  = '';
			}
			$date=date('Y-m-d');
			$sql="select sum(total_visits) as tv,sum(unique_visits) as uv,classification_name from classification_stats_datewise where datereport between '{$FromDate}' and '{$ToDate}' group by classification_id LIMIT $fr,".DEFAULT_PAGING_SIZE."";
			$result	=$this->MyDB->query($sql);
			$res['categorySearch'] = $result;
			$res['paging'] 		= Paging::numberPaging($this->sumCategorySearchCount($post), $fr, DEFAULT_PAGING_SIZE);
		}
		else
		{
			$sql					="select * from classification_stats LIMIT $fr,".DEFAULT_PAGING_SIZE."";
			$result				=$this->MyDB->query($sql);

			$res['categorySearch'] = $result;
			$res['paging'] 		= Paging::numberPaging($this->sumCategorySearchCount($post), $fr, DEFAULT_PAGING_SIZE);
		}	//prexit($res);
		return $res;
	}

	public function failed_search($post,$fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
	{
		//prexit($post);
		if((@$post['FMonth']!='' && @$post['FYear']!='') || @$post['FYear']!='')
		{
			if(isset($post['FDate']) && isset($post['FMonth']) && isset($post['FYear']))
			{
				if(@$post['FDate']!='')
				{
					$FDate	= $post['FDate'];
				}
				else
				{
					$FDate	= '1';
				}
				if(@$post['FMonth']!='')
				{
					$FMonth	= $post['FMonth'];
				}
				else
				{
					$FMonth	= '1';
				}
				$FYear	= $post['FYear'];
				//$FromDate= $FDate."-".$FMonth."-".$FYear;
				$FromDate= $FYear."-".$FMonth."-".$FDate;
			}else{
				$FDate	= '';
				$FMonth	= '';
				$FYear	= '';
				$FromDate= '';
			}

			if(isset($post['ToDate']) && isset($post['ToMonth']) && isset($post['ToYear']))
			{
				if(@$post['ToDate']!='')
				{
					$ToDate	= $post['ToDate'];
				}
				else
				{
					$ToDate	= '31';
				}
				if(@$post['ToMonth']!='')
				{
					$ToMonth	= $post['ToMonth'];
				}
				else
				{
					$ToMonth	= '12';
				}
				$ToYear	= $post['ToYear'];
				//$ToDate  = $ToDate."-".$ToMonth."-".$ToYear;
				$ToDate  = $ToYear."-".$ToMonth."-".$ToDate;
			}else{
				//$ToDate	= date('d-m-y');
				$ToMonth	= '';
				$ToYear	= '';
				$ToDate  = '';
			}


			$sql="select * from failed_searches where search_date between '{$FromDate}' and '{$ToDate}' ORDER BY searchid DESC LIMIT $fr,".DEFAULT_PAGING_SIZE."";
			$res=$this->MyDB->query($sql);
			$sql="select count(searchid) as cnt from failed_searches where search_date between '{$FromDate}' and '{$ToDate}'";
			$result=$this->MyDB->query($sql);
			$ret = $result[0]['cnt'];
			$reslt['search'] = $res;
			$reslt['paging'] = Paging::numberPaging($ret, $fr, DEFAULT_PAGING_SIZE);
		}
		else
		{
			$sql="select * from failed_searches where search_date  ORDER BY searchid DESC LIMIT $fr,".DEFAULT_PAGING_SIZE."";
			$res=$this->MyDB->query($sql);
			$sql="select count(searchid) as cnt from failed_searches ";
			$result=$this->MyDB->query($sql);
			$ret = $result[0]['cnt'];
			$reslt['search'] = $res;
			$reslt['paging'] = Paging::numberPaging($ret, $fr, DEFAULT_PAGING_SIZE);
		}
		return $reslt;

	}

	public function fetchClassificationDetails()
	{
		$SQL="SELECT
		            *
			  FROM
			        local_classification
			  ORDER BY LOCALCLASSIFICATION_NAME";
		$rec=$this->MyDB->query($SQL);
		return $rec;
	}
	
    public function fetchStates(){
	  $sql = "SELECT *
	            FROM local_state
			   ORDER BY localstate_id";
				
      return $this->MyDB->query($sql);
	}
	
	public function fetchLowerRankClassificationRegionCount($classificationID) {
	  $SQL =  "SELECT br.localclassification_id,shirename_id, count(2) as Count
                 FROM business_ranks br, local_classification lc
	            WHERE br.localclassification_id = $classificationID
	              AND lc.localclassification_id = $classificationID
		          AND br.businessrank_rank >  10
		     GROUP BY br.localclassification_id, br.shirename_id";
					 
		$rec=$this->MyDB->query($SQL);
		return $rec;			  
	}

	public function fetchClassificationCode($state='')
	{
	    if(isset($state)){
		  $sql = "SELECT *
		            FROM shire_names
				   WHERE shirename_state = {$state}";		
		} else {
		  $sql= "SELECT *
			       FROM shire_names";
		}		  
		
		$rec=$this->MyDB->query($sql);
		return $rec;
	}

	public function getClientName($get)
	{
		$SQL					="SELECT localuser_username
										FROM local_user WHERE localuser_id='{$get['ID']}'";
		$rec=$this->MyDB->query($SQL);
		return $rec;
	}

	/**
	* @desc This function will be used for getting the details of the business on the basis of classification.
	* @return mixed Return true if it get the detail of specified classification else false.
	*/		 
	public function ClassificationReport($post)
	{

		$SQL="SELECT *
			    FROM business_ranks br, shire_names sn
			   WHERE localclassification_id='{$post['classification']}'
			     AND  br.shirename_id = sn.shirename_id
			     AND  sn.shirename_state = {$post['state']}";
         			 
		$rec=$this->MyDB->query($SQL);

		foreach ($rec as $k=>$category)
		{
			$SQL	="SELECT
							business_name,client_id
							FROM local_businesses 
							WHERE local_businesses.expired=0
							AND business_id='{$category['business_id']}'";
			$result=$this->MyDB->query($SQL);
			$rec[$k]['business_name']=@$result[0]['business_name'];
			$rec[$k]['client_id']=@$result[0]['client_id'];

		}

		return $rec;
	}


	/**
		* @desc This function will be used for getting the details of the business on the basis of client.
		* @return mixed Return true if it get the details of details of client else false.
	*/		
	public function showClientDetails($get)
	{
		$client_id = isset($get['client_id'])?$get['client_id']:0;
		$result = array();
		if($client_id) {
			$fetchClientDetails				= "SELECT * FROM client,local_user WHERE client_id='{$client_id}' AND local_user.localuser_id = client.user_id_addedby";

			$result=$this->MyDB->query($fetchClientDetails);
		}
		return $result;
	}

	public function showClientBusinessInfo($get)
	{
		$client_id = isset($get['client_id'])?$get['client_id']:0;
		$business_id = isset($get['business_id'])?$get['business_id']:0;
		$result = array();
		if($client_id || $business_id) {
			if($business_id) {
				$sql = "SELECT
							business_id,
							account_id,
							business_name,
							shire_name,
							business_street1,
							business_street2,
							business_suburb,
							business_state,
							business_postcode,
							business_phone,
							url_alias
						FROM 
							local_businesses
						WHERE business_id='{$business_id}' 							
							";							
			}
			else {
				$sql = "SELECT
							business_id,
							business_name,
							account_id,
							shire_name,
							business_street1,
							business_street2,
							business_suburb,
							business_state,
							business_postcode
						FROM 
							local_businesses
						WHERE client_id='{$client_id}' 
						";												
			}
			$result=$this->MyDB->query($sql);			

			foreach($result as $key=>$business)
			{
			
                  $sql = "SELECT 
				             bcl.localclassification_id, 
							 lc.localclassification_name, 
							 m.market_name, 
							 b.add_date, b.expiry_date, b.banner_location, b.banner_name
                            FROM business_classification AS bcl 
                            LEFT JOIN local_classification AS lc ON (bcl.localclassification_id=lc.localclassification_id) 
                            LEFT JOIN banner AS b ON (bcl.localclassification_id=b.localclassification_id)  
                            LEFT JOIN markets AS m ON (m.market_id = b.market_id)   
                           WHERE bcl.business_id='{$business['business_id']}'
						     AND bcl.business_id = b.business_id";				
							 						  
				$classifications=$this->MyDB->query($sql);
				
				//If no banners are found then find other business details
				if(empty($classifications)){
                 $sql = "SELECT
						bcl.localclassification_id,
						lc.localclassification_name
					FROM 
						business_classification AS bcl
						LEFT JOIN local_classification AS lc
						ON (bcl.localclassification_id=lc.localclassification_id)
					WHERE 
						bcl.business_id='{$business['business_id']}'";							 				
						
				  $classifications=$this->MyDB->query($sql);						
				
				}
				if($classifications) {
					foreach($classifications as $k=>$cl)
					{
						$sql = "SELECT
									br.businessrank_rank,
									sh.shirename_shirename
								FROM 
									business_ranks AS br
									LEFT JOIN shire_names AS sh
									ON (br.shirename_id=sh.shirename_id)
								WHERE 
									br.business_id='{$business['business_id']}'
									AND
									br.localclassification_id='{$cl['localclassification_id']}'
									";
						$rank=$this->MyDB->query($sql);
						
						//fetching business view count
						$sql = "SELECT 
									views 
								FROM 
									business_classification_stats 
								WHERE 
									business_id={$business['business_id']}
									AND
									classification_id={$cl['localclassification_id']}
									";
						$rs=$this->MyDB->query($sql);
//						prexit($rs);
						$view_count = ($rs)?$rs[0]['views']:0;
						$classifications[$k]['view_count'] = $view_count;
						$classifications[$k]['rank'] = $rank;
					}
				}
				$result[$key]['classifications'] = $classifications;
				
			}
		}
//		prexit($result);
		return $result;
	}

	public function showClientBusinessDetails($get)
	{
		$client_id						= $get['client_id'];
		$fetchClientBusinessDetails				= "SELECT
												local_businesses.business_id,
												local_businesses.business_name,
												local_businesses.shire_name,
												business_ranks.localclassification_id,
												business_ranks.businessrank_rank 
											FROM 
												local_businesses,
												business_ranks 
											WHERE local_businesses.client_id='{$client_id}' 
												AND local_businesses.business_id=business_ranks.business_id
												AND business_ranks.businessrank_rank !='9999'";
		$result=$this->MyDB->query($fetchClientBusinessDetails);


		foreach ($result as $k=>$val)
		{
			$SQL	="SELECT
							localclassification_name
							FROM  local_classification  
							WHERE localclassification_id='{$val['localclassification_id']}'";
			$className=$this->MyDB->query($SQL);

			$result[$k]['classification_name']=@$className[0]['localclassification_name'];

		}
		return $result;
	}

	/**
		* @desc This function will be used for fetching the classification details.
		* @return mixed Return true if it get the classification name else false.
	*/	
	public function classificationName($post)
	{
		$query		="SELECT * FROM local_classification WHERE localclassification_id='{$post['classification']}'";
		$rec=$this->MyDB->query($query);
		return $rec;
	}


	public function sum_listings_in_classification()
	{
		$sql					= "SELECT count(DISTINCT local_classification .localclassification_id) as cnt
										FROM local_classification,local_businesses,business_classification 
										WHERE local_businesses.expired=0 
											AND local_businesses.business_id=business_classification.business_id 
											AND  (local_classification.localclassification_id=business_classification.localclassification_id)"; 
		$result=$this->MyDB->query($sql);
		$ret = $result[0]['cnt'];
		return $ret;
	}

	public function count_listings_in_classification($fr=0,$noOfRecords=DEFAULT_PAGING_SIZE)
	{

		$count_fetch				= "SELECT localclassification_name, CNT_RANKED, CNT_FREE FROM  local_classification
			 								LEFT JOIN 
												(SELECT business_classification.localclassification_id,COUNT(business_classification.business_id) AS CNT_RANKED 
													 FROM business_classification 
													 LEFT JOIN business_ranks ON 
													  business_ranks.business_id=business_classification.business_id 
													  WHERE business_ranks.businessrank_rank BETWEEN 1 AND 10 GROUP BY business_classification.localclassification_id) AS temptable 
											ON local_classification.localclassification_id=temptable.localclassification_id
											LEFT JOIN 
												(SELECT business_classification.localclassification_id,COUNT(business_classification.business_id) AS CNT_FREE 
													 FROM business_classification 
													 LEFT JOIN business_ranks ON 
													  business_ranks.business_id=business_classification.business_id 
													  WHERE business_ranks.businessrank_rank=9999 GROUP BY business_classification.localclassification_id) AS temptable1 
											ON local_classification.localclassification_id=temptable1.localclassification_id";
		$count_array				= $this->MyDB->query($count_fetch);
		$count						= count($count_array);



		$ranked_fetch				= "SELECT localclassification_name, CNT_RANKED, CNT_FREE FROM  local_classification
			 								LEFT JOIN 
												(SELECT business_classification.localclassification_id,COUNT(business_classification.business_id) AS CNT_RANKED 
													 FROM business_classification 
													 LEFT JOIN business_ranks ON 
													  business_ranks.business_id=business_classification.business_id 
													  WHERE business_ranks.businessrank_rank BETWEEN 1 AND 10 GROUP BY business_classification.localclassification_id) AS temptable 
											ON local_classification.localclassification_id=temptable.localclassification_id
											LEFT JOIN 
												(SELECT business_classification.localclassification_id,COUNT(business_classification.business_id) AS CNT_FREE 
													 FROM business_classification 
													 LEFT JOIN business_ranks ON 
													  business_ranks.business_id=business_classification.business_id 
													  WHERE business_ranks.businessrank_rank=9999 GROUP BY business_classification.localclassification_id) AS temptable1 
											ON local_classification.localclassification_id=temptable1.localclassification_id
											LIMIT $fr,".DEFAULT_PAGING_SIZE;
		$ranked_array				= $this->MyDB->query($ranked_fetch);



		$result['rank'] 	= $ranked_array;
		$result['paging'] 	= Paging::numberPaging($count, $fr, DEFAULT_PAGING_SIZE);
		return $result;
	}


	/*	$sql		="SELECT
	COUNT(bc.business_id)AS count_localclassification_name,
	lc.localclassification_name,lc.localclassification_id
	FROM
	business_classification as bc,
	local_classification as lc
	WHERE
	bc.localclassification_id=lc.localclassification_id
	AND
	(lc.localclassification_id
	IN
	(SELECT
	`localclassification_id`
	FROM `local_classification`))
	GROUP BY
	(lc.localclassification_name)
	LIMIT $fr,".DEFAULT_PAGING_SIZE;

	$res		=$this->MyDB->query($sql);

	$reslt['search'] = $res;
	$reslt['paging'] = Paging::numberPaging($this->sum_listings_in_classification(), $fr, DEFAULT_PAGING_SIZE);
	return $reslt;*/




	public function sum_listings_in_vertical($fr=0,$noOfRecords=DEFAULT_PAGING_SIZE)
	{
		$sql="select local_classification.localclassification_name from local_classification";
		$classification=$this->MyDB->query($sql);

		$FinalArr = array();
		$sql="SELECT
					 *
				FROM
					  vertical 
				";

		$listings=$this->MyDB->query($sql);
		$i=0;
		foreach ($listings as $k=>$category)
		{
			$ln = array();
			$FinalArr[$i]['vertical_id']=$category['vertical_id'];
			$FinalArr[$i]['vertical_title']=$category['vertical_title'];
			$FinalArr[$i]['vertical_description']=$category['vertical_description'];

			$sql="select classification_id from vertical_classification where vertical_id={$category['vertical_id']}";
			$all_classifications=$this->MyDB->query($sql);

			$sql="select count(business_id) from business_classification where localclassification_id in ($all_classifications)";
			$count_of_listing_in_vertical=$this->MyDB->query($sql);//prexit($count_of_listing_in_vertical);

			/*$sql="SELECT
			count(local_businesses.business_id) as cnt
			FROM
			vertical_classification as vc,local_classification as lc,local_businesses,business_classification as bc
			WHERE
			vc.vertical_id={$category['vertical_id']} AND vc.classification_id=lc.localclassification_id

			AND bc.localclassification_id= lc.localclassification_id
			limit $fr,10		    ";
			$temp=$this->MyDB->query($sql);
			foreach ($temp as $k=>$lname)
			{
			$ln[]=$lname['cnt'];
			}
			$FinalArr[$i]['cnt']=$ln;
			$i++;	*/
		}
		$ret = $FinalArr[0]['cnt'];
		return $ret;
	}


	public function count_listings_in_vertical($fr=0,$noOfRecords=DEFAULT_PAGING_SIZE)
	{
		$sql				="SELECT local_classification.localclassification_name from local_classification";
		$classification		=$this->MyDB->query($sql);

		$FinalArr = array();
		$sql="SELECT
	             *
	        FROM
			      vertical 
			";

		$listings=$this->MyDB->query($sql);
		$i=0;
		foreach ($listings as $k=>$category)
		{
			$ln = array();
			$FinalArr[$i]['vertical_id']=$category['vertical_id'];
			$FinalArr[$i]['vertical_title']=$category['vertical_title'];
			$FinalArr[$i]['vertical_description']=$category['vertical_description'];

			$sql="SELECT count(br.business_id) as ranked_cnt
					FROM 
						vertical_classification as vc,
						local_classification as lc,
						business_classification as bc,
						business_ranks as br
			        WHERE 
						vc.vertical_id={$category['vertical_id']} 
							AND vc.classification_id=lc.localclassification_id 
							AND bc.localclassification_id=lc.localclassification_id
							AND br.businessrank_rank BETWEEN 1 AND 10
							AND br.localclassification_id=vc.classification_id
							AND br.localclassification_id=bc.localclassification_id
							LIMIT $fr,".DEFAULT_PAGING_SIZE;
			$temp=$this->MyDB->query($sql);

			$sql_free="SELECT count(br.business_id) as free_cnt
					FROM 
						vertical_classification as vc,
						local_classification as lc,
						business_classification as bc,
						business_ranks as br
			        WHERE 
						vc.vertical_id={$category['vertical_id']} 
							AND vc.classification_id=lc.localclassification_id 
							AND bc.localclassification_id=lc.localclassification_id
							AND br.businessrank_rank='9999'
							AND br.localclassification_id=vc.classification_id
							AND br.localclassification_id=bc.localclassification_id
							LIMIT $fr,".DEFAULT_PAGING_SIZE;
			$temp_free=$this->MyDB->query($sql_free);
			/*$sql	="SELECT classification_id
			FROM vertical_classification
			WHERE vertical_id ={$category['vertical_id']}";
			$temp=$this->MyDB->query($sql);



			foreach($temp as $val)
			{
			$query	="SELECT COUNT(business_classification.business_id) AS cnt

			FROM  business_classification
			WHERE business_classification.localclassification_id
			IN ('{$val['classification_id']}') ";
			$classifivationID=$this->MyDB->query($query);
			}
			pre($classifivationID);*/
			foreach ($temp as $k=>$lname)
			{
				$ln[]=$lname['ranked_cnt'];
			}

			foreach ($temp_free as $k=>$free_listing)
			{
				$free_listing[]=$free_listing['free_cnt'];
			}


			$FinalArr[$i]['ranked_cnt']=$ln;
			$FinalArr[$i]['free_cnt']=$free_listing;
			$i++;
		}
		$Count=	count($FinalArr);
		$reslt['search'] = $FinalArr;
		$reslt['paging'] = Paging::numberPaging($Count, $fr, DEFAULT_PAGING_SIZE);
		return $reslt;

	}

	public function sum_listings_in_locality()
	{
		$sql2="select count(business_id) as cnt from local_businesses WHERE local_businesses.expired=0
	 		group by business_suburb  ";
		$result=$this->MyDB->query($sql2);
		$ret = count($result);
		return $ret;
	}



	public function count_listings_in_locality($fr=0,$noOfRecords=DEFAULT_PAGING_SIZE)
	{

		$count_fetch				= "SELECT shiretown_townname, CNT_RANKED, CNT_FREE FROM shire_towns
			 								LEFT JOIN 
												(SELECT local_businesses.business_suburb,
													 COUNT(local_businesses.business_id) AS CNT_RANKED 
													 FROM local_businesses 
													 LEFT JOIN business_ranks ON 
													  business_ranks.business_id=local_businesses.business_id 
													  WHERE business_ranks.businessrank_rank BETWEEN 1 AND 10 
													  GROUP BY local_businesses.business_suburb) AS temptable 
											ON shire_towns.shiretown_townname=temptable.business_suburb
											LEFT JOIN 
												(SELECT local_businesses.business_suburb,
													 COUNT(local_businesses.business_id) AS CNT_FREE 
													 FROM local_businesses 
													 LEFT JOIN business_ranks ON 
													  business_ranks.business_id=local_businesses.business_id 
													  WHERE business_ranks.businessrank_rank='9999'
													  GROUP BY local_businesses.business_suburb) AS temptable1 
											ON shire_towns.shiretown_townname=temptable1.business_suburb";
		$count_array				= $this->MyDB->query($count_fetch);
		$count						= count($count_array);



		$ranked_fetch				= "SELECT shiretown_townname, CNT_RANKED, CNT_FREE FROM shire_towns
			 								LEFT JOIN 
												(SELECT local_businesses.business_suburb,
													 COUNT(local_businesses.business_id) AS CNT_RANKED 
													 FROM local_businesses 
													 LEFT JOIN business_ranks ON 
													  business_ranks.business_id=local_businesses.business_id 
													  WHERE business_ranks.businessrank_rank BETWEEN 1 AND 10 
													  GROUP BY local_businesses.business_suburb) AS temptable 
											ON shire_towns.shiretown_townname=temptable.business_suburb
											LEFT JOIN 
												(SELECT local_businesses.business_suburb,
													 COUNT(local_businesses.business_id) AS CNT_FREE 
													 FROM local_businesses 
													 LEFT JOIN business_ranks ON 
													  business_ranks.business_id=local_businesses.business_id 
													  WHERE business_ranks.businessrank_rank='9999'
													  GROUP BY local_businesses.business_suburb) AS temptable1 
											ON shire_towns.shiretown_townname=temptable1.business_suburb
											LIMIT $fr,".DEFAULT_PAGING_SIZE;
		$ranked_array				= $this->MyDB->query($ranked_fetch);



		$result['rank'] 	= $ranked_array;
		$result['paging'] 	= Paging::numberPaging($count, $fr, DEFAULT_PAGING_SIZE);
		return $result;
	}

	//======================================Earlier code==========================================

	/*		 echo $ranked_fetch				= "SELECT shiretown_townname, CNT, rank FROM shire_towns
	LEFT JOIN
	(SELECT local_businesses.business_suburb,
	COUNT(local_businesses.business_id) AS CNT,
	(CASE WHEN business_ranks.businessrank_rank=9999 THEN 'free' ELSE 'ranked' END) AS rank
	FROM local_businesses
	LEFT JOIN business_ranks ON
	business_ranks.business_id=local_businesses.business_id
	GROUP BY local_businesses.business_suburb) AS temptable
	ON shire_towns.shiretown_townname=temptable.business_suburb";
	exit;*/





	/*	$free_fetch				= "SELECT shiretown_townname, CNT_FREE FROM shire_towns
	LEFT JOIN
	(SELECT local_businesses.business_suburb,
	COUNT(local_businesses.business_id) AS CNT_FREE
	FROM local_businesses
	LEFT JOIN business_ranks ON
	business_ranks.business_id=local_businesses.business_id
	WHERE business_ranks.businessrank_rank='9999'
	GROUP BY local_businesses.business_suburb) AS temptable
	ON shire_towns.shiretown_townname=temptable.business_suburb";
	$free_array					= $this->MyDB->query($free_fetch);



	foreach ($ranked_array as $l=>$ranked_listing)
	{
	$ranked[]=$ranked_listing['cnt_ranked'];
	}

	foreach ($free_array as $m=>$free_listing)
	{
	$free[]=$free_listing['cnt_free'];
	}

	foreach ($free_array as $n=>$free_listing)
	{
	$name[]=$free_listing['shiretown_townname'];
	}

	$FinalArr['cnt_ranked']=$ranked;
	$FinalArr['cnt_free']=$free;
	$FinalArr['shiretown_townname']=$name;


	prexit($FinalArr);


	$sql				= "SELECT * FROM shire_towns";
	$rec				= $this->MyDB->query($sql);

	$i=0;
	foreach ($rec as $k=>$category)
	{
	$shirename_id		= addslashes($category['shiretown_townname']);
	$sql2				= "SELECT COUNT(local_businesses.business_id) as CNT_RANKED
	FROM local_businesses,business_ranks,shire_towns
	WHERE local_businesses.expired=0
	AND business_ranks.businessrank_rank BETWEEN 1 AND 10
	AND business_ranks.shirename_id=shire_towns.shirename_id
	AND local_businesses.business_suburb='{$shirename_id}'
	AND shire_towns.shiretown_townname=local_businesses.business_suburb
	LIMIT $fr,".DEFAULT_PAGING_SIZE;
	$res				= $this->MyDB->query($sql2);

	echo $test				="SELECT shiretown_townname, CNT FROM shire_towns
	LEFT JOIN
	(SELECT local_businesses.business_suburb,
	COUNT(local_businesses.business_id) AS CNT
	FROM local_businesses
	LEFT JOIN business_ranks ON
	business_ranks.business_id=local_businesses.business_id
	WHERE business_ranks.businessrank_rank BETWEEN 1 AND 10
	GROUP BY local_businesses.business_suburb) AS temptable
	ON shire_towns.shiretown_townname=temptable.business_suburb";exit;



	$sql_free				= "SELECT COUNT(local_businesses.business_id) as CNT_FREE,
	local_businesses.business_suburb
	FROM local_businesses,business_ranks,shire_towns
	WHERE local_businesses.expired=0
	AND business_ranks.businessrank_rank='9999'
	AND local_businesses.business_suburb='{$shirename_id}'
	AND shire_towns.shiretown_townname=local_businesses.business_suburb
	GROUP BY local_businesses.business_suburb
	LIMIT $fr,".DEFAULT_PAGING_SIZE; exit;
	$res_free				=$this->MyDB->query($sql_free);

	foreach ($res as $l=>$lname)
	{
	$ln[]=$lname['cnt_ranked'];
	}

	foreach ($res_free as $m=>$free_listing)
	{
	$free_listing[]=$free_listing['cnt_free'];
	}

	$FinalArr[$i]['cnt_ranked']=$ln;
	$FinalArr[$i]['cnt_free']=$free_listing;
	$FinalArr[$i]['shiretown_townname']=$category['shiretown_townname'];
	$i++;

	}

	//pre($res);
	// prexit($res_free);
	/*		 			$i=0;
	foreach ($res as $k=>$lname){

	$FinalArr['ranked_cnt'][$i]['cnt_ranked']=$lname['cnt_ranked'];
	foreach ($res_free as $js=>$free_listing){
	if($lname['business_suburb']==$free_listing['business_suburb']){
	echo $free_listing['cnt_free'];//$FinalArr['free_cnt'][$i]['cnt_free']=$free_listing['cnt_free'];
	break;
	}
	}
	$FinalArr['ranked_cnt'][$i]['business_suburb']=$lname['business_suburb'];
	$i++;
	}*/
	// prexit($FinalArr);
	/*$j=$i;
	foreach ($res_free as $k=>$free_listing)
	{
	$FinalArr['free_cnt'][$j]['cnt_free']=$free_listing['cnt_free'];
	$FinalArr['free_cnt'][$j]['business_suburb']=$free_listing['business_suburb'];
	$j++;
	}			*/


	/*     $FinalArr['ranked_cnt']=$FinalArr;
	$FinalArr['free_cnt']=$free_listing;



	$reslt['search'] 	= $FinalArr;
	$reslt['paging'] 	= Paging::numberPaging($this->sum_listings_in_locality(), $fr, DEFAULT_PAGING_SIZE);
	return $reslt;
	}*/


	//=================================Earlier code ends====================================

	public function rankResult()
	{
		$sql="SELECT * FROM rank_rate";
		$res=$this->MyDB->query($sql);
		return $res;
	}

	public function editRate1($ID,$rate)
	{
		$SQL = "UPDATE rank_rate SET rate='{$rate}' WHERE rank={$ID}";
		$this->MyDB->query($SQL);
	}

	public function clientManager($fr=0,$noofrecords=DEFAULT_PAGING_SIZE)
	{
		$sql				= "SELECT * FROM `client` ORDER BY `client_id` DESC LIMIT $fr,".DEFAULT_PAGING_SIZE;
		$res				= $this->MyDB->query($sql);
		$sql				= "SELECT COUNT(client_id) as cnt FROM client ";
		$result_count		= $this->MyDB->query($sql);
		$count				= $result_count[0]['cnt'];
		$reslt['search'] 	= $res;
		$reslt['paging'] 	= Paging::numberPaging($count, $fr, DEFAULT_PAGING_SIZE);
		return $reslt;
	}


	public function fetchaffiliates($fr=0,$noofrecords=DEFAULT_PAGING_SIZE)
	{
		$sql				= "select * from affiliate limit $fr,".DEFAULT_PAGING_SIZE;
		$res				= $this->MyDB->query($sql);
		$sql				= "select count(affiliate_id) as cnt from affiliate ";
		$cnt				= $this->MyDB->query($sql);
		$reslt['search'] 	= $res;
		$reslt['paging'] 	= Paging::numberPaging(count($res), $fr, DEFAULT_PAGING_SIZE);
		return $reslt;
	}


	public function affiliateAdd($post)
	{
		$retArray 			= array("result"=>false, "message"=>'');
		$res 				= $this->__affiliateRegisterValidation($post);
		if(!$res['result'])
		{
			return $res;
		}

		$sql				="select * from affiliate where email='".$post['email']."'";
		$resultArray		=$this->MyDB->query($sql);
		if(count($resultArray)>0)
		{
			$retArray 	= array("result"=>false, "message"=>'Username Already Exists!! please try some other name');
			return $retArray;
		}
		else{
			$sql="INSERT INTO `affiliate` (
									`affiliate_id` ,
									`fname` ,
									`lname` ,
									`email` ,
									`password` ,
									`company_name` ,
									`url` ,
									`address1` ,
									`address2` ,
									`city` ,
									`zipcode` ,
									`state` ,
									`country` ,
									`phone` ,
									`fax` ,
									`tax_id` ,
									`adddate` ,
									`timezone` ,
									`secret_text` ,
									`status`
									)values('','{$post['fname']}','{$post['lname']}','{$post['email']}','".md5($post['password'])."','{$post['company']}','{$post['url']}','{$post['address1']}','{$post['address2']}','{$post['city']}','{$post['zipcode']}','{$post['state']}','{$post['country']}','{$post['phone']}','{$post['fax']}','{$post['tax_id']}','NOW()','{$post['timezone']}','{$post['secrettext']}','0')";
			$this->MyDB->query($sql);
			$rand_code = md5(uniqid(rand(), true));
			$sql = "INSERT
							 INTO client_verification (`client_id`, `var_code`)
								VALUES ('".$this->MyDB->getInsertId()."','".$rand_code."')";
			$this->MyDB->execute($sql);
			$mailer = new Mailer();
			$mailer->AddAddress($post['email']);
			// $mailer->IsHTML();
			$mailer->Body = "Hi, {$post['fname']} {$post['lname']}\nTo activate your account click on the link below\n\n".ADMIN_SITE_PATH.                                     "affiliate_activation.php?code=$rand_code";
			$mailer->Subject = "Activation Link";
			if(!$mailer->Send())
			{
				//                    echo $mailer->ErrorInfo;
				$retArray = array("result"=>true, $mailer->ErrorInfo);
			}
			$mailer->ClearAddresses();
			$retArray = array("result"=>true, "message"=>'Add');
		}

		return $retArray;
	}

	public function fetch_affiliateeditdetails($get)
	{
		$ID				=$_GET['ID'];
		$sql				="select * from affiliate where affiliate_id=$ID";
		$res				=$this->MyDB->query($sql);
		return $res;
	}

	public function editaffiliates($post)
	{
		$ID					=$_GET['ID'];
		$sql				="UPDATE affiliate
								SET fname='{$post['fname']}',
								lname='{$post['lname']}',
								email='{$post['email']}',
								company_name='{$post['company']}',
								url='{$post['url']}',
								address1='{$post['address1']}',
								address2='{$post['address2']}',
								city='{$post['city']}',
								zipcode='{$post['zipcode']}',
								state='{$post['state']}',
								country='{$post['country']}',
								phone='{$post['phone']}',
								fax='{$post['fax']}',
								tax_id='{$post['tax_id']}',
								adddate='NOW()',
								timezone='{$post['timezone']}' 
								WHERE affiliate_id=$ID ";
		$res				= $this->MyDB->query($sql);
		$retArray 			= array("result"=>true, "message"=>'Updated');
		return $retArray;
	}

	public function deleteaffiliate($get)
	{
		$ID 				= (!empty($_GET['ID']))?$_GET['ID']:NULL;
		$condition  		= "affiliate_id={$ID}";
		$QUERY				= "SELECT status from affiliate WHERE $condition";
		$res				= $this->MyDB->query($QUERY);
		if($res['0']['status'] =='1')
		{
			$data			= '0';
		}else{
			$data			= '1';
		}
		$sql				= "update affiliate set status='$data' where $condition";
		$this->MyDB->query($sql);
		$retArray 			= array("result"=>true, "message"=>'Status changed Successfully');
		return $retArray;
	}

	private function __affiliateRegisterValidation(&$data)
	{
		$retArray = array("result"=>false, "message"=>'');
		$errors = array();

		if(empty($data['email'])) {
			$errors[] = "email is blank!!";
		}
		if(!preg_match("/^[0-9a-zA-Z_\.-]+\@[0-9a-zA-Z_\.-]+\.[0-9a-zA-Z_\.-]+$/",$data['email'])||empty($data['email']))
		{
			$errors[] = "Invalid email format!!";
		}

		if(empty($data['fname'])) {
			$errors[] = "First Name is blank!!";
		}
		if(empty($data['lname'])) {
			$errors[] = "Last Name is blank!!";
		}

		if(!getSession("affiliate_id"))
		{
			if(empty($data['cpassword'])|| $data['password']!=$data['cpassword']) {
				$errors[] = "Password is blank or password Confirm Password didn't matched!!";
			}
		}

		if(empty($data['url'])) {
			$errors[] = "url is blank!!";
		}
		if(empty($data['address1'])) {
			$errors[] = "Address1 field is blank!!";
		}
		if(empty($data['address2'])) {
			$errors[] = "Address2 field is blank!!";
		}
		if(empty($data['city'])) {
			$errors[] = "City is blank!!";
		}
		if(!getSession("affiliate_id"))
		{
			if(empty($data['secrettext'])) {
				$errors[] = "Secret Text is blank";
			}
		}

		if(count($errors) == 0) {
			$retArray['result'] = true;
		}
		$retArray['message'] = $errors;
		return $retArray;
	}


	public function searchclients_affiliates($get,$fr=0,$noofrecords=DEFAULT_PAGING_SIZE)
	{

		$fetch_count		= "SELECT COUNT(client_id) AS cnt FROM `client` WHERE `client_name` LIKE '%{$get['name']}%'";
		$res_count			= $this->MyDB->query($fetch_count);
		$count				= $res_count[0]['cnt'];

		$fetch_client		= "SELECT * FROM `client` WHERE `client_name` LIKE '%{$get['name']}%' LIMIT $fr,".DEFAULT_PAGING_SIZE;
		$result				= $this->MyDB->query($fetch_client);


		/* if($get['user']=='clients')
		{
		$sql="SELECT * FROM `client` WHERE `client_name` LIKE '%{$get['name']}%' limit $fr,".DEFAULT_PAGING_SIZE;
		$res=$this->MyDB->query($sql);
		$reslt['search'] = $res;
		$reslt['paging'] = Paging::numberPaging(count($res), $fr, DEFAULT_PAGING_SIZE);


		}
		elseif($get['user']=='affiliates')
		{
		$sql="select * from affiliate where fname like '%{$get['name']}%' limit $fr,".DEFAULT_PAGING_SIZE;
		$res=$this->MyDB->query($sql);
		$reslt['search'] = $res;
		$reslt['paging'] = Paging::numberPaging(count($res), $fr, DEFAULT_PAGING_SIZE);
		}
		elseif($get=='clients')
		{
		$sql="select * from client where client_name like '%{$get['name']}%' limit $fr,".DEFAULT_PAGING_SIZE;
		$res=$this->MyDB->query($sql);
		$reslt['search'] = $res;
		$reslt['paging'] = Paging::numberPaging(count($res), $fr, DEFAULT_PAGING_SIZE);
		}
		elseif($get=='affiliates')
		{
		$sql="select * from affiliate where fname like '%{$get['name']}%' limit $fr,".DEFAULT_PAGING_SIZE;
		$res=$this->MyDB->query($sql);
		}*/
		$reslt['search'] = $result;
		$reslt['paging'] = Paging::numberPaging($count, $fr, DEFAULT_PAGING_SIZE);

		return $reslt;
	}
	/************************************************affiliate *********************************************************/



	public function fetcheditdetails()
	{
		$ID=$_GET['ID'];
		$sql="select * from client where client_id=$ID";
		$res=$this->MyDB->query($sql);
		return $res;

	}

	public function editclients($post)
	{
		$ID					= $_GET['ID'];
		$password 			= (!empty($post['password']))?$post['password']:NULL;
		$confpassword 		= (!empty($post['confpassword']))?$post['confpassword']:NULL;
		$retArray = array("result"=>false, "message"=>'');
		$res1 =$this->__clientEditValidation($post);
		//$password=md5($post['password']);
		if(!$res1['result'])
		{
			return $res1;
		}
		
/*		if($post['clientname'] == '')
		{
			$retArray 		= array("result"=>false, "message"=>'Business Name is blank!!');
			return $retArray;
		}
		if($password != '' && $confpassword != $password)
		{
			$retArray 		= array("result"=>false, "message"=>'Password and Confirm Password do not match!!');
			return $retArray;
		}*/		
		$client_details		= " SELECT * FROM client WHERE `client_id`='{$ID}'"; 
		$result				= $this->MyDB->query($client_details);
		$client_email		= $result[0]['email'];
		//prexit($client_email);		
		if($password == '')
		{
		$sql				= " UPDATE `client` SET
											`client_name` ='{$post['clientname']}',
											`postcode` ='{$post['postcode']}',
											`phone` ='{$post['phone']}',
											`contact_name` ='{$post['contactname']}',
											`business_address` ='{$post['address']}',
											`fax` ='{$post['fax']}',
											`mobile` ='{$post['mobile']}',
											`web_address` ='{$post['webaddress']}' 
										WHERE `client_id` = $ID";
				$this->MyDB->query($sql);									
		}else{
		$sql				= " UPDATE `client` SET
											`client_name` ='{$post['clientname']}',
											`postcode` ='{$post['postcode']}',
											`passwd` ='".md5($password)."',
											`phone` ='{$post['phone']}',
											`contact_name` ='{$post['contactname']}',
											`business_address` ='{$post['address']}',
											`fax` ='{$post['fax']}',
											`mobile` ='{$post['mobile']}',
											`web_address` ='{$post['webaddress']}' 
										WHERE `client_id` = $ID";											
			$this->MyDB->query($sql);
			
			$mailer = new Mailer();
			$mailer->AddAddress($client_email);
			$mailer->IsHTML(true);
			$mailer->Body = "Hi, {$post['clientname']}<br>Your Password has been changed by your Account Manager.<br>Your New Password is {$password}.<br><br>SydneyPinkpages.com";
			$mailer->Subject = "Your New Password";
			if(!$mailer->Send())
			{
				echo $mailer->ErrorInfo;
			}
			$mailer->ClearAddresses();	
		}
		//prexit($sql);
		
		$retArray 			= array("result"=>true, "message"=>'Updated successfully');
		return $retArray;
	}

	public function clientadd($post)
	{
		$user_id 			= getSession("userid");
		$currentdate		= date("Y-m-d H:m:s");
		$address 			= (!empty($post['address']))?$post['address']:NULL;
		$fax 				= (!empty($post['fax']))?$post['fax']:NULL;
		$mobile 			= (!empty($post['mobile']))?$post['mobile']:NULL;
		$webaddress 		= (!empty($post['webaddress']))?$post['webaddress']:NULL;
		$contactname 		= (!empty($post['contactname']))?$post['contactname']:NULL;
//		$account_id 		= (!empty($post['account_id']))?$post['account_id']:NULL;

		$retArray = array("result"=>false, "message"=>'');
		$res1 =$this->__clientRegisterValidation($post);
		$password=md5($post['password']);
		if(!$res1['result'])
		{
			return $res1;
		}

		$sql="SELECT * FROM client WHERE `email`='".$post['email']."'";
		$resultArray=$this->MyDB->query($sql);
		if(count($resultArray)>0)
		{
			$retArray = array("result"=>false, "message"=>'Email already exists!! please try some other Email');
			return $retArray;
		}
		else{

			$sql			= "INSERT INTO `client` (
		  							`client_id`,
									`client_name`,
									`email`,
									`passwd`,
									`business_address`,
									`fax`,
									`mobile`,
									`web_address`,
									`contact_name`,
									`user_id_addedby`,
									`postcode`,
									`phone`,
									`add_time`,
									`status`
									) 
							VALUES ( 
									'',
									'{$post['clientname']}',
									'{$post['email']}',
									'{$password}',
									'{$address}',
									'{$fax}',
									'{$mobile}',
									'{$webaddress}',
									'{$contactname}',
									'{$user_id}',
									'{$post['postcode']}',
									'{$post['phone']}',
									'{$currentdate}',
									'I')"; 
			$this->MyDB->query($sql);
			$rand_code = md5(uniqid(rand(), true));
			$client_id = $this->MyDB->getInsertId();
			$sql = "INSERT INTO
							 client_verification 
							 (`client_id`, `var_code`)
					VALUES 
							 (
							 '$client_id',
							 '$rand_code')";
			$this->MyDB->execute($sql);
			//sending verification email
			$mailer = new Mailer();
			$mailer->AddAddress($post['email']);
			$mailer->IsHTML(true);
			$mailer->Body = "Hi, {$post['clientname']}<br>
Your Account Number is {$client_id}.<br>
To activate your account click on the link below<br>
<br>
".ADMIN_SITE_PATH."activate.php?code=$rand_code";
			$mailer->Subject = "Activation Link";
			if(!$mailer->Send())
			{
				echo $mailer->ErrorInfo;
			}
			$mailer->ClearAddresses();
			$retArray = array("result"=>true, "message"=>'Added Successfully');
		}
		return $retArray;
	}

	public function activateclient()
	{
		$code = isset($_GET['code'])?$_GET['code']:'';
		if($code == '') {
			echo "errr";
		}
		else {
			$sql="SELECT
			           client_id 
				  FROM 
				       client_verification 
				  WHERE
				       var_code='$code'";
			$this->MyDB->reset();
			$res = $this->MyDB->query($sql);
			$client_id = @$res[0]['client_id'];
			$sql="update client set status='A' where client_id=$client_id";
			$this->MyDB->query($sql);
		}
		return $res;
	}

	/*   public function activateaffiliate()
	{
	$code = isset($_GET['code'])?$_GET['code']:'';
	if($code == '') {
	echo "errr";
	}
	else {
	$sql="SELECT
	client_id
	FROM
	client_verification
	WHERE
	var_code='$code'";
	$this->MyDB->reset();
	$res = $this->MyDB->query($sql);
	$client_id = @$res[0]['client_id'];
	$sql="update client set status='A' where client_id=$client_id";
	$this->MyDB->query($sql);
	}
	return $res;
	}*/



	private function __clientRegisterValidation(&$data)
	{

		$retArray = array("result"=>false, "message"=>'');
		$errors = array();
		if(empty($data['clientname'])) {
			$errors[] = "clientname is blank!!";
		}
		if(empty($data['password'])) {
			$errors[] = "password is blank!!";
		}

		if(empty($data['confpassword'])|| $data['password']!=$data['confpassword']) {
			$errors[] = "Password is blank or password and confirm password are not same!!";
		}

		if(!preg_match("/^[0-9a-zA-Z_\.-]+\@[0-9a-zA-Z_\.-]+\.[0-9a-zA-Z_\.-]+$/",$data['email'])||empty($data['email']))
		{
			$errors[] = "Invalid email format!!";
		}

		/*if(empty($data['account_id'])) {
			$errors[] = "Account Number is blank!!";
		}

		if(empty($data['secrettext'])) {
			$errors[] = "Secret Text is blank!!";
		}*/


		if(count($errors) == 0) {
			$retArray['result'] = true;
		}
		$retArray['message'] = $errors;
		return $retArray;
	}

	 private function __clientEditValidation(&$data)
	{

	$retArray = array("result"=>false, "message"=>'');
	$errors = array();

	if(empty($data['clientname'])) {
	$errors[] = "Business Name is blank!!";
	}
	if($data['password'] != '')
	{
		if(empty($data['confpassword'])|| $data['password']!=$data['confpassword']) {
		$errors[] = "Password is blank or password and confirm password do not match!!";
		}
	}

	if(count($errors) == 0) {
	$retArray['result'] = true;
	}
	$retArray['message'] = $errors;
	return $retArray;
	}

	public function deleteclients($get)
	{
		$ID 	= (!empty($_GET['ID']))?$_GET['ID']:NULL;
		$condition  ="client_id={$ID}";
		$QUERY		="SELECT status from client WHERE $condition";
		$res=$this->MyDB->query($QUERY);
		if($res['0']['status'] =='A')
		{
			$data='0';
		}else{
			$data='A';
		}
		$sql="update client set status='$data' where $condition";
		$this->MyDB->query($sql);
		$retArray = array("result"=>true, "message"=>'Status changed Successfully');
		return $retArray;
	}
	public function search_inarray($array, $key, $str){

		foreach($array as $val){

			if($val[$key]==$str)return true;
		}
		return false;

	}
	public function fetchAllPermission($get)
	{
		$userID				=$get['localuser_id'];

		$getAllPermission	="SELECT *
								FROM permissions";
		$resultArray		=$this->MyDB->query($getAllPermission);

		$getUserPermission	="SELECT *
								FROM user_permissions
								WHERE localuser_id='{$userID}'";
		$userResultArray		=$this->MyDB->query($getUserPermission);


		foreach($resultArray as $key=>$val)
		{
			$rs = $this->search_inarray($userResultArray, 'permission_id', $val['permission_id']);
			if($rs){
				$resultArray[$key]['check']='1';
			}else{

				$resultArray[$key]['check']='0';
			}
			/*foreach($userResultArray as $val1)
			{
			if($val['permission_id'] == $val1['permission_id'])
			{

			}else{
			$resultArray[$key]['check']='0';
			}
			}*/
		}
		return $resultArray;
	}

	public function setPermission($get,$post)
	{
		$UserID		=$get['localuser_id'];
		$deleteOldPermission	="DELETE FROM user_permissions WHERE localuser_id='{$UserID}'";
		$this->MyDB->query($deleteOldPermission);

		foreach($post['permission'] as $perm)
		{

			$insertNewPermission	="INSERT INTO user_permissions (
											localuser_id,
											permission_id)
											VALUES (
											'{$UserID}',
											'{$perm}')";
			$permissionArray		=$this->MyDB->query($insertNewPermission);
		}
		$retArray = array("result"=>true, "message"=>'Permissions Updated');
		return $retArray;
	}

	public function updateAccess($get,$post)
	{
		$UserID				=$get['localuser_id'];
		$Access				=$post['access'];

		$updateAccess		="UPDATE local_user  SET localuser_access ='{$Access}' WHERE localuser_id = '{$UserID}'";
		$updateArray		=$this->MyDB->query($updateAccess);

		if($Access=='admin'){
			$condition="role_id=1";
		}elseif($Access=='Employee'){
			$condition="role_id=2";
		}elseif($Access=='SAcManager'){
			$condition="role_id=3";
		}


		$fetchDefaultPerm	="SELECT * FROM default_permission WHERE $condition";
		$fetchArray			=$this->MyDB->query($fetchDefaultPerm);

		$deleteOldPermission	="DELETE FROM user_permissions WHERE localuser_id='{$UserID}'";
		$this->MyDB->query($deleteOldPermission);

		foreach($fetchArray as $value)
		{
			$insertNewPermission	="INSERT INTO user_permissions (
											localuser_id,
											permission_id)
											VALUES (
											'{$UserID}',
											{$value['permission_id']})";
			$permissionArray		=$this->MyDB->query($insertNewPermission);
		}

		$retArray = array("result"=>true, "message"=>'Access Changed Successfully');
		return $retArray;
	}

	public function userDetails($get)
	{
		$UserId				=$get['localuser_id'];
		$fetchUserDetails	="SELECT localuser_access FROM local_user WHERE localuser_id={$UserId}";
		$DetailArray		=$this->MyDB->query($fetchUserDetails);
		return $DetailArray;
	}


	public function min_visits()
	{
		$minCount					= '';
		$fetch_site_configuration	= "SELECT * FROM site_configuration WHERE action ='1'";
		$minCountArray				= $this->MyDB->query($fetch_site_configuration);
		$minCount					= $minCountArray['0']['min_count'];

		$fetch_min_visits			= "SELECT * FROM business_preview_count WHERE count <='{$minCount}'";
		$DetailArray				= $this->MyDB->query($fetch_min_visits);

		foreach($DetailArray as $k=>$val)
		{
			$Value						="SELECT business_name FROM local_businesses WHERE expired=0
									AND business_id={$val['business_id']}";
			$businessName				=$this->MyDB->query($Value);

			$DetailArray[$k]['name']	=$businessName['0']['business_name'];
		}
		return $DetailArray;
	}

	public function site_config_manager()
	{
		$fetch_site_config			="SELECT * FROM site_configuration";
		$site_configArray			=$this->MyDB->query($fetch_site_config);
		return $site_configArray;
	}

	public function editConfigValue($ID, $keyword)
	{

		$SQL = "UPDATE
				  site_configuration
			SET
				  min_count='{$keyword}' 
			WHERE 
				  action='{$ID}'";
		$this->MyDB->query($SQL);

	}

	public function countKey()
	{
		$ret 		= 0;
		$SQL		= "SELECT count(key_id) AS cnt FROM business_keyword_name";
		$result 	= $this->MyDB->query($SQL);
		$ret 		= $result[0]['cnt'];
		return $ret;
	}

	public function viewfetchDetails($fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
	{
		$SQL				="SELECT *
							   FROM 
							   		business_keyword_name
							   ORDER BY key_id DESC
							   LIMIT $fr,".DEFAULT_PAGING_SIZE;
		$result=$this->MyDB->query($SQL);
		$res['blogs'] = $result;
		$res['paging'] = Paging::numberPaging($this->countKey(), $fr, DEFAULT_PAGING_SIZE);
		return $res;
	}



	public function countService()
	{
		$ret = 0;
		$SQL="SELECT count(service_id) AS cnt
			  FROM business_service_name";
		$result = $this->MyDB->query($SQL);
		$ret = $result[0]['cnt'];
		return $ret;
	}


	public function viewServiceDetails($fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
	{
		$SQL				="SELECT *
							   FROM 
							   		business_service_name
							   ORDER BY service_id DESC
							   LIMIT $fr,".DEFAULT_PAGING_SIZE;
		$result=$this->MyDB->query($SQL);
		$res['blogs'] = $result;
		$res['paging'] = Paging::numberPaging($this->countService(), $fr, DEFAULT_PAGING_SIZE);
		return $res;
	}
	public function addlist($post)
	{
		$sql="INSERT
				      INTO 
					      business_keyword_name(key_id,keyword_name)
				  		VALUES
				      		('','{$post['keyword']}')";	  

		$this->MyDB->query($sql);
		$rec=array("result"=>true, "message"=>'Keyword Added Successfully');
		return $rec;
	}

	public function addService($post)
	{
		$sql="INSERT
				      INTO 
					      business_service_name(service_id,service_name)
				  		VALUES
				      		('','{$post['service']}')";	  

		$this->MyDB->query($sql);
		$rec=array("result"=>true, "message"=>'Service Added Successfully');
		return $rec;
	}


	public function deleteKey()
	{
		$ID			=$_GET['ID'];
		$SQL		 = "DELETE
						FROM
						business_keyword_name
						WHERE 
						key_id={$ID}";
		$this->MyDB->query($SQL);

		$Array = array("result"=>true, "message"=>'Deleted Successfully');
		return $Array;
	}

	public function fetchBrandDetails($fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
	{
		$SQL				="SELECT *
									FROM 
									business_brand_name
									ORDER BY brand_id DESC
									LIMIT $fr,".DEFAULT_PAGING_SIZE;
		$result=$this->MyDB->query($SQL);
		$res['blogs'] = $result;
		$res['paging'] = Paging::numberPaging($this->countKey(), $fr, DEFAULT_PAGING_SIZE);
		return $res;

	}


	public function deleteBrand()
	{
		$ID			=$_GET['ID'];
		$SQL		 = "DELETE
							FROM
							business_brand_name
							WHERE 
							brand_id={$ID}";
		$this->MyDB->query($SQL);

		$Array = array("result"=>true, "message"=>'Deleted Successfully');
		return $Array;
	}

	public function deleteService()
	{
		$ID			=$_GET['ID'];
		$SQL		 = "DELETE
							FROM
							business_service_name
							WHERE 
							service_id={$ID}";
		$this->MyDB->query($SQL);

		$Array = array("result"=>true, "message"=>'Deleted Successfully');
		return $Array;
	}

	public function addBrand($post)
	{
		$sql="INSERT
				      INTO 
					      business_brand_name(brand_id,brand_name)
				  		VALUES
				      		('','{$post['brand']}')";	  

		$this->MyDB->query($sql);
		$rec=array("result"=>true, "message"=>'Brand Added Successfully');
		return $rec;
	}

	public function viewContactDetails($fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
	{
		$count_query		= "SELECT * FROM contactUs_details";
		$result_count		= $this->MyDB->query($count_query);
		$Count_cont_det		= count($result_count);

		$SQL				="SELECT *
									FROM 
									contactUs_details
									ORDER BY contact_id DESC
									LIMIT $fr,".DEFAULT_PAGING_SIZE;
		$result=$this->MyDB->query($SQL);
		$res['blogs'] = $result;
		$res['paging'] = Paging::numberPaging($Count_cont_det, $fr, DEFAULT_PAGING_SIZE);
		return $res;

	}

	public function deleteContactDetails()
	{
		$ID			=$_GET['ID'];
		$SQL		 = "DELETE
							FROM
							contactUs_details
							WHERE 
							contact_id={$ID}";
		$this->MyDB->query($SQL);

		$Array = array("result"=>true, "message"=>'Deleted Successfully');
		return $Array;
	}


	public function search_within_a_locality_count($post,$fr=0,$noofrecords=DEFAULT_PAGING_SIZE)
	{
		if(isset($post['FDate']) && isset($post['FMonth']) && isset($post['FYear']))
		{
			if(@$post['FDate']!='')
			{
				$FDate	= $post['FDate'];
			}
			else
			{
				$FDate	= '1';
			}
			if(@$post['FMonth']!='')
			{
				$FMonth	= $post['FMonth'];
			}
			else
			{
				$FMonth	= '1';
			}
			$FYear	= $post['FYear'];
			//$FromDate= $FDate."-".$FMonth."-".$FYear;
			$FromDate= $FYear."-".$FMonth."-".$FDate;
		}else{
			$FDate	= '';
			$FMonth	= '';
			$FYear	= '';
			$FromDate= '';
		}

		if(isset($post['ToDate']) && isset($post['ToMonth']) && isset($post['ToYear']))
		{
			if(@$post['ToDate']!='')
			{
				$ToDate	= $post['ToDate'];
			}
			else
			{
				$ToDate	= '31';
			}
			if(@$post['ToMonth']!='')
			{
				$ToMonth	= $post['ToMonth'];
			}
			else
			{
				$ToMonth	= '12';
			}
			$ToYear	= $post['ToYear'];
			//$ToDate  = $ToDate."-".$ToMonth."-".$ToYear;
			$ToDate  = $ToYear."-".$ToMonth."-".$ToDate;
		}else{
			//$ToDate	= date('d-m-y');
			$ToMonth	= '';
			$ToYear	= '';
			$ToDate  = '';
		}


		if((@$post['FMonth']!='' && @$post['FYear']!='') || @$post['FYear']!='')
		{
			$condition ="date_report between '{$FromDate}' and '{$ToDate}'";
		}else{
			$condition ="date_report";
		}

		$sql="SELECT * FROM  locality_count where $condition ORDER BY date_report DESC LIMIT 0,".DEFAULT_PAGING_SIZE."";
		$res=$this->MyDB->query($sql);//prexit($res);
		$sql="select count(date_report) as cnt from locality_count where $condition";
		$result=$this->MyDB->query($sql);
		$ret = $result[0]['cnt'];
		$reslt['search'] = $res;
		$reslt['paging'] = Paging::numberPaging($ret, $fr, DEFAULT_PAGING_SIZE);

		return $reslt;


	}






}
/*END OF ADMINFACADE */
?>