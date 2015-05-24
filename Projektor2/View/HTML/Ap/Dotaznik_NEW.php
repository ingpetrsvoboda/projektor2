<?php
/**
 * Třída Projektor2_View_HTML_HeSmlouva zabaluje původní PHP4 kód do objektu. Funkčně se jedná o konponentu View, 
 * na základě dat předaných konstruktoru a šablony obsažené v metodě display() generuje HTML výstup
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Ap_Dotaznik extends Framework_View_Abstract {
    /**
     * Metoda obsahuje php kod (ve stylu PHP4), který užívá PHP jako šablonovací jazyk. Na základě dat zadaných v konstruktoru 
     * do paramentru $context metoda generuje přímo html výstup. Metoda nemá návratovou hodnotu.
     */
    public function render() {
        // hodnoty proměnných pro vytváření atributů při skládání tagů
//        if (isset($this->context['readonly']) AND $this->context['readonly']) {
//            // inputy jsou readonly nebo disabled, inputy pro datum jsou typu text (a readonly) a class fieldsetu pro css je "readonly"
//            $readonlyAttribute = TRUE;
//            $disabledAttribute = TRUE;
//            $dateInputType = 'text';
//            $fieldsetClass = 'readonly';
//        } else {
//            // inputy nejsou readonly ani disabled, inputy pro datum jsou typu date a class fieldsetu pro css není nastavena
//            $readonlyAttribute = ' ';
//            $disabledAttribute = ' ';
//            $dateInputType = 'date';  
//            $fieldsetClass = '';            
//        }
//        $checkedAttribute = ' checked="checked" ';
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

        $this->parts[] = '<form method="POST" action="index.php?akce=form&form=ap_reg_dot" name="dotaznik->form_dotaznik">';
        $fieldsetElement = new Projektor2_View_HTML_Element_Fieldset();
        $this->parts[] = $fieldsetElement->assign('attributes', array('class'=>$fieldsetClass));

        $fieldsetElement->addHtmlPart('<LEGEND style="color:white;"><b>Osobní údaje</b></LEGEND>');
        $inputAttributes = new Projektor2_View_HTML_Element_Attributes_Input(array('id'=>'dotaznik->titul', 'type'=>'text', 'name'=>'dotaznik->titul', 'size'=>'3', 'maxlength'=>'10', 'value'=>$this->context['dotaznik->titul']));
        $inputView = new Projektor2_View_HTML_Element_Input($this->context, $inputAttributes);
        $fieldsetElement->addChild($inputView->assign('label', 'Titul: ')->assign('readonly', $readonly));
        
        $inputAttributes = new Projektor2_View_HTML_Element_Attributes_Input(array('id'=>'dotaznik->jmeno', 'type'=>'text', 'name'=>'dotaznik->jmeno', 'size'=>'20', 'maxlength'=>'30', 'value'=>$this->context['dotaznik->jmeno']));
        $inputView = new Projektor2_View_HTML_Element_Input($this->context, $inputAttributes);
        $fieldsetElement->addChild($inputView->assign('label', 'Jméno: ')->assign('readonly', $readonly));

        $inputAttributes = new Projektor2_View_HTML_Element_Attributes_Input(array('id'=>'dotaznik->prijmeni', 'type'=>'text', 'name'=>'dotaznik->prijmeni', 'size'=>'20', 'maxlength'=>'30', 'value'=>$this->context['dotaznik->prijmeni']));
        $inputView = new Projektor2_View_HTML_Element_Input($this->context, $inputAttributes);
        $fieldsetElement->addChild($inputView->assign('label', 'Příjmení: ')->assign('readonly', $readonly));

        $inputAttributes = new Projektor2_View_HTML_Element_Attributes_Input(array('type'=>'submit', 'name'=>'B1', 'value'=>'Uložit'));
        $inputView = new Projektor2_View_HTML_Element_Input($this->context, $inputAttributes);
        $fieldsetElement->addChild($inputView->assign('readonly', $readonly));
        
        $inputAttributes = new Projektor2_View_HTML_Element_Attributes_Input(array('type'=>'reset', 'name'=>'B2', 'value'=>'Zruš provedené změny'));
        $inputView = new Projektor2_View_HTML_Element_Input($this->context, $inputAttributes);
        $fieldsetElement->addChild($inputView->assign('readonly', $readonly));
        
        if ($this->context['dotaznik->id_zajemce']){
            $inputAttributes = new Projektor2_View_HTML_Element_Attributes_Input(array('type'=>'submit', 'name'=>'pdf', 'value'=>'Tiskni dotazník'));
            $inputView = new Projektor2_View_HTML_Element_Input($this->context, $inputAttributes);
            $fieldsetElement->addChild($inputView->assign('readonly', $readonly));
        }

        $this->parts[] = '</form>';
        return $this;
    }
}