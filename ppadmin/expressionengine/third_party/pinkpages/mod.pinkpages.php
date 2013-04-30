<?php

require_once dirname(__FILE__).'/controllers/base_controller.php';
require_once dirname(__FILE__).'/models/base_model.php';

class Pinkpages {
	
	public function load($class='',$args='',$action='index') {
		require_once dirname(__FILE__)."/controllers/$class.php";
    	$obj = new $class();
    	return $obj->$action($args);
	}
	
     public function keyword_search($args='') {
    	 return $this->load(__FUNCTION__.'_controller',$args);
     }
	
    public function test($args='') {
    	 return $this->load(__FUNCTION__.'_controller',$args);
     }
     
     
     public function test_2($args='') {
    	 return $this->load(__FUNCTION__.'_controller',$args);
     }
     
	
}

/*
class test_controller extends Base_Controller {
	public function __construct($args) {
		//die('boo');
		parent::__construct($args);
	}
	
    public function execute() {
    	
    	$this->EE->load->model('pinkpages_model');
     	$output = "A. This is a test function of the PP 2 module - YAY IT WORKS!";
     	$lib_test = $this->EE->pinkpages_lib->library_test();
     	$mod_test = $this->EE->pinkpages_model->model_test();
     	
     	
     	
     	return "$output<br/>$lib_test<br/>$mod_test";
         	
     }
	
}
*/