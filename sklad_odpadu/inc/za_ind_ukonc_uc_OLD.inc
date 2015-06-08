<?php
//echo "<BR> za_ind_sml_uc.inc";
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

if ( ($User->username == "sys_admin" ))  {
    echo "<BR>*a id_zajemce je " . $id_zajemce .  "<BR>a  Projekt->kod:" . $Projekt->kod .
         "<BR>";
} 




If($id_zajemce){
    //echo "<BR>*ind_.inc - \$id_ucastnik je " . $id_ucastnik ;
    
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
        $Flat_tab = new Projektor2_Model_Db_Flat_ZaPlanFlatTable($Zajemce);         // !! tab. uc_plan_flat_table !ctu z ni údaje z plánu pro zobrazeni!
        $Flat_tab->read_values();
        $Flat_tab_data = $Flat_tab->getValuesAssoc();
        Foreach($Flat_tab_data as $key => $values) {
           // if(!array_key_exists($key,$pole)){
           //     $pole[$key]=$values;                      
           // }
           $pole_pro_zobrazeni[$key]=$values;   
        }
        // v  $pole_pro_zobrazeni jsou udaje pro zobrazeni
        
               
        $Flat_table = new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($Zajemce, $dbh);         // !! tab. uc_ukonc_flat_table
        $Flat_table->read_values();
        $Flat_table_data = $Flat_table->getValuesAssoc();
        Foreach($Flat_table_data as $key => $values) {
           // if(!array_key_exists($key,$pole)){
           //     $pole[$key]=$values;                        //polozky v $pole
           // }
           $pole[$key]=$values;   
        }
        
//  EEE        $Existuje_zaznam_v_uc_ukonc_flat_table = $Flat_table->existuje_zaznam_s_context_id();
        
        
    //    echo "<br>*ucastnik-cislo* " ;  echo($Ucastnik->cislo);
    //    echo "<br>*flat table*" .  "<br>";
    
    //    print_r($Flat_table->get_values_assoc());
    //    echo "<BR>**<BR>";
    //    print_r($pole);
        
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
?>
<ul id="menu">
        <hr>
            <li><a href="index.php?akce=unset_beh">Zpět na výběr turnusu</a></li>     
        </ul>
</center>
            
<H3>UKONČENÍ V PROJEKTU</H3>

<!-- onsubmit="ZobrazSmlouvu(<?php /*echo $Zajemce->identifikator;*/?>);" -->

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
    <form method="POST" action="index.php?akce=agp_ukonceni_uc&save=1&id_zajemce= <?php 
    echo $id_zajemce.'" name="form_ukonc">';        
    } else {
    ?>
    <form method="POST" action="index.php?akce=agp_ukonceni_uc&save=1" name="form_ukonc">
    <?php       
    }
    
    $zavolane_kolize_v_ukonc =array();
    $Kolize_Lokace="zacatekformulare";  
    //************** KOLIZE zjistovani kolizi pro tento formular a lokaci, pomoci definici v tabulce s_typ_kolize *****************
       Projektor2_Table_UcKolizeData::Vypis_kolize_pro_formular_a_lokaci($id_ucastnik,FORMULAR_ZA_UKONC,$Kolize_Lokace);
    //************** KOLIZE zjistovani kolizi pro tento formular a lokaci, pomoci definici v tabulce s_typ_kolize - konec *********
     $zavolane_kolize_v_ukonc= array_merge($zavolane_kolize_v_ukonc,Projektor2_Table_UcKolizeData::$zjistovane_kolize);
    ?>
    


    
<FIELDSET><LEGEND><b></b></LEGEND>
  <p>
  Datum zahájení účasti v projektu: <?php echo $pole_pro_zobrazeni['datum_reg'] ?>  </p>
  <p>
  Datum ukončení účasti v projektu: 
  <input ID="datum_ukonceni" type="text" name="datum_ukonceni" size="10" maxlength="10" value="<?php echo @$pole['datum_ukonceni'];?>">
  </p>
  <p>
  Důvod ukončení účasti v projektu: 
    
  
    <input ID="duvod_ukonceni" type="text" name="duvod_ukonceni" size="100" maxlength="100" value="<?php echo @$pole['duvod_ukonceni'];?>">
  <br>
  </p>
  <p>
      
  Podrobnější popis důvodu ukončení, vyplňujte pouze v případech 2b, 3a a 3b:<br>
  <input ID="popis_ukonceni" type="text" name="popis_ukonceni" size="120" maxlength="120" value="<?php echo @$pole['popis_ukonceni'];?>">
  </p>  
    
    

   <?php if ($Projekt->kod=="SPZP") {?>
                    
	<p>Ukončení účasti účastníka v projektu může nastat: 
	<ul>
	<li>1.	uplynutím doby stanovené pro účast účastníka v projektu – řádné absolvování projektu
	<li>&nbsp;&nbsp;a.	běžně v době 3 měsíce
	<li>&nbsp;&nbsp;b.	v případě účasti účastníka v profesním rekvalifikačním kurzu (tedy nikoli v kurzech Obsluha osobního počítače nebo Obsluha osobního počítače dle osnov ECDL START) nebo na praxi končí jeho účast po uplynutí 14 dní od absolvování kurzu, pokud je tato doba delší než 3 měsíce 
	<li>2.	předčasným ukončením účasti ze strany účastníka
	<li>&nbsp;&nbsp;a.	dnem předcházejícím nástupu účastníka do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)
	<li>&nbsp;&nbsp;b.	výpovědí dohody o účasti v projektu účastníkem z jiného důvodu než nástupu do zaměstnání (ukončení bude dnem, kdy byla výpověď doručena zástupci dodavatele) 
	<li>3.	předčasným ukončením účasti ze strany dodavatele
	<li>&nbsp;&nbsp;a.	pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu
	<li>&nbsp;&nbsp;b.	ve výjimečných případech na základě podnětu vysílajícího ÚP (např. při sankčním vyřazení z evidence ÚP)
	</ul>
        </p>
        
   <?php }
      if ($Projekt->kod=="RNH") { ?>
      
        <p>Ukončení účasti účastníka v projektu může nastat:
        <ul>
	<li>1. uplynutím doby stanovené pro účast účastníka v projektu – řádné absolvování projektu
        <li>&nbsp;&nbsp;a.      tato doba je 6 měsíců
        <li>&nbsp;&nbsp;b.      v případě účasti účastníka v profesním rekvalifikačním kurzu (tedy nikoli v kurzech Obsluha osobního počítače nebo Obsluha osobního počítače dle osnov ECDL START) nebo Pracovní praxi končí jeho účast po uplynutí 14 dní od absolvování kurzu či Pracovní praxe, pokud je doba jeho účasti v projektu delší než 6 měsíců 
        <li>2. předčasným ukončením účasti ze strany účastníka
        <li>&nbsp;&nbsp;a.      dnem předcházejícím nástupu účastníka do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)
        <li>&nbsp;&nbsp;b.      výpovědí dohody o účasti v projektu účastníkem z jiného důvodu než nástupu do zaměstnání (ukončení bude dnem, kdy byla výpověď doručena zástupci dodavatele) 
        <li>3. předčasným ukončením účasti ze strany dodavatele
        <li>&nbsp;&nbsp;a.       pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu
        <li>&nbsp;&nbsp;b.       ve výjimečných případech na základě podnětu vysílajícího ÚP, např. při sankčním vyřazení z evidence ÚP (ukončení bude v pracovní den předcházející dni vzniku důvodu ukončení)
        </ul>
        </p>
    
   <?php      }  ?>


  <p>
  Datum vydání osvědčení o úspěšném absolvování projektu:
  <input ID="datum_certif" type="text" name="datum_certif" size="10" maxlength="10" value="<?php echo @$pole['datum_certif'];?>">
  </p>
  <br>
  <!-- ########################################################################## //-->

 
  <!--`mot_znamka` tinyint(4) DEFAULT NULL, //-->
  <!--`mot_hodnoceni` varchar COLLATE utf8_czech_ci DEFAULT NULL, //-->
  <p>
    Motivační program:<br>
    <input ID="mot_znamka" type="text" name="mot_znamka" size="1" maxlength="1" value="<?php echo @$pole['mot_znamka'];?>"> 
    <span class="help">(zde uveďte známku hodnotící účast v motivačním programu)</span>
  <br>
    <?php
    /**/
    /* EEE
    if ($Existuje_zaznam_v_uc_ukonc_flat_table) {}
    else {
        if ( @$pole_pro_zobrazeni['id_s_kurz_zztp_FK'] >3  OR  @$pole_pro_zobrazeni['id_s_kurz_kom_FK'] >3){
          @$pole['mot_hodnoceni'] = "Účastník absolvoval motivační program s kurzy \"" . @$pole_pro_zobrazeni['zztp_text'] . "\" a \"" . @$pole_pro_zobrazeni['kom_text'] . "\".";
        }
    }
    */ 
     

    
    ?>
    <textarea ID="mot_hodnoceni" name="mot_hodnoceni" cols="100" rows=3><?php echo @$pole['mot_hodnoceni'];?></textarea> 
    <span class="help">(zde uveďte slovní hodnocení účasti v motivačním programu)<br>
    Příklady známek a slovního zhodnocení Motivačního programu<br> 
    1 = Účastník absolvoval kurzy Motivačního programu v plném rozsahu a se stoprocentní docházkou.<br>
    2 = Účastník úspěšně absolvoval kurzy Motivačního programu, jeho docházka byla postačující.<br>
    3 = Kurzy Motivačního programu účastník neabsolvoval v plném rozsahu, jeho účast na kurzu byla minimální.<br>
    </span>
  </p>
  
  
  
  <!--`pc1_znamka` tinyint(4) DEFAULT NULL, //-->
  <!--`pc1_hodnoceni` varcharCOLLATE utf8_czech_ci DEFAULT NULL, //-->
  <p>
    Rekvalifikační kurz obsluhy osobního počítače:<br>
    <input ID="pc1_znamka" type="text" name="pc1_znamka" size="1" maxlength="1" value="<?php echo @$pole['pc1_znamka'];?>"> 
    <span class="help">(zde uveďte známku hodnotící účast v PC kurzu)</span>
  <br>
    <?php
     
    /* EEE
    if ($Existuje_zaznam_v_uc_ukonc_flat_table) {}
    else {
        if  ( @$pole_pro_zobrazeni['id_s_kurz_pc1_FK'] >3  )  {
          @$pole['pc1_hodnoceni'] = "Účastník absolvoval rekvalifikační kurz obsluhy osobního počítače \"" . @$pole_pro_zobrazeni['pc1_text'] . "\".";
        }
    } 
    */ 
    
    
    ?>
    <textarea ID="pc1_hodnoceni" name="pc1_hodnoceni" cols="100" rows=3><?php echo @$pole['pc1_hodnoceni'];?></textarea> 
    <span class="help">(zde uveďte slovní hodnocení účasti v PC kurzu)<br>
    Příklady známek a slovního zhodnocení Kurzu obsluhy PC<br>
    1 = Účastník Kurz obsluhy PC absolvoval s maximální úspěšností a stoprocentní docházkou.<br> 
    3 = Účastník úspěšně absolvoval a Kurz obsluhy PC.<br>
    5 = Kurz obsluhy PC neabsolvoval účastník v plném rozsahu. Jeho docházka nebyla dostačující.<br>
    </span>
  </p>
  
  <p>
    Rekvalifikační kurz obsluhy osobního počítače - další:<br>
    <input ID="pc2_znamka" type="text" name="pc2_znamka" size="1" maxlength="1" value="<?php echo @$pole['pc2_znamka'];?>"> 
    <span class="help">(zde uveďte známku hodnotící účast v PC kurzu)</span>
  <br>
    <?php
    
    /*  EEE
    if ($Existuje_zaznam_v_uc_ukonc_flat_table) {}
    else {
        if  ( @$pole_pro_zobrazeni['id_s_kurz_pc2_FK'] >3  )  {
          @$pole['pc2_hodnoceni'] = "Účastník absolvoval rekvalifikační kurz obsluhy osobního počítače \"" . @$pole_pro_zobrazeni['pc2_text'] . "\".";
        }
    }  
    */
     
    
    ?>
    <textarea ID="pc2_hodnoceni" name="pc2_hodnoceni" cols="100" rows=3><?php echo @$pole['pc2_hodnoceni'];?></textarea> 
    <span class="help">(zde uveďte slovní hodnocení účasti v PC kurzu)</span><br>
   </p>    
   
   
  <!--`bidi_znamka` tinyint(4) DEFAULT NULL, //-->
  <!--`bidi_hodnoceni` varchar(200) COLLATE utf8_czech_ci DEFAULT NULL, //-->
  <p>
    Bilanční diagnostika:<br>
    <input ID="bidi_znamka" type="text" name="bidi_znamka" size="1" maxlength="1" value="<?php echo @$pole['bidi_znamka'];?>"> 
    <span class="help">(zde uveďte známku hodnotící účast v bilanční diagnostice)</span>
  <br>
    <?php
       /* EEE
       if ($Existuje_zaznam_v_uc_ukonc_flat_table) {}
       else {
        if  ( @$pole_pro_zobrazeni['id_s_kurz_bidi_FK'] >3   )  {
         @$pole['bidi_hodnoceni'] = "Účastník absolvoval bilanční diagnostiku \"" . @$pole_pro_zobrazeni['bidi_text'] . "\".";
        }
       } 
        */
     
    ?>
    <textarea ID="bidi_hodnoceni" name="bidi_hodnoceni" cols="100" rows=3><?php echo @$pole['bidi_hodnoceni'];?></textarea> 
    <span class="help">(zde uveďte slovní hodnocení účasti v bilanční diagnostice)</span>
  </p>  
  
  
   <!--`bidi_znamka` tinyint(4) DEFAULT NULL, //-->
  <!--`bidi_hodnoceni` varchar(200) COLLATE utf8_czech_ci DEFAULT NULL, //-->
  <p>
    Pracovní diagnostika:<br>
    <input ID="prdi_znamka" type="text" name="prdi_znamka" size="1" maxlength="1" value="<?php echo @$pole['prdi_znamka'];?>"> 
    <span class="help">(zde uveďte známku hodnotící účast v pracovní diagnostice)</span>
  <br>
    <?php
      /* EEE
      if ($Existuje_zaznam_v_uc_ukonc_flat_table) {}
      else {
        if  ( @$pole_pro_zobrazeni['id_s_kurz_prdi_FK'] >3   )  {
         @$pole['prdi_hodnoceni'] = "Účastník absolvoval pracovní diagnostiku \"" . @$pole_pro_zobrazeni['prdi_text'] . "\".";
        }
      } 
      */
     
     
    ?>
    <textarea ID="prdi_hodnoceni" name="prdi_hodnoceni" cols="100" rows=3><?php echo @$pole['prdi_hodnoceni'];?></textarea> 
    <span class="help">(zde uveďte slovní hodnocení účasti v pracovní diagnostice)</span>
  </p>  
  
  
  
<DIV  style='display:none'>
  <!--`praxe_znamka` tinyint(4) DEFAULT NULL, //-->
  <!--`praxe_hodnoceni` varchar COLLATE utf8_czech_ci DEFAULT NULL, //-->
  <p>
    Pracovní praxe:<br>
    <input ID="praxe_znamka" type="text" name="praxe_znamka" size="1" maxlength="1" value="<?php echo @$pole['praxe_znamka'];?>"> 
    <span class="help">(zde uveďte známku hodnotící účast v praxi)</span>
  <br>
    <?php
      /* EEE
      if ($Existuje_zaznam_v_uc_ukonc_flat_table) {}
      else {
        if  ( @$pole_pro_zobrazeni['id_s_kurz_praxe_FK'] >3   )  {
         @$pole['praxe_hodnoceni'] = "Účastník absolvoval praxi \"" . @$pole_pro_zobrazeni['praxe_text'] . "\".";
        } 
      } 
      */    
  
?>
    <textarea ID="praxe_hodnoceni" name="praxe_hodnoceni" cols="100" rows=3><?php echo @$pole['praxe_hodnoceni'];?></textarea> 
    <span class="help">(zde uveďte slovní hodnocení účasti v praxi)</span>
  </p>  
</DIV>


  
  <!--`prof1_znamka` tinyint(4) DEFAULT NULL, //-->
  <!--`prof1_hodnoceni` varchar COLLATE utf8_czech_ci DEFAULT NULL, //-->
  <p>
    Profesní rekvalifikační kurz I:<br>
    <input ID="prof1_znamka" type="text" name="prof1_znamka" size="1" maxlength="1" value="<?php echo @$pole['prof1_znamka'];?>"> 
    <span class="help">(zde uveďte známku hodnotící účast v profesním rekvalifikačním kurzu I)</span>
  <br>
    <?php
     /*  EEE
     if ($Existuje_zaznam_v_uc_ukonc_flat_table) {}
      else {
        if  ( @$pole_pro_zobrazeni['id_s_kurz_prof1_FK'] >3   )  {
         @$pole['prof1_hodnoceni'] = "Účastník absolvoval profesní rekvalifikační kurz \"" . @$pole_pro_zobrazeni['prof1_text'] . "\"." ;
        }
      }   
      */
    
  
     
    ?>
    <textarea ID="prof1_hodnoceni" name="prof1_hodnoceni" cols="100" rows=3><?php echo @$pole['prof1_hodnoceni'];?></textarea> 
    <span class="help">(zde uveďte slovní hodnocení účasti v profesním rekvalifikačním kurzu I)<br>
    Příklady známek a slovního zhodnocení Rekvalifikačního kurzu<br>
    Rekvalifikační kurzy (známku 3 a 5  je možné použít i jako doporučení pro ÚP)<br>
    1 = Účastník měl jasnou představu o dalším doplňujícím vzdělání. Rekvalifikační kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající zaměstnání.<br>
    2 = Účastník projevoval během účasti v projektu aktivní zájem o možnosti svého dalšího vzdělávání. Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit. Bylo by zřejmě rozumné umožnit Účastníkovi absolvovat tento kurz znovu, pokud bude naplánován.<br>
    3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru. Bohužel nebyl tento kurz do harmonogramu kurzů zařazen. Proto doporučujeme konzultantům Úřadu práce, aby jmenovanému umožnili tento kurz, pokud bude plánován, absolvovat. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    5 = Účastník pasivně přistupoval k výběru vhodného rekvalifikačního kurzu. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>
    </span>
  </p>  
  
  
  <!--`prof2_znamka` tinyint(4) DEFAULT NULL, //-->
  <!--`prof2_hodnoceni` varchar COLLATE utf8_czech_ci DEFAULT NULL, //-->
  <p>
    Profesní rekvalifikační kurz II:<br>
    <input ID="prof2_znamka" type="text" name="prof2_znamka" size="1" maxlength="1" value="<?php echo @$pole['prof2_znamka'];?>"> 
    <span class="help">(zde uveďte známku hodnotící účast v profesním rekvalifikačním kurzu II)</span>
  <br>
    <?php
    /*  EEE
     if ($Existuje_zaznam_v_uc_ukonc_flat_table) {}
      else {
        if  ( @$pole_pro_zobrazeni['id_s_kurz_prof2_FK'] >3   )  {
         @$pole['prof2_hodnoceni'] = "Účastník absolvoval profesní rekvalifikační kurz \"" . @$pole_pro_zobrazeni['prof2_text'] . "\"." ;
        }
      }      
     */
    
  
     
    ?>
    <textarea ID="prof2_hodnoceni" name="prof2_hodnoceni" cols="100" rows=3><?php echo @$pole['prof2_hodnoceni'];?></textarea> 
    <span class="help">(zde uveďte slovní hodnocení účasti v profesním rekvalifikačním kurzu II)<br>
    </span>
  </p>  
  
  
  
   
  <!--`prof _znamka` tinyint(4) DEFAULT NULL, //-->
  <!--`prof _hodnoceni` varchar COLLATE utf8_czech_ci DEFAULT NULL, //-->
  <p>
    Profesní rekvalifikační kurz III:<br>
    <input ID="prof3_znamka" type="text" name="prof3_znamka" size="1" maxlength="1" value="<?php echo @$pole['prof3_znamka'];?>"> 
    <span class="help">(zde uveďte známku hodnotící účast v profesním rekvalifikačním kurzu III)</span>
  <br>
    <?php
     /*    EEE
     if ($Existuje_zaznam_v_uc_ukonc_flat_table) {}
      else {
        if  ( @$pole_pro_zobrazeni['id_s_kurz_prof3_FK'] >3   )  {
         @$pole['prof3_hodnoceni'] = "Účastník absolvoval profesní rekvalifikační kurz \"" . @$pole_pro_zobrazeni['prof3_text'] . "\"." ;
        }
      }      
     */
  
     
    ?>
    <textarea ID="prof3_hodnoceni" name="prof3_hodnoceni" cols="100" rows=3><?php echo @$pole['prof3_hodnoceni'];?></textarea> 
    <span class="help">(zde uveďte slovní hodnocení účasti v profesním rekvalifikačním kurzu III)<br>
    </span>
  </p>  
  
 
  
  
  
  
  <!--`porad_znamka` tinyint(4) DEFAULT NULL, //-->
  <!--`porad_hodnoceni` varchar COLLATE utf8_czech_ci DEFAULT NULL, //-->
  <p>
    Individuální poradenství a zprostředkování zaměstnání:<br>
    <input ID="porad_znamka" type="text" name="porad_znamka" size="1" maxlength="1" value="<?php echo @$pole['porad_znamka'];?>"> 
    <span class="help">(zde uveďte známku hodnotící účast v programu poradenství a zprostředkování zaměstnání)</span>
  <br>
    <?php
    
     if (@$pole['porad_hodnoceni']==false   )
     {
            @$pole['porad_hodnoceni'] = "Účastník se účastnil individuálního poradenství a zprostředkování zaměstnání.";
     }    
    ?>
    <textarea ID="porad_hodnoceni" name="porad_hodnoceni" cols="100" rows=3 maxlength="160"><?php echo @$pole['porad_hodnoceni'];?></textarea> 
    <span class="help">(zde uveďte slovní hodnocení účasti v programu poradenství a zprostředkování zaměstnání)<br>
    Příklady známek a slovního zhodnocení spolupráce s okresním koordinátorem<br>
    1 = Klient se projektu <?php if ($Projekt->kod=="SPZP") echo "„S pomocí za prací“";
                                 if ($Projekt->kod=="RNH") echo "„Rodina není handicap“";?> zúčastnil úspěšně a aktivně spolupracoval s okresním koordinátorem projektu. Společně s ním se snažil najít uplatnění na trhu práce, docházel na všechny smluvené konzultace, zúčastňoval se klubových setkání. Sám aktivně vyhledával volné pracovní pozice ve svém regionu.<br>
    3 = Projektu se klient zúčastnil s ohledem na jeho možnosti (rodinné poměry, zdravotní problémy atd.) úspěšně. Vyvíjel snahu ve spolupráci s okresním koordinátorem, docházel na klubová setkání. Aktivně vyhledával za pomoci koordinátora projektu volné pracovní pozice ve svém regionu.<br>
    5 = Aktivity projektu <?php if ($Projekt->kod=="SPZP") echo "„S pomocí za prací“";
                                 if ($Projekt->kod=="RNH") echo "„Rodina není handicap“";?> klient absolvoval s nedostatečnou účastí. S okresním koordinátorem projektu spolupracoval na základě opakovaných výzev, klubových setkání se neúčastnil.<br>
    </span>
  </p>  
  
  
  <!--`doporuceni` varchar COLLATE utf8_czech_ci DEFAULT NULL, //-->
  <p>
    Doporučení:<br>
    <textarea ID="doporuceni" name="doporuceni" cols="100" rows=3><?php echo @$pole['doporuceni'];?></textarea> 
    <span class="help">(zde v případě, že účastník nezíská při účasti v projektu zaměstnání, uveďte doporučení pro ÚP ohledně další práce s účastníkem)<br>
    Příklady známek a slovního zhodnocení<br>
    1 = Účastník vyvíjí maximální snahu ve zdokonalování svých znalostí a dovedností a také v hledání zaměstnání. Nebylo by šťastné, pokud by nenašel uplatnění na trhu práce.<br>
    2 = Účastník se zúčastnil projektu <?php if ($Projekt->kod=="SPZP") echo "„S pomocí za prací“";
                                 if ($Projekt->kod=="RNH") echo "„Rodina není handicap“";?> aktivně, jeho uplatnění na trhu práce je velmi pravděpodobné. S pomocí konzultanta z Úřadu práce by mohl najít vhodné zaměstnání.<br>
    3 = Účast Účastníka na aktivitách projektu <?php if ($Projekt->kod=="SPZP") echo "„S pomocí za prací“";
                                 if ($Projekt->kod=="RNH") echo "„Rodina není handicap“";?> byla uspokojivá, jmenovaný vyvíjel průměrné úsilí v hledání zaměstnání. Konzultantům na Úřadu práce doporučujeme, aby pokračovali ve snaze motivovat jmenovaného při uplatnění se na trhu práce.<br>
    4 = S přihlédnutím na pasivní účast účastníka v aktivitách projektu <?php if ($Projekt->kod=="SPZP") echo "„S pomocí za prací“";
                                 if ($Projekt->kod=="RNH") echo "„Rodina není handicap“";?> je možné konstatovat, že jmenovaný nevyvíjí optimální snahu ve zdokonalování svých znalostí a dovedností a rovněž v hledání zaměstnání. Tedy jeho uplatnění na trhu práce  podle nás závisí na podpoře a pomoci konzultantů Úřadu práce.<br>
    5 = Vzhledem ke zkušenostem z jednání a konzultací s účastníkem lze konstatovat, že jmenovaný nevyvíjí optimální snahu ve zdokonalování svých znalostí a dovedností a rovněž v hledání zaměstnání. Možnost uplatnění účastníka je tedy na trhu práce poněkud omezená, zřejmě by potřeboval intenzivní pomoc konzultantů Úřadu práce.<br>
    </span>
  </p>

  
  <p>
    Další hodnocení:<br>
    <textarea ID="vyhodnoceni" name="vyhodnoceni" cols="100" rows=3><?php echo @$pole['vyhodnoceni'];?></textarea>
    <span class="help"><br>zde se zobrazuje hodnocení vytvořené ve starší verzi formuláře<br>
    </span>
  </p>
  
  <!--############################################################################## //-->
  
  <p>
  V případě, že nebylo možné získat podpis účastníka, uveďte zde důvod:<br>
  <input ID="neni_podpis" type="text" name="neni_podpis" size="120" maxlength="120" value="<?php echo @$pole['neni_podpis'];?>">
  </p>      
  <p>
  Příloha:
  <input ID="priloha" type="text" name="priloha" size="120" maxlength="120" value="<?php echo @$pole['priloha'];?>"> (zde uveďte typ přílohy)
  </p>       
</FIELDSET> 


<?php
  //************** KOLIZE ******************* 
  Projektor2_Table_UcKolizeData::Vypis_kolize_formulare_dosud_nezavolane($id_ucastnik,FORMULAR_ZA_UKONC,$zavolane_kolize_v_ukonc) ;
  //************** KOLIZE ******************* 
?> 



<p>Datum vytvoření:
<input ID="datum_vytvor_dok" type="text" name="datum_vytvor_dok" size="8" maxlength="10" value="<?php
                                        if (@$pole['datum_vytvor_dok']) {echo @$pole['datum_vytvor_dok'];}
                                        else {echo date("d.m.Y"); }
                                        ?>">
</p>

<!-- <p><input type="submit" value="Uložit" name="B1">&nbsp;&nbsp;&nbsp; -->
<input type="reset" value="Zruš provedené změny" name="B2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</p>
<!-- <input type="submit" value="Vytiskni Smlouvu" name="B1">
-->
<?php
//    if ( isset($_GET['id_ucastnik']) ) {
// //    if ($id_ucastnik){
//    echo ('<p><input type="submit" value="Tisk" name="T1">&nbsp;&nbsp;&nbsp;</p> ');
//    }
    
     echo '<script type ="text/javascript" src="./kontrol_ukonc_area.js"></script>'."\n"; 
?>


  </form>
  <ul id="menu">
     <li><a href="index.php?akce=agp_zobraz_reg">Zpět na výběr zájemce</a></li>
  </ul>  