<?php
class Projektor2_View_HTML_Ap_DotaznikFieldsetUdajeZajemce extends Projektor2_View_HTML_Tag {
    public function render() {
        
        if (isset($this->context['readonly']) AND $this->context['readonly']) {
            $readonly = TRUE;
            $fieldsetClass = 'readonly';
        } else {
            $readonly = FALSE;
            $fieldsetClass = '';
        }
               
        $fieldsetAttributes = new Projektor2_View_HTML_Tag_Attributes_Fieldset(array('class'=>$fieldsetClass));
        $fieldset = new Projektor2_View_HTML_Tag_Fieldset();
        $fieldset->setAttributes($fieldsetAttributes);

        $legend = new Projektor2_View_HTML_Tag_Legend();
        $legend->addHtmlPart('Údaje zájemce');
        $fieldset->addChild($legend);         
        $paragraph = new Projektor2_View_HTML_Tag_P();        
        $paragraph->addChild(Projektor2_View_HTML_Tag_Helper_Input::dateLabeled($this->context, 'dotaznik->datum_reg', 'Datum vstupu do projektu: ', $readonly));
        $fieldset->addChild($paragraph);         
        $paragraph = new Projektor2_View_HTML_Tag_P();        
        $paragraph->addChild(Projektor2_View_HTML_Tag_Helper_Input::textLabeled($this->context, 'dotaznik->z_up', 'Vysílající úřad práce: ', $readonly, 20))
                ->addChild(Projektor2_View_HTML_Tag_Helper_Input::textLabeled($this->context, 'dotaznik->prac_up', 'Pracoviště úřadu práce: ', $readonly, 20));
        $fieldset->addChild($paragraph);        
        $paragraph = new Projektor2_View_HTML_Tag_P();        
        $paragraph ->addChild(Projektor2_View_HTML_Tag_Helper_Input::textLabeled($this->context, 'dotaznik->stav', 'Stav osoby: ', $readonly, 20));
        $fieldset->addChild($paragraph);
        $paragraph = new Projektor2_View_HTML_Tag_P();        
        $paragraph->addChild(Projektor2_View_HTML_Tag_Helper_Input::textLabeled($this->context, 'dotaznik->zam_osvc_neaktivni', 'Jedná-li se o zájemce o zaměstnání, zvolte zaměstnanec/OSVČ: ', $readonly, 20));
        $fieldset->addChild($paragraph);
        $paragraph = new Projektor2_View_HTML_Tag_P();        
        $paragraph->addChild(Projektor2_View_HTML_Tag_Helper_Input::textLabeled($this->context, 'dotaznik->datum_poradenstvi_zacatek', 'Datum zahájení individuálního poradenství: ', $readonly, 20));
        $fieldset->addChild($paragraph);   
        
        $this->parts[] = $fieldset;
        return $this;    }
}
