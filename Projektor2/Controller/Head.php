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
        return new Projektor2_View_HTML_Head();
    }
}

?>
