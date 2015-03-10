<?php
/**
 * Description of Projektor2_Controller_ZobrazeniRegistraci
 *
 * @author pes2704
 */
class Projektor2_Controller_ZobrazeniRegistraci extends Projektor2_Controller_Abstract {
    
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
                $menuArray = $this->getLeftMenuArrayHelp();
                break;
            case "AP":
                $menuArray = $this->getLeftMenuArrayAP();
                break;
            case "SJZP":
                $menuArray = $this->getLeftMenuArraySjzp();
                break;            
            default:
                break;
        }
        return $menuArray;
    }
    
    private function getLeftMenuArrayAP() {
        $menuArray[] = array('href'=>'index.php?akce=form&form=ap_novy_zajemce', 'text'=>'Nová osoba');
        if ( ($this->sessionStatus->user->username == "sys_admin" OR $this->sessionStatus->user->username == "ap_manager")) {
            $menuArray[] = array('href'=>'index.php?akce=ap_export', 'text'=>'Exportuj přehled');
            $menuArray[] = array('href'=>'index.php?akce=ap_ip_certifikaty_export', 'text'=>'Exportuj IP certifikáty');
            $menuArray[] = array('href'=>'index.php?akce=ap_projekt_certifikaty_export', 'text'=>'Exportuj projektové certifikáty'); 
        }
        return $menuArray;
    }
    
    private function getLeftMenuArrayHelp() {
        $menuArray[] = array('href'=>'index.php?akce=form&form=he_novy_zajemce', 'text'=>'Nová osoba');
        if ( ($this->sessionStatus->user->username == "sys_admin" OR $this->sessionStatus->user->username == "help_manager")) {
            $menuArray[] = array('href'=>'index.php?akce=he_export', 'text'=>'Exportuj přehled'); 
        }
        return $menuArray;
    }     
    
    protected function getLeftMenuArraySjzp() {
        $menuArray[] = array('href'=>'index.php?akce=form&form=sjzp_novy_zajemce', 'text'=>'Nová osoba');
        if ( ($this->sessionStatus->user->username == "sys_admin" OR $this->sessionStatus->user->username == "sjzp_manager")) {
            $menuArray[] = array('href'=>'index.php?akce=sjzp_export', 'text'=>'Exportuj přehled'); 
        }
        return $menuArray;
    }    
    
    public function getResult() {
        $this->sessionStatus->setZajemce();  //smazání zajemce v session
        $viewLeftMenu = new Projektor2_View_HTML_LeftMenu($this->sessionStatus, array('menuArray'=>$this->getLeftMenuArray()));
        $parts[] = $viewLeftMenu;
        
        $zajemciOsobniUdaje = Projektor2_Model_ZajemceOsobniUdajeMapper::findAll(NULL, NULL, "identifikator");
        if ($zajemciOsobniUdaje) {
            foreach ($zajemciOsobniUdaje as $zajemceOsobniUdaje) {
                $params = array('zajemce' => $zajemceOsobniUdaje->zajemce);
                $tlacitkaController = new Projektor2_Controller_Element_MenuFormulare($this->sessionStatus, $this->request, $this->response, $params);
                $rows[] = $tlacitkaController->getResult();
            }
            $viewZaznamy = new Projektor2_View_HTML_Zaznamy($this->sessionStatus, array('rows'=>$rows));
            $viewContent = new Projektor2_View_HTML_Content($this->sessionStatus, array('htmlParts'=>array($viewZaznamy)));
            $parts[] = $viewContent;
        }   
        $viewZobrazeniRegistraci = new Projektor2_View_HTML_Multipart($this->sessionStatus, array('htmlParts'=>$parts));
        return $viewZobrazeniRegistraci;
    }
}

?>
