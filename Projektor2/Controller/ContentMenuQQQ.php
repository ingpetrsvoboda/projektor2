<?php
/**
 * Description of Projektor2_Controller_ZobrazeniRegistraci
 *
 * @author pes2704
 */
class Projektor2_Controller_ContentMenu implements Projektor2_Controller_ControllerInterface {
    
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
        $htmlResult .= '<div ID="zaznamy">';
        $htmlResult .= '<table>';
        
        $zajemceRegistrace = Projektor2_Model_ZajemceRegistraceMapper::findById($this->sessionStatus->zajemce->id);
        $params = array('zajemceRegistrace' => $zajemceRegistrace);
        $tlacitkaController = new Projektor2_Controller_Element_MenuFormulare($this->sessionStatus, $this->request, $this->response, $params);
        $htmlResult .= $tlacitkaController->getResult();        
        
        $htmlResult .= '</table>';
        $htmlResult .= '</div>';
        return $htmlResult;
    }
}

?>