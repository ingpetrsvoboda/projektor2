<?php
/**
 * Třída Projektor2_View_HTML_HeSmlouva zabaluje původní PHP4 kód do objektu. Funkčně se jedná o konponentu View, 
 * na základě dat předaných konstruktoru a šablony obsažené v metodě display() generuje HTML výstup
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Ap_Smlouva extends Projektor2_View_HTML_FormularPHP4 {
    /**
     * Metoda obsahuje php kod (ve stylu PHP4), který užívá PHP jako šablonovací jazyk. Na základě dat zadaných v konstruktoru 
     * do paramentru $context metoda generuje přímo html výstup. Metoda nemá návratovou hodnotu.
     */
    public function display() {
        $pole = $this->context;
    // nadpis je v původním kódu někde v inc - přesunout nadpisy vždy sem
    echo '<H3>SMLOUVA O ÚČASTI V PROJEKTU</H3>';

    echo '<form method="POST" action="index.php?akce=form&form=ap_sml_uc" name="smlouva->form_sml">';

     //dále následuje původní kód 
?>
<FIELDSET style=""><LEGEND><b>Osobní údaje</b></LEGEND>

  Titul: <input ID="titul" type="text" name="smlouva->titul" size="3" maxlength="10" value="<?php echo @$pole['smlouva->titul'];?>">
  Jméno: <input ID="jmeno" type="text" name="smlouva->jmeno" size="20" maxlength="50" value="<?php echo @$pole['smlouva->jmeno'];?>">
  Příjmení: <input ID="prijmeni" type="text" name="smlouva->prijmeni" size="20" maxlength="50" value="<?php echo @$pole['smlouva->prijmeni'];?>">
  Titul za: <input ID="titul_za" type="text" name="smlouva->titul_za" size="3" maxlength="10" value="<?php echo @$pole['smlouva->titul_za'];?>">
  Pohlaví: <select ID="pohlavi" size="1" name="smlouva->pohlavi">
          <option <?php if (@$pole['smlouva->pohlavi'] == '--------'){echo 'selected';} ?>>----</option>
          <option <?php if (@$pole['smlouva->pohlavi'] == 'muž'){echo 'selected';} ?>>muž</option>
          <option <?php if (@$pole['smlouva->pohlavi'] == 'žena'){echo 'selected';} ?>>žena</option>
          </select></p>
  <p>Datum narození: <input ID="datum_narozeni" type="date" name="smlouva->datum_narozeni" size="8" maxlength="10" value="<?php echo @$pole['smlouva->datum_narozeni'];?>">
    Rodné číslo: <input ID="rodne_cislo" type="text" name="smlouva->rodne_cislo" size="20" maxlength="50" value="<?php echo @$pole['smlouva->rodne_cislo'];?>"></p>
  <p></p>
</FIELDSET>

<FIELDSET><LEGEND><b>Bydliště a kontaktní údaje</b></LEGEND>
  <FIELDSET style="border-style: solid;border-color: black; border-width: 1px;margin: 4px">
  <LEGEND style="color:black;font-size: 11px"><b>Trvalé bydliště</b></LEGEND>
  <p>Město: <input ID="mesto" type="text" name="smlouva->mesto" size="20" maxlength="50" value="<?php echo @$pole['smlouva->mesto'];?>">
  Ulice: <input ID="ulice" type="text" name="smlouva->ulice" size="20" maxlength="50" value="<?php echo @$pole['smlouva->ulice'];?>">
  PSČ: <input ID="psc" type="text" name="smlouva->psc" size="5" maxlength="5" value="<?php echo @$pole['smlouva->psc'];?>">
  Pevný telefon: <input ID="pevny_telefon" type="text" name="smlouva->pevny_telefon" size="15" maxlength="20" value="<?php echo @$pole['smlouva->pevny_telefon'];?>">
  </p>
  </FIELDSET><br>
  <FIELDSET style="border-style: solid;border-color: black; border-width: 1px;margin: 4px">
  <LEGEND style="color:black;font-size: 11px"><b>Adresa dojíždění odlišná od místa bydliště</b></LEGEND>
  <p>Město: <input ID="mesto2" type="text" name="smlouva->mesto2" size="20" maxlength="50" value="<?php echo @$pole['smlouva->mesto2'];?>">
  Ulice: <input ID="ulice2" type="text" name="smlouva->ulice2" size="20" maxlength="50" value="<?php echo @$pole['smlouva->ulice2'];?>">
  PSČ: <input ID="psc2" type="text" name="smlouva->psc2" size="5" maxlength="5" value="<?php echo @$pole['smlouva->psc2'];?>">
  Pevný telefon: <input ID="pevny_telefon2" type="text" name="smlouva->pevny_telefon2" size="15" maxlength="20" value="<?php echo @$pole['smlouva->pevny_telefon2'];?>">
  </p>
  </FIELDSET>
  <p>Mobilní telefon: <input ID="mobilni_telefon" type="text" name="smlouva->mobilni_telefon" size="12" maxlength="15" value="<?php echo @$pole['smlouva->mobilni_telefon'];?>">
  Další telefony: <input ID="dalsi_telefon" type="text" name="smlouva->dalsi_telefon" size="12" maxlength="15" value="<?php echo @$pole['smlouva->dalsi_telefon'];?>">
  Popis: <input ID="popis_telefon" type="text" name="smlouva->popis_telefon" size="40" maxlength="100" value="<?php echo @$pole['smlouva->popis_telefon'];?>"></p>
  <p>e-mail: <input ID="mail" type="text" name="smlouva->mail" size="40" value="<?php echo @$pole['smlouva->mail'];?>"></p>
</FIELDSET>


<p>Datum vytvoření:
<input ID="datum_vytvor_smlouvy" type="date" name="smlouva->datum_vytvor_smlouvy" size="8" maxlength="10" value="<?php
                                        if (@$pole['smlouva->datum_vytvor_smlouvy']) {echo @$pole['smlouva->datum_vytvor_smlouvy'];}
                                        else {echo date("d.m.Y"); }
                                        ?>">
</p>

<p><input type="submit" value="Uložit" name="B1">&nbsp;&nbsp;&nbsp;
<input type="reset" value="Zruš provedené změny" name="B2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</p>
<!-- <input type="submit" value="Vytiskni Smlouvu" name="smlouva->B1">
-->
<?php
//TISK
   if ($pole['smlouva->id_zajemce']){
    echo ('<p><input type="submit" value="Tisk" name="pdf">&nbsp;&nbsp;&nbsp;</p> ');    }

?>


  </form>
<?php        
    }
}

?>
