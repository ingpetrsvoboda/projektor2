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
class Projektor2_View_PDF_Helper_UkonceniAktivitKurz extends Projektor2_View_PDF_Helper_Base {

    public static function createContent($pdf, $context, $caller, $dolniokrajAPaticka, $mistoDatumPodpisy) {
        $count = count($context['kurzyPlan']);
        if ($count) {
            $counter = 0;
            foreach($context['kurzyPlan'] as $aktivita) {
//                    $kurzPlan = new Projektor2_Model_KurzPlan();
                if (isset($aktivita->sKurz) AND $aktivita->sKurz->isNaplanovan()) {
                    $counter++;
                    $yPositionBefore = $pdf->getY(); 
                    $kurzSadaBunek = new Projektor2_PDF_SadaBunek();
                    $kurzSadaBunek->SpustSadu(true);
                    $kurzSadaBunek->Nadpis($aktivita->nadpisAktivity);
                    $kurzSadaBunek->MezeraPredNadpisem(4);
                    $kurzSadaBunek->ZarovnaniNadpisu("L");
                    $kurzSadaBunek->VyskaPismaNadpisu(11);
                    $kurzSadaBunek->MezeraPredSadouBunek(1);
//                        $kurzSadaBunek->PridejBunku("Název kurzu: ",$context[$druh.'_kurz']->kurz_nazev, 1);
//                        $kurzSadaBunek->PridejBunku("Termín konání: ",$context[$druh.'_kurz']->date_zacatek.' - '.$context[$druh.'_kurz']->date_konec, 1);
                    $kurzSadaBunek->PridejBunku("Název kurzu: ",$aktivita->sKurz->kurz_nazev, 1);
                    $kurzSadaBunek->PridejBunku("Termín konání: ",$aktivita->sKurz->date_zacatek.' - '.$aktivita->sKurz->date_konec, 1);
                    $kurzSadaBunek->PridejBunku("Počet absolvovaných hodin: ", $aktivita->pocAbsHodin,1);
                    if ($aktivita->duvodAbsence) {
                        $kurzSadaBunek->PridejBunku("Důvod absence: ", $aktivita->duvodAbsence, 1);
                    }
                    $kurzSadaBunek->PridejBunku("Dokončeno úspěšně: ", $aktivita->dokoncenoUspesne,1);
                    if ($aktivita->dokoncenoUspesne == "Ne") {
                        $kurzSadaBunek->PridejBunku("Důvod neúspěšného ukončení: ", $aktivita->duvodNeuspechu,1);
                    }
                    $pdf->TiskniSaduBunek($kurzSadaBunek); 
                    if ($aktivita->dokoncenoUspesne == "Ano" AND $aktivita->aktivitaSCertifikatem) {
                        $vyhodnoceni = new Projektor2_PDF_Blok();
                        $vyhodnoceni->Nadpis('Osvědčení o absolvování kurzu v projektu');
                        $vyhodnoceni->vyskaPismaNadpisu(9);
                        $vyhodnoceni->Odstavec("Účastníkovi bylo vydáno osvědčení dne: ".$aktivita->datumCertif);
                        $pdf->TiskniBlok($vyhodnoceni);
                    }
                    if ($context[$caller::MODEL_UKONCENI.$aktivita->indexAktivity.'_hodnoceni']) {
                        $vyhodnoceni = new Projektor2_PDF_Blok();
                        $vyhodnoceni->Nadpis('Hodnocení');
                        $vyhodnoceni->vyskaPismaNadpisu(9);
                        $vyhodnoceni->Odstavec($context[$caller::MODEL_UKONCENI.$aktivita->indexAktivity.'_hodnoceni']);
                        $pdf->TiskniBlok($vyhodnoceni);
                    }                        
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
