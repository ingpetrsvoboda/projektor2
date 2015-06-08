<?php
/**
 * Description of Chyby
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Tag_Label extends Projektor2_View_HTML_Tag {

    public function __construct(array $context=NULL, Projektor2_View_HTML_Tag_Attributes_Label $attributes=NULL) {
        parent::__construct($context);
        $this->setTag('label');
        $this->setAttributes($attributes);
    }    
}

?>
