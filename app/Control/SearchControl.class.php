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
class SearchControl extends MainControl {

	private $searchFacade;
	
	/**
     *  __construct
     *
     *  Set up request object & MainPage object
     *
     *  @param  object  request Request object
     */
	public function __construct($request) {
	    
		$this->searchFacade = new SearchFacade($GLOBALS['conn']);
		$this->page = new MainPage();
		parent::__construct($request);
	}/* END __construct */

	/**
     *  loadAjax
     *
     *  Loads classifications
     */
	public function loadAjax() {
	    
		$this->searchFacade->loadAjax($_GET);
		
	}/* END loadAjax */
	
}/* END ClassificationControl */
?>