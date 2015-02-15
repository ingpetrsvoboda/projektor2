<?php

/**
 * ModelProjekt je test pro Projektor2_Model_ZaPlanPoradenstviMapper, Projektor2_Model_ZaPlanPoradenstvi
 * volání testu:
 * http://localhost/p2/index.php?akce=test&testclass=Projektor2_Controller_Test_ModelZaPlanPoradenstvi
 *
 * @author pes2704
 */
class Projektor2_Controller_Test_ModelZaPlanPoradenstvi  implements Projektor2_Controller_ControllerInterface {
    
    /**
     *
     * @var Projektor2_Model_Db_ZaPlanPoradenstvi 
     */
    private $zaPlan;
    
    public function __construct() {

    }
    
    public function getResult() {
        $helper = new Projektor2_Controller_Test_Helper();

        $html .= $helper->listTestMethod('Projektor2_Controller_Test_ModelZaPlanPoradenstvi', 'test');
        $html .= $helper->interval();
        $html .= $this->test();
        $html .= $helper->interval();
        return $html;
    }
    
    public function test() {
        $html = '<div class=test>';
        $html .= '<h1>Test Projektor2_Model_ZaPlanPoradenstviMapper a Projektor2_Model_ZaPlanPoradenstvi';
        $mapper = new Projektor2_Model_Db_ZaPlanPoradenstviMapper();
        $id = 10844;
//        for ($id = 844; $id <= 10844; $id++) {
            $this->zaPlan = $mapper->findByIdZajemce($id);
//        }
        $html .= '<pre>'.print_r($this->zaPlan, TRUE).'</pre>';
        if ($this->zaPlan) {
            $html .= '<pre>'.'$this->zaPlan->getNames(): '.print_r($this->zaPlan->getNames(), TRUE).'</pre>';
            $html .= '<pre>'.'$this->zaPlan->getValues(): '.print_r($this->zaPlan->getValues(), TRUE).'</pre>';
            $html .= '<pre>'.'$this->zaPlan->getValuesAssoc(): '.print_r($this->zaPlan->getValuesAssoc(), TRUE).'</pre>';
            $html .= '<p>Přiřazení hodnot do jedné existující a jedné neexistující vlastnosti itemu.</p>';
            $this->zaPlan->text = 'A máme právě '.date('H:m:s');
            $this->zaPlan->qqqq = 'qqqq';
            $html .= '<pre>'.'$this->zaPlan->getValuesAssoc(): '. print_r($this->zaPlan->getValuesAssoc(), TRUE).'</pre>';
            $html .= '<pre>'.'$this->zaPlan->text: '.var_export($this->zaPlan->text, TRUE).'</pre>';
            $html .= '<pre>'.'$this->zaPlan->qqq: '.var_export($this->zaPlan->qqq, TRUE).'</pre>';
        } else {
            $html .= '<p>Objekt modelu (item) nebyl vytvořen, pravděpodobně nebyl nalezen záznam se zadaným id v databázi.</p>';
        }

        $html .= '</div>';
        return $html;        
    }
}
