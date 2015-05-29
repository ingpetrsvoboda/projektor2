<?php
/**
 * Description of Projektor2_View_HTML_Element_Helper_Input
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Element_Helper_Input {
    public static function text($context, $name, $readonly=FALSE, $maxlength=NULL) {
        if (!$maxlength) {
            $maxlength = 256;
        }
        $size = $maxlength>10 ? min(array($maxlength, 25)): max(array($maxlength-7, 1));
        $inputAttributes = new Projektor2_View_HTML_Element_Attributes_Input(array('id'=>$name, 'type'=>'text', 'name'=>$name, 'size'=>$size, 'maxlength'=>$maxlength, 'value'=>$context[$name]));
        if ($readonly) {
            self::setReadonly($inputAttributes);
        }
        return new Projektor2_View_HTML_Element_Input($context, $inputAttributes);
    }
    
    public static function textLabeled($context, $name, $label, $readonly=FALSE, $maxlength=NULL) {
        $inputView = self::text($context, $name, $readonly, $maxlength);
        $labelAttributes = new Projektor2_View_HTML_Element_Attributes_Label();                
        $labelView = new Projektor2_View_HTML_Element_Label($context, $labelAttributes);
        return $labelView->addHtmlPart($label)->addChild($inputView);
    }
    
    public static function submit($context, $name, $readonly=FALSE) {
        $inputAttributes = new Projektor2_View_HTML_Element_Attributes_Input(array('type'=>'submit', 'name'=>$name, 'value'=>$context[$name]));
        if ($readonly) {
            self::setReadonly($inputAttributes);
        }
        return new Projektor2_View_HTML_Element_Input($context, $inputAttributes);
    }
    
    // inputy jsou readonly nebo disabled, inputy pro datum jsou typu text (a readonly)      
    private static function setReadonly(Projektor2_View_HTML_Element_Attributes_Input &$attributes) {
        switch ($attributes->type) {
            case 'button':
            case 'submit':
            case 'number':
            case 'radio':
            case 'checkbox';
                $attributes->disabled = 'disabled';
                break;

            case 'date':
                $attributes->type = 'text';                
                $attributes->readonly = 'readonly';
                break;

            case 'text':
            default:
                $attributes->readonly = 'readonly';
                break;
        }
        return $attributes;
    }
    
}
