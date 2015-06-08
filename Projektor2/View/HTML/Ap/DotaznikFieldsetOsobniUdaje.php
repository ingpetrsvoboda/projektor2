<?php
class Projektor2_View_HTML_Ap_DotaznikFieldsetOsobniUdaje extends Projektor2_View_HTML_Tag {
    public function render() {
        
        if (isset($this->context['readonly']) AND $this->context['readonly']) {
            $readonly = TRUE;
            $fieldsetClass = 'readonly';
        } else {
            $readonly = FALSE;
            $fieldsetClass = '';
        }
        
        $fieldseAttributes = new Projektor2_View_HTML_Tag_Attributes_Fieldset(array('class'=>$fieldsetClass));        
        $fieldset = new Projektor2_View_HTML_Tag_Fieldset();
        $fieldset->setAttributes($fieldseAttributes);        
        $legend = new Projektor2_View_HTML_Tag_Legend();
        $legend->addHtmlPart('Osobní údaje');
        $fieldset->addChild($legend);        
        
        $paragraph = new Projektor2_View_HTML_Tag_P();
//        $inputAttributes = new Projektor2_View_HTML_Element_Attributes_Input(array('id'=>'dotaznik->titul', 'type'=>'text', 'name'=>'dotaznik->titul', 'size'=>'3', 'maxlength'=>'10', 'value'=>$this->context['dotaznik->titul']));
//        $inputView = new Projektor2_View_HTML_Element_Input($this->context, $inputAttributes);
//        $fieldsetElement->addChild($inputView->assign('label', 'Titul: ')->assign('readonly', $readonly));
        $paragraph->addChild(Projektor2_View_HTML_Tag_Helper_Input::textLabeled($this->context, 'dotaznik->titul', 'Titul: ', $readonly, 10))
                ->addChild(Projektor2_View_HTML_Tag_Helper_Input::textLabeled($this->context, 'dotaznik->jmeno', 'Jméno: ', $readonly, 30))
                ->addChild(Projektor2_View_HTML_Tag_Helper_Input::textLabeled($this->context, 'dotaznik->prijmeni', 'Příjmení: ', $readonly, 30))
                ->addChild(Projektor2_View_HTML_Tag_Helper_Input::textLabeled($this->context, 'dotaznik->titul_za', 'Titul za: ', $readonly, 10))
                ->addChild(Projektor2_View_HTML_Tag_Helper_Input::textLabeled($this->context, 'dotaznik->pohlavi', 'Pohlaví: ', $readonly, 12));
        $fieldset->addChild($paragraph);        

        $paragraph = new Projektor2_View_HTML_Tag_P();        
        $paragraph->addChild(Projektor2_View_HTML_Tag_Helper_Input::dateLabeled($this->context, 'dotaznik->datum_narozeni', 'Datum narození: ', $readonly))
                ->addChild(Projektor2_View_HTML_Tag_Helper_Input::textLabeled($this->context, 'dotaznik->rodne_cislo', 'Rodné číslo: ', $readonly, 20));
        $fieldset->addChild($paragraph);  
        
        $this->parts[] = $fieldset;
        return $this;
    }
}
