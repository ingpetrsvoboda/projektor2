<?php
/**
 * Description of Projektor2_Controller_ZobrazeniRegistraci
 *
 * @author pes2704
 */
class Projektor2_Controller_Element_MenuFormulare extends Projektor2_Controller_Abstract {
     
     public function getResult() {         
        //nové
        if (isset($this->params['zajemce'])) {
            $zajemceRegistrace = Projektor2_Model_ZajemceRegistraceMapper::create($this->params['zajemce']);  
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
