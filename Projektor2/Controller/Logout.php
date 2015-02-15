<?php
/**
 * Description of Hlavicka
 *
 * @author pes2704
 */
class Projektor2_Controller_Logout extends Projektor2_Controller_Abstract {

    public function getResult() {
        // kontroler logout se volá při každém requestu (zobrazení formuláře logout je součástí layoutu celé staránky
        // přesměruje se na login
        if ($this->request->isPost()) {
            if ($this->request->get('akce') == 'logout') {
                try {
                    $authCookie = new Projektor2_Auth_Cookie($this->response);
                    $authCookie->validate();  // pokud není uživatel přihlášen, dojde k přesměrování na login
                    // zde se pokračuje, jen pokud je uživatel přihlášen
                    $authCookie->logout();
                    header("Location: ./login.php?originating_uri=".$_SERVER['REQUEST_URI']);
                    $this->response->send();
                    exit;
                } catch (Projektor2_Auth_Exception $e) {
                    header("Location: ./login.php?originating_uri=".$_SERVER['REQUEST_URI']);
                    $this->response->send();
                    exit;
                }
            }
        }
        $view = new Projektor2_View_HTML_Logout();
        $html = $view->render();
        return $html;
    }
}

?>
