<?php
/**
 * Description of Projektor2_Controller_ZobrazeniRegistraci
 *
 * @author pes2704
 */
class Projektor2_Controller_Agp_ZobrazeniRegistraci implements Projektor2_Controller_ControllerInterface {

    
// !!! Konstanty i pro staré projekty a zájemce !!!!!!!!!!!
    const FORMULAR_PLAN = ind_plan_uc;
    const FORMULAR_ZAM = ind_zam_uc;
    const FORMULAR_UKONC = ind_ukonc_uc;
    const FORMULAR_REG_DOT = ind_reg_dot;

    const FORMULAR_ZOBRAZ = ind_zobraz_reg;

    const FORMULAR_ZA_PLAN = za_ind_plan_uc;
    const FORMULAR_ZA_ZAM = za_ind_zam_uc;
    const FORMULAR_ZA_UKONC = za_ind_ukonc_uc;
    const FORMULAR_ZA_REG_DOT = za_ind_reg_dot;

   /* const FORMULAR_ZA_ZOBRAZ = za_ind_zobraz_reg;*/
    
    protected $sessionStatus;
    protected $request;
    protected $response;
    
    public function __construct(Projektor2_Model_SessionStatus $sessionStatus, Projektor2_Request $request, Projektor2_Response $response) {
        $this->sessionStatus = $sessionStatus;
        $this->request = $request;
        $this->response = $response;
    }
     
     public function getResult() {         
        $htmlResult = '';
        $htmlResult .= "<h3>Zobrazeni registrací</h3>";
        $htmlResult .= '<div class="left">
                                <ul id="menu">
                                    <li><a href="index.php?akce=select_beh">Zpět na výběr běhu</a></li>
                                    <li><a href="index.php?akce=form&form=agp_novy_zajemce">Nová osoba</a></li>';
        if ( ($this->sessionStatus->user->username == "sys_admin" OR $this->sessionStatus->user->username == "agp_manager")) {
            $htmlResult .= '        <li><a href="index.php?akce=agp_export">Exportuj přehled</a></li>';
        }	
        $htmlResult .= '        </ul>
                        </div>';
        $htmlResult .= '<div class="content">';
        $htmlResult .= '<div ID="zaznamy">';

        $zajemciRegistrace = Projektor2_Model_ZajemceRegistraceMapper::findAll();
        $htmlResult .= '<table>';
        if ($zajemciRegistrace) {
            foreach ($zajemciRegistrace as $zajemceRegistrace) {
                $params = array('id' => $zajemceRegistrace->id);
                $tlacitkaController = new Projektor2_Controller_Agp_TlacitkaMenu($this->sessionStatus, $this->request, $this->response, $params);
                $htmlResult .= $tlacitkaController->getResult();  //$this->sessionStatus->zajemce->id
            }
        }
        $htmlResult .= '</table>';
        $htmlResult .= '</div>';
        $htmlResult .= '</div>';
        return $htmlResult;
    }
}

?>
