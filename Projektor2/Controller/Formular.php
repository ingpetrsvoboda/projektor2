<?php
/**
 * Description of Projektor2_Controller_ZobrazeniRegistraci
 *
 * @author pes2704
 */
class Projektor2_Controller_Formular extends Projektor2_Controller_Abstract {

    public function performPostActions() {
         if ($this->request->isPost()) {

         }        
    }

    public function performGetActions() {
         if ($this->request->isGet()) {
             if ($this->request->get('id_zajemce')) {
                 $zajemce = Projektor2_Model_Db_ZajemceMapper::findById($this->request->get('id_zajemce'));
                 $this->sessionStatus->setZajemce($zajemce);
             }
         }        
    }
    
    protected function getLeftMenuArray() {
        
        switch ($this->sessionStatus->projekt->kod) {
            case "NSP":

                break;
            case "PNP":

                break;
            case "SPZP":

                break;
            case "RNH":

                break;
            case "AGP":

                break;
            case "HELP":
            case "AP":
            case "SJZP":
                $menuArray = $this->getLeftMenuArrayUni();
                break;            
            default:
                break;
        }
        return $menuArray;
    }
    
    private function getLeftMenuArrayUni() { 
        $menuArray[] = array('href'=>'index.php?akce=zobraz_reg', 'text'=>'Zpět na výběr zájemce');
        return $menuArray;
    }

    public function getResult() {
        $this->performPostActions();
        $this->performGetActions();
        $viewLeftMenu = new Projektor2_View_HTML_LeftMenu($this->sessionStatus, array('menuArray'=>$this->getLeftMenuArray()));
        $parts[] = $viewLeftMenu;       
        
        // nezobrazuje se pro novou osobu
        if ($this->sessionStatus->zajemce) {
            $zajemceOsobniUdaje = Projektor2_Model_ZajemceOsobniUdajeMapper::findById($this->sessionStatus->zajemce->id);
            $params = array('zajemceOsobniUdaje' => $zajemceOsobniUdaje);
            $tlacitkaController = new Projektor2_Controller_Element_MenuFormulare($this->sessionStatus, $this->request, $this->response, $params);
            $rows[] = $tlacitkaController->getResult();            
            $contentParts[] = new Projektor2_View_HTML_Zaznamy($this->sessionStatus, array('rows'=>$rows));
        }
        $router = new Projektor2_Router_Form($this->sessionStatus, $this->request, $this->response);
        $formController = $router->getController();         
        $contentParts[] = $formController->getResult();
        $viewContent = new Projektor2_View_HTML_Content($this->sessionStatus, array('htmlParts'=>$contentParts));
        $parts[] = $viewContent;        
        
        $viewZobrazeniRegistraci = new Projektor2_View_HTML_Multipart($this->sessionStatus, array('htmlParts'=>$parts));
        return $viewZobrazeniRegistraci;
    }
}

?>
