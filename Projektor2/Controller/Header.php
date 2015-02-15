<?php
/**
 * Description of Projektor2_Controller_Layout
 *
 * @author pes2704
 */
class Projektor2_Controller_Header extends Projektor2_Controller_Abstract {

    public function getResult() {
        // kontrolery do šablony stránky - volají se vždy
        $contextController = new Projektor2_Controller_ConnectionInfo($this->sessionStatus, $this->request, $this->response);
        $logoutController = new Projektor2_Controller_Logout($this->sessionStatus, $this->request, $this->response);
        $logoController = new Projektor2_Controller_Logo($this->sessionStatus, $this->request, $this->response);
      
        $context['contextControllerResult'] = $contextController->getResult();
        $context['logoutControllerResult'] = $logoutController->getResult();
        $context['logoControllerResult'] = $logoController->getResult();        
        
        $view = new Projektor2_View_HTML_Header($context);
        $html = $view->render();
        return $html;
    }
}
