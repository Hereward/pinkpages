<?php
/**
 *  ClassificationControl Class
 *
 *  
 *
 *  @author     Vinod Kumar
 *  @version    $Revision: 1.0$
 *  @package    Project Name
 *
 */
class ClassificationControl extends MainControl {

	private $classificationFacade;
	
	/**
     *  __construct
     *
     *  Set up request object & MainPage object
     *
     *  @param  object  request Request object
     */
	public function __construct($request) {
	    
		$this->classificationFacade = new ClassificationFacade($GLOBALS['conn']);
		$this->page = new MainPage();
		parent::__construct($request);
	}/* END __construct */

	/**
     *  loadAjax
     *
     *  Loads classifications
     */
	public function loadAjax() {
	    
		$this->classificationFacade->loadAjax($_GET);
		
	}/* END loadAjax */
	
}/* END ClassificationControl */
?>