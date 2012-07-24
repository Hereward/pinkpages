<?php
/**
 *  MainFacade Class
 *
 *  
 *
 *  @author     Vinod Kumar
 *  @version    $Revision: 1.0$
 *  @package    Project Name
 *
 */
class MainFacade {
    
    protected $myDb;
    protected $request;
    
    /**
     *  __construct
     *
     *  Set up DB & Request class objects
     *
     *  @param  object  db      Database object
     *  @param  object  request Request object
     */
    public function __construct(myDB $myDb, Request $request) {

        $this->myDb = $myDb;
        $this->request = $request;
    }/* END __construct */
    
    /**
     *  __call
     *
     *  this magic method is invoked when called Method not found in Facade Class
     *
     *  @param  String  func    Function name
     *  @param  Array   args    array of arguments
     */
    public function __call($func, $args) {
        
        echo "Called undefined function <b>$func</b>";
    }/* END __call */     
    
}/*END MainFacade*/
?>