<?php
/**
 *  GoogleMap Class
 *
 *  extends GoogleMapAPI class (Refer to ThirdParty folder)
 * 
 *  @author     Vinod Kumar
 *  @package    Pinkpages
 *
 */
class GoogleMap extends GoogleMapAPI {

    /*map_keys - Holds array to Google Map API keys according to host */
    private $map_keys = array(
    "localhost"                        =>"ABQIAAAAzMPTzA3rmD4ROTo9rWQfwhT2yXp_ZAY8_ufC3CFXhHIE1NvwkxQd8I7j2SP2wfV9RAqQi_6jSRIbgA",
    "pinkpages.com.au"                 =>"ABQIAAAAeXyMnbvf1DZhueaUljtBOxRrYdsMBxWMtFL0a2YqnjQB_pOsoRRtIi492f0dXzB0Qsuq7NFHijxnWA",
    "www.pinkpages.com.au"             =>"ABQIAAAAeXyMnbvf1DZhueaUljtBOxRrYdsMBxWMtFL0a2YqnjQB_pOsoRRtIi492f0dXzB0Qsuq7NFHijxnWA",	
    "sydneypinkpagesonline.com.au"     =>"ABQIAAAAS_dsDzQZ0P_zSybiJny9kBQvhUNbdNK0cfXbDE_WGMkZzhTrUBTh_SIrMsT83lthk1Cfu9flIHe7fw",
	"dev.sydneypinkpagesonline.com.au" =>"ABQIAAAAiz4fq9Mzrzh3LjK5n6ce_hQffXHY9Ef4gkemAV-achfgMZbCCBQGlXNHqKY9opGivC48R-LziJ2Pcg"
    );

    /**
     * __construct
     *
     * @param string $map_id the id for this map
     * @param string $app_id YOUR Yahoo App ID
     */    
    public function __construct($map_id = 'map', $app_id = 'MyMapApp') {
	    //print("servername is " .$_SERVER['SERVER_NAME'].' url is '.$_SERVER['REQUEST_URI']);
		//print(" api key is " . $this->map_keys[$this->getServer()] );
        $this->setAPIKey($this->map_keys[$this->getServer()]);		
        //$this->setAPIKey($this->map_keys['pinkpages.com.au']);
        //$this->setAPIKey($this->map_keys['dev.sydneypinkpagesonline.com.au']);		
        parent::GoogleMapAPI($map_id, $app_id);
    }/* __construct */
	
	private function getServer() {
	  return $_SERVER['SERVER_NAME'];
	}

}/* End GoogleMap */
?>