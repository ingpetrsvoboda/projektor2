<?php
/**
 * Description of Chyby
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Element_Input extends Projektor2_View_HTML_Element {

    public function render() { 
        if (!isset($this->attributes)) {
            $this->attributes = new Projektor2_View_HTML_Element_Attributes_Input(array('type'=>'text'));
        }
        // inputy jsou readonly nebo disabled, inputy pro datum jsou typu text (a readonly)      
        if (isset($this->context['readonly']) AND $this->context['readonly']) {
//            if (isset($this->attributes->type)) {
//                $type = $this->attributes->type;
//            } else {
//                $type = NULL;
//            }
            switch ($this->attributes->type) {
                case 'button':
                case 'number':
                case 'radio':
                case 'checkbox';
                    $this->attributes->disabled = 'disabled';
                    break;

                case 'date':
                    $this->attributes->type = 'text';                
                    $this->attributes->readonly = 'readonly';
                    break;
                
                case 'text':
                default:
                    $this->attributes->readonly = 'readonly';
                    break;
            }
        }   
        if (isset($this->context['label']) AND $this->context['label']) {
            if (isset($this->attributes->id)) {
                $this->parts[] = '<label for="'.$this->attributes->id.'">'.$this->context['label'].'</label>';                
                $this->parts[] = '<input '.$this->attributes->getAttributesString().'></input>';                
            } else {
                $this->parts[] = '<label>'.$this->context['label'].'>';                
                $this->parts[] = '<input '.$this->attributes->getAttributesString().'></input>';                
                $this->parts[] = '</label>';                
            }
        } else {
            $this->parts[] = '<input '.$this->attributes->getAttributesString().'></input>';             
        }
        
        return $this;
    }
    
}

?>
