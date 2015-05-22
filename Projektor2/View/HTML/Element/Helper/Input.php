<?php
/**
 * Description of Projektor2_View_HTML_Element_Helper_Input
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Element_Helper {
    public static function inputTextLabeled($sessionStatus, $context, $name, $label) {
        $inputView = new Projektor2_View_HTML_Element_Input($sessionStatus);
        $inputView
                ->assign('label', 'Titul: ')
                ->assign('attributes', array('id'=>'dotaznik->titul', 'type'=>'text', 'name'=>'dotaznik->titul', 'size'=>'3', 'maxlength'=>'10', 'value'=>$this->context['dotaznik->titul']))
                ->assign('readonly', $readonly);        
    }
    
}
