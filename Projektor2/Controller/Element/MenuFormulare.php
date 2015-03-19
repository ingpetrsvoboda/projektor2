<?php
/**
 * Description of Projektor2_Controller_Element_MenuFormulare
 *
 * @author pes2704
 */
class Projektor2_Controller_Element_MenuFormulare extends Projektor2_Controller_Abstract {
     
    /**
     * Očekává v poli params (předávané při volání konstruktoru) nastavenou hodootu $params['zajemce'] 
     * typu Projektor2_Model_Db_Zajemce. Zájemce nečte z sesionStatus, protože tento kontroler je používán i pro 
     * vytvoření menu formuláře jako jednotlivých řádků ve seznamu. Pracuje tedy s zájemcem zadaných parametrem, 
     * který je jiný než zájemce v sessionStatus.
     * @return \Projektor2_View_HTML_Multipart
     */
    public function getResult() {         
        //nové
        $htmlParts = array();
        if (isset($this->params['zajemceOsobniUdaje'])) {
            $zajemceRegistrace = Projektor2_Model_ZajemceRegistraceMapper::create($this->params['zajemceOsobniUdaje']);  
            // sada td tlačítka
            $skupinaController = new Projektor2_Controller_Element_MenuFormulare_Skupina($this->sessionStatus, $this->request, $this->response, 
                                                                 array('zajemceRegistrace'=>$zajemceRegistrace));
            $htmlSkupiny = $skupinaController->getResult();
            $viewRegistrace = new Projektor2_View_HTML_Element_ZajemceRegistrace($this->sessionStatus, 
                                                                 array('zajemceRegistrace'=>$zajemceRegistrace, 'htmlSkupiny'=>$htmlSkupiny));
            // tr - registrace + sada tlačítek + sada signálů
            $htmlParts[] = $viewRegistrace;
        }
        return new Projektor2_View_HTML_Multipart($this->sessionStatus, array('htmlParts'=>$htmlParts));
    }
}
