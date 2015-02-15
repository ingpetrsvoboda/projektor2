<?php
class Projektor2_PDF_SadaBunek
{
    public $nadpis;
    public $bunky;
    public $barvaPisma;
    public $vyskaPismaNadpisu;
    public $vyskaPismaBunek;
    public $mezeraPredNadpisem;
    public $mezeraPredSadouBunek;
    public $zarovnaniNadpisu;    
    public $odsazeniZleva;
    public $sadaNeniPrazdna;
    public $sadaSpustena;
    
    protected $id;

    const NADPIS = "";
    const BUNKY = "";
    const BARVA_PISMA = "0,0,0";
    const VYSKA_PISMA_NADPISU = 12;
    const VYSKA_PISMA_BUNEK = 10;
    const MEZERA_PRED_NADPISEM = 4;
    const MEZERA_PRED_SADOU_BUNEK = 2;    
    const ZAROVNANI_NADPISU = "L";    
    const ODSAZENI_ZLEVA = 0;
    const MAX_RADKU = 8;

    

        // vlastnost sadaSpustena je true, pokud při vytváření
        // sady buněk byla alespoň jedna SpousteciBunka s jinou hodnotou než $prazdnaHodnota
    public function __construct($nadpis=self::NADPIS, $bunky=self::BUNKY, $barvaPisma=self::BARVA_PISMA,
                                $vyskaPismaNadpisu=self::VYSKA_PISMA_NADPISU, $mezeraPredNadpisem=self::MEZERA_PRED_NADPISEM, 
                                $mezeraPredSadouBunek=  self::MEZERA_PRED_SADOU_BUNEK,                    
                                $zarovnaniNadpisu=self::ZAROVNANI_NADPISU, $vyskaPismaBunek=self::VYSKA_PISMA_BUNEK,
                                $odsazeniZleva=self::ODSAZENI_ZLEVA)
    {
      $this->nadpis = $nadpis;
      $this->bunky = $bunky;
      $this->barvaPisma = $barvaPisma;
      $this->vyskaPismaNadpisu = $vyskaPismaNadpisu;
      $this->vyskaPismaBunek = $vyskaPismaBunek;
      $this->mezeraPredNadpisem = $mezeraPredNadpisem;
      $this->mezeraPredSadouBunek = $mezeraPredSadouBunek;
      $this->zarovnaniNadpisu = $zarovnaniNadpisu;
      $this->odsazeniZleva = $odsazeniZleva;
      $this->sadaNeniPrazdna = false;
      $this->sadaSpustena = false;
      $this->id = 0;
    }
         
    function Nadpis($textUTF8)
    {
        $this->nadpis=$textUTF8;
    }

    /**
     * Funkce přidá buňku do sady buněk a pokud $promennaUTF8 není prázdná, nastaví vlastnost sadaNeniPrazdna na true,
     * @param string $titulekUTF8 Titulek buňky (text vlevo před buňkou) v kódování UTF8
     * @param string $promennaUTF8 Hodnota zobrazená v buňce
     * @param boolean $odradkovani Odřádkování za buňkou
     * @param type $sirka Šířka buňky
     * @param type $prazdnaHodnota Hodnota, jejíž výskyt v obsahu buňky (promennaUTF8) bude považována za prázdnou 
     * @param type $vyska Výška buňky
     * @param type $ohraniceni Ohraničení Buňky
     * @param type $zarovnani Zarovnání buňky
     * @param type $vypln Výplň buňky
     * @param string $link
     */
    function PridejBunku($titulekUTF8='', $promennaUTF8='', $odradkovani=FALSE, $sirka=0, $prazdnaHodnota=false, $vyska=0,  $ohraniceni=0, $zarovnani='', $vypln=false, $link='') {
        $this->id = $this->id+1;
        $b = new Projektor2_PDF_Bunka($this->id, $sirka, $vyska, $titulekUTF8, $promennaUTF8, $ohraniceni, $odradkovani, $zarovnani, $vypln, $link='');
        if ($prazdnaHodnota) {
            if (substr_count($promennaUTF8, $prazdnaHodnota)*strlen($prazdnaHodnota) <> strlen($promennaUTF8)) {
                $this->sadaNeniPrazdna = true;
                $b->debugPrazdna = $this->id." neprazdna: ".$titulekUTF8."|".$promennaUTF8."#".$prazdnaHodnota."|";
            }        	
        } elseif ($promennaUTF8) {
            $this->sadaNeniPrazdna = true;       	
            $b->debugPrazdna = $this->id." neprazdna: ".$titulekUTF8."|".$promennaUTF8."#".$prazdnaHodnota."|";
        }
        $this->bunky[] =  $b;
    }
  
    /**
     * Funkce nastaví vlastnost sadaSpustena na hodnotu parametru $spoust
     * @param boolean $spoust
     */
    function SpustSadu($spoust=false)
    {
    	if ($spoust)
    	{
    		      $this->sadaSpustena = true;
    	}
    }
    
    /**
     * Funkce vyhodnoti, jestli parametr $promennaUTF8 obsahuje jiný znak než znak $prazdnaHodnota,
     * pokud ano, nastaví vlastnost sadaSpustena na true
     * @param character $prazdnaHodnota
     * @param string $promennaUTF8
     */
    function Spoust($prazdnaHodnota=false, $promennaUTF8=false)  
    {
	echo "SPOUST - strlen :";     echo (strlen($promennaUTF8));
	echo "SPOUST - substr_count :";     echo (substr_count($promennaUTF8, $prazdnaHodnota));
	
    	if (substr_count($promennaUTF8, $prazdnaHodnota) <> strlen($promennaUTF8))
      	{
    		      $this->sadaSpustena = true;
    	}
    }    
    /**
     * Funkce vloží $pocet nových řádků o výšce $vyska 
     * @param real $vyska
     * @param integer $pocet
     */
    function NovyRadek($vyska=0, $pocet=1)
    {
    	self::PridejBunku('',false, 1, 0, 0);
    	for ($i=1; $i<=$pocet; $i++)
    	{
    		self::PridejBunku('',false, 1, 0, $vyska);
    	}
    }
    
    function BarvaPisma($barvaPisma = self::BARVA_PISMA)
    {
    	$this->barvaPisma = $barvaPisma;
    }
    
    function VyskaPismaNadpisu($vyskaPismaNadpisu = self::VYSKA_PISMA_NADPISU)
    {
    	$this->VyskaPismaNadpisu = $vyskaPismaNadpisu;
    }
        
    function VyskaPismaBunek($vyskaPismaBunek = self::VYSKA_PISMA_BUNEK)
    {
    	$this->VyskaPismaBunek = $vyskaPismaBunek;
    }
    
    public function MezeraPredNadpisem($mezeraPredNadpisem = self::MEZERA_PRED_NADPISEM) {
        $this->mezeraPredNadpisem = $mezeraPredNadpisem;
    }
    
    public function MezeraPredSadouBunek($mezeraPredSadouBunek = self::MEZERA_PRED_NADPISEM) {
        $this->mezeraPredSadouBunek = $mezeraPredSadouBunek;
    }
    
    function OdsazeniZleva($odsazeniZleva = self::ODSAZENI_ZLEVA)
    {
    	$this->OdsazeniZleva = $odsazeniZleva;
    }

    public function ZarovnaniNadpisu($ZarovnaniNadpisu = self::ZAROVNANI_NADPISU) {
        $this->zarovnaniNadpisu = $ZarovnaniNadpisu;
    }
}
