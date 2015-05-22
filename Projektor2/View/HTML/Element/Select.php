<?php
/**
 * Description of Projektor2_View_HTML_Element_Select
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Element_Select extends Framework_View_Abstract {
    
    /**
     * Metoda generuje html kód elementu select.
     * Parametry očekává jako prvky pole context.
     * 'selectId' string id atribut prvku select
     * 'selectName' string name atribut prvku select (jméno proměnné formuláře)
     * 'valuesArray' array pole návratových hodnot, jde o pole skalárů nebo objektů, slouží také pro generování jednotlivých elementů option
     * 'returnedObjectProperty' string jméno vlastnosti objektu použité pro návratovou hodnotu, pokud valuesArray je pole objektů
     * 'actualValue' string současná hodnota proměnné formuláře - slouží pro výběr příslušné option jako selected
     * 'innerTextCallable' callable je volán pro vygenerování zobrazovaných textů jednotlivých option vytvožených z položek valuesArray (např. array($this,'text_retezec_kurz'))
     * 'onChangeJsCode' string javascriptový kód volaný při změně hodnoty selectu (např, 'submitForm(this);' provede submit formuláře po ksždé změně hodnoty
     * 'readonly' mixed pokud je TRUE je select je pouze pro čtení
     * 'required' mixed pokud je TRUE je select required, toto je funkční jen návratová hodnota "nevybraného" selectu (tedy hodnota první option) je vyhodnocována jako FALSE (napž. pokud první option je prázdný řetězec)
     * @return \Projektor2_View_HTML_Element_Select HTML kód select
     */
    public function render() {
        $disabledAttribute = (isset($this->context['readonly']) AND $this->context['readonly']) ? ' disabled="disabled" ' : ' ';
        $requiredAttribute = (isset($this->context['required']) AND $this->context['required']) ? ' required="required" ' : ' ';
        $onChangeCode = (isset($this->context['onChangeJsCode']) AND $this->context['onChangeJsCode']) ? ' onChange="'.$this->context['onChangeJsCode'].'"':' ';
        $style = (isset($this->context['display']) AND $this->context['display']) ? 'style=display:'.$this->context['display']:' ';

        $this->parts[] = '<select '
                . 'id="'.$this->context['selectId'].'" '
                . 'size="1" '
                . 'name="'.$this->context['selectName'].'" '
                .$disabledAttribute
                .$requiredAttribute
                .$style
                .$onChangeCode
                . ' >';
        if ($this->context['valuesArray']) {
            foreach ($this->context['valuesArray'] as $value) {
                $this->parts[] = $this->optionCode($value);
            }
        }
        $this->parts[] = '</select>';
        return $this;
    }
    
    private function optionCode($value) {
        $option = '<option ';
        $contextValue = $this->context['actualValue'];
        if (is_object($value)) {
            $prop = $this->context['returnedObjectProperty'];
            $valueObjectProperty = $value->$prop;
            if (isset($contextValue) AND $contextValue == $valueObjectProperty) {
                $option .= 'selected="selected"';
            }
            $option .= ' value="'.$valueObjectProperty.'">'.call_user_func($this->context['innerTextCallable'], $value).'</option>'; 
        } else {
            if (isset($contextValue) AND $contextValue == $value) {
                $option .= 'selected="selected"';
            }
            if (isset($this->context['innerTextCallable'])) {
                $option .= ' value='.$value.'>'.call_user_func($this->context['innerTextCallable'], $value).'</option>';                 
            } else {
                $option .= ' value="'.$value.'">'.$value.'</option>';             
            }
        }
        return $option;
    }
}
