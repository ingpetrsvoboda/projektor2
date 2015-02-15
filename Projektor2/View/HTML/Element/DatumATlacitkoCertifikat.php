<?php
/**
 * Description of Projektor2_View_HTML_Element_DatumATlacitkoCertifikat
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Element_DatumATlacitkoCertifikat extends Framework_View_Abstract {
    
    public function render() {
        if (isset($this->context['readonly']) AND $this->context['readonly']) {
            $readonlyAttribute = ' readonly="readonly" ';
            $disabledAttribute = ' disabled="disabled" ';
            $dateInputType = 'text';
        } else {
            $readonlyAttribute = '';
            $disabledAttribute = '';
            $dateInputType = 'date';            
        }
        if (isset($this->context['valueDatumCertif']) AND $this->context['valueDatumCertif']) {
            $displayTiskniCertifikat = 'block';
        } else {
            $displayTiskniCertifikat = 'none';
        }        
        $idTiskniCertifikat = $this->context['druhKurzu'].'_tiskni_certifikat';    

        $this->parts[] ='<div id="'.$this->context['idBlokCertifikat'].'" style="display:'.$this->context['displayBlokCertifikat'].'">'
                . '<p>'
                . '<label>Datum vydání osvědčení: </label>'
                . '<input type="'.$dateInputType.'" '
                . 'name="'.$this->context['nameDatumCertif'].'"'
                . 'value="'.$this->context['valueDatumCertif'].'" '
                . $disabledAttribute
                . ' onChange="showIfNotEmpty(\''.$idTiskniCertifikat.'\', this);">'
                . '</input>'
                . '</p>';

        $this->parts[] ='<p id="'.$idTiskniCertifikat.'" style="display:'.$displayTiskniCertifikat.'">'
//                . '<input id="'.$this->context['idTiskniCertifikat'].'" '
                . '<input '
                . 'type="submit" value="Tiskni osvědčení '.$this->context['druhKurzu'].'" '
                . 'name="pdf" '.$disabledAttribute.'>'
                . '</input>'
                . '</p> ';
        $this->parts[] ='</div> ';   
        return $this;
    }
}
