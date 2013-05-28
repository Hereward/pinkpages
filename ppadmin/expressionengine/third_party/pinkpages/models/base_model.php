<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// Base Model
//extends CI_Model

class Base_model extends CI_Model {

	protected $EE;

	public function __construct()
	{
		$this->EE =& get_instance();
        $this->ppo_db = $this->EE->load->database('ppo', TRUE);
		//set a global object
		//$this->EE->pinkpages = $this;
	}

	
	public function handle_input($input) {

		if(empty($input)) return "";
		//$value = ereg_replace("\[\]$","",$input);
		//$value = preg_replace("\[\]$","",$input);
		$value = preg_replace("/&#124;/", "|", $input);
		$value = stripslashes( html_entity_decode( $value ) );
		return trim($value);
	}
	

}
// End Class
/* End of file base_model.php */
/* Location: ./system/expressionengine/third_party/pinkpages/models/base_model */
