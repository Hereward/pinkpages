<?php
/**
 *  MainControl Class
 *
 *  
 *
 *  @author     Vinod Kumar
 *  @version    $Revision: 1.0$
 *  @package    Project Name
 *
 */
class MainControl {
    
    protected $page;
	protected $request;
    
    /**
     *  __construct
     *
     *  Set up request object & MainPage object
     *
     *  @param  object  request Request object
     */
    public function __construct(Request $request) {

        $this->request = $request;
    }/* END __construct */
    
    /**
     *  __call
     *
     *  this magic method is invoked when called Method not found in Control Class
     *
     *  @param  object  request Request object
     */
    public function __call($func, $args) {
        $this->PageNotFound();
    }/* END __call */
    
    /**
     *  pageNotFound
     *
     *  Triggered when undefined function of this class is called
     */    
    public function pageNotFound() {

        $this->page->getPage('page_not_found.tpl');
    }/* END pageNotFound */
    
}/*END MainControl*/
?>