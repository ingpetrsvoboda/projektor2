<?php
/**
 * Description of Projektor2_Controller_Layout
 *
 * @author pes2704
 */
class Projektor2_Controller_Header extends Projektor2_Controller_Abstract {

    public function getResult() {
        $logoController = new Projektor2_Controller_Logo($this->sessionStatus, $this->request, $this->response);
        $context['logoControllerResult'] = $logoController->getResult();        
        
        $view = new Projektor2_View_HTML_Header($this->sessionStatus, $context);
        $html = $view->render();
        return $html;
    }
}
