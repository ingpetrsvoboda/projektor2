<?php
/**
 * Description 
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Element_ZajemceRegistrace extends Framework_View_Abstract {
    
    /**
     * Vrací element tr
     * @return \Projektor2_View_HTML_Element_ZajemceRegistrace
     */
    public function render() {
        $zajemceRegistrace = $this->context['zajemceRegistrace'];
        
        $this->parts[]= '<tr>';
        $this->parts[]= '<td class=identifikator>' . $zajemceRegistrace->identifikator . '</td>';
        $this->parts[]= '<td class=identifikator>' . $zajemceRegistrace->znacka . '</td>';
        $this->parts[]= '<td class=jmeno>' . $zajemceRegistrace->jmeno_cele.'</td>';
        $this->parts[]= $this->context['htmlSkupiny']; 
        $this->parts[]= '</tr>';        
        return $this;
    }
}
