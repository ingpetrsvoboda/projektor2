<?php
/**
 * Description of Projektor2_Controller_Element_Tlacitko
 *
 * @author pes2704
 */
class Projektor2_Controller_Element_MenuFormulare_Tlacitko extends Projektor2_Controller_Abstract {
    
    public function getResult() {
        $view = new Projektor2_View_HTML_Element_Tlacitko();
        $view->appendContext($this->params);
        return $view->render();
    }
}
