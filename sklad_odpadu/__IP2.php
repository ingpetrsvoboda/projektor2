<?php
/**
 * Třída Projektor2_View_HTML_HeSouhlas zabaluje původní PHP4 kód do objektu. Funkčně se jedná o konponentu View, 
 * na základě dat předaných konstruktoru a šablony obsažené v metodě display() generuje HTML výstup
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Help_IP2 extends Framework_View_Abstract {
    
    const MODEL_UKONCENI = 'ukonceni';
    
    public function render() {
        $html[] = '<div>';
        $html[] = '<H3>UKONČENÍ ÚČASTI V PROJEKTU A DOPLNĚNÍ IP2</H3>';
        $html[] = '<form method="POST" action="index.php?akce=form&form=he_ukonceni_uc&save=1" name="form_ukonc">';

        $html[] = '<FIELDSET><LEGEND>Ukončení účasti v projektu</LEGEND>';
        $html[] = '<p>Datum ukončení účasti v projektu:';
        $html[] = '<input type="date" name="'.self::MODEL_UKONCENI.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.'datum_ukonceni" size="10" maxlength="10" value="'.$this->context[self::MODEL_UKONCENI.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.'datum_ukonceni'].'" required>';
        $html[] = '</p>';
        
        $html[] = '<p>Důvod ukončení účasti v projektu:';
        $valuesArray = array(
                '-------------',
                '1 | Řádné absolvování projektu',
                '2a | Nástupem do pracovního poměru',
                '2b | Výpovědí nebo jiným ukončení smlouvy ze strany účastníka',
                '3a | Pro porušování podmínek účasti v projektu',
                '3b | Na základě podnětu ÚP'
                );

        $viewSelect = new Projektor2_View_HTML_Element_Select($this->context);
        $viewSelect->assign('contextIndexName', self::MODEL_UKONCENI.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.'duvod_ukonceni');
        $viewSelect->assign('valuesArray', $valuesArray);
        $html[] = $viewSelect;
        $html[] = '</p>';
        
        $html[] = '<p>Podrobnější popis důvodu ukončení - vyplňujte pouze v případech 2b, 3a a 3b:</p>';
        $html[] = '</p>';  
        $html[] = '<input ID="popis_ukonceni" type="text" name="'.self::MODEL_UKONCENI.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.'popis_ukonceni" size="120" maxlength="120" value="'.$this->context[self::MODEL_UKONCENI.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.'popis_ukonceni'].'">';
        $html[] = '</p>'; 
        $html[] = '        
                <span class="help">Ukončení účasti účastníka v projektu může nastat:<br>
                1. řádné absolvování projektu<br>
                2. předčasným ukončením účasti ze strany účastníka<br>
                &nbsp;&nbsp;a.      dnem předcházejícím nástupu účastníka do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)<br>
                &nbsp;&nbsp;b.      výpovědí dohody o účasti v projektu účastníkem nebo ukončením dohody z jiného důvodu než nástupu do zaměstnání (ukončení bude dnem, kdy byla výpověď doručena zástupci dodavatele) <br>
                3. předčasným ukončením účasti ze strany dodavatele<br>
                &nbsp;&nbsp;a.       pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu<br>
                &nbsp;&nbsp;b.       ve výjimečných případech na základě podnětu vysílajícího ÚP, např. při sankčním vyřazení z evidence ÚP (ukončení bude v pracovní den předcházející dni vzniku důvodu ukončení)<br>
                </span>        
            ';
        
        $html[] = '<p>';
            $aktivity = Projektor2_AppContext::getAktivityProjektu('HELP');   
            foreach ($aktivity as $druh=>$aktivita) {
                if ($aktivita['typ']=='kurz') {
                    $view = new Projektor2_View_HTML_Element_HodnoceniFieldset($this->context);    
                    $view->assign('planPrefix', self::MODEL_UKONCENI);
                    $view->assign('druh', $druh);
                    $view->assign('modelsArray', $this->context['kurzy_'.$druh]);
                    $view->assign('returnedModelProperty', 'id');
                    $view->assign('aktivita', $aktivita);
                    $view->assign('readonly', FALSE);
                    $view->assign('help', TRUE);
                    $html[] = $view;                     
                }
            } 
        $html[] = '</p>';
        $html[] = '<p>V případě, že nebylo možné získat podpis účastníka, uveďte zde důvod:</p>
          <p><input ID="neni_podpis" type="text" name="'.self::MODEL_UKONCENI.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.'neni_podpis" size="120" maxlength="120" value="'.$this->context[self::MODEL_UKONCENI.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.'neni_podpis'].'"></p>';      
        $html[] = '<p>
          Příloha:
          <input ID="priloha" type="text" name="'.self::MODEL_UKONCENI.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.'priloha" size="120" maxlength="120" value="'.$this->context[self::MODEL_UKONCENI.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.'priloha'].'"> (zde uveďte typ přílohy)
          </p>';       
        $html[] = '</FIELDSET> 
        <p>Datum vytvoření:
        <input ID="datum_vytvor_dok" type="date" name="'.self::MODEL_UKONCENI.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.'datum_vytvor_dok_ukonc" size="8" maxlength="10" value="'
                .$this->context[self::MODEL_UKONCENI.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.'datum_vytvor_dok_ukonc'].'" required > 
        </p>';

        $html[] = '<p><input type="submit" value="Uložit" name="B1">&nbsp;&nbsp;&nbsp; 
        <input type="reset" value="Zruš provedené změny" name="B2">
        </p>';
        //TISK
           if ($this->context[self::MODEL_UKONCENI.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.'id_zajemce']){
                $html[] = '<p><input type="submit" value="Tiskni IP 2.část" name="pdf">&nbsp;&nbsp;&nbsp;</p> ';
                $html[] = '<p><input type="submit" value="Tiskni ukončení účasti" name="pdf">&nbsp;&nbsp;&nbsp;</p> ';
           }
        $html[] = '</form>';
        $html[] = '</div>';
        return $this->convertToString($html);
    }
}
