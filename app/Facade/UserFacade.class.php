<?php
class UserFacade extends MainFacade {

    /**
     *  __construct
     *
     *  Instantiate MyDb object
     */
    public function __construct(MyDB $MyDB) {

        $this->MyDB = $MyDB;
        $this->MyDB->table=TBL_USER;
		$this->MyDB->sequenceName=TBL_USER;
		$this->MyDB->primaryCol="userid";
    }/* END __construct */

    /**
     *  userLogin
     *
     *  Perform User Login
     * 
     * @param   array   post        User data
     * @return  array   retArray    array of bool result & message
     * 
     */
    public function userLogin($post) {

        $retArray = array("result"=>false, "message"=>'');

        //put validations for empty fields
        $res = $this->__validateUser($post);

        if($res['result']) {
            
            $this->MyDB->addWhere("Username='{$post['username']}' AND Passwd='".md5($post['password'])."'");
            $result = $this->MyDB->getAll();
            if(count($result) == 1) {
                
                //setting user information into session
                setSession('username', $result[0]['username']);
                setSession('userid', $result[0]['userid']);
                
                $retArray['result'] = true;
            }
            else {
                $retArray['message'] = "Wrong EmailID OR password!!";
            }
        }
        else {
            $retArray['message'] = $res['message'];
        }
		
        return $retArray;

    }/* END userLogin */


    /**
     *  __validateUser
     *
     *  Perform User Validation
     * 
     * @param   array   data        User data
     * @return  array   retArray    array of bool result & message
     * 
     */
    private function __validateUser(&$data) {

        $retArray = array("result"=>false, "message"=>'');
        $errors = array();
        if(empty($data['username'])) {
            $errors[] = "Username is blank!!";
        }
        if(empty($data['password'])) {
            $errors[] = "Password is blank!!";
        }
        if(count($errors) == 0) {
            $retArray['result'] = true;
        }
        $retArray['message'] = $errors;
        return $retArray;
        
    } /* END __validateUser */


    /**
     *  userLogout
     *
     *  Perform Logout User
     * 
     * @return  array   retArray    array of bool result & message
     * 
     */
    public function userLogout() {

        session_destroy();
        return $res = array("result"=>true, "message"=>'You have been successfully logged out!!');
    } /* END userLogout */


    /**
     *  userAdd
     *
     *  Perform User Registration
     * 
     * @param   array   post        User data
     * @return  array   retArray    array of bool result & message
     * 
     */
    public function userAdd($post) {

        //          user registration validation
        $retArray = $this->_userRegisterValidation($post);

        if(!$retArray['result']){
            return $retArray;
        }

        $this->userService->username     = $post['username'];
        $this->userService->password     = $post['password'];
        $this->userService->confPassword = $post['Confpassword'];
        $this->userService->firstName    = $post['firstName'];
        $this->userService->lastName     = $post['lastName'];

        //          Check user
        $checkUser  = $this->userService->checkUser();

        if($checkUser <= 0){

            $retArray = $this->userService->userAdd();
            return $retArray;

        }else{
            $retArray = array("result"=>false, "message"=>'');
            $retArray['message'] = "Username already exits!!";
            return $retArray;
        }

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

        $retArray = array("result"=>false, "message"=>'');
        $errors = array();
        if(empty($data['username'])) {
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
        $retArray['message'] = $errors;
        return $retArray;
        
    }/* END __userRegisterValidation */


    /**
     *  userFetch
     *
     *  Fetach User data
     * 
     * @param   array   post        User data
     * @return  array   retArray    array of user data
     * 
     */
    function userFetch(){

        $this->MyDB->reset();
        $this->MyDB->setSelect("FirstName", "LastName");
        $retArray = $this->MyDB->getAll();
//        $this->userService->setCols(array("FirstName", "LastName"));
//        $retArray = $this->userService->userFetch();
        return $retArray;
    }/* END userFetch */


    /**
     *  userUpdate
     *
     *  Perform User Profile Updation
     * 
     * @param   array   post        User data
     * @return  array   retArray    array of bool result & message
     * 
     */
    public function userUpdate($post) {

        //          user edit profile validation
        $retArray = $this->_userProfileValidation($post);

        if(!$retArray['result']){
            return $retArray;
        }

        $this->userService->firstName    = $post['firstName'];
        $this->userService->lastName     = $post['lastName'];

        $updateId =  $this->userService->userUpdate();

        if($updateId){

            $retArray = array("result"=>true, "message"=>'');
            $retArray['message'] = "User profile updated!!";
            return $retArray;

        }else{

            $retArray = array("result"=>false, "message"=>'');
            $retArray['message'] = "User profile not updated!!";
            return $retArray;
        }

    }/* END userUpdate */

    /**
     *  _userProfileValidation
     *
     *  Perform User Profile Update Validation
     * 
     * @param   array   data        User data
     * @return  array   retArray    array of bool result & message
     * 
     */
    protected function _userProfileValidation(&$data) {

        $retArray = array("result"=>false, "message"=>'');
        $errors = array();

        if(empty($data['firstName'])) {
            $errors[] = "First Name is blank!!";
        }
        if(empty($data['lastName'])) {
            $errors[] = "Last Name is blank!!";
        }

        if(count($errors) == 0) {
            $retArray['result'] = true;
        }
        $retArray['message'] = $errors;
        return $retArray;

    }/* END _userProfileValidation */


    /**
     *  changePassword
     *
     *  Change User Password
     * 
     * @param   array   post        User data
     * @return  array   retArray    array of bool result & message
     * 
     */
    public function changePassword($post) {

        $this->userService->OldPassword    = $post['OldPassword'];
        $this->userService->password       = $post['password'];

        $oldPass = $this->userService->fetchOldPassword();

        //          user edit profile validation
        $retArray = $this->_userPasswordValidation($post);

        if(!$retArray['result']){
            return $retArray;
        }

        if($oldPass > 0){

            $updateId =  $this->userService->userPassword();

            if($updateId){

                $retArray = array("result"=>true, "message"=>'');
                $retArray['message'] = "Password has been changed!!";
                return $retArray;
            }else{

                $retArray = array("result"=>false, "message"=>'');
                $retArray['message'] = "Password has not been changed!!";
                return $retArray;
            }
        }else{

            $retArray = array("result"=>false, "message"=>'');
            $retArray['message'] = "Old Password does not matched!!";
            return $retArray;
        }
    }/* END changePassword */


   /**
     *  _userPasswordValidation
     *
     *  Perform User Change Password Validation
     * 
     * @param   array   data        User data
     * @return  array   retArray    array of bool result & message
     * 
     */
    protected function _userPasswordValidation(&$data) {

        $retArray = array("result"=>false, "message"=>'');
        $errors = array();

        if(empty($data['OldPassword'])) {
            $errors[] = "Old Password is blank!!";
        }
        if(empty($data['password'])) {
            $errors[] = "New Password is blank!!";
        }
        if($data['password'] != $data['Confpassword']) {
            $errors[] = "Password and confirm password not matched!!";
        }
        if(count($errors) == 0) {
            $retArray['result'] = true;
        }
        $retArray['message'] = $errors;
        return $retArray;
    }/* END _userPasswordValidation */
}
?>