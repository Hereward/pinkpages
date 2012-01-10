<?php
/**
* @title   AffiliateFacade.class.php

* @desc    This is an AffiliateFacade class. The purpose of this class is to perform the actual actions needed for a function which           was called from AffiliateControl class. 
*/
class AffiliateFacade extends MainFacade {

    public function __construct(MyDB $MyDB){
        $this->MyDB = $MyDB;
        $this->MyDB->table=TBL_AFFILIATE;
        $this->MyDB->sequenceName=TBL_AFFILIATE;
        $this->MyDB->primaryCol="affiliate_id";
    }



    /** affiliateLogin()
	
	* @desc This function will be used for admin login with its validation check.
	* @param post values from Admin login form as arguments recieved here.
	* @return mixed Return true if login was successfull or false if failure.
	*/
    public function affiliateLogin($post)
    {
        $retArray = array("result"=>false, "message"=>'');
        $res = $this->__validateUser($post);
        if($res['result'])
        {
			$condition	="email='".$post['email']."' AND password='".md5($post['password'])."'";
            $this->MyDB->setWhere($condition);
            $result = $this->MyDB->getAll();
			

            if($result && count($result) == 1 && $result['0']['status'] == 1)
            {
                setSession("access", "Affiliate");
                setSession("affiliate_id", $result[0]['affiliate_id']);
				setSession("status", $result[0]['status']);
                setSession("fname", $result[0]['fname']);
                setSession("lname", $result[0]['lname']);
                $retArray['result'] = true;
            }
            else
            {
				if(@$result['0']['status'] == '0')
				{
                $retArray['message'] = "Activate your account from your mail";
				}else{
				$retArray['message'] = "Wrong email OR password!!";
				}
            }

        }
        else{
            $retArray['message'] = $res['message'];
        }
        return $retArray;
    }

    /** __validateUser()
	
	* @desc This function will be used for validation check of admin login form.
	* @param recieves posted data from user login form as a reference to adminLogin()
	* @return mixed Return true if validation was successfull or false if failure to addiliate login().
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


    /** affiliateAdd()
		
		* @desc This function will be used for adding user related informations.
		* @param posted values from user form, where he fills the data.
		* @return mixed Return true if addition was successfull or false if failure.
		*/
    public function affiliateAdd($post)
    {
        $retArray = array("result"=>false, "message"=>'edit');
        $res =$this->__affiliateRegisterValidation($post);
        if(!$res['result'])
        {
            return $res;
        }

        if(!getSession("affiliate_id"))
        {
            $data = array(
            'affiliate_id'=>'',
            'fname'=>$post['fname'],
            'lname'=>$post['lname'],
            'email'=>$post['email'],
            'password'=>md5($post['password']),
            'company_name'=>$post['company'],
            'url'=>$post['url'],
            'address1'=>$post['address1'],
            'address2'=>$post['address2'],
            'city'=>$post['city'],
            'zipcode'=>$post['zipcode'],
            'state'=>$post['state'],
            'country'=>$post['country'],
            'phone'=>$post['phone'],
            'fax'=>$post['fax'],
            'tax_id'=>$post['tax_id'],
            'adddate'=>'',
            'timezone'=>$post['timezone'],
			'secret_text'=>$post['secrettext'],
            'status'=>'0');
            $condition="email='{$post['email']}'";
            $this->MyDB->setWhere($condition);
            $resultArray=$this->MyDB->getAll();
            if(count($resultArray)>0)
            {
                $retArray = array("result"=>false, "message"=>'Username Already Exists!! please try some other name');
                return $retArray;
            }
            else{
                $this->MyDB->save($data);
                $rand_code = md5(uniqid(rand(), true));
                $sql = "INSERT
							 INTO client_verification (`client_id`, `var_code`)
								VALUES ('".$this->MyDB->getInsertId()."','".$rand_code."')";
                $this->MyDB->execute($sql);
                $mailer = new Mailer();
                $mailer->AddAddress($post['email']);
                // $mailer->IsHTML();
                $mailer->Body = "Hi, {$post['fname']} {$post['lname']}\nTo activate your account click on the link below\n\n".SITE_PATH.                                     "affiliate_activation.php?code=$rand_code";
                $mailer->Subject = "Activation Link";
                if(!$mailer->Send())
                {
//                    echo $mailer->ErrorInfo;
					$retArray = array("result"=>true, $mailer->ErrorInfo);
                }
                $mailer->ClearAddresses();
                $retArray = array("result"=>true, "message"=>'Add');
            }
        }else{
            $affiliate_id = getSession("affiliate_id");
            $this->MyDB->setWhere("affiliate_id=$affiliate_id") ;
            $resultArray=$this->MyDB->getAll();
            $data = array(
            'fname'=>$post['fname'],
            'lname'=>$post['lname'],
            'email'=>$post['email'],           
            'company_name'=>$post['company'],
            'url'=>$post['url'],
            'address1'=>$post['address1'],
            'address2'=>$post['address2'],
            'city'=>$post['city'],
            'zipcode'=>$post['zipcode'],
            'state'=>$post['state'],
            'country'=>$post['country'],
            'phone'=>$post['phone'],
            'fax'=>$post['fax'],
            'tax_id'=>$post['tax_id'],
            'adddate'=>'',
            'timezone'=>$post['timezone']
			);
            $this->MyDB->setWhere("affiliate_id=$affiliate_id") ;
            $this->MyDB->update($data);
            $retArray = array("result"=>true, "message"=>'edit');
        }
        return $retArray;
    }


    /** activate()
		
		* @desc This function will be used for adding user related informations.
		* @param posted values from user form, where he fills the data.(Admin in this case.
		* @return mixed Return true if addition was successfull or false if failure.
		*/	
    public function activate()
    {
        $code = isset($_GET['code'])?$_GET['code']:'';
        if($code == '') {
            echo "errr";
        }
        else{
            $sql="SELECT client_id
					FROM client_verification 
						WHERE var_code='$code'";

            $this->MyDB->reset();
            $res = $this->MyDB->query($sql);
            $affiliate_id = $res[0]['client_id'];
            $this->MyDB->setWhere("affiliate_id='$affiliate_id'");
            $this->MyDB->update(array("status"=>"1"));
        }
        return $res;
    }
	
		/**
		* @desc This function will be used for counting the number of list that has to be displayed.
		* @return mixed Return true if count was successfull or false if failure.
		*/
	public function countViewBanner()
    {
		$ret = 0;
		$QUERY="SELECT count(banner_id) as cnt FROM affiliate_banner";
        $result=$this->MyDB->query($QUERY);
		$ret = $result[0]['cnt'];
        return $ret;
    }
	

		/**
		* @desc This function will be used for getting the details of banner. 
		* @return mixed Return true if selection was successfull or false if failure.
		*/			
    public function viewBanner($fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
    {
        $QUERY="SELECT * FROM affiliate_banner WHERE status='1' LIMIT $fr,".DEFAULT_PAGING_SIZE."";
        $result=$this->MyDB->query($QUERY);
		$res['banner']	= $result;
		$res['paging']	= Paging::numberPaging($this->countViewBanner(), $fr, DEFAULT_PAGING_SIZE);
		return $res;
    }
	

		/**
		* @desc This function will be used for getting the details of banner. 
		* @return mixed Return true if selection was successfull or false if failure.
		*/			
    public function show_banner($banner_id,$affiliateid)
    {
		$ip				=$_SERVER['REMOTE_ADDR'];
		$CurrentDate	=date('Y-m-d');
		$SQL	="INSERT INTO banner_stats (
					`banner_stat_id` ,
					`banner_id` ,
					`time` ,
					`click` ,
					`view` ,
					`IP` ,
					`affiliate_id`
					)
					VALUES (
					NULL , '$banner_id', NOW( ) , '0', '1', '$ip', '$affiliateid'
					)";
		$this->MyDB->query($SQL);		
			
        $QUERY="SELECT * FROM affiliate_banner WHERE banner_id='{$banner_id}'";
        
		$result=$this->MyDB->query($QUERY);
		return $result;
    }
	
	
	
		/**
		* @desc This function will be used for inserting the count of the banner when it is viewed by the user. 
		* @return mixed Return true if insertion was successfull or false if failure.
		*/			
    public function view_count_banner($banner_id,$affiliateid)
    {

		$CurrentDate	=date('Y-m-d');
		$CurrentTime	=date('H');	
		$condition		="banner_id={$banner_id} AND day='{$CurrentDate}'";
		$VIEW_QUERY		="SELECT view FROM daily_banner_stats WHERE ".$condition."";
		$view_result	=$this->MyDB->query($VIEW_QUERY);
		$Count			=count($view_result);
		$ViewCounter	=@$view_result[0]['view']+1;
		
		if($Count <= 0)
			{
					$INSERT_VIEW	="INSERT INTO daily_banner_stats (
										`daily_stats_id` ,
										`banner_id` ,
										`day` ,
										`click` ,
										`view`
										)
										VALUES (
										NULL , '$banner_id', '$CurrentDate', '0', '1'
										)";
					$count_result	=$this->MyDB->query($INSERT_VIEW);
			}else{
			
					$UPDATE_VIEW	="UPDATE daily_banner_stats SET `view` = '$ViewCounter' WHERE banner_id ='$banner_id' AND day='$CurrentDate'";
					$count_result	=$this->MyDB->query($UPDATE_VIEW);
				}
				
		return $count_result;
    }
	
		
		/**
		* @desc This function will be used for inserting the count of the banner when it is viewed by the user. 
		* @return mixed Return true if insertion was successfull or false if failure.
		*/			
    public function affiliate_view_count_banner($banner_id,$affiliate_id)
    {

		$CurrentDate	=date('Y-m-d');
		$CurrentTime	=date('H');	
		$condition		="affiliate_id={$affiliate_id} AND day='{$CurrentDate}'";
		$VIEW_QUERY		="SELECT view FROM affiliate_daily_banner_stats WHERE ".$condition."";
		$view_result	=$this->MyDB->query($VIEW_QUERY);
		$Count			=count($view_result);
		$ViewCounter	=@$view_result[0]['view']+1;
		
		if($Count <= 0)
			{
					$INSERT_VIEW	="INSERT INTO affiliate_daily_banner_stats (
										`daily_stats_id` ,
										`affiliate_id` ,
										`day` ,
										`click` ,
										`view`
										)
										VALUES (
										NULL , '$affiliate_id', '$CurrentDate', '0', '1'
										)";
					$count_result	=$this->MyDB->query($INSERT_VIEW);
			}else{
			
					$UPDATE_VIEW	="UPDATE affiliate_daily_banner_stats SET `view` = '$ViewCounter' WHERE affiliate_id ='$affiliate_id' AND day='$CurrentDate'";
					$count_result	=$this->MyDB->query($UPDATE_VIEW);
				}
				
		return $count_result;
    }
	
	
		/**
		* @desc This function will be used for inserting the count of the banner when it is viewed by the user. 
		* @return mixed Return true if insertion was successfull or false if failure.
		*/			
    public function view_count_banner_hourley($banner_id,$affiliateid)
    {

		$CurrentDate	=date('Y-m-d');
		$CurrentHour	=date('H');	
		$condition		="banner_id={$banner_id} AND day='{$CurrentDate}' AND hour={$CurrentHour}";
		$VIEW_QUERY		="SELECT view FROM hourley_banner_stats WHERE ".$condition."";
		$view_result	=$this->MyDB->query($VIEW_QUERY);
		$Count			=count($view_result);
		$ViewCounter	=@$view_result[0]['view']+1;
		
		if($Count <= 0)
			{
					$INSERT_VIEW	="INSERT INTO hourley_banner_stats (
										`hourley_stats_id` ,
										`banner_id` ,
										`day` ,
										`hour` ,
										`click` ,
										`view`
										)
										VALUES (
										NULL , '$banner_id', '$CurrentDate','$CurrentHour', '0', '1'
										)";
					$count_result	=$this->MyDB->query($INSERT_VIEW);
			}else{
			
					$UPDATE_VIEW	="UPDATE hourley_banner_stats SET `view` = '$ViewCounter' WHERE banner_id ='$banner_id' AND day='$CurrentDate' AND  hour='$CurrentHour'";
					$count_result	=$this->MyDB->query($UPDATE_VIEW);
				}
				
		return $count_result;
    }
	
	
		/**
		* @desc This function will be used for inserting the count of the banner when it is viewed by the user. 
		* @return mixed Return true if insertion was successfull or false if failure.
		*/			
    public function affiliate_view_count_banner_hourley($banner_id,$affiliate_id)
    {

		$CurrentDate	=date('Y-m-d');
		$CurrentHour	=date('H');	
		$condition		="affiliate_id={$affiliate_id} AND day='{$CurrentDate}' AND hour={$CurrentHour}";
		$VIEW_QUERY		="SELECT view FROM affiliate_hourley_banner_stats WHERE ".$condition."";
		$view_result	=$this->MyDB->query($VIEW_QUERY);

		$Count			=count($view_result);
		$ViewCounter	=@$view_result[0]['view']+1;
		
		if($Count <= 0)
			{
					 $INSERT_VIEW	="INSERT INTO affiliate_hourley_banner_stats (
										`hourley_stats_id` ,
										`affiliate_id` ,
										`day` ,
										`hour` ,
										`click` ,
										`view`
										)
										VALUES (
										NULL , '$affiliate_id', '$CurrentDate','$CurrentHour', '0', '1'
										)";
					$count_result	=$this->MyDB->query($INSERT_VIEW);
			}else{
			
					$UPDATE_VIEW	="UPDATE affiliate_hourley_banner_stats SET `view` = '$ViewCounter' WHERE affiliate_id ='$affiliate_id' AND day='$CurrentDate' AND  hour='$CurrentHour'";
					$count_result	=$this->MyDB->query($UPDATE_VIEW);
				}
				
		return $count_result;
    }	
	
	
		/**
		* @desc This function will be used for inserting the count of the banner when it is clicked by the user. 
		* @return mixed Return true if insertion was successfull or false if failure.
		*/			
    public function hit_count_banner_hourley($bannerid,$affiliateid)
    {

		$CurrentDate	=date('Y-m-d');
		$CurrentHour	=date('H');
		$banner_id=base64_decode($bannerid);
		$condition		="banner_id={$banner_id} AND day='{$CurrentDate}' AND hour='{$CurrentHour}'";
		$VIEW_QUERY		="SELECT click FROM hourley_banner_stats WHERE ".$condition."";
		$view_result	=$this->MyDB->query($VIEW_QUERY);
		$Count			=count($view_result);
		$ViewCounter	=@$view_result[0]['click']+1;
		
		if($Count <= 0)
			{
					$INSERT_VIEW	="INSERT INTO hourley_banner_stats (
										`hourley_stats_id` ,
										`banner_id` ,
										`day` ,
										`hour` ,
										`click` ,
										`view`
										)
										VALUES (
										NULL , '$banner_id', '$CurrentDate','$CurrentHour', '1', '0'
										)";
					$count_result	=$this->MyDB->query($INSERT_VIEW);
			}else{
			
					$UPDATE_VIEW	="UPDATE hourley_banner_stats SET `click` = '$ViewCounter' WHERE banner_id ='$banner_id' AND day='$CurrentDate' AND  hour='$CurrentHour'";
					$count_result	=$this->MyDB->query($UPDATE_VIEW);
				}
				
		return $count_result;
    }	
	
	/**
		* @desc This function will be used for inserting the count of the banner when it is clicked by the user. 
		* @return mixed Return true if insertion was successfull or false if failure.
		*/			
    public function affiliate_hit_count_banner_hourley($bannerid,$affiliate_id)
    {

		$CurrentDate	=date('Y-m-d');
		$CurrentHour	=date('H');
		$banner_id=base64_decode($bannerid);
		$condition		="affiliate_id={$affiliate_id} AND day='{$CurrentDate}' AND hour='{$CurrentHour}'";
		$VIEW_QUERY		="SELECT click FROM affiliate_hourley_banner_stats WHERE ".$condition."";
		$view_result	=$this->MyDB->query($VIEW_QUERY);
		$Count			=count($view_result);
		$ViewCounter	=@$view_result[0]['click']+1;
		
		if($Count <= 0)
			{
					$INSERT_VIEW	="INSERT INTO affiliate_hourley_banner_stats (
										`hourley_stats_id` ,
										`affiliate_id` ,
										`day` ,
										`hour` ,
										`click` ,
										`view`
										)
										VALUES (
										NULL , '$affiliate_id', '$CurrentDate','$CurrentHour', '1', '0'
										)";
					$count_result	=$this->MyDB->query($INSERT_VIEW);
			}else{
			
					$UPDATE_VIEW	="UPDATE affiliate_hourley_banner_stats SET `click` = '$ViewCounter' WHERE affiliate_id ='$affiliate_id' AND day='$CurrentDate' AND  hour='$CurrentHour'";
					$count_result	=$this->MyDB->query($UPDATE_VIEW);
				}
				
		return $count_result;
    }	
	
		
		/**
		* @desc This function will be used for inserting the count of the banner when it is clicked by the user 
		* @return mixed Return true if insertion was successfull or false if failure.
		*/			
    public function hit_count_banner($bannerid,$affiliateid)
    {
		$banner_id=base64_decode($bannerid);
		$CurrentDate	=date('Y-m-d');		
		$condition		="banner_id={$banner_id} AND day='{$CurrentDate}'";
		$CLICK_QUERY		="SELECT click FROM daily_banner_stats WHERE ".$condition."";
		$click_result	=$this->MyDB->query($CLICK_QUERY);
		$Count			=count($click_result);
		$clickCounter	= @$click_result[0]['click']+1;
		
		if($Count <= 0)
			{
					$INSERT_CLICK	="INSERT INTO daily_banner_stats (
										`daily_stats_id` ,
										`banner_id` ,
										`day` ,
										`click` ,
										`view`
										)
										VALUES (
										NULL , '$banner_id', '$CurrentDate', '1', '0'
										)";
					$count_result	=$this->MyDB->query($INSERT_CLICK);
			}else{
			
					$UPDATE_CLICK	="UPDATE daily_banner_stats SET `click` = '$clickCounter' WHERE banner_id ='$banner_id' AND day='$CurrentDate'";
					$count_result	=$this->MyDB->query($UPDATE_CLICK);
				}
				
		return $count_result;
    }
	
		
		/**
		* @desc This function will be used for inserting the count of the banner when it is clicked by the user 
		* @return mixed Return true if insertion was successfull or false if failure.
		*/			
    public function affiliate_hit_count_banner($bannerid,$affiliate_id)
    {
		$banner_id=base64_decode($bannerid);
		$CurrentDate	=date('Y-m-d');		
		$condition		="affiliate_id={$affiliate_id} AND day='{$CurrentDate}'";
		$CLICK_QUERY		="SELECT click FROM affiliate_daily_banner_stats WHERE ".$condition."";
		$click_result	=$this->MyDB->query($CLICK_QUERY);
		$Count			=count($click_result);
		$clickCounter	= @$click_result[0]['click']+1;
		
		if($Count <= 0)
			{
					$INSERT_CLICK	="INSERT INTO affiliate_daily_banner_stats (
										`daily_stats_id` ,
										`affiliate_id` ,
										`day` ,
										`click` ,
										`view`
										)
										VALUES (
										NULL , '$affiliate_id', '$CurrentDate', '1', '0'
										)";
					$count_result	=$this->MyDB->query($INSERT_CLICK);
			}else{
			
					$UPDATE_CLICK	="UPDATE affiliate_daily_banner_stats SET `click` = '$clickCounter' WHERE affiliate_id ='$affiliate_id' AND day='$CurrentDate'";
					$count_result	=$this->MyDB->query($UPDATE_CLICK);
				}
				
		return $count_result;
    }	
	
	
	
	
		/**
		* @desc This function will be used for getting the details of banner. 
		* @return mixed Return true if selection was successfull or false if failure.
		*/			
    public function hit_count($banner_id,$affiliateid)
    {
		$ip=$_SERVER['REMOTE_ADDR'];
		$decBannerId=base64_decode($banner_id);
		$SQL	="INSERT INTO banner_stats (
					`banner_stat_id` ,
					`banner_id` ,
					`time` ,
					`click` ,
					`view` ,
					`IP` ,
					`affiliate_id`
					)
					VALUES (
					NULL , '$decBannerId', NOW( ) , '1', '0', '$ip', '$affiliateid'
					)";
		$this->MyDB->query($SQL);
		
		$QUERY="SELECT * FROM affiliate_banner WHERE banner_id='{$banner_id}'";
		$result=$this->MyDB->query($QUERY);
		return $result;
    }		

    /** __affiliateRegisterValidation()
		
		* @desc This function will be used for validation check of user data entry form.
		* @param posted values from form as reference.
		* @return mixed Return true if validation was successfull or false if failure with error message.
		*/
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

    /** fetchUserDetails()
		
		* @desc This function will be used for fetching user related informations.
		* @param NULL. 
		* @return records.
		*/

    function fetchAffiliateDetails()
    {
        $this->MyDB->reset();
        $this->MyDB->setWhere("affiliate_id='".getSession("affiliate_id")."'");
        $res = $this->MyDB->getAll();
        return $res;
    }

    /** editAffiliate()
		* @desc This function will be used for getting user related informations and to show on the form fields using ID.
		* @param NULL.
		* @return records.
		*/

    public function editAffiliate()
    {
        $condition = getSession("affiliate_id");
        $res = $this->MyDB->get($condition);
        return $res;
    }

    /** userLogout()
						 * @desc This function will be used for user logout by destroying session.
						 * @param NULL
						 * @return mixed Return true if logout was successful with a message 
					 */

    public function affiliateLogout()
    {
        unset($_SESSION[NAMESPACE]);
        return $res = array("result"=>true, "message"=>'You have been successfully logged out!!');
    }
	
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
	
	
	public function changePassword($post)
    {


		$res =$this->__changePasswordValidation($post);
		if(!$res['result'])
		{
		return $res;
		}
		
		$affiliate_id = getSession("affiliate_id");
		$password		=md5($post['oldPassword']);
		$newPassword	=$post['newPassword'];
		$confirmPassword=$post['confirmPassword'];
		$newmd5Password	=md5($post['newPassword']);
		$condition	="affiliate_id=$affiliate_id AND password='$password'";
		$this->MyDB->setWhere($condition) ;
		$resultArray=$this->MyDB->getAll();
		if(count($resultArray)>0)
		{
		$data = array(
		'password'=>$newmd5Password
		);
		$this->MyDB->setWhere("affiliate_id=$affiliate_id") ;
		$this->MyDB->update($data);
		$retArray = array("result"=>true, "message"=>'Password Changed Successfully');
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
			 $retArray = array("result"=>false, "message"=>'Your E-mail ID does not exists in our system.Sorry for inconvinience. ');
            return $retArray;
			//$mailBody	="Your EMail ID '".$email."' does not exists in our system.\nSorry for inconvinience.";
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
	
    private function __Validation(&$data)
    {
        $retArray = array("result"=>false, "message"=>'');
        $errors = array();
        if(empty($data['email'])) {
            $errors[] = "email is blank!!";
        }
        if(count($errors) == 0) {
            $retArray['result'] = true;
        }
        $retArray['message'] = $errors;
        return $retArray;
    }
	
		public function popularPageCount($page_id)
		{
		$PAGE_DETAIL_QUERY	="SELECT * FROM page_details WHERE page_id='$page_id'";
		$PAGE_DETAIL_RESULT	=$this->MyDB->query($PAGE_DETAIL_QUERY);
		
		$homePageCount		=$PAGE_DETAIL_RESULT['0']['count']+1;
		
		$update_query	="UPDATE page_details SET `count` = '$homePageCount' WHERE page_id='$page_id'";
		$this->MyDB->query($update_query);
		
		$date=date('Y-m-d');
		$select_page_stats="SELECT page_id,views FROM page_stats WHERE page_id='$page_id'";
		$views=$this->MyDB->query($select_page_stats);
		if(count($views)==0)
		{
		 $page_views=@$views[0]['views']+1;
		 $insert_page_stats= "INSERT
							  INTO `page_stats` (`id`,`page_id`,`datereport`,`views`)
							  VALUES (NULL,'{$page_id}','{$date}','{$page_views}')"; 
		// prexit($insert_page_stats);					  
		 $this->MyDB->query($insert_page_stats);
		}
		else
		{
		$page_views=$views[0]['views']+1;
		$update_page_stats= "UPDATE page_stats SET views ='$page_views' WHERE page_id='$page_id' AND datereport ='$date'";
		//prexit($update_page_stats);
		$this->MyDB->query($update_page_stats);
		}
		
		}
		


		/**
		* @desc This function will be used for counting the number of list that has to be displayed.
		* @return mixed Return true if count was successfull or false if failure.
		*/
	public function countviewReport()
    {
		$ret = 0;
		$affiliate_id	= getSession("affiliate_id");
		$QUERY="SELECT count(daily_stats_id) as cnt FROM affiliate_daily_banner_stats WHERE affiliate_id='{$affiliate_id}'";
        $result=$this->MyDB->query($QUERY);
		$ret = $result[0]['cnt'];
        return $ret;
    }
	

		/**
		* @desc This function will be used for getting the details of banner. 
		* @return mixed Return true if selection was successfull or false if failure.
		*/			
    public function viewReport($fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
    {
		$affiliate_id	= getSession("affiliate_id");
       	$QUERY="SELECT * FROM affiliate_daily_banner_stats WHERE affiliate_id='{$affiliate_id}' LIMIT $fr,".DEFAULT_PAGING_SIZE."";
        $result=$this->MyDB->query($QUERY);
		$res['banner']	= $result;
		$res['paging']	= Paging::numberPaging($this->countviewReport(), $fr, DEFAULT_PAGING_SIZE);
		return $res;
    }
	
		/**
		* @desc This function will be used for getting the details of banner. 
		* @return mixed Return true if selection was successfull or false if failure.
		*/			
    public function linkDate($date)
    {
		$day		=$date['Date'];
		$affiliate_id	= getSession("affiliate_id");
        $QUERY="SELECT * FROM affiliate_hourley_banner_stats WHERE day='{$day}' AND affiliate_id='{$affiliate_id}'";
        $result=$this->MyDB->query($QUERY);
		return $result;
    }					



}
/*END OF AffiliateFacade */

?>