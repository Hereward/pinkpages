<?php
/**
 *  Mailer Class
 *
 *  Set up configuration of mailer object used for sending emails
 *
 *  Extends 3rdparty phpmailer class (See Util/3rdParty/PHPMailer.class.php
 *
 *  @author     Vinod Kumar
 *  @version    $Revision: 1.0$
 *  @package    Project name
 *
 */
class Mailer extends PHPMailer
{
    /*
    *   From Email
    */
    public $From     = "info@pinkpages.com.au";

    /*
    *   From Name
    */
    public $FromName = "PinkPages";

    /*
    *   Mailer
    */
    public $Mailer = "sendmail";

    /*
    *   Word Wrap Limit
    */
    public $WordWrap = 75;

    /*
    *   Word Wrap Limit
    */
    public $ContentType = "text/html";

    /**
     *  __construct
     *
     *
     */
    public function __construct() {
        $this->__initSettings('smtp');
    }/*END __construct*/

    /**
     *  __initSettings
     *
     *  Load & initializes default mail settings
     *
     */
    private function __initSettings($mailMethod) {

        switch ($mailMethod) {

            case 'smtp': {
                $this->IsSMTP();
                $this->Host = "localhost";
            /*   $this->Username = "info";*/
            /*    $this->Password = "chop6convex+cloud";*/
                $this->SMTPAuth = false;
                $this->Port = 25; //Default 25
              /*  $this->SMTPSecure = "ssl";// Option ssl/tsl */
                break;
            }
            case 'sendmail': {
                $this->IsSendmail();
                break;
            }
            case 'qmail': {
                $this->IsQmail();
                break;
            }
            default: {
                $this->IsMail();
            }
        }
    }/*END __initSettings*/

}/*END Mailer Class*/
?>