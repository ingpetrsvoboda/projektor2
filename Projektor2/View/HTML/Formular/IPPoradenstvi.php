<?php
/**
 * Třída Projektor2_View_HTML_ApIPPoradenství zabaluje původní PHP4 kód do objektu. Funkčně se jedná o konponentu View, 
 * na základě dat předaných konstruktoru a šablony obsažené v metodě display() generuje HTML výstup
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Formular_IPPoradenstvi extends Projektor2_View_HTML_FormularPHP4 {
    
    // NEDODĚLANÝ KOUSEK - JEN JSEM HO PŘESUNUL DO SLOŽKY FORMULAR!!
    
    
    
    
    /**
     * Metoda obsahuje php kod (ve stylu PHP4), který užívá PHP jako šablonovací jazyk. Na základě dat zadaných v konstruktoru 
     * do paramentru $context metoda generuje přímo html výstup. Metoda nemá návratovou hodnotu.
     */
    public function display() {
        $pole = $this->context;
        // nadpis je v původním kódu někde v inc - přesunout nadpisy vždy sem
        echo '<H3>INDIVIDUÁLNÍ PLÁN ÚČASTNÍKA PROJEKTU Alternativní práce</H3>';
        echo '<H4>Plán poradenských aktivit</H4>';
        echo '<form method="POST" action="index.php?akce=form&form=ap_porad_uc" name="form_porad">';
        
        $aktivity = Projektor2_AppContext::getAktivityProjektu('AP');   
        foreach ($aktivity as $druh=>$aktivita) {
            if ($aktivita['typ']=='poradenstvi') {
                $name = 'poranenstvi->'.$druh;
                echo Projektor2_View_HTML_Element_PlanFieldset::renderFieldsetPoradenstvi($this->context, 'zaPlanPoradnestvi->id_s_kurz_FK', $this->context['poradenstvi_'.$druh], 'id', $aktivita['nadpis'], FALSE, $aktivita['s_certifikatem']);
            }
        }        
        
     //dále následuje původní kód 
?>

<br>
<p>Datum vytvoření:
    <input ID="datum_vytvor_dok" type="date" name="datum_upravy_dok_plan" size="8" maxlength="10" value="<?php
                                        if (@$pole['datum_upravy_dok_plan']) {echo @$pole['datum_upravy_dok_plan'];}
                                        ?>">
</p>
<p>
    <input type="submit" value="Uložit" name="save">&nbsp;&nbsp;&nbsp;
    <input type="reset" value="Zruš provedené změny" name="reset">
</p>
<?php
    //TISK
    if ($pole['id_zajemce']){
        echo ('<p><input type="submit" value="Tiskni IP 1.část - doplnění" name="pdf">&nbsp;&nbsp;&nbsp;</p> ');        
    }
?>
</form>
<?php        
    }
}
?>
