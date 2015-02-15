<?php
//echo "<BR> za_ind_zam_uc.inc";
//echo "<BR>\$_COOKIE: ";
//print_r ($_COOKIE);




$id_zajemce = false;
if(isset($_GET['id_zajemce'])) {
    $id_zajemce = $_GET['id_zajemce'];
    $pole=array();
}
else if (isset($Zajemce->id)) {
    $id_zajemce = $Zajemce->id;
}


If($id_zajemce){
    //echo "<BR>*ind_.inc - \$id_zajemce je " . $id_zajemce ;
    
    If($Zajemce = Projektor2_Model_Db_ZajemceMapper::findById($id_zajemce, $dbh)) {
        setcookie("id_zajemce",$Zajemce->id);
        
        $Flat_tab = new Projektor2_Model_Db_Flat_ZaFlatTable($Zajemce);         // !! tab. uc_flat_table !ctu z ni jmeno pro zobrazeni!
        $Flat_tab->read_values();
        $Flat_tab_data = $Flat_tab->getValuesAssoc();
        Foreach($Flat_tab_data as $key => $values) {
           // if(!array_key_exists($key,$pole)){
           //     $pole[$key]=$values;                      
           // }
           $pole_pro_zobrazeni[$key]=$values;   
        }     
       
       /*
        $Flat_tab = new Flat_ PlanFlatTable($Ucastnik , $dbh);         // !! tab. uc_plan_flat_table !ctu z ni údaje z plánu pro zobrazeni!
        $Flat_tab->read_values();
        $Flat_tab_data = $Flat_tab->get_values_assoc();
        Foreach($Flat_tab_data as $key => $values) {
           // if(!array_key_exists($key,$pole)){
           //     $pole[$key]=$values;                      
           // }
           $pole_pro_zobrazeni[$key]=$values;   
        }  
     */ 
               
        $Flat_table = new Projektor2_Model_Db_Flat_ZaZamFlatTable($Zajemce, $dbh);         // !! tab. uc_ukonc_flat_table
        $Flat_table->read_values();
        $Flat_table_data = $Flat_table->getValuesAssoc();
        Foreach($Flat_table_data as $key => $values) {
           // if(!array_key_exists($key,$pole)){
           //     $pole[$key]=$values;                        //polozky v $pole
           // }
           $pole[$key]=$values;   
        }
    //    echo "<br>*zajemce-cislo* " ;  echo($Zajemce->cislo);
    //    echo "<br>*flat table*" .  "<br>";
    
    //    print_r($Flat_table->get_values_assoc());
    //    echo "<BR>**<BR>";
    //    print_r($pole);
        //Zobrazení navigace
?>
        
        
<?php

        //Zobrazeni stavové informace
?>
        
        <ul id="menu">
            <li><a href="index.php?akce=agp_zobraz_reg">Zpět na výběr zájemce</a></li>
        </ul>        
        <table border="0">
        <tr>
            <td><h2><b>Zájemce: </b><?php echo $pole_pro_zobrazeni['titul']." ".$pole_pro_zobrazeni['jmeno']." ".$pole_pro_zobrazeni['prijmeni'] ?></h2></td>
        </tr>
        <tr>
            <td><h3>Číslo zájemce: <?php echo $Zajemce->identifikator; ?> </td>
          
        </tr>
        <hr>
        </table>
<?php        
    }
    
}
else {
    //echo "<BR>ind_.inc - \$id_zajemce je false " . $id_zajemce;
    setcookie("id_zajemce");
}


if ( ($User->username == "sys_admin" ))  {
    echo "<BR>a *id_zajemce je " . $id_zajemce . "<BR>";
} 

?>
<ul id="menu">
        <hr>
            <li><a href="index.php?akce=unset_beh">Zpět na výběr turnusu</a></li>     
        </ul>
</center>
            
<H3>ZÁZNAM DO EVIDENCE ZAMĚSTNAVATELŮ</H3>


<!-- **** zde lze zobrazovat pole nactena z uc_flat_table , jsou v promenne $pole_pro_zobrazeni***
     **** tato pole se neposilaji POSTem *** -->
<!--
<p>
  Titul: <input ID="titul" disabled type="text" name="titul" size="3" maxlength="10" value="<?php echo @$pole_pro_zobrazeni['titul'];?>">
  Jméno: <input ID="jmeno" disabled type="text" name="jmeno" size="20" maxlength="50" value="<?php echo @$pole_pro_zobrazeni['jmeno'];?>">
  Příjmení: <input ID="prijmeni"  disabled type="text" name="prijmeni" size="20" maxlength="50" value="<?php echo @$pole_pro_zobrazeni['prijmeni'];?>">
</p>
-->
<!-- *************************************** -->

<?php
    if ( isset($_GET['id_zajemce']) ) {
    ?>
    <form method="POST" action="index.php?akce=agp_zam_uc&save=1&id_zajemce= <?php 
    echo $id_zajemce.'">';        
    } else {
    ?>
    <form method="POST" action="index.php?akce=agp_zam_uc&save=1">
    <?php       
    }
    
    $zavolane_kolize_v_zam =array();
    $Kolize_Lokace="zacatekformulare";  
    //************** KOLIZE zjistovani kolizi pro tento formular a lokaci, pomoci definici v tabulce s_typ_kolize *****************
       Projektor2_Table_UcKolizeData::Vypis_kolize_pro_formular_a_lokaci($id_zajemce,FORMULAR_ZA_ZAM,$Kolize_Lokace);
    //************** KOLIZE zjistovani kolizi pro tento formular a lokaci, pomoci definici v tabulce s_typ_kolize - konec *********
     $zavolane_kolize_v_zam= array_merge($zavolane_kolize_v_zam,Projektor2_Table_UcKolizeData::$zjistovane_kolize);
    ?>
    
<!--
<p>
  Datum zahájení účasti v projektu: <?php  /* echo  $pole_pro_zobrazeni['datum_reg'] */ ?>
</p> -->




<p>
  Nově vytvořené pracovní místo: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
  <input ID="zam_nove_misto_ano" type="radio" name="zam_nove_misto" value="Ano" <?php if (@$pole['zam_nove_misto'] == 'Ano') {echo 'checked';} ?>>
  Ano &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <input ID="zam_nove_misto_ne" type="radio" value="Ne" name="zam_nove_misto" <?php if (@$pole['zam_nove_misto'] == 'Ne') {echo 'checked';} ?>>
  Ne<br>
</p>


<p>
  Forma zaměstnání: 
      
     <input ID="zam_forma" type="text" name="zam_forma" size="50" maxlength="50" value="<?php echo @$pole['zam_forma'];?>">
  </p>

<p>
  Datum nástupu do zaměstnání: 
  <input ID="zam_datum_vstupu" type="text" name="zam_datum_vstupu" size="10" maxlength="10" value="<?php echo @$pole['zam_datum_vstupu'];?>">
</p>


    
<FIELDSET style="width:;"><LEGEND><b>Údaje o zaměstnavateli</b></LEGEND>
  <p>
  Název zaměstnavatele:
  <input ID="zam_nazev" type="text" name="zam_nazev" size="120" maxlength="255" value="<?php echo @$pole['zam_nazev'];?>">

  <br>IČ:
  <input ID="zam_ic" type="text" name="zam_ic" size="20" maxlength="20" value="<?php echo @$pole['zam_ic'];?>"> 
 </p> 
  
  <p>
  Adresa zaměstnavatele:<br>  
  Město:
  <input ID="zam_mesto" type="text" name="zam_mesto" size="30" maxlength="50" value="<?php echo @$pole['zam_mesto'];?>">
  
  Ulice:
  <input ID="zam_ulice" type="text" name="zam_ulice" size="50" maxlength="50" value="<?php echo @$pole['zam_ulice'];?>">
  
  PSČ: <input ID="zam_psc" type="text" name="zam_psc" size="5" maxlength="5" value="<?php echo @$pole['zam_psc'];?>">
  </p>

</FIELDSET>
<br><br><br>
   


<FIELDSET><LEGEND></LEGEND>
  <p>
  Pro případ, že forma zaměstnání je dohoda o provedení práce (DPP) nebo dohoda o pracovní činnosti (DPČ),<br>
  doplňte informace o <b>případném navazujícím pracovním poměru (na základě pracovní smlouvy) uzavřeném v návaznosti na DPP nebo DPČ</b>:<br>
  </p>
  <p>
  Datum nástupu do zaměstnání: 
  <input ID="zam_navazujici_datum_vstupu" type="text" name="zam_navazujici_datum_vstupu" size="10" maxlength="10" value="<?php echo @$pole['zam_navazujici_datum_vstupu'];?>">
 </p>

   
<FIELDSET><LEGEND><b>Údaje o zaměstnavateli</b></LEGEND>
  <p>
  Název zaměstnavatele:
  <input ID="zam_navazujici_nazev" type="text" name="zam_navazujici_nazev" size="120" maxlength="255" value="<?php echo @$pole['zam_navazujici_nazev'];?>">

  <br>IČ:
  <input ID="zam_navazujici_ic" type="text" name="zam_navazujici_ic" size="20" maxlength="20" value="<?php echo @$pole['zam_navazujici_ic'];?>"> 
 </p> 
  
  <p>
  Adresa zaměstnavatele:<br>  
  Město:
  <input ID="zam_navazujici_mesto" type="text" name="zam_navazujici_mesto" size="30" maxlength="50" value="<?php echo @$pole['zam_navazujici_mesto'];?>">
  
  Ulice:
  <input ID="zam_navazujici_ulice" type="text" name="zam_navazujici_ulice" size="50" maxlength="50" value="<?php echo @$pole['zam_navazujici_ulice'];?>">
  
  PSČ: <input ID="zam_navazujici_psc" type="text" name="zam_navazujici_psc" size="5" maxlength="5" value="<?php echo @$pole['zam_navazujici_psc'];?>">
  </p>

</FIELDSET>    
</FIELDSET>    
<br> <br>   
    
    
    

<?php
  //************** KOLIZE ******************* 
  Projektor2_Table_UcKolizeData::Vypis_kolize_formulare_dosud_nezavolane($id_zajemce,FORMULAR_ZA_ZAM,$zavolane_kolize_v_zam) ;
  //************** KOLIZE ******************* 
?> 

<!--
<p>Datum vytvoření:
<input ID="datum_vytvor_dok" type="text" name="datum_vytvor_dok" size="8" maxlength="10" value="<?php  /*
                                        if (@$pole['datum_vytvor_dok']) {echo @$pole['datum_vytvor_dok'];}
                                        else {echo date("d.m.Y"); }
                    */ ?>">
</p>  -->

<p>
  <!-- <input type="submit" value="Uložit" name="B1">&nbsp;&nbsp;&nbsp; -->
<input type="reset" value="Zruš provedené změny" name="B2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</p>


<?php
 
?>


  </form>
  <ul id="menu">
     <li><a href="index.php?akce=agp_zobraz_reg">Zpět na výběr zájemce</a></li>
  </ul>  