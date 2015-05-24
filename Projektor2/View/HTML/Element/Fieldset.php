<?php
/**
 * Description of Chyby
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Element_Fieldset extends Projektor2_View_HTML_Element {


    public function render() { 
        if (isset($this->attributes)) {
            $this->parts = array_merge(array('<fieldset '.$this->attributes->getAttributesString().'>'), $this->childrens, array('</fieldset>'));
        } else {
            $this->parts = array_merge(array('<fieldset>'), $this->childrens, array('</fieldset>'));            
        }
        return $this;
    }
    
}

?>
