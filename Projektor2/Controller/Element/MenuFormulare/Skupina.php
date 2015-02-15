<?php
/**
 * Description of Tlacitka
 *
 * @author pes2704
 */
class Projektor2_Controller_Element_MenuFormulare_Skupina extends Projektor2_Controller_Abstract {
     
     public function getResult() { 
        $zajemceRegistrace = $this->params['zajemceRegistrace'];
        $html = '';
        foreach ($zajemceRegistrace->getSkupinyAssoc() as $skupina) {
            foreach ($skupina->getMenuTlacitkaAssoc() as $tlacitko) {
                $view = new Projektor2_View_HTML_Element_Tlacitko();
                $view->appendContext(array('model'=>$tlacitko, 'zajemceRegistrace'=>$zajemceRegistrace));
                $html .= $view->render();
            }
            foreach ($skupina->getMenuSignalyAssoc() as $signal) {
                $view = new Projektor2_View_HTML_Element_SignalPlan();
                $view->appendContext(array('model'=>$signal));
                $html .= $view->render();
            }
        }
        return $html;
     }
}
