<?php
class Projektor2_ItemID {
    public $p_cislo_projektu;
    public $b_cislo_rozsahu;
    public $c_cislo_kontextu;
    public $u_cislo_polozky;
    public $i_cislo_identifikacni;
    public $c_cislo_behu;
    public $c_oznaceni_turnusu;
    private $m_kontrola_modulo;
    private $pozice_cisla_polozky = array(1243,2143,3124,4123,2341,3412,4312,1432,2431,4213);
    private $nas_pivoty = array(3,8,9,2,1,10,8,4,9,5);
    
    public function __construct($cislo_projektu = false,$cislo_rozsahu = false,$cislo_kontextu = false) {
        $this->p_cislo_projektu=$cislo_projektu;
        $this->b_cislo_rozsahu=$cislo_rozsahu;
        $this->c_cislo_kontextu=$cislo_kontextu;
    }
    
    public function over_cislo($kontrolovane_cislo){
        $kontrolovane_cislo = trim($kontrolovane_cislo);
        if(strlen($kontrolovane_cislo)==10 && is_numeric($kontrolovane_cislo)) {
            $this->p_cislo_projektu = substr($kontrolovane_cislo,3,2);
            $this->b_cislo_rozsahu = substr($kontrolovane_cislo,1,2);
            $this->c_cislo_kontextu = substr($kontrolovane_cislo,0,1);
            $this->m_kontrola_modulo = substr($kontrolovane_cislo,9,1);
            $this->u_cislo_polozky=substr($kontrolovane_cislo,5,1)*pow(10,4-substr($this->pozice_cisla_polozky[$this->m_kontrola_modulo],0,1));
            $this->u_cislo_polozky+=substr($kontrolovane_cislo,6,1)*pow(10,4-substr($this->pozice_cisla_polozky[$this->m_kontrola_modulo],1,1));
            $this->u_cislo_polozky+=substr($kontrolovane_cislo,7,1)*pow(10,4-substr($this->pozice_cisla_polozky[$this->m_kontrola_modulo],2,1));
            $this->u_cislo_polozky+=substr($kontrolovane_cislo,8,1)*pow(10,4-substr($this->pozice_cisla_polozky[$this->m_kontrola_modulo],3,1));
            $this->u_cislo_polozky=$this->strvalnn($this->u_cislo_polozky,4);
            //$this->u_cislo_polozky=substr($kontrolovane_cislo,4+substr($this->pozice_cisla_polozky[$this->m_kontrola_modulo],0,1),1);
            //$this->u_cislo_polozky.=substr($kontrolovane_cislo,4+substr(strval($this->pozice_cisla_polozky[$this->m_kontrola_modulo]),1,1),1);
            //$this->u_cislo_polozky.=substr($kontrolovane_cislo,4+substr(strval($this->pozice_cisla_polozky[$this->m_kontrola_modulo]),2,1),1);
            //$this->u_cislo_polozky.=substr($kontrolovane_cislo,4+substr(strval($this->pozice_cisla_polozky[$this->m_kontrola_modulo]),3,1),1);
            $kontrolovane_cislo_dekod = $this->c_cislo_kontextu.$this->b_cislo_rozsahu.$this->p_cislo_projektu.$this->u_cislo_polozky;
            $i=0;
            $kontrolni_soucet=0;
            While($i<=strlen($kontrolovane_cislo_dekod)){
                $kontrolni_soucet+=$this->nas_pivoty[$i]*substr($kontrolovane_cislo_dekod,$i,1);
                $i++;
            }
            $kontrolni_soucet_mod = $kontrolni_soucet%11;
            if($kontrolni_soucet_mod == 10) {
                $kontrolni_soucet_mod = 0;
            }
            if($kontrolni_soucet_mod ==$this->m_kontrola_modulo) {
                $this->i_cislo_identifikacni=$kontrolovane_cislo;
                return true;
            }
            else {
                return false;
            }
            
        }
        else {
            return false;
        }
    }
    
    public function generuj_cislo(){
        
        //Kontrola zadanych parametru
        if($this->p_cislo_projektu &&  $this->b_cislo_rozsahu && $this->c_cislo_kontextu && $this->u_cislo_polozky) {     /*ss*/
            
           // echo "<br>rozsah " . $this->b_cislo_rozsahu;
           // echo "<br>projekt " . $this->p_cislo_projektu;
           // echo "<br>beh " . $this->c_cislo_behu;
           // echo "<br>cpolozka " . $this->u_cislo_polozky;
            
            
            $this->i_cislo_identifikacni = "2" .
                                        $this->strnn($this->b_cislo_rozsahu,2) .
                                        $this->strnn($this->p_cislo_projektu,2) .
                                        $this->strnn($this->c_oznaceni_turnusu,2) .
                                        $this->strnn($this->u_cislo_polozky,3) ;
            
            /*
            $cislo_dekod=strval($this->c_cislo_kontextu);
            $cislo_dekod.=$this->strvalnn($this->b_cislo_rozsahu,2);
            $cislo_dekod.=$this->strvalnn($this->p_cislo_projektu,2);
            $cislo_dekod.=$this->strvalnn($this->u_cislo_polozky,4);
            $i=0;
            $kontrolni_soucet=0;
            While($i<=strlen($cislo_dekod)){
                $kontrolni_soucet+=$this->nas_pivoty[$i]*substr($cislo_dekod,$i,1);
                $i++;
            }
            $this->m_kontrola_modulo=$kontrolni_soucet%11;
            if($this->m_kontrola_modulo==10){
                $this->m_kontrola_modulo=0;
            }
            
            
            //prehozeni cislic
            $this->i_cislo_identifikacni=substr($cislo_dekod,0,5);
            $cislo_kod=substr($cislo_dekod,4+substr($this->pozice_cisla_polozky[$this->m_kontrola_modulo],0,1),1)*1000;
            $cislo_kod+=substr($cislo_dekod,4+substr($this->pozice_cisla_polozky[$this->m_kontrola_modulo],1,1),1)*100;
            $cislo_kod+=substr($cislo_dekod,4+substr($this->pozice_cisla_polozky[$this->m_kontrola_modulo],2,1),1)*10;
            $cislo_kod+=substr($cislo_dekod,4+substr($this->pozice_cisla_polozky[$this->m_kontrola_modulo],3,1),1)*1;
            $this->i_cislo_identifikacni.=$this->strvalnn($cislo_kod,4).strval($this->m_kontrola_modulo);
            */
            
            return $this->i_cislo_identifikacni;
        }
        else {
            return "";
        }
        
        
    }
    
    
    function strnn($cislo,$pocet_mist)
    {
        $retezec = strval($cislo);
        $retezec = str_pad($retezec, $pocet_mist, "0", STR_PAD_LEFT);
        return $retezec;
    }
    
    
    function strvalnn($cislo,$pocet_mist){
        if(is_int($pocet_mist) && $pocet_mist>0) {
            $i=$pocet_mist-1;
            $retezec="";
            $cislo=(int)$cislo;
            while($cislo<pow(10,$i)) {
                $retezec.="0";
                $i--;
            }
            $retezec.=strval($cislo);
            return $retezec;
        }
        else{
            return "";
        }
    }
        
        
        
}
?>