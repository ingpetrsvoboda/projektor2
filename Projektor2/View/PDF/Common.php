<?php
/**
 * Společné části pro všechny dokumenty používající data z dotazníku
 *
 * @author pes2704
 */
abstract class Projektor2_View_PDF_Common extends Projektor2_View_PDF_Base{
    
    
    protected function initialize() {
        $pdfdebug = Projektor2_PDFContext::getDebug();
        $pdfdebug->debug(0);
        $this->pdf = new Projektor2_PDF_PdfCreator();
        $this->pdf->AddFont('Times','','times.php');
        $this->pdf->AddFont('Times','B','timesbd.php');
        $this->pdf->AddFont("Times","BI","timesbi.php");
        $this->pdf->AddFont("Times","I","timesi.php");
        $this->pdf->AddPage();   //uvodni stranka                
    }
    
    
    
    protected function completeHeader($logoFileName=NULL, $sirka, $vyska ) {
        $pdfhlavicka = Projektor2_PDFContext::getHlavicka();
        $pdfhlavicka->zarovnani("C");
        $pdfhlavicka->vyskaPisma(14);
        if ($logoFileName) {
            if (is_readable($logoFileName)) {
                $pdfhlavicka->obrazek($logoFileName, null, null, $sirka, $vyska);
            } else {
                throw new UnexpectedValueException('Zadán neexistující soubor s obrázkem do hlavičky dokumentu: '.$logoFileName.'.');
            }
        }
    }   
    protected function completeFooter( $textPaticky=NULL, $cislovani=TRUE) {    
        $pdfpaticka = Projektor2_PDFContext::getPaticka();
        if ($textPaticky) {
            $pdfpaticka->Odstavec($textPaticky);
        }
        $pdfpaticka->zarovnani("C");
        $pdfpaticka->vyskaPisma(6);
        $pdfpaticka->cislovani = $cislovani;
    }
    
    

    protected function tiskniTitul(array $textyTitulu, $naStredStrany=FALSE) {
        if ($naStredStrany) {
            $this->pdf->Ln(125-count($textyTitulu)*20);
        }
        $titulka1 = new Projektor2_PDF_Blok;
        $titulka1->MezeraPredNadpisem(0);
        $titulka1->ZarovnaniNadpisu("C");
        $titulka1->VyskaPismaNadpisu(14);
        foreach ($textyTitulu as $textTitulu) {
            $titulka1->Nadpis($textTitulu);
            $this->pdf->TiskniBlok($titulka1);            
            $titulka1->MezeraPredNadpisem(3);            
        }
        if ($naStredStrany) {
            $this->pdf->AddPage();   //uvodni stranka            
        }        
    }    
    
    protected function tiskniPodpisCertifikat() {
        $podpisy = new Projektor2_PDF_Blok(); 
        $podpisy->VyskaPismaTextu(12);
        $podpisy->ZarovnaniTextu('C');
        $podpisy->PridejOdstavec("......................................................");
        $podpisy->PridejOdstavec($this->context['managerName'], '');
        $podpisy->PridejOdstavec(" manažer projektu","");

        $this->pdf->TiskniBlok($podpisy);          
    }
    
    protected function celeJmeno($modelSmlouva) {   //--vs
        $celeJmeno = $this->context[$modelSmlouva."titul"]." ".  $this->context[$modelSmlouva ."jmeno"]." ".  $this->context[$modelSmlouva ."prijmeni"];
        if ($this->context[$modelSmlouva ."titul_za"]) {
            $celeJmeno = $celeJmeno.", ".  $this->context[$modelSmlouva ."titul_za"];
        }       
        return $celeJmeno;        
    }
    
    protected function celaAdresa($ulice='', $mesto='', $psc='') {
        $celaAdresa = '';
        if ($ulice) {
            $celaAdresa .= $ulice;
            if  ($mesto) {
                $celaAdresa .=  ", ".$mesto;
            }
            if  ($psc) {
                $celaAdresa .= ", ".$psc;
            }
        } else {
            if  ($mesto)  {
                $celaAdresa .= $mesto;
                if  ($psc) {
                    $celaAdresa .= ", " .$psc;
                }
            } else {
                if  ($psc) {
                    $celaAdresa .= $psc;
                }
            }
        }  
        return $celaAdresa;
    }
    
    protected function datumBezNul($datum) {
        $tokens = explode('.', $datum);
        foreach ($tokens as $key=>$value) {
            $tokens[$key] = (int) $value;
        }
        return \implode('.', $tokens);
    }
}

?>
