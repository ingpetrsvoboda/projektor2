<?php
ob_start();

require_once "save_zpracuj_cookie.inc";

//Zpracování dat z formulare
   //echo "<BR>*\Ucastnik*";  print_r ($Ucastnik); exit;
$Chyby = new Projektor2_Chyby;

if (array_key_exists('T1', $_POST)) {
    //jdu z tlacitka tisk ve smlouve , musim odstranit T1 z $_POST
    $tlacitko_tisk = array_pop($_POST);
}
else {
    $tlacitko_tisk = "";
}

$pole = $_POST;

//echo "<BR>POST*"; print_r($_POST) ; 
//echo "<BR>pole*"; print_r($pole) ; 

//*******************************************************************************************
//*** doplneni textovych retezcu  do sloupcu tabulky uc_plan_flat_table  ..._text a priprava pro pdf
$dbh = Projektor2_AppContext::getDb();


//***** zztp
   $query=" SELECT * FROM  s_kurz  WHERE (s_kurz.id_s_kurz  = '" . $pole['id_s_kurz_zztp_FK'] . "' ) ";     // echo " ***" . $query . "  ";
   $data= $dbh->prepare($query)->execute();
   
if ($skurz = $data->fetch()) {
    $pole['zztp_text'] = text_retezec_kurz($skurz);
        //echo "<br>*Kurz nalezen " . $skurz['id_s_kurz'];
      
      $pole_pro_zobrazeni['zztp_pdf_kod_kurzu'] = $skurz['projekt_kod'] . "_" .$skurz['kurz_druh']. "_" . $skurz['kurz_cislo'] . "_" .
                                                  $skurz['beh_cislo'] . "T_" . $skurz['kurz_zkratka'] ;       
      $pole_pro_zobrazeni['zztp_pdf_termin_konani'] = $skurz['kurz_termin'];
      $pole_pro_zobrazeni['zztp_pdf_skupina'] = $skurz['kurz_zkratka'];
      $pole_pro_zobrazeni['zztp_pdf_nazev'] = $skurz['kurz_nazev'];
        
    if ($pole['id_s_kurz_zztp_FK']== 1) {
       $pole['zztp_text'] = "-------------";
       $pole_pro_zobrazeni['zztp_pdf_kod_kurzu'] = "-------------"; $pole_pro_zobrazeni['zztp_pdf_termin_konani'] = "";
       $pole_pro_zobrazeni['zztp_pdf_skupina'] = ""; $pole_pro_zobrazeni['zztp_pdf_nazev'] = "";
    }
    if ($pole['id_s_kurz_zztp_FK']== 2) {
        $pole['zztp_text'] = "nezařazen";
        $pole_pro_zobrazeni['zztp_pdf_kod_kurzu'] = "nezařazen"; $pole_pro_zobrazeni['zztp_pdf_termin_konani'] = "";
        $pole_pro_zobrazeni['zztp_pdf_skupina'] = ""; $pole_pro_zobrazeni['zztp_pdf_nazev'] = "";
    }
    if ($pole['id_s_kurz_zztp_FK']== 3) {
        $pole['zztp_text'] = "odmítl účast";
        $pole_pro_zobrazeni['zztp_pdf_kod_kurzu'] = "odmítl účast"; $pole_pro_zobrazeni['zztp_pdf_termin_konani'] = "";
        $pole_pro_zobrazeni['zztp_pdf_skupina'] = ""; $pole_pro_zobrazeni['zztp_pdf_nazev'] = "";
    } 
}
else {
    $pom = $pole['id_s_kurz_zztp_FK'];
    $pole['id_s_kurz_zztp_FK'] = 0;  // tj. = null, !neumime zapsat NULL jako =null
    $pole['zztp_text'] = $pom; //
        // echo "<br>*Kurz nenalezen ";
}
//echo " id_skurz zztp FK "; var_dump($pole['id_s_kurz_zztp_FK']);
//echo " "; var_dump($pole['zztp_text']);



//***** kom
   $query=" SELECT * FROM  s_kurz  WHERE (s_kurz.id_s_kurz  = '" . $pole['id_s_kurz_kom_FK'] . "' ) ";   // echo " ***" . $query . "  ";
   $data= $dbh->prepare($query)->execute();
   
if ($skurz = $data->fetch()) {
    $pole['kom_text'] = text_retezec_kurz($skurz);
           //echo "<br>*Kurz nalezen " . $skurz['id_s_kurz'];
           
     $pole_pro_zobrazeni['kom_pdf_kod_kurzu'] = $skurz['projekt_kod'] . "_" .$skurz['kurz_druh']. "_" . $skurz['kurz_cislo'] . "_" .
                                                  $skurz['beh_cislo'] . "T_" . $skurz['kurz_zkratka'] ;       // trim($vkurz['kurz_nazev'])." | ".
     $pole_pro_zobrazeni['kom_pdf_termin_konani'] = $skurz['kurz_termin'];
     $pole_pro_zobrazeni['kom_pdf_skupina'] = $skurz['kurz_zkratka'];
     $pole_pro_zobrazeni['kom_pdf_nazev'] = $skurz['kurz_nazev'];
           
    if ($pole['id_s_kurz_kom_FK']== 1) {
        $pole['kom_text'] = "-------------";
        $pole_pro_zobrazeni['kom_pdf_kod_kurzu'] = "-------------"; $pole_pro_zobrazeni['kom_pdf_termin_konani'] = "";
        $pole_pro_zobrazeni['kom_pdf_skupina'] = ""; $pole_pro_zobrazeni['kom_pdf_nazev'] = "";
    }
    if ($pole['id_s_kurz_kom_FK']== 2) {
        $pole['kom_text'] = "nezařazen";
        $pole_pro_zobrazeni['kom_pdf_kod_kurzu'] = "nezařazen"; $pole_pro_zobrazeni['kom_pdf_termin_konani'] = "";
        $pole_pro_zobrazeni['kom_pdf_skupina'] = ""; $pole_pro_zobrazeni['kom_pdf_nazev'] = "";

    }
    if ($pole['id_s_kurz_kom_FK']== 3) {
        $pole['kom_text'] = "odmítl účast";
        $pole_pro_zobrazeni['kom_pdf_kod_kurzu'] = "odmítl účast"; $pole_pro_zobrazeni['kom_pdf_termin_konani'] = "";
        $pole_pro_zobrazeni['kom_pdf_skupina'] = ""; $pole_pro_zobrazeni['kom_pdf_nazev'] = "";

    }        
}
else {
    $pom = $pole['id_s_kurz_kom_FK'];
    $pole['id_s_kurz_kom_FK'] = 0;  // tj.= null, !neumime zapsat NULL jako =null
    $pole['kom_text'] = $pom; //
           //echo "<br>*Kurz nenalezen ";    
}
//echo " id_skurz kom FK "; var_dump($pole['id_s_kurz_kom_FK']);
//echo " "; var_dump($pole['kom_text']);



//***** pc1
   $query=" SELECT * FROM  s_kurz  WHERE (s_kurz.id_s_kurz  = '" . $pole['id_s_kurz_pc1_FK'] . "' ) ";    //echo " ***" . $query . "  ";
   $data= $dbh->prepare($query)->execute();
   
if ($skurz = $data->fetch()) {
    $pole['pc1_text'] = text_retezec_kurz($skurz);
           //echo "<br>*Kurz nalezen " . $skurz['id_s_kurz'];
    
     $pole_pro_zobrazeni['pc1_pdf_kod_kurzu'] = $skurz['projekt_kod'] . "_" .$skurz['kurz_druh']. "_" . $skurz['kurz_cislo'] . "_" .
                                                  $skurz['beh_cislo'] . "T_" . $skurz['kurz_zkratka'] ;       // trim($vkurz['kurz_nazev'])." | ".
     $pole_pro_zobrazeni['pc1_pdf_termin_konani'] = $skurz['kurz_termin'];
     $pole_pro_zobrazeni['pc1_pdf_skupina'] = $skurz['kurz_zkratka'];
     $pole_pro_zobrazeni['pc1_pdf_nazev'] = $skurz['kurz_nazev'];
           
    if ($pole['id_s_kurz_pc1_FK']== 1) {
        $pole['pc1_text'] = "-------------";
        $pole_pro_zobrazeni['pc1_pdf_kod_kurzu'] = "-------------"; $pole_pro_zobrazeni['pc1_pdf_termin_konani'] = "";
        $pole_pro_zobrazeni['pc1_pdf_skupina'] = ""; $pole_pro_zobrazeni['pc1_pdf_nazev'] = "";

    }
    if ($pole['id_s_kurz_pc1_FK']== 2) {
        $pole['pc1_text'] = "nezařazen";
        $pole_pro_zobrazeni['pc1_pdf_kod_kurzu'] = "nezařazen"; $pole_pro_zobrazeni['pc1_pdf_termin_konani'] = "";
        $pole_pro_zobrazeni['pc1_pdf_skupina'] = ""; $pole_pro_zobrazeni['pc1_pdf_nazev'] = "";


    }
    if ($pole['id_s_kurz_pc1_FK']== 3) {
        $pole['pc1_text'] = "odmítl účast";
        $pole_pro_zobrazeni['pc1_pdf_kod_kurzu'] = "odmítl účast"; $pole_pro_zobrazeni['pc1_pdf_termin_konani'] = "";
        $pole_pro_zobrazeni['pc1_pdf_skupina'] = ""; $pole_pro_zobrazeni['pc1_pdf_nazev'] = "";


    }        
}
else {
    $pom = $pole['id_s_kurz_pc1_FK'];
    $pole['id_s_kurz_pc1_FK'] = 0;  // tj.= null, !neumime zapsat NULL jako =null
    $pole['pc1_text'] = $pom; //
           //echo "<br>*Kurz nenalezen ";    
}
//echo " id_skurz pc1 FK "; var_dump($pole['id_s_kurz_pc1_FK']);
//echo " "; var_dump($pole['pc1_text']);




//***** pc2
   $query=" SELECT * FROM  s_kurz  WHERE (s_kurz.id_s_kurz  = '" . $pole['id_s_kurz_pc2_FK'] . "' ) ";    //echo " ***" . $query . "  ";
   $data= $dbh->prepare($query)->execute();
   
if ($skurz = $data->fetch()) {
    $pole['pc2_text'] = text_retezec_kurz($skurz);
           //echo "<br>*Kurz nalezen " . $skurz['id_s_kurz'];
    
     $pole_pro_zobrazeni['pc2_pdf_kod_kurzu'] = $skurz['projekt_kod'] . "_" .$skurz['kurz_druh']. "_" . $skurz['kurz_cislo'] . "_" .
                                                  $skurz['beh_cislo'] . "T_" . $skurz['kurz_zkratka'] ;       // trim($vkurz['kurz_nazev'])." | ".
     $pole_pro_zobrazeni['pc2_pdf_termin_konani'] = $skurz['kurz_termin'];
     $pole_pro_zobrazeni['pc2_pdf_skupina'] = $skurz['kurz_zkratka'];
     $pole_pro_zobrazeni['pc2_pdf_nazev'] = $skurz['kurz_nazev'];
           
    if ($pole['id_s_kurz_pc2_FK']== 1) {
        $pole['pc2_text'] = "-------------";
        $pole_pro_zobrazeni['pc2_pdf_kod_kurzu'] = "-------------"; $pole_pro_zobrazeni['pc2_pdf_termin_konani'] = "";
        $pole_pro_zobrazeni['pc2_pdf_skupina'] = ""; $pole_pro_zobrazeni['pc2_pdf_nazev'] = "";

    }
    if ($pole['id_s_kurz_pc2_FK']== 2) {
        $pole['pc2_text'] = "nezařazen";
        $pole_pro_zobrazeni['pc2_pdf_kod_kurzu'] = "nezařazen"; $pole_pro_zobrazeni['pc2_pdf_termin_konani'] = "";
        $pole_pro_zobrazeni['pc2_pdf_skupina'] = ""; $pole_pro_zobrazeni['pc2_pdf_nazev'] = "";


    }
    if ($pole['id_s_kurz_pc2_FK']== 3) {
        $pole['pc2_text'] = "odmítl účast";
        $pole_pro_zobrazeni['pc2_pdf_kod_kurzu'] = "odmítl účast"; $pole_pro_zobrazeni['pc2_pdf_termin_konani'] = "";
        $pole_pro_zobrazeni['pc2_pdf_skupina'] = ""; $pole_pro_zobrazeni['pc2_pdf_nazev'] = "";


    }        
}
else {
    $pom = $pole['id_s_kurz_pc2_FK'];
    $pole['id_s_kurz_pc2_FK'] = 0;  // tj.= null, !neumime zapsat NULL jako =null
    $pole['pc2_text'] = $pom; //
           //echo "<br>*Kurz nenalezen ";    
}
//echo " id_skurz pc1 FK "; var_dump($pole['id_s_kurz_pc2_FK']);
//echo " "; var_dump($pole['pc2_text']);









//***** bidi
   $query=" SELECT * FROM  s_kurz  WHERE (s_kurz.id_s_kurz  = '" . $pole['id_s_kurz_bidi_FK'] . "' ) ";    //echo " ***" . $query . "  ";
   $data= $dbh->prepare($query)->execute();
   
if ($skurz = $data->fetch()) {
    $pole['bidi_text'] = text_retezec_kurz($skurz);
           //echo "<br>*Kurz nalezen " . $skurz['id_s_kurz'];
           
     $pole_pro_zobrazeni['bidi_pdf_kod_kurzu'] = $skurz['projekt_kod'] . "_" .$skurz['kurz_druh']. "_" . $skurz['kurz_cislo'] . "_" .
                                                  $skurz['beh_cislo'] . "T_" . $skurz['kurz_zkratka'] ;       // trim($vkurz['kurz_nazev'])." | ".
     $pole_pro_zobrazeni['bidi_pdf_termin_konani'] = $skurz['kurz_termin'];
     $pole_pro_zobrazeni['bidi_pdf_skupina'] = $skurz['kurz_zkratka'];
     $pole_pro_zobrazeni['bidi_pdf_nazev'] = $skurz['kurz_nazev'];
           
    if ($pole['id_s_kurz_bidi_FK']== 1) {
        $pole['bidi_text'] = "-------------";
        $pole_pro_zobrazeni['bidi_pdf_kod_kurzu'] = "-------------"; $pole_pro_zobrazeni['bidi_pdf_termin_konani'] = "";
        $pole_pro_zobrazeni['bidi_pdf_skupina'] = ""; $pole_pro_zobrazeni['bidi_pdf_nazev'] = "";

    }
    if ($pole['id_s_kurz_bidi_FK']== 2) {
        $pole['bidi_text'] = "nezařazen";
        $pole_pro_zobrazeni['bidi_pdf_kod_kurzu'] = "nezařazen"; $pole_pro_zobrazeni['bidi_pdf_termin_konani'] = "";
        $pole_pro_zobrazeni['bidi_pdf_skupina'] = "";  $pole_pro_zobrazeni['bidi_pdf_nazev'] = "";

    }
    if ($pole['id_s_kurz_bidi_FK']== 3) {
        $pole['bidi_text'] = "odmítl účast";
        $pole_pro_zobrazeni['bidi_pdf_kod_kurzu'] = "odmítl účast"; $pole_pro_zobrazeni['bidi_pdf_termin_konani'] = "";
        $pole_pro_zobrazeni['bidi_pdf_skupina'] = ""; $pole_pro_zobrazeni['bidi_pdf_nazev'] = "";

    }        
}
else {
    $pom = $pole['id_s_kurz_bidi_FK'];
    $pole['id_s_kurz_bidi_FK'] = 0;  // tj.= null, !neumime zapsat NULL jako =null
    $pole['bidi_text'] = $pom; //
           //echo "<br>*Kurz nenalezen ";
           
}
//echo " id_skurz bidi FK "; var_dump($pole['id_s_kurz_bidi_FK']);
//echo " "; var_dump($pole['bidi_text']);


//***** prdi
   $query=" SELECT * FROM  s_kurz  WHERE (s_kurz.id_s_kurz  = '" . $pole['id_s_kurz_prdi_FK'] . "' ) ";    //echo " ***" . $query . "  ";
   $data= $dbh->prepare($query)->execute();
   
if ($skurz = $data->fetch()) {
    $pole['prdi_text'] = text_retezec_kurz($skurz);
           //echo "<br>*Kurz nalezen " . $skurz['id_s_kurz'];
           
     $pole_pro_zobrazeni['prdi_pdf_kod_kurzu'] = $skurz['projekt_kod'] . "_" .$skurz['kurz_druh']. "_" . $skurz['kurz_cislo'] . "_" .
                                                  $skurz['beh_cislo'] . "T_" . $skurz['kurz_zkratka'] ;       // trim($vkurz['kurz_nazev'])." | ".
     $pole_pro_zobrazeni['prdi_pdf_termin_konani'] = $skurz['kurz_termin'];
     $pole_pro_zobrazeni['prdi_pdf_skupina'] = $skurz['kurz_zkratka'];
     $pole_pro_zobrazeni['prdi_pdf_nazev'] = $skurz['kurz_nazev'];
           
    if ($pole['id_s_kurz_prdi_FK']== 1) {
        $pole['prdi_text'] = "-------------";
        $pole_pro_zobrazeni['prdi_pdf_kod_kurzu'] = "-------------"; $pole_pro_zobrazeni['prdi_pdf_termin_konani'] = "";
        $pole_pro_zobrazeni['prdi_pdf_skupina'] = "";  $pole_pro_zobrazeni['prdi_pdf_nazev'] = "";

    }
    if ($pole['id_s_kurz_prdi_FK']== 2) {
        $pole['prdi_text'] = "nezařazen";
        $pole_pro_zobrazeni['prdi_pdf_kod_kurzu'] = "nezařazen"; $pole_pro_zobrazeni['prdi_pdf_termin_konani'] = "";
        $pole_pro_zobrazeni['prdi_pdf_skupina'] = "";  $pole_pro_zobrazeni['prdi_pdf_nazev'] = "";

    }
    if ($pole['id_s_kurz_prdi_FK']== 3) {
        $pole['prdi_text'] = "odmítl účast";
        $pole_pro_zobrazeni['prdi_pdf_kod_kurzu'] = "odmítl účast"; $pole_pro_zobrazeni['prdi_pdf_termin_konani'] = "";
        $pole_pro_zobrazeni['prdi_pdf_skupina'] = ""; $pole_pro_zobrazeni['prdi_pdf_nazev'] = "";

    }              
           
}
else {
    $pom = $pole['id_s_kurz_prdi_FK'];
    $pole['id_s_kurz_prdi_FK'] = 0;  // tj.= null, !neumime zapsat NULL jako =null
    $pole['prdi_text'] = $pom; //
           //echo "<br>*Kurz nenalezen ";
      
}
//echo " id_skurz prdi FK "; var_dump($pole['id_s_kurz_prdi_FK']);
//echo " "; var_dump($pole['prdi_text']);


//***** praxe
   $query=" SELECT * FROM  s_kurz  WHERE (s_kurz.id_s_kurz  = '" . $pole['id_s_kurz_praxe_FK'] . "' ) ";    //echo " ***" . $query . "  ";
   $data= $dbh->prepare($query)->execute();
   
if ($skurz = $data->fetch()) {
    $pole['praxe_text'] = text_retezec_kurz($skurz);
           //echo "<br>**************Kurz nalezen " . $skurz['id_s_kurz'] .$pole['praxe_text'];
           
     $pole_pro_zobrazeni['praxe_pdf_kod_kurzu'] = $skurz['projekt_kod'] . "_" .$skurz['kurz_druh']. "_" . $skurz['kurz_cislo'] . "_" .
                                                  $skurz['beh_cislo'] . "T_" . $skurz['kurz_zkratka'] ;       // trim($vkurz['kurz_nazev'])." | ".
     $pole_pro_zobrazeni['praxe_pdf_termin_konani'] = $skurz['kurz_termin'];
     $pole_pro_zobrazeni['praxe_pdf_skupina'] = $skurz['kurz_zkratka'];
     $pole_pro_zobrazeni['praxe_pdf_nazev'] = $skurz['kurz_nazev'];
           
    if ($pole['id_s_kurz_praxe_FK']== 1) {
        $pole['praxe_text'] = "-------------";
        $pole_pro_zobrazeni['praxe_pdf_kod_kurzu'] = "-------------"; $pole_pro_zobrazeni['praxe_pdf_termin_konani'] = "";
        $pole_pro_zobrazeni['praxe_pdf_skupina'] = "";  $pole_pro_zobrazeni['praxe_pdf_nazev'] = "";

    }
    if ($pole['id_s_kurz_praxe_FK']== 2) {
        $pole['praxe_text'] = "nezařazen";
        $pole_pro_zobrazeni['praxe_pdf_kod_kurzu'] = "nezařazen"; $pole_pro_zobrazeni['praxe_pdf_termin_konani'] = "";
        $pole_pro_zobrazeni['praxe_pdf_skupina'] = ""; $pole_pro_zobrazeni['praxe_pdf_nazev'] = "";

    }
    if ($pole['id_s_kurz_praxe_FK']== 3) {
        $pole['praxe_text'] = "odmítl účast";
        $pole_pro_zobrazeni['praxe_pdf_kod_kurzu'] = "odmítl účast"; $pole_pro_zobrazeni['praxe_pdf_termin_konani'] = "";
        $pole_pro_zobrazeni['praxe_pdf_skupina'] = ""; $pole_pro_zobrazeni['praxe_pdf_nazev'] = "";

    }              
}
else {
    $pom = $pole['id_s_kurz_praxe_FK'];
    $pole['id_s_kurz_praxe_FK'] = 0;  // tj.= null, !neumime zapsat NULL jako =null
    $pole['praxe_text'] = $pom; //
          // echo "<br>*Kurz nenalezen ";    
}
//echo " id_skurz praxe FK "; var_dump($pole['id_s_kurz_praxe_FK']);
//echo " "; var_dump($pole['praxe_text']);




//***** prof1
   $query=" SELECT * FROM  s_kurz  WHERE (s_kurz.id_s_kurz  = '" . $pole['id_s_kurz_prof1_FK'] . "' ) ";    //echo " ***" . $query . "  ";
   $data= $dbh->prepare($query)->execute();
   
if ($skurz = $data->fetch()) {
    $pole['prof1_text'] = text_retezec_kurz($skurz);
           //echo "<br>*Kurz nalezen " . $skurz['id_s_kurz'];
           
     $pole_pro_zobrazeni['prof1_pdf_kod_kurzu'] = $skurz['projekt_kod'] . "_" .$skurz['kurz_druh']. "_" . $skurz['kurz_cislo'] . "_" .
                                                  $skurz['beh_cislo'] . "T_" . $skurz['kurz_zkratka'] ;       // trim($vkurz['kurz_nazev'])." | ".
     $pole_pro_zobrazeni['prof1_pdf_termin_konani'] = $skurz['kurz_termin'];
     $pole_pro_zobrazeni['prof1_pdf_skupina'] = $skurz['kurz_zkratka'];
     $pole_pro_zobrazeni['prof1_pdf_nazev'] = $skurz['kurz_nazev'];
           
           
    if ($pole['id_s_kurz_prof1_FK']== 1) {
        $pole['prof1_text'] = "-------------";
        $pole_pro_zobrazeni['prof1_pdf_kod_kurzu'] = "-------------"; $pole_pro_zobrazeni['prof1_pdf_termin_konani'] = "";
        $pole_pro_zobrazeni['prof1_pdf_skupina'] = ""; $pole_pro_zobrazeni['prof1_pdf_nazev'] = "";

    }
    if ($pole['id_s_kurz_prof1_FK']== 2) {
        $pole['prof1_text'] = "nezařazen";
        $pole_pro_zobrazeni['prof1_pdf_kod_kurzu'] = "nezařazen"; $pole_pro_zobrazeni['prof1_pdf_termin_konani'] = "";
        $pole_pro_zobrazeni['prof1_pdf_skupina'] = ""; $pole_pro_zobrazeni['prof1_pdf_nazev'] = "";

    }
    if ($pole['id_s_kurz_prof1_FK']== 3) {
        $pole['prof1_text'] = "odmítl účast";
        $pole_pro_zobrazeni['prof1_pdf_kod_kurzu'] = "odmítl účast"; $pole_pro_zobrazeni['prof1_pdf_termin_konani'] = "";
        $pole_pro_zobrazeni['prof1_pdf_skupina'] = ""; $pole_pro_zobrazeni['prof1_pdf_nazev'] = "";

    }              
}
else {
    $pom = $pole['id_s_kurz_prof1_FK'];
    $pole['id_s_kurz_prof1_FK'] = 0;  // tj.= null, !neumime zapsat NULL jako =null
    $pole['prof1_text'] = $pom; //
          // echo "<br>*Kurz nenalezen ";    
}
//echo " id_skurz prof FK "; var_dump($pole['id_s_kurz_prof1_FK']);
//echo " "; var_dump($pole['prof1_text']);






//***** prof2
   $query=" SELECT * FROM  s_kurz  WHERE (s_kurz.id_s_kurz  = '" . $pole['id_s_kurz_prof2_FK'] . "' ) ";    //echo " ***" . $query . "  ";
   $data= $dbh->prepare($query)->execute();
   
if ($skurz = $data->fetch()) {
    $pole['prof2_text'] = text_retezec_kurz($skurz);
           //echo "<br>*Kurz nalezen " . $skurz['id_s_kurz'];
           
     $pole_pro_zobrazeni['prof2_pdf_kod_kurzu'] = $skurz['projekt_kod'] . "_" .$skurz['kurz_druh']. "_" . $skurz['kurz_cislo'] . "_" .
                                                  $skurz['beh_cislo'] . "T_" . $skurz['kurz_zkratka'] ;       // trim($vkurz['kurz_nazev'])." | ".
     $pole_pro_zobrazeni['prof2_pdf_termin_konani'] = $skurz['kurz_termin'];
     $pole_pro_zobrazeni['prof2_pdf_skupina'] = $skurz['kurz_zkratka'];
     $pole_pro_zobrazeni['prof2_pdf_nazev'] = $skurz['kurz_nazev'];
           
           
    if ($pole['id_s_kurz_prof2_FK']== 1) {
        $pole['prof2_text'] = "-------------";
        $pole_pro_zobrazeni['prof2_pdf_kod_kurzu'] = "-------------"; $pole_pro_zobrazeni['prof2_pdf_termin_konani'] = "";
        $pole_pro_zobrazeni['prof2_pdf_skupina'] = ""; $pole_pro_zobrazeni['prof2_pdf_nazev'] = "";

    }
    if ($pole['id_s_kurz_prof2_FK']== 2) {
        $pole['prof2_text'] = "nezařazen";
        $pole_pro_zobrazeni['prof2_pdf_kod_kurzu'] = "nezařazen"; $pole_pro_zobrazeni['prof2_pdf_termin_konani'] = "";
        $pole_pro_zobrazeni['prof2_pdf_skupina'] = ""; $pole_pro_zobrazeni['prof2_pdf_nazev'] = "";

    }
    if ($pole['id_s_kurz_prof2_FK']== 3) {
        $pole['prof2_text'] = "odmítl účast";
        $pole_pro_zobrazeni['prof2_pdf_kod_kurzu'] = "odmítl účast"; $pole_pro_zobrazeni['prof2_pdf_termin_konani'] = "";
        $pole_pro_zobrazeni['prof2_pdf_skupina'] = ""; $pole_pro_zobrazeni['prof2_pdf_nazev'] = "";

    }              
}
else {
    $pom = $pole['id_s_kurz_prof2_FK'];
    $pole['id_s_kurz_prof2_FK'] = 0;  // tj.= null, !neumime zapsat NULL jako =null
    $pole['prof2_text'] = $pom; //
          // echo "<br>*Kurz nenalezen ";    
}
//echo " id_skurz prof2 FK "; var_dump($pole['id_s_kurz_prof2_FK']);
//echo " "; var_dump($pole['prof2_text']);





//***** prof3
   $query=" SELECT * FROM  s_kurz  WHERE (s_kurz.id_s_kurz  = '" . $pole['id_s_kurz_prof3_FK'] . "' ) ";    //echo " ***" . $query . "  ";
   $data= $dbh->prepare($query)->execute();
   
if ($skurz = $data->fetch()) {
    $pole['prof3_text'] = text_retezec_kurz($skurz);
           //echo "<br>*Kurz nalezen " . $skurz['id_s_kurz'];
           
     $pole_pro_zobrazeni['prof3_pdf_kod_kurzu'] = $skurz['projekt_kod'] . "_" .$skurz['kurz_druh']. "_" . $skurz['kurz_cislo'] . "_" .
                                                  $skurz['beh_cislo'] . "T_" . $skurz['kurz_zkratka'] ;       // trim($vkurz['kurz_nazev'])." | ".
     $pole_pro_zobrazeni['prof3_pdf_termin_konani'] = $skurz['kurz_termin'];
     $pole_pro_zobrazeni['prof3_pdf_skupina'] = $skurz['kurz_zkratka'];
     $pole_pro_zobrazeni['prof3_pdf_nazev'] = $skurz['kurz_nazev'];
           
           
    if ($pole['id_s_kurz_prof3_FK']== 1) {
        $pole['prof3_text'] = "-------------";
        $pole_pro_zobrazeni['prof3_pdf_kod_kurzu'] = "-------------"; $pole_pro_zobrazeni['prof3_pdf_termin_konani'] = "";
        $pole_pro_zobrazeni['prof3_pdf_skupina'] = ""; $pole_pro_zobrazeni['prof3_pdf_nazev'] = "";

    }
    if ($pole['id_s_kurz_prof3_FK']== 2) {
        $pole['prof3_text'] = "nezařazen";
        $pole_pro_zobrazeni['prof3_pdf_kod_kurzu'] = "nezařazen"; $pole_pro_zobrazeni['prof3_pdf_termin_konani'] = "";
        $pole_pro_zobrazeni['prof3_pdf_skupina'] = ""; $pole_pro_zobrazeni['prof3_pdf_nazev'] = "";

    }
    if ($pole['id_s_kurz_prof3_FK']== 3) {
        $pole['prof3_text'] = "odmítl účast";
        $pole_pro_zobrazeni['prof3_pdf_kod_kurzu'] = "odmítl účast"; $pole_pro_zobrazeni['prof3_pdf_termin_konani'] = "";
        $pole_pro_zobrazeni['prof3_pdf_skupina'] = ""; $pole_pro_zobrazeni['prof3_pdf_nazev'] = "";

    }              
}
else {
    $pom = $pole['id_s_kurz_prof3_FK'];
    $pole['id_s_kurz_prof3_FK'] = 0;  // tj.= null, !neumime zapsat NULL jako =null
    $pole['prof3_text'] = $pom; //
          // echo "<br>*Kurz nenalezen ";    
}
//echo " id_skurz prof3 FK "; var_dump($pole['id_s_kurz_prof3_FK']);
//echo " "; var_dump($pole['prof3_text']);








       
//*** doplneni textovych retezcu  do sloupcu tabulky uc_plan_flat_table  ..._text  a priprava pro pdf *** konec
//***************************** konec ******************************************************




if ( ($User->username == "sys_admin" ))  {
  echo "<BR>a pole*"; print_r($pole) ; 
}
//exit;



//{
/*******************TADY UKLADAME*******************************************/
  
     $idcka_skolizi_z_formulare =  array();
        
    //Nacteni dat do falt tabulky (objektu)
    $flat_table = new Projektor2_Model_Db_Flat_UcPlanFlatTable($Ucastnik);
    
    $flat_table->read_values();   //PP opatreni pro zachovani=neprepsani udaju v tabulce, neni-li sloupecek ve formulari 
    foreach($pole as $klic => $hodnota) {
        
            //tady !nepriradit! ty policka, co do uc_plan_flat_table nepatri
            
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
 // echo "<hr><br> idcka s_typ_kolize " ;  var_dump($idcka_skolizi_z_formulare);  echo "<hr>";
 //exit;
        
    /*************************************************************************************/
        
    
    if  ($User->povolen_zapis) {  
        if(!$Ucastnik->id) {
         Projektor2_Model_Db_UcastnikMapper::insert($Ucastnik,  $dbh);    //DDBBHH  aby se nevytvarelo pokazde nove pripojeni
        }
        else {
        }
    } 
    
    //echo "<br> Ucastnik-id"  . $Ucastnik->id;
    
    //***********************Ulozeni flat tabulky*********************
    if (($flat_table->chyby->pocet==0)) {
            //if  ($data_users['povolen_zapis']) {
            //     $flat_table->save_values(); //}
            
            if  ($User->povolen_zapis) {
              $flat_table->save();   //zapis do flat tabulky
            
              //*** KOLIZE - zapis  do tabulky uc_kolize_table
              Projektor2_Table_UcKolizeData::Zapis_vsechny_kolize_v_zaveru_formulare ($pole, $idcka_skolizi_z_formulare,  $Ucastnik->id, FORMULAR_PLAN); 
              //*** KOLIZE - zapis  do tabulky uc_kolize_table - konec
            
            }  
    }
        //echo "<BR>ULOZENO!"; exit;
       
    /*************************************************************************************/
    
    if ($flat_table->chyby->pocet) {        //*******byly chyby - odstranujte je*******

        //Jsou chyby, zobrazíme hlášku
        //Vypsání hlavičky stránky //        include "ind_hlavicka.inc";	//	klon
        //Zobrazení loga projektu  //        include"ind_logo_projektu.inc";	//	klon
?>
<h1> Ve formuláři se vyskytly chyby !! </h1>
<br>    <h2> Prosíme, pokuste se je odstranit a uložte formulář znovu </h2>
<br>     
<!-- <h2> Následující seznam se Vám pokusí napovědět </h2><br> -->      
<!--<hr>    Chyby v osobních údajích:   
<br>     
<table border="1">       
  <tr>        <td>Položka</td><td>Hodnota</td><td>Důvod</td>       
  </tr>  -->
<?php
  /*  require_once "chyby_text.inc";
    for($i=0;$i<$Osobni_udaje->chyby->pocet;$i++){
        echo "<tr>\n";
        echo "<td>".$Osobni_udaje->chyby->promnenna[$i]."&nbsp;</td><td>".
                  // $Osobni_udaje->chyby->hodnota[$i].
                  "&nbsp;</td><td>".
                   $chyby_text[$Osobni_udaje->chyby->chyba_cislo[$i]]."&nbsp;</td>\n";
        echo "</tr>\n";
    }*/
    ?>     
<!--</table>    --> 
<hr>    Chyby v ostatních datech: 
<br>     
<table border="1">       
  <tr>        <td>Položka</td><td>Hodnota</td><td>Důvod</td>       
  </tr>
<?php
    require_once "chyby_text.inc";
    for($i=0;$i<$flat_table->chyby->pocet;$i++){
        echo "<tr>\n";
        echo "<td>".$flat_table->chyby->promnenna[$i]."</td><td>".$flat_table->chyby->hodnota[$i]."</td><td>".$chyby_text[$flat_table->chyby->chyba_cislo[$i]]."</td>\n";
        echo "</tr>\n";
    }
    ?>     
</table>

<?php
//        include "ind_plan_uc.inc";	//	klon       
    }
    
    else                // nebyly chyby - vytvoř pdf a vygeneruj obsah stránky
    {
 //       echo "<BR><BR>pole pro zobrazeni*"; print_r($pole_pro_zobrazeni) ;
        $Flat_tab = new Projektor2_Model_Db_Flat_UcFlatTable($Ucastnik , $dbh);         // !! tab. uc_flat_table !ctu z ni jmeno pro zobrazeni!
        $Flat_tab->read_values();
        $Flat_tab_data = $Flat_tab->getValuesAssoc();
        Foreach($Flat_tab_data as $key => $values) {
           // if(!array_key_exists($key,$pole)){
           //     $pole[$key]=$values;                      
           // }
           $pole_pro_zobrazeni[$key]=$values;   
	}
        
 //       echo "<BR><BR>pole pro zobrazeni*"; print_r($pole_pro_zobrazeni) ;
            

        
        if ($tlacitko_tisk <> "" ) {
                       //require "./PDF/SPZP_pdfplan.php";		//vytvori PDF
             if  ($Projekt->kod == "SPZP" ) {
              require "./PDF/SPZP_pdfplan.php"; }
            if  ($Projekt->kod == "RNH" ) {
              require "./PDF/RNH_pdfplan.php";  }
            
            echo '<script type ="text/javascript" src="./zdot.js"></script>'."\n";
            echo '<script type ="text/javascript">';
            //<!--
            echo " Zobraz('". $Ucastnik->identifikator . "','plan','".$filepathprefix."')" ;              // $filepathprefix vznikla v pdfplan.php 
            //-->
            echo '</script>';
        }
        
        
//         include "ind_hlavicka.inc";	//	klon
//         include "ind_logo_projektu.inc";	//	klon      
//         include "ind_plan_uc.inc";	//	klon
        
    }
        
        //header("Location: ./index.php");
//        header("Refresh: 5; url=./index.php");
        
/*********************************KONEC UKLADANI**************************/
      
?>