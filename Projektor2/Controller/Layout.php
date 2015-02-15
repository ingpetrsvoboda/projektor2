<?php
/**
 * Description of Projektor2_Controller_Layout
 *
 * @author pes2704
 */
class Projektor2_Controller_Layout extends Projektor2_Controller_Abstract {

    public function getResult() {
        // kontrolery do šablony stránky - volají se vždy
        $headController = new Projektor2_Controller_Head($this->sessionStatus, $this->request, $this->response);
        $headerController = new Projektor2_Controller_Header($this->sessionStatus, $this->request, $this->response);
        $logoutController = new Projektor2_Controller_Logout($this->sessionStatus, $this->request, $this->response);
        $logoController = new Projektor2_Controller_Logo($this->sessionStatus, $this->request, $this->response);
        $containerController = new Projektor2_Controller_Container($this->sessionStatus, $this->request, $this->response);
        $footerController = new Projektor2_Controller_Footer($this->sessionStatus, $this->request, $this->response);
      
        $context['headControllerResult'] = $headController->getResult();
        $context['headerControllerResult'] = $headerController->getResult();
        $context['containerControllerResult'] = $containerController->getResult();;
        $context['footerControllerResult'] = $footerController->getResult();        
        
        $view = new Projektor2_View_HTML_Layout($context);
        $html = $view;
        return $html;
    }
}
