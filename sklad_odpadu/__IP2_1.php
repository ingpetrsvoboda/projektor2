<?php
/**
 * Třída Projektor2_View_HTML_HeSouhlas zabaluje původní PHP4 kód do objektu. Funkčně se jedná o konponentu View, 
 * na základě dat předaných konstruktoru a šablony obsažené v metodě display() generuje HTML výstup
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Sjzp_IP2 extends Projektor2_View_HTML_FormularPHP4 {
    
    /**
     * Metoda obsahuje php kod (ve stylu PHP4) kombinovaný s HTML, který užívá PHP jako šablonovací jazyk. Na základě dat zadaných v konstruktoru 
     * do paramentru $context metoda generuje přímo html na výstup. Metoda nemá návratovou hodnotu.
     */
    public function display() {
        $pole = $this->context;
    // nadpis je v původním kódu někde v inc - přesunout nadpisy vždy sem
    echo '<H3>UKONČENÍ ÚČASTI V PROJEKTU A DOPLNĚNÍ IP - 2. část</H3>';
    //form
    echo '<form method="POST" action="index.php?akce=form&form=sjzp_ukonceni_uc&save=1" name="form_ukonc">';
     //dále následuje původní kód 
    ?>
<FIELDSET><LEGEND>Ukončení účasti v projektu</LEGEND>
  <p>
  Datum ukončení účasti v projektu: 
  <input ID="datum_ukonceni" type="date" name="ukonceni->datum_ukonceni" size="10" maxlength="10" value="<?php echo @$pole['ukonceni->datum_ukonceni'];?>" required>
  </p>
  
  <p>
  Důvod ukončení účasti v projektu: 
    <select size="1" name="ukonceni->duvod_ukonceni">
    <option <?php if (@$pole['ukonceni->duvod_ukonceni'] == trim( '-------------')){echo 'selected';} ?>>-------------</option>
    <option <?php if (@$pole['ukonceni->duvod_ukonceni'] == trim( '1 | Řádné absolvování projektu')){echo 'selected';} ?>>1 | Řádné absolvování projektu</option>
    <option <?php if (@$pole['ukonceni->duvod_ukonceni'] == trim( '2a | Nástupem do pracovního poměru')){echo 'selected';} ?>>2a | Nástupem do pracovního poměru</option>
    <option <?php if (@$pole['ukonceni->duvod_ukonceni'] == trim( '2b | Výpovědí nebo jiným ukončení smlouvy ze strany účastníka')){echo 'selected';} ?>>2b | Výpovědí nebo jiným ukončení smlouvy ze strany účastníka</option>
    <option <?php if (@$pole['ukonceni->duvod_ukonceni'] == trim( '3a | Pro porušování podmínek účasti v projektu')){echo 'selected';} ?>>3a | Pro porušování podmínek účasti v projektu</option>
    <option <?php if (@$pole['ukonceni->duvod_ukonceni'] == trim( '3b | Na základě podnětu ÚP')){echo 'selected';} ?>>3b | Na základě podnětu ÚP</option>
    </select> <br>
  </p>  
  <p>      
  Podrobnější popis důvodu ukončení - vyplňujte pouze v případech 2b, 3a a 3b:<br>
  <input ID="popis_ukonceni" type="text" name="ukonceni->popis_ukonceni" size="120" maxlength="120" value="<?php echo @$pole['ukonceni->popis_ukonceni'];?>">
  </p>  
   <?php 
      echo '
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

 ?>

  <p>
   <?php 
    $aktivity = Projektor2_AppContext::getAktivityProjektu('AP');   
    foreach ($aktivity as $druh=>$aktivita) {
        if ($aktivita['typ']=='kurz') {
            echo Projektor2_View_HTML_Element_PlanFieldset::renderFieldsetKurz($this->context, 'plan', $druh, $this->context['kurzy_'.$druh], 'id', $aktivita['nadpis'], FALSE, $aktivita['s_certifikatem']);
        }
    } 
   ?> 
  
  <!--############################################################################## //-->
  
  <p>
  V případě, že nebylo možné získat podpis účastníka, uveďte zde důvod:<br>
  <input ID="neni_podpis" type="text" name="ukonceni->neni_podpis" size="120" maxlength="120" value="<?php echo @$pole['ukonceni->neni_podpis'];?>">
  </p>      
  <p>
  Příloha:
  <input ID="priloha" type="text" name="ukonceni->priloha" size="120" maxlength="120" value="<?php echo @$pole['ukonceni->priloha'];?>"> (zde uveďte typ přílohy)
  </p>       
</FIELDSET> 


<?php
  //************** KOLIZE ******************* 
  Projektor2_Table_UcKolizeData::Vypis_kolize_formulare_dosud_nezavolane($id_ucastnik,FORMULAR_HE_UKONC,$zavolane_kolize_v_ukonc) ;
  //************** KOLIZE ******************* 
?> 



<p>Datum vytvoření:
<input ID="datum_vytvor_dok" type="date" name="ukonceni->datum_vytvor_dok_ukonc" size="8" maxlength="10" value="<?php
                                        if (@$pole['ukonceni->datum_vytvor_dok_ukonc']) {echo @$pole['ukonceni->datum_vytvor_dok_ukonc'];}
                                        ?>" required > 
</p>

<p><input type="submit" value="Uložit" name="B1">&nbsp;&nbsp;&nbsp; 
<input type="reset" value="Zruš provedené změny" name="B2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</p>

<?php
//TISK
   if ($pole['ukonceni->id_zajemce']){
        echo ('<p><input type="submit" value="Tiskni IP 2.část - vyhodnocení aktivit" name="pdf">&nbsp;&nbsp;&nbsp;</p> ');
        echo ('<p><input type="submit" value="Tiskni ukončení účasti" name="pdf">&nbsp;&nbsp;&nbsp;</p> ');
   }
?>

  </form>
<?php        
    }
}

?>
