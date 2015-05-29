<?php
class Projektor2_View_HTML_Ap_Dotaznik extends Framework_View_Abstract {

    public function render() {
        // jen test:
//        $this->context['readonly']=TRUE;
        
        if (isset($this->context['readonly']) AND $this->context['readonly']) {
            $readonly = TRUE;
            $fieldsetClass = 'readonly';
        } else {
            $readonly = FALSE;
            $fieldsetClass = '';
        }
        
        $this->parts[] = '<H3>Příloha IP 1. část</H3>';
        $this->parts[] = '<H3>DOTAZNÍK</H3>';

//        $this->parts[] = '<form method="POST" action="index.php?akce=form&form=ap_reg_dot" name="dotaznik->form_dotaznik">';
        $formAttributes = new Projektor2_View_HTML_Element_Attributes_Form(array('method'=>'POST', 'action'=>'index.php?akce=form&form=ap_reg_dot', 'name'=>'dotaznik->form_dotaznik'));
        $formElement = new Projektor2_View_HTML_Element_Form();
        $formElement->setAttributes($formAttributes);

        $fieldsetAttributes = new Projektor2_View_HTML_Element_Attributes_Fieldset(array('class'=>$fieldsetClass));
        $fieldsetElement = new Projektor2_View_HTML_Element_Fieldset();
        $fieldsetElement->setAttributes($fieldsetAttributes);
        $formElement->addChild($fieldsetElement);

//        $fieldsetElement->addHtmlPart('<LEGEND style="color:white;"><b>Osobní údaje</b></LEGEND>');
//        $legendAttributes = new Projektor2_View_HTML_Element_Attributes_Legend(array('style'=>'color:white;'));
        $legendElement = new Projektor2_View_HTML_Element_Legend();
        $legendElement->addHtmlPart('Osobní údaje');
        $fieldsetElement->addChild($legendElement);        
        
//        $inputAttributes = new Projektor2_View_HTML_Element_Attributes_Input(array('id'=>'dotaznik->titul', 'type'=>'text', 'name'=>'dotaznik->titul', 'size'=>'3', 'maxlength'=>'10', 'value'=>$this->context['dotaznik->titul']));
//        $inputView = new Projektor2_View_HTML_Element_Input($this->context, $inputAttributes);
//        $fieldsetElement->addChild($inputView->assign('label', 'Titul: ')->assign('readonly', $readonly));
//        
        $fieldsetElement->addChild(Projektor2_View_HTML_Element_Helper_Input::textLabeled($this->context, 'dotaznik->titul', 'Titul: ', $readonly, 10));
        $fieldsetElement->addChild(Projektor2_View_HTML_Element_Helper_Input::textLabeled($this->context, 'dotaznik->jmeno', 'Jméno: ', $readonly, 30));
        $fieldsetElement->addChild(Projektor2_View_HTML_Element_Helper_Input::textLabeled($this->context, 'dotaznik->prijmeni', 'Příjmení: ', $readonly, 30));
        
//        $inputAttributes = new Projektor2_View_HTML_Element_Attributes_Input(array('type'=>'submit', 'name'=>'B1', 'value'=>'Uložit'));
//        $inputView = new Projektor2_View_HTML_Element_Input($this->context, $inputAttributes);
//        $fieldsetElement->addChild($inputView->assign('readonly', $readonly));
        
        $this->context['B1'] = 'Uložit';
        $fieldsetElement->addChild(Projektor2_View_HTML_Element_Helper_Input::submit($this->context, 'B1', $readonly));
        $this->context['B2'] = 'Zruš provedené změny';
        $fieldsetElement->addChild(Projektor2_View_HTML_Element_Helper_Input::submit($this->context, 'B2', $readonly));
        if ($this->context['dotaznik->id_zajemce']){
            $this->context['pdf'] = 'Tiskni dotazník';
            $fieldsetElement->addChild(Projektor2_View_HTML_Element_Helper_Input::submit($this->context, 'pdf', $readonly));
        }
        $this->parts[] = $formElement;
        return $this;
    }
}

?>
