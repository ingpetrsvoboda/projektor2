<?php
/**
 * Description of Chyby
 *
 * @author pes2704
 */
abstract class Projektor2_View_HTML_Tag_Attributes {
            
    public function __construct($attributesArray=array()) {
        foreach ($attributesArray as $name => $value) {
            $this->$name = $value;
        }
    }



    /**
     * Getter, vrací jen hodnoty existujících atributů.
     * @param type $name
     * @return type
     */
    public function __get($name) {
        if ($this->getIterator()->offsetExists($name)) {
            return $this->$name;
        }
    }
    
    /**
     * Setter, nastavuje jen hodnoty existujících atributů, nepřidává další atributy elementu. 
     * V případě, že $name neodpovídá existujícímu atributu elementu metoda jen tiše skončí.
     * @param type $name
     * @param type $value
     */
    public function __set($name, $value) {
        if ($this->getIterator()->offsetExists($name)) {
            $this->$name = $value;
        }
    }
    
    /**
     * Metoda vrací názvy atributů elementu v číselně indexovaném poli.
     * @return array
     */
    public function getNames() {
        return array_keys($this->getValuesAssoc());
    }

    /**
     * Metoda vrací hodnoty atributů elementu v číselně indexovaném poli.
     * @return array
     */    
    public function getValues() {
        return iterator_to_array($this->getIterator(), FALSE);
    }
    
    /**
     * Metoda vrací hodnoty a názvy atributů elementu jako asociativní pole.
     * @return array
     */    
    public function getValuesAssoc() {
        return iterator_to_array($this->getIterator(), TRUE);
    }
    
    /**
     * Metoda vrací hodnoty a názvy atributů elementu jako string ve tvaru vhodném pro vypsání html elementu.
     * Formát: Řetězec je složen z výrazů atribut="hodnota" oddělených mezerou. Hodnota ošetřena funkcí htmlspecialchars 
     * a je vždy uzavřena do uvozovek. Funkce htmlspecialchars neescapuje znak apostrof, hodnoty atributů nesmí obsahovat apostrofy, 
     * výskyt apostrofu způsobí chbnou syntaxi výsledného html.
     * @return string
     */    
    public function getAttributesString() {
        foreach (iterator_to_array($this->getIterator(), TRUE) as $key => $value) {
            if ($value) {
                $attr[] = $key.' = "'.htmlspecialchars(trim($value)).'"';
            }
        }
        if (isset($attr)) {
            return implode(' ', $attr);
        } else {
            return '';
        }
    }
    
    /**
     * Metoda vrací iterátor obsahující atributy elementu
     * @return \ArrayIterator
     */
    public function getIterator() {
        return new ArrayIterator(get_object_vars($this));  // vrací properties
    }
    
}

