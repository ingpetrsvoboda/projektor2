<?php
/**
 * Description of Projektor2_View_HTML_Element_Fieldset
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Tag_Fieldset extends Projektor2_View_HTML_Tag {    
    public function __construct(array $context=NULL, Projektor2_View_HTML_Tag_Attributes_Fieldset $attributes=NULL) {
        parent::__construct($context);
        $this->setTag('fieldset');
        $this->setAttributes($attributes);
    }
}

