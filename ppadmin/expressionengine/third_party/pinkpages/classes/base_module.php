<?php

abstract class Base_Module {
	
	/**
	 * @var	object
	 */
	protected $EE;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->EE =& get_instance();
		$this->EE->load->add_package_path(PATH_THIRD.'/pinkpages');
		$this->EE->load->library('pinkpages_lib');
	}
	
	
     public function test() {
     	$output = "this is a test function of the PP 2 module - YAY IT WORKS!";
     	$lib_test = $this->EE->pinkpages_lib->library_test();
     	
     	$ppo_db = $this->EE->load->database('ppo', TRUE);
     	
     	$query = "SELECT * FROM `local_businesses` WHERE business_id = 10599250";
     	$results = $ppo_db->query($query);
     	
     	$bname = $results->row('business_name');
     	
     	return "$output<br/>$lib_test<br/>DB Query (business_id = 10599250): busines name = [$bname]";
         	
     }
	
}

abstract class Base_Module_UPD {
	
	/**
	 * @var	string
	 */
	public $version = '2.0';
	
	/**
	 * @var	string
	 */
	protected $has_cp_backend = 'y';
	
	/**
	 * @var	string
	 */
	protected $has_publish_fields = 'n';
	
	/**
	 * @var	object
	 */
	protected $EE;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->EE =& get_instance();
	}
	
	/**
	 * Install the module
	 */
	public function install()
	{
		$this->EE->load->dbforge();
		$data = array(
			'module_name' => str_replace('_upd', '', get_class($this)),
			'module_version' => $this->version,
			'has_cp_backend' => $this->has_cp_backend,
			'has_publish_fields' => $this->has_publish_fields,
		);
		
		$this->EE->db->insert('modules', $data);
		
		return TRUE;
	}
	
	/**
	 * Update the module
	 *
	 * @param	string
	 * @return	bool
	 */
	public function update($current = '')
	{
		// no need to update
		if($current == '' || $current == $this->version)
		{
			return FALSE;
		}
		
		return TRUE;
	}
	
	/**
	 * Uninstall the module
	 *
	 * @return	bool
	 */
	public function uninstall()
	{
		$this->EE->db->where('module_name', str_replace('_upd', '', get_class($this)))->delete('modules');
		
		return TRUE;
	}
	
}

abstract class Base_Module_MCP {
	
	/**
	 * @var	object
	 */
	protected $EE;
	
	/**
	 * @var	string
	 */
	protected $base_url = '';
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->EE =& get_instance();
		
		$this->EE->load->library('javascript'); 
		$this->EE->load->library('table');
		
		// set the base control panel url for this module
		$this->base_url = BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=' . strtolower(str_replace('_mcp', '', get_class($this))) . AMP.'method=';
	
		$this->EE->cp->set_right_nav(array(
            'button 1'  => BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'
                .AMP.'module=pinkpages'.AMP.'method=index',
              'button 2'  => BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'
                .AMP.'module=pinkpages'.AMP.'method=index'
            ));     
        
	}
	
    public function index()
	{
		$this->EE->load->library('javascript');
		$this->EE->load->library('table');
		$this->EE->load->helper('form');

		$this->EE->cp->set_variable('cp_page_title', 'Pink Pages');

		$vars['action_url'] = 'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=download'.AMP.'method=edit_downloads';
		$vars['form_hidden'] = NULL;
		$vars['files'] = array();

		$vars['options'] = array(
                'edit'  => 'Edit Selected',
                'delete'    => 'Delete Selected'
                );

        return $this->EE->load->view('index', $vars, TRUE);
	}
	
}