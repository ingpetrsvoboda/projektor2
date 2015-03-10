<?php
/**
 * Description of Projektor2_Controller_ZobrazeniRegistraci
 *
 * @author pes2704
 */
class Projektor2_Controller_Agp_TlacitkaMenu implements Projektor2_Controller_ControllerParamsInterface {

    
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

    const FORMULAR_ZA_ZOBRAZ = za_ind_zobraz_reg;
    
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
            $zajemcePrenesenyZeStarehoProjektu = FALSE;
    //##### !!! blokace - neexistují pohledy pro formuláře ze starých projektů                
    //                if (substr($zajemceRegistrace->identifikator, 0, 1)<'3') {
            if (substr($zajemceRegistrace->identifikator, 0, 1)<'3') {
                $zajemcePrenesenyZeStarehoProjektu = TRUE;
                $zajemce = Projektor2_Model_Db_ZajemceMapper::findById($zajemceRegistrace->id);
                $zaPlanFlatTable = new Projektor2_Model_Db_Flat_ZaPlanFlatTable($zajemce);
                $zaUkoncFlatTable = new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce);
                $zaZamFlatTable = new Projektor2_Model_Db_Flat_ZaZamFlatTable($zajemce);
            }
            $htmlResult .= '<tr>';
            $htmlResult .= '<td class=identifikator>' . $zajemceRegistrace->identifikator . '</td>';
    //                $htmlResult .= '<td class=identifikator>' . $zajemce->identifikator . '</td>';
            $htmlResult .= '<td class=jmeno>' . $zajemceRegistrace->jmeno_cele.'</td>';
    //                $htmlResult .= '<td class=jmeno>' . $zaFlatTable->prijmeni.' '.$zaFlatTable->jmeno.' '.$zaFlatTable->titul.' '.$zaFlatTable->titul_za.'</td>';
            //smlouva
            if ($this->sessionStatus->user->tl_agp_sml) {
                    $htmlResult .= "<td class='editace'><a title='editace' href=\"index.php?akce=form&form=agp_sml_uc&id_zajemce=".$zajemceRegistrace->id."\">"."Smlouva</a></td>";
            }
            //souhlas se zpracováním osobních údajů
            if ($this->sessionStatus->user->tl_agp_souhlas) {
                    $htmlResult .= "<td class='editace'><a title='editace' href=\"index.php?akce=form&form=agp_souhlas_uc&id_zajemce=".$zajemceRegistrace->id."\">"."Souhlas</a></td>";
            }	
            //registrační dotazník
            if ($this->sessionStatus->user->tl_agp_dot) {
                if (isset($zajemceRegistrace->vyplneno_vzdelani)) {
                        $htmlResult .= "<td class='editace'><a title='editace' "; 
                } else {
                        $htmlResult .= "<td class='novy'><a title='nový' ";
                }

                $htmlResult .= " href=\"index.php?akce=form&form=agp_reg_dot&id_zajemce=".$zajemceRegistrace->id."\">"."Dotazník"."</a></td>";
            }
            //plan
            if ($zajemcePrenesenyZeStarehoProjektu) {
                if (isset($zaPlanFlatTable->vyplneny_kurzy) AND substr_count($zaPlanFlatTable->vyplneny_kurzy, "-") <> strlen($zaPlanFlatTable->vyplneny_kurzy)) {                               
                        $htmlResult .= "<td class='editace'><a title='editace' ";
                } else {                    
                        $htmlResult .= "<td class='novy'><a title='' ";
                }
                $htmlResult .= " href=\"index.php?akce=form&form=agp_ind_plan_uc&id_zajemce=".$zajemce->id."\">"."Plán kurzů"."</a>";
                $htmlResult .= "</td>";
            }
            //ukonceni
            if ($zajemcePrenesenyZeStarehoProjektu){
                    if (isset($zaUkoncFlatTable->duvod_ukonceni) AND substr_count($zaUkoncFlatTable->duvod_ukonceni, "-") <> strlen($zaUkoncFlatTable->duvod_ukonceni)) {
                            $htmlResult .= "<td class='editace'><a title='' ";
                    } else {	
                            $htmlResult .= "<td class='novy'><a title='' ";
                    }
                    $htmlResult .= " href=\"index.php?akce=form&form=agp_ukonceni_uc&id_zajemce=".$zajemce->id."\">"."Ukončení"."</a></td>";
            }
            //zamestnani
            if ($zajemcePrenesenyZeStarehoProjektu){ 
                    if (isset($zaZamFlatTable->zam_datum_vstupu) AND isset($zaZamFlatTable->zam_nazev) AND  isset($zaZamFlatTable->zam_ic) ) {
                            $htmlResult .= "<td class='editace'><a title='' ";
                    } else {
                            $htmlResult .= "<td class='novy'><a title='' ";
                    }
                    $htmlResult .= " href=\"index.php?akce=form&form=agp_zam_uc&id_zajemce=".$zajemce->id."\">"."Zaměstnání" . "</a></td>";
            }
            $htmlResult .= '</tr>';
        }

        return $htmlResult;
    }
}

?>