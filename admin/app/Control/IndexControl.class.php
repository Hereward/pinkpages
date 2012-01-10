<?php
/**
 *  IndexControl Class
 *
 *  
 *
 *  @author     Vinod Kumar
 *  @version    $Revision: 1.0
 *  @package    Pinkpages.com.au
 *
 */
class IndexControl extends MainControl {
    
    /**
     *  __construct
     *
     *  Set up request object & MainPage object
     *
     *  @param  object  request Request object
     */
    public function __construct(&$request) {

        $this->request = $request;
        $this->mainPage = new AdminPage();
    }/* END __construct */
    
    /**
     *  showhomePageAdmin
     *
     *  Open user home page
     */
    public function showhomePageAdmin() {

        $this->mainPage->getPage('dashboard.tpl');
    }/* END showhomePageAdmin */
    
    /**
     *  pageNotFound
     *
     *  Triggered when undefined function of this class is called
     */    
    public function pageNotFound() {

        $this->mainPage->getPage('page_not_found.tpl');
    }/* END pageNotFound */
    
}/*END IndexControl*/
?>