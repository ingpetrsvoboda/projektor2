<?php
/**
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

    
    //-------------------------------------------------------------------------
    
    protected function setHeaderFooter($textPaticky=NULL, $cislovani=TRUE) {
        switch ($this->sessionStatus->projekt->kod) {
            case 'AP':
                self::completeHeader( "./img/loga/loga_AP_BW.png", 165,14 );
                self::completeFooter( $textPaticky 
                                    . "\nProjekt Alternativní práce v Plzeňském kraji CZ.1.04/2.1.00/70.00055 je financován z Evropského "
                                    . "sociálního fondu prostřednictvím OP LZZ a ze státního rozpočtu ČR.", $cislovani);
                break;
            case 'AGP':
                self::completeHeader( "./img/loga/logo_agp_bw.png", 165,26 );
                self::completeFooter( $textPaticky , $cislovani);
                break; 
            case 'HELP':
                self::completeHeader("./img/loga/loga_HELP50+_BW.png", 165,11);
                self::completeFooter( $textPaticky 
                                    . "\n Projekt Help 50+ CZ.1.04/3.3.05/96.00249 je financován z Evropského "
                                    . "sociálního fondu prostřednictvím OP LZZ a ze státního rozpočtu ČR.", $cislovani);          
                break;              
            case 'SJZP':
                self::completeHeader("./img/loga/loga_OPLZZ_BW.jpg", 125,18);
                self::completeFooter( $textPaticky 
                                    . "\n Projekt S jazyky za prací v Karlovarském kraji CZ.1.04/2.1.01/D8.00020 je financován "
                                    . "z ESF prostřednictvím OP LZZ a ze státního rozpočtu ČR.", $cislovani);        
                break;
            default:
                throw new RuntimeException('Nepodarilo se vytvorit pdf - neosetrene HeaderFooter ');      
                break;
        }
    }
    
     protected function TiskniGrafiaUdaje() {   
         
        $grafia = new Projektor2_PDF_Blok;
        $grafia->Odstavec("Grafia, společnost s ručením omezeným");
        $grafia->PridejOdstavec("zapsaná v obchodním rejstříku vedeném Krajským soudem v Plzni, odd. C, vl. 3067");
        $grafia->PridejOdstavec("sídlo: Plzeň, Budilova 4, PSČ 301 21");
        $grafia->PridejOdstavec("zastupující: Mgr. Jana Brabcová, jednatelka společnosti");
        $grafia->PridejOdstavec("IČ: 47714620");
        $grafia->PridejOdstavec("DIČ: CZ 47714620");
        $grafia->PridejOdstavec("bankovní spojení: ČSOB");
        $grafia->PridejOdstavec("č. účtu:  275795033/0300");
        $grafia->PridejOdstavec("zapsán v obchodním rejstříku vedeném Krajským soudem v Plzni, v oddílu C vložka 3067"); 
        switch ($this->sessionStatus->projekt->kod) {
            case 'AP':
            case 'AGP': 
                $grafia->PridejOdstavec("jako dodavatel (dále jen „Dodavatel“)");                     
                break;       
            case 'HELP':    
            case 'SJZP': 
                $grafia->PridejOdstavec("jako příjemce podpory (dále jen „Příjemce“)");                 
                break;     
            default:
                throw new RuntimeException('Nepodarilo se vytvorit pdf - neosetrene GrafiaUdaje ');      
                break;
        }
        $grafia->mezeraMeziOdstavci(1.5);
        $grafia->Radkovani(1);
        $this->pdf->TiskniBlok($grafia);   
    }    
    
    
    protected function tiskniOsobniUdaje($modelSmlouva) {
        $osobniUdaje = new Projektor2_PDF_Blok;
        $osobniUdaje->MezeraMeziOdstavci(1.5);
        $osobniUdaje->Radkovani(1);

        $osobniUdaje->Odstavec("jméno, příjmení, titul: ".$this->celeJmeno($modelSmlouva));
        $osobniUdaje->PridejOdstavec("bydliště: ".$this->celaAdresa($this->context[$modelSmlouva."ulice"], $this->context[$modelSmlouva."mesto"], $this->context[$modelSmlouva."psc"]));
        $celaAdresa2 = $this->celaAdresa($this->context[$modelSmlouva ."ulice2"], $this->context[$modelSmlouva."mesto2"], $this->context[$modelSmlouva ."psc2"]);
        if  ($celaAdresa2) {
            $osobniUdaje->PridejOdstavec("adresa dojíždění odlišná od místa bydliště: ".$celaAdresa2);
        }
        $osobniUdaje->PridejOdstavec("nar.: " . $this->context[$modelSmlouva ."datum_narozeni"]);
        switch ($this->sessionStatus->projekt->kod) {
            case 'AP': 
                $osobniUdaje->PridejOdstavec("identifikační číslo účastníka: ".$this->context["identifikator"]);
                $osobniUdaje->PridejOdstavec("identifikační značka účastníka: ".$this->context["znacka"]);        
                $osobniUdaje->PridejOdstavec("(dále jen „Účastník“)");                 
                break;            
            case 'AGP': 
                $osobniUdaje->PridejOdstavec("identifikační číslo zájemce: ".$this->context["identifikator"]);               
                $osobniUdaje->PridejOdstavec("(dále jen „Zájemce“)");                
                break;
            case 'HELP':     
            case 'SJZP':     
                $osobniUdaje->PridejOdstavec("identifikační číslo účastníka: ".$this->context["identifikator"]);
                $osobniUdaje->PridejOdstavec("(dále jen „Účastník“)");               
                break;     
            default:
                throw new RuntimeException('Nepodarilo se vytvorit pdf - neosetrene OsobniUdaje ');                
                break;
        }
        $this->pdf->TiskniBlok($osobniUdaje); 
    }
    
    protected function tiskniPodpisy($modelSmlouva) {
        $podpisy = new Projektor2_PDF_SadaBunek();        
        $podpisy->PridejBunku('', '', FALSE, 20);
        switch ($this->sessionStatus->projekt->kod) {
            case 'AP':                 
                $podpisy->PridejBunku("Účastník:", '', FALSE, 100);
                $podpisy->PridejBunku("Dodavatel:","",TRUE);                
                break;
            case 'AGP':              
                $podpisy->PridejBunku("Zájemce:", '', FALSE, 100);
                $podpisy->PridejBunku("Dodavatel:","",TRUE);                  
                break;        
            case 'HELP':   
            case 'SJZP':     
                $podpisy->PridejBunku("Účastník:", '', FALSE, 100);
                $podpisy->PridejBunku("Příjemce:","",TRUE);              
                break;                
            default:
                throw new RuntimeException('Nepodarilo se vytvorit pdf - neosetrene Podpisy ');    
                break;
        }
        $podpisy->NovyRadek(0,3);
        $podpisy->PridejBunku('', '', FALSE, 15);
        $podpisy->PridejBunku("......................................................", '', FALSE, 100);
        $podpisy->PridejBunku("......................................................","",TRUE);
        $podpisy->PridejBunku('', '', FALSE, 20);
        $podpisy->PridejBunku($this->celeJmeno($modelSmlouva), '', FALSE, 100);
        $podpisy->PridejBunku($this->context['user_name'], '', TRUE);
        $podpisy->PridejBunku('', '', FALSE, 120);        
        switch ($this->sessionStatus->projekt->kod) {
            case 'AP':                                 
            case 'AGP':                                                
            case 'HELP':   
                $podpisy->PridejBunku(" okresní poradce projektu","",TRUE);
                break;    
            case 'SJZP':     
                $podpisy->PridejBunku("koordinátor projektu","",TRUE);        
                break;                
            default:
                throw new RuntimeException('Nepodarilo se vytvorit pdf - neosetrene Podpisy ');    
                break;
        }            
        $this->pdf->TiskniSaduBunek($podpisy, 0, 1);    
    }
    
    
     //vola se v AP!!!!!!!!!!
    protected function tiskniPodpisUcastnik($modelSmlouva) {
        switch ($this->sessionStatus->projekt->kod) {
            case 'AP': 
                $podpisy = new Projektor2_PDF_SadaBunek();        
                $podpisy->PridejBunku('', '', FALSE, 110);
                $podpisy->PridejBunku("Účastník:", '',TRUE);
                $podpisy->NovyRadek(0,4);
                $podpisy->PridejBunku('', '', FALSE, 110);
                $podpisy->PridejBunku("......................................................", '',TRUE);
                $podpisy->PridejBunku('', '', FALSE, 115);
                $podpisy->PridejBunku($this->celeJmeno($modelSmlouva), '', TRUE);
                $this->pdf->TiskniSaduBunek($podpisy, 0, 1);    
            break;

            default:
                 throw new RuntimeException('Nepodarilo se vytvorit pdf - neosetrene PodpisUcastnik '); 
                break;
        }
    }   
    
    //vola se v AGP!!!!!!!!!  a HELP!!!!!!!!!! a SJZP!!!!!!!!!!!!!!!!!!!!!!!
    protected function tiskniPodpis($modelSmlouva) {
        switch ($this->sessionStatus->projekt->kod) {
            case 'AGP': 
            case 'HELP':    
            case 'SJZP':    
                $podpisy = new Projektor2_PDF_SadaBunek();        
                $podpisy->PridejBunku('', '', FALSE, 110);
                $podpisy->PridejBunku("Účastník:", '',TRUE);
                $podpisy->NovyRadek(0,4);
                $podpisy->PridejBunku('', '', FALSE, 110);
                $podpisy->PridejBunku("......................................................", '',TRUE);
                $podpisy->PridejBunku('', '', FALSE, 115);
                $podpisy->PridejBunku($this->celeJmeno($modelSmlouva), '', TRUE);
                $this->pdf->TiskniSaduBunek($podpisy, 0, 1);     
                break;                               
            default:
                throw new RuntimeException('Nepodarilo se vytvorit pdf - neosetrene Podpis ');    
                break;
        }
                
    }    
    
    
    //vola se v AP!!!!!!!!!!
    protected function tiskniPodpisPoradce($modelSmlouva) {
        switch ($this->sessionStatus->projekt->kod) {
            case 'AP': 
                $podpisy = new Projektor2_PDF_SadaBunek();        
                $podpisy->PridejBunku('', '', FALSE, 110);
                $podpisy->PridejBunku("Dodavatel:", '',TRUE);
                $podpisy->NovyRadek(0,4);
                $podpisy->PridejBunku('', '', FALSE, 110);
                $podpisy->PridejBunku("......................................................", '',TRUE);
                $podpisy->PridejBunku('', '', FALSE, 115);
                $podpisy->PridejBunku($this->context['user_name'], '', TRUE);

                $this->pdf->TiskniSaduBunek($podpisy, 0, 1);   
            break;

            default:
                break;
        }
    }
    
    protected function tiskniMistoDatum($modelSmlouva, $datum) {
        switch ($this->sessionStatus->projekt->kod) {
            case 'AGP':             
            case 'AP': 
            case 'HELP': 
            case 'SJZP': 
                $mistoDatum = new Projektor2_PDF_SadaBunek();
                $mistoDatum->MezeraPredSadouBunek(8);
                $mistoDatum->PridejBunku('', '', FALSE, 0);  //odsazeni zleva
                $mistoDatum->PridejBunku("Konzultační centrum: ", $this->context['kancelar_plny_text'], TRUE);
                $mistoDatum->NovyRadek(0,1);
                $mistoDatum->PridejBunku('', '', FALSE, 0);
                $mistoDatum->PridejBunku("Dne ",$datum,1);
                $mistoDatum->NovyRadek(0,1);
                $this->pdf->TiskniSaduBunek($mistoDatum, 0, 1);   
                break;
            default:
                 throw new RuntimeException('Nepodarilo se vytvorit pdf - neosetrene MistoDatum ');
                break;
        }
    }
    
    
    
}


?>
