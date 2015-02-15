<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of KurzOsvedceni
 *
 * @author pes2704
 */
class Projektor2_View_PDF_Helper_UkonceniAktivitPoradenstvi extends Projektor2_View_PDF_Helper_Base {

    public static function createContent($pdf, $context, $caller, $dolniokrajAPaticka, $mistoDatumPodpisy) {
        $count = count($context['aktivityProjektuTypuPoradenstvi']);
        if ($count) {
            $counter = 0;
            foreach($context['aktivityProjektuTypuPoradenstvi'] as $indexAktivity=>$aktivita) {
//                    $kurzPlan = new Projektor2_Model_KurzPlan();
                if ($context[$caller::MODEL_UKONCENI.$indexAktivity.'_hodnoceni']) {
                    $counter++;
                    $yPositionBefore = $pdf->getY();  

                    $vyhodnoceni=new Projektor2_PDF_Blok();
                    $vyhodnoceni->Nadpis($aktivita['nadpis']);
                    $vyhodnoceni->vyskaPismaNadpisu(11);
                    $vyhodnoceni->Odstavec($context[$caller::MODEL_UKONCENI.'vyhodnoceni']);                        
                    $vyhodnoceni->PridejOdstavec($context[$caller::MODEL_UKONCENI.$indexAktivity.'_hodnoceni']);
                    $pdf->TiskniBlok($vyhodnoceni);

                    if ($counter == $count-1) {
                        $potrebneMisto = $dolniokrajAPaticka+$mistoDatumPodpisy;                        
                    } else {
                        $potrebneMisto = $dolniokrajAPaticka;
                    }
                    if (($pdf->h - $potrebneMisto - $pdf->getY()) < ($pdf->getY() - $yPositionBefore)) {
                        $pdf->AddPage();
                    }                        
                }               
            }
            if (!$counter) {
                $bezAktivit = new Projektor2_PDF_Blok();
                $bezAktivit->Odstavec("Účastníkovi nebyly naplánovány žádné aktivity.");
                $pdf->TiskniBlok($bezAktivit);  
            }                
        } else {
            $bezAktivit = new Projektor2_PDF_Blok();
            $bezAktivit->Odstavec("V projektu nelze plánovat žádné aktivity.");
            $pdf->TiskniBlok($bezAktivit);                      
        }        
        
}
    
}
