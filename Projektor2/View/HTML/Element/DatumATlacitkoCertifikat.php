<?php
/**
 * Description of Projektor2_View_HTML_Element_DatumATlacitkoCertifikat
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Element_DatumATlacitkoCertifikat extends Framework_View_Abstract {
    
    public function render() {
        if (isset($this->context['readonly']) AND $this->context['readonly']) {
            // inputy jsou readonly nebo disabled, inputy pro datum jsou typu text (a readonly)
            $readonlyAttribute = ' readonly="readonly" ';
            $disabledAttribute = ' disabled="disabled" ';
            $dateInputType = 'text';
        } else {
            // inputy nejsou readonly ani disabled, inputy pro datum jsou typu date
            $readonlyAttribute = '';
            $disabledAttribute = '';
            $dateInputType = 'date';            
        }
        $zobrazTiskniCertifikat = (isset($this->context['zobrazTiskniCertifikat']) AND $this->context['zobrazTiskniCertifikat']) ? TRUE : FALSE;

        if (isset($this->context['valueDatumCertif']) AND $this->context['valueDatumCertif']) {
            $displayTiskniCertifikat = 'block';
        } else {
            $displayTiskniCertifikat = 'none';
        }        
        $idTiskniCertifikat = $this->context['druhKurzu'].'_tiskni_certifikat';    

        $this->parts[] = '<div id="'.$this->context['idBlokCertifikat'].'" style="display:'.$this->context['displayBlokCertifikat'].'">';
        $this->parts[] = '<p>';
        $this->parts[] = '<label>Datum vydání osvědčení: </label>';
        $inputTag = '<input type="'.$dateInputType.'" '
                . 'name="'.$this->context['nameDatumCertif'].'"'
                . 'value="'.$this->context['valueDatumCertif'].'" '
                . $disabledAttribute;
        if ($zobrazTiskniCertifikat) {
            $inputTag .= ' onChange="showIfNotEmpty(\''.$idTiskniCertifikat.'\', this);"';
        }
        $inputTag .= '>'
                . '</input>';
        $this->parts[] = $inputTag;
        $this->parts[] = '</p>';
        if ($zobrazTiskniCertifikat) {
            $this->parts[] ='<p id="'.$idTiskniCertifikat.'" style="display:'.$displayTiskniCertifikat.'">';
            $this->parts[] ='<button '
                    . 'type="submit" value="Tiskni osvědčení '.$this->context['druhKurzu'].'" '
                    . 'name="pdf" '.$disabledAttribute.'>'
                    . 'Tiskni osvědčení'
                    . '</button>';
            $this->parts[] ='</p> ';
        }
        $this->parts[] ='</div> ';   
        return $this;
    }
}
