<?php
/**
 * Description of Projektor2_Controller_ZobrazeniRegistraci
 *
 * @author pes2704
 */
class Projektor2_Controller_Sjzp_TlacitkaMenu implements Projektor2_Controller_ControllerParamsInterface {
    
    protected $sessionStatus;
    protected $request;
    protected $response;
    protected $params;
    
    public function __construct(Projektor2_Model_SessionStatus $sessionStatus, Projektor2_Request $request, Projektor2_Response $response, array $params=array()) {
        $this->sessionStatus = $sessionStatus;
        $this->request = $request;
        $this->response = $response;
        $this->params = $params;
    }
     
     public function getResult() {         
        $htmlResult = '';
        if (isset($this->params['id'])) {

            $zajemceRegistrace = Projektor2_Model_ZajemceRegistraceMapper::findById($this->params['id']);
            $zajemce = Projektor2_Model_Db_ZajemceMapper::findById($zajemceRegistrace->id);
            $zaPlanFlatTable = new Projektor2_Model_Db_Flat_ZaPlanFlatTable($zajemce);
//            $zaPlanFlatTable->read_values();            
            $zaUkoncFlatTable = new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce);
//            $zaUkoncFlatTable->read_values();
            $zaZamFlatTable = new Projektor2_Model_Db_Flat_ZaZamFlatTable($zajemce);
//            $zaZamFlatTable->read_values();
            
            $htmlResult .= '<tr>';
            $htmlResult .= '<td class=identifikator>' . $zajemceRegistrace->identifikator . '</td>';
            $htmlResult .= '<td class=identifikator>' . $zajemceRegistrace->znacka . '</td>';
            
//            $htmlResult .= '<td class=jmeno>' . $zaznam['jmeno_cele'].'</td>';
            $htmlResult .= '<td class=jmeno>' . $zajemceRegistrace->jmeno_cele.'</td>';
            //smlouva
            if ($this->sessionStatus->user->tl_sj_sml) {
                $htmlResult .= "<td class='editace'><a title='editace' href=\"index.php?akce=form&form=sjzp_sml_uc&id_zajemce="
                            .$zajemceRegistrace->id."\">"."Smlouva</a></td>";
            }
            //souhlas se zpracováním osobních údajů
            if ($this->sessionStatus->user->tl_sj_souhlas) {
                $htmlResult .= "<td class='editace'><a title='editace' href=\"index.php?akce=form&form=sjzp_souhlas_uc&id_zajemce="
                            .$zajemceRegistrace->id."\">"."Souhlas</a></td>";
            }	
            //registrační dotazník
            if ($this->sessionStatus->user->tl_sj_dot) {
                //barvy
                if ($zajemceRegistrace->vyplneno_vzdelani) {
                        $htmlResult .= "<td class='editace'><a title='editace' ";
                    } else {
                        $htmlResult .= "<td class='novy'><a title='nový' ";
                    }
                $htmlResult .= " href=\"index.php?akce=form&form=sjzp_reg_dot&id_zajemce="
                            .$zajemceRegistrace->id."\">"."Dotazník"."</a>";
                $htmlResult .= "</td>";                    
            }
            //IP1
            if ($this->sessionStatus->user->tl_ap_ip1) {
                //barvy
                if ($zaPlanFlatTable->vyplneny_kurzy) {
                        $htmlResult .= "<td class='editace'><a title='editace' ";
                    } else {
                        $htmlResult .= "<td class='novy'><a title='nový' ";
                    }
                $htmlResult .= " href=\"index.php?akce=form&form=sjzp_ip1_uc&id_zajemce="
                            .$zajemceRegistrace->id."\">"."IP1"."</a>";
                $htmlResult .= "</td>";        
            }
            //plan
            if ($this->sessionStatus->user->tl_ap_plan) {
                //barvy
                if ($zaPlanFlatTable->vyplneny_kurzy) {
                        $htmlResult .= "<td class='editace'><a title='editace' ";
                    } else {
                        $htmlResult .= "<td class='novy'><a title='nový' ";
                    }
                $htmlResult .= " href=\"index.php?akce=form&form=sjzp_plan_uc&id_zajemce="
                            .$zajemceRegistrace->id."\">"."Plán kurzů"."</a>";
                $htmlResult .= "</td>";        
            }
            //plan kurzy a poradenstvi
            if ($this->sessionStatus->user->tl_ap_plan) {
                //barvy
                if ($zaPlanFlatTable->vyplneny_kurzy) {
                        $htmlResult .= "<td class='editace'><a title='editace' ";
                    } else {
                        $htmlResult .= "<td class='novy'><a title='nový' ";
                    }
                $htmlResult .= " href=\"index.php?akce=form&form=sjzp_porad_uc&id_zajemce="
                            .$zajemceRegistrace->id."\">"."Plán kurzů a poradenství"."</a>";
                $htmlResult .= "</td>";        
            }
            //ukonceni
            if ($this->sessionStatus->user->tl_ap_ukon) {
                //barvy
                if ($zaUkoncFlatTable->duvod_ukonceni) {
                        $htmlResult .= "<td class='editace'><a title='editace' ";
                    } else {
                        $htmlResult .= "<td class='novy'><a title='nový' ";
                    }
                $htmlResult .= " href=\"index.php?akce=form&form=sjzp_ukonceni_uc&id_zajemce=".$zajemceRegistrace->id."\">"
                            ."Ukončení IP2"."</a></td>";
            }
            //zamestnani
            if ($this->sessionStatus->user->tl_ap_zam) { 
                //barvy
                if ($zaZamFlatTable->zam_datum_vstupu AND $zaZamFlatTable->zam_nazev AND $zaZamFlatTable->zam_ic) {
                        $htmlResult .= "<td class='editace'><a title='editace' ";
                    } else {
                        $htmlResult .= "<td class='novy'><a title='nový' ";
                    }
                $htmlResult .= " href=\"index.php?akce=form&form=sjzp_zamestnani_uc&id_zajemce=".$zajemceRegistrace->id."\">"
                            ."Zaměstnání" . "</a></td>";
            }
            $htmlResult .= '</tr>';
        }

        return $htmlResult;
    }
}

?>