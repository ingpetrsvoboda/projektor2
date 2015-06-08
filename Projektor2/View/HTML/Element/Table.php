<?php
/**
 * Description of Projektor2_View_HTML_Zaznamy
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Element_Table extends Framework_View_Abstract {
    public function render() {
        if (isset($this->context['class'])) {
            $this->parts[] = '<table class='.$this->context['class'].'>';                        
        } else {
            $this->parts[] = '<table>';            
        }        
        foreach ($this->context['rows'] as $row) {
            $this->parts[] = $row;
        }
        $this->parts[] = '</table>';
        return $this;
    }
}
