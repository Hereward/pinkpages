<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class test_2_controller extends Base_Controller {

	protected $EE;

	public function __construct($args='') {
		//die('boo');
		parent::__construct($args);
	}

	public function index() {
		 
		$this->EE->load->model('pinkpages_model');
		$output = "This is  test function 2 of the PP 2 module!";
		//$lib_test = $this->EE->pinkpages_lib->library_test();
		$mod_test = $this->EE->pinkpages_model->model_test_2();
		$my_var = $this->EE->pinkpages_model->my_var;
		$orig = $this->EE->pinkpages_model->orig;

		return "$output<br/>[$mod_test]<br/>my_var = [$my_var]<br/>orig = [$orig]<br/><br/>";

	}

}
