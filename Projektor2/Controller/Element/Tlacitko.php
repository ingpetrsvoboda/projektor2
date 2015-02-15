<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tlacitko
 *
 * @author pes2704
 */
class Projektor2_Controller_Element_Tlacitko extends Projektor2_Controller_Abstract {
    
    public function getResult() {
        $view = new Projektor2_View_HTML_Element_Tlacitko();
        $view->appendContext($this->params);
        return $view->render();
    }
}
