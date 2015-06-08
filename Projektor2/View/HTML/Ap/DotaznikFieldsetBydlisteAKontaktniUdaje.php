<?php
class Projektor2_View_HTML_Ap_DotaznikFieldsetBydlisteAKontaktniUdaje extends Projektor2_View_HTML_Tag {
    public function render() {
        
        if (isset($this->context['readonly']) AND $this->context['readonly']) {
            $readonly = TRUE;
            $fieldsetClass = 'readonly';
        } else {
            $readonly = FALSE;
            $fieldsetClass = '';
        }

        //atributy se použijí pro všechny fieldsety
        $fieldsetAttributes = new Projektor2_View_HTML_Tag_Attributes_Fieldset(array('class'=>$fieldsetClass));
        $fieldset = new Projektor2_View_HTML_Tag_Fieldset();
        $fieldset->setAttributes($fieldsetAttributes);
        $legend = new Projektor2_View_HTML_Tag_Legend();
        $fieldset->addChild($legend->addHtmlPart('Bydliště a kontaktní údaje')); 
        
        $fieldsetTrvale = new Projektor2_View_HTML_Tag_Fieldset();
        $fieldsetTrvale->setAttributes($fieldsetAttributes);
        $legendTrvale = new Projektor2_View_HTML_Tag_Legend();
        $fieldsetTrvale->addChild($legendTrvale->addHtmlPart('Trvalé bydliště')); 
        $paragraph = new Projektor2_View_HTML_Tag_P();        
        $paragraph->addChild(Projektor2_View_HTML_Tag_Helper_Input::textLabeled($this->context, 'dotaznik->mesto', 'Město: ', $readonly, 30))
                ->addChild(Projektor2_View_HTML_Tag_Helper_Input::textLabeled($this->context, 'dotaznik->ulice', 'Ulice: ', $readonly, 30))
                ->addChild(Projektor2_View_HTML_Tag_Helper_Input::textLabeled($this->context, 'dotaznik->psc', 'PSČ: ', $readonly, 6, 6));
        $fieldsetTrvale->addChild($paragraph); 
        $paragraph = new Projektor2_View_HTML_Tag_P();        
        $paragraph->addChild(Projektor2_View_HTML_Tag_Helper_Input::textLabeled($this->context, 'dotaznik->pevny_telefon', 'Pevný telefon: ', $readonly, 14, 14));
        $fieldsetTrvale->addChild($paragraph);         
        $fieldset->addChild($fieldsetTrvale);
        
        $fieldsetDojizdeni = new Projektor2_View_HTML_Tag_Fieldset();
        $fieldsetDojizdeni->setAttributes($fieldsetAttributes);
        $legendDojizdeni = new Projektor2_View_HTML_Tag_Legend();
        $fieldsetDojizdeni->addChild($legendDojizdeni->addHtmlPart('Adresa dojíždění odlišná od místa bydliště')); 
        $paragraph = new Projektor2_View_HTML_Tag_P();        
        $paragraph->addHtmlPart('Vyplňte pouze pokud se liší od místa trvalého bydliště.');
        $paragraph = new Projektor2_View_HTML_Tag_P();        
        $paragraph->addChild(Projektor2_View_HTML_Tag_Helper_Input::textLabeled($this->context, 'dotaznik->mesto2', 'Město: ', $readonly, 30))
                ->addChild(Projektor2_View_HTML_Tag_Helper_Input::textLabeled($this->context, 'dotaznik->ulice2', 'Ulice: ', $readonly, 30))
                ->addChild(Projektor2_View_HTML_Tag_Helper_Input::textLabeled($this->context, 'dotaznik->psc2', 'PSČ: ', $readonly, 6, 6));
        $fieldsetDojizdeni->addChild($paragraph); 
        $paragraph = new Projektor2_View_HTML_Tag_P();        
        $paragraph->addChild(Projektor2_View_HTML_Tag_Helper_Input::textLabeled($this->context, 'dotaznik->pevny_telefon2', 'Pevný telefon: ', $readonly, 14, 14));
        $fieldsetDojizdeni->addChild($paragraph);         
        $fieldset->addChild($fieldsetDojizdeni);
        
        $paragraph = new Projektor2_View_HTML_Tag_P();        
        $paragraph->addChild(Projektor2_View_HTML_Tag_Helper_Input::dateLabeled($this->context, 'dotaznik->mobilni_telefon', 'Mobilní telefon: ', $readonly, 14, 14))
                ->addChild(Projektor2_View_HTML_Tag_Helper_Input::textLabeled($this->context, 'dotaznik->dalsi_telefon', 'Další telefon: ', $readonly, 14, 14))
                ->addChild(Projektor2_View_HTML_Tag_Helper_Input::textLabeled($this->context, 'dotaznik->popis_telefon', 'Popis: ', $readonly, 50));
        $fieldset->addChild($paragraph);        
        $paragraph = new Projektor2_View_HTML_Tag_P();        
        $paragraph ->addChild(Projektor2_View_HTML_Tag_Helper_Input::textLabeled($this->context, 'dotaznik->mail', 'e-mail: ', $readonly, 50));
        $fieldset->addChild($paragraph);
        
        $this->parts[] = $fieldset;
        return $this;    }
}
