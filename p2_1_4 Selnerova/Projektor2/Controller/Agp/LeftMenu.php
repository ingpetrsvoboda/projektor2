<?php
/**
 * Description of Projektor2_Controller_ZobrazeniRegistraci
 *
 * @author pes2704
 */
class Projektor2_Controller_Agp_LeftMenu implements Projektor2_Controller_ControllerInterface {
    
    protected $sessionStatus;
    protected $request;
    protected $response;
    
    public function __construct(Projektor2_Model_SessionStatus $sessionStatus, Projektor2_Request $request, Projektor2_Response $response) {
        $this->sessionStatus = $sessionStatus;
        $this->request = $request;
        $this->response = $response;
    }
     
     public function getResult() {         
        $htmlResult = '';
        // MENU
        $htmlResult .= "<div class='left'>
            <ul id='menu'>
                <hr>
                <li><a href='index.php?akce=select_beh'>Zpět na výběr běhu</a></li>
                <li><a href='index.php?akce=zobraz_reg'>Zpět na výběr zájemce</a></li>
            </ul>   
            </div>";
        return $htmlResult;
    }
}

?>