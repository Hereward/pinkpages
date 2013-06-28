<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

abstract class Base_Controller {
	
	/**
	 * @var	object
	 */
	protected $EE;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{

		//die('weeeeeee');
		$this->EE =& get_instance();
		$this->EE->load->add_package_path(PATH_THIRD.'/pinkpages');
		$this->EE->load->library('pinkpages_lib');
		//$this->EE->load->model('pinkpages_model');
	}
	
	/*
     public function test() {
     	$output = "this is a test function of the PP 2 module - YAY IT WORKS!";
     	$lib_test = $this->EE->pinkpages_lib->library_test();
     	$mod_test = $this->EE->pinkpages_model->model_test();
     	
     	
     	
     	return "$output<br/>$lib_test<br/>$mod_test";
         	
     }
     */
	
}
