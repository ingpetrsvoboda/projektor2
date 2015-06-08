<?php
/**
 * Description of Base
 *
 * @author pes2704
 */
class Projektor2_View_PDF_Helper_Base {

    
    protected static function celeJmeno(Projektor2_Model_Db_Flat_ZaFlatTable $modelSmlouva) {   //--vs
        $celeJmeno = $modelSmlouva->titul." ".$modelSmlouva->jmeno." ".$modelSmlouva->prijmeni;
        if ($modelSmlouva->titul_za) {
            $celeJmeno = $celeJmeno.", ".$modelSmlouva->titul_za;
        }       
        return $celeJmeno;        
    }
    
    protected static function celaAdresa($ulice='', $mesto='', $psc='') {
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
    
    protected static function datumBezNul($datum) {
        $tokens = explode('.', $datum);
        foreach ($tokens as $key=>$value) {
            $tokens[$key] = (int) $value;
        }
        return \implode('.', $tokens);
    }    
    
    
}
