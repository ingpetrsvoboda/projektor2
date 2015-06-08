<?php
ob_start();

require_once "save_zpracuj_cookie.inc";
 
//echo "****<br>ind_zarad_do_agp.inc****";    //  *SEL*


//$pole = $_POST;
//echo "<BR>POST*"; print_r($_POST) ; 
//echo "<BR>pole*"; print_r($pole) ; 

//echo "<BR>*Ucastnik v ind_zarad_do_agp* ";  print_r ($Ucastnik); /*exit;*/ // tady neni id ucastnika
//echo "<BR>*GET id_ucastnik*";  print_r ($_GET['id_ucastnik']); 

//echo  "<BR>*Ucastnik-Kancelar-id* ";  print_r($Ucastnik-> kancelar->id);    //*
//echo "<BR>" . $Kancelar->id;

//echo  "<BR>*data_users* "  ;    print_r($data_users);
//echo  "<BR>*data_users[id_sys_users]* "  ; echo $data_users['id_sys_users'];   //*

//$id_ucastnik_pro_zapis_do_agp=$_GET['id_ucastnik'];


$dbh = Projektor2_AppContext::getDb();

$query= "SELECT   count(*) as  vysl_pocet," .
         " id_sys_users_FK, id_c_kancelar_puvodni_FK, id_c_kancelar_agentura_FK  FROM trans_kancelar " . 
          " WHERE id_sys_users_FK = " . $data_users['id_sys_users'] . " and id_c_kancelar_puvodni_FK = " . $Ucastnik-> kancelar->id   ;
 
      //echo "<br>*select: " . $query;
      
 $data = $dbh->prepare($query)->execute();
 //  echo "<BR>** **<BR>" ; print_r($data);
  
  // vzdy jeden -(count(*))
  $zaznam = $data->fetch();
     //echo "<BR>zaznam*vysl_pocet* "  . $zaznam['vysl_pocet'];
     
     if ($zaznam['vysl_pocet']==0) {
         echo "<BR>Chyba: V této kanceláři nemůžete provést zařazení do Personal Service! (Viz tbl. trans_kancelar.)";
     }
     elseif ($zaznam['vysl_pocet']>1) {
         echo "<BR>Chyba: Převedení nelze provést. (Nejednoznačná identifikace kanceláře.)";
     }
     elseif ($zaznam['vysl_pocet']==1){
         
         //$dbh = AppContext::getDB();
         $query= "UPDATE zajemce SET valid=1, id_c_projekt_FK=6, id_s_beh_projektu_FK=24, " . 
                 " id_c_kancelar_FK=" . $zaznam['id_c_kancelar_agentura_FK'] .
                 " WHERE id_zajemce="  .  $_GET['id_ucastnik'] ;
         echo "<br>*update : " . $query;
  
         $data1 = $dbh->prepare($query)->execute();
         
 
         
     }
     else {
        echo "<BR>Chyba: Převedení nelze provést."; 
        exit;
     }
     
 

//*********update zaznamu o zajemci
 // $query= "UPDATE zajemce SET valid=1, id_c_projekt_FK=6, id_s_beh_projektu_FK=24 " . 
 //         " WHERE id_zajemce ="  .  $_GET['id_ucastnik'] ;
      //echo "<br>*update : " . $query;
 // $data = $dbh->prepare($query)->execute();
  




      
?>