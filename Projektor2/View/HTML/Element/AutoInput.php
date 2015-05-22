<?php
/**
 * Description of Chyby
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Element_AutoInput extends Projektor2_View_HTML_Element_Input {
        
    protected function initialize() {
        parent::initialize();
        if (!$this->attributes['type']) {
            $this->attributes['type'] = 'text';
        }
        if (!$this->attributes['id'] AND isset($this->context['name'])) {
            $this->attributes['id'] = $this->context['name'];
        }
        if (!$this->attributes['name'] AND isset($this->context['name'])) {
            $this->attributes['name'] = $this->context['name'];
        }       
        if (!$this->attributes['name'] AND isset($this->context['name'])) {
            $this->attributes['name'] = $this->context['name'];
        }         
        
        
    }
}

?>
