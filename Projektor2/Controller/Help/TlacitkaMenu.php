<?php
/**
 * Description of Projektor2_Controller_ZobrazeniRegistraci
 *
 * @author pes2704
 */
class Projektor2_Controller_Help_TlacitkaMenu implements Projektor2_Controller_ControllerParamsInterface {

    

    protected $sessionStatus;
    protected $request;
    protected $response;
    protected $params;
    
    public function __construct(Projektor2_Model_SessionStatus $sessionStatus, Projektor2_Request $request, Projektor2_Response $response, array $params=array()) {
        $this->sessionStatus = $sessionStatus;
        $this->request = $request;
        $this->response = $response;
        $this->params = $params;
    }
     
     public function getResult() {      
        $htmlResult = '';
        //nové
        if (isset($this->params['zajemceRegistrace'])) {
            $zajemceRegistrace = $this->params['zajemceRegistrace'];
        }

        ####### zobrazení registrace ################
            $htmlResult .= '<tr>';
            $htmlResult .= '<td class=identifikator>' . $zajemceRegistrace->identifikator . '</td>';
//            $htmlResult .= '<td class=identifikator>' . $zajemceRegistrace->znacka . '</td>';
            $htmlResult .= '<td class=jmeno>' . $zajemceRegistrace->jmeno_cele.'</td>';
        
        ####### zobrazení tlačítek ################
        $htmlResult .= $this->getTlacitkaResult($zajemceRegistrace);            
            $htmlResult .= '</tr>';

        return $htmlResult;
    }
    
    private function getTlacitkaResult(Projektor2_Model_ZajemceRegistrace $zajemceRegistrace) {
        foreach ($zajemceRegistrace->getSkupinyAssoc() as $tlacitko) {    
            $controllerTlacitko = new Projektor2_Controller_Element_Tlacitko($this->sessionStatus, $this->request, $this->response, array('zajemceRegistrace'=>$zajemceRegistrace, 'model'=>$tlacitko));
            $html .= $controllerTlacitko->getResult();
}
        return $html;
    }
}

?>