<?php
/**
 * Description of 
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Element_KurzFieldset extends Framework_View_Abstract {
    
    public function render() {
        if (isset($this->context['readonly']) AND $this->context['readonly']) {
            $readonlyAttribute = ' readonly="readonly" ';
            $disabledAttribute = ' disabled="disabled" ';
            $dateInputType = 'text';
            $fieldsetClass = 'readonly';
        } else {
//            $dateInputType = 'date';  
            $readonlyAttribute = ' ';
            $disabledAttribute = ' ';
            $dateInputType = 'date';  
            $fieldsetClass = '';            
        }
        $checkedAttribute = ' checked="checked" ';
//        $idSKurzName = $this->context['planPrefix'].'->id_s_kurz_'.$this->context['druhKurzu'].'_FK';        
//        $idSKurzValue = $this->context[$idSKurzName];
//        $prop = $this->context['returnedModelProperty']; 
//        $planovanyPocetHodin = 0;
//        $naplanovanKurz = FALSE;
//        // zjištění plánovaného počtu hodin
//        foreach ($this->context['modelsArray'] as $model) {
//            $valueObjectProperty = $model->$prop;
//            if (isset($idSKurzValue) AND $idSKurzValue == $valueObjectProperty AND $valueObjectProperty>3) {    // a id>3
//                $planovanyPocetHodin = $model->pocet_hodin;
//                $naplanovanKurz = TRUE;   
//            }
//        }      
        
//    $kurzPlan = new Projektor2_Model_KurzPlan();  // jen pro našeptávání!!        
        if (isset($this->context['druhKurzu'])) {
            $druhKurzu = $this->context['druhKurzu'];
        } else {
            throw new UnexpectedValueException('Položka kontextu \'druhKurzu\' musí být nastevena.');
        }
        $zaPlanColumnNames = Projektor2_Model_Db_Flat_ZaPlanFlatTable::getItemColumnsNames($druhKurzu);
        $idSKurzColumnName = $this->context['planPrefix'].Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.$zaPlanColumnNames['idSKurzFK'];
        
        
        $kurzPlan = $this->context['kurzPlan'];   
        if ($kurzPlan AND $kurzPlan->sKurz) {
            $planovanyPocetHodin = $kurzPlan->sKurz->pocet_hodin;
            $naplanovanKurz = $kurzPlan->sKurz->isNaplanovan();
        } else {
            $planovanyPocetHodin = 0;
            $naplanovanKurz = FALSE;
        }
        
        // názvy pro návratové hodnoty do contextu
        $namePocAbsHodin = $this->context['planPrefix'].Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.$zaPlanColumnNames['pocAbsHodin'];
        $nameDokonceno = $this->context['planPrefix'].Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.$zaPlanColumnNames['dokonceno'];
        $nameDuvodAbsence = $this->context['planPrefix'].Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.$zaPlanColumnNames['duvodAbsence'];
        $nameDatumCertif = $this->context['planPrefix'].Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.$zaPlanColumnNames['datumCertif'];
        $nameDuvodNeukonceni = $this->context['planPrefix'].Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.$zaPlanColumnNames['duvodNeukonceni'];
        $zadanyAbsolvovaneHodiny = $kurzPlan->pocAbsHodin>0 ? TRUE : FALSE;
        $zadanoUspesneNeuspesne = $kurzPlan->dokoncenoUspesne ? TRUE : FALSE;  // hodnota je "Ano" nebo "Ne", tedy zadaná hodnote -> TRUE
        
        $idSelect = $kurzPlan->indexAktivity.'_select';
        $idTlacitkoAbsolvovano = $kurzPlan->indexAktivity.'_tlacitko_absolvovano';
        $idUdajeAbsolvovano = $kurzPlan->indexAktivity.'_udaje_absolvovano';
       
        $displayTlacitkoAbsolvovano = ($naplanovanKurz AND !$zadanyAbsolvovaneHodiny AND !$zadanoUspesneNeuspesne) ?'block':'none';
        // flag je true pokud již byl dříve zadán (načten z db) počet hodin nebo dokonceno
        $displayBlokAbsolvovano = ($zadanyAbsolvovaneHodiny OR $zadanoUspesneNeuspesne) ? 'block':'none';
        // flag je true pokud již byl dříve zadán (načten z db) vybraný kurz (plánovaný)
        $displayBlokPocetHodin = ($planovanyPocetHodin>0) ? 'block':'none';
        $displayBlokDuvodAbsence = ($kurzPlan->duvodAbsence) ? 'block':'none';
        $displayBlokDokonceno = ($zadanoUspesneNeuspesne) ? 'block':'none';
        $zadanoDokoncenoAno = ($kurzPlan->dokoncenoUspesne == 'Ano') ? TRUE:FALSE;
        $zadanoDokoncenoNe = ($kurzPlan->dokoncenoUspesne == 'Ne') ? TRUE : FALSE;            
        $zobrazBlokCertifikat = ($kurzPlan->aktivitaSCertifikatem) ? TRUE : FALSE;  
        $idBlokCertifikat = $kurzPlan->indexAktivity.'_certifikat';
        $displayBlokCertifikat = ($zadanoDokoncenoAno) ? 'block':'none';
        
        // view pro select
        $viewSelect = new Projektor2_View_HTML_Element_Select($this->sessionStatus, $this->context);
        if (isset($kurzPlan->sKurz->id)) {
            $aktVal = $kurzPlan->sKurz->id;
        } else {
            $aktVal = NULL;
        }
        $viewSelect->assign('selectId', $idSelect)
                ->assign('selectName', $idSKurzColumnName)
                ->assign('valuesArray', $this->context['modelsArray'])
                ->assign('returnedObjectProperty', $this->context['returnedModelProperty'])
                ->assign('actualValue', $aktVal)
                ->assign('innerTextCallable', array($this,'text_retezec_kurz'))
                ->assign('onChangeJsCode', 'submitForm(this);') // SUBMIT po ksždé změně hodnoty - je potřebný pro načtení plánovaného počtu hodin právě zvoleného kurzu
                ->assign('readonly', $this->context['readonly']);        
        if ($zadanyAbsolvovaneHodiny OR $zadanoUspesneNeuspesne) {
            $viewSelect->assign('readonly', TRUE);
        }         
            
        ####### html ############
        $this->parts[] ='<fieldset class="'.$fieldsetClass.'">';
        $this->parts[] ='<legend>'.$this->context['aktivita']['nadpis'].'</legend>'; 
        $this->parts[] ='<p>';
            $this->parts[] ='<label>'.$this->context['aktivita']['nadpis'].': </label>';
            $this->parts[] = $viewSelect;
        $this->parts[] ='</p>';

        // tlačítko zadání údajů absolvováno
        if ($displayTlacitkoAbsolvovano) {
            $this->parts[] = '<input type="button" name="dummy" '
                    . 'id="'.$idTlacitkoAbsolvovano.'" style="display:'.$displayTlacitkoAbsolvovano.'" '
                    . $disabledAttribute.' value="Zadání údajů o absolvování aktivity: "'; 
            $this->parts[] = ' onClick="toggle(\''.$idUdajeAbsolvovano.'\');">';             
        }
        // a span absolvovano
        $this->parts[] = '<div id="'.$idUdajeAbsolvovano.'" style="display:'.$displayBlokAbsolvovano.'">';
            // span pro počet absolvovaných hodin        
            $this->parts[] = '<span style="display:'.$displayBlokPocetHodin.'">';            
                $this->parts[] = '<p>';
                // počet plánovaných hodin
                $this->parts[] ='<span> Plánovaný počet hodin: '.$planovanyPocetHodin
                        .'</span>';            
                // počet absolvovaných hodin a závislý prvek důvod absence
                $this->parts[] = '<label>Počet absolvovaných hodin: </label>'
                            . '<input type="number" pattern="\d+" min="0" max="'.$planovanyPocetHodin.'" '
                            . 'name="'.$namePocAbsHodin.'" '
                            . 'size=8 maxlength=10 value="'.$this->context[$namePocAbsHodin].'" '
                            . $disabledAttribute
                            . ' onChange="showWithRequiredInputsIfIn(\''.$nameDuvodAbsence.'\', this, 1, '.($planovanyPocetHodin-1).');'
                        . 'showWithRequiredInputsIfGt(\''.$nameDokonceno.'\', this, 0);">';
                $this->parts[] = '</p>';

                $this->parts[] ='<p id="'.$nameDuvodAbsence.'" style="display:'.$displayBlokDuvodAbsence.'">'
                            . '<label>V případě, že neabsolvoval plný počet hodin, uveďte důvod: </label>'
                            . '<input type="text" name="'.$nameDuvodAbsence.'" size=120 maxlength=120 '
                            . 'value="'.$this->context[$nameDuvodAbsence].'" '
                            . $disabledAttribute.' >'
                            . '</input>'
                            . '</p>';
            $this->parts[] ='</span>';
            // konec počet plánovaných hodin
            
            // dokončeno úšpěšně/neúspěšně a závislý prvek důvod neukončení
            $this->parts[] ='<p id="'.$nameDokonceno.'" style="display:'.$displayBlokDokonceno.'">';
            $this->parts[] ='<label>Dokončeno úspěšně: </label>'
                    . '<input type="radio" name="'.$nameDokonceno.'" value="Ano" ';
                    if ($zadanoDokoncenoAno) {
                        $this->parts[] = $checkedAttribute;
                    } else {
                        $this->parts[] = $disabledAttribute;                    
                    }
                    $this->parts[] =' onClick="hideWithRequiredInputs(\''.$nameDuvodNeukonceni.'\'); show(\''.$idBlokCertifikat.'\');">';
            $this->parts[] ='<label>Dokončeno neúspěšně: </label>'
                        .'<input type="radio" name="'.$nameDokonceno.'" value="Ne" ';
                    if ($zadanoDokoncenoNe) {
                        $this->parts[] = $checkedAttribute;
                        $styleDuvodNeukonceni = 'block';
                    } else {
                        $this->parts[] = $disabledAttribute;                 
                        $styleDuvodNeukonceni = 'none';
                    }
                    $this->parts[] =' onClick="showWithRequiredInputs(\''.$nameDuvodNeukonceni.'\'); hide(\''.$idBlokCertifikat.'\');">';
            $this->parts[] ='</p>';
            $this->parts[] ='<div id="'.$nameDuvodNeukonceni.'" style="display:'.$styleDuvodNeukonceni.'">'
                    . '<label>Při neúspěšném ukončení uveďte důvod: </label>'
                    . '<input type="text" name="'.$nameDuvodNeukonceni.'" size=120 maxlength=120 '
                    . 'value="'.$this->context[$nameDuvodNeukonceni].'" '
                    . $disabledAttribute.'>'
                    . '</input>'
                    . '</div>';   
            // konec dokončeno úšpěšně/neúspěšně a závislý prvek důvod neukončení
            
            if ($zobrazBlokCertifikat) {
                $viewCertifikat = new Projektor2_View_HTML_Element_DatumATlacitkoCertifikat($this->sessionStatus);
                $viewCertifikat->assign('readonly', $this->context['readonly']);
                $viewCertifikat->assign('idBlokCertifikat', $idBlokCertifikat);
                $viewCertifikat->assign('displayBlokCertifikat', $displayBlokCertifikat);
                $viewCertifikat->assign('nameDatumCertif', $nameDatumCertif);
                $viewCertifikat->assign('valueDatumCertif', $this->context[$nameDatumCertif]);
                $viewCertifikat->assign('druhKurzu', $druhKurzu);
                $this->parts[] = $viewCertifikat;
            }
        $this->parts[] = '</div>'; 
// konec span absolvovano
        $this->parts[] ='</fieldset>'; 

        return $this;        
    }
        
    /**
     * Callback funkce pro view  Projektor2_View_HTML_Element_Select.
     * @param Projektor2_Model_Db_SKurz $kurz
     * @return string
     */
    public function text_retezec_kurz(Projektor2_Model_Db_SKurz $kurz) {
        if ($kurz->kurz_zkratka == '*') {
            $ret = $kurz->kurz_nazev;
        } else {
            $ret = trim($kurz->projekt_kod). "_" .trim($kurz->kurz_druh). "_" . trim($kurz->kurz_cislo) . "_".
                    trim($kurz->beh_cislo) . "T_" . trim($kurz->kurz_zkratka). " | ".
                    trim($kurz->kurz_nazev)." | ".trim($kurz->date_zacatek)." - ".trim($kurz->date_konec). " | " . trim($kurz->kancelar_kod);
        }
        return $ret;
    }    
}
