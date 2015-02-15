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
class Projektor2_View_PDF_Helper_ProjektOsvedceni extends Projektor2_View_PDF_Helper_Base {

    public static function createContent($pdf, $context, $caller) {
        $pdf->SetXY(0,60);

        $blokCentered = new Projektor2_PDF_Blok;
            $blokCentered->ZarovnaniNadpisu('C');
            $blokCentered->ZarovnaniTextu('C');
        $blokCentered30_14 = clone $blokCentered;
            $blokCentered30_14->VyskaPismaNadpisu(30);
            $blokCentered30_14->VyskaPismaTextu(14);
            $blokCentered30_14->ZarovnaniTextu('C');
        $blokCentered20_11 = clone $blokCentered;
            $blokCentered20_11->VyskaPismaNadpisu(20);
            $blokCentered20_11->VyskaPismaTextu(11);
            $blokCentered20_11->ZarovnaniTextu('C');           
        
        $blok = clone $blokCentered30_14;
            $blok->PridejOdstavec('Grafia, společnost s ručením omezeným');
            $blok->PridejOdstavec('se sídlem Budilova 4, 301 21 Plzeň');
            $blok->PridejOdstavec('IČ: 477 14 620');
            $blok->PridejOdstavec('');
            $blok->PridejOdstavec('uděluje');
        $pdf->TiskniBlok($blok);
        
        $blok = clone $blokCentered30_14;
            $blok->Nadpis("CERTIFIKÁT");
            $blok->PridejOdstavec('č. '.$context['certifikat']->identifikator);
        $pdf->TiskniBlok($blok);

        $blok = clone $blokCentered30_14;
            $blok->PridejOdstavec('o absolutoriu projektu');
        $pdf->TiskniBlok($blok);
        
        $blok = clone $blokCentered30_14;
            $blok->PridejOdstavec('„Alternativní práce v Plzeňském kraji“');
        $pdf->TiskniBlok($blok);
        // financovací věta
        $blok = clone $blokCentered20_11;
            $blok->PridejOdstavec($caller::STALY_TEXT_PATICKY);
        $pdf->TiskniBlok($blok);        
        // jméno
        $blok = clone $blokCentered30_14;
            $blok->Nadpis(self::celeJmeno($context[$caller::MODEL_DOTAZNIK]));
        $pdf->TiskniBlok($blok);

        $blok = clone $blokCentered30_14;
        if ($context[$caller::MODEL_DOTAZNIK.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.'pohlavi'] == 'muž') {
            $abs = 'absolvoval';
        } else {
            $abs = 'absolvovala';            
        }
        
        $blok->PridejOdstavec('úspěšně '.$abs.' projekt');
        $pdf->Ln(20);
//        $blok->PridejOdstavec('v rozsahu '.$context[$caller::MODEL_PLAN .$druh.'_poc_abs_hodin'].' hodin');
        $pdf->TiskniBlok($blok);        
                   
        
        
        
}
    
}
