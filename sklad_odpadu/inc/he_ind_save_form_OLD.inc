<?php
ob_start();

require_once "save_zpracuj_cookie.inc";

//Zpracování dat z formulare
$Chyby = new Projektor2_Chyby;

$pole = $_POST;
if (array_key_exists('T1', $pole)) {
    //jdu z tlacitka tisk ve smlouve , musim odstranit T1 z $pole, abych se nepokoušel ukládat do db sloupce 'T1'
    unset($pole['T1']);
}

/*******************TADY UKLADAME*******************************************/
    //************************Data pro tabulku uc_osobni_udaje
    //Pseudo čiselníky
    $Ciselnik = new Projektor2_Model_Db_CiselnikAbstract("c_pohlavi", $dbh);
    if($Ciselnik->check_text(trim($pole['pohlavi']))){
        $pohlavi_id = $Ciselnik->id;
    }
    else {
        $pohlavi_id = 1;
    }
    $Ciselnik = new Projektor2_Model_Db_CiselnikAbstract("c_titul_pred", $dbh);
    if($Ciselnik->check_column(trim($pole['titul']),'titul')){
        $titul_pred_id = $Ciselnik->id;
    }
    else {
        $titul_pred_id = "NULL";
    }
    
    $Osobni_udaje = new Projektor2_Model_Flat_ZaOsobniUdaje($Zajemce,1,$pole['jmeno'],$pole['prijmeni'],$pole['rodne_cislo'],$pole['datum_narozeni'],$pole['datum_reg'],"",$pohlavi_id,$titul_pred_id,null,null,null,$dbh);
    //Overeni udaju
    $Osobni_udaje->check_values();
   
   
    //echo "<BR>***1Osobni_udaje->chyby->pocet: " . $Osobni_udaje->chyby->pocet    ;  // *SEL*
    
    
    
    $idcka_skolizi_z_formulare =  array();
    
    //Nacteni dat do falt tabulky (objektu)
    $flat_table = new Projektor2_Model_Db_Flat_ZaFlatTable($Zajemce);
    
    $flat_table->read_values();   // PP opatreni pro zachovani=neprepsani udaju v tabulce, neni-li sloupecek ve formulari 
    foreach($pole as $klic => $hodnota) {
        
         //tady !nepriradit! ty policka, co do uc_flat_table nepatri
           
           if (strpos($klic, '§')!== false) {  //tj. § tam nekde je, je mozne hledat pozici
                if ( substr($klic, 0, strlen("uc_kolize_table") )  == "uc_kolize_table")   //vyhledavam policka  pro uc_kolize_table
                {  
                  //!! echo "<br>" .$klic  . "   pozice p: "  . mb_strpos($klic, 'p') .  " " . substr($klic,  mb_strpos($klic, '§')+1 , mb_strlen($klic) );
                  // !! pozor ! § zaujima dve pozice
                  
                  //sesbirat, ktere s_typ_kolize jsou nyni aktualni - tj. byly vypsane, ve jmenu polozek je id_s_typ_kolize
                  $a1 = explode ("§", $klic );
                     //echo "<br>prvni explode" ; var_dump(  $a1 );
                  $a2 = explode ("_", $a1[1] );
                     //echo "<br>druhe explode" ; var_dump(  $a2  );
                  
                  if (in_array($a2[0], $idcka_skolizi_z_formulare)) {}
                  else {
                    $idcka_skolizi_z_formulare[]= $a2[0];
                  }  
                  
                }
                else {       
                  $flat_table->$klic = $hodnota;
                }
            }
            else {   //pro policka bez tabulkoveho§ prefixu 
                $flat_table->$klic = $hodnota;
            }
    }

    //Nejsou-li chyby (v osobních udajích) - uložíme
    if ( (!$Osobni_udaje->chyby->pocet)  )  {
       /*
          //zruseno ukladani do tabulky uc_osobni_udaje
          //objekt Uc_osobni_udaje se v pgm vytvari,
          //probihaji metody na kontrolu chyb - generuji pripadne vyjimky a hlaseni chyb do formulare
          //pouze se nezapise do tabulky uc_osobni_udaje
     */
        if  ($User->povolen_zapis) {
           if(!$Zajemce->id) {
               $Zajemce = Projektor2_Model_Db_ZajemceMapper::create();
           }
           $idName = $flat_table->mainObjectIdColumnName;
           $flat_table->$idName = $Zajemce->id;

        }
        
        //***********************Ulozeni flat tabulky*********************
        //echo "<BR>***3Osobni_udaje->chyby->pocet: " . $Osobni_udaje->chyby->pocet    ;      //  *SEL*
        if($flat_table->chyby->pocet==0) {
            if  ($User->povolen_zapis) {
                $flat_table->save();                
                //*** KOLIZE - zapis  do tabulky uc_kolize_table
                Projektor2_Table_UcKolizeData::Zapis_vsechny_kolize_v_zaveru_formulare($pole, $idcka_skolizi_z_formulare,  $Zajemce->id, FORMULAR_ZA_REG_DOT);
            }
        }
    }
    /*************************************************************************************/
    
    if($Osobni_udaje->chyby->pocet) {
        if($Osobni_udaje->chyby->pocet) {
            $chyby = new Projektor2_View_HTML_Chyby();
            $chyby->display($Osobni_udaje->chyby, 'Chyby v osobních údajích:');
        }
        if($flat_table->chyby->pocet) {
            $chyby = new Projektor2_View_HTML_Chyby();        
            $chyby->display($Osobni_udaje->chyby, 'Chyby v ostatních datech:');
        }
    } else {    
        // nebyly chyby - vytvoř pdf a vygeneruj obsah stránky
        if ($tlacitko_tisk) {
            if  ($_GET['akce'] == 'he_sml_uc') {
                //přidání dalších údajů potřebných pro vytvoření dokumentu
                $pole['kancelar_plny_text'] = $Kancelar->plny_text;
                $pole['user_name'] = $User->name;
                $view = new Projektor2_View_PDF_Help_Smlouva($pole, $Zajemce->identifikator);
                $view->save();
                echo $view->getNewWindowOpenerCode();
            }
            if  ($_GET['akce'] == 'he_souhlas_uc') {
                //přidání dalších údajů potřebných pro vytvoření dokumentu
                $pole['kancelar_plny_text'] = $Kancelar->plny_text;
                $view = new Projektor2_View_PDF_Help_Souhlas($pole, $Zajemce->identifikator);
                $view->save();
                echo $view->getNewWindowOpenerCode();
            }
            if  ($_GET['akce'] == 'he_ukonceni_uc') {
                //přidání dalších údajů potřebných pro vytvoření dokumentu
                $pole['kancelar_plny_text'] = $Kancelar->plny_text;
                $view = new Projektor2_View_PDF_Help_Ukonceni($pole, $Zajemce->identifikator);
                $view->save();
                echo $view->getNewWindowOpenerCode();
            }
        }    
    }
    
    
//--------------------------------------        
//header("Location: ./index.php");
//header("Refresh: 5; url=./index.php");    
    
//print_r($Osobni_udaje);               
//print_r($_POST);
//print_r($_COOKIE);
/*********************************KONEC UKLADANI**************************/
//}
          
?>