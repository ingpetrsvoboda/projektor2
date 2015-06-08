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

        $formAttributes = new Projektor2_View_HTML_Tag_Attributes_Form(array('method'=>'POST', 'action'=>'index.php?akce=form&form=ap_reg_dot', 'name'=>'dotaznik->form_dotaznik'));
        $formElement = new Projektor2_View_HTML_Tag_Form();
        $formElement->setAttributes($formAttributes);

        $fieldsetAttributes = new Projektor2_View_HTML_Tag_Attributes_Fieldset(array('class'=>$fieldsetClass));
        // osobní údaje
        $formElement->addChild(new Projektor2_View_HTML_Ap_DotaznikFieldsetOsobniUdaje($this->context));
        
        // údaje zájemce -- !! byl nasteven fieladset display:none
        $formElement->addChild(new Projektor2_View_HTML_Ap_DotaznikFieldsetUdajeZajemce($this->context));
        // bydliště a kontaktní údaje
        $formElement->addChild(new Projektor2_View_HTML_Ap_DotaznikFieldsetBydlisteAKontaktniUdaje($this->context));
//        $inputAttributes = new Projektor2_View_HTML_Element_Attributes_Input(array('type'=>'submit', 'name'=>'B1', 'value'=>'Uložit'));
//        $inputView = new Projektor2_View_HTML_Element_Input($this->context, $inputAttributes);
//        $fieldsetElement->addChild($inputView->assign('readonly', $readonly));
        $this->context['B1'] = 'Uložit';
        $formElement->addChild(Projektor2_View_HTML_Tag_Helper_Input::submit($this->context, 'B1', $readonly));
        $this->context['B2'] = 'Zruš provedené změny';
        $formElement->addChild(Projektor2_View_HTML_Tag_Helper_Input::submit($this->context, 'B2', $readonly));
        if ($this->context['dotaznik->id_zajemce']){
            $this->context['pdf'] = 'Tiskni dotazník';
            $formElement->addChild(Projektor2_View_HTML_Tag_Helper_Input::submit($this->context, 'pdf', $readonly));
        }
        $this->parts[] = $formElement;
        return $this;
    }
}
