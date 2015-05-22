<?php
/**
 * Description of Projektor2_Controller_Layout
 *
 * @author pes2704
 */
class Projektor2_Controller_Page extends Projektor2_Controller_Abstract {

    public function getResult() {
        // kontrolery do šablony stránky - volají se vždy
        $headController = new Projektor2_Controller_Head($this->sessionStatus, $this->request, $this->response);
        $loginLogoutController = new Projektor2_Controller_LoginLogout($this->sessionStatus, $this->request, $this->response);
      
        $context['headControllerResult'] = $headController->getResult();
        $context['loginControllerResult'] = $loginLogoutController->getResult();        
        
        $view = new Projektor2_View_HTML_Page($context);
        return $view;
    }
}
