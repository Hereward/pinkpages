<?php
/**
   * @title   AdminFacade.class.php
    
   * @desc    This is an AdminFacade class. The purpose of this class is to perform the actual actions needed for a function which              was called from AdminControl class. 
*/
class BusinessFacade extends MainFacade {

    public function __construct(MyDB $MyDB){           //Start of The __contructor.purpose is to assign database parmeters to                                                           //a variable acting as an object and using that object to declare
        $this->MyDB = $MyDB;                             //the table name,sequence name and primary column.
        $this->MyDB->table=TBL_CLIENT;
        $this->MyDB->sequenceName=TBL_CLIENT;
        $this->MyDB->primaryCol="client_id";
    }

    /** businessLogin()
	
					* @desc This function will be used for Affiliate login with its validation check.
					* @param post values from Affiliate login form as arguments recieved here.
					* @return mixed Return true if login was successfull or false if failure.
	*/
    public function businessLogin($post)
    {
        $retArray = array("result"=>false, "message"=>'');
        $res = $this->__validateUser($post);
        if($res['result'])
        {
		  $sql="select * from client where email='".$post['email']."' AND passwd='".md5($post['password'])."'";
		  @$res=$this->MyDB->query($sql);
		  if((@$res[0]['status']=='I'))
		  {
		  $retArray = array("result"=>false, "message"=>'You are an Inactive User');
		  return $retArray;
		  
		  }
		  	$condition	="email='".$post['email']."' AND passwd='".md5($post['password'])."'";
            $this->MyDB->setWhere($condition);
            $result = $this->MyDB->getAll();  

            if($result && count($result) == 1)
            {
                setSession("client_access", "Business");
                setSession("client_id", $result[0]['client_id']);
				setSession("status", $result[0]['status']);
                setSession("username", $result[0]['client_name']);
                $retArray['result'] = true;
            }
            else
            {
                $retArray['message'] = "Wrong e-mail or password!!";
            }

        }
        else{
            $retArray['message'] = $res['message'];
        }
        return $retArray;
    }

    /** __validateUser()
	
						 * @desc This function will be used for validation check of admin login form.
						 * @param recieves posted data from user login form as a reference to Affiliatelogin()
						 * @return mixed Return true if validation was successfull or false if failure to Affiliatelogin().
	*/
    private function __validateUser(&$data)
    {
        $retArray = array("result"=>false, "message"=>'');
        $errors = array();

        if(!preg_match("/^[0-9a-zA-Z_\.-]+\@[0-9a-zA-Z_\.-]+\.[0-9a-zA-Z_\.-]+$/",$data['email'])||empty($data['email']))
        {
            $errors[] = "Invalid email format!!";
        }
        if(empty($data['password'])) {
            $errors[] = "Password is blank!!";
        }
        if(count($errors) == 0) {
            $retArray['result'] = true;
        }
        $retArray['message'] = $errors;
        return $retArray;
    }


    /** userLogout()
						 * @desc This function will be used for user logout by destroying session.
						 * @param NULL
						 * @return mixed Return true if logout was successful with a message 
	*/
    public function userLogout()
    {
        unset($_SESSION[NAMESPACE]);
        return $res = array("result"=>true, "message"=>'You have successfully logged out!!');
    }


    /** businessAdd()
	
						 * @desc This function will be used for adding user related informations.
						 * @param posted values from user form, where he fills the data.(Admin in this case.)
						 * @return mixed Return true if addition was successfull or false if failure.
	*/
    public function businessAdd($post)
    {
        $retArray = array("result"=>false, "message"=>'');
        $res1 =$this->__userRegisterValidation($post);
        if(!$res1['result'])
        {
            return $res1;
        }

        $data = array('client_name'=>$post['clientname'],
        'passwd'=>md5($post['password']),
        'email'=>$post['email'],
        'postcode'=>$post['postcode'],
        'phone'=>$post['phone'],
        'add_time'=>'NOW()',
        'secret_text'=>$post['secrettext'],
        'status'=>'I');
        $this->MyDB->setWhere("email='".$post['email']."'");
        $resultArray=$this->MyDB->getAll();
        if(count($resultArray)>0)
        {
            $retArray = array("result"=>false, "message"=>'Email already exists!! please try some other Email');
            return $retArray;
        }
        else{
            $this->MyDB->save($data);
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
            $mailer->Body = "Hi, {$post['clientname']}\nTo activate your account click on the link below\n\n".SITE_PATH.                                     "activate.php?code=$rand_code";
            $mailer->Subject = "Activation Link";
            if(!$mailer->Send())
            {
                echo $mailer->ErrorInfo;
            }
            $mailer->ClearAddresses();
            $retArray = array("result"=>true, "message"=>'');
        }
        return $retArray;
    }


    /** activate()
	
						 * @desc This function will be used for validating the user by validating the details from the database.
						 * @param No parameter accepted.
						 * @return mixed Return true if fetching was successfull or false if failure.
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
            $client_id = @$res[0]['client_id'];
            $this->MyDB->setWhere("client_id='$client_id'");
            $this->MyDB->update(array("status"=>"A"));
        }
        return $res;
    }
	
    /** fetchUserDetails()
	
						 * @desc This function will be used for fetching user related informations.
						 * @param NULL. 
						 * @return records.
	*/
    function fetchUserDetails()
    {
        $this->MyDB->reset();
        $this->MyDB->setWhere("client_id='".getSession("client_id")."'");
        $res = $this->MyDB->getAll();
        return $res;
    }


    /** __userRegisterValidation()
	 
						 * @desc This function will be used for validation check of user data entry form.
						 * @param posted values from form as reference.
						 * @return mixed Return true if validation was successfull or false if failure with error message.
	*/
    private function __userRegisterValidation(&$data)
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

        if(empty($data['postcode'])) {
            $errors[] = "postcode is blank!!";
        }

        if(empty($data['phone'])) {
            $errors[] = "phone is blank!!";
        }
		
		if(empty($data['secrettext'])) {
            $errors[] = "Secret Text is blank!!";
        }

        if(count($errors) == 0) {
            $retArray['result'] = true;
        }
        $retArray['message'] = $errors;
        return $retArray;
    }



    /** editUser()
				 * @desc This function will be used for getting user related informations and to show on the form fields using ID.
				 * @param NULL.
				 * @return records.
	*/
    public function editUser()
    {
        $condition = getSession("client_id");
        $res = $this->MyDB->get($condition);
        return $res;
    }


    /** changeStatus()
	
					 * @desc This function will be used for changing status of user as Active(1) or Inactive(0).
					 * @param NULL
					 * @return value after updation of status in table(local_user)'s ("localuser_status") field.
	*/
    public function changeStatus()
    {
        $ID			=getSession("client_id");
        $condition  ="client_id={$ID}";
        $data 		=array('status'=>'I');
        $this->MyDB->setWhere($condition);
        return $this->MyDB->update($data);
    }


    /** editAdd()
					 * @desc This function will be used for adding updated data after editing into table('local_user').
					 * @param posted data from edit form after editing the existing information. 
					 * @return mixed Return true if updation was successfull or false if failure.
	 */
    public function editAdd($post)
    {
        $ID			=getSession("client_id");
        $condition  =$ID;
        
            $data = array('client_name'=>$post['clientname'],
            'email'=>$post['email'],
            'postcode'=>$post['postcode'],
            'phone'=>$post['phone'],
            );        
        $this->MyDB->setWhere("client_id=$condition") ;
        $this->MyDB->update($data);
        $Array = array("result"=>true, "message"=>'Profile updated successfully');
        return $Array;
    }
	
	
    /** createRandomPassword()
					 * @desc This function will be used for creating the random password.
					 * @param No parameter accepted. 
					 * @return mixed Return true if password creation was successfull or false if failure.
	 */	
	public function createRandomPassword()
	{
		$chars = "abcdefghijkmnopqrstuvwxyz023456789";

		srand((double)microtime()*1000000);

		$i = 0;

		$pass = '' ;

		while ($i <= 7) {

			$num = rand() % 33;

			$tmp = substr($chars, $num, 1);

			$pass = $pass . $tmp;

			$i++;

		}

		return $pass;

	}


    /** lostpassgain()
					 * @desc This function will be used for fetching the lost password.
					 * @param Take the email address. 
					 * @return mixed Return true if password fetching was successfull or false if failure.
	 */	
    public function lostpassgain($post)
    {
	
        $res1 						= $this->__Validation($post);
        if(!$res1['result']){
            return $res1;
        }else
        {
		
			$email					= $post['email'];
			$secrettext				= $post['secrettext'];
			$this->MyDB->setWhere("email='{$post['email']}' AND secret_text='{$secrettext}'");
            $rows					= $this->MyDB->getAll();
		
			if(count($rows)>0)
			{
			$client_name			= $rows['0']['client_name'];
			$email					= $rows['0']['email'];
			$newPassword			= $this->createRandomPassword();
			$data 					= array('passwd'=>md5($newPassword));
            $this->MyDB->setWhere("email='{$email}'") ;
            $this->MyDB->update($data);
			$mailBody				= "Hi ".$client_name.",\nThis is your new password please login using this new password. \n\nYour Email ID is '".$email."' \nYour Password is '".$newPassword."'\nThanks.";
			}else{
			 $retArray 				= array("result"=>false, "message"=>'Your email does not exists in our system.Sorry for inconvinience.');
            return $retArray;
			/*$mailBody	="Your EMail ID '".$email."' does not exists in our system.\nSorry for inconvinience.";*/
			}
			
			
            $mailer 				= new Mailer();
            $mailer->AddAddress($post['email']);
            // $mailer->IsHTML();
            $mailer->Body 			= $mailBody;
            $mailer->Subject 		= "Lost Password Recovery";
            if(!$mailer->Send()) {
                echo $mailer->ErrorInfo;
            }
            $mailer->ClearAddresses();
            $retArray 				= array("result"=>true, "message"=>'');
            return $retArray;
        }
    }


    /** __Validation()
					 * @desc This function will be used for validating the fields of the form.
					 * @param Take the variable which has the name of the components.
					 * @return mixed Return true if validation was successfull or false if failure.
	 */	
    private function __Validation(&$data)
    {
        $retArray 					= array("result"=>false, "message"=>'');
        $errors 					= array();

        if(empty($data['email'])) {
            $errors[] 				= "E-mail field is blank!!";
        }

        if(count($errors) == 0) {
            $retArray['result'] 	= true;
        }
        $retArray['message'] 		= $errors;
        return $retArray;
    }
	
    /** popularPageCount()
					 * @desc This function will be used for adding and updating the popular page count details.
					 * @param Take the variable which has the page id.
					 * @return mixed Return true if addition and updation was successfull or false if failure.
	 */	
	public function popularPageCount($page_id)
	{
		$PAGE_DETAIL_QUERY			= "SELECT * FROM page_details WHERE page_id='$page_id'";
		$PAGE_DETAIL_RESULT			= $this->MyDB->query($PAGE_DETAIL_QUERY);
		$homePageCount				= $PAGE_DETAIL_RESULT['0']['count']+1;
		
		$update_query				= "UPDATE page_details SET `count` = '$homePageCount' WHERE page_id='$page_id'";
		$this->MyDB->query($update_query);
		
		$date						= date('Y-m-d');
		$select_page_stats			= "SELECT page_id,views FROM page_stats WHERE page_id='$page_id'";
		$views						= $this->MyDB->query($select_page_stats);
		if(count($views)==0)
		{
			 $page_views			= @$views[0]['views']+1;
			 $insert_page_stats		= "INSERT
											  INTO `page_stats` (`id`,`page_id`,`datereport`,`views`)
											  VALUES (NULL,'{$page_id}','{$date}','{$page_views}')"; 
			 $this->MyDB->query($insert_page_stats);
		}else{
			$page_views				= $views[0]['views']+1;
			$update_page_stats		= "UPDATE page_stats 
											SET views ='$page_views' 
											WHERE page_id='$page_id' 
												AND datereport ='$date'";
			$this->MyDB->query($update_page_stats);
		}
	}
	
	
    /** changePassword()
					 * @desc This function will be used for changing the password of the user.
					 * @param Take the variable which has the value of the old password.
					 * @return mixed Return true if password updation was successfull or false if failure.
	 */	
	public function changePassword($post)
    {
		$res 					= $this->__changePasswordValidation($post);
		if(!$res['result'])
		{
			return $res;
		}
		$client_id 				= getSession("client_id");
		$password				= md5($post['oldPassword']);
		$newPassword			= $post['newPassword'];
		$confirmPassword		= $post['confirmPassword'];
		$newmd5Password			= md5($post['newPassword']);
		$condition				= "client_id=$client_id AND passwd='$password'";
		$this->MyDB->setWhere($condition) ;
		$resultArray			= $this->MyDB->getAll();
		if(count($resultArray)>0)
		{
			$data 				= array('passwd'=>$newmd5Password);
			$this->MyDB->setWhere("client_id=$client_id") ;
			$this->MyDB->update($data);
			$retArray 			= array("result"=>true, "message"=>'Password changed successfully');
		}else{
			$retArray 			= array("result"=>false, "message"=>'Wrong old password');
		}
		return $retArray;
    }
	
	
    /** __changePasswordValidation()
					 * @desc This function will be used for validating that the old password, newpassword and confirm password is                        filled or not.
					 * @param Take the variable which has the value of the old password, new password and .
					 * @return mixed Return true if password updation was successfull or false if failure.
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
		$errors[] = "Password is blank or password and confirm password are not same!!";
		}
		
		
		
		
		if(count($errors) == 0) {
		$retArray['result'] = true;
		}
		$retArray['message'] = $errors;
		return $retArray;
    }
	
	
	
		

}
/*END OF ADMINFACADE */
?>