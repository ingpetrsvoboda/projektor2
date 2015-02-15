<?php
/**
 * Description of Projektor2_Controller_Formular_Base
 *
 * @author pes2704
 */
abstract class Projektor2_Controller_Formular_Help_Menus extends Projektor2_Controller_Formular_Base {
    protected function getLeftMenu() {
        $leftMenuController = new Projektor2_Controller_Help_LeftMenu($this->sessionStatus, $this->request, $this->response);
        $htmlResult = $leftMenuController->getResult();
        return $htmlResult;
    }

    protected function getContentMenu() {
        $html = '';
        // nezobrazuje se pro novou osobu
        if ($this->sessionStatus->zajemce) {
            $params = array('zajemce' => $this->sessionStatus->zajemce);
            $tlacitkaController = new Projektor2_Controller_Element_MenuFormulare($this->sessionStatus, $this->request, $this->response, $params);
            $html .= $tlacitkaController->getResult();
        }
        return $html;
    }
}

?>
