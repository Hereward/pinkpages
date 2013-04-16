
<?php
	$this->table->set_template($cp_table_template);
    $this->table->set_heading(array('colspan'=>1, 'data'=>lang('pinkpages_module_name')));
    $this->table->add_row('<a href="'.BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=pinkpages'.AMP.'method=index'.'">Option 1</a>'); 
	$this->table->add_row('<a href="'.BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=pinkpages'.AMP.'method=index'.'">Option 2</a>'); 
		
	echo $this->table->generate();
?>



