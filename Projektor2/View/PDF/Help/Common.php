<?php
/**
 * Description of Projektor2_View_PDF_DotaznikCommon
 * Spoločné části pro všechny dokumenty používající data z dotazníku
 *
 * @author pes2704
 */
abstract class Projektor2_View_PDF_Help_Common extends Projektor2_View_PDF_Common {  
    const STALY_TEXT_PATICKY = "\n Projekt Help 50+ CZ.1.04/3.3.05/96.00249 je financován z Evropského sociálního fondu prostřednictvím OP LZZ a ze státního rozpočtu ČR.";
    
    protected function setHeaderFooter($textPaticky=NULL) {
        parent::completeHeader("./img/loga/loga_HELP50+_BW.png", 165,11);
        parent::completeFooter( $textPaticky . self::STALY_TEXT_PATICKY );
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
        $grafia->PridejOdstavec("jako příjemce podpory (dále jen „Příjemce“)");
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
        $osobniUdaje->PridejOdstavec("identifikační číslo účastníka: ".$this->context["identifikator"]);
        $osobniUdaje->PridejOdstavec("(dále jen „Účastník“)");
        $this->pdf->TiskniBlok($osobniUdaje);   
    }
    
    protected function tiskniPodpisy($modelSmlouva) {
        $podpisy = new Projektor2_PDF_SadaBunek();        
        $podpisy->PridejBunku('', '', FALSE, 20);
        $podpisy->PridejBunku("Účastník:", '', FALSE, 100);
        $podpisy->PridejBunku("Příjemce:","",TRUE);
        $podpisy->NovyRadek(0,3);
        $podpisy->PridejBunku('', '', FALSE, 15);
        $podpisy->PridejBunku("......................................................", '', FALSE, 100);
        $podpisy->PridejBunku("......................................................","",TRUE);
        $podpisy->PridejBunku('', '', FALSE, 20);
        $podpisy->PridejBunku($this->celeJmeno($modelSmlouva), '', FALSE, 100);
        $podpisy->PridejBunku($this->context['user_name'], '', TRUE);
        $podpisy->PridejBunku('', '', FALSE, 120);
        $podpisy->PridejBunku(" okresní poradce projektu","",TRUE);

        $this->pdf->TiskniSaduBunek($podpisy, 0, 1);        
    }
    
    protected function tiskniPodpis($modelSmlouva) {
        $podpisy = new Projektor2_PDF_SadaBunek();        
        $podpisy->PridejBunku('', '', FALSE, 110);
        $podpisy->PridejBunku("Účastník:", '',TRUE);
        $podpisy->NovyRadek(0,4);
        $podpisy->PridejBunku('', '', FALSE, 110);
        $podpisy->PridejBunku("......................................................", '',TRUE);
        $podpisy->PridejBunku('', '', FALSE, 115);
        $podpisy->PridejBunku($this->celeJmeno($modelSmlouva), '', TRUE);

        $this->pdf->TiskniSaduBunek($podpisy, 0, 1);        
    }    
    
    protected function tiskniMistoDatum($modelSmlouva, $datum) {
        $mistoDatum = new Projektor2_PDF_SadaBunek();
        $mistoDatum->MezeraPredSadouBunek(8);
        $mistoDatum->PridejBunku('', '', FALSE, 0);  //odsazeni zleva
        $mistoDatum->PridejBunku("Konzultační centrum: ", $this->context['kancelar_plny_text'], TRUE);
        $mistoDatum->NovyRadek(0,1);
        $mistoDatum->PridejBunku('', '', FALSE, 0);
        $mistoDatum->PridejBunku("Dne ",$datum,1);
        $mistoDatum->NovyRadek(0,1);
        $this->pdf->TiskniSaduBunek($mistoDatum, 0, 1);        
    }
}

?>
