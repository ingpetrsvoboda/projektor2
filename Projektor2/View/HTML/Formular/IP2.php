<?php
/**
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Formular_IP2 extends Framework_View_Abstract {
    
    const MODEL_UKONCENI = 'ukonceni';
    const MODEL_PLAN = 'plan';
    
    public function render() {
        $requiredAttribute = ' required="required" ';
        $checkedAttribute = ' checked="checked" ';
        
        $nameDokonceno = self::MODEL_UKONCENI.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.'dokonceno';
        if ($this->context[$nameDokonceno] == 'Ano') {
            $zadanoDokoncenoAno = TRUE;
        } else {
            $zadanoDokoncenoAno = FALSE;            
        }
        if ($this->context[$nameDokonceno] == 'Ne') {
            $zadanoDokoncenoNe = TRUE;
        } else {
            $zadanoDokoncenoNe = FALSE;            
        }    
        $nameDatumCertif = self::MODEL_UKONCENI.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.'datum_certif';
        $nameDatumUkonceni = self::MODEL_UKONCENI.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.'datum_ukonceni';
        $idBlokDuvod = 'idDuvodSelect';
        if ($this->context[$nameDatumUkonceni]) {
            $displayBlokDuvod = 'block';            
        } else {
            $displayBlokDuvod = 'none';
        }
        $zobrazBlokUspesneNeuspesnePodporenySCertifikatem = $this->context['s_certifikatem'];
        $idBlokHodnoceni = 'idBlokHodnoceni';
        // blok úspěšně/neúspěšně se nezobrazuje nebo se zobrazuje a je zadáno dokončeno (buď ano nebo ne)
        if ($zadanoDokoncenoAno OR $zadanoDokoncenoNe) {
            $displayBlokHodnoceni = 'block';            
        } else {
            $displayBlokHodnoceni = 'none';
        }         
        
        $this->parts[] = '<div>';
        $this->parts[] = '<H3>'.$this->context['nadpis'].'</H3>';
        $this->parts[] = '<form method="POST" action="index.php?akce=form&form='.$this->context['formAction'].'" name="form_ukonc">';

            $this->parts[] = '<fieldset>';
            $this->parts[] = '<legend>Ukončení účasti v projektu</legend>';
                // fieladset datum a důvod ukončení účasti
                $this->parts[] = '<fieldset>';
                $this->parts[] = '<legend>Datum a důvod ukončení účasti</legend>';          
                    $this->parts[] = '<p>Datum ukončení účasti v projektu:';
                        $this->parts[] = '<input '
                            . 'type="date" name="'.$nameDatumUkonceni.'" '
                            . 'size="10" maxlength="10" '
                            . 'value="'.$this->context[$nameDatumUkonceni].'" '
                            . $requiredAttribute
                            . 'onChange="showIfNotEmpty(\''.$idBlokDuvod.'\', this);" >';
                    $this->parts[] = '</p>';
                    // span důvod
                    $this->parts[] = '<span id="'.$idBlokDuvod.'" style="display:'.$displayBlokDuvod.'">';
                        $this->parts[] = '<p>Důvod ukončení účasti v projektu:';
                            $viewSelect = new Projektor2_View_HTML_Element_Select($this->context);
                            $name = self::MODEL_UKONCENI.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.'duvod_ukonceni';
                            $viewSelect->assign('selectId', 'ukonceni')
                                    ->assign('selectName', $name)
                                    ->assign('valuesArray', $this->context['duvodUkonceniValuesArray'])
                                    ->assign('actualValue', $this->context[$name])
                                    ->assign('required', TRUE);  //funkční jen pro prázdnou hodnotu v prvním option
                            $this->parts[] = $viewSelect;
                        $this->parts[] ='</p>';

                        $this->parts[] = '<p>Podrobnější popis důvodu ukončení - vyplňujte pouze v případech 2b, 3a a 3b:</p>';
                        $this->parts[] = '<p>';  
                            $this->parts[] = '<input ID="popis_ukonceni" type="text" name="'.self::MODEL_UKONCENI.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.'popis_ukonceni" size="120" maxlength="120" value="'.$this->context[self::MODEL_UKONCENI.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.'popis_ukonceni'].'">';
                        $this->parts[] = '</p>'; 
                        $this->parts[] = '<span class="help">Ukončení účasti účastníka v projektu může nastat:<br>';
                            foreach ($this->context['duvodUkonceniHelpArray'] as $helpTextRow) {
                                $this->parts[] = '<p>'.$helpTextRow.'</p>';
                            }
                        $this->parts[] = '</span>';
                    $this->parts[] = '</span>';
                $this->parts[] ='</fieldset>';
                // blok uspesne/neuspesne podporeny
                $this->parts[] ='<fieldset>';
                if ($zobrazBlokUspesneNeuspesnePodporenySCertifikatem) {
                    $this->parts[] = '<legend>Úspěšnost a certifikát</legend>';            
                        $this->parts[] ='<label for="'.$nameDokonceno.'-ano" >Úspěšně podpořená osoba: </label>'
                                . '<input type="radio" '
                                . 'id="'.$nameDokonceno.'-ano" '
                                . 'name="'.$nameDokonceno.'" '
                                . 'value="Ano" '
                                . ($zadanoDokoncenoAno ? $checkedAttribute : '')
                                . $requiredAttribute
                                . ' onClick="show(\'idBlokCertifikat\');show(\''.$idBlokHodnoceni.'\');">';
                        $this->parts[] ='<label for="'.$nameDokonceno.'-ne" >Neúspěšně podpořená osoba: </label>'
                                .'<input type="radio" '
                                . 'id="'.$nameDokonceno.'-ne" '
                                . 'name="'.$nameDokonceno.'" '
                                . 'value="Ne" '
                                . ($zadanoDokoncenoNe ? $checkedAttribute : '')
                                . $requiredAttribute
                                . ' onClick="hide(\'idBlokCertifikat\');show(\''.$idBlokHodnoceni.'\');">';                    
                        // certifikat
                        $viewCertifikat = new Projektor2_View_HTML_Element_DatumATlacitkoCertifikat();
                        if (isset($this->context['readonly'])) {
                            $viewCertifikat->assign('readonly', $this->context['readonly']);
                        }
                        $viewCertifikat->assign('idBlokCertifikat', 'idBlokCertifikat');
                        $viewCertifikat->assign('nameDatumCertif', $nameDatumCertif);
                        $viewCertifikat->assign('valueDatumCertif', $this->context[$nameDatumCertif]);
                        $viewCertifikat->assign('druhKurzu', 'projekt');
                        if ($zadanoDokoncenoAno) {
                            $viewCertifikat->assign('displayBlokCertifikat', 'block');
                        } else {
                            $viewCertifikat->assign('displayBlokCertifikat', 'none');            
                        }
                        // projektový certifikát se z projektoru tiskne vždy
                        $viewCertifikat->assign('zobrazTiskniCertifikat', TRUE);                        
                        
                        $this->parts[] = $viewCertifikat;
                } else {
                    $this->parts[] = '<legend>Úspěšnost</legend>';            
                        $this->parts[] ='<label for="'.$nameDokonceno.'-ano" >Úspěšně podpořená osoba: </label>'
                                . '<input type="radio" '
                                . 'id="'.$nameDokonceno.'-ano" '
                                . 'name="'.$nameDokonceno.'" '
                                . 'value="Ano" '
                                . ($zadanoDokoncenoAno ? $checkedAttribute : '')
                                . $requiredAttribute
                                . ' onClick="show(\''.$idBlokHodnoceni.'\');">';
                        $this->parts[] ='<label for="'.$nameDokonceno.'-ne" >Neúspěšně podpořená osoba: </label>'
                                .'<input type="radio" '
                                . 'id="'.$nameDokonceno.'-ne" '
                                . 'name="'.$nameDokonceno.'" '
                                . 'value="Ne" '
                                . ($zadanoDokoncenoNe ? $checkedAttribute : '')
                                . $requiredAttribute
                                . ' onClick="show(\''.$idBlokHodnoceni.'\');">';                    
                }
                $this->parts[] ='</fieldset>';  

                // blok hodnocení
                $this->parts[] = '<span id="'.$idBlokHodnoceni.'" style="display:'.$displayBlokHodnoceni.'">';
                    // hodnocení kurzy
                    $kurzyPlan = $this->context['kurzyPlan'];
                    if (isset($this->context['kurzyModels']) AND $this->context['kurzyModels']) {
                        foreach ($this->context['kurzyModels'] as $druhKurzu=>$sKurzyJednohoDruhu) {
                            $view = new Projektor2_View_HTML_Element_HodnoceniFieldset($this->context);    
                            $view->assign('planPrefix', self::MODEL_PLAN)
                                ->assign('ukonceniPrefix', self::MODEL_UKONCENI)
                                ->assign('druhKurzu', $druhKurzu)
                                ->assign('modelsArray', $sKurzyJednohoDruhu)
                                ->assign('returnedModelProperty', 'id')
                                ->assign('aktivita', $this->context['aktivityProjektuTypuKurz'][$druhKurzu])
                                ->assign('kurzPlan', $kurzyPlan[$druhKurzu])
                                ->assign('readonly', FALSE);
                            $this->parts[] = $view; 
                        }
                    }
                    // hodnocení poradenství
                    if (isset($this->context['aktivityProjektuTypuPoradenstvi']) AND $this->context['aktivityProjektuTypuPoradenstvi']) {
                        foreach ($this->context['aktivityProjektuTypuPoradenstvi'] as $druhKurzu => $aktivita) {
                            $view = new Projektor2_View_HTML_Element_HodnoceniFieldset($this->context);    
                            $view->assign('ukonceniPrefix', self::MODEL_UKONCENI)
                                ->assign('druhKurzu', $druhKurzu)
                                ->assign('aktivita', $this->context['aktivityProjektuTypuPoradenstvi'][$druhKurzu])
                                ->assign('readonly', FALSE);
                            $this->parts[] = $view;                 
                        }
                    }
                    // Příloha
                    $this->parts[] ='<fieldset>';
                    $this->parts[] = '<legend>Příloha</legend>'; 
                        $this->parts[] = '<p>V případě, že nebylo možné získat podpis účastníka, uveďte zde důvod:</p>';
                        $this->parts[] = '<p>';
                            $this->parts[] = '<input ID="neni_podpis" type="text" name="'.self::MODEL_UKONCENI.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.'neni_podpis" size="120" maxlength="120" value="'.$this->context[self::MODEL_UKONCENI.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.'neni_podpis'].'">';
                        $this->parts[] = '</p>';      
                        $this->parts[] = '<p>Příloha:';
                            $this->parts[] = '<input ID="priloha" type="text" name="'.self::MODEL_UKONCENI.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.'priloha" size="120" maxlength="120" value="'.$this->context[self::MODEL_UKONCENI.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.'priloha'].'"> (zde uveďte typ přílohy)';
                        $this->parts[] = '</p>';     
                $this->parts[] = '</span>';
                $this->parts[] = '</span>';
            $this->parts[] = '</fieldset>'; 
            // datumy
            $this->parts[] = '<p>Datum vytvoření:';
                $this->parts[] = '<input ID="datum_vytvor_dok" type="date" name="'.self::MODEL_UKONCENI.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.'datum_vytvor_dok_ukonc" size="8" maxlength="10" value="'
                        .$this->context[self::MODEL_UKONCENI.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.'datum_vytvor_dok_ukonc'].'" required >';
            $this->parts[] = '</p>';
            // submit
            $this->parts[] = '<p>';
                $this->parts[] = isset($this->context['submitUloz']) ? '<input type="submit" value="'.$this->context['submitUloz']['value'].'" name="'.$this->context['submitUloz']['name'].'">&nbsp;&nbsp;&nbsp;</p> ' : '';
                $this->parts[] = '<input type="reset" value="Zruš provedené změny" name="dummy">';
            $this->parts[] = '</p>';
            if ($this->context[self::MODEL_UKONCENI.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.'id_zajemce']){
                $this->parts[] = isset($this->context['submitTiskIP2']) ? '<p><input type="submit" value="'.$this->context['submitTiskIP2']['value'].'" name="'.$this->context['submitTiskIP2']['name'].'">&nbsp;&nbsp;&nbsp;</p> ' : '';
                $this->parts[] = isset($this->context['submitTiskIP2Hodnoceni']) ? '<p><input type="submit" value="'.$this->context['submitTiskIP2Hodnoceni']['value'].'" name="'.$this->context['submitTiskIP2Hodnoceni']['name'].'">&nbsp;&nbsp;&nbsp;</p> ' : '';
                $this->parts[] = isset($this->context['submitTiskUkonceni']) ? '<p><input type="submit" value="'.$this->context['submitTiskUkonceni']['value'].'" name="'.$this->context['submitTiskUkonceni']['name'].'">&nbsp;&nbsp;&nbsp;</p> ' : '';
            }
        $this->parts[] = '</form>';
        $this->parts[] = '</div>';
        return $this;
    }
}

