<?php
class Projektor2_Controller_Footer extends Projektor2_Controller_Abstract {

    public function getResult() {
        $view = new Projektor2_View_HTML_Footer($this->sessionStatus);
        $html = $view->render();
        return $html;
    }
}

