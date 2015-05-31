<?php
class Projektor2_View_HTML_Ap_Dotaznik extends Framework_View_Abstract {
    public function render() {
        // jen test:
        $this->context['readonly']=TRUE;
        
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
        //fialdset osobní údaje
        $fieldsetOsobniUdaje = new Projektor2_View_HTML_Tag_Fieldset();
        $fieldsetOsobniUdaje->setAttributes($fieldsetAttributes);
        $formElement->addChild($fieldsetOsobniUdaje);

        $legendOsobniUdaje = new Projektor2_View_HTML_Tag_Legend();
        $legendOsobniUdaje->addHtmlPart('Osobní údaje');
        $fieldsetOsobniUdaje->addChild($legendOsobniUdaje);        
        
        $paragraph = new Projektor2_View_HTML_Tag_P();
//        $inputAttributes = new Projektor2_View_HTML_Element_Attributes_Input(array('id'=>'dotaznik->titul', 'type'=>'text', 'name'=>'dotaznik->titul', 'size'=>'3', 'maxlength'=>'10', 'value'=>$this->context['dotaznik->titul']));
//        $inputView = new Projektor2_View_HTML_Element_Input($this->context, $inputAttributes);
//        $fieldsetElement->addChild($inputView->assign('label', 'Titul: ')->assign('readonly', $readonly));
        $paragraph->addChild(Projektor2_View_HTML_Element_Helper_Input::textLabeled($this->context, 'dotaznik->titul', 'Titul: ', $readonly, 10))
                ->addChild(Projektor2_View_HTML_Element_Helper_Input::textLabeled($this->context, 'dotaznik->jmeno', 'Jméno: ', $readonly, 30))
                ->addChild(Projektor2_View_HTML_Element_Helper_Input::textLabeled($this->context, 'dotaznik->prijmeni', 'Příjmení: ', $readonly, 30))
                ->addChild(Projektor2_View_HTML_Element_Helper_Input::textLabeled($this->context, 'dotaznik->titul_za', 'Titul za: ', $readonly, 10))
                ->addChild(Projektor2_View_HTML_Element_Helper_Input::textLabeled($this->context, 'dotaznik->pohlavi', 'Pohlaví: ', $readonly, 12));
        $fieldsetOsobniUdaje->addChild($paragraph);        

        $paragraph = new Projektor2_View_HTML_Tag_P();        
        $paragraph->addChild(Projektor2_View_HTML_Element_Helper_Input::dateLabeled($this->context, 'dotaznik->datum_narozeni', 'Datum narození: ', $readonly))
                ->addChild(Projektor2_View_HTML_Element_Helper_Input::textLabeled($this->context, 'dotaznik->rodne_cislo', 'Rodné číslo: ', $readonly, 20));
        $fieldsetOsobniUdaje->addChild($paragraph);        
        //fieladset údaje zájemce -- !! display:none
        $fieldsetUdajeZajemceAttributes = new Projektor2_View_HTML_Tag_Attributes_Fieldset(array('class'=>$fieldsetClass, 'style'=>'display:none'));
//        $fieldsetUdajeZajemceAttributes = new Projektor2_View_HTML_Tag_Attributes_Fieldset(array('class'=>$fieldsetClass));
        $fieldsetUdajeZajemce = new Projektor2_View_HTML_Tag_Fieldset();
        $fieldsetUdajeZajemce->setAttributes($fieldsetUdajeZajemceAttributes);
        $formElement->addChild($fieldsetUdajeZajemce);

        $legendUdajeZajemce = new Projektor2_View_HTML_Tag_Legend();
        $legendUdajeZajemce->addHtmlPart('Údaje zájemce');
        $fieldsetUdajeZajemce->addChild($legendUdajeZajemce);         
        $paragraph = new Projektor2_View_HTML_Tag_P();        
        $paragraph->addChild(Projektor2_View_HTML_Element_Helper_Input::dateLabeled($this->context, 'dotaznik->datum_reg', 'Datum vstupu do projektu: ', $readonly));
        $fieldsetUdajeZajemce->addChild($paragraph);         
        $paragraph = new Projektor2_View_HTML_Tag_P();        
        $paragraph->addChild(Projektor2_View_HTML_Element_Helper_Input::textLabeled($this->context, 'dotaznik->z_up', 'Vysílající úřad práce: ', $readonly, 20))
                ->addChild(Projektor2_View_HTML_Element_Helper_Input::textLabeled($this->context, 'dotaznik->prac_up', 'Pracoviště úřadu práce: ', $readonly, 20));
        $fieldsetUdajeZajemce->addChild($paragraph);        
        $paragraph = new Projektor2_View_HTML_Tag_P();        
        $paragraph ->addChild(Projektor2_View_HTML_Element_Helper_Input::textLabeled($this->context, 'dotaznik->stav', 'Stav osoby: ', $readonly, 20));
        $fieldsetUdajeZajemce->addChild($paragraph);
        $paragraph = new Projektor2_View_HTML_Tag_P();        
        $paragraph->addChild(Projektor2_View_HTML_Element_Helper_Input::textLabeled($this->context, 'dotaznik->zam_osvc_neaktivni', 'Jedná-li se o zájemce o zaměstnání, zvolte zaměstnanec/OSVČ: ', $readonly, 20));
        $fieldsetUdajeZajemce->addChild($paragraph);
        $paragraph = new Projektor2_View_HTML_Tag_P();        
        $paragraph->addChild(Projektor2_View_HTML_Element_Helper_Input::textLabeled($this->context, 'dotaznik->datum_poradenstvi_zacatek', 'Datum zahájení individuálního poradenství: ', $readonly, 20));
        $fieldsetUdajeZajemce->addChild($paragraph);        
//        $inputAttributes = new Projektor2_View_HTML_Element_Attributes_Input(array('type'=>'submit', 'name'=>'B1', 'value'=>'Uložit'));
//        $inputView = new Projektor2_View_HTML_Element_Input($this->context, $inputAttributes);
//        $fieldsetElement->addChild($inputView->assign('readonly', $readonly));
        $this->context['B1'] = 'Uložit';
        $formElement->addChild(Projektor2_View_HTML_Element_Helper_Input::submit($this->context, 'B1', $readonly));
        $this->context['B2'] = 'Zruš provedené změny';
        $formElement->addChild(Projektor2_View_HTML_Element_Helper_Input::submit($this->context, 'B2', $readonly));
        if ($this->context['dotaznik->id_zajemce']){
            $this->context['pdf'] = 'Tiskni dotazník';
            $formElement->addChild(Projektor2_View_HTML_Element_Helper_Input::submit($this->context, 'pdf', $readonly));
        }
        $this->parts[] = $formElement;
        return $this;
    }
}
