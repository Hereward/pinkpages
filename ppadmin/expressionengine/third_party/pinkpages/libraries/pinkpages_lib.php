<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Pinkpages_lib
{
	
	
	/**
	 * constructor
	 * 
	 * @return	void
	 */
	public function __construct()
	{
		$this->EE =& get_instance();
		
		//set a global object
		$this->EE->pinkpages = $this;
	}
	
	
/*
$this->EE->load->helper('form');
		$this->EE->router->set_class('cp');
		$this->EE->load->library('cp');
		$this->EE->router->set_class('ee');
		$this->EE->load->library('javascript');
		$this->EE->load->library('api');
		$this->EE->load->library('form_validation');
		$this->EE->api->instantiate('channel_fields');
		$this->load_channel_standalone();
		
		$this->EE->lang->loadfile('content');
		$this->EE->lang->loadfile('upload');
		
		$this->EE->javascript->output('if (typeof SafeCracker == "undefined" || ! SafeCracker) { var SafeCracker = {markItUpFields:{}};}');
 */

}

/* End of file pinkpages_lib.php */
/* Location: ./ppadmin/expressionengine/third_party/pinkpages/libraries/pinkpages_lib.php */
