<?php
class TeamManagerFacade extends MainFacade {

    public function __construct(MyDB $MyDB) {

        $this->MyDB = $MyDB;

        $this->MyDB->table=TBL_LOCAL_USER;
        $this->MyDB->sequenceName=TBL_LOCAL_USER;
		 $this->MyDB->primaryCol="localuser_id";
    }/* END __construct */

    /**
	
     *  adminLogin
    */
	/* function loginLevel(){
       	$this->MyDB->reset();      
		$this->MyDB->table="login_table";
	   	$this->MyDB->setSelect('level');
		$retLevel = $this->MyDB->getAll();
		return $retLevel;
    }
	
	 function FetchUserID($userlevel){
       	$this->MyDB->table="login_table";
	    $this->MyDB->reset();        
		$this->MyDB->setWhere('level='."{$userlevel['level']}");
        $retArray = $this->MyDB->getAll();
	    return $retArray;
    }*/
	
	 function FetchUserDetails(){
		$this->MyDB->reset();    
		$this->MyDB->setJoin('login_table',  $this->MyDB->table.'.managerid=login_table.userid');
		$res = $this->MyDB->getAll();
		return $res;
	}
	
    
//*****************************************************************************************************************************

 public function userAdd($post) {

 echo 'aaaaaaaaaaaaaa';
        //          user registration validation
		
        $retArray = $this->__userRegisterValidation($post);
         
      
		
		 $data = array('localuser_firstname'=>$post['firstname'],'localuser_surname'=>$post['surname'],'localuser_username'=>$post['username'],'localuser_password'=>$post['password'],'localuser_email'=>$post['email'],'localuser_address'=>$post['address'],'localuser_phone'=>$post['phone'],'localuser_mobile'=>$post['mobile_number']);
		       //prexit($data);
               $this->MyDB->save($data); 
			   $retArray = array("result"=>true, "message"=>'');
			   return $retArray;
			   
               // myPrint($fooBarId);

        /*$this->userService->username     = $post['firstname'];
        $this->userService->password     = $post['password'];
        $this->userService->confPassword = $post['Confpassword'];
        $this->userService->firstName    = $post['firstName'];
        $this->userService->lastName     = $post['lastName'];*/

        //          Check user
        //$checkUser  = $this->userService->checkUser();

        /*if($checkUser <= 0){

            $retArray = $this->userService->userAdd();
            return $retArray; */

        /*}else{
            $retArray = array("result"=>false, "message"=>'');
            $retArray['message'] = "Username already exits!!";
            return $retArray;
        }*/

    }/* END userAdd */


    /**
     *  __userRegisterValidation
     *
     *  Perform User Registration Validation
     * 
     * @param   array   post        User data
     * @return  array   retArray    array of bool result & message
     * 
     */
    private function __userRegisterValidation(&$data) {
        
        $retArray = array("result"=>true, "message"=>'');
        /*$errors = array();
        if(empty($data['firstname'])) {
            $errors[] = "Username is blank!!";
        }
        if(empty($data['password'])) {
            $errors[] = "Password is blank!!";
        }
        if($data['password'] != $data['Confpassword']) {
            $errors[] = "Password and confirm password not matched!!";
        }
        if(empty($data['firstName'])) {
            $errors[] = "First Name is blank!!";
        }
        if(empty($data['lastName'])) {
            $errors[] = "Last Name is blank!!";
        }

        if(count($errors) == 0) {
            $retArray['result'] = true;
        }
        $retArray['message'] = $errors;*/
        return $retArray;
        
    }/* END __userRegisterValidation */ 
    
    /**
     *  __userRegisterValidation
     *
     *  Perform User Registration Validation
     * 
     * @param   array   post        User data
     * @return  array   retArray    array of bool result & message
     * 
     */
    private function search(&$data) {
        
        $retArray = array("result"=>true, "message"=>'');
        /*$errors = array();
        if(empty($data['firstname'])) {
            $errors[] = "Username is blank!!";
        }
        if(empty($data['password'])) {
            $errors[] = "Password is blank!!";
        }
        if($data['password'] != $data['Confpassword']) {
            $errors[] = "Password and confirm password not matched!!";
        }
        if(empty($data['firstName'])) {
            $errors[] = "First Name is blank!!";
        }
        if(empty($data['lastName'])) {
            $errors[] = "Last Name is blank!!";
        }

        if(count($errors) == 0) {
            $retArray['result'] = true;
        }
        $retArray['message'] = $errors;*/
        return $retArray;
        
    }/* END __userRegisterValidation */
	
//**************************************************************************************************************************	
	
	
		
}
?>