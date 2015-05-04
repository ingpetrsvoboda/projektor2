<?php
/**
 * Description of Projektor2_Controller_Element_SignalPlan
 *
 * @author pes2704
 */
class Projektor2_Controller_Element_SignalPlan extends Projektor2_Controller_Abstract  {
    
    public function getResult() {
        $view = new Projektor2_View_HTML_Element_Signal($this->sessionStatus);
        $view->appendContext(array('model'=>$modelSignal));
        return $view->render();
    }
}
