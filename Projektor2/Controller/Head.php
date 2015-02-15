<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Hlavicka
 *
 * @author pes2704
 */
class Projektor2_Controller_Head extends Projektor2_Controller_Abstract {

    public function getResult() {
        $projektText = isset($this->sessionStatus->projekt->text) ? $this->sessionStatus->projekt->text : '';
        $kancelarText = isset($this->sessionStatus->kancelar->text) ? $this->sessionStatus->kancelar->text : '';
        $view = new Projektor2_View_HTML_Head(array('projektText'=>$projektText , 'kancelarText'=>$kancelarText));
        $html = $view->render();
        return $html;
    }
}

?>
