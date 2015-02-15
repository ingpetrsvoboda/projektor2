<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ModelProjekt
 *
 * @author pes2704
 */
class Projektor2_Controller_Test_ModelProjekt  implements Projektor2_Controller_ControllerInterface {
    
    private $projekt;
    
    public function __construct() {
        $this->projekt = Projektor2_Model_Db_ProjektMapper::findByKod('AP');
    }
    
    public function getResult() {
        $html = '<div class=test>';
        $html .= '<h1>Test Projektor2_Model_ProjektMapper a Projektor2_Model_Projekt';
        $html .= '<pre>'.print_r($this->projekt, TRUE).'</pre>';
        $html .= '<pre>'.print_r($this->projekt->getNames(), TRUE).'</pre>';
        $html .= '<pre>'.print_r($this->projekt->getValues(), TRUE).'</pre>';
        $html .= '<pre>'.print_r($this->projekt->getValuesAssoc(), TRUE).'</pre>';
        $html .= '</div>';
        return $html;
    }
}
