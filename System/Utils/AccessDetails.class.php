<?php
class AccessDetails {

  private static $admin = array('gcattley', 'kfong', 'abarry');    
  
    public static function isAdmin($username) {
	  if(getSession("userid")&& getSession("localuser_access")=='admin'&& getSession("localuser_status")!="0") {
        if(in_array($username, array('gcattley', 'kfong', 'abarry'))){
          return true;
	    }
	  }	
        return false;
	}
	
	private static function CheckAccessDetails() {
		
		return $DropDown;
	}
	
	private static function getAccessDetails() {
	
	}
}
?>