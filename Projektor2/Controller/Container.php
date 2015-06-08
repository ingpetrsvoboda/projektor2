<?php
/**
 *
 * @author pes2704
 */
class Projektor2_Controller_Container extends Projektor2_Controller_Abstract {

    public function getResult() {
        $message = '';
//        $sessionStatus = Projektor2_Model_SessionStatus::getSessionStatus();

        if(!Projektor2_Model_Db_SysAccUsrProjektMapper::findById($this->sessionStatus->user->id, $this->sessionStatus->projekt->id)) {
            $message = "V tomto projektu nemáte přístupná žádná data, zkuste se odhlásit a vybrat jiný";
        }
        // podmínka pro pokračování
        if ($message) {
            $viewMessage = new Projektor2_View_HTML_Message(array('message' => $message));
            $htmlParts[] = $viewMessage;
        } else {
            $controller = new Projektor2_Controller_VyberKontext($this->sessionStatus, $this->request, $this->response);
            $htmlParts[] = $controller->getResult();
        }
        $viewContainer = new Projektor2_View_HTML_Element_Div(array('htmlParts'=>$htmlParts, 'class'=>'container'));
        return $viewContainer;
    }
}
